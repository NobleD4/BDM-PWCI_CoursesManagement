<?php
session_start();

include '../DB_Config.php';

if (isset($_POST['NAME_INPUT_EMAIL']) && isset($_POST['NAME_INPUT_PASSWORD']) && isset($_POST['NAME_USER_ROLE'])) {
    
    $User_email             = $_POST['NAME_INPUT_EMAIL'];
    $User_CurrentPassword   = $_POST['NAME_INPUT_PASSWORD'];
    $User_Role              = $_POST['NAME_USER_ROLE'];

    $stmt = $conn->prepare("CALL SP_UserManagement(
    1,      -- pSP_Action
    
    NULL,   -- pID_User
    ?,      -- pUser_Role
    NULL,   -- pProfile_Picture
    NULL,   -- pUser_Birthdate
    NULL,   -- pUser_Gender
    NULL,   -- pUser_Name
    NULL,   -- pUser_LastName
    NULL,   -- pUser_SecondLastName
    ?,      -- pUser_email
    ?,      -- pUser_CurrentPassword
    
    NULL,   -- pUser_NewPassword

    @ResultCode
    )");
    $stmt->bind_param("sss", $User_Role, $User_email, $User_CurrentPassword);

    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $_SESSION['ID_User']             = $fila['ID_User'];
        $_SESSION['User_Role']           = $fila['User_Role'];
        $_SESSION['Profile_Picture']     = $fila['Profile_Picture'];
        $_SESSION['User_Birthdate']      = $fila['User_Birthdate'];
        $_SESSION['User_Name']           = $fila['User_Name'];
        $_SESSION['User_LastName']       = $fila['User_LastName'];
        $_SESSION['User_SecondLastName'] = $fila['User_SecondLastName'];
        $_SESSION['User_email']          = $fila['User_email'];
        echo "Inicio de sesión exitoso";

        if ($_SESSION['User_Role'] == 1) {
            header("Location: ../Principal.php");
        }

        elseif ($_SESSION['User_Role'] == 2) {
            header("Location: ../PrincipalInstructor.php");
        }

        elseif ($_SESSION['User_Role'] == 3) {
            header("Location: ../PrincipalAdmin.php");
        }
    }
    else {
        echo "Credenciales incorrectas.";
    }
}
?>