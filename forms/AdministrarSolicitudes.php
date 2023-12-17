<?php
try 
{
    // Consulta preparada para obtener el rol del usuario por su nombre
    $conexion = Db::conectar();
    $query = "SELECT rol FROM candidatos WHERE dni = :dni";
    $statement = $conexion->prepare($query);

    $statement->bindParam(':dni', $_SESSION['usuario'], PDO::PARAM_STR);
    $statement->execute();

    // Obtener el resultado de la consulta
    $resultado = $statement->fetch(PDO::FETCH_ASSOC);

    if ($resultado) 
    {
        $rolUsuario = $resultado['rol'];
    } 
    else
    {
        $rolUsuario = 'sinRol'; // Establece un valor predeterminado si el usuario no tiene un rol
    }
} 
catch (PDOException $e) 
{
    // Manejar errores de conexión o consultas
    $rolUsuario = 'sinRol';
}



// Lógica para determinar qué mostrar según el rol
if ($rolUsuario == 'admin') 
{
    ImprimirMenus::imprimirMenuAdmin();
} 
elseif ($rolUsuario == 'alumno') 
{
    ImprimirMenus::imprimirMenuAlumno();
} 
else 
{
    echo $rolUsuario;
    echo $_SESSION['usuario'];
    echo "<p>Rol no reconocido</p>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['calificar'])) {
    // Procesar los datos del formulario y cualquier otra lógica necesaria

    // Obtener el ID de la convocatoria
    $idConvocatoria = $_POST['idConvocatoria'];

    // Redireccionar a la página de calificación con el ID de la convocatoria
    header("Location: ?menu=calificar&idConvocatoria=$idConvocatoria");
    exit();
}


$conexion = Db::conectar();

$sql = "SELECT DISTINCT c.id, c.movilidades, c.tipo, c.fecha_inicio, c.fecha_fin, c.fecha_inicio_pruebas, c.fecha_fin_pruebas, c.fecha_inicio_definitiva
        FROM convocatorias c
        INNER JOIN baremacion b ON c.id = b.id_convocatoria";

$resultadoConvocatoriasBaremacion = $conexion->query($sql);
$convocatoriasBaremacion = $resultadoConvocatoriasBaremacion->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Solicitudes</title>
    <link rel="stylesheet" href="../estilos/estiloAdministrarSolicitudes.css">
</head>
<body>

    <h1>Convocatorias en Baremación</h1>

    <?php foreach ($convocatoriasBaremacion as $convocatoria): ?>
        <div class="listconvocatorias">
            <h2><?php echo $convocatoria['movilidades'] . " Plazas"; ?></h2>
            <p><strong>Tipo:</strong> <?php echo $convocatoria['tipo']; ?></p>
            <p><strong>Fecha de Inicio:</strong> <?php echo $convocatoria['fecha_inicio']; ?></p>
            <p><strong>Fecha de Fin:</strong> <?php echo $convocatoria['fecha_fin']; ?></p>
            <p><strong>Fecha de Inicio Pruebas:</strong> <?php echo $convocatoria['fecha_inicio_pruebas']; ?></p>
            <p><strong>Fecha de Fin Pruebas:</strong> <?php echo $convocatoria['fecha_fin_pruebas']; ?></p>
            <p><strong>Fecha de Inicio Definitiva:</strong> <?php echo $convocatoria['fecha_inicio_definitiva']; ?></p>
            
            <form action="" method="post">
                <input type="hidden" name="idConvocatoria" value="<?php echo $convocatoria['id']; ?>">
                <button type="submit" name="calificar">Calificar</button>
            </form>

        </div>
        <hr>
    <?php endforeach; ?>

</body>
</html>