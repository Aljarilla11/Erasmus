<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryBaremacion.php';

header('Content-Type: application/json');
$conexion = "";  // Asegúrate de establecer la conexión a la base de datos
$repositoryBaremacion = new RepositoryBaremacion($conexion);

// Obtener todas las baremaciones por id_convocatoria
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idConvocatoria'])) {
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
