<?php
require 'vendor/autoload.php';
require_once '../repository/Db.php';
require_once '../repository/RepositoryBaremacion.php';
require_once '../repository/RepositoryCandidatos.php';

use Dompdf\Dompdf;
use Dompdf\Options;

header('Content-Type: application/json');
$conexion = "";
$repositoryBaremacion = new RepositoryBaremacion($conexion);
$repositoryCandidatos = new RepositoryCandidatos($conexion);

    // Crear una nueva baremación
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $idCandidato = $_POST['idCandidato'];
        $idConvocatoria = $_POST['idConvocatoria']; 
        $idItemBaremo = $_POST['idItemBaremo'];
        $url = $_FILES['url']['name'];

        // Obtener los datos del candidato según su idCandidato
        $datosCandidato = $repositoryCandidatos->obtenerCandidatoPorId($idCandidato);

        try 
        {
            // Crear la baremación en la base de datos
            $repositoryBaremacion->crearBaremacion($idCandidato, $idConvocatoria, $idItemBaremo, $url);
            echo json_encode(['success' => true, 'message' => 'Baremación creada con éxito']);
        } 
        catch (PDOException $e) 
        {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
            exit();
        }

        $html = "<html>
        <head></head>
        <body>
            <h1>Datos de la Solicitud</h1>
            <p><strong>Nombre:</strong> {$datosCandidato['nombre']}</p>
            <p><strong>Apellidos:</strong> {$datosCandidato['apellidos']}</p>
            <p><strong>DNI:</strong> {$datosCandidato['dni']}</p>
        </body>
        </html>";

    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);

    $dompdf = new Dompdf($options);

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    $dompdf->stream();

    }
    elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idConvocatoria'])) 
    {
        $idConvocatoria = intval($_GET['idConvocatoria']);
        try {
            $baremacionesPorConvocatoria = $repositoryBaremacion->obtenerBaremacionesPorConvocatoria($idConvocatoria);
            echo json_encode($baremacionesPorConvocatoria);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }
    // Obtener baremación por ID
    elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) 
    {
        $id = intval($_GET['id']);
        try {
            $baremacion = $repositoryBaremacion->obtenerBaremacionPorId($id);
            if ($baremacion) {
                echo json_encode($baremacion);
            } else {
                echo json_encode(['error' => 'Baremación no encontrada']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }
    // Obtener todas las baremaciones
    elseif ($_SERVER['REQUEST_METHOD'] == 'GET') 
    {
        try {
            $baremaciones = $repositoryBaremacion->obtenerTodasBaremaciones();
            echo json_encode($baremaciones);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    }

    else 
    {
        echo json_encode(['error' => 'Método no permitido']);
    }

?>
