<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryDestinatarios.php';

header('Content-Type: application/json');
$conexion = ""; 
$repositoryDestinatarios = new RepositoryDestinatarios($conexion);
if (estaLogeado()) 
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $destinatario = $repositoryDestinatarios->obtenerDestinatarioPorId($id);
            if ($destinatario) {
                echo json_encode($destinatario);
            } else {
                echo json_encode(['error' => 'Destinatario no encontrado']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }
    elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
        try {
            $destinatarios = $repositoryDestinatarios->obtenerDestinatarios();
            echo json_encode($destinatarios);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }

    else {
        echo json_encode(['error' => 'Método no permitido']);
    }
}
?>
