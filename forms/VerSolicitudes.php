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

$dni = Sesion::leerSesion('usuario');

$sql = "SELECT id FROM candidatos WHERE dni = :dni";
$statement = $conexion->prepare($sql);
$statement->bindParam(':dni', $dni, PDO::PARAM_STR);
$statement->execute();

$resultado = $statement->fetch(PDO::FETCH_ASSOC);

if ($resultado) {
    $idCandidato = $resultado['id'];

    // Consultar las convocatorias asociadas al alumno desde la tabla candidatos_convocatoria
    $sqlConvocatoriasAlumno = "SELECT c.id, c.movilidades, c.tipo, c.fecha_inicio, c.fecha_fin, c.fecha_inicio_pruebas, c.fecha_fin_pruebas, c.fecha_inicio_definitiva, p.nombre as nombre_proyecto
                                FROM convocatorias c
                                INNER JOIN proyectos p ON c.id_proyecto = p.id
                                INNER JOIN candidatos_convocatoria cc ON c.id = cc.id_convocatoria
                                WHERE cc.id_candidatos = :idCandidato";

    $statementConvocatorias = $conexion->prepare($sqlConvocatoriasAlumno);
    $statementConvocatorias->bindParam(':idCandidato', $idCandidato, PDO::PARAM_INT);
    $statementConvocatorias->execute();

    $convocatorias = $statementConvocatorias->fetchAll(PDO::FETCH_ASSOC);
} else {
    // No se encontró ningún candidato con el DNI proporcionado
    echo "Candidato no encontrado";
    $convocatorias = []; // Inicializar como un array vacío para evitar errores
}

$conexion = null;
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
            <p><strong>Proyecto:</strong> <?= $convocatoria['nombre_proyecto'] ?></p>
            <p><strong>Tipo:</strong> <?= $convocatoria['tipo'] ?></p>
            <p><strong>Fecha de Inicio:</strong> <?= $convocatoria['fecha_inicio'] ?></p>
            <p><strong>Fecha de Fin:</strong> <?= $convocatoria['fecha_fin'] ?></p>
            <p><strong>Fecha de Inicio Pruebas:</strong> <?= $convocatoria['fecha_inicio_pruebas'] ?></p>
            <p><strong>Fecha de Fin Pruebas:</strong> <?= $convocatoria['fecha_fin_pruebas'] ?></p>
            <p><strong>Fecha de Inicio Definitiva:</strong> <?= $convocatoria['fecha_inicio_definitiva'] ?></p> 
            <h3 id="estado">Pendiente</h3>     
        </div>
        <hr>
    <?php endforeach; ?>

</body>
</html>
