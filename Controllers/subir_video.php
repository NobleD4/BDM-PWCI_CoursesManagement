<?php
    session_start();
    include '../DB_Config.php';

    // Datos del formulario
    $id_level = $_POST['ID_Level'];
    $id_course = $_POST['NAME_INPUT_ID_COURSE'];
    $resource_type = $_POST['resource_type'];
    $upload_dir = "Media/" . $_SESSION['ID_User'] . "/$id_course" . "/$id_level/";

    // Crear el directorio si no existe
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (isset($_FILES['resource_file']) && $_FILES['resource_file']['error'] === UPLOAD_ERR_OK) {
        $original_name = pathinfo($_FILES['resource_file']['name'], PATHINFO_FILENAME); // Nombre sin extensión
        $extension = pathinfo($_FILES['resource_file']['name'], PATHINFO_EXTENSION);   // Extensión del archivo

        // Generar un nombre único
        $unique_name = $original_name . "_" . uniqid() . "." . $extension;
        $file_path = $upload_dir . $unique_name;

        // Mueve el archivo al servidor con el nombre único
        if (move_uploaded_file($_FILES['resource_file']['tmp_name'], $file_path)) {
            // Inserta en la base de datos
            $stmt = $conn->prepare("CALL SP_LevelResourcesManagement(
            4,    -- pSP_Action
                
            NULL,    -- pID_Course
            ?,    -- pID_Level
            NULL,    -- pID_Resource
            ?,    -- pResource_Name
            ?,    -- pResource_Type
            ?     -- pResource_Path
            )");
            $stmt->bind_param("ssis", $id_level, $unique_name, $resource_type, $file_path);
            
            if ($stmt->execute()) {
                echo "Recurso registrado correctamente.";
                header("Location: ../curso.php?ID_Course=$id_course");
                exit;
            }

        } else {
            echo "Error al subir el archivo.";
        }
    } else {
        echo "No se seleccionó ningún archivo.";
    }
?>
