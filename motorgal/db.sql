CREATE DATABASE trafico;
USE trafico;
CREATE TABLE coche(
    matricula CHAR(7) PRIMARY KEY,
    marca VARCHAR(20) NOT NULL,
    modelo VARCHAR(20) NOT NULL,
    color VARCHAR(20)
);

CREATE TABLE conductor(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(40) NOT NULL,
    apellido1 VARCHAR(40) NOT NULL,
    apellido2 VARCHAR(40),
    licencia CHAR(9) NOT NULL
);


INSERT INTO coche (matricula, marca, modelo, color) VALUES
('1234ABC', 'Toyota', 'Corolla', 'Rojo'),
('5678DEF', 'Honda', 'Civic', 'Azul'),
('9101GHI', 'Ford', 'Focus', 'Negro'),
('1121JKL', 'Chevrolet', 'Malibu', 'Blanco'),
('3141MNO', 'BMW', 'Serie 3', 'Gris'),
('5161PQR', 'Audi', 'A4', 'Plata'),
('7181STU', 'Mercedes', 'Clase C', 'Negro'),
('9202VWX', 'Volkswagen', 'Golf', 'Verde'),
('2232YZA', 'Hyundai', 'Elantra', 'Azul'),
('4252BCD', 'Nissan', 'Sentra', 'Rojo'),
('6272EFG', 'Kia', 'Forte', 'Blanco'),
('8292HIJ', 'Mazda', 'Mazda3', 'Negro'),
('0313KLM', 'Subaru', 'Impreza', 'Gris'),
('2333NOP', 'Tesla', 'Model 3', 'Blanco'),
('4353QRS', 'Peugeot', '208', 'Azul'),
('6373TUV', 'Renault', 'Clio', 'Rojo'),
('8393WXY', 'Citroën', 'C3', 'Verde'),
('0414ZAB', 'Fiat', '500', 'Amarillo'),
('2434CDE', 'Jeep', 'Wrangler', 'Negro'),
('4454FGH', 'Volvo', 'XC60', 'Plata');

