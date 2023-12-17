<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryConvocatoriaBaremo.php';

header('Content-Type: application/json');
$conexion = "";
$repositoryConvocatoriaBaremo = new RepositoryConvocatoriaBaremo($conexion);
    // Obtener todos los elementos del baremo de una convocatoria
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idConvocatoria'])) {
        $idConvocatoria = intval($_GET['idConvocatoria']);
        try {
            $convocatoriaBaremo = $repositoryConvocatoriaBaremo->obtenerConvocatoriaBaremoPorConvocatoria($idConvocatoria);
            echo json_encode($convocatoriaBaremo);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }

    // Obtener un elemento del baremo por ID
    elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        try {
            $elementoBaremo = $repositoryConvocatoriaBaremo->obtenerConvocatoriaBaremoPorId($id);
            if ($elementoBaremo) {
                echo json_encode($elementoBaremo);
            } else {
                echo json_encode(['error' => 'Elemento del baremo no encontrado']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }

    else {
        echo json_encode(['error' => 'Método no permitido']);
    }
?>
