<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo "Por favor, inicia sesión para ver los reportes";
        exit();
    }

    $sql_InstructorReport = "CALL `SP_UserManagement`(
    -3,     -- pSP_Action
    
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
    $stmt_InstructorReport = $conn->prepare($sql_InstructorReport);
    $stmt_InstructorReport->execute();

    $result_InstructorReport = $stmt_InstructorReport->get_result();
    
    $Instructors = [];
    if ($result_InstructorReport) {
        while ($row_InstructorReport = $result_InstructorReport->fetch_assoc()) {
            $Instructors[] = $row_InstructorReport;
        }
    }

    echo json_encode($Instructors);
?>