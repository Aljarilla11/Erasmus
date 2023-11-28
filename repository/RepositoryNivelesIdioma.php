<?php

require_once 'Db.php';

class RepositoryNivelesIdioma
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function obtenerNivelesIdioma()
    {
        $sql = "SELECT * FROM niveles_idioma";
        $result = $this->conexion->query($sql);
        $nivelesIdioma = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $nivelesIdioma[] = $row;
        }
        return $nivelesIdioma;
    }

    public function obtenerNivelIdiomaPorId($id)
    {
        $sql = "SELECT * FROM niveles_idioma WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarNivelIdiomaPorId($id, $nuevoNivel)
    {
        $sql = "UPDATE niveles_idioma SET niveles = :nuevo_nivel WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nuevo_nivel', $nuevoNivel);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function eliminarNivelIdiomaPorId($id)
    {
        $sql = "DELETE FROM niveles_idioma WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

?>
