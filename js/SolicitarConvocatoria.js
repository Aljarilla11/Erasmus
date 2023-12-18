window.addEventListener("load", function () {
    // Obtiene los parámetros 'idCandidato' e 'idConvocatoria' de la URL
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

            // Realizar solicitud para obtener los convocatoria_baremo de la convocatoria específica
            fetch(`http://erasmusbeca.com/api/ApiConvocatoriaBaremo.php?idConvocatoria=${idConvocatoria}`)
                .then(response => response.json())
                .then(convocatoriaBaremos => {
                    // Filtrar los convocatoria_baremo que permiten aportes de alumnos
                    var convocatoriaBaremosAporteAlumno = convocatoriaBaremos.filter(convBaremo => convBaremo.aportalumno);

                    // Realizar solicitud para obtener los item_baremos asociados a cada convocatoria_baremo
                    Promise.all(convocatoriaBaremosAporteAlumno.map(convBaremo =>
                        fetch(`http://erasmusbeca.com/api/ApiItemBaremo.php?idConvocatoriaBaremo=${convBaremo.id_baremo}`)
                            .then(response => response.json())
                    ))
                        .then(itemBaremos => {
                            // Crear elementos en el formulario para cada item_baremo
                            var contenedorItemBaremos = document.getElementById('contenedorItemBaremos');
                            itemBaremos.forEach(itemArray => {
                                var item = itemArray[0];

                                if (item && item.id !== undefined && item.nombre !== undefined) {
                                    var inputElement = document.createElement('input');
                                    inputElement.type = 'file';
                                    inputElement.name = 'aportesAlumno[' + item.id + ']';
                                    inputElement.placeholder = 'Adjuntar archivo para ' + item.nombre;

                                    var labelElement = document.createElement('label');
                                    labelElement.for = inputElement.name;
                                    labelElement.textContent = item.nombre;

                                    contenedorItemBaremos.appendChild(labelElement);
                                    contenedorItemBaremos.appendChild(inputElement);
                                }
                            });
                        })
                        .catch(error => console.error('Error al obtener datos del item_baremo:', error));
                })
                .catch(error => console.error('Error al obtener datos del convocatoria_baremo:', error));
        })
        .catch(error => console.error('Error al obtener datos del candidato:', error));

    // Agregar un evento de escucha para el envío del formulario
    document.getElementById('solicitudForm').addEventListener('submit', function (event) {
        event.preventDefault();

        // Obtener los elementos de archivo
        var inputElements = document.querySelectorAll('input[type="file"]');
        
        // Iterar sobre los elementos de archivo y realizar la solicitud para cada uno
        var isValid = true; //verificar la validez de los archivos

        inputElements.forEach(function (inputElement) {
            var idItemBaremo = inputElement.name.replace('aportesAlumno[', '').replace(']', '');

            // Verificar si se ha seleccionado un archivo
            if (inputElement.files.length > 0) {
                var file = inputElement.files[0];

                // Verificar si el archivo es de tipo PDF
                if (file.type !== 'application/pdf') {
                    // Mostrar mensaje de error si el archivo no es PDF
                    alert('Por favor, seleccione un archivo PDF.');
                    isValid = false;
                }
            }
        });

        // Si todos los archivos son válidos, proceder con la solicitud de la API de baremación
        if (isValid) {
            inputElements.forEach(function (inputElement) {
                var idItemBaremo = inputElement.name.replace('aportesAlumno[', '').replace(']', '');
                var formData = new FormData();
                
                formData.append('idCandidato', idCandidato);
                formData.append('idConvocatoria', idConvocatoria);
                formData.append('idItemBaremo', idItemBaremo);

                // Verificar si se ha seleccionado un archivo
                if (inputElement.files.length > 0) {
                    var file = inputElement.files[0];

                    formData.append('url', file);
                    formData.append(inputElement.name, file);

                    // Realizar la solicitud HTTP POST a la API de baremación
                    fetch('http://erasmusbeca.com/api/ApiBaremacion.php', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);
                        })
                        .catch(error => {
                            console.error('Error al enviar la solicitud:', error);
                        });
                }
            });

            // También, realizar la solicitud para agregar el candidato a la convocatoria
            var formData = new FormData();
            formData.append('idConvocatoria', idConvocatoria);
            formData.append('idCandidato', idCandidato);

            fetch('http://erasmusbeca.com/api/ApiCandidatosConvocatoria.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error al enviar la solicitud:', error);
                });
        }
    });
});
