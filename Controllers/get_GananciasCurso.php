<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo "Por favor, inicia sesión para ver las ganancias";
        exit();
    }

    $id_course = $_GET['ID_Course'];

    $sql_CourseRevenues = "CALL `SP_CourseManagement`(
        -7,     -- pSP_Action
        
        ?,      -- pID_Course
        NULL,   -- pID_User
        NULL,   -- pCourse_Picture
        NULL,   -- pCourse_Name
        NULL    -- pCourse_Description
    );";
    $stmt_CourseRevenues = $conn->prepare($sql_CourseRevenues);
    $stmt_CourseRevenues->bind_param("s", $id_course);
    $stmt_CourseRevenues->execute();

    $result_CourseRevenues = $stmt_CourseRevenues->get_result();
    
    $CourseRevenues = [];
    if ($result_CourseRevenues) {
        while ($row_CourseRevenues = $result_CourseRevenues->fetch_assoc()) {
            $CourseRevenues[] = $row_CourseRevenues;
        }
    }

    echo json_encode($CourseRevenues);
?>