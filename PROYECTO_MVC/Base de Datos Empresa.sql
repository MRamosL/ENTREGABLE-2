CREATE DATABASE EMPRESA

CREATE TABLE Empleados(
    id INT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    edad INT,
    salario_soles DECIMAL(10, 2),
    area VARCHAR(50)
);

INSERT INTO Empleados (id, nombre, apellido, edad, salario_soles, area) 
VALUES 
    (1, 'Juan', 'Gómez', 30, 2500.00, 'Ventas'),
    (2, 'María', 'López', 28, 2800.00, 'Marketing'),
    (3, 'Carlos', 'Martínez', 35, 3000.00, 'Finanzas'),
    (4, 'Ana', 'Sánchez', 32, 2700.00, 'Recursos Humanos');

CREATE TABLE Dueño(
    id INT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    edad INT,
    salario_soles DECIMAL(10, 2),
    cargo VARCHAR(50)
);

INSERT INTO Dueño (id, nombre, apellido, edad, salario_soles, cargo) 
VALUES 
    (1, 'Eduardo', 'Rodríguez', 45, 10000.00, 'CEO');


CREATE TABLE Areas (
    id INT PRIMARY KEY,
    nombre VARCHAR(50),
    ubicacion VARCHAR(100)
);

INSERT INTO Areas (id, nombre, ubicacion) 
VALUES 
    (1, 'Ventas', 'Piso 1'),
    (2, 'Marketing', 'Piso 2'),
    (3, 'Finanzas', 'Piso 3'),
    (4, 'Recursos Humanos', 'Piso 2');


CREATE TABLE Proyectos (
    id INT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    area_id INT,
    FOREIGN KEY (area_id) REFERENCES areas(id)
);

INSERT INTO Proyectos (id, nombre, descripcion, area_id) 
VALUES 
    (1, 'Campaña de Marketing Digital', 'Lanzamiento de una nueva campaña en redes sociales', 2),
    (2, 'Reestructuración de Finanzas', 'Implementación de un nuevo sistema de contabilidad', 3),
    (3, 'Desarrollo de Software', 'Creación de una nueva aplicación móvil', 4);


CREATE TABLE Clientes (
    id INT PRIMARY KEY,
    nombre VARCHAR(100),
    contacto VARCHAR(100),
    ubicacion VARCHAR(100)

);

INSERT INTO Clientes (id, nombre, contacto, ubicacion) 
VALUES 
    (1, 'ABC Company', 'Juan Pérez', 'Av. 15 de Julio Mz. A Lt. 39 Zona A'),
    (2, 'XYZ Corporation', 'María García', 'Ca. las Prensas 495, San Martín de Porres 15311'),
    (3, 'DEF Enterprises', 'Carlos Ruiz',  'Av. Túpac Amaru 15311, Comas 15311');