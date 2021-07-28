-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-07-2021 a las 21:44:44
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `amigo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `galeria`
--

CREATE TABLE `galeria` (
  `url` varchar(800) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `integrada`
--

CREATE TABLE `integrada` (
  `id_orden` int(30) NOT NULL COMMENT 'Numero de identificación de la orden de trabajo',
  `fecha_orden` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha del registro',
  `placa` varchar(6) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Placa de vehiculo',
  `tipo_serv` varchar(1000) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Tipo de servicio a realizar',
  `observ_cliente` mediumtext COLLATE utf8_spanish2_ci DEFAULT '\'NULL\'',
  `identificacion` varchar(1000) COLLATE utf8_spanish2_ci DEFAULT '''\\''NULL\\''''' COMMENT 'identificación de los mecánicos encargados del servicio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mecanicos`
--

CREATE TABLE `mecanicos` (
  `identificacion` bigint(20) NOT NULL COMMENT 'Identificación de mecánico',
  `nombre` varchar(20) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Nombre de mecánico',
  `apellido` varchar(22) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Apellido  de mecánico',
  `email` varchar(38) COLLATE utf8_spanish2_ci DEFAULT NULL COMMENT 'Email mecánico',
  `telefono` varchar(14) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Numero de celular',
  `especialidad` varchar(100) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Especialidad del mecánico',
  `estado` varchar(9) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Estado del mecánico',
  `fecha_ingreso` date NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha de ingreso usuario.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `id_orden` int(30) NOT NULL COMMENT 'Numero de identificación de la orden de trabajo',
  `fecha_orden` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha del registro',
  `placa` varchar(6) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Placa de vehiculo',
  `conductor` varchar(200) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Conductor del vehículo',
  `recibe` varchar(200) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Nombre de la persona que recibe el vehículo',
  `encargado` varchar(1000) COLLATE utf8_spanish2_ci DEFAULT NULL COMMENT 'Nombre del mecánico encargado del servicio',
  `tipo_serv` varchar(1000) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Tipo de servicio a realizar',
  `observ_cliente` mediumtext COLLATE utf8_spanish2_ci DEFAULT '\'NULL\'',
  `dgmec` mediumtext COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Diagnostico del Mecánico',
  `proced` mediumtext COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Procedimientos realizados',
  `repuest` mediumtext COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Repuestos utilizados',
  `obsad` mediumtext COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Observaciones Adicionales',
  `pendientes` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `dirfotos` varchar(800) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_serv` int(11) NOT NULL,
  `nom_serv` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tvehiculo`
--

CREATE TABLE `tvehiculo` (
  `id_tveh` int(11) NOT NULL,
  `nom_tveh` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `identificacion` bigint(20) NOT NULL COMMENT 'Identificacion de user',
  `nombre` varchar(20) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Nombre de usuario',
  `apellido` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `cargo` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` varchar(9) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Estado del Usuario',
  `foto` varchar(300) COLLATE utf8_spanish2_ci DEFAULT NULL COMMENT 'Foto de usuario',
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL COMMENT 'Clave de email.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`identificacion`, `nombre`, `apellido`, `cargo`, `estado`, `foto`, `pass`) VALUES
(1232, 'Claudia', 'García Contreras', 'supervisor', 'activo', 'public/img/usuarios/stand/default.png', '12345'),
(12345, 'Administrador', 'Adm', 'administrador', 'activo', '6101b216f25d3-тaииег.jpg', '123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `cliente` varchar(200) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Nombres y apellidos del cliente',
  `nom_conduct` varchar(100) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Nombre del conductor',
  `telef1` varchar(100) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Numero telefónico del cliente',
  `email` varchar(100) COLLATE utf8_spanish2_ci DEFAULT '''\\''NULL\\''''' COMMENT 'Email del cliente (opcional)',
  `placa` varchar(6) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Placa de vehiculo',
  `depen` varchar(100) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Dependencia a la que pertenece el vehiculo',
  `color` varchar(30) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Color del vehículo',
  `marca` varchar(30) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Nombre de la compañía fabricante del vehículo',
  `refer` varchar(50) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Referencia a la que pertenece el automotor',
  `serie` varchar(30) COLLATE utf8_spanish2_ci DEFAULT NULL COMMENT 'Serie a la que pertenece la referencia',
  `modelo` int(4) NOT NULL COMMENT 'Año al que pertenece la referencia del vehículo',
  `tipo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Tipo de vehículo',
  `kilometraje` bigint(20) NOT NULL COMMENT 'Kilómetros recorridos por el automotor',
  `pendientes` varchar(50) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Acciones pendientes a realizarle al vehículo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculosant`
--

CREATE TABLE `vehiculosant` (
  `id_cliente` varchar(20) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Identificación del propietario del vehículo',
  `nombres` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `nom_conduct` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `telef1` varchar(100) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Numero telefónico del cliente',
  `telef2` varchar(100) COLLATE utf8_spanish2_ci DEFAULT '''\\''NULL\\''''' COMMENT 'Numero telefónico secundario del cliente (opcional)',
  `email` varchar(100) COLLATE utf8_spanish2_ci DEFAULT '''\\''NULL\\''''' COMMENT 'Email del cliente (opcional)',
  `placa` varchar(6) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Placa de vehiculo',
  `depen` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `color` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `marca` varchar(30) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Nombre de la compañía fabricante del vehículo',
  `refer` varchar(50) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Referencia a la que pertenece el automotor',
  `serie` varchar(30) COLLATE utf8_spanish2_ci DEFAULT NULL COMMENT 'Serie a la que pertenece la referencia',
  `modelo` int(4) NOT NULL COMMENT 'Año al que pertenece la referencia del vehículo',
  `tipo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL COMMENT 'Tipo de vehículo',
  `kilometraje` bigint(20) NOT NULL COMMENT 'Kilómetros recorridos por el automotor',
  `pendientes` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `integrada`
--
ALTER TABLE `integrada`
  ADD PRIMARY KEY (`id_orden`),
  ADD KEY `placa` (`placa`);

--
-- Indices de la tabla `mecanicos`
--
ALTER TABLE `mecanicos`
  ADD PRIMARY KEY (`identificacion`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`id_orden`),
  ADD KEY `placa` (`placa`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_serv`);

--
-- Indices de la tabla `tvehiculo`
--
ALTER TABLE `tvehiculo`
  ADD PRIMARY KEY (`id_tveh`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`identificacion`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`placa`),
  ADD KEY `placa` (`placa`);

--
-- Indices de la tabla `vehiculosant`
--
ALTER TABLE `vehiculosant`
  ADD PRIMARY KEY (`placa`),
  ADD KEY `placa` (`placa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `integrada`
--
ALTER TABLE `integrada`
  MODIFY `id_orden` int(30) NOT NULL AUTO_INCREMENT COMMENT 'Numero de identificación de la orden de trabajo', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `id_orden` int(30) NOT NULL AUTO_INCREMENT COMMENT 'Numero de identificación de la orden de trabajo', AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_serv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `tvehiculo`
--
ALTER TABLE `tvehiculo`
  MODIFY `id_tveh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `identificacion` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'Identificacion de user', AUTO_INCREMENT=1078369337;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
