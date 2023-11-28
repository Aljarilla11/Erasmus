<?php
class CandidatosConvocatoria 
{
    public $id;
    public $id_convocatoria;
    public $id_candidatos;

    public function __construct($id, $id_convocatoria, $id_candidatos) {
        $this->id = $id;
        $this->id_convocatoria = $id_convocatoria;
        $this->id_candidatos = $id_candidatos;
    }

    // Métodos getter
    public function getId() {
        return $this->id;
    }

    public function getIdConvocatoria() {
        return $this->id_convocatoria;
    }

    public function getIdCandidatos() {
        return $this->id_candidatos;
    }

    // Métodos setter
    public function setId($id) {
        $this->id = $id;
    }

    public function setIdConvocatoria($id_convocatoria) {
        $this->id_convocatoria = $id_convocatoria;
    }

    public function setIdCandidatos($id_candidatos) {
        $this->id_candidatos = $id_candidatos;
    }
}
?>