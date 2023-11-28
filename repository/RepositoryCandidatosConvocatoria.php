<?php

require_once 'Db.php';

class RepositoryCandidatosConvocatoria
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function obtenerCandidatosConvocatoria()
    {
        $sql = "SELECT * FROM candidatos_convocatoria";
        $result = $this->conexion->query($sql);
        $candidatosConvocatoria = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $candidatosConvocatoria[] = $row;
        }
        return $candidatosConvocatoria;
    }

    public function obtenerCandidatoConvocatoriaPorId($id)
    {
        $sql = "SELECT * FROM candidatos_convocatoria WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarCandidatoConvocatoriaPorId($id, $nuevoIdConvocatoria, $nuevoIdCandidato)
    {
        $sql = "UPDATE candidatos_convocatoria SET id_convocatoria = :nuevo_id_convocatoria, id_candidatos = :nuevo_id_candidato WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nuevo_id_convocatoria', $nuevoIdConvocatoria);
        $stmt->bindParam(':nuevo_id_candidato', $nuevoIdCandidato);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function eliminarCandidatoConvocatoriaPorId($id)
    {
        $sql = "DELETE FROM candidatos_convocatoria WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

?>
