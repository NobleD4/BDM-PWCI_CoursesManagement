<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo "Por favor, inicia sesión para actualizar tu perfil.";
        exit();
    }

    $data = json_decode(file_get_contents("php://input"), true);

    $id_user            = $_SESSION['ID_User'];
    $course_picture    = NULL;
    $course_name        = $_POST['NAME_INPUT_COURSENAME'];
    $description        = $_POST['NAME_INPUT_COURSE_DESCRIPTION'];

    // Verifica si se subió un archivo
    if (isset($_FILES['NAME_INPUT_COURSE_PICTURE']) && $_FILES['NAME_INPUT_COURSE_PICTURE']['error'] == UPLOAD_ERR_OK) {
        // Convierte el archivo en binario
        $course_picture = file_get_contents($_FILES['NAME_INPUT_COURSE_PICTURE']['tmp_name']);    
    }

    $sql = "CALL SP_CourseManagement(
    2,          -- pSP_Action
	NULL,       -- pID_Course
    ?,          -- PID_User
    ?,          -- pCourse_Picture
    ?,          -- pCourse_Name
    ?          -- pCourse_Description
    )";


    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $id_user, $course_picture, $course_name, $description);

    $response = ['success' => $stmt->execute()];
    echo json_encode($response);

    header("Location: ../perfilinstructor.php");
?>