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

$idConvocatoria = isset($_GET['idConvoctoria']) ? $_GET['idConvoctoria'] : null;
$conexion = Db::conectar();
$query = "SELECT * FROM convocatorias WHERE id = :idConvocatoria";
$stmt = $conexion->prepare($query);
$stmt->bindParam(':idConvocatoria', $idConvocatoria);
$stmt->execute();
$convocatoria = $stmt->fetch(PDO::FETCH_ASSOC);
$idProyectoSeleccionado = $convocatoria['id_proyecto'];

// Obtener todos los proyectos disponibles
$queryProyectos = "SELECT * FROM proyectos";
$stmtProyectos = $conexion->prepare($queryProyectos);
$stmtProyectos->execute();
$proyectos = $stmtProyectos->fetchAll(PDO::FETCH_ASSOC);

$sqlDestinatarios = "SELECT cod_grupo, nombre FROM destinatarios";
$resultadoDestinatarios = $conexion->query($sqlDestinatarios);
$destinatarios = $resultadoDestinatarios->fetchAll(PDO::FETCH_ASSOC);

$queryDestinatariosConvocatoria = "SELECT id_destinatario FROM destinatarios_convocatoria WHERE id_convocatoria = :idConvocatoria";
$stmtDestinatariosConvocatoria = $conexion->prepare($queryDestinatariosConvocatoria);
$stmtDestinatariosConvocatoria->bindParam(':idConvocatoria', $idConvocatoria);
$stmtDestinatariosConvocatoria->execute();
$destinatariosSeleccionados = $stmtDestinatariosConvocatoria->fetchAll(PDO::FETCH_COLUMN);


if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // Realizar las validaciones necesarias

    // Obtener los datos del formulario
    $movilidad = $_POST['movilidad'];
    $idProyecto = $_POST['idProyecto'];
    $tipo = $_POST['tipo'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $fechaInicioProvisional = $_POST['fechaInicioProvisional'];
    $fechaFinProvisional = $_POST['fechaFinProvisional'];
    $fechaInicioDefinitiva = $_POST['fechaInicioDefinitiva'];

    $conexion = Db::conectar();
    
    // Iniciar la transacción
    $conexion->beginTransaction();

    try 
    {
        // Actualizar la tabla convocatorias
        $sqlUpdateConvocatoria = "UPDATE convocatorias SET movilidades = :movilidad, id_proyecto = :idProyecto, tipo = :tipo, 
            fecha_inicio = :fechaInicio, fecha_fin = :fechaFin, fecha_inicio_pruebas = :fechaInicioProvisional, 
            fecha_fin_pruebas = :fechaFinProvisional, fecha_inicio_definitiva = :fechaInicioDefinitiva WHERE id = :idConvocatoria";
        $stmtUpdateConvocatoria = $conexion->prepare($sqlUpdateConvocatoria);
        $stmtUpdateConvocatoria->bindParam(':movilidad', $movilidad);
        $stmtUpdateConvocatoria->bindParam(':idProyecto', $idProyecto);
        $stmtUpdateConvocatoria->bindParam(':tipo', $tipo);
        $stmtUpdateConvocatoria->bindParam(':fechaInicio', $fechaInicio);
        $stmtUpdateConvocatoria->bindParam(':fechaFin', $fechaFin);
        $stmtUpdateConvocatoria->bindParam(':fechaInicioProvisional', $fechaInicioProvisional);
        $stmtUpdateConvocatoria->bindParam(':fechaFinProvisional', $fechaFinProvisional);
        $stmtUpdateConvocatoria->bindParam(':fechaInicioDefinitiva', $fechaInicioDefinitiva);
        $stmtUpdateConvocatoria->bindParam(':idConvocatoria', $idConvocatoria);
        $stmtUpdateConvocatoria->execute();
        

        // Realizar las acciones necesarias para guardar en otras tablas (destinatarios, etc.)

        // Confirmar la transacción
        $conexion->commit();
        header("Location: ?menu=modificarconvocatoria");
        exit();
        echo "La convocatoria se actualizó correctamente.";
    } 
    catch (PDOException $e) 
    {
        // Revertir la transacción en caso de error
        $conexion->rollBack();
        echo "Error al actualizar la convocatoria: " . $e->getMessage();
    }
    $sqlDeleteDestinatarios = "DELETE FROM destinatarios_convocatoria WHERE id_convocatoria = :idConvocatoria";
    $stmtDeleteDestinatarios = $conexion->prepare($sqlDeleteDestinatarios);
    $stmtDeleteDestinatarios->bindParam(':idConvocatoria', $idConvocatoria);
    $stmtDeleteDestinatarios->execute();

    // Insertar los destinatarios seleccionados en el formulario
    if (isset($_POST['destinatarios']) && is_array($_POST['destinatarios'])) 
    {
        foreach ($_POST['destinatarios'] as $codGrupo) {
            $sqlInsertDestinatario = "INSERT INTO destinatarios_convocatoria (id_convocatoria, id_destinatario) VALUES (:idConvocatoria, :idDestinatario)";
            $stmtInsertDestinatario = $conexion->prepare($sqlInsertDestinatario);
            $stmtInsertDestinatario->bindParam(':idConvocatoria', $idConvocatoria);
            $stmtInsertDestinatario->bindParam(':idDestinatario', $codGrupo);
            $stmtInsertDestinatario->execute();
        }
    }
}

// Cerrar la conexión
$conexion = null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Convocatoria</title>
    <link rel="stylesheet" href="../estilos/estiloEditarConvocatoria.css">
</head>
<body>

<h1>Editar Convocatoria</h1>

<form id="convocatoriaForm" method="post" action="">
    <label for="movilidad">Movilidad:</label>
    <input type="text" id="movilidad" name="movilidad" value="<?php echo $convocatoria['movilidades']; ?>" required>
    <?php if(isset($errores['movilidad'])) { echo $errores['movilidades']; } ?>

    <label for="idProyecto">Proyecto:</label>
    <select id="idProyecto" name="idProyecto">
        <?php foreach ($proyectos as $proyecto): ?>
            <option value="<?php echo $proyecto['id']; ?>" <?php echo ($idProyectoSeleccionado == $proyecto['id']) ? 'selected' : ''; ?>><?php echo $proyecto['nombre']; ?></option>
        <?php endforeach; ?>
    </select>

    <label>Destinatarios:</label>
    <?php foreach ($destinatarios as $destinatario): ?>
        <input type="checkbox" name="destinatarios[]" value="<?php echo $destinatario['cod_grupo']; ?>" <?php echo (in_array($destinatario['cod_grupo'], $destinatariosSeleccionados)) ? 'checked' : ''; ?>>
        <?php echo $destinatario['nombre']; ?><br>
    <?php endforeach; ?>

    <label for="tipo">Tipo:</label>
    <select id="tipo" name="tipo">
        <option value="larga" <?php echo ($convocatoria['tipo'] === 'larga') ? 'selected' : ''; ?>>Larga</option>
        <option value="corta" <?php echo ($convocatoria['tipo'] === 'corta') ? 'selected' : ''; ?>>Corta</option>
    </select>
    <?php if(isset($errores['tipo'])) { echo $errores['tipo']; } ?>

    <label for="fechaInicio">Fecha de Inicio:</label>
    <input type="date" id="fechaInicio" name="fechaInicio" value="<?php echo $convocatoria['fecha_inicio']; ?>">
    <?php if(isset($errores['fechaInicio'])) { echo $errores['fechaInicio']; } ?>

    <label for="fechaFin">Fecha de Fin:</label>
    <input type="date" id="fechaFin" name="fechaFin" value="<?php echo $convocatoria['fecha_fin']; ?>">
    <?php if(isset($errores['fechaFin'])) { echo $errores['fechaFin']; } ?>

    <label for="fechaInicioProvisional">Fecha de Inicio Provisional:</label>
    <input type="date" id="fechaInicioProvisional" name="fechaInicioProvisional" value="<?php echo $convocatoria['fecha_inicio_pruebas']; ?>">
    <?php if(isset($errores['fechaInicioProvisional'])) { echo $errores['fechaInicioProvisional']; } ?>

    <label for="fechaFinProvisional">Fecha de Fin Provisional:</label>
    <input type="date" id="fechaFinProvisional" name="fechaFinProvisional" value="<?php echo $convocatoria['fecha_fin_pruebas']; ?>">
    <?php if(isset($errores['fechaFinProvisional'])) { echo $errores['fechaFinProvisional']; } ?>

    <label for="fechaInicioDefinitiva">Fecha de Inicio Definitiva:</label>
    <input type="date" id="fechaInicioDefinitiva" name="fechaInicioDefinitiva" value="<?php echo $convocatoria['fecha_inicio_definitiva']; ?>">
    <?php if(isset($errores['fechaInicioDefinitiva'])) { echo $errores['fechaInicioDefinitiva']; } ?>

    <button type="submit" name="guardar">Guardar</button>
</form>

</body>
</html>
