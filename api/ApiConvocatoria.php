<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryConvocatorias.php';

header('Content-Type: application/json');
$conexion = ""; 
$repositoryConvocatorias = new RepositoryConvocatoria($conexion);
if (estaLogeado()) 
{
    // Obtener una convocatoria por ID
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        try {
            $convocatoria = $repositoryConvocatorias->obtenerConvocatoriaPorId($id);
            if ($convocatoria) {
                echo json_encode($convocatoria);
            } else {
                echo json_encode(['error' => 'Convocatoria no encontrada']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }// Obtener todas las convocatorias
    elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
        try {
            $convocatorias = $repositoryConvocatorias->obtenerConvocatorias();
            echo json_encode($convocatorias);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }

    // Eliminar una convocatoria por ID
    elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        try {
            $repositoryConvocatorias->eliminarConvocatoriaPorId($id);
            echo json_encode(['mensaje' => 'Convocatoria eliminada exitosamente']);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }

    // Actualizar una convocatoria por ID
    elseif ($_SERVER['REQUEST_METHOD'] == 'PUT' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $datos_json = file_get_contents('php://input');
        $datos = json_decode($datos_json, true);
        
        if (isset($datos['movilidades']) && isset($datos['tipo']) && isset($datos['fecha_inicio']) && isset($datos['fecha_fin']) && isset($datos['fecha_inicio_pruebas']) && isset($datos['fecha_fin_pruebas']) && isset($datos['fecha_inicio_definitiva']) && isset($datos['id_proyecto'])) {
            try {
                $repositoryConvocatorias->actualizarConvocatoriaPorId(
                    $id,
                    $datos['movilidades'],
                    $datos['tipo'],
                    $datos['fecha_inicio'],
                    $datos['fecha_fin'],
                    $datos['fecha_inicio_pruebas'],
                    $datos['fecha_fin_pruebas'],
                    $datos['fecha_inicio_definitiva'],
                    $datos['id_proyecto']
                );
                echo json_encode(['mensaje' => 'Convocatoria actualizada exitosamente']);
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
