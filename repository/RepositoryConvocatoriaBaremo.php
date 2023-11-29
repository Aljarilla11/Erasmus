<?php

require_once 'Db.php';

class RepositoryConvocatoriaBaremo
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = Db::conectar();
    }

    public function obtenerConvocatoriaBaremaciones()
    {
        $sql = "SELECT * FROM convocatoria_baremo";
        $result = $this->conexion->query($sql);
        $convocatoriaBaremaciones = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $convocatoriaBaremaciones[] = $row;
        }
        return $convocatoriaBaremaciones;
    }

    public function obtenerConvocatoriaBaremoPorId($id)
    {
        $sql = "SELECT * FROM convocatoria_baremo WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarConvocatoriaBaremoPorId($id, $nuevoRequisito, $nuevaNotaMax, $nuevoIdBaremo, $nuevaIdConvocatoria, $nuevoValorMinimo)
    {
        $sql = "UPDATE convocatoria_baremo SET requisito = :nuevo_requisito, nota_max = :nueva_nota_max, id_baremo = :nuevo_id_baremo, id_convocatoria = :nueva_id_convocatoria, valor_minimo = :nuevo_valor_minimo WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nuevo_requisito', $nuevoRequisito);
        $stmt->bindParam(':nueva_nota_max', $nuevaNotaMax);
        $stmt->bindParam(':nuevo_id_baremo', $nuevoIdBaremo);
        $stmt->bindParam(':nueva_id_convocatoria', $nuevaIdConvocatoria);
        $stmt->bindParam(':nuevo_valor_minimo', $nuevoValorMinimo);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function eliminarConvocatoriaBaremoPorId($id)
    {
        $sql = "DELETE FROM convocatoria_baremo WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

?>
