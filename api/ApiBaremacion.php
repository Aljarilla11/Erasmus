<?php
require 'vendor/autoload.php';
require_once '../repository/Db.php';
require_once '../repository/RepositoryBaremacion.php';

use Dompdf\Dompdf;
use Dompdf\Options;

header('Content-Type: application/json');
$conexion = "";
$repositoryBaremacion = new RepositoryBaremacion($conexion);

// Crear una nueva baremación
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $idCandidato = $_POST['idCandidato'];
    $idConvocatoria = $_POST['idConvocatoria']; 
    $idItemBaremo = $_POST['idItemBaremo'];
    $url = $_FILES['url']['name'];
    $rutaCarpeta = __DIR__ . '/Erasmus/pdf/';
    move_uploaded_file($_FILES['url']['tmp_name'], "C:/xampp/htdocs/Erasmus/pdf/".$_FILES['url']['name']);
    try 
    {
        // Crear la baremación en la base de datos
        $repositoryBaremacion->crearBaremacion($idCandidato, $idConvocatoria, $idItemBaremo, $url);

        // Responder con un mensaje de éxito o cualquier otra información necesaria
        echo json_encode(['success' => true, 'message' => 'Baremación creada con éxito']);
    } 
    catch (PDOException $e)
    {
        // Responder con un mensaje de error en caso de fallo en la base de datos
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }

    $html = "<html>
    <head></head>
    <body>
        <h1>Datos de la Solicitud</h1>
        <p><strong>Nombre:</p>
        <p><strong>Apellidos:</p>
        <p><strong>DNI:</p>
    </body>
</html>";

// Configurar Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);

// Instanciar Dompdf
$dompdf = new Dompdf($options);

// Cargar el HTML al Dompdf
$dompdf->loadHtml($html);

// Establecer el tamaño del papel (puedes ajustarlo según tus necesidades)
$dompdf->setPaper('A4', 'portrait');

// Renderizar el PDF
$dompdf->render();

// Mostrar el PDF en el navegador
$dompdf->stream();

}
// Obtener todas las baremaciones por id_convocatoria
elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idConvocatoria'])) 
{
    $idConvocatoria = intval($_GET['idConvocatoria']);
    try {
        $baremacionesPorConvocatoria = $repositoryBaremacion->obtenerBaremacionesPorConvocatoria($idConvocatoria);
        echo json_encode($baremacionesPorConvocatoria);
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
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
            header('HTTP/1.0 404 Not Found');
            echo json_encode(['error' => 'Baremación no encontrada']);
        }
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
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
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }
}

else 
{
    header('HTTP/1.0 405 Method Not Allowed');
    echo json_encode(['error' => 'Método no permitido']);
}

?>
