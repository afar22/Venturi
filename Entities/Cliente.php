<?php
class Cliente
{
    public $cliente_id;
    public $nombre;
    public $apellido;
    public $correo;
    public $telefono;
    private $tipoDocumento;
    private $documento;
    

    public function __construct($cliente_id, $nombre, $apellido, $correo, $telefono, $documento, $tipoDocumento)
    {
        $this->cliente_id = $cliente_id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->telefono = $telefono;
        $this->tipoDocumento = $tipoDocumento;
        $this->documento = $documento;
        
    }

    public function getId()
    {
        return $this->cliente_id;
    }

    public function setId($cliente_id)
    {
        $this->cliente_id = $cliente_id;
        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
        return $this;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
        return $this;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
        return $this;
    }

    
    public function getTipoDocumento()
    {
        return $this->tipoDocumento;
    }

    public function setTipoDocumento($tipoDocumento)
    {
        $this->tipoDocumento = $tipoDocumento;
        return $this;
    }

    public function getDocumento()
    {
        return $this->documento;
    }

    public function setDocumento($documento)
    {
        $this->documento = $documento;
        return $this;
    }

}