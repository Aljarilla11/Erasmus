<?php
class Convocatoria 
{
    public $id;
    public $dni;
    public $nombre;
    public $apellidos;
    public $fecha_nacimiento;
    public $telefono;
    public $correo;
    public $domicilio;
    public $curso;
    public $tutor;
    public $rol;

    public function __construct($id, $dni, $nombre, $apellidos, $fecha_nacimiento, $telefono, $correo, $domicilio, $curso, $tutor, $rol) {
        $this->id = $id;
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->domicilio = $domicilio;
        $this->curso = $curso;
        $this->tutor = $tutor;
        $this->rol = $rol;
    }

    // Métodos getter
    public function getId() {
        return $this->id;
    }

    public function getDni() {
        return $this->dni;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function getFechaNacimiento() {
        return $this->fecha_nacimiento;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function getDomicilio() {
        return $this->domicilio;
    }

    public function getCurso() {
        return $this->curso;
    }

    public function getTutor() {
        return $this->tutor;
    }

    public function getRol() {
        return $this->rol;
    }

    // Métodos setter
    public function setId($id) {
        $this->id = $id;
    }

    public function setDni($dni) {
        $this->dni = $dni;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function setFechaNacimiento($fecha_nacimiento) {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function setDomicilio($domicilio) {
        $this->domicilio = $domicilio;
    }

    public function setCurso($curso) {
        $this->curso = $curso;
    }

    public function setTutor($tutor) {
        $this->tutor = $tutor;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }
}
?>