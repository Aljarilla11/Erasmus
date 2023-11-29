<?php

require_once 'Db.php';

class RepositoryTutor
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = Db::conectar();
    }

    public function obtenerTutores()
    {
        $sql = "SELECT * FROM tutor";
        $result = $this->conexion->query($sql);
        $tutores = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $tutores[] = $row;
        }
        return $tutores;
    }

    public function obtenerTutorPorId($id)
    {
        $sql = "SELECT * FROM tutor WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarTutorPorId($id, $nuevoDni, $nuevoNombre, $nuevoApellidos, $nuevoTelefono, $nuevoDomicilio)
    {
        $sql = "UPDATE tutor SET dni = :nuevo_dni, nombre = :nuevo_nombre, apellidos = :nuevo_apellidos, telefono = :nuevo_telefono, domicilio = :nuevo_domicilio WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nuevo_dni', $nuevoDni);
        $stmt->bindParam(':nuevo_nombre', $nuevoNombre);
        $stmt->bindParam(':nuevo_apellidos', $nuevoApellidos);
        $stmt->bindParam(':nuevo_telefono', $nuevoTelefono);
        $stmt->bindParam(':nuevo_domicilio', $nuevoDomicilio);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function eliminarTutorPorId($id)
    {
        $sql = "DELETE FROM tutor WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

?>
