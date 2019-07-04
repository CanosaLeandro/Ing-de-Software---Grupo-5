-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-06-2019 a las 01:53:50
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ingsoft`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `usuario` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `contrasenia` varchar(45) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotsale`
--

CREATE TABLE `hotsale` (
  `id` int(11) NOT NULL,
  `id_residencia` int(11) NOT NULL,
  `precio` double NOT NULL,
  `id_semana` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `semana`
--

CREATE TABLE `semana` (
  `id` int(11) NOT NULL,
  `id_residencia` int(11) NOT NULL,
  `num_semana` int(11) NOT NULL,
  `anio`  int(4) NOT NULL,
  `disponible` enum('si','no') COLLATE latin1_spanish_ci NOT NULL,
  `en_subasta` enum('si','no') COLLATE latin1_spanish_ci NOT NULL,
  `en_hotsale` enum('si','no') COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puja`
--

CREATE TABLE `puja` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_subasta` int(11) NOT NULL,
  `monto` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id` int(11) NOT NULL,
  `id_residencia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_semana` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `residencia`
--

CREATE TABLE `residencia` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `foto` longblob NOT NULL,
  `capacidad` int(11) NOT NULL,
  `ubicacion` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `direccion` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `en_subasta` enum('si','no') COLLATE latin1_spanish_ci NOT NULL,
  `en_hotsale` enum('si','no') COLLATE latin1_spanish_ci NOT NULL,
  `descrip` text COLLATE latin1_spanish_ci NOT NULL,
  `activo` enum('si','no') COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subasta`
--

CREATE TABLE `subasta` (
  `id` int(11) NOT NULL,
  `id_residencia` int(11) NOT NULL,
  `monto_minimo` double NOT NULL,
  `id_semana` int(11) NOT NULL,
  `inicia` datetime DEFAULT NULL,
  `puja_ganadora` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `apellido` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `nombre` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `contrasenia` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `suscripto` enum('si','no') COLLATE latin1_spanish_ci NOT NULL,
  `tarjeta_credito` bigint(16) NOT NULL,
  `numero_seguridad` int(3) NOT NULL,
  `actualizar` enum('si','no') COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `apellido`, `nombre`, `contrasenia`, `suscripto`, `tarjeta_credito`, `numero_seguridad`, `actualizar`) VALUES
(1, 'matias_lp_97@hotmail.com', 'Tomiello', 'Matias', '1matias1', 'si', 5678998765432125, 520, 'si'),
(2, 'matias@hotmail.com', 'Tomiello', 'Matias', '12443', 'no', 2345346748765490, 90, 'no'),
(3, 'matias_lp_97@hotmail.com.ar', 'Tomiello', 'Matias', '1233214', 'no', 7849485720198756, 324, 'si'),
(4, 'matiastomiello00@gmail.com', 'Tomiello', 'Matias', 'tomiello', 'si', 1234256879980090, 327, 'si'),
(5, 'juani00@gmail.com', 'Juani', 'UnApellido', 'juani', 'no', 2147483647091283, 984, 'no'),
(6, 'HS@yahoo.com.ar', 'Simpson', 'Homero', 'homero', 'no', 2147483647234599, 234, 'no'),
(7, 'BS@gmail.com', 'Simpson', 'Bart', 'barto', 'si', 2147483647444888, 867, 'si'),
(8, 'Ned@hotmail.com', 'Flanders', 'Ned', 'flanders', 'si', 9876543219876543, 987, 'si');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indices de la tabla `hotsale`
--
ALTER TABLE `hotsale`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_hotsale_residencia1_idx` (`id_residencia`),
  ADD KEY `id_residencia_idx` (`id_residencia`),
  ADD KEY `fk_hotsale_semana1_idx` (`id_semana`),
  ADD KEY `id_semana_idx` (`id_semana`);

--
-- Indices de la tabla `semana`
--
ALTER TABLE `semana`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_semana_residencia1_idx` (`id_residencia`),
  ADD KEY `id_residencia_idx` (`id_residencia`);

--
-- Indices de la tabla `puja`
--
ALTER TABLE `puja`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_puja_usuario_idx` (`id_usuario`),
  ADD KEY `fk_puja_subasta_idx` (`id_subasta`),
  ADD KEY `id_usuario_idx` (`id_usuario`),
  ADD KEY `id_subasta_idx` (`id_subasta`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idreserva_UNIQUE` (`id`),
  ADD KEY `fk_reserva_residencia1_idx` (`id_residencia`),
  ADD KEY `fk_reserva_usuario1_idx` (`id_usuario`),
  ADD KEY `fk_reserva_semana1_idx` (`id_semana`),
  ADD KEY `id_residencia_idx` (`id_residencia`),
  ADD KEY `id_usuario_idx` (`id_usuario`),
  ADD KEY `id_semana_idx` (`id_semana`);

--
-- Indices de la tabla `residencia`
--
ALTER TABLE `residencia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idresidencia_UNIQUE` (`id`);

--
-- Indices de la tabla `subasta`
--
ALTER TABLE `subasta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `fk_subasta_residencia1_idx` (`id_residencia`),
  ADD KEY `fk_subasta_semana1_idx` (`id_semana`),
  ADD KEY `id_residencia_idx` (`id_residencia`),
  ADD KEY `id_semana_idx` (`id_semana`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idusuario_UNIQUE` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `hotsale`
--
ALTER TABLE `hotsale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `semana`
--
ALTER TABLE `semana`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `puja`
--
ALTER TABLE `puja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `residencia`
--
ALTER TABLE `residencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `subasta`
--
ALTER TABLE `subasta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `hotsale`
--
ALTER TABLE `hotsale`
  ADD CONSTRAINT `fk_hotsale_residencia1` FOREIGN KEY (`id_residencia`) REFERENCES `residencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_hotsale_semana1` FOREIGN KEY (`id_semana`) REFERENCES `semana` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `semana`
--
ALTER TABLE `semana`
  ADD CONSTRAINT `fk_semana_residencia1` FOREIGN KEY (`id_residencia`) REFERENCES `residencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `puja`
--
ALTER TABLE `puja`
  ADD CONSTRAINT `fk_puja_subasta1` FOREIGN KEY (`id_subasta`) REFERENCES `subasta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_puja_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
  
--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `fk_reserva_residencia1` FOREIGN KEY (`id_residencia`) REFERENCES `residencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reserva_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reserva_semana1` FOREIGN KEY (`id_semana`) REFERENCES `semana` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `subasta`
--
ALTER TABLE `subasta`
  ADD CONSTRAINT `fk_subasta_residencia1` FOREIGN KEY (`id_residencia`) REFERENCES `residencia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_subasta_puja1` FOREIGN KEY (`puja_ganadora`) REFERENCES `puja` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_subasta_semana1` FOREIGN KEY (`id_semana`) REFERENCES `semana` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
