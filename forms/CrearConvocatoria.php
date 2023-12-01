<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['movilidad'], $_POST['tipo'], $_POST['fechaInicio'], $_POST['fechaFin'], $_POST['fechaInicioProvisional'],
    $_POST['fechaFinProvisional'], $_POST['fechaInicioDefinitiva'], $_POST['idProyecto'])) 
{
    $conexion = Db::conectar();

    // Obtener el id_proyecto seleccionado
    $idProyecto = $_POST['idProyecto'];

    // Insertar datos de la convocatoria
    $movilidad = $_POST['movilidad'];
    $tipo = $_POST['tipo'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $fechaInicioProvisional = $_POST['fechaInicioProvisional'];
    $fechaFinProvisional = $_POST['fechaFinProvisional'];
    $fechaInicioDefinitiva = $_POST['fechaInicioDefinitiva'];

    $sqlConvocatoria = "INSERT INTO convocatorias (movilidades, tipo, fecha_inicio, fecha_fin, fecha_inicio_pruebas, fecha_fin_pruebas, fecha_inicio_definitiva, id_proyecto)
                        VALUES (:movilidad, :tipo, :fechaInicio, :fechaFin, :fechaInicioProvisional, :fechaFinProvisional, :fechaInicioDefinitiva, :idProyecto)";

    $statementConvocatoria = $conexion->prepare($sqlConvocatoria);

    $statementConvocatoria->bindParam(':movilidad', $movilidad);
    $statementConvocatoria->bindParam(':tipo', $tipo);
    $statementConvocatoria->bindParam(':fechaInicio', $fechaInicio);
    $statementConvocatoria->bindParam(':fechaFin', $fechaFin);
    $statementConvocatoria->bindParam(':fechaInicioProvisional', $fechaInicioProvisional);
    $statementConvocatoria->bindParam(':fechaFinProvisional', $fechaFinProvisional);
    $statementConvocatoria->bindParam(':fechaInicioDefinitiva', $fechaInicioDefinitiva);
    $statementConvocatoria->bindParam(':idProyecto', $idProyecto);

    if ($statementConvocatoria->execute()) 
    {
        echo "Convocatoria creada exitosamente";
    } 
    else 
    {
        echo "Error al crear la convocatoria: " . $statementConvocatoria->errorInfo()[2];
    }

    // Cerrar la conexión
    $conexion = null;
}

// Obtener la lista de proyectos
$conexion = Db::conectar();
$sqlProyectos = "SELECT id, nombre FROM proyectos";
$resultadoProyectos = $conexion->query($sqlProyectos);
$proyectos = $resultadoProyectos->fetchAll(PDO::FETCH_ASSOC);
$conexion = null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Convocatorias</title>
    <style>
        label {
            display: block;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>

    <h1>Formulario de Convocatorias</h1>

    <form id="convocatoriaForm" method="post" action="">

        <!-- Campos del formulario relacionados con el proyecto ... -->

        <label for="movilidad">Movilidad:</label>
        <input type="text" id="movilidad" name="movilidad" required>

        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo">
            <option value="larga">Larga</option>
            <option value="corta">Corta</option>
        </select>

        <label for="fechaInicio">Fecha de Inicio:</label>
        <input type="date" id="fechaInicio" name="fechaInicio">

        <label for="fechaFin">Fecha de Fin:</label>
        <input type="date" id="fechaFin" name="fechaFin">

        <label for="fechaInicioProvisional">Fecha de Inicio Provisional:</label>
        <input type="date" id="fechaInicioProvisional" name="fechaInicioProvisional">

        <label for="fechaFinProvisional">Fecha de Fin Provisional:</label>
        <input type="date" id="fechaFinProvisional" name="fechaFinProvisional">

        <label for="fechaInicioDefinitiva">Fecha de Inicio Definitiva:</label>
        <input type="date" id="fechaInicioDefinitiva" name="fechaInicioDefinitiva">

        <!-- Agregado el campo para idProyecto con un evento onChange -->
        <label for="idProyecto">Proyecto:</label>
        <select id="idProyecto" name="idProyecto">
            <?php foreach ($proyectos as $proyecto): ?>
                <option value="<?php echo $proyecto['id']; ?>"><?php echo $proyecto['nombre']; ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Crear Convocatoria</button>
    </form>
</body>
</html>
