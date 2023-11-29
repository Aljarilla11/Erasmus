<?php

require_once 'Db.php';

class RepositoryItemBaremo
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = Db::conectar();
    }

    public function obtenerItemsBaremo()
    {
        $sql = "SELECT * FROM item_baremo";
        $result = $this->conexion->query($sql);
        $itemsBaremo = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $itemsBaremo[] = $row;
        }
        return $itemsBaremo;
    }

    public function obtenerItemBaremoPorId($id)
    {
        $sql = "SELECT * FROM item_baremo WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarItemBaremoPorId($id, $nuevoNombre)
    {
        $sql = "UPDATE item_baremo SET nombre = :nuevo_nombre WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nuevo_nombre', $nuevoNombre);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function eliminarItemBaremoPorId($id)
    {
        $sql = "DELETE FROM item_baremo WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

?>
