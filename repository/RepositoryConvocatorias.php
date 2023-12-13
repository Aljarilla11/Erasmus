<?php

require_once 'Db.php';

class RepositoryConvocatoria
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = Db::conectar();
    }

    public function obtenerConvocatorias()
    {
        $sql = "SELECT * FROM convocatorias";
        $result = $this->conexion->query($sql);
        $convocatorias = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $convocatorias[] = $row;
        }
        return $convocatorias;
    }

    public function obtenerConvocatoriaPorId($id)
    {
        $sql = "SELECT * FROM convocatorias WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarConvocatoriaPorId($id, $nuevoMovilidades, $nuevoTipo, $nuevaFechaInicio, $nuevaFechaFin, $nuevaFechaInicioPruebas, $nuevaFechaFinPruebas, $nuevaFechaInicioDefinitiva, $nuevoIdProyecto)
    {
        $sql = "UPDATE convocatorias SET movilidades = :nuevo_movilidades, tipo = :nuevo_tipo, fecha_inicio = :nueva_fecha_inicio, fecha_fin = :nueva_fecha_fin, fecha_inicio_pruebas = :nueva_fecha_inicio_pruebas, fecha_fin_pruebas = :nueva_fecha_fin_pruebas, fecha_inicio_definitiva = :nueva_fecha_inicio_definitiva, id_proyecto = :nuevo_id_proyecto WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nuevo_movilidades', $nuevoMovilidades);
        $stmt->bindParam(':nuevo_tipo', $nuevoTipo);
        $stmt->bindParam(':nueva_fecha_inicio', $nuevaFechaInicio);
        $stmt->bindParam(':nueva_fecha_fin', $nuevaFechaFin);
        $stmt->bindParam(':nueva_fecha_inicio_pruebas', $nuevaFechaInicioPruebas);
        $stmt->bindParam(':nueva_fecha_fin_pruebas', $nuevaFechaFinPruebas);
        $stmt->bindParam(':nueva_fecha_inicio_definitiva', $nuevaFechaInicioDefinitiva);
        $stmt->bindParam(':nuevo_id_proyecto', $nuevoIdProyecto);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function eliminarConvocatoriaPorId($id)
    {
        $sql = "DELETE FROM convocatorias WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

?>
