<?php
class Destinatarios 
{
    public $cod_grupo;
    public $nombre;

    public function __construct($cod_grupo, $nombre) {
        $this->cod_grupo = $cod_grupo;
        $this->nombre = $nombre;
    }

    // Métodos getter
    public function getCodGrupo() {
        return $this->cod_grupo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    // Métodos setter
    public function setCodGrupo($cod_grupo) {
        $this->cod_grupo = $cod_grupo;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
}

?>