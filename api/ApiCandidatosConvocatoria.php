<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryCandidatosConvocatoria.php';

header('Content-Type: application/json');
$conexion = "";  // Asegúrate de establecer la conexión a la base de datos
$repositoryCandidatosConvocatoria = new RepositoryCandidatosConvocatoria($conexion);


// Obtener candidatos convocatoria por id_convocatoria
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idConvocatoria'])) {
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
