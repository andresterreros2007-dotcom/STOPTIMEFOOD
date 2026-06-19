-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-06-2026 a las 03:52:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_sesiones`
--

CREATE TABLE `historial_sesiones` (
  `id_log` int(11) NOT NULL,
  `id_usuario` varchar(15) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `usuario` varchar(13) NOT NULL,
  `fecha_ing` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `historial_sesiones`
--

INSERT INTO `historial_sesiones` (`id_log`, `id_usuario`, `nombre`, `email`, `usuario`, `fecha_ing`) VALUES
(1, '1005', 'Paula', 'paula@gmail.com', 'Admin', '2026-06-15 00:00:00'),
(2, '1007', 'Manuel', 'manu@gmail.com', 'Alman', '2026-06-15 00:00:00'),
(3, '1005', 'Paula', 'paula@gmail.com', 'Admin', '2026-06-15 00:00:00'),
(4, '1002', 'Manuel', 'manuelterreros10@gmail.com', 'Alman', '2026-06-15 18:35:17'),
(5, '1001', 'Nelly', 'nelly@gmail.com', 'Admin', '2026-06-15 18:36:03'),
(6, '1001', 'Nelly', 'nelly@gmail.com', 'Admin', '2026-06-15 20:34:06'),
(7, '1001', 'Nelly', 'nelly@gmail.com', 'Admin', '2026-06-15 20:51:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `producto` varchar(30) NOT NULL,
  `fecha_ing` date NOT NULL,
  `fecha_elab` date NOT NULL,
  `fecha_venc` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria`, `producto`, `fecha_ing`, `fecha_elab`, `fecha_venc`) VALUES
(1, 'panaderia', 'Pan', '2026-06-14', '2026-06-08', '2030-07-20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` varchar(15) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `apellido` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `Contrasenia` varchar(15) NOT NULL,
  `verificarcontrasenia` varchar(15) NOT NULL,
  `restaurante` varchar(30) NOT NULL,
  `usuario` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `email`, `Contrasenia`, `verificarcontrasenia`, `restaurante`, `usuario`) VALUES
('1001', 'Nelly', 'Rodriguez', 'nelly@gmail.com', 'nelly2', 'nelly2', 'El coctel', 'Admin'),
('1002', 'Manuel', 'Torres', 'manuelterreros10@gmail.com', 'manu123', 'manu123', 'El Corral', 'Alman'),
('1003', 'Andres', 'Torres', 'and@gmail.com', 'hola12', 'hola12', 'La Fogata', 'Admin'),
('1004', 'Paul', 'Calderon', 'paul@gmail.com', 'paul23', 'paul23', 'El coctel', 'Alman'),
('1005', 'Paula', 'Rodriguez', 'paula@gmail.com', 'paula23', 'paula23', 'El Corral', 'Admin'),
('1007', 'Manuel', 'Terreros', 'manu@gmail.com', 'canky1', 'canky1', 'Burguer ', 'Alman');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `historial_sesiones`
--
ALTER TABLE `historial_sesiones`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `fk_historial_usuarios` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `historial_sesiones`
--
ALTER TABLE `historial_sesiones`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial_sesiones`
--
ALTER TABLE `historial_sesiones`
  ADD CONSTRAINT `fk_historial_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
