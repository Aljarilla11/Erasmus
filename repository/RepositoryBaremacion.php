<?php

require_once 'Db.php';

class RepositoryBaremacion 
{
    private $conexion;

    public function __construct() {
        $this->conexion = Db::conectar();
    }

    public function obtenerTodasBaremaciones() {
        $sql = "SELECT * FROM baremacion";
        $result = $this->conexion->query($sql);
        $baremaciones = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $baremaciones[] = $row;
        }
        return $baremaciones;
    }

    public function crearBaremacion($idCandidato, $idConvocatoria, $idItemBaremo, $url) {
        // Aquí debes procesar los datos del formulario y realizar la inserción en la base de datos
    
        // Ejemplo de inserción:
        $sql = "INSERT INTO baremacion (id_candidatos, id_convocatoria, id_item_baremo, url,notas) 
                VALUES (:id_candidatos, :id_convocatoria, :id_item_baremo, :url,null)";
        
        $stmt = $this->conexion->prepare($sql);
    
        // Ajusta las siguientes líneas según la estructura real de tu base de datos y el formulario
        $stmt->bindParam(':id_candidatos', $idCandidato);
        $stmt->bindParam(':id_convocatoria', $idConvocatoria);
        $stmt->bindParam(':id_item_baremo', $idItemBaremo);
        $stmt->bindParam(':url', $url);
    
        // Ejecutar la consulta
        $stmt->execute();
    
        // Puedes devolver un mensaje de éxito o el ID de la nueva entrada, según tus necesidades
        return ['success' => true, 'message' => 'Baremación creada con éxito'];
    }

    public function obtenerBaremacionPorId($id) {
        $sql = "SELECT * FROM baremacion WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerBaremacionesPorConvocatoria($idConvocatoria)
    {
        $sql = "SELECT * FROM baremacion WHERE id_convocatoria = :idConvocatoria";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':idConvocatoria', $idConvocatoria, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function actualizarBaremacionPorId($id, $nuevosDatos) {
        $sql = "UPDATE baremacion SET id_candidatos = :id_candidatos, id_convocatoria = :id_convocatoria, id_item_baremo = :id_item_baremo, notas = :notas WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_candidatos', $nuevosDatos['id_candidatos']);
        $stmt->bindParam(':id_convocatoria', $nuevosDatos['id_convocatoria']);
        $stmt->bindParam(':id_item_baremo', $nuevosDatos['id_item_baremo']);
        $stmt->bindParam(':notas', $nuevosDatos['notas']);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function eliminarBaremacionPorId($id) {
        $sql = "DELETE FROM baremacion WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

?>
