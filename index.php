<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicio de Sesión</title>
        <link rel="stylesheet" href="./CSS/styles.css">
    </head>
    <body>
        <div class="container">
            <div class="login-form">
                <h2>Iniciar Sesión</h2>
                <form id="ID_FORM_LOGIN" action="./Controllers/validar_usuario.php" method="POST"> <!-- Si metes a una carpeta las páginas asegúrate de que cuando se haga la referencia a la ruta del archivo .php correctamente -->
                    <label for="ID_INPUT_EMAIL">Usuario:</label>
                    <input type="email" id="ID_INPUT_EMAIL" name="NAME_INPUT_EMAIL" placeholder="Ingrese su correo" required>

                    <label for="ID_INPUT_PASSWORD">Contraseña:</label>
                    <input type="password" id="ID_INPUT_PASSWORD" name="NAME_INPUT_PASSWORD" placeholder="Ingrese su contraseña" required>
                    
                    <label for="ID_USER_ROLE">Entrar como:</label>
                    <select id="ID_USER_ROLE" name="NAME_USER_ROLE">
                        <option value="1">Estudiante</option>
                        <option value="2">Instructor</option>
                        <option value="3">Administrador</option>
                    </select>

                    <br>
                    <br>

                    <button id="loginbtn">Iniciar Sesión</button>   
                </form>
                <p>No tienes cuenta? <a href="./register.php">Regístrate aquí</a></p>
            </div>

            
        </div>
        <script src="./JS/functions.js"></script>
        <script src="./JS/login.js"></script>
    </body>
</html>