<?php

class Cita
{
    public $cita_id;
    public $tipoEstufa;
    public $operario_Fk;
    public $tipoMantenimiento_Fk;

    public function __construct($cita_id, $tipoEstufa, $operario_Fk, $tipoMantenimiento_Fk)
    {
        $this->cita_id = $cita_id;
        $this->tipoEstufa = $tipoEstufa;
        $this->operario_Fk = $operario_Fk;
        $this->tipoMantenimiento_Fk = $tipoMantenimiento_Fk;
    }

    public function getId()
    {
        return $this->cita_id;
    }

    public function setId($cita_id)
    {
        $this->cita_id = $cita_id;
        return $this;
    }

    public function getTipoEstufa()
    {
        return $this->tipoEstufa;
    }

    public function setTipoEstufa($tipoEstufa)
    {
        $this->tipoEstufa = $tipoEstufa;
        return $this;
    }

    public function getOperarioFk()
    {
        return $this->operario_Fk;
    }

    public function setOperarioFk($operario_Fk)
    {
        $this->operario_Fk = $operario_Fk;
        return $this;
    }

    public function getTipoMantenimientoFk()
    {
        return $this->tipoMantenimiento_Fk;
    }

    public function setTipoMantenimientoFk($tipoMantenimiento_Fk)
    {
        $this->tipoMantenimiento_Fk = $tipoMantenimiento_Fk;
        return $this;
    }
}