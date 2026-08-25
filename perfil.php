<?php
  require_once './Controllers/authRole_middleware.php';
?>

<?php
  include './DB_Config.php';

  $id_user = $_SESSION['ID_User'];

  $sql = "CALL SP_User_CourseEnrollmentsManagement(   -- Todos los cursos inscritos por un estudiante
	  1,      -- pSP_Action
    
    ?,      -- pID_User
    NULL,   -- pID_Course
    NULL    -- pUserRating
);";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id_user);
  $stmt->execute();
  $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil Usuario</title>
  <link rel="stylesheet" href="./CSS/perfil.css">
</head>
<body>
  <header>
    <div class="shoppingcart"><a href="carrito.html"><img src="https://img.icons8.com/?size=100&id=59997&format=png&color=FFFFFF" alt="Carrito"></div></a>
    <div class="user">
      <a href="#" class="user-dropdown-toggle">
        <img src="<?php echo isset($_SESSION['Profile_Picture']) ? 'data:image/jpeg;base64,' . base64_encode($_SESSION['Profile_Picture']) : 'https://i.pinimg.com/564x/cb/81/27/cb8127cba8860d645bbe0cfb07ef0759.jpg'; ?>"
        alt="Foto del usuario"
        id="profilePicture">
      </a>
    </div>
    <div class="home">
      <a href="principal.php"><img src="https://img.icons8.com/?size=100&id=2797&format=png&color=FFFFFF" alt="volvermenu"></a>
  </div>
  </header>

  <!-- Sidebar -->
  <div class="sidebar">
    <a href="#" class="sidebar-link" onclick="openWindow('window1')">Ventana 1</a>
    <a href="#" class="sidebar-link" onclick="openWindow('window2')">Tu Info</a>
    <a href="#" class="sidebar-link" onclick="openWindow('window3')">Cursos</a>
    <a href="#" class="sidebar-link" onclick="openWindow('window4')">Mensajes</a>
    <a href="#" class="sidebar-link" onclick="openWindow('window5')">Certificados</a>
    <a href="#" class="sidebar-link" onclick="openWindow('window9')">Kardex</a>
  </div>

  <!-- Contenido de las ventanas -->
  <div class="content">

    <div id="window1" class="window active">
      <h1>¡Bienvenid@ a tu perfil!</h1>
    </div>

    <div id="window2" class="window">
      <div class="form-container" style="display: none;">
        <h2>Tu información</h2>
        <?php include './Components/datosPerfilUsuario.php';?>
      </div>
    </div>
    

    <div id="window3" class="window">
      <h1 class="cursos-title">Cursos Inscritos</h1>
      <div class="gallery-container">
        <?php
          while ($course = $result->fetch_assoc()) {
            include './Components/TarjetaCurso.php';
          }
        ?>
        
        <div class="clearfix"></div>
      </div>
    </div>

    <div id="window4" class="window">
      <div class="container">
        <div class="header">
          <h1>Chat Privado</h1>
          <img src="https://i.pinimg.com/564x/cb/81/27/cb8127cba8860d645bbe0cfb07ef0759.jpg" alt="Foto del usuario">
        </div>

        <div class="body">
          <p class="message">¡Hola!¿En qué puedo servirte?</p>
          <p class="message user_message">¡Hola!</p>
        </div>

        <div class="footer">
          <form>
            <input type="text" name="">
            <button>Enviar</button>
          </form>
        </div>
      </div>
    </div>

    <div id="window5" class="window">
      <div class="custom-select-imagenes">
        <div class="select-imagenes-selected">Certificado 1</div>
        <div class="select-imagenes-items">
           <img src="https://i.pinimg.com/736x/32/ab/74/32ab7454c0065d06dfb078ea37ceb5d9.jpg" alt="Image 1">
        </div>
    </div>
    
    <div class="custom-select-imagenes">
        <div class="select-imagenes-selected">Certificado 2</div>
        <div class="select-imagenes-items">
           <img src="https://i.pinimg.com/736x/0a/40/b8/0a40b8b842e1fd83cc651a6a4a4f110f.jpg" alt="Image 4">
        </div>
    </div>
    
    <div class="custom-select-imagenes">
        <div class="select-imagenes-selected">Certificado 3</div>
        <div class="select-imagenes-items">
       <img src="https://i.pinimg.com/736x/1b/db/aa/1bdbaacb9233d2978fae6e8683d25b7d.jpg" alt="Image 7">
        </div>
    </div>
    </div>

    <div id="window6" class="window">
      <div class="custom-select-container">
        <div class="custom-select">
          <div class="selected-option">Selecciona un tema</div>
          <div class="custom-options">
            <div class="option-group">
              <div class="group-label">Tema 1: Introducción a HTML</div>
              <div class="option" data-value="subtema1">Subtema 1.1: Definiciones</div>
              <div class="option" data-value="subtema2">Subtema 1.2: Historia</div>
            </div>
            <div class="option-group">
              <div class="group-label">Tema 2: Practicas Faciles en HTML</div>
              <div class="option" data-value="subtema3">Subtema 2.1: Practica 1</div>
              <div class="option" data-value="subtema4">Subtema 2.2: Práctica 2</div>
            </div>
            <div class="option-group">
              <div class="group-label">Tema 3: Practicas Avanzadas en HTML</div>
              <div class="option" data-value="subtema5">Subtema 3.1: Practica 1</div>
              <div class="option" data-value="subtema6">Subtema 3.2: Practica 2</div>
            </div>
          </div>
        </div>
        <div class="image-containe-video">
          <img class="custom-image-video" src="https://www.shutterstock.com/shutterstock/videos/3469765267/thumb/1.jpg?ip=x480" alt="Image 10">
      </div>
        <input type="hidden" id="selectedValue6">
      </div>
    </div>
    
    <div id="window7" class="window">
      <div class="custom-select-container">
        <div class="custom-select">
          <div class="selected-option">Selecciona un tema</div>
          <div class="custom-options">
            <div class="option-group">
              <div class="group-label">Tema 1: Introducción a CSS</div>
              <div class="option" data-value="subtema1">Subtema 1.1: Definiciones</div>
              <div class="option" data-value="subtema2">Subtema 1.2: Historia</div>
            </div>
            <div class="option-group">
              <div class="group-label">Tema 2: Practicas Faciles en CSS</div>
              <div class="option" data-value="subtema3">Subtema 2.1: Practica 1</div>
              <div class="option" data-value="subtema4">Subtema 2.2: Práctica 2</div>
            </div>
            <div class="option-group">
              <div class="group-label">Tema 3: Practicas Avanzadas en CSS</div>
              <div class="option" data-value="subtema5">Subtema 3.1: Practica 1</div>
              <div class="option" data-value="subtema6">Subtema 3.2: Practica 2</div>
            </div>
          </div>
        </div>
        <div class="image-containe-video">
          <img class="custom-image-video" src="https://www.shutterstock.com/shutterstock/videos/3469765267/thumb/1.jpg?ip=x480" alt="Image 10">
      </div>

        <input type="hidden" id="selectedValue7">
      </div>
    </div>
    
    <div id="window8" class="window">
      <div class="custom-select-container">
        <div class="custom-select">
          <div class="selected-option">Selecciona un tema</div>
          <div class="custom-options">
            <div class="option-group">
              <div class="group-label">Tema 1: Introducción a PHP</div>
              <div class="option" data-value="subtema1">Subtema 1.1: Definiciones</div>
              <div class="option" data-value="subtema2">Subtema 1.2: Historia</div>
            </div>
            <div class="option-group">
              <div class="group-label">Tema 2: Practicas Faciles PHP</div>
              <div class="option" data-value="subtema3">Subtema 2.1: Practica 1</div>
              <div class="option" data-value="subtema4">Subtema 2.2: Práctica 2</div>
            </div>
            <div class="option-group">
              <div class="group-label">Tema 3: Practicas Dificiles PHP</div>
              <div class="option" data-value="subtema5">Subtema 3.1: Practica 1</div>
              <div class="option" data-value="subtema6">Subtema 3.2: Practica 2</div>
            </div>
          </div>
        </div>
        <div class="image-containe-video"></div>
          <img class="custom-image-video" src="https://www.shutterstock.com/shutterstock/videos/3469765267/thumb/1.jpg?ip=x480" alt="Image 10">
      </div>
        <input type="hidden" id="selectedValue8">
      </div>
    </div>
    
    <?php include './Components/VentanaKárdex.php';?>
  </div>

  <script src="./JS/scriptperfil.js"></script>

</body>
</html>