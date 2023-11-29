<?php

require_once 'Db.php';

class RepositoryCandidatos
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = Db::conectar();
    }

    public function obtenerCandidatos()
    {
        $sql = "SELECT * FROM candidatos";
        $result = $this->conexion->query($sql);
        $candidatos = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $candidatos[] = $row;
        }
        return $candidatos;
    }

    public function obtenerCandidatoPorId($id)
    {
        $sql = "SELECT * FROM candidatos WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarCandidatoPorId($id, $nuevoNombre, $nuevosApellidos, $nuevaFechaNacimiento, $nuevoTelefono, $nuevoCorreo, $nuevoDomicilio, $nuevoCurso, $nuevoIdTutor, $nuevoRol)
    {
        $sql = "UPDATE candidatos SET nombre = :nuevo_nombre, apellidos = :nuevos_apellidos, fecha_nacimiento = :nueva_fecha_nacimiento, telefono = :nuevo_telefono, correo = :nuevo_correo, domicilio = :nuevo_domicilio, curso = :nuevo_curso, id_tutor = :nuevo_id_tutor, rol = :nuevo_rol WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nuevo_nombre', $nuevoNombre);
        $stmt->bindParam(':nuevos_apellidos', $nuevosApellidos);
        $stmt->bindParam(':nueva_fecha_nacimiento', $nuevaFechaNacimiento);
        $stmt->bindParam(':nuevo_telefono', $nuevoTelefono);
        $stmt->bindParam(':nuevo_correo', $nuevoCorreo);
        $stmt->bindParam(':nuevo_domicilio', $nuevoDomicilio);
        $stmt->bindParam(':nuevo_curso', $nuevoCurso);
        $stmt->bindParam(':nuevo_id_tutor', $nuevoIdTutor);
        $stmt->bindParam(':nuevo_rol', $nuevoRol);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function eliminarCandidatoPorId($id)
    {
        $sql = "DELETE FROM candidatos WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

?>