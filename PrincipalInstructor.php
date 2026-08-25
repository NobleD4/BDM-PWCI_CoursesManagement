<?php
  require_once './Controllers/authRole_middleware.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal Instructor</title>
    <link rel="stylesheet" href="./CSS/principalinstructor.css">

    <!-- Font Awesome Solid + Brands -->
    <link href="./fontawesome-free-v6.6.0/css/brands.css" rel="stylesheet" type="text/css">
    <link href="./fontawesome-free-v6.6.0/css/solid.css" rel="stylesheet" type="text/css">
    <link href="./fontawesome-free-v6.6.0/css/fontawesome.css" rel="stylesheet" type="text/css">
</head>
<body>

    <?php include './Components/headerInstructor.php';?>

    <!-- Sección de Descuentos -->
    <section class="discount-section">
        <div class="discount-content">
            <h1>Bienvenido a EduCASA</h1>
            <p>¡Aprende, repasa y adentrate más al íncreible mundo de la programación!</p>
        </div>
    </section>

    <!-- Sección de Selección de Cursos -->
    <section class="courses-section">
        <h2>Te encuentras en el perfil de instructor</h2>
        <p>¿Listo para educar y transformar mentes?</p>
        <div class="course-highlight">
            <h3>¿Quieres crear tu propio curso?</h3>
            <p>¿No encontraste cursos de lo que necesitabas?¿Eres experto o dominas un tema que quieres compartir con el mundo? ¡Crea tu curso ahora!</p>
            <a href="crearcurso.php"><button>Crea tu propio curso</button></a>
        </div>

    </section>

    <!-- Sección de Convertirse en Instructor -->
    <section class="instructor-section">
        <div class="instructor-content">
            <img src="https://i.pinimg.com/736x/00/f7/e8/00f7e8f546445af302fa33ba4d249b29.jpg" alt="Instructor">
            <div class="instructor-text">
                <h2>Ve a tu perfil</h2>
                <a href="perfilinstructor.php"><button>A mi perfil</button></a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
    </footer>
    <script src="./JS/script.js"></script>
</body>
</html>