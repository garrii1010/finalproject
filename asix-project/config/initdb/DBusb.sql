-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: database:3306
-- Tiempo de generación: 29-05-2023 a las 16:28:43
-- Versión del servidor: 10.6.13-MariaDB-1:10.6.13+maria~ubu2004
-- Versión de PHP: 8.1.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `DBusb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE `archivos` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `ubicacion` varchar(100) NOT NULL,
  `direccion` varchar(120) NOT NULL,
  `MD5` varchar(75) NOT NULL,
  `usb` varchar(12) NOT NULL,
  `report` varchar(150) NOT NULL,
  `estado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`ID`, `nombre`, `ubicacion`, `direccion`, `MD5`, `usb`, `report`, `estado`) VALUES
(1, 'test', 'test', 'test', 'test', '1', '', 0),
(2, 'test2', 'test2', 'test2', 'test2', '1', 'test2', 1),
(3, '1.png', '/media/PEPE/1.png', '/uploaded/PEPE/pos/1.png', '9e076561b11bfe0c4563f8a68f0524010906fbdf1c8de76e8651ac1418a5da66', '2', '/reports/PEPE/1.png.json', 0),
(4, '2.png', '/media/PEPE/2.png', '/uploaded/PEPE/pos/1.png', '8d300b8c5290ad717f42086adcfeae0353994046d610b8a0929fc90499275213', '2', '/reports/PEPE/2.png.json', 0),
(5, '3.png', '/media/PEPE/3.png', '/uploaded/PEPE/pos/1.png', '27e0db909c13c2213ca353a0bd8d9ac94297292dba2ff233ff25ce60c02c3f8d', '2', '/reports/PEPE/3.png.json', 0),
(6, '4.png', '/media/PEPE/4.png', '/uploaded/PEPE/pos/1.png', 'fb512d04f4220dc991fad07bad70a08fe160c228540dfde9b095f519f1d7361b', '2', '/reports/PEPE/4.png.json', 0),
(7, 'IndexerVolumeGuid', '/media/PEPE/System Volume Information/IndexerVolumeGuid', '/uploaded/PEPE/pos/1.png', 'd2c11bf7e1c01193da134ac185a0be32d07d172c30598c72a6ac9ab95c658b5d', '2', '/reports/PEPE/IndexerVolumeGuid.json', 0),
(8, 'WPSettings.dat', '/media/PEPE/System Volume Information/WPSettings.dat', '/uploaded/PEPE/pos/1.png', '481a144767b3049f3ace8a0de7740cf0c1797e3459b5d6ada9fb8c3efb2a04be', '2', '/reports/PEPE/WPSettings.dat.json', 0),
(9, '40.png', '/media/PEPE/Folder4/40.png', '/uploaded/PEPE/pos/1.png', 'f98428dc5b6ff219071af0d06c4f46921bbcb37f4388169a6fd45a05d5881ba8', '2', '/reports/PEPE/40.png.json', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id_gr` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `propietario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id_gr`, `nombre`, `propietario`) VALUES
(1, 'patata', 1),
(4, 'safeUSB', 2),
(5, 'demo', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubic`
--

CREATE TABLE `ubic` (
  `id_gr` int(11) DEFAULT NULL,
  `id_usu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubic`
--

INSERT INTO `ubic` (`id_gr`, `id_usu`) VALUES
(1, 1),
(1, 2),
(2, 4),
(2, 3),
(3, 4),
(3, 3),
(1, 7),
(4, 2),
(5, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usb`
--

CREATE TABLE `usb` (
  `id_usb` varchar(12) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `hora` varchar(45) NOT NULL,
  `propietario` int(11) DEFAULT NULL,
  `grupo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usb`
--

INSERT INTO `usb` (`id_usb`, `nombre`, `hora`, `propietario`, `grupo`) VALUES
('1', 'USB de Oscar', '', 3, 1),
('2', 'PEPE', '2023-05-29 15:20:49.176616', 2, 5),
('3', 'PEPE', '2023-05-29 15:31:19.388557', 2, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usu` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `pass` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usu`, `nombre`, `pass`) VALUES
(1, 'invitado', 'invitado'),
(2, 'DBgod', '75b2321fe50f26ae3f9a4be66c9411b7f4e26780aa868bbd4c1643edf1ea52e9');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `usb` (`usb`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id_gr`);

--
-- Indices de la tabla `ubic`
--
ALTER TABLE `ubic`
  ADD KEY `id_gr` (`id_gr`),
  ADD KEY `id_usu` (`id_usu`);

--
-- Indices de la tabla `usb`
--
ALTER TABLE `usb`
  ADD PRIMARY KEY (`id_usb`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usu`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id_gr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD CONSTRAINT `archivos_ibfk_1` FOREIGN KEY (`usb`) REFERENCES `usb` (`id_usb`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
