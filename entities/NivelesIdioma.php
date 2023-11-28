<?php
class NivelesIdiomas 
{
    public $id;
    public $niveles;

    public function __construct($id, $niveles) {
        $this->id = $id;
        $this->niveles = $niveles;
    }

    // Métodos getter
    public function getId() {
        return $this->id;
    }

    public function getNiveles() {
        return $this->niveles;
    }

    // Métodos setter
    public function setId($id) {
        $this->id = $id;
    }

    public function setNiveles($niveles) {
        $this->niveles = $niveles;
    }
}

?>