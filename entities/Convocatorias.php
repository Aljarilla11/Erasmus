<?php
class Convocatoria 
{
    public $id;
    public $movilidades;
    public $tipo;
    public $fecha_inicio;
    public $fecha_fin;
    public $fecha_inicio_pruebas;
    public $fecha_fin_pruebas;
    public $fecha_inicio_definitiva;
    public $id_proyecto;

    public function __construct($id, $movilidades, $tipo, $fecha_inicio, $fecha_fin, $fecha_inicio_pruebas, $fecha_fin_pruebas, $fecha_inicio_definitiva, $id_proyecto) {
        $this->id = $id;
        $this->movilidades = $movilidades;
        $this->tipo = $tipo;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->fecha_inicio_pruebas = $fecha_inicio_pruebas;
        $this->fecha_fin_pruebas = $fecha_fin_pruebas;
        $this->fecha_inicio_definitiva = $fecha_inicio_definitiva;
        $this->id_proyecto = $id_proyecto;
    }

    // Métodos getter
    public function getId() {
        return $this->id;
    }

    public function getMovilidades() {
        return $this->movilidades;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getFechaInicio() {
        return $this->fecha_inicio;
    }

    public function getFechaFin() {
        return $this->fecha_fin;
    }

    public function getFechaInicioPruebas() {
        return $this->fecha_inicio_pruebas;
    }

    public function getFechaFinPruebas() {
        return $this->fecha_fin_pruebas;
    }

    public function getFechaInicioDefinitiva() {
        return $this->fecha_inicio_definitiva;
    }

    public function getIdProyecto() {
        return $this->id_proyecto;
    }

    // Métodos setter
    public function setId($id) {
        $this->id = $id;
    }

    public function setMovilidades($movilidades) {
        $this->movilidades = $movilidades;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setFechaInicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
    }

    public function setFechaFin($fecha_fin) {
        $this->fecha_fin = $fecha_fin;
    }

    public function setFechaInicioPruebas($fecha_inicio_pruebas) {
        $this->fecha_inicio_pruebas = $fecha_inicio_pruebas;
    }

    public function setFechaFinPruebas($fecha_fin_pruebas) {
        $this->fecha_fin_pruebas = $fecha_fin_pruebas;
    }

    public function setFechaInicioDefinitiva($fecha_inicio_definitiva) {
        $this->fecha_inicio_definitiva = $fecha_inicio_definitiva;
    }

    public function setIdProyecto($id_proyecto) {
        $this->id_proyecto = $id_proyecto;
    }
}

?>