<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Regístrate</title>
        <link rel="stylesheet" href="./CSS/styles.css">
    </head>
    <body>
        <div class="container">
            <div class="signup-form">
                <h2>Registrarse</h2>
                <form id="ID_FORM_REGISTER" action="./Controllers/insertar_usuario.php" method="POST">
                    <label for="name">Nombre:</label>
                    <input type="text" id="ID_INPUT_NAME" name="NAME_INPUT" placeholder="Ingrese su nombre" required>
                    
                    <label for="lastname">Apellido paterno:</label>
                    <input type="text" id="ID_INPUT_LASTNAME" name="NAME_INPUT_LASTNAME" placeholder="Ingrese su apellido paterno" required>

                    <label for="lastname">Apellido materno:</label>
                    <input type="text" id="ID_INPUT_SECONDLASTNAME" name="NAME_INPUT_SECONDLASTNAME"placeholder="Ingrese su apellido materno" required>
                    
                    <label for="birthdate">Fecha de Nacimiento:</label>
                    <input type="date" id="ID_INPUT_BIRTHDATE" name="NAME_INPUT_BIRTHDATE" required>
                    
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="ID_INPUT_EMAIL" name="NAME_INPUT_EMAIL" placeholder="Ingrese su correo electrónico" required>
                    
                    <label for="newpassword">Contraseña:</label>
                    <input type="password" id="ID_INPUT_NEWPASSWORD" name="NAME_INPUT_PASSWORD" placeholder="Ingrese su contraseña" required>
                    
                    <label for="confirmPassword">Confirmar Contraseña:</label>
                    <input type="password" id="ID_INPUT_CONFIRMPASSWORD" name="NAME_INPUT_CONFIRMPASSWORD" placeholder="Confirme su contraseña" required>
                    
                    <label for="tipousureg">Género</label>
                    <select name="NAME_USER_GENDER" id="generoreg">
                        <option value="0">Prefiero no decirlo</option>
                        <option value="1">Femenino</option>
                        <option value="2">Masculino</option>
                    </select>

                    <button id="signupbtn">Registrarse</button>

                    <label for="tipousureg">Entrar como:</label>
                    <select name="NAME_USER_ROLE" id="tipousureg">
                        <option value="1">Estudiante</option>
                        <option value="2">Instructor</option>
                    </select>
                    
                    <p>¿Ya tienes una cuenta? <a href="index.php">Inicia sesión aquí</a></p>
                </form>
            </div>
        </div>
        <script src="./JS/functions.js"></script>
        <script src="./JS/register.js"></script>
    </body>
</html>