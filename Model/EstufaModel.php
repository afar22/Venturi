<?php
require_once "core/BaseDatos.php";
require_once "Entities/Estufa.php";

class EstufaModel extends Conectar {

    public function __construct(){
        parent::__construct();
    }

    public function contarEstufas(){
        try{
            $sql = "SELECT COUNT(*) as total FROM tEstufa";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function obtenerTodasLasEstufas(){
        try{
            $sql = "SELECT
                        e.nEstufaID AS nEstufaid,
                        e.cMarca AS cMarcaEstufa,
                        e.cModelo,
                        e.lEstado AS nEstadoEstufafk,
                        e.cObservaciones AS cInformacionAdicional,
                        '' AS cTipoEstufa,
                        e.nClienteFK AS nClientefk,
                        c.cNombres,
                        c.cApellidos
                    FROM tEstufa e
                    LEFT JOIN tPerfil c ON c.nPerfilID = e.nClienteFK";
            $consulta = $this->conexion->prepare($sql);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function obtenerEstufaPorId($id){
        try{
            $sql = "SELECT
                        nEstufaID AS nEstufaid,
                        cMarca AS cMarcaEstufa,
                        cModelo,
                        lEstado AS nEstadoEstufafk,
                        cObservaciones AS cInformacionAdicional,
                        '' AS cTipoEstufa,
                        nClienteFK AS nClientefk
                    FROM tEstufa WHERE nEstufaID = :id";
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
            $sql = "SELECT
                        nEstufaID AS nEstufaid,
                        cMarca AS cMarcaEstufa,
                        cModelo,
                        lEstado AS nEstadoEstufafk,
                        cObservaciones AS cInformacionAdicional,
                        '' AS cTipoEstufa,
                        nClienteFK AS nClientefk
                    FROM tEstufa WHERE nClienteFK = :clienteId";
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
            $sql = "SELECT
                        e.nEstufaID AS nEstufaid,
                        e.cMarca AS cMarcaEstufa,
                        e.cModelo,
                        e.lEstado AS nEstadoEstufafk,
                        e.cObservaciones AS cInformacionAdicional,
                        '' AS cTipoEstufa,
                        c.cNombres,
                        c.cApellidos,
                        c.cCorreo,
                        '' AS cTelefono
                    FROM tEstufa e
                    LEFT JOIN tPerfil c ON c.nPerfilID = e.nClienteFK
                    WHERE e.nEstufaID = :id";
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
            $sql = "INSERT INTO tEstufa (nClienteFK, nTrabajadorFK, cMarca, cModelo, lEstado, cObservaciones)
                    VALUES (:clientefk, 0, :marca, :modelo, :estadoEstufafk, :informacionAdicional)";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindValue(':clientefk', $estufa->getClientefk());
            $sentencia->bindValue(':marca', $estufa->getMarca());
            $sentencia->bindValue(':modelo', $estufa->getModelo());
            $sentencia->bindValue(':estadoEstufafk', $estufa->getEstadoEstufa_fK());
            $sentencia->bindValue(':informacionAdicional', $estufa->getInformacionAdicional());
            $sentencia->execute();
            return $this->conexion->lastInsertId();
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function actualizarEstufa(Estufa $estufa){
        try{
            $sql = "UPDATE tEstufa
                    SET nClienteFK=:clientefk, cMarca=:marca, cModelo=:modelo,
                        lEstado=:estadoEstufafk, cObservaciones=:informacionAdicional
                    WHERE nEstufaID=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':id', $estufa->getId());
            $stmt->bindValue(':clientefk', $estufa->getClientefk());
            $stmt->bindValue(':marca', $estufa->getMarca());
            $stmt->bindValue(':modelo', $estufa->getModelo());
            $stmt->bindValue(':estadoEstufafk', $estufa->getEstadoEstufa_fK());
            $stmt->bindValue(':informacionAdicional', $estufa->getInformacionAdicional());
            return $stmt->execute();
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function eliminarEstufa($id){
        try{
            $sql = "DELETE FROM tEstufa WHERE nEstufaID=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        }catch(Exception $e){
            die($e->getMessage());
        }
    }
}
