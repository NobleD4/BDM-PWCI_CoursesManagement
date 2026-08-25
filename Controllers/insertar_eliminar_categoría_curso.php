<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo "Debes iniciar sesión para realizar esta acción.";
        exit();
    }

    $action = $_POST['action']; // Acción enviada (4 o 5)
    $id_course = $_POST['ID_Course'] ?? null;
    $id_category = $_POST['ID_Category'] ?? null;

    if (!$id_course || !$id_category) {
        echo "ID_Course o ID_Category faltante.";
        exit();
    }

    if ($action == 4) {
        // Añadir categoría
        $sql = "CALL SP_Course_CategoryManagement(4, ?, ?)";
    } elseif ($action == 5) {
        // Eliminar categoría
        $sql = "CALL SP_Course_CategoryManagement(5, ?, ?)";
    } else {
        echo "Acción no válida.";
        exit();
    }
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $id_course, $id_category);

    if ($stmt->execute()) {
        echo "Categoría añadida exitosamente.";
        header("Location: ../curso.php?ID_Course=$id_course"); // Redirigir de vuelta al curso
    } else {
        echo "Error al añadir la categoría.";
    }
?>  
