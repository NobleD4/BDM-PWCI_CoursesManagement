# EduCASA

**Plataforma web educativa FULL-STACK** para la gestión y consumo de cursos. Incluyendo gestión de Usuarios, Cursos, Categorías, Niveles, Calificaciones y Reportes.

## Información del proyecto

Desarrollado con fines académicos como Proyecto Final para las asignaturas **Base de Datos Multimedia** y **Programación Web de Capa Intermedia**. Es una plataforma web que tiene como fin que cualquier persona pueda compartir sus conocimientos por medio de cursos diseñados para que puedan ser consumidos de forma autodidacta.

Hubo que diseñar y modelar una base de datos con sus [Tablas](https://github.com/NobleD4/BDM-PWCI_CoursesManagement/blob/main/SQL%20Database/1-TABLES.sql), [Vistas](https://github.com/NobleD4/BDM-PWCI_CoursesManagement/blob/main/SQL%20Database/2-VIEWS.sql), [Triggers](https://github.com/NobleD4/BDM-PWCI_CoursesManagement/blob/main/SQL%20Database/3-TRIGGERS.sql), [Stored Procedures](https://github.com/NobleD4/BDM-PWCI_CoursesManagement/blob/main/SQL%20Database/4-STORED%20PROCEDURES.sql), y [Funciones](https://github.com/NobleD4/BDM-PWCI_CoursesManagement/blob/main/SQL%20Database/5-FUNCTIONS.sql).

<img width="493" height="690" alt="BDM_Modelo-Relacional-v4" src="https://github.com/user-attachments/assets/331e8b95-609d-4d70-a66d-c152405f687c" />

Finalizado en *Noviembre del 2024*.

## Instalación

Las tecnologías que se utilizaron para este proyecto fueron:
* **Gestor.** `MySQL Workbench`
* **Base de datos.** `MySQL Server 8.0`
* **Servidor.** `Apache XAMPP`
* **Lenguajes.** `PHP`, `HTML`, `CSS` & `JS`

1. Clonar el repositorio.
2. Añadir [Font Awesome](https://fontawesome.com/v6/download):
    * Descargar [Font Awesome Free 6.6.0](https://use.fontawesome.com/releases/v6.6.0/fontawesome-free-6.6.0-desktop.zip).
    * Agregar todos los archivos del `.zip`en la carpeta `fontawesome-free-v6.6.0` en la raíz del proyecto (crear la carpeta en caso de que no exista).
3. Crear localmente la base de datos MySQL por medio de los archivos incluidos en la carpeta `SQL Database`.
4. Configurar credenciales de la base de datos:
    * Agregar el archivo `DB_Config.php` en caso de que no exista.
    * El archivo debería verse de la siguiente manera: 
    ```php
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "Tu_Contraseña";
    $dbname = "db_prueba";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    ?>
    ```
5. Ejecutar el proyecto
