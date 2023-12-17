<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryItemBaremo.php';

header('Content-Type: application/json');
$conexion = "";
$repositoryItemBaremo = new RepositoryItemBaremo($conexion);
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['idConvocatoriaBaremo'])) {
        $idConvocatoriaBaremo = intval($_GET['idConvocatoriaBaremo']);
        try {
            $itemsBaremo = $repositoryItemBaremo->obtenerItemsBaremoPorConvocatoriaBaremo($idConvocatoriaBaremo);
            echo json_encode($itemsBaremo);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }
    // Obtener todos los ítems del baremo
    elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id'])) {
        $id = intval($_GET['id']);
        try {
            $itemBaremo = $repositoryItemBaremo->obtenerItemBaremoPorId($id);
            if ($itemBaremo) {
                echo json_encode($itemBaremo);
            } else {
                echo json_encode(['error' => 'Ítem del baremo no encontrado']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
        try {
            $itemsBaremo = $repositoryItemBaremo->obtenerItemsBaremo();
            echo json_encode($itemsBaremo);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Método no permitido']);
    }
?>
