///FUNCIONES

//Función para validar contraseña
function Validate_Password(password) {
    let mayusculas = "A-Z";
    let minusculas = "a-z";
    let numeros = "\\d";
    let especiales = "¡!¿?@#$%^&\\-_.,;:=([{}])*";
    let conjuntoTotal = `${mayusculas}${minusculas}${numeros}${especiales}`;

    let regex = new RegExp(`^(?=.*[${mayusculas}])(?=.*[${minusculas}])(?=.*[${numeros}])(?=.*[${especiales}])[${conjuntoTotal}]{8,}$`);

    if (!regex.test(password)) {
        alert("La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, una letra minúscula y un carácter especial.");
        return false; // No se envía el formulario
    }
    return true; // Se envía el formulario
}

//Función para validar fecha de nacimiento
function Validate_Birthdate(fechaNac) {
    var fechaIngresada = new Date(fechaNac);
    var fechaActual = new Date();
    var edadMinima = 13;

    // Calcular la diferencia de años
    var edad = fechaActual.getFullYear() - fechaIngresada.getFullYear();
    var mes = fechaActual.getMonth() - fechaIngresada.getMonth();
    var dia = fechaActual.getDate() - fechaIngresada.getDate();

    if (mes < 0 || (mes === 0 && dia < 0)) {
        edad--; // Se resta un año si el cumpleaños aún no ha pasado
    }

    if (edad < edadMinima) {
        alert("Debes tener al menos 13 años para registrarte.");
        return false;
    }
    return true;
}
///