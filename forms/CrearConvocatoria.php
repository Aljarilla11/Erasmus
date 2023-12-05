<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['movilidad'], $_POST['tipo'], $_POST['fechaInicio'], $_POST['fechaFin'], $_POST['fechaInicioProvisional'],
    $_POST['fechaFinProvisional'], $_POST['fechaInicioDefinitiva'], $_POST['idProyecto'])) 
{
    $conexion = Db::conectar();

    // Obtener el id_proyecto seleccionado
    $idProyecto = $_POST['idProyecto'];

    // Insertar datos de la convocatoria
    $movilidad = $_POST['movilidad'];
    $tipo = $_POST['tipo'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $fechaInicioProvisional = $_POST['fechaInicioProvisional'];
    $fechaFinProvisional = $_POST['fechaFinProvisional'];
    $fechaInicioDefinitiva = $_POST['fechaInicioDefinitiva'];

    $sqlConvocatoria = "INSERT INTO convocatorias (movilidades, tipo, fecha_inicio, fecha_fin, fecha_inicio_pruebas, fecha_fin_pruebas, fecha_inicio_definitiva, id_proyecto)
                        VALUES (:movilidad, :tipo, :fechaInicio, :fechaFin, :fechaInicioProvisional, :fechaFinProvisional, :fechaInicioDefinitiva, :idProyecto)";

    $statementConvocatoria = $conexion->prepare($sqlConvocatoria);

    $statementConvocatoria->bindParam(':movilidad', $movilidad);
    $statementConvocatoria->bindParam(':tipo', $tipo);
    $statementConvocatoria->bindParam(':fechaInicio', $fechaInicio);
    $statementConvocatoria->bindParam(':fechaFin', $fechaFin);
    $statementConvocatoria->bindParam(':fechaInicioProvisional', $fechaInicioProvisional);
    $statementConvocatoria->bindParam(':fechaFinProvisional', $fechaFinProvisional);
    $statementConvocatoria->bindParam(':fechaInicioDefinitiva', $fechaInicioDefinitiva);
    $statementConvocatoria->bindParam(':idProyecto', $idProyecto);

    if ($statementConvocatoria->execute()) 
    {
        // Obtener el último id insertado
        $idConvocatoria = $conexion->lastInsertId();

        if (isset($_POST['clases'])) {
            $elementosSeleccionados = $_POST['clases'];

            // Iterar sobre los elementos seleccionados y realizar la acción deseada
            foreach ($elementosSeleccionados as $elementoId) {
                $sqlInsert = "INSERT INTO destinatarios_convocatoria (id_convocatoria, id_destinatario) VALUES (:idConvocatoria, :idDestinatario)";
                $statementInsert = $conexion->prepare($sqlInsert);
                $statementInsert->bindParam(':idConvocatoria', $idConvocatoria);
                $statementInsert->bindParam(':idDestinatario', $elementoId);
                $statementInsert->execute();
            }
        }

        // Manejar los elementos del baremo seleccionados
        if (isset($_POST['elementosBaremo'])) {
            $elementosSeleccionados = $_POST['elementosBaremo'];

            foreach ($elementosSeleccionados as $elementoId) {
                // Verificar si el elemento es de idioma (id = 1)
                if ($elementoId == 1) {
                    // Insertar datos en la tabla convocatoria_baremo para elementos que no son de idioma
                    $sqlBaremo = "INSERT INTO convocatoria_baremo (requisito, nota_max, id_baremo, id_convocatoria, valor_minimo, aportalumno)
                                  VALUES (:requisito, :notaMax, :idBaremo, :idConvocatoria, :valorMinimo, :aporteAlumno)";
                    $statementBaremo = $conexion->prepare($sqlBaremo);
            
                    // Obtener los datos de baremo desde el formulario
                    $requisito = isset($_POST['requisitos'][$elementoId]) ? 1 : 0;
                    $notaMax = $_POST['notasMaximas'][$elementoId];
                    $valorMinimo = $_POST['valoresMinimos'][$elementoId];
                    $aporteAlumno = isset($_POST['aportesAlumno'][$elementoId]) ? 1 : 0;
            
                    // Insertar datos en convocatoria_baremo
                    $statementBaremo->bindParam(':requisito', $requisito, PDO::PARAM_BOOL);
                    $statementBaremo->bindParam(':notaMax', $notaMax);
                    $statementBaremo->bindParam(':idBaremo', $elementoId);
                    $statementBaremo->bindParam(':idConvocatoria', $idConvocatoria);
                    $statementBaremo->bindParam(':valorMinimo', $valorMinimo);
                    $statementBaremo->bindParam(':aporteAlumno', $aporteAlumno, PDO::PARAM_BOOL);
                    $statementBaremo->execute();
            
                    // Insertar datos en la tabla convocatoria_baremo_idioma
                    $sqlBaremoIdioma = "INSERT INTO convocatoria_baremo_idioma (valor, id_niveles_idioma, id_convocatoria_baremo)
                                        VALUES (:valor, :idNivelesIdioma, :idConvocatoriaBaremo)";
                    $statementBaremoIdioma = $conexion->prepare($sqlBaremoIdioma);
            
                    $nivelesIdioma = isset($_POST['nivelesIdioma'][$elementoId]) ? $_POST['nivelesIdioma'][$elementoId] : [];


                    $sqlObtenerIdConvocatoriaBaremo = "SELECT id FROM convocatoria_baremo WHERE id_baremo = 1 ORDER BY id DESC LIMIT 1";
                    $statementObtenerIdConvocatoriaBaremo = $conexion->prepare($sqlObtenerIdConvocatoriaBaremo);
                    $statementObtenerIdConvocatoriaBaremo->execute();

                    $fila = $statementObtenerIdConvocatoriaBaremo->fetch(PDO::FETCH_ASSOC);
                    $idConvocatoriaBaremo = $fila['id'];
                    

                // Verificar si $nivelesIdioma es un array antes de iterar
                if (is_array($nivelesIdioma)) {
                
                    foreach ($nivelesIdioma as $nivel => $valor) {
                        $idNivelesIdioma = obtenerIdNivelesIdioma($nivel);
                        
                        // Insertar datos en convocatoria_baremo_idioma
                        $statementBaremoIdioma->bindParam(':valor', $valor);
                        $statementBaremoIdioma->bindParam(':idNivelesIdioma', $idNivelesIdioma);
                        $statementBaremoIdioma->bindParam(':idConvocatoriaBaremo', $idConvocatoriaBaremo);
                        $statementBaremoIdioma->execute();
                    }
                }
                } else {
                    // Insertar datos en la tabla convocatoria_baremo para elementos que no son de idioma
                    $sqlBaremo = "INSERT INTO convocatoria_baremo (requisito, nota_max, id_baremo, id_convocatoria, valor_minimo, aportalumno)
                                  VALUES (:requisito, :notaMax, :idBaremo, :idConvocatoria, :valorMinimo, :aporteAlumno)";
                    $statementBaremo = $conexion->prepare($sqlBaremo);
            
                    // Obtener los datos de baremo desde el formulario
                    $requisito = isset($_POST['requisitos'][$elementoId]) ? 1 : 0;
                    $notaMax = $_POST['notasMaximas'][$elementoId];
                    $valorMinimo = $_POST['valoresMinimos'][$elementoId];
                    $aporteAlumno = isset($_POST['aportesAlumno'][$elementoId]) ? 1 : 0;
            
                    // Insertar datos en convocatoria_baremo
                    $statementBaremo->bindParam(':requisito', $requisito, PDO::PARAM_BOOL);
                    $statementBaremo->bindParam(':notaMax', $notaMax);
                    $statementBaremo->bindParam(':idBaremo', $elementoId);
                    $statementBaremo->bindParam(':idConvocatoria', $idConvocatoria);
                    $statementBaremo->bindParam(':valorMinimo', $valorMinimo);
                    $statementBaremo->bindParam(':aporteAlumno', $aporteAlumno, PDO::PARAM_BOOL);
                    $statementBaremo->execute();
                }
            }
    }
        echo "Convocatoria creada exitosamente";
    } 
    else 
    {
        echo "Error al crear la convocatoria: " . $statementConvocatoria->errorInfo()[2];
    }

    // Cerrar la conexión
    $conexion = null;
}

function obtenerIdNivelesIdioma($nivel) 
{
    $conexion = Db::conectar(); // Asegúrate de tener una función Db::conectar() que devuelva una conexión PDO válida

    // Consulta para obtener el ID del nivel de idioma según el nombre
    $sql = "SELECT id FROM niveles_idioma WHERE niveles = :nivel";
    $statement = $conexion->prepare($sql);
    $statement->bindParam(':nivel', $nivel);
    $statement->execute();

    // Obtener el resultado de la consulta
    $resultado = $statement->fetch(PDO::FETCH_ASSOC);

    // Cerrar la conexión
    $conexion = null;

    // Devolver el ID del nivel de idioma (o false si no se encuentra)
    return $resultado ? $resultado['id'] : false;
}

$conexion = Db::conectar();
$sqlProyectos = "SELECT id, nombre FROM proyectos";
$resultadoProyectos = $conexion->query($sqlProyectos);
$proyectos = $resultadoProyectos->fetchAll(PDO::FETCH_ASSOC);

$sqlClases = "SELECT cod_grupo, nombre FROM destinatarios";
$resultadoClases = $conexion->query($sqlClases);
$clases = $resultadoClases->fetchAll(PDO::FETCH_ASSOC);

$sqlElementosBaremo = "SELECT id, nombre FROM item_baremo";
$resultadoElementosBaremo = $conexion->query($sqlElementosBaremo);
$elementosBaremo = $resultadoElementosBaremo->fetchAll(PDO::FETCH_ASSOC);
$conexion = null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Convocatorias</title>
    <style>
        label { display: block; margin-bottom: 8px; }
        .campos-especiales table { margin-top: 10px; border-collapse: collapse; }
        .campos-especiales th, .campos-especiales td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    </style>
    <script src="../js/CheckBoxDestinatarios.js"></script>
</head>
<body>

    <h1>Formulario de Convocatorias</h1>

    <form id="convocatoriaForm" method="post" action="">

        <label for="idProyecto">Proyecto:</label>
        <select id="idProyecto" name="idProyecto">
            <?php foreach ($proyectos as $proyecto): ?>
                <option value="<?php echo $proyecto['id']; ?>"><?php echo $proyecto['nombre']; ?></option>
            <?php endforeach; ?>
        </select>

        <label>Clases (Destinatarios):</label>
        <ul>
            <?php foreach ($clases as $clase): ?>
                <li>
                    <label for="clase_<?php echo $clase['cod_grupo']; ?>"><?php echo $clase['nombre']; ?></label>
                    <input type="checkbox" id="clase_<?php echo $clase['cod_grupo']; ?>" name="clases[]" value="<?php echo $clase['cod_grupo']; ?>">
                </li>
            <?php endforeach; ?>
        </ul>

        <button type="button" onclick="marcarTodos()">Marcar Todos</button>
        <button type="button" onclick="desmarcarTodos()">Desmarcar Todos</button>

        <label>Elementos de Baremo:</label>
        <ul>
            <?php foreach ($elementosBaremo as $elemento): ?>
                <li>
                    <label for="elemento_<?php echo $elemento['id']; ?>"><?php echo $elemento['nombre']; ?></label>
                    <input type="checkbox" id="elemento_<?php echo $elemento['id']; ?>" name="elementosBaremo[]" value="<?php echo $elemento['id']; ?>" onchange="mostrarRequisitos()">
                    <div class="requisitos-campos" id="requisitos_<?php echo $elemento['id']; ?>" style="display: none;">
                        <label for="requisito_<?php echo $elemento['id']; ?>">Requisito:</label>
                        <input type="checkbox" id="requisito_<?php echo $elemento['id']; ?>" name="requisitos[<?php echo $elemento['id']; ?>]">
                        <label for="notaMaxima_<?php echo $elemento['id']; ?>">Nota Máxima:</label>
                        <input type="text" id="notaMaxima_<?php echo $elemento['id']; ?>" name="notasMaximas[<?php echo $elemento['id']; ?>]">
                        <label for="valorMinimo_<?php echo $elemento['id']; ?>">Valor Mínimo:</label>
                        <input type="text" id="valorMinimo_<?php echo $elemento['id']; ?>" name="valoresMinimos[<?php echo $elemento['id']; ?>]">
                        <label for="aporteAlumno_<?php echo $elemento['id']; ?>">Aporte Alumno:</label>
                        <input type="checkbox" id="aporteAlumno_<?php echo $elemento['id']; ?>" name="aportesAlumno[<?php echo $elemento['id']; ?>]">
                    </div>
                    <div id="camposEspeciales_<?php echo $elemento['id']; ?>" class="campos-especiales" style="display: none;">
    <table>
        <tbody>
            <tr>
                <td>A1</td>
                <td><td><input type="text" id="nivelA2_<?php echo $elemento['id']; ?>" name="nivelesIdioma[<?php echo $elemento['id']; ?>][A1]"></td></td>
            </tr>
            <tr>
                <td>A2</td>
                <td><td><input type="text" id="nivelA2_<?php echo $elemento['id']; ?>" name="nivelesIdioma[<?php echo $elemento['id']; ?>][A2]"></td></td>
            </tr>
            <tr>
                <td>B1</td>
                <td><td><input type="text" id="nivelA2_<?php echo $elemento['id']; ?>" name="nivelesIdioma[<?php echo $elemento['id']; ?>][B1]"></td></td>
            </tr>
            <tr>
                <td>B2</td>
                <td><td><input type="text" id="nivelA2_<?php echo $elemento['id']; ?>" name="nivelesIdioma[<?php echo $elemento['id']; ?>][B2]"></td></td>
            </tr>
            <tr>
                <td>C1</td>
                <td><td><input type="text" id="nivelA2_<?php echo $elemento['id']; ?>" name="nivelesIdioma[<?php echo $elemento['id']; ?>][C1]"></td></td>
            </tr>
            <tr>
                <td>C2</td>
                <td><td><input type="text" id="nivelA2_<?php echo $elemento['id']; ?>" name="nivelesIdioma[<?php echo $elemento['id']; ?>][C2]"></td></td>
            </tr>
        </tbody>
    </table>
</div>
                </li>
            <?php endforeach; ?>
        </ul>

        <button type="button" onclick="marcarTodosBaremo()">Marcar Todos</button>
        <button type="button" onclick="desmarcarTodosBaremo()">Desmarcar Todos</button>

        <label for="movilidad">Movilidad:</label>
        <input type="text" id="movilidad" name="movilidad" required>

        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo">
            <option value="larga">Larga</option>
            <option value="corta">Corta</option>
        </select>

        <label for="fechaInicio">Fecha de Inicio:</label>
        <input type="date" id="fechaInicio" name="fechaInicio">

        <label for="fechaFin">Fecha de Fin:</label>
        <input type="date" id="fechaFin" name="fechaFin">

        <label for="fechaInicioProvisional">Fecha de Inicio Provisional:</label>
        <input type="date" id="fechaInicioProvisional" name="fechaInicioProvisional">

        <label for="fechaFinProvisional">Fecha de Fin Provisional:</label>
        <input type="date" id="fechaFinProvisional" name="fechaFinProvisional">

        <label for="fechaInicioDefinitiva">Fecha de Inicio Definitiva:</label>
        <input type="date" id="fechaInicioDefinitiva" name="fechaInicioDefinitiva">

        <button type="submit">Crear Convocatoria</button>
    </form>
</body>
</html>
