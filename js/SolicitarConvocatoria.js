window.addEventListener("load", function() {
    var parametros = new URLSearchParams(window.location.search);
    var idCandidato = parametros.get("id");
    var idConvocatoria = parametros.get("idConvocatoria");

    console.log(idConvocatoria)

    // Realiza la solicitud para obtener los datos del candidato
    fetch(`http://erasmusbecas.com/api/ApiCandidatos.php?id=${idCandidato}`)
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

            // Realizar solicitud para obtener los convocatoria_baremo de la convocatoria específica
            fetch(`http://erasmusbecas.com/api/ApiConvocatoriaBaremo.php?idConvocatoria=${idConvocatoria}`)
                .then(response => response.json())
                .then(convocatoriaBaremos => {
                    // Filtrar los convocatoria_baremo que permiten aportes de alumnos
                    var convocatoriaBaremosAporteAlumno = convocatoriaBaremos.filter(convBaremo => convBaremo.aportalumno);
                    console.log(convocatoriaBaremos)
                    console.log(convocatoriaBaremosAporteAlumno)
                    // Realizar solicitud para obtener los item_baremos asociados a cada convocatoria_baremo
                    Promise.all(convocatoriaBaremosAporteAlumno.map(convBaremo =>
                        fetch(`http://erasmusbecas.com/api/ApiItemBaremo.php?idConvocatoriaBaremo=${convBaremo.id_baremo}`)
                            .then(response => response.json())
                    ))
                    .then(itemBaremos => {
                        // Crear elementos en el formulario para cada item_baremo
                        var formulario = document.querySelector('form');
                        itemBaremos.forEach(itemArray => {
                            // Acceder al objeto dentro del array
                            var item = itemArray[0];

                            // Verifica si hay datos y que las propiedades esperadas están presentes
                            if (item && item.id !== undefined && item.nombre !== undefined) {
                                // Crear un nuevo elemento de etiqueta <input> o <textarea> según sea necesario
                                var inputElement = document.createElement('input');
                                inputElement.type = 'file'; // Configurar como tipo de archivo para la carga de archivos
                                inputElement.name = 'aportesAlumno[' + item.id + ']'; // Usar el id del item_baremo como nombre del campo
                                inputElement.placeholder = 'Adjuntar archivo para ' + item.nombre;

                                // Crear una etiqueta <label> para describir el campo
                                var labelElement = document.createElement('label');
                                labelElement.for = inputElement.name;
                                labelElement.textContent = item.nombre;

                                // Agregar elementos al formulario
                                formulario.appendChild(labelElement);
                                formulario.appendChild(inputElement);
                            }
                        });
                    })
                    .catch(error => console.error('Error al obtener datos del item_baremo:', error));
                })
                .catch(error => console.error('Error al obtener datos del convocatoria_baremo:', error));
        })
        .catch(error => console.error('Error al obtener datos del candidato:', error));
});
