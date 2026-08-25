<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo "Por favor, inicia sesión para actualizar tu perfil.";
        exit();
    }

    $id_usuario = $_SESSION['ID_User'];
    $nombre = $_POST['name'];
    $apellido_paterno = $_POST['lastname'];
    $apellido_materno = $_POST['secondlastname'];
    $fecha_nacimiento = $_POST['fechanac'];
    $correo = $_POST['email'];

    // Inicializa la variable para la foto de perfil
    $profile_picture = NULL;

    // Verifica si se subió un archivo
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == UPLOAD_ERR_OK) {
        // Convierte el archivo en binario
        $profile_picture = file_get_contents($_FILES['profilePicture']['tmp_name']);    
    }
    // Prepara la consulta
    $sql = "CALL SP_UserManagement(
        3,      -- pSP_Action
        ?,      -- pID_User
        NULL,   -- pUser_Role
        ?,      -- pProfile_Picture
        ?,      -- pUser_Birthdate
        0,      -- pUser_Gender
        ?,      -- pUser_Name
        ?,      -- pUser_LastName
        ?,      -- pUser_SecondLastName
        ?,      -- pUser_email
        NULL,   -- pUser_CurrentPassword
        NULL,   -- pUser_NewPassword
        @ResultCode
    );";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $id_usuario, $profile_picture, $fecha_nacimiento, $nombre, $apellido_paterno, $apellido_materno, $correo);

    if ($stmt->execute()) {
        // Actualiza la sesión con los nuevos datos
        $_SESSION['User_Name'] = $nombre;
        $_SESSION['User_LastName'] = $apellido_paterno;
        $_SESSION['User_SecondLastName'] = $apellido_materno;
        $_SESSION['User_Birthdate'] = $fecha_nacimiento;
        $_SESSION['User_email'] = $correo;
        $_SESSION['Profile_Picture'] = $profile_picture;

        $_SESSION['mensaje'] = "Perfil actualizado correctamente.";

        if ($_SESSION['User_Role'] == 1) {
            header("Location: ../perfil.php");
        }

        elseif ($_SESSION['User_Role'] == 2) {
            header("Location: ../perfilinstructor.php");
        }

        elseif ($_SESSION['User_Role'] == 3) {
            header("Location: ../perfiladmin.php");
        }
    }
    else {
        $_SESSION['mensaje'] = "Error al actualizar el perfil.";
        header("Location: ../perfil.php");
    }

    $stmt->close();
    $conn->close();
?>