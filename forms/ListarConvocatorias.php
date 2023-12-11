<?php

// Obtener convocatorias desde la base de datos
$conexion = Db::conectar();
$sqlConvocatorias = "SELECT c.id, c.movilidades, c.tipo, c.fecha_inicio, c.fecha_fin, c.fecha_inicio_pruebas, c.fecha_fin_pruebas, c.fecha_inicio_definitiva, p.nombre as nombre_proyecto
                    FROM convocatorias c
                    INNER JOIN proyectos p ON c.id_proyecto = p.id";

$resultadoConvocatorias = $conexion->query($sqlConvocatorias);
$convocatorias = $resultadoConvocatorias->fetchAll(PDO::FETCH_ASSOC);
$conexion = null;

if (isset($_POST['idConvocatoria']) && is_numeric($_POST['idConvocatoria'])) {
    // Obtener el ID de convocatoria desde el formulario
    $idConvocatoria = $_POST['idConvocatoria'];

    // Aquí puedes realizar cualquier lógica adicional para manejar la solicitud según tus necesidades

    // Redireccionar a la nueva página "Solicitud" con un encabezado personalizado
    header("Location: ?menu=solicitarconvocatoria&idConvocatoria=$idConvocatoria");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convocatorias Disponibles</title>
    <link rel="stylesheet" href="../estilos/estiloListarConvocatorias.css">
</head>
<body>

    <h1>Convocatorias Disponibles</h1>

    <?php foreach ($convocatorias as $convocatoria): ?>
        <div class="listconvocatorias">
            <h2><?php echo $convocatoria['movilidades'] . " Plazas"; ?></h2>
            <p><strong>Proyecto:</strong> <?php echo $convocatoria['nombre_proyecto']; ?></p>
            <p><strong>Tipo:</strong> <?php echo $convocatoria['tipo']; ?></p>
            <p><strong>Fecha de Inicio:</strong> <?php echo $convocatoria['fecha_inicio']; ?></p>
            <p><strong>Fecha de Fin:</strong> <?php echo $convocatoria['fecha_fin']; ?></p>
            <p><strong>Fecha de Inicio Pruebas:</strong> <?php echo $convocatoria['fecha_inicio_pruebas']; ?></p>
            <p><strong>Fecha de Fin Pruebas:</strong> <?php echo $convocatoria['fecha_fin_pruebas']; ?></p>
            <p><strong>Fecha de Inicio Definitiva:</strong> <?php echo $convocatoria['fecha_inicio_definitiva']; ?></p>
            
            <!-- Formulario de solicitud -->
            <form action="" method="post">
                <input type="hidden" name="idConvocatoria" value="<?php echo $convocatoria['id']; ?>">
                <button type="submit">Solicitar</button>
            </form>
        </div>
        <hr>
    <?php endforeach; ?>

</body>
</html>