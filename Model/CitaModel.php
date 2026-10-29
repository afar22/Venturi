<?php
require_once "core/BaseDatos.php";
require_once "Entities/Cita.php";

class CitaModel extends Conectar {

    public function __construct(){
        parent::__construct();
    }

    public function contarCitas(){
        try{
            $sql = "SELECT COUNT(*) as total FROM tCita WHERE dFecha_Inicio >= CURDATE()";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function obtenerCitasRecientes(){
        try{
            $sql = "SELECT
                        c.nCitaID AS nCitaid,
                        c.dFecha_Inicio AS dFecha,
                        COALESCE(s.cDescripcion, '') AS cDescripcion,
                        COALESCE(e.cMarca, 'N/A') AS cTipoEstufa
                    FROM tCita c
                    LEFT JOIN tServicios s ON s.nServiciosID = c.nServiciosFK
                    LEFT JOIN tEstufa e ON e.nEstufaID = s.nEstufaFK
                    WHERE c.dFecha_Inicio >= CURDATE()
                    ORDER BY c.dFecha_Inicio ASC
                    LIMIT 5";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function obtenerTodasLasCitas(){
        try{
            $sql = "SELECT
                        c.nCitaID AS nCitaid,
                        c.dFecha_Inicio AS dFecha,
                        c.lEstado,
                        COALESCE(s.cDescripcion, '') AS cDescripcion,
                        COALESCE(e.cMarca, 'N/A') AS cTipoEstufa,
                        COALESCE(op.cNombres, '') AS nombreOperario
                    FROM tCita c
                    LEFT JOIN tServicios s ON s.nServiciosID = c.nServiciosFK
                    LEFT JOIN tEstufa e ON e.nEstufaID = s.nEstufaFK
                    LEFT JOIN tPerfil op ON op.nUsuarioFK = c.nTrabajadorFK
                    ORDER BY c.dFecha_Inicio DESC";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function obtenerCitaPorId($id){
        try{
            $sql = "SELECT
                        c.nCitaID AS nCitaid,
                        c.dFecha_Inicio AS dFecha,
                        c.lEstado,
                        c.nServiciosFK,
                        c.nClienteFK,
                        c.nTrabajadorFK,
                        COALESCE(s.cDescripcion, '') AS cDescripcion,
                        COALESCE(e.cMarca, 'N/A') AS cTipoEstufa,
                        COALESCE(op.cNombres, '') AS nombreOperario
                    FROM tCita c
                    LEFT JOIN tServicios s ON s.nServiciosID = c.nServiciosFK
                    LEFT JOIN tEstufa e ON e.nEstufaID = s.nEstufaFK
                    LEFT JOIN tPerfil op ON op.nUsuarioFK = c.nTrabajadorFK
                    WHERE c.nCitaID = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function crearCita(Cita $cita, $fecha, $descripcion){
        try{
            // 1) Se crea primero el servicio (guarda la descripción y la estufa)
            $sqlServicio = "INSERT INTO tServicios (nClienteFK, nTrabajadorFK, nEstufaFK, nTipo_ServicioFK, cDescripcion, lEstado, dFecha_Solicitud, dFecha_Fin, cMotivo_Cancelacion)
                            VALUES (0, :trabajadorFK, :estufaFK, :tipoServicioFK, :descripcion, 1, :fecha, :fecha, '')";
            $stmt = $this->conexion->prepare($sqlServicio);
            $stmt->bindValue(':trabajadorFK', $cita->getOperarioFk());
            $stmt->bindValue(':estufaFK', $cita->getTipoEstufa());
            $stmt->bindValue(':tipoServicioFK', $cita->getTipoMantenimientoFk());
            $stmt->bindValue(':descripcion', $descripcion);
            $stmt->bindValue(':fecha', $fecha);
            $stmt->execute();
            $idServicio = $this->conexion->lastInsertId();

            // 2) Luego la cita referenciando el servicio
            $sqlCita = "INSERT INTO tCita (nClienteFK, nTrabajadorFK, nServiciosFK, dFecha_Inicio, dFecha_Final, lEstado)
                        VALUES (0, :trabajadorFK, :serviciosFK, :fecha, :fecha, 1)";
            $stmt = $this->conexion->prepare($sqlCita);
            $stmt->bindValue(':trabajadorFK', $cita->getOperarioFk());
            $stmt->bindValue(':serviciosFK', $idServicio);
            $stmt->bindValue(':fecha', $fecha);
            $stmt->execute();

            return $this->conexion->lastInsertId();
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function eliminarCita($id){
        try{
            // Recupera el servicio asociado para eliminarlo también
            $stmt = $this->conexion->prepare("SELECT nServiciosFK FROM tCita WHERE nCitaID=:id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $this->conexion->prepare("DELETE FROM tCita WHERE nCitaID=:id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            if($fila && $fila['nServiciosFK']){
                $stmt = $this->conexion->prepare("DELETE FROM tServicios WHERE nServiciosID=:id");
                $stmt->bindValue(':id', $fila['nServiciosFK']);
                return $stmt->execute();
            }
            return true;
        }catch(Exception $e){ die($e->getMessage()); }
    }
}
