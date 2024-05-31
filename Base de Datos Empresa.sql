-- Crear base de datos Empresa
CREATE DATABASE Empresa;

-- Seleccionar la base de datos
USE Empresa;

-- Crear tabla Empleados
CREATE TABLE Empleados (
    id INT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    edad INT,
    salario_soles DECIMAL(10, 2),
    area VARCHAR(50)
);

-- Insertar datos en la tabla Empleados
INSERT INTO Empleados (id, nombre, apellido, edad, salario_soles, area)
VALUES 
    (1, 'Juan', 'Gómez', 30, 2500.00, 'Ventas'),
    (2, 'María', 'López', 28, 2800.00, 'Marketing'),
    (3, 'Carlos', 'Martínez', 35, 3000.00, 'Finanzas'),
    (4, 'Ana', 'Sánchez', 32, 2700.00, 'Recursos Humanos');

-- Crear tabla Dueño
CREATE TABLE Dueño (
    id INT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    edad INT,
    salario_soles DECIMAL(10, 2),
    cargo VARCHAR(50)
);

-- Insertar datos en la tabla Dueño
INSERT INTO Dueño (id, nombre, apellido, edad, salario_soles, cargo)
VALUES 
    (1, 'Eduardo', 'Rodríguez', 45, 10000.00, 'CEO');

-- Crear tabla Áreas
CREATE TABLE Areas (
    id INT PRIMARY KEY,
    nombre VARCHAR(50),
    ubicacion VARCHAR(100)
);

-- Insertar datos en la tabla Áreas
INSERT INTO Areas (id, nombre, ubicacion)
VALUES 
    (1, 'Ventas', 'Piso 1'),
    (2, 'Marketing', 'Piso 2'),
    (3, 'Finanzas', 'Piso 3'),
    (4, 'Recursos Humanos', 'Piso 2');

-- Crear tabla Proyectos
CREATE TABLE Proyectos (
    id INT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    area_id INT,
    FOREIGN KEY (area_id) REFERENCES Areas(id)
);

-- Insertar datos en la tabla Proyectos
INSERT INTO Proyectos (id, nombre, descripcion, area_id)
VALUES 
    (1, 'Campaña de Marketing Digital', 'Lanzamiento de una nueva campaña en redes sociales', 2),
    (2, 'Reestructuración de Finanzas', 'Implementación de un nuevo sistema de contabilidad', 3),
    (3, 'Desarrollo de Software', 'Creación de una nueva aplicación móvil', 4);

-- Crear tabla Clientes
CREATE TABLE Clientes (
    id INT PRIMARY KEY,
    nombre VARCHAR(100),
    contacto VARCHAR(100),
    ubicacion VARCHAR(100)
);

-- Insertar datos en la tabla Clientes
INSERT INTO Clientes (id, nombre, contacto, ubicacion)
VALUES 
    (1, 'Compañía ABC', 'Juan Pérez', 'Av. 15 de Julio Mz. A Lt. 39 Zona A'),
    (2, 'Corporación XYZ', 'María García', 'Ca. las Prensas 495, San Martín de Porres 15311'),
    (3, 'Empresas DEF', 'Carlos Ruiz', 'Av. Túpac Amaru 15311, Comas 15311');

-- Crear tabla de Inicio de Sesión
CREATE TABLE InicioSesion (
    correo VARCHAR(100) PRIMARY KEY,
    clave CHAR(4)
);

-- Insertar datos en la tabla Inicio de Sesión
INSERT INTO InicioSesion (correo, clave)
VALUES 
    ('juan@example.com', '1234'),
    ('maria@example.com', '5678'),
    ('carlos@example.com', '9101'),
    ('ana@example.com', '1121');
    

