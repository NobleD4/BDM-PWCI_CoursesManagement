<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo "Por favor, inicia sesión para crear un nivel.";
        exit();
    }

    $data = json_decode(file_get_contents("php://input"), true);

    $id_course        = $_POST['NAME_INPUT_ID_COURSE'];
    $level_name       = $_POST['NAME_INPUT_LEVEL_NAME'];
    $level_price      = $_POST['NAME_INPUT_PRICE'];

    $sql = "CALL SP_LevelCourseManagement(
	3,          -- pSP_Action
    
    NULL,       -- pID_Level
    ?,          -- pID_Course
    ?,          -- pLevel_Name
    ?           -- pLevel_Price
    )";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $id_course, $level_name, $level_price);

    $response = ['success' => $stmt->execute()];
    echo json_encode($response);

    header("Location: ../perfilinstructor.php");
?>