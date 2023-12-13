<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryItemBaremo.php';

header('Content-Type: application/json');
$conexion = "";
$repositoryItemBaremo = new RepositoryItemBaremo($conexion);

// Obtener todos los ítems del baremo
if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    try {
        $itemBaremo = $repositoryItemBaremo->obtenerItemBaremoPorId($id);
        if ($itemBaremo) {
            echo json_encode($itemBaremo);
        } else {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Ítem del baremo no encontrado']);
        }
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $itemsBaremo = $repositoryItemBaremo->obtenerItemsBaremo();
        echo json_encode($itemsBaremo);
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
} else {
    // Método no permitido o acción no reconocida
    header('HTTP/1.0 405 Method Not Allowed');
    echo json_encode(['error' => 'Método no permitido']);
}
?>
