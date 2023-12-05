<?php

// Obtener convocatorias desde la base de datos
$conexion = Db::conectar();
$sqlConvocatorias = "SELECT c.id, c.movilidades, c.tipo, c.fecha_inicio, c.fecha_fin, c.fecha_inicio_pruebas, c.fecha_fin_pruebas, c.fecha_inicio_definitiva, p.nombre as nombre_proyecto
                    FROM convocatorias c
                    INNER JOIN proyectos p ON c.id_proyecto = p.id";

$resultadoConvocatorias = $conexion->query($sqlConvocatorias);
$convocatorias = $resultadoConvocatorias->fetchAll(PDO::FETCH_ASSOC);
$conexion = null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convocatorias Disponibles</title>
</head>
<body>

    <h1>Convocatorias Disponibles</h1>

    <?php foreach ($convocatorias as $convocatoria): ?>
        <div>
            <h2><?php echo $convocatoria['movilidades'] . " Plazas"; ?></h2>
            <p><strong>Proyecto:</strong> <?php echo $convocatoria['nombre_proyecto']; ?></p>
            <p><strong>Tipo:</strong> <?php echo $convocatoria['tipo']; ?></p>
            <p><strong>Fecha de Inicio:</strong> <?php echo $convocatoria['fecha_inicio']; ?></p>
            <p><strong>Fecha de Fin:</strong> <?php echo $convocatoria['fecha_fin']; ?></p>
            <p><strong>Fecha de Inicio Pruebas:</strong> <?php echo $convocatoria['fecha_inicio_pruebas']; ?></p>
            <p><strong>Fecha de Fin Pruebas:</strong> <?php echo $convocatoria['fecha_fin_pruebas']; ?></p>
            <p><strong>Fecha de Inicio Definitiva:</strong> <?php echo $convocatoria['fecha_inicio_definitiva']; ?></p>
            
            <!-- Formulario de solicitud -->
            <form action="procesar_solicitud.php" method="post">
                <input type="hidden" name="idConvocatoria" value="<?php echo $convocatoria['id']; ?>">
                <button type="submit">Solicitar</button>
            </form>
        </div>
        <hr>
    <?php endforeach; ?>

</body>
</html>