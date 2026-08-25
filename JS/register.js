//La función se manda a llamar para el formulario del Registro
document.getElementById('ID_FORM_REGISTER').onsubmit = function() {
    var fechaNac = document.getElementById('ID_INPUT_BIRTHDATE').value;
    var newpassword = document.getElementById('ID_INPUT_NEWPASSWORD').value;
    var confirmPassword = document.getElementById('ID_INPUT_CONFIRMPASSWORD').value;
    
    // Validar fecha de nacimiento
    if (!Validate_Birthdate(fechaNac)) {
        return false;
    }

    // Verificar que las contraseñas coincidan
    if (newpassword !== confirmPassword) {
        alert("Las contraseñas no coinciden.");
        return false;
    }

    // Validar formato de la contraseña
    if (!Validate_Password(newpassword)) {
        return false;
    }

    return true;
};