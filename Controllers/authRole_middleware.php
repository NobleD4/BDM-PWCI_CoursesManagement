<?php
    session_start();

    // Verifica si el usuario está logueado
    if (!isset($_SESSION['User_Role'])) {
        // Si no hay sesión activa, redirige al login
        header("Location: ../index.php");
        exit();
    }

    // Páginas permitidas para cada rol
    $rolePermissions = [
        1 => ['Principal.php',              // Estudiante
        'perfil.php',
        'mensajepriv.php',
        'curso.php'],

        2 => ['PrincipalInstructor.php',    // Instructor
        'perfilinstructor.php',
        'mensajepriv.php',
        'crearcurso.php',
        'creartema.php',
        'curso.php'],
        
        3 => ['PrincipalAdmin.php',         // Administrador
        'perfiladmin.php',
        'curso.php'],
    ];

    // Obtiene el rol del usuario
    $userRole = $_SESSION['User_Role'];

    // Obtiene la página actual
    $currentFile = basename($_SERVER['PHP_SELF']);

    // Verifica si el rol del usuario tiene acceso a la página actual
    if (!in_array($currentFile, $rolePermissions[$userRole])) {
        // Si no tiene acceso, redirige a la página principal de su rol
        header("Location: " . $rolePermissions[$userRole][0]);
        exit(); // Detener ejecución
    }
?>