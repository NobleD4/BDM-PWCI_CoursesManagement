<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo "Por favor, inicia sesión para ver los reportes";
        exit();
    }

    $sql_StudentReport = "CALL `SP_UserManagement`(
    -2,     -- pSP_Action
    
    NULL,   -- pID_User
    NULL,   -- pUser_Role
    NULL,   -- pProfile_Picture
    NULL,   -- pUser_Birthdate
    NULL,   -- pUser_Gender
    NULL,   -- pUser_Name
    NULL,   -- pUser_LastName
    NULL,   -- pUser_SecondLastName
    NULL,   -- pUser_email
    NULL,   -- pUser_CurrentPassword
    
    NULL,   -- pUser_NewPassword

    @ResultCode
    );";
    $stmt_StudentReport = $conn->prepare($sql_StudentReport);
    $stmt_StudentReport->execute();

    $result_StudentReport = $stmt_StudentReport->get_result();
    
    $Students = [];
    if ($result_StudentReport) {
        while ($row_StudentReport = $result_StudentReport->fetch_assoc()) {
            $Students[] = $row_StudentReport;
        }
    }

    echo json_encode($Students);
?>