<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryCandidatos.php';

header('Content-Type: application/json');
$conexion = "";
$repositoryCandidatos = new RepositoryCandidatos($conexion);

// Obtener todos los candidatos
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) 
{
    $id = intval($_GET['id']);
    try 
    {
        $candidato = $repositoryCandidatos->obtenerCandidatoPorId($id);
        if ($candidato) 
        {
            echo json_encode($candidato);
        } 
        else 
        {
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Candidato no encontrado']);
        }
    } 
    catch (PDOException $e) 
    {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}

// Obtener todos los candidatos
elseif ($_SERVER['REQUEST_METHOD'] == 'GET') 
{
    try 
    {
        $candidatos = $repositoryCandidatos->obtenerCandidatos();
        echo json_encode($candidatos);
    } 
    catch (PDOException $e) 
    {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}
// Actualizar un candidato por ID
elseif ($_SERVER['REQUEST_METHOD'] == 'PUT' && isset($_GET['id'])) 
{
    $id = intval($_GET['id']);
    $datos_json = file_get_contents('php://input');
    $datos = json_decode($datos_json, true);

    if (isset($datos['dni']) && isset($datos['nombre']) && isset($datos['apellidos']) && isset($datos['fecha_nacimiento']) && isset($datos['telefono']) && isset($datos['correo']) && isset($datos['domicilio']) && isset($datos['curso']) && isset($datos['id_tutor']) && isset($datos['rol']) && isset($datos['contrasena'])) {
        try {
            $repositoryCandidatos->editarCandidatoPorId(
                $id,
                $datos['dni'],
                $datos['nombre'],
                $datos['apellidos'],
                $datos['fecha_nacimiento'],
                $datos['telefono'],
                $datos['correo'],
                $datos['domicilio'],
                $datos['curso'],
                $datos['id_tutor'],
                $datos['rol'],
                $datos['contrasena']
            );
            echo json_encode(['mensaje' => 'Candidato actualizado exitosamente']);
        } catch (PDOException $e) {
            header('HTTP/1.1 500 Internal Server Error');
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo json_encode(['error' => 'Datos incompletos']);
    }
} else {
    header('HTTP/1.0 405 Method Not Allowed');
    echo json_encode(['error' => 'Método no permitido']);
}
?>
