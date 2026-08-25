<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo "Por favor, inicia sesión para actualizar tu perfil.";
        exit();
    }

    $data = json_decode(file_get_contents("php://input"), true);

    $id_user            = $_SESSION['ID_User'];
    $category_name      = $_POST['NAME_INPUT_NEW_CATEGORY'];
    $description        = $_POST['NAME_TEXTARE_NEW_CATEGORY_DESCRIPTION'];

    $sql = "CALL SP_CategoryManagement(
    2,      -- pSP_Action
    NULL,   -- pID_Category
    ?,      -- pID_User
    ?,      -- pCategory_Name
    ?       -- pCategory_Description
    )";


    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $id_user, $category_name, $description);

    $response = ['success' => $stmt->execute()];
    echo json_encode($response);

    header("Location: ../perfiladmin.php");
?>
