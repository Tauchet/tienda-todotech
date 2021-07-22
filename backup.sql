-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-07-2021 a las 08:31:24
-- Versión del servidor: 8.0.25
-- Versión de PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `software`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `usuario_id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`usuario_id`, `nombre`, `direccion`) VALUES
(1, 'Hogar', 'Cra 19 11N 33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `garantias`
--

CREATE TABLE `garantias` (
  `id` int NOT NULL,
  `codigo` int NOT NULL,
  `problema` varchar(100) NOT NULL,
  `descripcion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `precio` int NOT NULL,
  `stock` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `categoria`, `precio`, `stock`) VALUES
(1, 'PC Core i5 7400f', 'Un computador perfecto para programar', 'computador', 2000000, 2),
(2, 'PC Ryzen 5 5600x RTX 2060', 'Computador ideal para videojuegos y multitarea en general', 'computador', 4500000, 1),
(3, 'Camara Sony 4k', 'Perfecta para captar los momentos que valen la pena', 'video', 3000000, 4),
(4, 'Xbox Series s', 'Consola de alto rendimiento en 2k', 'consola', 1500000, 7),
(5, 'Xbox series x ', 'La consola más potente del mundo, disfruta tus juegos en 4k', 'consola', 2500000, 3),
(6, 'PlayStation 5', 'Disfruta de los videojuegos exclusivos de Sony en resolución 4k', 'consola', 3500000, 2),
(7, 'iPhone 12 Pro Max 256 gb', 'El sistema de cámaras Pro te permite tomar fotos espectaculares con poca luz, y el iPhone 12 Pro Max lleva tu talento fotográfico mucho más allá.', 'celular', 5000000, 4),
(8, '64 GB RAM DDR4', '4 módulos de 16 gb de ram a 3200 mhz', 'componente', 350000, 13),
(9, 'Disco duro 1tb 7200rpm', 'Disco duro 1tb de 7200rpm, al mejor precio del mercado', 'computador', 175000, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `administrador` int NOT NULL DEFAULT '0',
  `contrasenia` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `administrador`, `contrasenia`) VALUES
(1, 'Cristian', 'cristian0415@gmail.com', 1, '123456');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `fecha_compra` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `direccion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `usuario_id`, `fecha_compra`, `direccion`) VALUES
(1, 1, '2021-07-21 20:49:21', 'Cra 19 11N 33'),
(2, 1, '2021-07-21 20:50:16', 'Cra 19 11N 33'),
(3, 1, '2021-07-21 20:53:17', 'Cra 19 11N 33'),
(4, 1, '2021-07-21 20:55:06', 'Cra 19 11N 33'),
(5, 1, '2021-07-21 20:58:26', 'Cra 19 11N 33'),
(6, 1, '2021-07-21 20:58:47', 'Cra 19 11N 33'),
(7, 1, '2021-07-21 20:58:50', 'Cra 19 11N 33'),
(8, 1, '2021-07-21 21:08:05', 'Cra 19 11N 33'),
(9, 1, '2021-07-21 21:08:13', 'Cra 19 11N 33'),
(10, 1, '2021-07-21 21:08:49', 'Cra 19 11N 33'),
(11, 1, '2021-07-21 22:22:25', 'Cra 19 11N 33'),
(12, 1, '2021-07-22 02:10:59', 'Cra 19 11N 33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_producto`
--

CREATE TABLE `ventas_producto` (
  `venta_id` int NOT NULL,
  `producto_id` int NOT NULL,
  `cantidad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ventas_producto`
--

INSERT INTO `ventas_producto` (`venta_id`, `producto_id`, `cantidad`) VALUES
(3, 2, 1),
(3, 4, 1),
(4, 2, 1),
(4, 4, 1),
(5, 2, 1),
(5, 4, 1),
(6, 8, 1),
(10, 2, 9),
(11, 1, 1),
(12, 5, 1),
(12, 6, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `garantias`
--
ALTER TABLE `garantias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `garantias`
--
ALTER TABLE `garantias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
