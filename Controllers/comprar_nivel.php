<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo "Debes iniciar sesión para realizar esta acción.";
        exit();
    }

    $id_course = $_POST['NAME_INPUT_ID_COURSE'];

    $action = $_POST['action'];
    $id_user = $_POST['NAME_INPUT_ID_USER'];
    $id_level = $_POST['NAME_INPUT_ID_LEVEL'];
    $pay_method = $_POST['NAME_INPUT_PAY_METHOD'] ?? null;

    if ($action == 4) {
        // Comprar nivel
        $sql = "CALL SP_User_LevelCourseManagement (4, ?, ?, ?);";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $id_user, $id_level, $pay_method);
    } elseif ($action == 5) {
        // Empezar nivel
        $sql = "CALL SP_User_LevelCourseManagement (5, ?, ?, NULL);";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $id_user, $id_level);
    } elseif ($action == 6) {
        // Completar nivel
        $sql = "CALL SP_User_LevelCourseManagement (6, ?, ?, NULL);";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $id_user, $id_level);
    } else {
        echo "Acción no válida.";
        exit();
    }

    if ($stmt->execute()) {
        echo "Acción realizada exitosamente.";
        header("Location: ../curso.php?ID_Course=$id_course"); // Redirigir de vuelta al curso
    } else {
        echo "Error al añadir la categoría.";
    }
?>