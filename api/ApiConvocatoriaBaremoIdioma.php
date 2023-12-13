<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryConvocatoriaBaremoIdioma.php';

header('Content-Type: application/json');
$conexion = "";
$repositoryConvocatoriaBaremoIdioma = new RepositoryConvocatoriaBaremoIdiomas($conexion);

// Obtener todos los elementos del baremo idioma de una convocatoria específica
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idConvocatoriaBaremo'])) {
    $idConvocatoriaBaremo = intval($_GET['idConvocatoriaBaremo']);
    try {
        $convocatoriaBaremoIdioma = $repositoryConvocatoriaBaremoIdioma->obtenerConvocatoriaBaremoIdiomaPorConvocatoriaBaremo($idConvocatoriaBaremo);
        echo json_encode($convocatoriaBaremoIdioma);
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
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
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Elemento del baremo idioma no encontrado']);
        }
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}

else {
    // Método no permitido o acción no reconocida
    header('HTTP/1.0 405 Method Not Allowed');
    echo json_encode(['error' => 'Método no permitido']);
}
?>
