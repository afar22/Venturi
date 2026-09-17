<?php

class operarioController {

    public function lista(){
        require_once "Model/OperarioModel.php";
        $modelo = new OperarioModel();
        $operarios = $modelo->obtenerTodosLosOperarios();
        require_once "View/Operario/ListOperarios.php";
    }

    public function crear(){
        require_once "View/Operario/CrearOperario.php";
    }

    public function guardar(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header("Location: " . APP_URL . "index.php?url=operario&accion=crear");
            exit;
        }

        require_once "Model/OperarioModel.php";
        require_once "Entities/Operario.php";

        $nombre   = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $correo   = trim($_POST['correo'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $documento = trim($_POST['documento'] ?? '');

        if(empty($nombre) || empty($apellido) || empty($correo) || empty($telefono) || empty($documento)){
            $error = "Todos los campos son obligatorios";
            require_once "View/Operario/CrearOperario.php";
            return;
        }

        $modelo = new OperarioModel();
        $operario = new Operario(null, $nombre, $apellido, $correo, $telefono, $documento);
        $modelo->crearOperario($operario);

        header("Location: " . APP_URL . "index.php?url=operario&accion=lista");
        exit;
    }

    public function editar($id){
        require_once "Model/OperarioModel.php";
        require_once "Entities/Operario.php";

        $modelo = new OperarioModel();
        $operario = $modelo->obtenerOperarioPorId($id);

        if(!$operario){
            header("Location: " . APP_URL . "index.php?url=operario&accion=lista");
            exit;
        }

        require_once "View/Operario/EditarOperario.php";
    }

    public function actualizar(){
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header("Location: " . APP_URL . "index.php?url=operario&accion=lista");
            exit;
        }

        require_once "Model/OperarioModel.php";
        require_once "Entities/Operario.php";

        $id       = $_POST['operario_id'] ?? null;
        $nombre   = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $correo   = trim($_POST['correo'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $documento = trim($_POST['documento'] ?? '');

        $modelo = new OperarioModel();
        $operario = new Operario($id, $nombre, $apellido, $correo, $telefono, $documento);
        $modelo->actualizarOperario($operario);

        header("Location: " . APP_URL . "index.php?url=operario&accion=lista");
        exit;
    }

    public function eliminar($id){
        require_once "Model/OperarioModel.php";
        $modelo = new OperarioModel();
        $modelo->eliminarOperario($id);
        header("Location: " . APP_URL . "index.php?url=operario&accion=lista");
        exit;
    }
}