<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryNivelesIdioma.php';

header('Content-Type: application/json');
$conexion = "";
$repositoryNivelesIdioma = new RepositoryNivelesIdioma($conexion);
if (estaLogeado()) 
{
    // Obtener todos los niveles de idioma
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['id'])) {
        $id = intval($_GET['id']);
        try {
            $nivelIdioma = $repositoryNivelesIdioma->obtenerNivelIdiomaPorId($id);
            if ($nivelIdioma) {
                echo json_encode($nivelIdioma);
            } else {
                echo json_encode(['error' => 'Nivel de idioma no encontrado']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
        try {
            $nivelesIdioma = $repositoryNivelesIdioma->obtenerNivelesIdioma();
            echo json_encode($nivelesIdioma);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Método no permitido']);
    }
}
?>
