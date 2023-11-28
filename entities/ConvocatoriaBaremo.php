<?php
class ConvocatoriaBaremo 
{
    public $id;
    public $requisito;
    public $nota_max;
    public $id_baremo;
    public $id_convocatoria;
    public $valor_minimo;

    public function __construct($id, $requisito, $nota_max, $id_baremo, $id_convocatoria, $valor_minimo) {
        $this->id = $id;
        $this->requisito = $requisito;
        $this->nota_max = $nota_max;
        $this->id_baremo = $id_baremo;
        $this->id_convocatoria = $id_convocatoria;
        $this->valor_minimo = $valor_minimo;
    }

    // Métodos getter
    public function getId() {
        return $this->id;
    }

    public function getRequisito() {
        return $this->requisito;
    }

    public function getNotaMax() {
        return $this->nota_max;
    }

    public function getIdBaremo() {
        return $this->id_baremo;
    }

    public function getIdConvocatoria() {
        return $this->id_convocatoria;
    }

    public function getValorMinimo() {
        return $this->valor_minimo;
    }

    // Métodos setter
    public function setId($id) {
        $this->id = $id;
    }

    public function setRequisito($requisito) {
        $this->requisito = $requisito;
    }

    public function setNotaMax($nota_max) {
        $this->nota_max = $nota_max;
    }

    public function setIdBaremo($id_baremo) {
        $this->id_baremo = $id_baremo;
    }

    public function setIdConvocatoria($id_convocatoria) {
        $this->id_convocatoria = $id_convocatoria;
    }

    public function setValorMinimo($valor_minimo) {
        $this->valor_minimo = $valor_minimo;
    }
}

?>