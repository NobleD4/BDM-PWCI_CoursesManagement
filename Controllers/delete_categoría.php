<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo "Por favor, inicia sesión para eliminar una categoría.";
        exit();
    }

    // Obtener el ID de la categoría a eliminar
    $id_categoria = $_POST['NAME_INPUT_DELETE_CATEGORY'];

    // Procedimiento almacenado para eliminar la categoría
    $sql = "CALL SP_CategoryManagement(
    4,      -- pSP_Action
    ?,      -- pID_Category
    NULL,   -- pID_User
    NULL,   -- pCategory_Name
    NULL    -- pCategory_Description
    )";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_categoria);

    $response = ['success' => $stmt->execute()];
    echo json_encode($response);

    header("Location: ../perfiladmin.php");
?>