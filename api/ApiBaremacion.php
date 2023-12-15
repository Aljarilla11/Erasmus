<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryBaremacion.php';

header('Content-Type: application/json');
$conexion = "";  // Asegúrate de establecer la conexión a la base de datos
$repositoryBaremacion = new RepositoryBaremacion($conexion);

// Crear una nueva baremación
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Asegúrate de que la solicitud sea de tipo POST y maneja adecuadamente la subida de archivos

    // Obtén los datos del formulario
    $idCandidato = $_POST['idCandidato']; // Ajusta según tu formulario
    $idConvocatoria = $_POST['idConvocatoria']; // Ajusta según tu formulario
    $idItemBaremo = $_POST['idItemBaremo']; // Ajusta según tu formulario
    //$url = $_FILES['archivo']['name']; // Ajusta según tu formulario y el nombre del campo del archivo
    $url = $_POST['url'];

    try {
        // Crear la baremación en la base de datos
        $repositoryBaremacion->crearBaremacion($idCandidato, $idConvocatoria, $idItemBaremo, $url);

        // Responder con un mensaje de éxito o cualquier otra información necesaria
        echo json_encode(['success' => true, 'message' => 'Baremación creada con éxito']);
    } catch (PDOException $e) {
        // Responder con un mensaje de error en caso de fallo en la base de datos
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}
// Obtener todas las baremaciones por id_convocatoria
elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idConvocatoria'])) {
    $idConvocatoria = intval($_GET['idConvocatoria']);
    try {
        $baremacionesPorConvocatoria = $repositoryBaremacion->obtenerBaremacionesPorConvocatoria($idConvocatoria);
        echo json_encode($baremacionesPorConvocatoria);
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}
// Obtener baremación por ID
elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    try {
        $baremacion = $repositoryBaremacion->obtenerBaremacionPorId($id);
        if ($baremacion) {
            echo json_encode($baremacion);
        } else {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Baremación no encontrada']);
        }
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}
// Obtener todas las baremaciones
elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $baremaciones = $repositoryBaremacion->obtenerTodasBaremaciones();
        echo json_encode($baremaciones);
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
