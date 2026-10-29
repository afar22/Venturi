<?php
require_once "core/BaseDatos.php";
require_once "Entities/Cliente.php";

class ClienteModel extends Conectar {

    public function __construct(){
        parent::__construct();
    }

    public function contarClientes(){
        try{
            $sql = "SELECT COUNT(*) as total FROM tPerfil";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function obtenerTodosLosClientes(){
        try{
            $sql = "SELECT
                        nPerfilID AS nClienteid,
                        cNombres,
                        cApellidos,
                        cCorreo,
                        '' AS cTelefono,
                        cDocumento,
                        eTipo_Documento AS cTipoDocumento
                    FROM tPerfil";
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
            $sql = "SELECT
                        nPerfilID AS nClienteid,
                        cNombres,
                        cApellidos,
                        cCorreo,
                        '' AS cTelefono,
                        cDocumento,
                        eTipo_Documento AS cTipoDocumento
                    FROM tPerfil WHERE nPerfilID = :id";
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
            $sql = "INSERT INTO tPerfil (nUsuarioFK, cNombres, cApellidos, eTipo_Documento, cDocumento, cCorreo, nExpedicionFK)
                    VALUES (0, :nombre, :apellido, :tipoDocumento, :documento, :correo, 1)";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindValue(':nombre', $cliente->getNombre());
            $sentencia->bindValue(':apellido', $cliente->getApellido());
            $sentencia->bindValue(':tipoDocumento', $cliente->getTipoDocumento());
            $sentencia->bindValue(':documento', $cliente->getDocumento());
            $sentencia->bindValue(':correo', $cliente->getCorreo());
            $sentencia->execute();
            return $this->conexion->lastInsertId();
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function actualizarCliente(Cliente $cliente){
        try{
            $sql = "UPDATE tPerfil
                    SET cNombres=:nombre, cApellidos=:apellido, cCorreo=:correo,
                        cDocumento=:documento, eTipo_Documento=:tipoDocumento
                    WHERE nPerfilID=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':id', $cliente->getId());
            $stmt->bindValue(':nombre', $cliente->getNombre());
            $stmt->bindValue(':apellido', $cliente->getApellido());
            $stmt->bindValue(':correo', $cliente->getCorreo());
            $stmt->bindValue(':documento', $cliente->getDocumento());
            $stmt->bindValue(':tipoDocumento', $cliente->getTipoDocumento());
            return $stmt->execute();
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function eliminarCliente($id){
        try{
            $sql = "DELETE FROM tPerfil WHERE nPerfilID=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        }catch(Exception $e){
            die($e->getMessage());
        }
    }
}
