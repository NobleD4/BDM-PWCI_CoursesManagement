<?php
  require_once './Controllers/authRole_middleware.php';
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Administrador</title>
    <link rel="stylesheet" href="./CSS/perfiladmin.css">
  </head>
  <body>
    <header>
      <div class="user-header">
        <a href="#" class="user-dropdown-toggle">
          <img src="<?php echo isset($_SESSION['Profile_Picture']) ? 'data:image/jpeg;base64,' . base64_encode($_SESSION['Profile_Picture']) : 'https://i.pinimg.com/564x/cb/81/27/cb8127cba8860d645bbe0cfb07ef0759.jpg'; ?>"
          alt="Foto del usuario"
          id="profilePicture">
        </a>
      </div>
      <div class="home">
        <a href="./principaladmin.php"><img src="https://img.icons8.com/?size=100&id=2797&format=png&color=FFFFFF" alt="volvermenu"></a>
    </div>
    </header>

    <!-- Sidebar -->
    <div class="sidebar">
      <a href="#" class="sidebar-link" onclick="openWindow('window1')">Ventana 1</a>  <!-- ??? -->
      <a href="#" class="sidebar-link" onclick="openWindow('window2')">Tu Info</a>
      <a href="#" class="sidebar-link" onclick="openWindow('window3')">Reporte de Instructores</a>
      <a href="#" class="sidebar-link" onclick="openWindow('window5')">Reporte de estudiantes</a>
      <a href="#" class="sidebar-link" onclick="openWindow('window4')">Categorias</a>
    </div>

    <!-- Contenido de las ventanas -->
    <div class="content">
      <!-- window1 -->
      <div id="window1" class="window active">
        <h1>¡Bienvenid@ a tu perfil!</h1>
      </div>

      <!-- window2 -->
      <div id="window2" class="window">
        <div class="form-container" style="display: none;">
          <h2>Tu información</h2>
          <?php include './Components/datosPerfilUsuario.php';?>
        </div>
      </div>

      <!-- window3 -->
      <?php include './Components/VentanaReporteInstructores.php';?>

      <!-- window4 -->
      <?php include './Components/CrearNuevaCategoría.php';?>

      <!-- window5 -->
      <?php include './Components/VentanaReporteEstudiantes.php';?>

      <!--Estas no sirven de nada pero por alguna razon crashea si las quito D:-->
      <!-- window7 -->
      <div id="window7" class="window">
      </div>
      <!-- window8 -->
      <div id="window8" class="window">
      </div>
    </div>
    <script src="./JS/scriptperfiladmin.js"></script>
  </body>
</html>