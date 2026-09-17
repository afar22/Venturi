<?php

class citaController {

    public function lista(){
        require_once "Model/CitaModel.php";
        $modelo = new CitaModel();
        $citas = $modelo->obtenerTodasLasCitas();
        require_once "View/Cita/ListCitas.php";
    }

    public function crear(){
        require_once "Model/FacturaModel.php";
        require_once "Model/OperarioModel.php";

        $modeloFactura  = new FacturaModel();
        $modeloOperario = new OperarioModel();

        $facturas  = $modeloFactura->obtenerTodasLasFacturas();
        $operarios = $modeloOperario->obtenerTodosLosOperarios();

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
        $facturaFK   = trim($_POST['facturaFK'] ?? '');
        $operarioFK  = trim($_POST['operarioFK'] ?? '');
        $tipoMantFK  = trim($_POST['tipoMantFK'] ?? 1);
        $fecha       = trim($_POST['fecha'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        if(empty($tipoEstufa) || empty($facturaFK) || empty($operarioFK) || empty($fecha)){
            $error = "Todos los campos son obligatorios";
            require_once "Model/FacturaModel.php";
            require_once "Model/OperarioModel.php";
            $facturas  = (new FacturaModel())->obtenerTodasLasFacturas();
            $operarios = (new OperarioModel())->obtenerTodosLosOperarios();
            require_once "View/Cita/CrearCita.php";
            return;
        }

        $modelo = new CitaModel();
        $cita = new Cita(null, $tipoEstufa, $facturaFK, $operarioFK, $tipoMantFK);
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