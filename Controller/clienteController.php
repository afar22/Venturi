<?php

class clienteController {

    public function lista(){
        require_once "Model/ClienteModel.php";
        $modelo = new ClienteModel();
        $clientes = $modelo->obtenerTodosLosClientes();
        require_once "View/Cliente/ListClientes.php";
    }

    public function crear(){
        require_once "View/CrearCliente.php";
    }

    public function guardar(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header("Location: " . APP_URL . "index.php?url=cliente&accion=crear");
            exit;
        }

        require_once "Model/ClienteModel.php";
        require_once "Entities/Cliente.php";

        $nombre        = trim($_POST['nombre'] ?? '');
        $apellido      = trim($_POST['apellido'] ?? '');
        $correo        = trim($_POST['correo'] ?? '');
        $telefono      = trim($_POST['telefono'] ?? '');
        $documento     = trim($_POST['documento'] ?? '');
        $tipoDocumento = trim($_POST['tipoDocumento'] ?? '');

        if(empty($nombre) || empty($apellido) || empty($correo) || empty($telefono) || empty($documento) || empty($tipoDocumento)){
            $error = "Todos los campos son obligatorios";
            require_once "View/CrearCliente.php";
            return;
        }

        $modelo = new ClienteModel();
        $cliente = new Cliente(null, $nombre, $apellido, $correo, $telefono, $documento, $tipoDocumento);
        $modelo->crearCliente($cliente);

        header("Location: " . APP_URL . "index.php?url=cliente&accion=lista");
        exit;
    }

    public function editar($id){
        require_once "Model/ClienteModel.php";
        require_once "Entities/Cliente.php";

        $modelo = new ClienteModel();
        $cliente = $modelo->obtenerClientePorId($id);

        if(!$cliente){
            header("Location: " . APP_URL . "index.php?url=cliente&accion=lista");
            exit;
        }

        require_once "View/EditarCliente.php";
    }

    public function actualizar(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header("Location: " . APP_URL . "index.php?url=cliente&accion=lista");
            exit;
        }

        require_once "Model/ClienteModel.php";
        require_once "Entities/Cliente.php";

        $id            = $_POST['cliente_id'] ?? null;
        $nombre        = trim($_POST['nombre'] ?? '');
        $apellido      = trim($_POST['apellido'] ?? '');
        $correo        = trim($_POST['correo'] ?? '');
        $telefono      = trim($_POST['telefono'] ?? '');
        $documento     = trim($_POST['documento'] ?? '');
        $tipoDocumento = trim($_POST['tipoDocumento'] ?? '');

        $modelo = new ClienteModel();
        $cliente = new Cliente($id, $nombre, $apellido, $correo, $telefono, $documento, $tipoDocumento);
        $modelo->actualizarCliente($cliente);

        header("Location: " . APP_URL . "index.php?url=cliente&accion=lista");
        exit;
    }

    public function eliminar($id){
        require_once "Model/ClienteModel.php";
        $modelo = new ClienteModel();
        $modelo->eliminarCliente($id);
        header("Location: " . APP_URL . "index.php?url=cliente&accion=lista");
        exit;
    }

    public function porEstufa($id){
        require_once "Model/ClienteModel.php";
        $modelo = new ClienteModel();
        $cliente = $modelo->obtenerClientePorId($id);

        if(!$cliente){
            header("Location: " . APP_URL . "index.php?url=cliente&accion=lista");
            exit;
        }

        require_once "Model/EstufaModel.php";
        $modeloEstufa = new EstufaModel();
        $estufas = $modeloEstufa->obtenerEstufasPorCliente($id);

        require_once "View/Estufa/EstufasPorCliente.php";
    }
}