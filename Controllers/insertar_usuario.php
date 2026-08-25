<?php
session_start();

include '../DB_Config.php';

if (isset($_POST['NAME_INPUT_EMAIL']) && isset($_POST['NAME_INPUT_PASSWORD'])) {

    $nombre                 = $_POST['NAME_INPUT'];
    $apellido_paterno       = $_POST['NAME_INPUT_LASTNAME'];
    $apellido_materno       = $_POST['NAME_INPUT_SECONDLASTNAME'];
    $fecha_nacimiento       = $_POST['NAME_INPUT_BIRTHDATE'];
    $correo                 = $_POST['NAME_INPUT_EMAIL'];
    $contraseña             = $_POST['NAME_INPUT_PASSWORD'];
    $genero                 = $_POST['NAME_USER_GENDER'];
    $rol                    = $_POST['NAME_USER_ROLE'];
    
    if ($_POST['NAME_INPUT_PASSWORD'] != $_POST['NAME_INPUT_CONFIRMPASSWORD']) {
        $_SESSION['error'] = "Las contraseñas no coinciden";
        header("Location: ../register.php");
        exit();
    }

    $stmt = $conn->prepare("CALL SP_UserManagement(
	2,		-- pSP_Action

	NULL,	-- pID_User
	?,		-- pUser_Role
	NULL,	-- pProfile_Picture
	?,      -- pUser_Birthdate
	?,		-- pUser_Gender
	?,      -- pUser_Name
	?,      -- pUser_LastName
	?,      -- pUser_SecondLastName
	?,      -- pUser_email
	?,       -- pUser_CurrentPassword

    NULL,    -- pUser_NewPassword

    @ResultCode
    )");
    $stmt->bind_param("isisssss", $rol, $fecha_nacimiento, $genero, $nombre, $apellido_paterno, $apellido_materno, $correo, $contraseña);

    if ($stmt->execute()) {
        $result = $conn->query("SELECT @ResultCode AS ResultCode");
        $row = $result->fetch_assoc();
        $resultCode = $row['ResultCode'];

        if ($resultCode == 0) { // Verifica el valor de ResultCode
            $_SESSION['mensaje'] = "Usuario registrado correctamente.";
            header("Location: ../index.php");
            exit();
        }
        elseif ($resultCode == 1) { // Verifica el valor de ResultCode
            $_SESSION['mensaje'] = "No puedes usar el mismo correo para el mismo rol.";
            header("Location: ../register.php");
            exit();
        }
        else {
            $_SESSION['error'] = "Error al registrar usuario: código $resultCode.";
            header("Location: ../register.php");
            exit();
        }
    }
    else {
        $_SESSION['mensaje'] = "Excepción en la base de datos: " . $stmt->error;
        header("Location: ../register.php");
        exit();
    }
}
?>