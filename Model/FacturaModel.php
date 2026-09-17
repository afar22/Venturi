<?php
require_once "core/BaseDatos.php";
require_once "Entities/Factura.php";

class FacturaModel extends Conectar {

    public function __construct(){
        parent::__construct();
    }

    public function contarFacturas(){
        $sql = "SELECT COUNT(*) as total FROM TFactura";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function obtenerTodasLasFacturas(){
        try{
            $sql = "SELECT f.*, c.cNombres, c.cApellidos 
                    FROM TFactura f 
                    LEFT JOIN TCliente c ON f.nClientefk = c.nClienteid
                    ORDER BY f.dFecha DESC";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function obtenerFacturaPorId($id){
        try{
            $sql = "SELECT f.*, c.cNombres, c.cApellidos 
                    FROM TFactura f 
                    LEFT JOIN TCliente c ON f.nClientefk = c.nClienteid
                    WHERE f.nFacturaid = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function crearFactura(Factura $factura){
        try{
            $sql = "INSERT INTO TFactura (nTotalPago, dFecha, nClientefk) 
                    VALUES (:totalPago, :fecha, :clientefk)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':totalPago', $factura->getTotalPago());
            $stmt->bindValue(':fecha', $factura->getFecha());
            $stmt->bindValue(':clientefk', $factura->getClienteFk());
            $stmt->execute();
            return $this->conexion->lastInsertId();
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function actualizarFactura(Factura $factura){
        try{
            $sql = "UPDATE TFactura SET nTotalPago=:totalPago, dFecha=:fecha, nClientefk=:clientefk 
                    WHERE nFacturaid=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':id', $factura->getId());
            $stmt->bindValue(':totalPago', $factura->getTotalPago());
            $stmt->bindValue(':fecha', $factura->getFecha());
            $stmt->bindValue(':clientefk', $factura->getClienteFk());
            return $stmt->execute();
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function eliminarFactura($id){
        try{
            $sql = "DELETE FROM TFactura WHERE nFacturaid=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        }catch(Exception $e){ die($e->getMessage()); }
    }
}