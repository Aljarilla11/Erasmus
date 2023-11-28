<?php
class DestinatarioConvocatoria {
    public $id;
    public $id_convocatoria;
    public $id_destinatario;

    public function __construct($id, $id_convocatoria, $id_destinatario) {
        $this->id = $id;
        $this->id_convocatoria = $id_convocatoria;
        $this->id_destinatario = $id_destinatario;
    }

    // Métodos getter
    public function getId() {
        return $this->id;
    }

    public function getIdConvocatoria() {
        return $this->id_convocatoria;
    }

    public function getIdDestinatario() {
        return $this->id_destinatario;
    }

    // Métodos setter
    public function setId($id) {
        $this->id = $id;
    }

    public function setIdConvocatoria($id_convocatoria) {
        $this->id_convocatoria = $id_convocatoria;
    }

    public function setIdDestinatario($id_destinatario) {
        $this->id_destinatario = $id_destinatario;
    }
}

?>