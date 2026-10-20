-- Script para crear la base del Maestro de empleados (importar desde phpMyAdmin > Importar,
-- o pegarlo en la pestaña SQL). Crea las 3 tablas pedidas en tablasACrear.pdf.

CREATE DATABASE IF NOT EXISTS bdempleados CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
USE bdempleados;

DROP TABLE IF EXISTS empleados;
DROP TABLE IF EXISTS areas;
DROP TABLE IF EXISTS usuarios;

-- Tabla auxiliar: puebla el campo parametrizable codArea
CREATE TABLE areas (
    codArea         VARCHAR(5)  NOT NULL PRIMARY KEY,
    descripcionArea VARCHAR(60) NOT NULL
) ENGINE=InnoDB;

INSERT INTO areas (codArea, descripcionArea) VALUES
('CCO', 'Cuentas corrientes'),
('COM', 'Compras'),
('CON', 'Contable'),
('DEP', 'Depósito'),
('VEN', 'Ventas');

-- Tabla principal
CREATE TABLE empleados (
    idEmpleado      INT AUTO_INCREMENT PRIMARY KEY,           -- a) clave primaria autonumérica
    legajo          VARCHAR(10)  NOT NULL UNIQUE,             -- b) identificador de registro
    apellidoNombres VARCHAR(80)  NOT NULL,                    -- c) campo descriptivo
    dni             VARCHAR(10)  NOT NULL,
    codArea         VARCHAR(5)   NOT NULL,                    -- d) parametrizable, clave foránea
    sueldoBasico    DOUBLE       NOT NULL DEFAULT 0,          -- e) numérico real
    fechaIngreso    DATE         NOT NULL,                    -- f) fecha
    fotoEmpleado    LONGBLOB     NULL,                        -- g) binario (imagen)
    CONSTRAINT fk_empleados_areas FOREIGN KEY (codArea) REFERENCES areas (codArea)
) ENGINE=InnoDB;

INSERT INTO empleados (legajo, apellidoNombres, dni, codArea, sueldoBasico, fechaIngreso) VALUES
('E-1001', 'Gómez, Lucía',        '30111222', 'CON', 1250000, '2019-03-11'),
('E-1002', 'Pereyra, Martín',     '31222333', 'VEN', 1180000, '2020-07-01'),
('E-1003', 'Suárez, Camila',      '32333444', 'DEP', 1100000, '2021-02-15'),
('E-1004', 'Ferreyra, Nicolás',   '28444555', 'COM', 1320000, '2017-09-04'),
('E-1005', 'Ibáñez, Sofía',       '35555666', 'CCO', 1050000, '2022-05-23'),
('E-1006', 'Rodríguez, Tomás',    '33666777', 'VEN', 1210000, '2018-11-12'),
('E-1007', 'Medina, Valentina',   '36777888', 'CON', 1150000, '2023-01-09'),
('E-1008', 'Acosta, Julián',      '29888999', 'DEP', 1080000, '2016-06-20'),
('E-1009', 'Benítez, Martina',    '37999000', 'COM', 1120000, '2024-03-04'),
('E-1010', 'Castro, Federico',    '34000111', 'CCO', 1190000, '2021-08-30'),
('E-1011', 'Domínguez, Abril',    '38111222', 'VEN', 1015000, '2025-02-17'),
('E-1012', 'Herrera, Santiago',   '27222333', 'CON', 1400000, '2015-04-13');

-- Tabla de usuarios (para el login de los próximos ejercicios)
CREATE TABLE usuarios (
    idUsuario        INT AUTO_INCREMENT PRIMARY KEY,
    login            VARCHAR(30)  NOT NULL UNIQUE,
    apellido         VARCHAR(50)  NOT NULL,
    nombres          VARCHAR(50)  NOT NULL,
    password         VARCHAR(64)  NOT NULL,                   -- hash SHA-256 en hexadecimal
    contadorSesiones INT(5)       NOT NULL DEFAULT 0
) ENGINE=InnoDB;
