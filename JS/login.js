//La función se manda a llamar para el formulario del Login
document.getElementById('ID_FORM_LOGIN').onsubmit = function() {
    var password = document.getElementById('ID_INPUT_PASSWORD').value;

    // Validar contraseña de inicio de sesión
  if (!Validate_Password(password)) {
    return false;
    }
    
    return true;
};