<?php

class estufaController {

    public function lista(){
        require_once "Model/EstufaModel.php";
        $modelo = new EstufaModel();
        $estufas = $modelo->obtenerTodasLasEstufas();
        require_once "View/Estufa/ListEstufa.php";
    }

    public function crear(){
        require_once "Model/ClienteModel.php";
        $modeloCliente = new ClienteModel();
        $clientes = $modeloCliente->obtenerTodosLosClientes();
        require_once "View/Estufa/CrearEstufa.php";
    }

    public function guardar(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header("Location: " . APP_URL . "index.php?url=estufa&accion=crear");
            exit;
        }

        require_once "Model/EstufaModel.php";
        require_once "Entities/Estufa.php";

        $tipoEstufa           = trim($_POST['tipoEstufa'] ?? '');
        $modelo               = trim($_POST['modelo'] ?? '');
        $marca                = trim($_POST['marca'] ?? '');
        $informacionAdicional = trim($_POST['informacionAdicional'] ?? '');
        $estadoEstufafk       = trim($_POST['estadoEstufafk'] ?? '');
        $clientefk            = trim($_POST['clientefk'] ?? '');

        if(empty($tipoEstufa) || empty($modelo) || empty($marca) || empty($clientefk)){
            $error = "Los campos marcados son obligatorios";
            require_once "Model/ClienteModel.php";
            $modeloCliente = new ClienteModel();
            $clientes = $modeloCliente->obtenerTodosLosClientes();
            require_once "View/Estufa/CrearEstufa.php";
            return;
        }

        $estufaModel = new EstufaModel();
        $estufa = new Estufa(null, $tipoEstufa, $modelo, $marca, $informacionAdicional, $estadoEstufafk, $clientefk);
        $estufaModel->crearEstufa($estufa);

        header("Location: " . APP_URL . "index.php?url=estufa&accion=lista");
        exit;
    }

    public function editar($id){
        require_once "Model/EstufaModel.php";
        require_once "Model/ClienteModel.php";
        require_once "Entities/Estufa.php";

        $modelo = new EstufaModel();
        $estufa = $modelo->obtenerEstufaPorId($id);

        if(!$estufa){
            header("Location: " . APP_URL . "index.php?url=estufa&accion=lista");
            exit;
        }

        $modeloCliente = new ClienteModel();
        $clientes = $modeloCliente->obtenerTodosLosClientes();

        require_once "View/Estufa/EditarEstufa.php";
    }

    public function actualizar(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header("Location: " . APP_URL . "index.php?url=estufa&accion=lista");
            exit;
        }

        require_once "Model/EstufaModel.php";
        require_once "Entities/Estufa.php";

        $id                   = $_POST['estufa_id'] ?? null;
        $tipoEstufa           = trim($_POST['tipoEstufa'] ?? '');
        $modelo               = trim($_POST['modelo'] ?? '');
        $marca                = trim($_POST['marca'] ?? '');
        $informacionAdicional = trim($_POST['informacionAdicional'] ?? '');
        $estadoEstufafk       = trim($_POST['estadoEstufafk'] ?? '');
        $clientefk            = trim($_POST['clientefk'] ?? '');

        $estufaModel = new EstufaModel();
        $estufa = new Estufa($id, $tipoEstufa, $modelo, $marca, $informacionAdicional, $estadoEstufafk, $clientefk);
        $estufaModel->actualizarEstufa($estufa);

        header("Location: " . APP_URL . "index.php?url=estufa&accion=lista");
        exit;
    }

    public function eliminar($id){
        require_once "Model/EstufaModel.php";
        $modelo = new EstufaModel();
        $modelo->eliminarEstufa($id);
        header("Location: " . APP_URL . "index.php?url=estufa&accion=lista");
        exit;
    }

    public function porCliente($id){
        require_once "Model/EstufaModel.php";
        require_once "Model/ClienteModel.php";

        $modelo = new EstufaModel();
        $modeloCliente = new ClienteModel();

        $estufas = $modelo->obtenerEstufasPorCliente($id);
        $cliente = $modeloCliente->obtenerClientePorId($id);

        if(!$cliente){
            header("Location: " . APP_URL . "index.php?url=cliente&accion=lista");
            exit;
        }

        require_once "View/Estufa/EstufasPorCliente.php";
    }

    public function detalle($id){
        require_once "Model/EstufaModel.php";

        $modelo = new EstufaModel();
        $estufa = $modelo->obtenerDetalle($id);

        if(!$estufa){
            header("Location: " . APP_URL . "index.php?url=estufa&accion=lista");
            exit;
        }

        require_once "View/Estufa/DetalleEstufa.php";
    }
}