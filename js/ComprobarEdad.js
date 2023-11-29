document.addEventListener("DOMContentLoaded", function () {
    var fechaNacimiento = document.getElementById("fechaNacimiento");

    fechaNacimiento.addEventListener("change", function () {
        var fechaNacimientoValue = new Date(fechaNacimiento.value);
        var fechaActual = new Date();
        var diferenciaEdad = fechaActual.getFullYear() - fechaNacimientoValue.getFullYear();

        var seccionTutor = document.getElementById("seccionTutor");

        // Muestra la sección del tutor solo si el usuario es menor de edad
        if (diferenciaEdad < 18) {
            seccionTutor.style.display = "block";
        } else {
            seccionTutor.style.display = "none";
        }
    });
});