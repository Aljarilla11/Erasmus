<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryTutor.php';

header('Content-Type: application/json');
$conexion = "";
$repositoryTutor = new RepositoryTutor($conexion);

// Obtener todos los tutores
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $tutores = $repositoryTutor->obtenerTodosTutores();
        echo json_encode($tutores);
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}

// Obtener un tutor por su ID
elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $idTutor = intval($_GET['id']);
    try {
        $tutor = $repositoryTutor->obtenerTutorPorId($idTutor);
        if ($tutor) {
            echo json_encode($tutor);
        } else {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Tutor no encontrado']);
        }
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}

// Actualizar un tutor por su ID
elseif ($_SERVER['REQUEST_METHOD'] == 'PUT' && isset($_GET['id'])) {
    $idTutor = intval($_GET['id']);
    $datos_json = file_get_contents('php://input');
    $datos = json_decode($datos_json, true);

    if (isset($datos['dni']) && isset($datos['nombre']) && isset($datos['apellidos']) && isset($datos['telefono']) && isset($datos['domicilio'])) {
        try {
            $repositoryTutor->editarTutorPorId(
                $idTutor,
                $datos['dni'],
                $datos['nombre'],
                $datos['apellidos'],
                $datos['telefono'],
                $datos['domicilio']
            );
            echo json_encode(['mensaje' => 'Tutor actualizado exitosamente']);
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
