-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 10-05-2023 a las 21:00:20
-- Versión del servidor: 10.6.12-MariaDB-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.2-1ubuntu2.11

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
  `ubicacion` varchar(50) NOT NULL,
  `direccion` varchar(120) NOT NULL,
  `MD5` varchar(75) NOT NULL,
  `usb` varchar(12) NOT NULL,
  `report` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `archivos`
--

INSERT INTO `archivos` (`ID`, `nombre`, `ubicacion`, `direccion`, `MD5`, `usb`, `report`) VALUES
(1, 'test', 'test', 'test', 'test', '1', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id_gr` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `propietario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id_gr`, `nombre`, `propietario`) VALUES
(1, 'patata', 1);

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
(1, 7);

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
('1', 'USB de Oscar', '', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usu` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `pass` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usu`, `nombre`, `pass`) VALUES
(1, 'invitado', 'invitado'),
(2, 'DBgod', 'DBgod'),
(3, 'DBusu', 'DBusu'),
(4, 'DBruben', 'DBruben');

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id_gr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD CONSTRAINT `archivos_ibfk_1` FOREIGN KEY (`usb`) REFERENCES `usb` (`id_usb`);

--
-- Filtros para la tabla `ubic`
--
ALTER TABLE `ubic`
  ADD CONSTRAINT `ubic_ibfk_1` FOREIGN KEY (`id_gr`) REFERENCES `grupo` (`id_gr`),
  ADD CONSTRAINT `ubic_ibfk_2` FOREIGN KEY (`id_usu`) REFERENCES `usuarios` (`id_usu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
