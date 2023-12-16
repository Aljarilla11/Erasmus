window.addEventListener("load", function () {
    var parametros = new URLSearchParams(window.location.search);
    var idCandidato = parametros.get("idCandidato");

    // Hacer la solicitud a ApiCandidatosConvocatoria para obtener los idConvocatoria asociados al candidato
    fetch(`http://erasmusbecas.com/api/ApiCandidatosConvocatoria.php?idCandidato=${idCandidato}`)
        .then(response => response.json())
        .then(data => {
            
            var idConvocatoriasSet = new Set(data);

            // Convertir el conjunto a un array
            var idConvocatoriasArray = Array.from(idConvocatoriasSet);

            // Iterar sobre los idConvocatorias y hacer la solicitud para obtener detalles de cada convocatoria
            idConvocatoriasArray.forEach(idConvocatoria => {
                fetch(`http://erasmusbecas.com/api/ApiConvocatoria.php?id=${idConvocatoria}`)
                    .then(response => response.json())
                    .then(convocatoriaData => {
                        // Aquí puedes manejar los datos de la convocatoria como desees
                        console.log(convocatoriaData);
                    })
                    .catch(error => {
                        console.error('Error al obtener detalles de la convocatoria:', error);
                    });
            });
        })
        .catch(error => {
            console.error('Error al obtener idConvocatorias del candidato:', error);
        });
});