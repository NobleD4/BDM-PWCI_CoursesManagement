<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo "Por favor, inicia sesión para editar una categoría.";
        exit();
    }

    // Obtener datos enviados por POST
    $id_categoria = $_POST['NAME_INPUT_EDIT_CATEGORY'];
    $id_usuario = $_SESSION['ID_User'];
    $category_name = $_POST['NAME_INPUT_EDIT_CATEGORY_NAME'];
    $description = $_POST['NAME_INPUT_EDIT_CATEGORY_DESCRIPTION'];

    // Procedimiento almacenado para editar la categoría
    $sql = "CALL SP_CategoryManagement(
    3,      -- pSP_Action
    ?,      -- pID_Category
    ?,      -- pID_User
    ?,      -- pCategory_Name
    ?       -- pCategory_Description
    )";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $id_categoria, $id_usuario, $category_name, $description);

    $response = ['success' => $stmt->execute()];
    echo json_encode($response);

    header("Location: ../perfiladmin.php");
?>