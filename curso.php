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

$sql_course = "CALL SP_CourseManagement(
-1,      -- IN pSP_Action
    
?,      -- IN pID_Course
NULL,   -- IN PID_User
NULL,   -- IN pCourse_Picture
NULL,   -- IN pCourse_Name
NULL    -- IN pCourse_Description
);";
$stmt_course = $conn->prepare($sql_course);
$stmt_course->bind_param("s", $id_course);
$stmt_course->execute();
$result_course = $stmt_course->get_result();

// Verifica si el curso existe
if ($result_course->num_rows > 0) {
$course = $result_course->fetch_assoc();
} else {
die("Curso no encontrado.");
}

// ¿Es creador del curso?
$is_creator = ($_SESSION['ID_User'] === $course['ID_User']);
?>

<?php
include 'DB_Config.php';

$sql_level = "CALL SP_LevelCourseManagement(
2,   -- pSP_Action			

NULL,   -- pID_Level
?,      -- pID_Course
NULL,   -- pLevel_Name
NULL    -- pLevel_Price
)";
$stmt_level = $conn->prepare($sql_level);
$stmt_level->bind_param('s', $id_course);
$stmt_level->execute();
$result_level = $stmt_level->get_result();

// Verifica si el nivel existe
if ($result_level->num_rows > 0) {
  $level = $result_level->fetch_assoc();
}
?>

<?php
include 'DB_Config.php';

$sql_comments = "CALL SP_Course_Comments(
    2,          -- IN pSP_Action
    NULL,       -- IN pID_Comment
    NULL,       -- IN pID_User
    ?,          -- IN pID_Course
    NULL        -- IN pComment_Text
)";
$stmt_comments = $conn->prepare($sql_comments);
$stmt_comments->bind_param('s', $id_course);
$stmt_comments->execute();
$result_comments = $stmt_comments->get_result();

// Verifica si el comentario existe
if ($result_comments->num_rows > 0) {
  $comment = $result_comments->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página Curso</title>
  <link rel="stylesheet" href="./CSS/curso.css">

  <!-- Font Awesome Solid + Brands -->
  <link href="./fontawesome-free-v6.6.0/css/brands.css" rel="stylesheet" type="text/css">
  <link href="./fontawesome-free-v6.6.0/css/solid.css" rel="stylesheet" type="text/css">
  <link href="./fontawesome-free-v6.6.0/css/fontawesome.css" rel="stylesheet" type="text/css">

  <style>
    body {
        font-family: Arial, sans-serif;
    }

    .wrapper {
        border: 1px solid #ccc;
        margin: 10px 0;
        border-radius: 8px;
        overflow: hidden;
    }

    .level-title {
        background-color: #f4f4f4;
        padding: 10px 15px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .level-title:hover {
        background-color: #eaeaea;
    }

    .level-content {
        display: none;
        padding: 15px;
        background-color: #fff;
    }

    .level-content p {
        margin: 0 0 10px;
    }

    .buttons {
        margin-top: 10px;
    }

    .buttons button {
        padding: 8px 12px;
        margin-right: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .buttons .publish {
        background-color: #007bff;
        color: #fff;
    }

    .buttons .complete {
        background-color: #28a745;
        color: #fff;
    }
  </style>
</head>
<body>

  <?php include './Components/headerCurso.php';?>

  <main>
      <section class="course-info">
          <h1><?php echo ($course['Course_Name']); ?></h1>
          <p><?php echo ($course['Course_Description']); ?></p>
          <p>Categorías:</p>
          <p id="current-categories">
              <!-- Aquí se cargarán dinámicamente las categorías del curso -->
              Cargando categorías...
          </p>

          <?php if ($is_creator) { ?>
            <form action="./Controllers/insertar_eliminar_categoría_curso.php" method="POST">
              <input type="hidden" name="ID_Course" value="<?php echo $id_course; ?>">
              <input type="hidden" name="action" id="action-input" value="4"> <!-- Acción por defecto: Añadir categoría -->
              
              <select name="ID_Category" id="categories-select" required>
                  <!-- Aquí se cargarán las categorías disponibles -->
              </select>
              <br>
              
              <!-- Botón para añadir categoría -->
              <button type="submit" onclick="setAction(4)">Añadir categoría</button>
              
              <!-- Botón para eliminar categoría -->
              <button type="submit" onclick="setAction(5)">Eliminar categoría</button>
            </form>

            <br>
          <?php } ?>

          <script>
            function setAction(actionValue) {
              document.getElementById('action-input').value = actionValue;
            }

            // Función para cargar las categorías existentes del curso
            function loadCourseCategories() {
                const courseId = "<?php echo $id_course; ?>";
                fetch(`./Controllers/get_categoría_curso.php?ID_Course=${courseId}`)
                    .then(response => response.json())
                    .then(categories => {
                        const container = document.getElementById("current-categories");
                        if (categories.length > 0) {
                            container.innerHTML = categories.map(cat => cat.Category_Name).join(", ");
                        } else {
                            container.textContent = "Sin categorías";
                        }
                    })
                    .catch(err => console.error("Error al cargar las categorías del curso:", err));
            }

            // Función para cargar todas las categorías disponibles
            function loadAllCategories() {
                fetch("./Controllers/get_categoría.php")
                    .then(response => response.json())
                    .then(categories => {
                        const select = document.getElementById("categories-select");
                        categories.forEach(cat => {
                            const option = document.createElement("option");
                            option.value = cat.ID_Category;
                            option.textContent = cat.Category_Name;
                            select.appendChild(option);
                        });
                    })
                    .catch(err => console.error("Error al cargar todas las categorías:", err));
            }

            // Cargar las categorías al cargar la página
            document.addEventListener("DOMContentLoaded", () => {
              loadCourseCategories();
              loadAllCategories();
            });
          </script>
          
          
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <span class="fa fa-star <?= $i <= ($course['AverageRating']) ? 'checked' : ''; ?>"></span>
          <?php endfor; ?>

          <p>Calificación: <?php echo ($course['AverageRating']); ?></p>
          <p><?php echo ($course['Total_Votes']); ?> votos de estudiantes registrados</p>
          <p>Total de niveles <?php echo ($course['Course_TotalLevels']); ?></p>
          <p>Creado por <a href="mensajepriv.php"><?php echo ($course['Creator_Name']); ?></a></p>
          <p>Creado el <?php echo ($course['Register_Date']); ?></p>
          <p>Última actualización <?php echo ($course['UpdateInfo_Date']); ?></p>

          <div class="imagenhtml">
          <img src="data:image/jpeg;base64,<?php echo base64_encode($course['Course_Picture']); ?>" alt="Portada del curso">
        </div>
          
      </section>
      <aside class="pricing">
        <?php if ($is_creator) { ?>
          <p>Estatus del Curso: <?php echo ($course['Course_Status']) ?></p>

          <?php
            if ($course['Course_Status'] === 'DESACTIVADO') {
          ?>
          <form action="./Controllers/activar_curso.php" method="POST">
            <input type="hidden" name="ID_Course" value="<?php echo $id_course; ?>">
            <button>Publicar curso</button>
          </form>
          <br><br>
          <?php
            } else {
          ?>
          <form action="./Controllers/desactivar_curso.php" method="POST">
            <input type="hidden" name="ID_Course" value="<?php echo $id_course; ?>">
            <button>Eliminar curso</button>
          </form>
          <br><br>
          <?php
            }
          ?>
        <?php } ?>

        <div class="price">
            <span class="discounted-price"><?php echo ($course['FullCourse_Price']); ?></span>
        </div>

        <?php if ($_SESSION['User_Role'] == 1) { ?>
          <p><b>Comprar curso completo</b></p>
          <br>
          <button value="1">Transferencia</button>
          <button value="2">Mastercard</button>
          <button value="3">PayPal</button>
        <?php } ?>
      </aside>
  </main>
  <?php if ($is_creator) { ?>
  <button onclick="window.location.href='./creartema.php?ID_Course=<?= $course['ID_Course']; ?>'">Crear Nuevo Nivel +</button>
  <br><br>
  <?php } ?>

  <?php
    include './Components/LevelWrapper.php';
    while ($level = $result_level->fetch_assoc()) {
      include './Components/LevelWrapper.php';
    }
  ?>
  <?php if ($_SESSION['User_Role'] == 1) { ?>
    <!-- Mostrar las estrellas -->
    <div class="star-rating">
      <form action="./Controllers/calificar_curso.php" method="POST" id="ratingForm">
        <input type="hidden" name="NAME_INPUT_ID_COURSE" value="<?php echo $id_course; ?>">
        <input type="hidden" name="NAME_INPUT_USER_RATING" id="UserRating" value="0">

        <?php for ($i = 1; $i <= 5; $i++): ?>
          <span
            class="fa fa-star star" 
            data-value="<?= $i; ?>" 
            onclick="rateCourse(<?= $i; ?>)"
            onmouseover="highlightStars(<?= $i; ?>)" 
            onmouseout="resetStars()"
          ></span>
        <?php endfor; ?>
        
        <button type="submit" class="submit-rating">Enviar Calificación</button>
      </form>

      <script>
        let selectedRating = 0;

        function rateCourse(rating) {
          selectedRating = rating; // Guardar la calificación seleccionada
          document.getElementById('UserRating').value = rating; // Actualizar el input oculto
          highlightStars(rating); // Actualizar las estrellas visualmente
        }

        function highlightStars(rating) {
          const stars = document.querySelectorAll('.star');
          stars.forEach((star, index) => {
            if (index < rating) {
              star.classList.add('checked');
            } else {
              star.classList.remove('checked');
            }
          });
        }

        function resetStars() {
          if (selectedRating === 0) {
            const stars = document.querySelectorAll('.star');
            stars.forEach(star => star.classList.remove('checked'));
          } else {
            highlightStars(selectedRating);
          }
        }
      </script>
    </div>

    <div class="comment-section">
      <h3>Deja un comentario</h3>
      <form action="./Controllers/crear_comentario.php" method="POST">
          <input type="hidden" name="NAME_INPUT_ID_COURSE" value="<?php echo $id_course; ?>">
          
          <textarea 
            name="NAME_INPUT_COMMENT_TEXT"
            rows="5"
            placeholder="Escribe tu comentario aquí..."
            required></textarea>
          
          <button type="submit" class="submit-comment">Enviar Comentario</button>
      </form>
    </div>
  <?php } ?>

  <!-- Mostrar comentarios -->
  <div class="carousel">
      <div class="carousel-inner">
      <?php
        include './Components/CursoComentario.php';
        while ($comment = $result_comments->fetch_assoc()) {
          include './Components/CursoComentario.php';
        }
      ?>
      </div>
      <button class="prev" onclick="prevSlide()">❮</button>
      <button class="next" onclick="nextSlide()">❯</button>
    </div>
    <script>
      function toggleLevelContent(element) {
        const content = element.nextElementSibling;
        const isVisible = content.style.display === "block";
        const icon = element.querySelector("span:last-child");

        // Toggle content visibility
        content.style.display = isVisible ? "none" : "block";

        // Update the toggle icon
        icon.textContent = isVisible ? "+" : "-";
      }
    </script>
  <script src="./JS/cursos.js"></script>
</body>
</html>