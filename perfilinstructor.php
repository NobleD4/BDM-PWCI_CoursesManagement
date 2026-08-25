<?php
  require_once './Controllers/authRole_middleware.php';
?>

<?php
  include './DB_Config.php';

  $id_user = $_SESSION['ID_User'];

  $sql = "CALL SP_CourseManagement(
  -2,      -- IN pSP_Action
      
  NULL,   -- IN pID_Course
  ?,      -- IN PID_User
  NULL,   -- IN pCourse_Picture
  NULL,   -- IN pCourse_Name
  NULL    -- IN pCourse_Description
  )";
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
  <title>Perfil Instructor</title>
  <link rel="stylesheet" href="./CSS/perfilinstructor.css">

  <!-- Font Awesome Solid + Brands -->
  <link href="./fontawesome-free-v6.6.0/css/brands.css" rel="stylesheet" type="text/css">
  <link href="./fontawesome-free-v6.6.0/css/solid.css" rel="stylesheet" type="text/css">
  <link href="./fontawesome-free-v6.6.0/css/fontawesome.css" rel="stylesheet" type="text/css">
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
      <a href="./principalinstructor.php"><img src="https://img.icons8.com/?size=100&id=2797&format=png&color=FFFFFF" alt="volvermenu"></a>
  </div>
  </header>

  <!-- Sidebar -->
  <div class="sidebar">
    <a href="#" class="sidebar-link" onclick="openWindow('window1')">Ventana 1</a>
    <a href="#" class="sidebar-link" onclick="openWindow('window2')">Tu Info</a>
    <a href="#" class="sidebar-link" onclick="openWindow('window3')">Cursos Creados</a>
    <a href="#" class="sidebar-link" onclick="openWindow('window4')">Mensajes</a>
    <a href="#" class="sidebar-link" onclick="openWindow('window5')">Ganancias</a>
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
      <h1 class="cursos-title">Sus cursos</h1>
      <div class="gallery-container">
        <?php
          while ($course = $result->fetch_assoc()) {
            include './Components/TarjetaCurso.php';
          }
        ?>
        
        <div class="clearfix"></div>
      </div>
      <button class="create-course-btn" onclick="window.location.href='./crearcurso.php'">Crear Curso</button>
    </div>

    <div id="window4" class="window">
      <div class="chat-container">
        <aside class="sidebar2">
            <div class="sidebar2-header">
                <img src="https://i.pinimg.com/564x/cb/81/27/cb8127cba8860d645bbe0cfb07ef0759.jpg" alt="User Image" class="user-image">
                <button class="settings-btn">...</button>
            </div>
            <div class="chat-list">
                <div class="chat-item">
                    <img src="https://i.pinimg.com/564x/68/3d/8f/683d8f58c98a715130b1251a9d59d1b9.jpg" alt="Chat Image" class="chat-image">
                    <div class="chat-info">
                        <h4>Estudiante 1</h4>
                        <p>¡Hola! tengo una duda en este...</p>
                    </div>
                    <span class="chat-time">8:29 p.m.</span>
                </div>
                <div class="chat-item">
                  <img src="https://i.pinimg.com/564x/2c/bb/0e/2cbb0ee6c1c55b1041642128c902dadd.jpg" alt="Chat Image" class="chat-image">
                  <div class="chat-info">
                      <h4>Estudiante 2</h4>
                      <p>¡Muchas gracias! :D</p>
                  </div>
                  <span class="chat-time">8:29 p.m.</span>
              </div>
              <div class="chat-item">
                <img src="https://i.pinimg.com/564x/46/72/f8/4672f876389036583190d93a71aa6cb2.jpg" alt="Chat Image" class="chat-image">
                <div class="chat-info">
                    <h4>Estudiante 3</h4>
                    <p>¿Tiene más cursos?</p>
                </div>
                <span class="chat-time">8:29 p.m.</span>
            </div>
            </div>
        </aside>
        
        <section class="chat-window">
            <div class="chat-header">
                <h2>Estudiante 1</h2>
                <span>En línea</span>
            </div>
            <div class="chat-body">
              <p class="message">¡Hola! Tengo una duda sobre una clase suya</p>
              <p class="message user_message">¡Hola! Con mucho gusto, dime</p>
            </div>
            <div class="chat-footer">
                <input type="text" placeholder="Escribe un mensaje">
                <button>Enviar</button>
            </div>
        </section>
    </div>
    </div>

    <!-- window5 GANANCIAS -->
    <?php include './Components/VentanaGananciasGenerales.php';?>

    <!--CURSO 1-->
    <div id="window6" class="window">
    </div>
      
    <!--CURSO 2-->
    <div id="window7" class="window">
    </div>
  
    <!--CURSO 3 si le borro todo el contenido ya no puedo ver la información del usuario -->
    <div id="window8" class="window">
      <div class="rect-container contenido-ajustado">
        <div class="custom-select-container">
          <img src="https://i.pinimg.com/564x/76/37/1b/76371b2a2b1f40d8973c49047adda0da.jpg" alt="cursounoimagen">
          <div class="custom-select">
            <div class="selected-option">Selecciona un tema</div>
            <div class="custom-options">
              <div class="option-group">
                <div 
                class="group-label">Tema 1: Introducción <button onclick="window.location.href='crearsubtema.html'">Crear Subtema</button>
                <button id="deleteButton">Eliminar Tema</button>
              </div>
                <div class="option" data-value="subtema1">Subtema 1.1: Definiciones <button id="deletesubButton">Eliminar Subtema</button></div>
                <div class="option" data-value="subtema2">Subtema 1.2: Historia<button id="deletesubButton">Eliminar Subtema</button></div>
              </div>
              <div class="option-group">
                <div class="group-label">Tema 2: Desarrollo<button onclick="window.location.href='crearsubtema.html'">Crear Subtema</button>
              <button id="deleteButton">Eliminar Tema</button>
              </div>
                <div class="option" data-value="subtema3">Subtema 2.1: Teoría<button id="deletesubButton">Eliminar Subtema</button></div>
                <div class="option" data-value="subtema4">Subtema 2.2: Práctica<button id="deletesubButton">Eliminar Subtema</button></div>
              </div>
              <div class="option-group">
                <div class="group-label">Tema 3: Conclusiones<button onclick="window.location.href='crearsubtema.html'">Crear Subtema</button>
                  <button id="deleteButton">Eliminar Tema</button>
              </div>
                <div class="option" data-value="subtema5">Subtema 3.1: Resumen<button id="deletesubButton">Eliminar Subtema</button></div></div>
                <div class="option" data-value="subtema6">Subtema 3.2: Perspectivas futuras<button id="deletesubButton">Eliminar Subtema</button></div>
              
                <div class="option-group">
                  <div 
                  class="group-label"><button onclick="window.location.href='creartema.html'">Crear Tema</button>
                </div>
              </div>
              </div>
            </div>
        </div>
      </div>

        <div class="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="testimonial">
                <div class="testimonial-header">
                  <img src="https://i.pinimg.com/564x/5a/6d/66/5a6d66a3e38a50419400963106036e59.jpg" alt="Usuario" class="avatar">
                  <div>
                    <h3>Álvaro Castilla Baró</h3>
                    <span>2021-06-07</span>
                  </div>
                  <img src="https://img.icons8.com/?size=100&id=102729&format=png&color=1A1A1A" alt="trespuntos" class="tres-puntos" onclick="toggleDropdown()">
                  <div id="dropdownreportar" class="dropdown-content-reportar">
                    <a href="#">Reportar</a>
                  </div>
                </div>
                <p>Nos asesoraron y guiaron para crear nuestra web. Cumplieron con lo que necesitábamos. Nos sorprendió lo fácil que hicieron la navegación y el diseño de la web.</p>
                <div class="rating">
                  
                  <span class="fa fa-star checked"></span>
  
              <span class="fa fa-star checked"></span>
  
              <span class="fa fa-star checked"></span>
  
              <span class="fa fa-star checked"></span>
  
              <span class="fa fa-star checked"></span>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="testimonial">
                <div class="testimonial-header">
                  <img src="https://via.placeholder.com/50" alt="Usuario" class="avatar">
                  <div>
                    <h3>Alberto Ruiz</h3>
                    <span>2021-05-31</span>
                  </div>
                  <img src="https://img.icons8.com/?size=100&id=102729&format=png&color=1A1A1A" alt="trespuntos" class="tres-puntos">
                </div>
                <p>Si con el diseño web han hecho un trabajo excelente, con el SEO ha sido aún mejor. Además tienen un trato muy cercano. Da gusto trabajar con personas de este perfil.</p>
                <div class="rating">
              <span class="fa fa-star checked"></span>
  
              <span class="fa fa-star checked"></span>
  
              <span class="fa fa-star checked"></span>
  
              <span class="fa fa-star checked"></span>
  
              <span class="fa fa-star checked"></span>
                </div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="testimonial">
                <div class="testimonial-header">
                  <img src="https://via.placeholder.com/50" alt="Usuario" class="avatar">
                  <div>
                    <h3>Fabiolo Gomez</h3>
                    <span>2021-05-27</span>
                  </div>
                  <img src="https://img.icons8.com/?size=100&id=102729&format=png&color=1A1A1A" alt="trespuntos" class="tres-puntos">
                </div>
                <p>uNa vaZUra de KURzo, 0 EZTRELLAZZZZ!!!!</p>
                <div class="rating">
              <span class="fa fa-star"></span>
  
              <span class="fa fa-star"></span>
  
              <span class="fa fa-star"></span>
  
              <span class="fa fa-star"></span>
  
              <span class="fa fa-star"></span>
                </div>
              </div>
            </div>
          </div>
          <button class="prev" onclick="prevSlide()">❮</button>
          <button class="next" onclick="nextSlide()">❯</button>
      </div>

      <input type="hidden" id="selectedValue8">
    </div>

    <!--window9 CURSO1 GANANCIAS-->
    <?php include './Components/VentanaGananciasCurso.php';?>

    <!--CURSO2 GANANCIAS-->
    <div id="window10" class="window">
    </div>
  
    <!--CURSO3 GANANCIAS-->
    <div id="window11" class="window">
    </div>

    <script src="./JS/scriptperfilinst.js"></script>
  </div> 
</body>
</html>