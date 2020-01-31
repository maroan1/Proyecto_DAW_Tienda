-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2019 a las 14:54:42
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

SET SQL_MODE
= "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT
= 0;
START TRANSACTION;
SET time_zone
= "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `virtualmarket`
--

CREATE DATABASE virtualmarket;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes`
(
  `dniCliente` varchar
(9) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar
(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `direccion` varchar
(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar
(75) COLLATE utf8_unicode_ci NOT NULL,
  `pwd` varchar
(255) COLLATE utf8_unicode_ci NOT NULL,
  `administrador` tinyint
(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`
dniCliente`,
`nombre
`, `direccion`, `email`, `pwd`, `administrador`) VALUES
('000000000', 'admin', 'C/Atocha 14', 'admin@midominio.es', '$2y$10$W8Fys/lIo9i6orurKt53cu0n.7lDm2ml93OOuo6e.X95/Ua/ZNH.K', 1),
('111111119', 'Mario', 'iuniuygcnuyht', 'munij@mailinator.net', '$2y$10$fMhiR4u68MESXkhTXa/pc.PY.vRiABuyVeXofeo10gCGaOj8TGfau', 0),
('11111118', 'Marquitos34', 'Magnam dolor archite', 'hosiw@mailinator.com', '$2y$10$6PUHQ0NIkC1nb3UHkUI7h.ozkhW2w1pLdY4qv9bQ5lXnkmmLoEKHi', 0),
('12345678', 'isabel', 'C/ Virgen del Puerto 3', 'isabel@midominio.es', '$2y$10$1MwUnR3VhpRFNxSdrwYabusrTsABQi/wD8Mhx7svMxlQ5TEe/JM/m', 0),
('22222222', 'maria', 'C/ Moreras 12', 'maria@midominio.es', '$2y$10$MjSBnNWMTj4Uy9n0yCrB2Os71VMq.Cai9cCLH3xn72gEio9qJVr4m', 0),
('33333333', 'jaime', 'Avda Capitï¿½n 102', 'jaime@midominio.es', '$2y$10$5Xb6Mf1SGQK08KNxrrMaQO69yl9B3chaTpGHTPfyoOXDZ1p8hQPdi', 0),
('44444444', 'marta', 'C/ Valeras 4', 'marta@midominio.es', '$2y$10$wrwC6iE0d.6Z903wWALkrOqt9..tdwVYLZPUIDX1hJEjV4c77TSB6', 0),
('55555555', 'juan', 'Plaza Miguel de Unamuno', 'juan@midominio.es', '$2y$10$wA5S9tCi4JoSRndeoi0GZeWfCSQ3YiU99hcICMvRfzABiK7LZz1gi', 0),
('66666666', 'manuel', 'C/Atocha 14', 'manuel@midominio.es', '$2y$10$yQUmmBljjH67F5i01FQXh.VJzSR/MVM9i1BWQWzlZLBTzuJEzY.eq', 0),
('77777777', 'Non molestiae dolor ', 'ytfyfjtytfyfgyjtfyj', 'jimodeg@mailinator.net', '$2y$10$o8TLCcJ2fMCBs9768xirluPsXgevTsnJkJ5atBBp//QUnM/tftzqe', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineaspedidos`
--

CREATE TABLE `lineaspedidos`
(
  `idPedido` int
(4) NOT NULL,
  `nlinea` int
(2) NOT NULL,
  `idProducto` int
(6) DEFAULT NULL,
  `cantidad` int
(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lineaspedidos`
--

INSERT INTO `lineaspedidos` (`
idPedido`,
`nlinea
`, `idProducto`, `cantidad`) VALUES
(1, 1, 3, 10),
(1, 2, 4, 10),
(1, 3, 9, 10),
(2, 1, 5, 10),
(2, 2, 7, 10),
(3, 1, 2, 1),
(3, 2, 6, 2),
(3, 3, 5, 45),
(4, 1, 6, 2),
(4, 2, 8, 2),
(5, 1, 6, 2),
(5, 2, 8, 2),
(6, 1, 6, 2),
(6, 2, 8, 2),
(7, 1, 6, 2),
(7, 2, 8, 2),
(8, 1, 6, 2),
(8, 2, 8, 2),
(9, 1, 6, 2),
(9, 2, 8, 2),
(10, 1, 6, 2),
(10, 2, 8, 2),
(11, 1, 6, 2),
(11, 2, 8, 2),
(12, 1, 4, 2),
(12, 2, 1, 3),
(12, 3, 7, 5),
(13, 1, 1, 1),
(13, 2, 4, 1),
(13, 3, 5, 1),
(16, 1, 9, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos`
(
  `idPedido` int
(4) NOT NULL,
  `fecha` date NOT NULL,
  `dirEntrega` varchar
(50) COLLATE utf8_unicode_ci NOT NULL,
  `nTarjeta` varchar
(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fechaCaducidad` date DEFAULT NULL,
  `matriculaRepartidor` varchar
(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dniCliente` varchar
(9) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`
idPedido`,
`fecha
`, `dirEntrega`, `nTarjeta`, `fechaCaducidad`, `matriculaRepartidor`, `dniCliente`) VALUES
(1, '2016-01-20', 'C/ Valeras, 22', '111111', '2020-02-02', 'pbf-1144', '11111111'),
(2, '2016-02-10', 'C/ Princesa, 15', '333333', '2020-02-02', 'bbc-2589', '33333333'),
(3, '2019-11-09', '', NULL, NULL, NULL, '11111111'),
(4, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(5, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(6, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(7, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(8, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(9, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(10, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(11, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(12, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(13, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(14, '2019-11-15', '', NULL, NULL, NULL, '44444444'),
(15, '2019-11-22', '', NULL, NULL, NULL, '33333333'),
(16, '2019-11-18', '', NULL, NULL, NULL, '22222222');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos`
(
  `idProducto` int
(6) NOT NULL,
  `nombre` varchar
(100) COLLATE utf8_unicode_ci NOT NULL,
  `idioma` varchar
(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto` varchar
(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `autor` varchar
(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `categoria` varchar
(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `anyo` int
(4) NOT NULL,
  `unidades` int
(5) NOT NULL,
  `precio` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`
idProducto`,
`nombre
`, `idioma`, `foto`, `autor`, `categoria`, `anyo`, `unidades`, `precio`) VALUES
(1, 'Back in Black', 'italia', 'ACDC-back-in-black_512x.progressive.jpg', 'AC/DC', 'seco', 250, 100, 17.5),
(2, 'Black Ice', 'italia', 'ACDCblackice.jpg', 'AC/DC', 'seco', 250, 100, 1),
(3, 'Atun', 'espa?a', 'CHOPIN_CHOPINS+GREATEST+HITS-538222.jpg', 'calvo', 'seco', 250, 100, 1.01),
(4, 'Contra OST', 'espa?a', 'Contra3OST.jpg', 'dia', 'seco', 250, 100, 30.69),
(5, 'Pelicula OST', 'espa?a', 'david-arnold-hot-fuzz-ost.jpg', 'KAKI', 'seco', 125, 100, 21),
(6, 'Small Hours', 'italia', 'HAZYMOUNTAINSsmallHours.jpg', 'Hazy Mountains', 'seco', 250, 100, 22.81),
(7, 'Platform', 'francia', 'HollyHerndon-platform.jpg', 'Holly Herdnom', 'seco', 800, 100, 1),
(8, 'Barquillos', 'espa?a', 'johncarpenteranthology-moviethemes-.jpg', 'cuetara', 'seco', 150, 100, 1),
(9, 'Leche entera', 'espa?a', 'SisterSmirkAnimals.jpg', 'pascual', 'frio', 1000, 100, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
ADD PRIMARY KEY
(`dniCliente`);

--
-- Indices de la tabla `lineaspedidos`
--
ALTER TABLE `lineaspedidos`
ADD PRIMARY KEY
(`idPedido`,`nlinea`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
ADD PRIMARY KEY
(`idPedido`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
ADD PRIMARY KEY
(`idProducto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int
(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
