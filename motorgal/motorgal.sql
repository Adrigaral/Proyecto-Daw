-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: mariadb:3306
-- Tiempo de generación: 09-06-2025 a las 22:53:47
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id_evento`, `id_usuario`, `titulo`, `descripcion`, `fecha_inicio_evento`, `fecha_fin_evento`, `estado_evento`, `limite_plazas`, `requisitos`, `lugar`, `precio`, `foto_evento`, `latitud`, `longitud`) VALUES
(1, 4, 'Exhibición Volvo', 'Exhibe tu vehículo Volvo en Lugo en la Av. de Grant Sphere', '2025-06-01 10:55:00', '2025-06-01 11:00:00', 'FINALIZADO', 50, 'Volvo', 'Lugo', 0.00, 'volvo.jpg', NULL, NULL),
(2, 4, 'Concentración de vehículos Porsche', 'Acércate para que admiremos todos tu máquina Porsche que tan enamorado te tiene.', '2025-06-06 09:00:00', '2025-06-06 22:30:00', 'CANCELADO', 30, 'Porsche', 'A Coruña', 10.00, 'Porsche.jpg', NULL, NULL),
(3, 4, 'Gran Premio de Competición BMW', 'Se celebrará en Santiago de Compostela en el circuíto de Vilas un gran premio para ver cual BMW se supera más y hace un mejor tiempo. Y sabéis que dá igual la máquina mientras haya conductor.', '2025-06-09 10:00:00', '2025-06-10 22:30:00', 'EN PROGRESO', 30, 'Bmw', 'Santiago de Compostela', 15.00, 'BMW.webp', 42.59768300, NULL),
(4, 4, 'Manifestación de vehículos Porsche', 'Venid a mostrarnos a todos vuestras máquinas Porsche más preciadas en Santiago de Compostela, en el aparcamiento de la Ciudad de la Cultura. El más bonito recibirá un premio, y además habrá más sorpresas que desvelaremos en el evento. ¡Nos vemos allí amigos!', '2025-06-07 10:00:00', '2025-06-08 22:30:00', 'FINALIZADO', 30, 'Porsche', 'Santiago de Compostela', 0.00, 'evento_683f425a74600.jpg', 42.86308100, -8.50341800),
(6, 4, 'Audi expo en la ciudad de Santiago de Compostela', 'Coches preciosos y con la esencia de cada uno de vosotros.', '2025-06-14 07:30:00', '2025-06-15 23:00:00', 'ACTIVO', 20, 'Audi', 'Santiago de Compostela', 20.00, 'evento_6846b97c32074.webp', 42.81132000, -8.42239400);

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
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
  `id_permiso` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `controller` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_permiso`),
  UNIQUE KEY `uk_controller_action` (`controller`,`action`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `controller`, `action`, `descripcion`) VALUES
(1, 'VehiculoController', 'listarVehiculos', 'Listar vehículos'),
(2, 'VehiculoController', 'insertarVehiculo', 'Insertar vehículo'),
(3, 'VehiculoController', 'eliminarVehiculo', 'Eliminar vehículo'),
(4, 'VehiculoController', 'actualizarVehiculo', 'Actualizar vehículo'),
(5, 'UsuarioController', 'logout', 'Cerrar sesión'),
(9, 'EventoController', 'lista_eventos_activos', 'Listar eventos activos'),
(10, 'EventoController', 'lista_eventos_creados', 'Listar eventos creados por el usuario'),
(11, 'EventoController', 'listarEventosUsuario', 'Listar eventos por usuario'),
(12, 'EventoController', 'ver_evento', 'Ver detalle del evento'),
(13, 'EventoController', 'crear_evento', 'Crear nuevo evento'),
(14, 'EventoController', 'modificar_evento', 'Modificar evento'),
(15, 'EventoController', 'actualizar_estado_manual', 'Actualizar estado del evento manualmente'),
(16, 'EventoController', 'eliminar_evento', 'Eliminar evento'),
(17, 'InscribeController', 'verInscritos', 'Ver inscritos en evento'),
(18, 'InscribeController', 'inscribirse', 'Inscribirse en un evento'),
(19, 'InscribeController', 'quitarInscripcion', 'Cancelar inscripción a un evento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_usuario`
--

CREATE TABLE IF NOT EXISTS `tipos_usuario` (
  `id_tipo_usuario` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(20) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_usuario`),
  UNIQUE KEY `nombre_tipo` (`nombre_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_usuario`
--

INSERT INTO `tipos_usuario` (`id_tipo_usuario`, `nombre_tipo`, `descripcion`) VALUES
(1, 'NORMAL', 'Usuario estándar'),
(2, 'PREMIUM', 'Usuario premium creador de eventos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario_permiso`
--

CREATE TABLE IF NOT EXISTS `tipo_usuario_permiso` (
  `id_tipo_usuario` tinyint(3) UNSIGNED NOT NULL,
  `id_permiso` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_tipo_usuario`,`id_permiso`),
  KEY `fk_tu_permiso_perm` (`id_permiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_usuario_permiso`
--

INSERT INTO `tipo_usuario_permiso` (`id_tipo_usuario`, `id_permiso`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 9),
(1, 11),
(1, 12),
(1, 15),
(1, 18),
(1, 19),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 19);

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
  `estado_usuario` varchar(20) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `id_tipo_usuario` tinyint(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `dni` (`dni`),
  UNIQUE KEY `correo_electronico` (`correo_electronico`),
  KEY `fk_usuarios_tipo` (`id_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `dni`, `nombre`, `correo_electronico`, `username`, `contrasinal`, `estado_usuario`, `foto_perfil`, `id_tipo_usuario`) VALUES
(1, '12345678Z', 'Adrián García', 'adrian@example.com', 'adriangarcia', '2ac753375c8e9e6675b3e8f3c63fd53aea3d4a64', 'ACTIVO', '../img/Porsche.jpg', 2),
(4, '13895654C', 'Candela Mundiña Muiños', 'cande@gmail.com', 'caandelam', 'e665f4d3e9ce97415665f498749cdee4a7ab449c', 'ACTIVO', '../img/Porsche.jpg', 2),
(5, '54226670F', 'Adrián García Álvarez', 'adrian@gmail.com', 'alsonder', '9627956c5f4b00eec8b129e114ea46f60e134a70', 'ACTIVO', '../img/Porsche.jpg', 1),
(6, '19843914C', 'Pedro Vázquez', 'pedrovazquez@gmail.com', 'pedrovazquez', '97afe14706199c2a34cec1a3e7d2c0dfcc5c58c1', 'ACTIVO', '../img/Porsche.jpg', 1);

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
-- Filtros para la tabla `tipo_usuario_permiso`
--
ALTER TABLE `tipo_usuario_permiso`
  ADD CONSTRAINT `fk_tu_permiso_perm` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permiso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tu_permiso_tipo` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipos_usuario` (`id_tipo_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_tipo` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipos_usuario` (`id_tipo_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
