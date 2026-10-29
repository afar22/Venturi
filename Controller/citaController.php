<?php

class citaController {

    public function lista(){
        require_once "Model/CitaModel.php";
        $modelo = new CitaModel();
        $citas = $modelo->obtenerTodasLasCitas();
        require_once "View/Cita/ListCitas.php";
    }

    public function crear(){
        require_once "Model/OperarioModel.php";
        require_once "Model/EstufaModel.php";

        $modeloOperario = new OperarioModel();
        $modeloEstufa   = new EstufaModel();

        $operarios = $modeloOperario->obtenerTodosLosOperarios();
        $estufas   = $modeloEstufa->obtenerTodasLasEstufas();

        require_once "View/Cita/CrearCita.php";
    }

    public function guardar(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header("Location: " . APP_URL . "index.php?url=cita&accion=crear");
            exit;
        }

        require_once "Model/CitaModel.php";
        require_once "Entities/Cita.php";

        $tipoEstufa  = trim($_POST['tipoEstufa'] ?? '');
        $operarioFK  = trim($_POST['operarioFK'] ?? '');
        $tipoMantFK  = trim($_POST['tipoMantFK'] ?? 1);
        $fecha       = trim($_POST['fecha'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        if(empty($operarioFK) || empty($fecha)){
            $error = "Los campos operario y fecha son obligatorios";
            require_once "Model/OperarioModel.php";
            require_once "Model/EstufaModel.php";
            $modeloOperario = new OperarioModel();
            $modeloEstufa   = new EstufaModel();
            $operarios = $modeloOperario->obtenerTodosLosOperarios();
            $estufas   = $modeloEstufa->obtenerTodasLasEstufas();
            require_once "View/Cita/CrearCita.php";
            return;
        }

        if(empty($tipoEstufa)) $tipoEstufa = 0; // Sin estufa asignada

        $modelo = new CitaModel();
        $cita = new Cita(null, $tipoEstufa, $operarioFK, $tipoMantFK);
        $modelo->crearCita($cita, $fecha, $descripcion);

        header("Location: " . APP_URL . "index.php?url=cita&accion=lista");
        exit;
    }

    public function eliminar($id){
        require_once "Model/CitaModel.php";
        $modelo = new CitaModel();
        $modelo->eliminarCita($id);
        header("Location: " . APP_URL . "index.php?url=cita&accion=lista");
        exit;
    }
}