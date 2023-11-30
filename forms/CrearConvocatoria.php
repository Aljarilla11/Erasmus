<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
        isset($_POST['nombreProyecto'], $_POST['codigoProyecto'], $_POST['fechaInicioProyecto'], $_POST['fechaFinProyecto'],
        $_POST['movilidad'], $_POST['tipo'], $_POST['fechaInicio'], $_POST['fechaFin'], $_POST['fechaInicioProvisional'],
        $_POST['fechaFinProvisional'], $_POST['fechaInicioDefinitiva'])) 
    {
        $conexion = Db::conectar();
        $nombreProyecto = $_POST['nombreProyecto'];
        $codigoProyecto = $_POST['codigoProyecto'];
        $fechaInicioProyecto = $_POST['fechaInicioProyecto'];
        $fechaFinProyecto = $_POST['fechaFinProyecto'];

        $sqlProyecto = "INSERT INTO proyectos (nombre, cod_proyecto, fecha_inicio, fecha_fin)
                            VALUES (:nombreProyecto, :codigoProyecto, :fechaInicioProyecto, :fechaFinProyecto)";

        $statementProyecto = $conexion->prepare($sqlProyecto);

        $statementProyecto->bindParam(':nombreProyecto', $nombreProyecto);
        $statementProyecto->bindParam(':codigoProyecto', $codigoProyecto);
        $statementProyecto->bindParam(':fechaInicioProyecto', $fechaInicioProyecto);
        $statementProyecto->bindParam(':fechaFinProyecto', $fechaFinProyecto);

        if ($statementProyecto->execute()) 
        {
            // Obtener el último id insertado
            $idProyecto = $conexion->lastInsertId();

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
                echo "Creado";
            } 
            else 
            {
                echo "Error al crear la convocatoria: " . $statementConvocatoria->errorInfo()[2];
            }
            } 
            else 
            {
                echo "Error al crear el proyecto: " . $statementProyecto->errorInfo()[2];
            }
            $conexion = null;
    } 
    
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

        <label for="nombreProyecto">Nombre del Proyecto:</label>
        <input type="text" id="nombreProyecto" name="nombreProyecto" required>

        <label for="codigoProyecto">Código del Proyecto:</label>
        <input type="text" id="codigoProyecto" name="codigoProyecto" required>

        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo">
            <option value="larga">Larga</option>
            <option value="corta">Corta</option>
        </select>

        <label for="movilidad">Movilidad:</label>
        <input type="text" id="movilidad" name="movilidad" required>

        <label for="fechaInicio">Fecha de Inicio:</label>
        <input type="date" id="fechaInicio" name="fechaInicio">

        <label for="fechaFin">Fecha de Fin:</label>
        <input type="date" id="fechaFin" name="fechaFin">

        <label for="fechaInicioProvisional">Fecha de Inicio Provisional:</label>
        <input type="date" id="fechaInicioProvisional" name="fechaInicioProvisional">

        <label for="fechaFinProvisional">Fecha de Fin Provisional:</label>
        <input type="date" id="fechaFinProvisional" name="fechaFinProvisional">

        <label for="fechaInicioDefinitivo">Fecha de Inicio Definitivo:</label>
        <input type="date" id="fechaInicioDefinitivo" name="fechaInicioDefinitivo">

        <button type="submit">Crear Convocatoria</button>
    </form>
</body>
</html>
