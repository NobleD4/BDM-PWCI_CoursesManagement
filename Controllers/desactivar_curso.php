<?php
    include '../DB_Config.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ID_Course'])) {
        $id_course = $_POST['ID_Course'];

        // Preparar la llamada al procedimiento almacenado
        $sql = "CALL `SP_CourseManagement`(
            5,      -- pSP_Action
            
            ?,      -- pID_Course
            NULL,   -- PID_User
            NULL,   -- pCourse_Picture
            NULL,   -- pCourse_Name
            NULL    -- pCourse_Description
        );";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id_course);

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