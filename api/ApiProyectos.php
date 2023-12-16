<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryProyectos.php';

header('Content-Type: application/json');
$conexion = ""; 
$repositoryProyectos = new RepositoryProyectos($conexion);

// Obtener todos los proyectos
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $proyectos = $repositoryProyectos->obtenerTodosProyectos();
        echo json_encode($proyectos);
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}

// Obtener un proyecto por su ID
elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $idProyecto = intval($_GET['id']);
    try {
        $proyecto = $repositoryProyectos->obtenerProyectoPorId($idProyecto);
        if ($proyecto) {
            echo json_encode($proyecto);
        } else {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Proyecto no encontrado']);
        }
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}

// Actualizar un proyecto por su ID
elseif ($_SERVER['REQUEST_METHOD'] == 'PUT' && isset($_GET['id'])) {
    $idProyecto = intval($_GET['id']);
    $datos_json = file_get_contents('php://input');
    $datos = json_decode($datos_json, true);

    if (isset($datos['cod_proyecto']) && isset($datos['nombre']) && isset($datos['fecha_inicio']) && isset($datos['fecha_fin'])) {
        try {
            $repositoryProyectos->editarProyectoPorId(
                $idProyecto,
                $datos['cod_proyecto'],
                $datos['nombre'],
                $datos['fecha_inicio'],
                $datos['fecha_fin']
            );
            echo json_encode(['mensaje' => 'Proyecto actualizado exitosamente']);
        } catch (PDOException $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo json_encode(['error' => 'Datos incompletos']);
    }
}
else {
    header('HTTP/1.0 405 Method Not Allowed');
    echo json_encode(['error' => 'Método no permitido']);
}

?>
