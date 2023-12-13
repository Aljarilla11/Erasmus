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
                    INNER JOIN proyectos p ON c.id_proyecto = p.id LIMIT 1";

$resultadoConvocatorias = $conexion->query($sqlConvocatorias);
$convocatorias = $resultadoConvocatorias->fetchAll(PDO::FETCH_ASSOC);

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

    <h1>Convocatorias Solicitadas</h1>

    <?php foreach ($convocatorias as $convocatoria): ?>
        <div class="listconvocatorias">
            <h2>Beca Erasmus 2023</h2>
            <p><strong>Proyecto:</strong> <?php echo $convocatoria['nombre_proyecto']; ?></p>
            <p><strong>Tipo:</strong> <?php echo $convocatoria['tipo']; ?></p>
            <p><strong>Fecha de Inicio:</strong> <?php echo $convocatoria['fecha_inicio']; ?></p>
            <p><strong>Fecha de Fin:</strong> <?php echo $convocatoria['fecha_fin']; ?></p>
            <p><strong>Fecha de Inicio Pruebas:</strong> <?php echo $convocatoria['fecha_inicio_pruebas']; ?></p>
            <p><strong>Fecha de Fin Pruebas:</strong> <?php echo $convocatoria['fecha_fin_pruebas']; ?></p>
            <p><strong>Fecha de Inicio Definitiva:</strong> <?php echo $convocatoria['fecha_inicio_definitiva']; ?></p> 
            <h3 id="estado">Pendiente</h3>     
        </div>
        <hr>
    <?php endforeach; ?>

</body>
</html>