<?php
// Verificar si se proporcionó el ID de convocatoria en la URL
if (isset($_GET['idConvocatoria']) && is_numeric($_GET['idConvocatoria'])) {
    $idConvocatoria = $_GET['idConvocatoria'];

    // Obtener los IDs de baremo para la convocatoria específica
    $conexion = Db::conectar();

    // Obtener nombres de elementos de baremo para cada ID de baremo
    $nombresBaremo = [];

    $sqlBaremo = "SELECT id_baremo FROM convocatoria_baremo WHERE id_convocatoria = :idConvocatoria";
    $statementBaremo = $conexion->prepare($sqlBaremo);
    $statementBaremo->bindParam(':idConvocatoria', $idConvocatoria);
    $statementBaremo->execute();
    $idBaremos = $statementBaremo->fetchAll(PDO::FETCH_ASSOC);

    foreach ($idBaremos as $idBaremo) {
        $sqlNombreBaremo = "SELECT nombre FROM item_baremo WHERE id = :idBaremo";
        $statementNombreBaremo = $conexion->prepare($sqlNombreBaremo);
        $statementNombreBaremo->bindParam(':idBaremo', $idBaremo['id_baremo']);
        $statementNombreBaremo->execute();
        $nombreBaremo = $statementNombreBaremo->fetch(PDO::FETCH_ASSOC);

        if ($nombreBaremo) {
            array_push($nombresBaremo, $nombreBaremo['nombre']);
        }
    }

    $conexion = null;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Solicitud</title>
</head>
<body>
    <h1>Formulario de Solicitud</h1>

    <form action="" method="post">
        <!-- Datos personales del alumno -->
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required>

        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required>

        <label for="telefono">Número de Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" required>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required>

        <label for="domicilio">Domicilio:</label>
        <input type="text" id="domicilio" name="domicilio" required>

        <label for="fechaNacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fechaNacimiento" name="fechaNacimiento" required>

        <!-- Elementos del baremo -->
        <h2>Elementos del Baremo</h2>

        <?php foreach ($nombresBaremo as $nombreBaremo): ?>
    <label for="elemento_<?php echo $nombreBaremo; ?>"><?php echo $nombreBaremo; ?>:</label>
    <input type="text" id="elemento_<?php echo $nombreBaremo; ?>" name="elementosBaremo[<?php echo $nombreBaremo; ?>]" required>
<?php endforeach; ?>

        <button type="submit">Enviar Solicitud</button>
    </form>
</body>
</html>
