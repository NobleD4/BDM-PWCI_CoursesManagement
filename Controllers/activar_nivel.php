<?php
    include '../DB_Config.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID_Level'])) {
        $id_level = $_POST['ID_Level'];
        $id_course = $_POST['NAME_INPUT_ID_COURSE'];

        // Preparar la llamada al procedimiento almacenado
        $sql = "CALL SP_LevelCourseManagement(
            6,        -- pSP_Action
            ?,        -- pID_Level
            NULL,     -- pID_Course
            NULL,     -- pLevel_Name
            NULL      -- pLevel_Price
        );";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id_level);

        if ($stmt->execute()) {
            // Redireccionar de regreso al nivel con un mensaje de éxito
            header("Location: ../curso.php?ID_Course=$id_course&status=successful");
        } else {
            // Manejar errores
            header("Location: ../curso.php?ID_Course=$id_course&status=error");
        }

        $stmt->close();
        $conn->close();
    } else {
        // Si no hay un POST válido, redireccionar con un mensaje de error
        header("Location: ../curso.php?ID_Course=$id_course&status=error");
    }
?>