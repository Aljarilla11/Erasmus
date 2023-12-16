<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryCandidatosConvocatoria.php';

header('Content-Type: application/json');
$conexion = "";  // Asegúrate de establecer la conexión a la base de datos
$repositoryCandidatosConvocatoria = new RepositoryCandidatosConvocatoria($conexion);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $idConvocatoria = $_POST['idConvocatoria']; // Ajusta según tu formulario
    $idCandidato = $_POST['idCandidato']; // Ajusta según tu formulario

    try {
        // Agregar candidato a la convocatoria
        $repositoryCandidatosConvocatoria->agregarCandidatoConvocatoria($idConvocatoria, $idCandidato);

        // Responder con un mensaje de éxito o cualquier otra información necesaria
        echo json_encode(['success' => true, 'message' => 'Candidato agregado a la convocatoria con éxito']);
    } catch (PDOException $e) {
        // Responder con un mensaje de error en caso de fallo en la base de datos
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idCandidato'])) {
    $idCandidato = intval($_GET['idCandidato']);
    try {
        $idConvocatorias = $repositoryCandidatosConvocatoria->obtenerIdConvocatoriasPorCandidato($idCandidato);
        echo json_encode($idConvocatorias);
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}
// Obtener candidatos convocatoria por id_convocatoria
elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idConvocatoria'])) {
    $idConvocatoria = intval($_GET['idConvocatoria']);
    try {
        $candidatosConvocatoria = $repositoryCandidatosConvocatoria->obtenerCandidatosConvocatoriaPorConvocatoria($idConvocatoria);
        echo json_encode($candidatosConvocatoria);
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}
// Obtener todos los candidatos convocatoria
elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $candidatosConvocatoria = $repositoryCandidatosConvocatoria->obtenerTodosCandidatosConvocatoria();
        echo json_encode($candidatosConvocatoria);
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}



// Método no permitido o acción no reconocida
else {
    header('HTTP/1.0 405 Method Not Allowed');
    echo json_encode(['error' => 'Método no permitido']);
}

?>
