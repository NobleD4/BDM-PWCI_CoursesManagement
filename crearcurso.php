<?php
  require_once './Controllers/authRole_middleware.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea tu curso</title>
    <link href="./output.css" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/crearcurso.css">
</head>
<body>
    <header>
        <h1>¡Crea tu curso!</h1>
        <div class="header-images">
            <div class="user">
                <img src="<?php echo isset($_SESSION['Profile_Picture']) ? 'data:image/jpeg;base64,' . base64_encode($_SESSION['Profile_Picture']) : 'https://i.pinimg.com/564x/cb/81/27/cb8127cba8860d645bbe0cfb07ef0759.jpg'; ?>"
                alt="Foto del usuario"
                id="profilePicture">    
            </div>
            <div class="home">
                <a href="principalinstructor.php"><img src="https://img.icons8.com/?size=100&id=2797&format=png&color=FFFFFF" alt="volvermenu"></a>
            </div>
        </div>
    </header>

    <main>
        <form id="courseForm" action="./Controllers/crear_curso.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre del curso:</label>
                <input type="text" id="nombre" name="NAME_INPUT_COURSENAME" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción del curso:</label>
                <textarea id="descripcion" name="NAME_INPUT_COURSE_DESCRIPTION" rows="4"></textarea>
            </div>

            <div class="form-group">
                <button id="triggerFileInput" type="button" class="btn">Cambiar Portada</button>
                <input type="file" id="fileInput" name="NAME_INPUT_COURSE_PICTURE" accept="image/*" style="display: none;">
            </div>

            <a href="#">
                <img id="previewImage" 
                src="https://via.placeholder.com/150x200" 
                alt="Previsualización" 
                style="max-width: 150; max-height: 200px; object-fit: cover;">
            </a>

            <br>
                
            <button type="submit" class="btn">Crear curso</button>
        </form>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const courseForm = document.getElementById('courseForm');
        // Referencias a los elementos
        const triggerFileInput = document.getElementById('triggerFileInput');
        const fileInput = document.getElementById('fileInput');
        const previewImage = document.getElementById('previewImage');

        // Evento para abrir el selector de archivos
        triggerFileInput.addEventListener('click', function() {
            fileInput.click(); // Abre el diálogo de selección de archivo
        });

        // Evento para mostrar la previsualización
        fileInput.addEventListener('change', function() {
            const file = fileInput.files[0]; // Obtiene el archivo seleccionado
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result; // Muestra la imagen seleccionada
                };
                reader.readAsDataURL(file); // Lee el archivo como URL de datos
            }
        });

        courseForm.addEventListener('submit', function(event) {
            alert('El curso ha sido creado exitosamente. No será visible al público hasta que se le agreguen niveles.');
        });
    });
    </script>

</body>
</html>
