<?php
require_once "core/BaseDatos.php";
require_once "Entities/Estufa.php";

class EstufaModel extends Conectar {

    public function __construct(){
        parent::__construct();
        $this->asegurarColumnaTipoEstufa();
    }

    private function asegurarColumnaTipoEstufa(){
        try {
            $stmt = $this->conexion->prepare("SELECT COUNT(*) AS total FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tEstufa' AND COLUMN_NAME = 'cTipoEstufa'");
            $stmt->execute();
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);

            if ((int)$fila['total'] === 0) {
                $this->conexion->exec("ALTER TABLE tEstufa ADD cTipoEstufa VARCHAR(30) NOT NULL DEFAULT 'Otro'");
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
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
                        e.cTipoEstufa,
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
                        cTipoEstufa,
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
                        cTipoEstufa,
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
                        e.cTipoEstufa,
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

    private function obtenerTrabajadorDefectoId(){
        $stmt = $this->conexion->prepare("SELECT u.nUsuarioID FROM tUsuario u INNER JOIN tRol r ON r.nRolID = u.nRolFK WHERE r.cRol = 'Operario' ORDER BY u.nUsuarioID ASC LIMIT 1");
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if($fila) return (int)$fila['nUsuarioID'];

        $stmt = $this->conexion->prepare("SELECT nRolID FROM tRol WHERE cRol = 'Operario' LIMIT 1");
        $stmt->execute();
        $rol = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$rol){
            $this->conexion->prepare("INSERT INTO tRol (cRol) VALUES ('Operario')")->execute();
            $rolId = $this->conexion->lastInsertId();
        } else {
            $rolId = $rol['nRolID'];
        }

        $stmt = $this->conexion->prepare("INSERT INTO tUsuario (cNickname, cCorreo, lEstado, nRolFK, cClave)
                                          VALUES ('operario_default', 'operario@local', 1, :rolId, :clave)");
        $stmt->bindValue(':rolId', $rolId, PDO::PARAM_INT);
        $stmt->bindValue(':clave', password_hash('123456', PASSWORD_DEFAULT));
        $stmt->execute();

        return (int)$this->conexion->lastInsertId();
    }

    public function crearEstufa(Estufa $estufa){
        try{
            $trabajadorId = $this->obtenerTrabajadorDefectoId();
            $sql = "INSERT INTO tEstufa (nClienteFK, nTrabajadorFK, cTipoEstufa, cMarca, cModelo, lEstado, cObservaciones)
                    VALUES (:clientefk, :trabajadorId, :tipoEstufa, :marca, :modelo, :estadoEstufafk, :informacionAdicional)";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindValue(':clientefk', $estufa->getClientefk(), PDO::PARAM_INT);
            $sentencia->bindValue(':trabajadorId', $trabajadorId, PDO::PARAM_INT);
            $sentencia->bindValue(':tipoEstufa', $estufa->getTipoEstufa());
            $sentencia->bindValue(':marca', $estufa->getMarca());
            $sentencia->bindValue(':modelo', $estufa->getModelo());
            $sentencia->bindValue(':estadoEstufafk', $estufa->getEstadoEstufa_fK(), PDO::PARAM_INT);
            $sentencia->bindValue(':informacionAdicional', $estufa->getInformacionAdicional());
            $sentencia->execute();
            return $this->conexion->lastInsertId();
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function actualizarEstufa(Estufa $estufa){
        try{
            $trabajadorId = $this->obtenerTrabajadorDefectoId();
            $sql = "UPDATE tEstufa
                    SET nClienteFK=:clientefk, nTrabajadorFK=:trabajadorId, cTipoEstufa=:tipoEstufa, cMarca=:marca, cModelo=:modelo,
                        lEstado=:estadoEstufafk, cObservaciones=:informacionAdicional
                    WHERE nEstufaID=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':id', $estufa->getId());
            $stmt->bindValue(':clientefk', $estufa->getClientefk(), PDO::PARAM_INT);
            $stmt->bindValue(':trabajadorId', $trabajadorId, PDO::PARAM_INT);
            $stmt->bindValue(':tipoEstufa', $estufa->getTipoEstufa());
            $stmt->bindValue(':marca', $estufa->getMarca());
            $stmt->bindValue(':modelo', $estufa->getModelo());
            $stmt->bindValue(':estadoEstufafk', $estufa->getEstadoEstufa_fK(), PDO::PARAM_INT);
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
