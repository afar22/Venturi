<?php

class Estufa
{
    public $estufa_id;
    public $tipoEstufa;
    public $modelo;
    public $marca;
    public $informacionAdicional;
    public $estadoEstufa_fK;
    public $clientefk;

    public function __construct($estufa_id, $tipoEstufa, $modelo, $marca, $informacionAdicional, $estadoEstufa_fK, $clientefk)
    {
        $this->estufa_id = $estufa_id;
        $this->tipoEstufa = $tipoEstufa;
        $this->modelo = $modelo;
        $this->marca = $marca;
        $this->informacionAdicional = $informacionAdicional;
        $this->estadoEstufa_fK = $estadoEstufa_fK;
        $this->clientefk = $clientefk;
    }

    public function getId() { return $this->estufa_id; }
    public function setId($estufa_id) { $this->estufa_id = $estufa_id; return $this; }

    public function getTipoEstufa() { return $this->tipoEstufa; }
    public function setTipoEstufa($tipoEstufa) { $this->tipoEstufa = $tipoEstufa; return $this; }

    public function getModelo() { return $this->modelo; }
    public function setModelo($modelo) { $this->modelo = $modelo; return $this; }

    public function getMarca() { return $this->marca; }
    public function setMarca($marca) { $this->marca = $marca; return $this; }

    public function getInformacionAdicional() { return $this->informacionAdicional; }
    public function setInformacionAdicional($informacionAdicional) { $this->informacionAdicional = $informacionAdicional; return $this; }

    public function getEstadoEstufa_fK() { return $this->estadoEstufa_fK; }
    public function setEstadoEstufa_fK($estadoEstufa_fK) { $this->estadoEstufa_fK = $estadoEstufa_fK; return $this; }

    public function getClientefk() { return $this->clientefk; }
    public function setClientefk($clientefk) { $this->clientefk = $clientefk; return $this; }
}