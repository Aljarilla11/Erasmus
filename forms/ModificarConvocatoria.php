<?php
$conexion = Db::conectar();
$sqlConvocatorias = "SELECT c.id, c.movilidades, c.tipo, c.fecha_inicio, c.fecha_fin, c.fecha_inicio_pruebas, c.fecha_fin_pruebas, c.fecha_inicio_definitiva, p.nombre as nombre_proyecto
                    FROM convocatorias c
                    INNER JOIN proyectos p ON c.id_proyecto = p.id";

$resultadoConvocatorias = $conexion->query($sqlConvocatorias);
$convocatorias = $resultadoConvocatorias->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $idConvocatoria = $_POST['idConvocatoria'];

        switch ($_POST['action']) {
            case 'modificar':
                header("Location: ?menu=editarconvocatoria&idConvoctoria=$idConvocatoria");
                exit();
                break;
            case 'eliminar':
                    $conexion = Db::conectar();
                
                    // Inicia una transacción para asegurar la integridad de los datos
                    $conexion->beginTransaction();
                
                    // Elimina registros de la tabla Convocatoria
                    $sqlDeleteConvocatoria = "DELETE FROM convocatorias WHERE id = :idConvocatoria";
                    $stmtDeleteConvocatoria = $conexion->prepare($sqlDeleteConvocatoria);
                    $stmtDeleteConvocatoria->bindParam(':idConvocatoria', $idConvocatoria, PDO::PARAM_INT);
                    $stmtDeleteConvocatoria->execute();

                    // Confirma la transacción si todas las operaciones fueron exitosas
                    $conexion->commit();
                
                    // Cierra la conexión
                    $conexion = null;
                    
                    echo "Operación exitosa: Convocatoria y relacionados eliminados.";
                
                break;
            default:
                // Acción no reconocida
                break;
        }

        // Redirige a la página actual para evitar envíos de formulario repetidos
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
    <!-- Agrega el enlace a tu archivo de estilos -->
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