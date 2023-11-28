<?php
class Proyectos {
    public $id;
    public $cod_proyecto;
    public $nombre;
    public $fecha_inicio;
    public $fecha_fin;

    public function __construct($id, $cod_proyecto, $nombre, $fecha_inicio, $fecha_fin) {
        $this->id = $id;
        $this->cod_proyecto = $cod_proyecto;
        $this->nombre = $nombre;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    // Métodos getter
    public function getId() {
        return $this->id;
    }

    public function getCodProyecto() {
        return $this->cod_proyecto;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getFechaInicio() {
        return $this->fecha_inicio;
    }

    public function getFechaFin() {
        return $this->fecha_fin;
    }

    // Métodos setter
    public function setId($id) {
        $this->id = $id;
    }

    public function setCodProyecto($cod_proyecto) {
        $this->cod_proyecto = $cod_proyecto;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setFechaInicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
    }

    public function setFechaFin($fecha_fin) {
        $this->fecha_fin = $fecha_fin;
    }
}

?>