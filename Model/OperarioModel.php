<?php
require_once "core/BaseDatos.php";
require_once "Entities/Operario.php";

class OperarioModel extends Conectar {

    public function __construct(){
        parent::__construct();
    }

    /* Devuelve el ID del rol "Operario"; lo crea si no existe */
    private function obtenerRolOperarioId(){
        $stmt = $this->conexion->prepare("SELECT nRolID FROM tRol WHERE cRol='Operario' LIMIT 1");
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if($fila) return $fila['nRolID'];

        $this->conexion->prepare("INSERT INTO tRol (cRol) VALUES ('Operario')")->execute();
        return $this->conexion->lastInsertId();
    }

    private function obtenerCiudadExpedicionId(){
        $stmt = $this->conexion->prepare("SELECT nCiudadID FROM tCiudad WHERE cCiudad = 'Sin ciudad' LIMIT 1");
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if($fila) return (int)$fila['nCiudadID'];

        $stmt = $this->conexion->prepare("SELECT nDepartamentoID FROM tDepartamento WHERE cDepartamento = 'Sin departamento' LIMIT 1");
        $stmt->execute();
        $departamento = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$departamento){
            $this->conexion->prepare("INSERT INTO tDepartamento (cDepartamento) VALUES ('Sin departamento')")->execute();
            $departamentoId = $this->conexion->lastInsertId();
        } else {
            $departamentoId = $departamento['nDepartamentoID'];
        }

        $stmt = $this->conexion->prepare("INSERT INTO tCiudad (cCiudad, nDepartamentoFK) VALUES ('Sin ciudad', :departamentoId)");
        $stmt->bindValue(':departamentoId', $departamentoId, PDO::PARAM_INT);
        $stmt->execute();

        return (int)$this->conexion->lastInsertId();
    }

    public function obtenerTodosLosOperarios(){
        try{
            $sql = "SELECT
                        u.nUsuarioID AS nOperarioid,
                        p.cNombres,
                        p.cApellidos,
                        u.cCorreo,
                        '' AS cTtelefono,
                        p.cDocumento AS nDocumento
                    FROM tUsuario u
                    LEFT JOIN tPerfil p ON p.nUsuarioFK = u.nUsuarioID
                    WHERE u.nRolFK = (SELECT nRolID FROM tRol WHERE cRol='Operario' LIMIT 1)";
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
            $sql = "SELECT
                        u.nUsuarioID AS nOperarioid,
                        p.cNombres,
                        p.cApellidos,
                        u.cCorreo,
                        '' AS cTtelefono,
                        p.cDocumento AS nDocumento
                    FROM tUsuario u
                    LEFT JOIN tPerfil p ON p.nUsuarioFK = u.nUsuarioID
                    WHERE u.nUsuarioID = :id";
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
            $rol = $this->obtenerRolOperarioId();

            // Nickname a partir del correo (la entidad no maneja nickname)
            $local = $operario->getCorreo();
            $pos = strrpos($local, '@');
            if($pos !== false) $local = substr($local, 0, $pos);
            $nickname = $local !== '' ? substr($local, 0, 25) : substr($operario->getDocumento(), 0, 25);

            $stmt = $this->conexion->prepare("INSERT INTO tUsuario (cNickname, cCorreo, lEstado, nRolFK, cClave)
                                              VALUES (:nickname, :correo, 1, :rol, :clave)");
            $stmt->bindValue(':nickname', $nickname);
            $stmt->bindValue(':correo', $operario->getCorreo());
            $stmt->bindValue(':rol', $rol);
            $stmt->bindValue(':clave', password_hash($operario->getDocumento(), PASSWORD_DEFAULT));
            $stmt->execute();
            $idUsuario = $this->conexion->lastInsertId();

            $expedicionId = $this->obtenerCiudadExpedicionId();

            $stmt = $this->conexion->prepare("INSERT INTO tPerfil (nUsuarioFK, cNombres, cApellidos, eTipo_Documento, cDocumento, cCorreo, nExpedicionFK)
                                              VALUES (:usuario, :nombre, :apellido, 'Cedula de Ciudadania', :documento, :correo, :expedicion)");
            $stmt->bindValue(':usuario', $idUsuario);
            $stmt->bindValue(':nombre', $operario->getNombre());
            $stmt->bindValue(':apellido', $operario->getApellido());
            $stmt->bindValue(':documento', $operario->getDocumento());
            $stmt->bindValue(':correo', $operario->getCorreo());
            $stmt->bindValue(':expedicion', $expedicionId, PDO::PARAM_INT);
            $stmt->execute();

            return $idUsuario;
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function actualizarOperario(Operario $operario){
        try{
            // tPerfil: nombres, apellidos y documento
            $stmt = $this->conexion->prepare("UPDATE tPerfil SET cNombres=:nombre, cApellidos=:apellido, cDocumento=:documento
                                              WHERE nUsuarioFK=:id");
            $stmt->bindValue(':id', $operario->getId());
            $stmt->bindValue(':nombre', $operario->getNombre());
            $stmt->bindValue(':apellido', $operario->getApellido());
            $stmt->bindValue(':documento', $operario->getDocumento());
            $stmt->execute();

            // tUsuario: correo
            $stmt = $this->conexion->prepare("UPDATE tUsuario SET cCorreo=:correo WHERE nUsuarioID=:id");
            $stmt->bindValue(':id', $operario->getId());
            $stmt->bindValue(':correo', $operario->getCorreo());
            return $stmt->execute();
        }catch(Exception $e){ die($e->getMessage()); }
    }

    public function eliminarOperario($id){
        try{
            $stmt = $this->conexion->prepare("DELETE FROM tEstufa WHERE nTrabajadorFK=:id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            $stmt = $this->conexion->prepare("DELETE FROM tPerfil WHERE nUsuarioFK=:id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            $stmt = $this->conexion->prepare("DELETE FROM tUsuario WHERE nUsuarioID=:id");
            $stmt->bindValue(':id', $id);
            return $stmt->execute();
        }catch(Exception $e){ die($e->getMessage()); }
    }
}
