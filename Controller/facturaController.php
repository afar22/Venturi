<?php

class facturaController {

    public function lista(){
        require_once "Model/FacturaModel.php";
        $modelo = new FacturaModel();
        $facturas = $modelo->obtenerTodasLasFacturas();
        require_once "View/Factura/ListFacturas.php";
    }

    public function crear(){
        require_once "Model/ClienteModel.php";
        $modeloCliente = new ClienteModel();
        $clientes = $modeloCliente->obtenerTodosLosClientes();
        require_once "View/Factura/CrearFactura.php";
    }

    public function guardar(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header("Location: " . APP_URL . "index.php?url=factura&accion=crear");
            exit;
        }
        require_once "Model/FacturaModel.php";
        require_once "Entities/Factura.php";

        $totalPago  = trim($_POST['totalPago'] ?? '');
        $fecha      = trim($_POST['fecha'] ?? '');
        $clientefk  = trim($_POST['clientefk'] ?? '');

        if(empty($totalPago) || empty($fecha) || empty($clientefk)){
            $error = "Todos los campos son obligatorios";
            require_once "Model/ClienteModel.php";
            $modeloCliente = new ClienteModel();
            $clientes = $modeloCliente->obtenerTodosLosClientes();
            require_once "View/Factura/CrearFactura.php";
            return;
        }

        $modelo = new FacturaModel();
        $factura = new Factura(null, $totalPago, $fecha, $clientefk);
        $modelo->crearFactura($factura);

        header("Location: " . APP_URL . "index.php?url=factura&accion=lista");
        exit;
    }

    public function editar($id){
        require_once "Model/FacturaModel.php";
        require_once "Model/ClienteModel.php";

        $modelo = new FacturaModel();
        $factura = $modelo->obtenerFacturaPorId($id);

        if(!$factura){
            header("Location: " . APP_URL . "index.php?url=factura&accion=lista");
            exit;
        }

        $modeloCliente = new ClienteModel();
        $clientes = $modeloCliente->obtenerTodosLosClientes();
        require_once "View/Factura/EditarFactura.php";
    }

    public function actualizar(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header("Location: " . APP_URL . "index.php?url=factura&accion=lista");
            exit;
        }
        require_once "Model/FacturaModel.php";
        require_once "Entities/Factura.php";

        $id        = $_POST['factura_id'] ?? null;
        $totalPago = trim($_POST['totalPago'] ?? '');
        $fecha     = trim($_POST['fecha'] ?? '');
        $clientefk = trim($_POST['clientefk'] ?? '');

        $modelo = new FacturaModel();
        $factura = new Factura($id, $totalPago, $fecha, $clientefk);
        $modelo->actualizarFactura($factura);

        header("Location: " . APP_URL . "index.php?url=factura&accion=lista");
        exit;
    }

    public function eliminar($id){
        require_once "Model/FacturaModel.php";
        $modelo = new FacturaModel();
        $modelo->eliminarFactura($id);
        header("Location: " . APP_URL . "index.php?url=factura&accion=lista");
        exit;
    }
}