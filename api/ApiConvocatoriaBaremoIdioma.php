<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryConvocatoriaBaremoIdioma.php';

header('Content-Type: application/json');
$conexion = "";
$repositoryConvocatoriaBaremoIdioma = new RepositoryConvocatoriaBaremoIdiomas($conexion);
if (estaLogeado()) 
{
    // Obtener todos los elementos del baremo idioma de una convocatoria específica
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idConvocatoriaBaremo'])) {
        $idConvocatoriaBaremo = intval($_GET['idConvocatoriaBaremo']);
        try {
            $convocatoriaBaremoIdioma = $repositoryConvocatoriaBaremoIdioma->obtenerConvocatoriaBaremoIdiomaPorConvocatoriaBaremo($idConvocatoriaBaremo);
            echo json_encode($convocatoriaBaremoIdioma);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }

    // Obtener un elemento del baremo idioma por ID
    elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        try {
            $elementoBaremoIdioma = $repositoryConvocatoriaBaremoIdioma->obtenerConvocatoriaBaremoIdiomasPorId($id);
            if ($elementoBaremoIdioma) {
                echo json_encode($elementoBaremoIdioma);
            } else {
                echo json_encode(['error' => 'Elemento del baremo idioma no encontrado']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }

    else {
        echo json_encode(['error' => 'Método no permitido']);
    }
}
?>
