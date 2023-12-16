<?php

require_once 'Db.php';

class RepositoryCandidatosConvocatoria
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = Db::conectar();
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

    public function agregarCandidatoConvocatoria($idConvocatoria, $idCandidatos)
    {
        try {
            $query = "INSERT INTO candidatos_convocatoria (id_convocatoria, id_candidatos) VALUES (:idConvocatoria, :idCandidato)";
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(':idConvocatoria', $idConvocatoria, PDO::PARAM_INT);
            $statement->bindParam(':idCandidato', $idCandidatos, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $e) {
            throw new Exception('Error al agregar candidato a la convocatoria: ' . $e->getMessage());
        }
    }

    public function obtenerIdConvocatoriasPorCandidato($idCandidato)
    {
        try {
            $query = "SELECT id_convocatoria FROM candidatos_convocatoria WHERE id_candidatos = :idCandidato";
            $statement = $this->conexion->prepare($query);
            $statement->bindParam(':idCandidato', $idCandidato, PDO::PARAM_INT);
            $statement->execute();

            $resultados = $statement->fetchAll(PDO::FETCH_ASSOC);

            $idConvocatorias = array_column($resultados, 'id_convocatoria');

            return $idConvocatorias;
        } catch (PDOException $e) {
            throw new Exception('Error en la base de datos: ' . $e->getMessage());
        }
    }

    public function obtenerCandidatosConvocatoriaPorConvocatoria($idConvocatoria)
    {
        $sql = "SELECT * FROM candidatos_convocatoria WHERE id_convocatoria = :idConvocatoria";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':idConvocatoria', $idConvocatoria, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
