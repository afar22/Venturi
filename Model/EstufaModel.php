<?php
require_once "core/BaseDatos.php";
require_once "Entities/Estufa.php";

class EstufaModel extends Conectar {

    public function __construct(){
        parent::__construct();
    }

    public function contarEstufas(){
        try{
            $sql = "SELECT COUNT(*) as total FROM TEstufa";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function obtenerTodasLasEstufas(){
        try{
            $sql = "SELECT e.*, c.cNombres, c.cApellidos 
                    FROM TEstufa e 
                    LEFT JOIN TCliente c ON e.nClientefk = c.nClienteid";
            $consulta = $this->conexion->prepare($sql);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function obtenerEstufaPorId($id){
        try{
            $sql = "SELECT * FROM TEstufa WHERE nEstufaid = :id";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(':id', $id);
            $sentencia->execute();
            $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            if($resultado){
                return new Estufa(
                    $resultado['nEstufaid'],
                    $resultado['cTipoEstufa'],
                    $resultado['cModelo'],
                    $resultado['cMarcaEstufa'],
                    $resultado['cInformacionAdicional'],
                    $resultado['nEstadoEstufafk'],
                    $resultado['nClientefk']
                );
            }
            return null;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function obtenerEstufasPorCliente($clienteId){
        try{
            $sql = "SELECT * FROM TEstufa WHERE nClientefk = :clienteId";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(':clienteId', $clienteId);
            $sentencia->execute();
            $resultados = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            $lista = [];
            foreach($resultados as $fila){
                $lista[] = new Estufa(
                    $fila['nEstufaid'],
                    $fila['cTipoEstufa'],
                    $fila['cModelo'],
                    $fila['cMarcaEstufa'],
                    $fila['cInformacionAdicional'],
                    $fila['nEstadoEstufafk'],
                    $fila['nClientefk']
                );
            }
            return $lista;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function obtenerDetalle($id){
        try{
            $sql = "SELECT e.*, c.cNombres, c.cApellidos, c.cCorreo, c.cTelefono
                    FROM TEstufa e 
                    LEFT JOIN TCliente c ON e.nClientefk = c.nClienteid
                    WHERE e.nEstufaid = :id";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(':id', $id);
            $sentencia->execute();
            return $sentencia->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function crearEstufa(Estufa $estufa){
        try{
            $sql = "INSERT INTO TEstufa (cTipoEstufa, cModelo, cMarcaEstufa, cInformacionAdicional, nEstadoEstufafk, nClientefk)
                    VALUES (:tipoEstufa, :modelo, :marca, :informacionAdicional, :estadoEstufafk, :clientefk)";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindValue(':tipoEstufa', $estufa->getTipoEstufa());
            $sentencia->bindValue(':modelo', $estufa->getModelo());
            $sentencia->bindValue(':marca', $estufa->getMarca());
            $sentencia->bindValue(':informacionAdicional', $estufa->getInformacionAdicional());
            $sentencia->bindValue(':estadoEstufafk', $estufa->getEstadoEstufa_fK());
            $sentencia->bindValue(':clientefk', $estufa->getClientefk());
            $sentencia->execute();
            return $this->conexion->lastInsertId();
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function actualizarEstufa(Estufa $estufa){
        try{
            $sql = "UPDATE TEstufa 
                    SET cTipoEstufa=:tipoEstufa, cModelo=:modelo, cMarcaEstufa=:marca,
                        cInformacionAdicional=:informacionAdicional, nEstadoEstufafk=:estadoEstufafk,
                        nClientefk=:clientefk
                    WHERE nEstufaid=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':id', $estufa->getId());
            $stmt->bindValue(':tipoEstufa', $estufa->getTipoEstufa());
            $stmt->bindValue(':modelo', $estufa->getModelo());
            $stmt->bindValue(':marca', $estufa->getMarca());
            $stmt->bindValue(':informacionAdicional', $estufa->getInformacionAdicional());
            $stmt->bindValue(':estadoEstufafk', $estufa->getEstadoEstufa_fK());
            $stmt->bindValue(':clientefk', $estufa->getClientefk());
            return $stmt->execute();
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function eliminarEstufa($id){
        try{
            $sql = "DELETE FROM TEstufa WHERE nEstufaid=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        }catch(Exception $e){
            die($e->getMessage());
        }
    }
}