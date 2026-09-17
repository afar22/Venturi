<?php
require_once "core/BaseDatos.php";
require_once "Entities/Cita.php";

class CitaModel extends Conectar {

    public function __construct(){
        parent::__construct();
    }

    public function contarCitas(){
        $sql = "SELECT COUNT(*) as total FROM TCita WHERE dFecha >= CURDATE()";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function obtenerCitasRecientes(){
        try{
            $sql = "SELECT * FROM TCita WHERE dFecha >= CURDATE() ORDER BY dFecha ASC LIMIT 5";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function obtenerTodasLasCitas(){
        try{
            $sql = "SELECT c.*, f.nTotalPago, o.cNombres as nombreOperario
                    FROM TCita c
                    LEFT JOIN TFactura f ON c.nFacturaFK = f.nFacturaid
                    LEFT JOIN TOperario o ON c.nOperarioFK = o.nOperarioid
                    ORDER BY c.dFecha DESC";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function obtenerCitaPorId($id){
        try{
            $sql = "SELECT * FROM TCita WHERE nCitaid = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function crearCita(Cita $cita, $fecha, $descripcion){
        try{
            $sql = "INSERT INTO TCita (cTipoEstufa, nFacturaFK, nOperarioFK, nTipoMantenimientoFK, dFecha, cDescripcion)
                    VALUES (:tipoEstufa, :facturaFK, :operarioFK, :tipoMantFK, :fecha, :descripcion)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':tipoEstufa', $cita->getTipoEstufa());
            $stmt->bindValue(':facturaFK', $cita->getFacturaFk());
            $stmt->bindValue(':operarioFK', $cita->getOperarioFk());
            $stmt->bindValue(':tipoMantFK', $cita->getTipoMantenimientoFk());
            $stmt->bindValue(':fecha', $fecha);
            $stmt->bindValue(':descripcion', $descripcion);
            $stmt->execute();
            return $this->conexion->lastInsertId();
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function eliminarCita($id){
        try{
            $sql = "DELETE FROM TCita WHERE nCitaid=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        }catch(Exception $e){ die($e->getMessage()); }
    }
}