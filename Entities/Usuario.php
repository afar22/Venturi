<?php


class Usuario
{
    public $usuario_id;
    public $rol;
    public $telefono;
    private $documento;
    public $estado;

    public function __construct($usuario_id, $rol, $telefono, $documento, $estado)
    {
        $this->usuario_id = $usuario_id;
        $this->rol = $rol;
        $this->telefono = $telefono;
        $this->documento = $documento;
        $this->estado = $estado;
    }

    public function getId()
    {
        return $this->usuario_id;
    }

    public function setId($id)
    {
        $this->usuario_id = $id;
        return $this;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
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

    public function getDocumento()
    {
        return $this->documento;
    }

    public function setDocumento($documento)
    {
        $this->documento = $documento;
        return $this;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }
}