<?php

require_once 'Db.php';

class RepositoryConvocatoriaBaremoIdiomas
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function obtenerConvocatoriaBaremoIdiomas()
    {
        $sql = "SELECT * FROM convocatoria_baremo_idiomas";
        $result = $this->conexion->query($sql);
        $convocatoriaBaremoIdiomas = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $convocatoriaBaremoIdiomas[] = $row;
        }
        return $convocatoriaBaremoIdiomas;
    }

    public function obtenerConvocatoriaBaremoIdiomasPorId($id)
    {
        $sql = "SELECT * FROM convocatoria_baremo_idiomas WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editarConvocatoriaBaremoIdiomasPorId($id, $nuevoValor, $nuevoIdNivelesIdioma, $nuevoIdConvocatoriaBaremo)
    {
        $sql = "UPDATE convocatoria_baremo_idiomas SET valor = :nuevo_valor, id_niveles_idioma = :nuevo_id_niveles_idioma, id_convocatoria_baremo = :nuevo_id_convocatoria_baremo WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nuevo_valor', $nuevoValor);
        $stmt->bindParam(':nuevo_id_niveles_idioma', $nuevoIdNivelesIdioma);
        $stmt->bindParam(':nuevo_id_convocatoria_baremo', $nuevoIdConvocatoriaBaremo);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function eliminarConvocatoriaBaremoIdiomasPorId($id)
    {
        $sql = "DELETE FROM convocatoria_baremo_idiomas WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

?>
