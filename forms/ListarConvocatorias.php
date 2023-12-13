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

// Obtener convocatorias desde la base de datos
$conexion = Db::conectar();
$sqlConvocatorias = "SELECT c.id, c.movilidades, c.tipo, c.fecha_inicio, c.fecha_fin, c.fecha_inicio_pruebas, c.fecha_fin_pruebas, c.fecha_inicio_definitiva, p.nombre as nombre_proyecto
                    FROM convocatorias c
                    INNER JOIN proyectos p ON c.id_proyecto = p.id";

$resultadoConvocatorias = $conexion->query($sqlConvocatorias);
$convocatorias = $resultadoConvocatorias->fetchAll(PDO::FETCH_ASSOC);


$dni = Sesion::leerSesion('usuario');

$sql = "SELECT id FROM candidatos WHERE dni = :dni";
$statement = $conexion->prepare($sql);
$statement->bindParam(':dni', $dni, PDO::PARAM_STR);
$statement->execute();

$resultado = $statement->fetch(PDO::FETCH_ASSOC);

$conexion = null;

if ($resultado) {
    $idCandidato = $resultado['id'];
} else {
    // No se encontró ningún candidato con el DNI proporcionado
    echo "Candidato no encontrado";
}


if (isset($_POST['idConvocatoria']) && is_numeric($_POST['idConvocatoria'])) {
    // Obtener el ID de convocatoria desde el formulario
    $idConvocatoria = $_POST['idConvocatoria'];

    // Aquí puedes realizar cualquier lógica adicional para manejar la solicitud según tus necesidades

    // Redireccionar a la nueva página "Solicitud" con un encabezado personalizado
    header("Location: ?menu=solicitarconvocatoria&idConvocatoria=$idConvocatoria&id=$idCandidato");
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