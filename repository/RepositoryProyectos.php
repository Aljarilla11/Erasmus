<?php

require_once 'Db.php';

class RepositoryProyectos
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function obtenerProyectos()
    {
        $sql = "SELECT * FROM proyectos";
        $result = $this->conexion->query($sql);
        $proyectos = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $proyectos[] = $row;
        }
        return $proyectos;
    }

    public function obtenerProyectoPorId($id)
    {
        $sql = "SELECT * FROM proyectos WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarProyectoPorId($id, $nuevoCodProyecto, $nuevoNombre, $nuevaFechaInicio, $nuevaFechaFin)
    {
        $sql = "UPDATE proyectos SET cod_proyecto = :nuevo_cod_proyecto, nombre = :nuevo_nombre, fecha_inicio = :nueva_fecha_inicio, fecha_fin = :nueva_fecha_fin WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nuevo_cod_proyecto', $nuevoCodProyecto);
        $stmt->bindParam(':nuevo_nombre', $nuevoNombre);
        $stmt->bindParam(':nueva_fecha_inicio', $nuevaFechaInicio);
        $stmt->bindParam(':nueva_fecha_fin', $nuevaFechaFin);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function eliminarProyectoPorId($id)
    {
        $sql = "DELETE FROM proyectos WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

?>
