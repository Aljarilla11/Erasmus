<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryDestinatarios.php';

header('Content-Type: application/json');
$conexion = "";  // Asegúrate de establecer la conexión a la base de datos
$repositoryDestinatarios = new RepositoryDestinatarios($conexion);

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $destinatario = $repositoryDestinatarios->obtenerDestinatarioPorId($id);
        if ($destinatario) {
            echo json_encode($destinatario);
        } else {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Destinatario no encontrado']);
        }
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $destinatarios = $repositoryDestinatarios->obtenerDestinatarios();
        echo json_encode($destinatarios);
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}

else {
    // Método no permitido o acción no reconocida
    header('HTTP/1.0 405 Method Not Allowed');
    echo json_encode(['error' => 'Método no permitido']);
}
?>
