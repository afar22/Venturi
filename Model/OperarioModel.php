<?php
require_once "core/BaseDatos.php";
require_once "Entities/Operario.php";

class OperarioModel extends Conectar {

    public function __construct(){
        parent::__construct();
    }

    public function obtenerTodosLosOperarios(){
        try{
            $sql = "SELECT * FROM TOperario";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $lista = [];
            foreach($resultados as $fila){
                $lista[] = new Operario(
                    $fila['nOperarioid'],
                    $fila['cNombres'],
                    $fila['cApellidos'],
                    $fila['cCorreo'],
                    $fila['cTtelefono'],
                    $fila['nDocumento']
                );
            }
            return $lista;
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function obtenerOperarioPorId($id){
        try{
            $sql = "SELECT * FROM TOperario WHERE nOperarioid = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $f = $stmt->fetch(PDO::FETCH_ASSOC);
            if($f) return new Operario($f['nOperarioid'], $f['cNombres'], $f['cApellidos'], $f['cCorreo'], $f['cTtelefono'], $f['nDocumento']);
            return null;
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function crearOperario(Operario $operario){
        try{
            $sql = "INSERT INTO TOperario (cNombres, cApellidos, cCorreo, cTtelefono, nDocumento)
                    VALUES (:nombre, :apellido, :correo, :telefono, :documento)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':nombre', $operario->getNombre());
            $stmt->bindValue(':apellido', $operario->getApellido());
            $stmt->bindValue(':correo', $operario->getCorreo());
            $stmt->bindValue(':telefono', $operario->getTelefono());
            $stmt->bindValue(':documento', $operario->getDocumento());
            $stmt->execute();
            return $this->conexion->lastInsertId();
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function actualizarOperario(Operario $operario){
        try{
            $sql = "UPDATE TOperario SET cNombres=:nombre, cApellidos=:apellido, cCorreo=:correo,
                    cTtelefono=:telefono, nDocumento=:documento WHERE nOperarioid=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':id', $operario->getId());
            $stmt->bindValue(':nombre', $operario->getNombre());
            $stmt->bindValue(':apellido', $operario->getApellido());
            $stmt->bindValue(':correo', $operario->getCorreo());
            $stmt->bindValue(':telefono', $operario->getTelefono());
            $stmt->bindValue(':documento', $operario->getDocumento());
            return $stmt->execute();
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function eliminarOperario($id){
        try{
            $sql = "DELETE FROM TOperario WHERE nOperarioid=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        }catch(Exception $e){ die($e->getMessage()); }
    }
}