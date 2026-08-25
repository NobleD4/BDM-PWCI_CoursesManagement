<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo "Por favor, inicia sesión para ver categorías";
        exit();
    }

    $sql = "CALL SP_CategoryManagement(-1, NULL, NULL, NULL, NULL)";
    $result = $conn->query($sql);

    $categories = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }

    echo json_encode($categories);
?>