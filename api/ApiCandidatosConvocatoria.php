<?php

require_once '../repository/Db.php';
require_once '../repository/RepositoryCandidatosConvocatoria.php';

header('Content-Type: application/json');
$conexion = "";
$repositoryCandidatosConvocatoria = new RepositoryCandidatosConvocatoria($conexion);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Obtener datos del formulario
        $idConvocatoria = $_POST['idConvocatoria']; 
        $idCandidato = $_POST['idCandidato'];

        try {
            // Agregar candidato a la convocatoria
            $repositoryCandidatosConvocatoria->agregarCandidatoConvocatoria($idConvocatoria, $idCandidato);
            echo json_encode(['success' => true, 'message' => 'Candidato agregado a la convocatoria con éxito']);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idCandidato'])) {
        $idCandidato = intval($_GET['idCandidato']);
        try {
            $idConvocatorias = $repositoryCandidatosConvocatoria->obtenerIdConvocatoriasPorCandidato($idCandidato);
            echo json_encode($idConvocatorias);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }
    // Obtener candidatos convocatoria por id_convocatoria
    elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idConvocatoria'])) {
        $idConvocatoria = intval($_GET['idConvocatoria']);
        try {
            $candidatosConvocatoria = $repositoryCandidatosConvocatoria->obtenerCandidatosConvocatoriaPorConvocatoria($idConvocatoria);
            echo json_encode($candidatosConvocatoria);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }
    // Obtener todos los candidatos convocatoria
    elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
        try {
            $candidatosConvocatoria = $repositoryCandidatosConvocatoria->obtenerTodosCandidatosConvocatoria();
            echo json_encode($candidatosConvocatoria);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }
    else {
        echo json_encode(['error' => 'Método no permitido']);
    }

?>
