<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo json_encode(["error" => "No estás autenticado"]);
        exit();
    }

    $id_course = $_GET['ID_Course'] ?? null;

    if (!$id_course) {
        echo json_encode(["error" => "ID_Course no proporcionado"]);
        exit();
    }

    $sql = "CALL SP_Course_CategoryManagement(1, ?, NULL)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_course);
    $stmt->execute();

    $result = $stmt->get_result();
    $categories = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }

    echo json_encode($categories);
?>
