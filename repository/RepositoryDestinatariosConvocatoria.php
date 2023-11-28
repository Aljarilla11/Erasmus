<?php

require_once 'Db.php';

class RepositoryDestinatariosConvocatoria
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function obtenerDestinatariosConvocatoria()
    {
        $sql = "SELECT * FROM destinatarios_convocatoria";
        $result = $this->conexion->query($sql);
        $destinatariosConvocatoria = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $destinatariosConvocatoria[] = $row;
        }
        return $destinatariosConvocatoria;
    }

    public function obtenerDestinatarioConvocatoriaPorId($id)
    {
        $sql = "SELECT * FROM destinatarios_convocatoria WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarDestinatarioConvocatoriaPorId($id, $nuevoIdConvocatoria, $nuevoIdDestinatario)
    {
        $sql = "UPDATE destinatarios_convocatoria SET id_convocatoria = :nuevo_id_convocatoria, id_destinatario = :nuevo_id_destinatario WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nuevo_id_convocatoria', $nuevoIdConvocatoria);
        $stmt->bindParam(':nuevo_id_destinatario', $nuevoIdDestinatario);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function eliminarDestinatarioConvocatoriaPorId($id)
    {
        $sql = "DELETE FROM destinatarios_convocatoria WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

?>
