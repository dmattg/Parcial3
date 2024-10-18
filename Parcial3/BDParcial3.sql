CREATE DATABASE BDParcial3;
USE BDParcial3;

CREATE TABLE nacionalidad (
    nacionalidad_id TINYINT(3) AUTO_INCREMENT PRIMARY KEY,
    valor VARCHAR(50)
);

CREATE TABLE interes (
    interes_id TINYINT(2) AUTO_INCREMENT PRIMARY KEY,
    valor VARCHAR(100)
);

CREATE TABLE usuario (
    usuario_id INT(10) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    email VARCHAR(50),
    contrasena VARCHAR(50),
    nacionalidad_id TINYINT(3),
    FOREIGN KEY (nacionalidad_id) REFERENCES nacionalidad(nacionalidad_id)
);

CREATE TABLE telefono (
    telefono_id INT(10) AUTO_INCREMENT PRIMARY KEY,
    valor VARCHAR(50),
    usuario_id INT(10),
    FOREIGN KEY (usuario_id) REFERENCES usuario(usuario_id)
);

CREATE TABLE usuario_interes (
    usuario_interes_id INT(10) AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT(10),
    interes_id TINYINT(2),
    FOREIGN KEY (usuario_id) REFERENCES usuario(usuario_id),
    FOREIGN KEY (interes_id) REFERENCES interes(interes_id)
);