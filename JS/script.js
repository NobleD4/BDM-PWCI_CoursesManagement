document.addEventListener('DOMContentLoaded', function() {
    console.log("Jala");

    // Cambiar entre el formulario de inicio de sesión y el de registro
    document.querySelector('.signup-link').addEventListener('click', function(event) {
        event.preventDefault();
        document.querySelector('.login-form').style.display = 'none';
        document.querySelector('.signup-form').style.display = 'block';
    });

    document.querySelector('.login-link').addEventListener('click', function(event) {
        event.preventDefault();
        document.querySelector('.signup-form').style.display = 'none';
        document.querySelector('.login-form').style.display = 'block';
    });

    // Redirigir según el valor del combobox
    document.getElementById("loginbtn").addEventListener("click", function(event) {
        event.preventDefault(); // Evita el envío del formulario por defecto

        var username = document.getElementById('username').value;
        var nameRegex = /^[A-Za-z\s]+$/;
    
        if (!nameRegex.test(username)) {
            alert("El nombre de usuario solo puede contener letras.");
            return;
        }
    
        var password = document.getElementById('password').value;
        var passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&_.*])(?=.*[0-9]).{8,}$/;
        if (!passwordRegex.test(password)) {
            alert("La contraseña debe tener al menos 8 caracteres, incluir una mayúscula, un número y un carácter especial.");
            return;
        }

        var userType = document.getElementById('tipousu').value;

        // Define las páginas a las que redirigir según el tipo de usuario
        var redirectTo = '';
        switch(userType) {
            case 'estudiante':
                redirectTo = 'principal.html'; // Cambia a la página para estudiantes
                window.location.href = 'principal.html';
                break;
            case 'instructor':
                redirectTo = 'principalinstructor.html'; // Cambia a la página para instructores
                break;
            case 'admin':
                redirectTo = 'principaladmin.html'; // Cambia a la página para administradores
                break;
            default:
                redirectTo = 'index.html'; // Página por defecto si no se selecciona un valor válido
        }

        window.location.href = redirectTo;
    });

    // Validar campos de registro
    document.getElementById("signupbtn").addEventListener("click", function(event) {
        event.preventDefault(); // Evita el envío del formulario por defecto

        // Validación del nombre (no debe contener números)
        var name = document.getElementById('name').value;
        var lastname = document.getElementById('lastname').value;
        var nameRegex = /^[A-Za-z\s]+$/;

        if (!nameRegex.test(name) || !nameRegex.test(lastname)) {
            alert("El nombre y los apellidos solo pueden contener letras.");
            return;
        }

        // Validación del correo electrónico
        var email = document.getElementById('email').value;
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert("Por favor, ingresa un correo electrónico válido.");
            return;
        }

        // Validación de la contraseña
        var password = document.getElementById('newpassword').value;
        var confirmPassword = document.getElementById('confirmPassword').value;
        var passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&_.*])(?=.*[0-9]).{8,}$/;
        if (!passwordRegex.test(password)) {
            alert("La contraseña debe tener al menos 8 caracteres, incluir una mayúscula, un número y un carácter especial.");
            return;
        }

        // Verificar que las contraseñas coincidan
        if (password !== confirmPassword) {
            alert("Las contraseñas no coinciden.");
            return;
        }

        var userTypeRegis = document.getElementById('tipousu').value;

        // Define las páginas a las que redirigir según el tipo de usuario
        var redirectToRegis = '';
        switch(userTypeRegis) {
            case 'estudiante':
                redirectToRegis = 'principal.html'; // Cambia a la página para estudiantes
                window.location.href = 'principal.html';
                break;
            case 'instructor':
                redirectToRegis = 'principalinstructor.html'; // Cambia a la página para instructores
                break;
            case 'admin':
                redirectToRegis = 'principaladmin.html'; // Cambia a la página para administradores
                break;
            default:
                redirectToRegis = 'index.html'; // Página por defecto si no se selecciona un valor válido
        }

        // Redirigir después del registro exitoso
        window.location.href = redirectToRegis;
    });
});