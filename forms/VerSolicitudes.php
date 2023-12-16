<?php
try {
    // Consulta preparada para obtener el rol del usuario por su nombre
    $conexion = Db::conectar();
    $query = "SELECT rol FROM candidatos WHERE dni = :dni";
    $statement = $conexion->prepare($query);

    $statement->bindParam(':dni', $_SESSION['usuario'], PDO::PARAM_STR);
    $statement->execute();

    // Obtener el resultado de la consulta
    $resultado = $statement->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $rolUsuario = $resultado['rol'];
    } else {
        $rolUsuario = 'sinRol'; // Establece un valor predeterminado si el usuario no tiene un rol
    }
} catch (PDOException $e) {
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

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convocatorias Solicitadas</title>
    <link rel="stylesheet" href="../estilos/estiloListarConvocatorias.css">
    <script src="../js/VerSolicitudes.js"></script>
</head>
<body>
    <h1>Convocatorias Solicitadas</h1>

    <!-- Contenedor para todas las convocatorias -->
    <div id="convocatoriasContainer"></div>

</body>
</html>