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
if (isset($_GET['idConvocatoria'])) {
    // Obtener el valor de idConvocatoria desde la URL
    $idConvocatoria = $_GET['idConvocatoria'];
}

$conexion = Db::conectar();
// Procesar la nota si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nota'])) {
    // Obtén el ID de la baremación y la nota desde el formulario
    $idBaremacion = $_POST['idBaremacion'];
    $nota = $_POST['nota'];

    // Validar la nota (puedes agregar más validaciones según tus requisitos)
    if (!is_numeric($nota)) {
        echo "La nota debe ser un número válido.";
        exit;
    }

    // Actualiza la base de datos con la nota
    try {
        $conexion = Db::conectar();
        $sql = "UPDATE baremacion SET notas = :nota WHERE id = :idBaremacion";
        $statement = $conexion->prepare($sql);
        $statement->bindParam(':nota', $nota, PDO::PARAM_STR);
        $statement->bindParam(':idBaremacion', $idBaremacion, PDO::PARAM_INT);
        $statement->execute();
    } catch (PDOException $e) {
        echo "Error al actualizar la nota: " . $e->getMessage();
    }
}

// Continuación del código para mostrar la información de la baremación...

// Obtener los resultados
$sql = "SELECT * FROM baremacion WHERE id_convocatoria = :idConvocatoria";
$statement = $conexion->prepare($sql);
$statement->bindParam(':idConvocatoria', $idConvocatoria, PDO::PARAM_INT);
$statement->execute();
$resultadosBaremacion = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Baremación</title>
    <link rel="stylesheet" href="../estilos/estiloResultadoBaremacion.css">
</head>
<body>

    <h1>Resultados de Baremación</h1>

    <?php foreach ($resultadosBaremacion as $resultado): ?>
        <div class="resultadoBaremacion">
            <h2>ID: <?php echo $resultado['id']; ?></h2>
            <p><strong>Notas:</strong> <?php echo $resultado['notas']; ?></p>
            <p><strong>URL:</strong> <?php echo $resultado['url']; ?></p>
            
            <!-- Mostrar el PDF en el navegador -->
            <iframe src="C:\xampp\htdocs\Erasmus\pdf<?php echo urlencode($resultado['url']); ?>" width="600" height="400"></iframe>

            <!-- Formulario para poner nota -->
            <form action="" method="post">
                <input type="hidden" name="idBaremacion" value="<?php echo $resultado['id']; ?>">
                <input type="text" name="nota" placeholder="Ingrese la nota">
                <button type="submit">Poner Nota</button>
            </form>
        </div>
        <hr>
    <?php endforeach; ?>

</body>
</html>