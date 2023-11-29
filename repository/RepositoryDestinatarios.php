<?php

require_once 'Db.php';

class RepositoryDestinatarios
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = Db::conectar();
    }

    public function obtenerDestinatarios()
    {
        $sql = "SELECT * FROM destinatarios";
        $result = $this->conexion->query($sql);
        $destinatarios = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $destinatarios[] = $row;
        }
        return $destinatarios;
    }

    public function obtenerDestinatarioPorId($id)
    {
        $sql = "SELECT * FROM destinatarios WHERE cod_grupo = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarDestinatarioPorId($id, $nuevoNombre)
    {
        $sql = "UPDATE destinatarios SET nombre = :nuevo_nombre WHERE cod_grupo = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nuevo_nombre', $nuevoNombre);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function eliminarDestinatarioPorId($id)
    {
        $sql = "DELETE FROM destinatarios WHERE cod_grupo = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

?>
