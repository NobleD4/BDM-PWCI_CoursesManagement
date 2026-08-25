<?php
  require_once './Controllers/authRole_middleware.php';
?>

<?php
    include './DB_Config.php';
    
    $stmt_bestselling = $conn->prepare("CALL SP_CourseManagement(-3, NULL, NULL, NULL, NULL, NULL);");
    $stmt_bestselling->execute();
    $result_bestselling = $stmt_bestselling->get_result();
?>
<?php
    include './DB_Config.php';

    $stmt_toprated = $conn->prepare("CALL SP_CourseManagement(-4, NULL, NULL, NULL, NULL, NULL);");
    $stmt_toprated->execute();
    $result_toprated = $stmt_toprated->get_result();
?>
<?php
    include './DB_Config.php';

    $stmt_recent = $conn->prepare("CALL SP_CourseManagement(-5, NULL, NULL, NULL, NULL, NULL);");
    $stmt_recent->execute();
    $result_recent = $stmt_recent->get_result();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Página Principal</title>
        <link rel="stylesheet" href="./CSS/principal.css">
    </head>
    <body>

        <?php include './Components/headerEstudiante.php';?>

        <!-- Sección de Descuentos -->
        <section class="discount-section">
            <div class="discount-content">
                <h1>Bienvenido a EduCASA</h1>
                <p>¡Aprende, repasa y adentrate más al íncreible mundo de la programación!</p>
            </div>
        </section>

        <!-- Sección de Selección de Cursos -->
        <section class="courses-section">
            <h2>Te encuentras en el perfil estudiantil</h2>
            <p>Elige entre más de 250 000 cursos de vídeo en línea con nuevo contenido cada mes... Bueno, hasta ahora son solo 3, ¡pero habrá más!</p>

            <div class="course-highlight">
                <h3>¿Quieres crear tu propio curso?</h3>
                <p>¿No encontraste cursos de lo que necesitabas?¿Eres experto o dominas un tema que quieres compartir con el mundo? ¡Crea tu curso ahora!</p>
                <a href="#"><button>Conviertete en instructor</button></a>
            </div>

            <!-- Carrusel de Cursos -->
            <h2>Los Más Vendidos</h2>
            <div class="gallery-container">
                <?php while ($course = $result_bestselling->fetch_assoc()) : ?>
                <?php include './Components/TarjetaCurso.php'; ?>
                <?php endwhile; ?>
            </div>
            <h2>Los Mejor Calificados</h2>
            <div class="gallery-container">
                <?php while ($course = $result_toprated->fetch_assoc()) : ?>
                <?php include './Components/TarjetaCurso.php'; ?>
                <?php endwhile; ?>
            </div>
            <h2>Los Más Recientes</h2>
            <div class="gallery-container">
                <?php while ($course = $result_recent->fetch_assoc()) : ?>
                <?php include './Components/TarjetaCurso.php'; ?>
                <?php endwhile; ?>
            </div>
        </section>

        <!-- Sección de Convertirse en Instructor -->
        <section class="instructor-section">
            <div class="instructor-content">
                <img src="https://i.pinimg.com/736x/00/f7/e8/00f7e8f546445af302fa33ba4d249b29.jpg" alt="Instructor">
                <div class="instructor-text">
                    <h2>¿Quieres convertirte en instructor?</h2>
                    <p>¡Ayudanos a combatir la ignorancia con el poder del conocimiento!</p>
                    <a href="#"><button>¡Quiero ser instructor!</button></a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">

        </footer>
        <script src="./JS/script.js"></script>
    </body>
</html>

