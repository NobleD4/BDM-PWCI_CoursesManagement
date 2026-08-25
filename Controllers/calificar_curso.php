<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo "Debes iniciar sesión para realizar esta acción.";
        exit();
    }

    $id_user = $_SESSION['ID_User'];
    $id_course = $_POST['NAME_INPUT_ID_COURSE'];
    $user_rating = $_POST['NAME_INPUT_USER_RATING'];

    $sql = "CALL SP_User_CourseEnrollmentsManagement(
        8,       -- pSP_Action
        ?,       -- pID_User
        ?,       -- pID_Course
        ?        -- pUserRating
    );";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $id_user, $id_course, $user_rating);

    if ($stmt->execute()) {
        echo "Acción realizada exitosamente.";
        header("Location: ../curso.php?ID_Course=$id_course");
    } else {
        echo "Error al calificar curso.";
    }
?>