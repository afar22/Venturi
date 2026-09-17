<?php
require_once "core/BaseDatos.php";
require_once "Entities/Cliente.php";

class ClienteModel extends Conectar {

    public function __construct(){
        parent::__construct();
    }

    public function contarClientes(){
        try{
            $sql = "SELECT COUNT(*) as total FROM TCliente";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function obtenerTodosLosClientes(){
        try{
            $sql = "SELECT * FROM TCliente";
            $consulta = $this->conexion->prepare($sql);
            $consulta->execute();
            $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $lista = [];
            foreach($resultados as $fila){
                $lista[] = new Cliente(
                    $fila['nClienteid'],
                    $fila['cNombres'],
                    $fila['cApellidos'],
                    $fila['cCorreo'],
                    $fila['cTelefono'],
                    $fila['cDocumento'],
                    $fila['cTipoDocumento']
                );
            }
            return $lista;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function obtenerClientePorId($id){
        try{
            $sql = "SELECT * FROM TCliente WHERE nClienteid = :id";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(':id', $id);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            if($resultado){
                return new Cliente(
                    $resultado['nClienteid'],
                    $resultado['cNombres'],
                    $resultado['cApellidos'],
                    $resultado['cCorreo'],
                    $resultado['cTelefono'],
                    $resultado['cDocumento'],
                    $resultado['cTipoDocumento']
                );
            }
            return null;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function crearCliente(Cliente $cliente){
        try{
            $sql = "INSERT INTO TCliente (cNombres, cApellidos, cCorreo, cTelefono, cDocumento, cTipoDocumento)
                    VALUES (:nombre, :apellido, :correo, :telefono, :documento, :tipoDocumento)";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindValue(':nombre', $cliente->getNombre());
            $sentencia->bindValue(':apellido', $cliente->getApellido());
            $sentencia->bindValue(':correo', $cliente->getCorreo());
            $sentencia->bindValue(':telefono', $cliente->getTelefono());
            $sentencia->bindValue(':documento', $cliente->getDocumento());
            $sentencia->bindValue(':tipoDocumento', $cliente->getTipoDocumento());
            $sentencia->execute();
            return $this->conexion->lastInsertId();
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function actualizarCliente(Cliente $cliente){
        try{
            $sql = "UPDATE TCliente 
                    SET cNombres=:nombre, cApellidos=:apellido, cCorreo=:correo,
                        cTelefono=:telefono, cDocumento=:documento, cTipoDocumento=:tipoDocumento
                    WHERE nClienteid=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':id', $cliente->getId());
            $stmt->bindValue(':nombre', $cliente->getNombre());
            $stmt->bindValue(':apellido', $cliente->getApellido());
            $stmt->bindValue(':correo', $cliente->getCorreo());
            $stmt->bindValue(':telefono', $cliente->getTelefono());
            $stmt->bindValue(':documento', $cliente->getDocumento());
            $stmt->bindValue(':tipoDocumento', $cliente->getTipoDocumento());
            return $stmt->execute();
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function eliminarCliente($id){
        try{
            $sql = "DELETE FROM TCliente WHERE nClienteid=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        }catch(Exception $e){
            die($e->getMessage());
        }
    }
}