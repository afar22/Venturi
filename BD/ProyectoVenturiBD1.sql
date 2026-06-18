CREATE DATABASE VenturiN2
character set utf8mb4 collate  utf8mb4_general_ci;
use VenturiN2;

CREATE TABLE IF NOT EXISTS TCliente (
  nClienteid int auto_increment,
  cNombres varchar(50),
  cApellidos varchar(50),
  cCorreo varchar(50),
  cTelefono varchar(50),
  cDocumento varchar(10),
  primary key(nClienteid)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS TOperario (
  nOperarioid int auto_increment,
  cNombres varchar(50),
  cApellidos varchar(50),
  cTtelefono varchar(10),
  cCorreo varchar(50),
  nDocumento int(10),
  primary key(nOperarioid)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS TRepuestos (
  nRepuestosid int auto_increment,
  cTipo varchar (50),
  nCantidad int (100),
  lEstado boolean default 1,
  primary key(nRepuestosid)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS TTipoMantenimiento (
  nTipoMantenimientoid int auto_increment,
  cTipoMantenimiento varchar(50),
  primary key(nTipoMantenimientoid)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS TUsuario (
  nUsuarioid int auto_increment,
  eRol enum("Operario","Trabajador","Usuario"),
  cTelefono varchar (10),
  nDocumento int (10),
  lEstado boolean default 1,
  primary key(nUsuarioid)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS TTrabajador (
  nTrabajadorid int auto_increment,
  cNombres varchar(50),
  cApellidos varchar(50),
  cDocumento int(10),
  nRegistroFK int not null,
  nCitaFK int not null,
  primary key(nTrabajadorid)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS TEstadoEstufa (
nEstadoEstufaid int auto_increment,
cEstadoEstufa varchar(150),
  primary key(nEstadoEstufaid)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS TEstufa (
  nEstufaid int auto_increment,
  cTipoEstufa varchar(50),
  cModelo varchar(20),
  cMarcaEstufa varchar(20),
  cInformacionAdicional varchar(150),
  nEstadoEstufafk int not null,
  primary key(nEstufaid)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS TLocal (
  nLocalid int auto_increment,
  cNombres varchar(50),
  cDireccion varchar(50),
  cTelefono varchar(10),
  nEstufafk int not null,
  nRepuestosfk int not null,
  primary key(nLocalid)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS TComentario (
  nComentarioid int auto_increment,
  nComentario varchar(100),
  nClientefk int not null,
  primary key(nComentarioid)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS TMantenimiento (
  nMantenimientoid int auto_increment,
  dFecha date,
  cDescripcion varchar(50),
  nTipoMantenimientofk int not null,
  nEstufafk int not null,
  nOperariofk int not null,
  primary key(nMantenimientoid)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS TReporte (
  nReporteid int auto_increment,
  cDescripcion varchar(120),
  dFecha date,
  nMantenimientofk int not null,
  nComentariofk int not null,
  primary key(nReporteid)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS TFactura (
  nFacturaid int auto_increment,
  nTotalPago int(20),
  dFecha date,
  nClientefk int not null,
  primary key(nFacturaid)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS TCita (
  nCitaid int auto_increment,
  cTipoEstufa varchar(50),
  nFacturaFK int not null,
  nOperarioFK int not null,
  nTipoMantenimientoFK int not null,
  primary key(nCitaid)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS TLogin (
  nLoginid int auto_increment,
  cUsuario varchar(20),
  cPassword varchar (20),
  nUsuariofk int not null,
  primary key(nLoginid)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS TRegistro (
  nRegistroid int auto_increment,
  cPassword varchar(20),
  cCorreo varchar(50),
  nUsuarioFK int not null,
  primary key(nRegistroid)
) ENGINE=InnoDB;