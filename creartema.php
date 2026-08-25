<?php
  require_once './Controllers/authRole_middleware.php';
?>

<?php
if (isset($_GET['ID_Course'])) {
    $id_course = $_GET['ID_Course'];
} else {
    echo "No se ha proporcionado un ID de curso.";
}
?>

<?php
include 'DB_Config.php';

$sql = "CALL SP_CourseManagement(
-1,      -- IN pSP_Action
    
?,      -- IN pID_Course
NULL,   -- IN PID_User
NULL,   -- IN pCourse_Picture
NULL,   -- IN pCourse_Name
NULL    -- IN pCourse_Description
)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_course);
$stmt->execute();
$result = $stmt->get_result();

// Verifica si el curso existe
if ($result->num_rows > 0) {
$course = $result->fetch_assoc();
} else {
die("Curso no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear tema</title>
    <link href="./output.css" rel="stylesheet">
    <link rel="stylesheet" href="./CSS/crearcurso.css">
</head>
    <body>
        <header>
            <h1>¡Crea un tema nuevo!</h1>
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
            <form id="CREAR_NIVEL" action="./Controllers/crear_nivel.php" method="POST">
                <input type="hidden" id="hiddenInput" name="NAME_INPUT_ID_COURSE" value="<?php echo ($course['ID_Course']); ?>">

                <div class="form-group">
                    <label for="nombre">Nombre del Nivel:</label>
                    <input type="text" id="nombre" name="NAME_INPUT_LEVEL_NAME" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label for="precio">Precio del Nivel $MXN:</label>
                    <input type="number" id="precio" name="NAME_INPUT_PRICE" min="1" max="9999" value="1" required>
                    <div class="checkbox-group">
                        <input type="checkbox" id="gratis" name="precio_gratis" value="gratis">
                        <label for="gratis" class="checkbox-label">Nivel gratuito</label>
                    </div>
                </div>

                <button type="submit" class="btn">Crear Nivel nuevo</button>
            </form>
        </main>

        <script>
        // Referencias a los elementos
        const precioInput = document.getElementById('precio');
        const gratisCheckbox = document.getElementById('gratis');

        // Evento cuando se cambia el estado del checkbox
        gratisCheckbox.addEventListener('change', function () {
            if (this.checked) {
                // Deshabilita el input y establece el valor en 0
                precioInput.min = 0;
                precioInput.value = 0;
                precioInput.readOnly = true;
            } else {
                // Habilita el input para que sea interactivo
                precioInput.min = 1;
                precioInput.readOnly = false;
            }
        });

        CREAR_NIVEL.addEventListener('submit', function(event) {
            alert('El nivel se ha registrado correctamente. No estará activo hasta que no se le asigne un video.');
        });
        </script>
    </body>
</html>