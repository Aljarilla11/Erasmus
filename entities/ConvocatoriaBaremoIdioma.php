<?php
class ConvocatoriaBaremoIdioma 
{
    public $id;
    public $valor;
    public $id_niveles_idioma;
    public $id_convocatoria_baremo;

    public function __construct($id, $valor, $id_niveles_idioma, $id_convocatoria_baremo) {
        $this->id = $id;
        $this->valor = $valor;
        $this->id_niveles_idioma = $id_niveles_idioma;
        $this->id_convocatoria_baremo = $id_convocatoria_baremo;
    }

    // Métodos getter
    public function getId() {
        return $this->id;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getIdNivelesIdioma() {
        return $this->id_niveles_idioma;
    }

    public function getIdConvocatoriaBaremo() {
        return $this->id_convocatoria_baremo;
    }

    // Métodos setter
    public function setId($id) {
        $this->id = $id;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function setIdNivelesIdioma($id_niveles_idioma) {
        $this->id_niveles_idioma = $id_niveles_idioma;
    }

    public function setIdConvocatoriaBaremo($id_convocatoria_baremo) {
        $this->id_convocatoria_baremo = $id_convocatoria_baremo;
    }
}
?>