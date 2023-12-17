<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryDestinatariosConvocatoria.php';

header('Content-Type: application/json');
$conexion = "";
$repositoryDestinatariosConvocatoria = new RepositoryDestinatariosConvocatoria($conexion);
if (estaLogeado()) 
{
    // Obtener todos los destinatarios de una convocatoria por su ID
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idConvocatoria'])) {
        $idConvocatoria = intval($_GET['idConvocatoria']);
        try {
            $destinatariosConvocatoria = $repositoryDestinatariosConvocatoria->obtenerDestinatariosPorConvocatoria($idConvocatoria);
            echo json_encode($destinatariosConvocatoria);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }
    elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_GET['id_convocatoria'])) {
        try {
            $todosDestinatariosConvocatoria = $repositoryDestinatariosConvocatoria->obtenerDestinatariosConvocatoria();
            echo json_encode($todosDestinatariosConvocatoria);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }
    // Insertar un destinatario para una convocatoria por su ID
    elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $datos_json = file_get_contents('php://input');
        $datos = json_decode($datos_json, true);

        if (isset($datos['id_convocatoria']) && isset($datos['id_destinatario'])) {
            try {
                $idDestinatarioConvocatoria = $repositoryDestinatariosConvocatoria->insertarDestinatarioConvocatoria(
                    $datos['id_convocatoria'],
                    $datos['id_destinatario']
                );
                echo json_encode(['id' => $idDestinatarioConvocatoria]);
            } catch (PDOException $e) {
                echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['error' => 'Datos incompletos']);
        }
    }

    else {
        echo json_encode(['error' => 'Método no permitido']);
    }
}
?>
