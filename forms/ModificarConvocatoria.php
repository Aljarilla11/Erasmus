<?php
try 
{
    $conexion = Db::conectar();
    $query = "SELECT rol FROM candidatos WHERE dni = :dni";
    $statement = $conexion->prepare($query);

    $statement->bindParam(':dni', $_SESSION['usuario'], PDO::PARAM_STR);
    $statement->execute();
    $resultado = $statement->fetch(PDO::FETCH_ASSOC);

    if ($resultado) 
    {
        $rolUsuario = $resultado['rol'];
    } 
    else
    {
        $rolUsuario = 'sinRol';
    }
} 
catch (PDOException $e) 
{
    $rolUsuario = 'sinRol';
}


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

$conexion = Db::conectar();
$sqlConvocatorias = "SELECT c.id, c.movilidades, c.tipo, c.fecha_inicio, c.fecha_fin, c.fecha_inicio_pruebas, c.fecha_fin_pruebas, c.fecha_inicio_definitiva, p.nombre as nombre_proyecto
                    FROM convocatorias c
                    INNER JOIN proyectos p ON c.id_proyecto = p.id";

$sqlConvocatorias = "SELECT c.id, c.movilidades, c.tipo, c.fecha_inicio, c.fecha_fin, c.fecha_inicio_pruebas, c.fecha_fin_pruebas, c.fecha_inicio_definitiva, p.nombre as nombre_proyecto
FROM convocatorias c
INNER JOIN proyectos p ON c.id_proyecto = p.id";

$resultadoConvocatorias = $conexion->query($sqlConvocatorias);
$convocatorias = $resultadoConvocatorias->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    if (isset($_POST['action'])) 
    {
        $idConvocatoria = $_POST['idConvocatoria'];

        switch ($_POST['action']) 
        {
            case 'modificar':
                header("Location: ?menu=editarconvocatoria&idConvoctoria=$idConvocatoria");
                exit();
                break;
            case 'eliminar':
                    $conexion = Db::conectar();
                
                    $conexion->beginTransaction();
                    $sqlDeleteConvocatoria = "DELETE FROM convocatorias WHERE id = :idConvocatoria";
                    $stmtDeleteConvocatoria = $conexion->prepare($sqlDeleteConvocatoria);
                    $stmtDeleteConvocatoria->bindParam(':idConvocatoria', $idConvocatoria, PDO::PARAM_INT);
                    $stmtDeleteConvocatoria->execute();
                    $conexion->commit();
                    $conexion = null;
                    
                    echo "Operación exitosa: Convocatoria y relacionados eliminados.";
                
                break;
            default:
                break;
        }

        header("Location: ?menu=modificarconvocatoria");
        exit();
    }
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

    <table class="listconvocatorias">
        <thead>
            <tr>
                <th>Movilidades</th>
                <th>Proyecto</th>
                <th>Tipo</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Fecha de Inicio Pruebas</th>
                <th>Fecha de Fin Pruebas</th>
                <th>Fecha de Inicio Definitiva</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php

        ?>
            <?php foreach ($convocatorias as $convocatoria): ?>
                <tr>
                    <td><?php echo $convocatoria['movilidades'] . " Plazas"; ?></td>
                    <td><?php echo $convocatoria['nombre_proyecto']; ?></td>
                    <td><?php echo $convocatoria['tipo']; ?></td>
                    <td><?php echo $convocatoria['fecha_inicio']; ?></td>
                    <td><?php echo $convocatoria['fecha_fin']; ?></td>
                    <td><?php echo $convocatoria['fecha_inicio_pruebas']; ?></td>
                    <td><?php echo $convocatoria['fecha_fin_pruebas']; ?></td>
                    <td><?php echo $convocatoria['fecha_inicio_definitiva']; ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="idConvocatoria" value="<?php echo $convocatoria['id']; ?>">
                            <button type="submit" name="action" value="modificar">Modificar</button>
                            <button type="submit" name="action" value="eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>