<?php
$idConvocatoria = isset($_GET['idConvoctoria']) ? $_GET['idConvoctoria'] : null;
        $conexion = Db::conectar();
                $query = "SELECT * FROM convocatorias WHERE id = :idConvocatoria";
                $stmt = $conexion->prepare($query);
                $stmt->bindParam(':idConvocatoria', $idConvocatoria);
                $stmt->execute();
                $convocatoria = $stmt->fetch(PDO::FETCH_ASSOC);

                // Cerrar la conexión
                $conexion = null;

                ?>
                <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Editar Convocatoria</title>
            </head>
            <body>

            <h1>Editar Convocatoria</h1>

            <form id="convocatoriaForm" method="post" action="">

                <label for="movilidad">Movilidad:</label>
                <input type="text" id="movilidad" name="movilidad" value="<?php echo $convocatoria['movilidades']; ?>" required>
                <?php if(isset($errores['movilidad'])) { echo $errores['movilidades']; } ?>

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

                <label for="idProyecto">Proyecto:</label>
                <select id="idProyecto" name="idProyecto">
                    <?php foreach ($proyectos as $proyecto): ?>
                        <option value="<?php echo $proyecto['id']; ?>" <?php echo ($convocatoria['id_proyecto'] == $proyecto['id']) ? 'selected' : ''; ?>><?php echo $proyecto['nombre']; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="guardar">Guardar</button>
                </form>
            