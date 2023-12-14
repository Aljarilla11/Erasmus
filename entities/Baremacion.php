<?php

class Baremacion 
{
    // Atributos públicos
    public $id;
    public $id_candidatos;
    public $id_convocatoria;
    public $id_item_baremo;
    public $notas;
    public $url;

    // Constructor
    public function __construct($id, $id_candidatos, $id_convocatoria, $id_item_baremo, $notas, $url) {
        $this->id = $id;
        $this->id_candidatos = $id_candidatos;
        $this->id_convocatoria = $id_convocatoria;
        $this->id_item_baremo = $id_item_baremo;
        $this->notas = $notas;
        $this->url = $url;
    }

    // Métodos getter
    public function getId() {
        return $this->id;
    }

    public function getIdCandidatos() {
        return $this->id_candidatos;
    }

    public function getIdConvocatoria() {
        return $this->id_convocatoria;
    }

    public function getIdItemBaremo() {
        return $this->id_item_baremo;
    }

    public function getNotas() {
        return $this->notas;
    }

    public function getUrl() {
        return $this->url;
    }

    // Métodos setter
    public function setId($id) {
        $this->id = $id;
    }

    public function setIdCandidatos($id_candidatos) {
        $this->id_candidatos = $id_candidatos;
    }

    public function setIdConvocatoria($id_convocatoria) {
        $this->id_convocatoria = $id_convocatoria;
    }

    public function setIdItemBaremo($id_item_baremo) {
        $this->id_item_baremo = $id_item_baremo;
    }

    public function setNotas($notas) {
        $this->notas = $notas;
    }

    public function setUrl($url) {
        $this->url = $url;
    }
}

?>
