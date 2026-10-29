CREATE DATABASE Venturi_CH4
character set utf8mb4 collate  utf8mb4_general_ci;
use Venturi_CH4;

CREATE TABLE IF NOT EXISTS tRol (
  nRolID int auto_increment not null,
  cRol varchar(25) not null,
  primary key(nRolID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tUsuario (
  nUsuarioID int auto_increment not null,
  cNickname varchar(25) not null,
  cCorreo varchar(55) not null,
  lEstado TINYINT(1) not null default 1,
  nRolFK int not null,
  cClave varchar(75) not null,
  primary key(nUsuarioID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tDepartamento (
  nDepartamentoID int auto_increment not null,
  cDepartamento varchar(25) not null,
  primary key(nDepartamentoID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tCiudad (
  nCiudadID int auto_increment not null,
  cCiudad varchar(25) not null,
  nDepartamentoFK int not null,
  primary key(nCiudadID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tPerfil (
  nPerfilID int auto_increment not null,
  nUsuarioFK int not null,
  cNombres varchar(25) not null,
  cApellidos varchar(25) not null,
  eTipo_Documento enum("Cedula de Ciudadania","Cedula de Extranjeria","Otro") default ("Cedula de Ciudadania") not null,
  cDocumento varchar(10) not null,
  cCorreo varchar(55) not null,
  nExpedicionFK int not null,
  primary key(nPerfilID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tBarrio (
  nBarrioID int auto_increment not null,
  cBarrio varchar(25) not null,
  nCiudadFK int not null,
  cComuna varchar(25) not null,
  primary key(nBarrioID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tLocal (
  nLocalID int auto_increment not null,
  nPerfilFK int not null,
  cDescripcion varchar(80) not null,
  eTipo enum("Residencia","Hotel","Restaurante", "Otro") not null default ("Otro"),
  primary key(nLocalID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tDireccion (
  nDireccionID int auto_increment not null,
  nBarrioFK int not null,
  eTipo enum("Calle","Vereda","Avenida", "Otro") not null default ("Calle"),
  cNumero varchar(10) not null,
  cMatricula varchar(15) not null,
  nLocalFK int not null,
  primary key(nDireccionID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tEstufa (
  nEstufaID int auto_increment not null,
  nClienteFK int not null,
  nTrabajadorFK int not null,
  cMarca varchar(10) not null,
  cModelo varchar(10) not null,
  lEstado TINYINT(1) not null default 1,
  cObservaciones text not null,
  primary key(nEstufaID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tTipo_Servicios (
  nTipo_ServiciosID int auto_increment not null,
  cTipo_Servicios varchar(40) not null,
  cDescripcion varchar(80) not null,
  primary key(nTipo_ServiciosID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tServicios (
  nServiciosID int auto_increment not null,
  nClienteFK int not null,
  nTrabajadorFK int not null,
  nEstufaFK int not null,
  nTipo_ServicioFK int not null,
  cDescripcion varchar(80) not null,
  lEstado TINYINT(1) not null default 1,
  dFecha_Solicitud date not null,
  dFecha_Fin date not null,
  cMotivo_Cancelacion varchar(30) not null,
  primary key(nServiciosID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tCita (
  nCitaID int auto_increment not null,
  nClienteFK int not null,
  nTrabajadorFK int not null,
  nServiciosFK int not null,
  dFecha_Inicio date not null,
  dFecha_Final date not null,
  lEstado TINYINT(1) not null default 1,
  primary key(nCitaID)
) ENGINE=InnoDB;
