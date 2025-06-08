-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: mariadb:3306
-- Tiempo de generación: 08-06-2025 a las 21:41:13
-- Versión del servidor: 10.6.19-MariaDB
-- Versión de PHP: 8.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `motorgal`
--
CREATE DATABASE IF NOT EXISTS `motorgal` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `motorgal`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE IF NOT EXISTS `eventos` (
  `id_evento` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_inicio_evento` datetime NOT NULL,
  `fecha_fin_evento` datetime NOT NULL,
  `estado_evento` varchar(20) DEFAULT NULL,
  `limite_plazas` int(11) DEFAULT NULL,
  `requisitos` varchar(30) DEFAULT NULL,
  `lugar` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `foto_evento` varchar(255) NOT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `longitud` decimal(11,8) DEFAULT NULL,
  PRIMARY KEY (`id_evento`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id_evento`, `id_usuario`, `titulo`, `descripcion`, `fecha_inicio_evento`, `fecha_fin_evento`, `estado_evento`, `limite_plazas`, `requisitos`, `lugar`, `precio`, `foto_evento`, `latitud`, `longitud`) VALUES
(1, 4, 'Exhibición Volvo', 'Exhibe tu vehículo Volvo en Lugo en la Av. de Grant Sphere', '2025-06-01 10:55:00', '2025-06-01 11:00:00', 'FINALIZADO', 50, 'Volvo', 'Lugo', 0.00, 'volvo.jpg', NULL, NULL),
(2, 4, 'Concentración de vehículos Porsche', 'Acércate para que admiremos todos tu máquina Porsche que tan enamorado te tiene.', '2025-06-06 09:00:00', '2025-06-06 22:30:00', 'CANCELADO', 30, 'Porsche', 'A Coruña', 10.00, 'Porsche.jpg', NULL, NULL),
(3, 4, 'Gran Premio de Competición BMW', 'Se celebrará en Santiago de Compostela en el circuíto de Vilas un gran premio para ver cual BMW se supera más y hace un mejor tiempo. Y sabéis que dá igual la máquina mientras haya conductor.', '2025-06-09 10:00:00', '2025-06-10 22:30:00', 'ACTIVO', 30, 'Bmw', 'Santiago de Compostela', 15.00, 'BMW.webp', 42.59768300, NULL),
(4, 4, 'Manifestación de vehículos Porsche', 'Venid a mostrarnos a todos vuestras máquinas Porsche más preciadas en Santiago de Compostela, en el aparcamiento de la Ciudad de la Cultura. El más bonito recibirá un premio, y además habrá más sorpresas que desvelaremos en el evento. ¡Nos vemos allí amigos!', '2025-06-07 10:00:00', '2025-06-08 22:30:00', 'ACTIVO', 30, 'Porsche', 'Santiago de Compostela', 0.00, 'evento_683f425a74600.jpg', 42.86308100, -8.50341800);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscribe`
--

CREATE TABLE IF NOT EXISTS `inscribe` (
  `id_usuario` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `fecha_inscripcion` datetime DEFAULT NULL,
  PRIMARY KEY (`id_usuario`,`id_evento`),
  KEY `id_evento` (`id_evento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inscribe`
--

INSERT INTO `inscribe` (`id_usuario`, `id_evento`, `fecha_inscripcion`) VALUES
(5, 1, '2025-05-30 23:15:12'),
(5, 2, '2025-06-05 17:39:19'),
(5, 3, '2025-06-02 21:19:18'),
(6, 2, '2025-06-05 19:40:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(9) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `correo_electronico` varchar(100) DEFAULT NULL,
  `username` varchar(30) NOT NULL,
  `contrasinal` varchar(255) DEFAULT NULL,
  `tipo_usuario` varchar(50) DEFAULT NULL,
  `estado_usuario` varchar(20) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `dni` (`dni`),
  UNIQUE KEY `correo_electronico` (`correo_electronico`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `dni`, `nombre`, `correo_electronico`, `username`, `contrasinal`, `tipo_usuario`, `estado_usuario`, `foto_perfil`) VALUES
(1, '12345678Z', 'Adrián García', 'adrian@example.com', 'adriangarcia', '2ac753375c8e9e6675b3e8f3c63fd53aea3d4a64', 'PREMIUM', 'ACTIVO', '../img/Porsche.jpg'),
(4, '13895654C', 'Candela Mundiña Muiños', 'cande@gmail.com', 'caandelam', 'e665f4d3e9ce97415665f498749cdee4a7ab449c', 'PREMIUM', 'ACTIVO', '../img/Porsche.jpg'),
(5, '54226670F', 'Adrián García Álvarez', 'adrian@gmail.com', 'alsonder', '9627956c5f4b00eec8b129e114ea46f60e134a70', 'NORMAL', 'ACTIVO', '../img/Porsche.jpg'),
(6, '19843914C', 'Pedro Vázquez', 'pedrovazquez@gmail.com', 'pedrovazquez', '97afe14706199c2a34cec1a3e7d2c0dfcc5c58c1', 'NORMAL', 'ACTIVO', '../img/Porsche.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE IF NOT EXISTS `vehiculos` (
  `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `matricula` varchar(15) DEFAULT NULL,
  `marca` enum('Audi','Bmw','Citroën','Fiat','Hyundai','Mercedes-Benz','Porsche','Renault','Tesla','Toyota','Volkswagen','Volvo') DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_vehiculo`),
  UNIQUE KEY `matricula` (`matricula`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id_vehiculo`, `id_usuario`, `matricula`, `marca`, `modelo`, `anio`) VALUES
(8, 5, '3655FTR', 'Porsche', '911 Carrera', 2017),
(10, 5, '6344RLR', 'Bmw', 'M3 Competition', 2024),
(12, 5, '6244DUV', 'Bmw', 'M2', 2007),
(13, 6, '8699WEE', 'Porsche', 'Cayman S', 2016);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `inscribe`
--
ALTER TABLE `inscribe`
  ADD CONSTRAINT `inscribe_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `inscribe_ibfk_2` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`);

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
