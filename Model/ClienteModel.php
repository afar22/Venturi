<?php
require_once "core/BaseDatos.php";
require_once "Entities/Cliente.php";

class ClienteModel extends Conectar {

    public function __construct(){
        parent::__construct();
        $this->asegurarColumnaTelefonoPerfil();
    }

    private function asegurarColumnaTelefonoPerfil(){
        try {
            $stmt = $this->conexion->prepare("SELECT COUNT(*) AS total FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'tPerfil' AND COLUMN_NAME = 'cTelefono'");
            $stmt->execute();
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);

            if ((int)$fila['total'] === 0) {
                $this->conexion->exec("ALTER TABLE tPerfil ADD cTelefono VARCHAR(20) NOT NULL DEFAULT ''");
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
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
                        cTelefono,
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
                        cTelefono,
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

    private function obtenerRolClienteId(){
        $stmt = $this->conexion->prepare("SELECT nRolID FROM tRol WHERE cRol='Cliente' LIMIT 1");
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if($fila) return $fila['nRolID'];

        $this->conexion->prepare("INSERT INTO tRol (cRol) VALUES ('Cliente')")->execute();
        return $this->conexion->lastInsertId();
    }

    public function crearCliente(Cliente $cliente){
        try{
            $rol = $this->obtenerRolClienteId();
            $correo = $cliente->getCorreo();
            $local = $correo;
            $pos = strrpos($local, '@');
            if($pos !== false) $local = substr($local, 0, $pos);
            $nickname = $local !== '' ? substr($local, 0, 25) : substr($cliente->getDocumento(), 0, 25);

            $stmt = $this->conexion->prepare("INSERT INTO tUsuario (cNickname, cCorreo, lEstado, nRolFK, cClave)
                                              VALUES (:nickname, :correo, 1, :rol, :clave)");
            $stmt->bindValue(':nickname', $nickname);
            $stmt->bindValue(':correo', $correo);
            $stmt->bindValue(':rol', $rol);
            $stmt->bindValue(':clave', password_hash($cliente->getDocumento(), PASSWORD_DEFAULT));
            $stmt->execute();
            $idUsuario = $this->conexion->lastInsertId();

            $expedicionId = $this->obtenerCiudadExpedicionId();
            $sql = "INSERT INTO tPerfil (nUsuarioFK, cNombres, cApellidos, eTipo_Documento, cDocumento, cCorreo, cTelefono, nExpedicionFK)
                    VALUES (:usuario, :nombre, :apellido, :tipoDocumento, :documento, :correo, :telefono, :expedicion)";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindValue(':usuario', $idUsuario, PDO::PARAM_INT);
            $sentencia->bindValue(':nombre', $cliente->getNombre());
            $sentencia->bindValue(':apellido', $cliente->getApellido());
            $sentencia->bindValue(':tipoDocumento', $cliente->getTipoDocumento());
            $sentencia->bindValue(':documento', $cliente->getDocumento());
            $sentencia->bindValue(':correo', $cliente->getCorreo());
            $sentencia->bindValue(':telefono', $cliente->getTelefono());
            $sentencia->bindValue(':expedicion', $expedicionId, PDO::PARAM_INT);
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
                        cDocumento=:documento, cTelefono=:telefono, eTipo_Documento=:tipoDocumento
                    WHERE nPerfilID=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':id', $cliente->getId());
            $stmt->bindValue(':nombre', $cliente->getNombre());
            $stmt->bindValue(':apellido', $cliente->getApellido());
            $stmt->bindValue(':correo', $cliente->getCorreo());
            $stmt->bindValue(':documento', $cliente->getDocumento());
            $stmt->bindValue(':telefono', $cliente->getTelefono());
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
