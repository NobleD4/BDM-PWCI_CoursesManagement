<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo "Por favor, inicia sesión para ver categorías";
        exit();
    }

    $sql = "CALL `SP_User_CourseEnrollmentsManagement`(
        -1,     -- pSP_Action
        
        ?,      -- pID_User
        NULL,   -- pID_Course
        NULL    -- pUserRating
    );";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['ID_User']);
    $stmt->execute();

    $result = $stmt->get_result();
    
    $kardex = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $kardex[] = $row;
        }
    }

    echo json_encode($kardex);
?>