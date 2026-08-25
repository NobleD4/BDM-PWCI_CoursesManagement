<?php
    session_start();
    include '../DB_Config.php';

    if (!isset($_SESSION['ID_User'])) {
        echo "Debes iniciar sesión para realizar esta acción.";
        exit();
    }

    $id_user = $_SESSION['ID_User'];
    $id_course = $_POST['NAME_INPUT_ID_COURSE'];
    $comment_text = $_POST['NAME_INPUT_COMMENT_TEXT'];

    $sql = "CALL SP_Course_Comments(
        4,          -- pSP_Action
        NULL,       -- pID_Comment
        ?,          -- pID_User
        ?,          -- pID_Course
        ?           -- pComment_Text
    );";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $id_user, $id_course, $comment_text);

    if ($stmt->execute()) {
        echo "Acción realizada exitosamente.";
        header("Location: ../curso.php?ID_Course=$id_course");
    } else {
        echo "Error al crear comentario.";
    }
?>