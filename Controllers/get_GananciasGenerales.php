<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo "Por favor, inicia sesión para ver las ganancias";
        exit();
    }

    $sql = "CALL `SP_CourseManagement`(
        -6,     -- pSP_Action
        
        NULL,   -- pID_Course
        ?,      -- pID_User
        NULL,   -- pCourse_Picture
        NULL,   -- pCourse_Name
        NULL    -- pCourse_Description
    );";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['ID_User']);
    $stmt->execute();

    $result = $stmt->get_result();
    
    $Revenues = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $Revenues[] = $row;
        }
    }

    echo json_encode($Revenues);
?>