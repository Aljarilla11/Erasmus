window.addEventListener("load", function() {
    var parametros = new URLSearchParams(window.location.search);
    var idCandidato = parametros.get("id");
    var idConvocatoria = parametros.get("idConvocatoria");

    // Realiza la solicitud para obtener los datos del candidato
    fetch(`http://erasmusbeca.com/api/ApiCandidatos.php?id=${idCandidato}`)
        .then(response => response.json())
        .then(data => {
            // Rellena los campos del formulario con los datos del candidato
            document.getElementById('nombre').value = data.nombre;
            document.getElementById('apellidos').value = data.apellidos;
            document.getElementById('dni').value = data.dni;
            document.getElementById('telefono').value = data.telefono;
            document.getElementById('correo').value = data.correo;
            document.getElementById('domicilio').value = data.domicilio;
            document.getElementById('fechaNacimiento').value = data.fecha_nacimiento;
        })
        .catch(error => console.error('Error al obtener datos del candidato:', error));
});
