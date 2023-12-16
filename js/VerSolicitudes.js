window.addEventListener("load", function () {
    var parametros = new URLSearchParams(window.location.search);
    var idCandidato = parametros.get("idCandidato");

    // Hacer la solicitud a ApiCandidatosConvocatoria para obtener los idConvocatoria asociados al candidato
    fetch(`http://erasmusbecas.com/api/ApiCandidatosConvocatoria.php?idCandidato=${idCandidato}`)
        .then(response => response.json())
        .then(data => {
            // Convertir el conjunto de idConvocatorias a un array
            var idConvocatoriasArray = Array.from(new Set(data));

            // Obtener el contenedor de convocatorias
            var convocatoriasContainer = document.getElementById('convocatoriasContainer');

            // Iterar sobre los idConvocatorias y hacer la solicitud para obtener detalles de cada convocatoria
            idConvocatoriasArray.forEach(idConvocatoria => {
                fetch(`http://erasmusbecas.com/api/ApiConvocatoria.php?id=${idConvocatoria}`)
                    .then(response => response.json())
                    .then(convocatoriaData => {
                        // Llenar los elementos con los datos de la convocatoria
                        convocatoriasContainer.innerHTML += `
                            <div>
                                <h2>Beca Erasmus 2023 - ${convocatoriaData.movilidades} plazas</h2>
                                <p><strong>Tipo:</strong> ${convocatoriaData.tipo}</p>
                                <p><strong>Fecha de Inicio:</strong> ${convocatoriaData.fecha_inicio}</p>
                                <p><strong>Fecha de Fin:</strong> ${convocatoriaData.fecha_fin}</p>
                                <p><strong>Fecha de Inicio Pruebas:</strong> ${convocatoriaData.fecha_inicio_pruebas}</p>
                                <p><strong>Fecha de Fin Pruebas:</strong> ${convocatoriaData.fecha_fin_pruebas}</p>
                                <p><strong>Fecha de Inicio Definitiva:</strong> ${convocatoriaData.fecha_inicio_definitiva}</p>
                                <hr>
                            </div>
                        `;
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
