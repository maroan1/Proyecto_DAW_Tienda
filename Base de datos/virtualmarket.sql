-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-02-2020 a las 12:24:11
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `virtualmarket`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritos`
--

CREATE TABLE `carritos` (
  `dniCliente` varchar(9) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `idProducto` int(6) NOT NULL,
  `cantidad` int(4) NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `dniCliente` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `direccion` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `pwd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `administrador` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`dniCliente`, `nombre`, `direccion`, `email`, `pwd`, `administrador`) VALUES
('000000000', 'admin', 'C/Atocha 14', 'admin@midominio.es', '$2y$10$W8Fys/lIo9i6orurKt53cu0n.7lDm2ml93OOuo6e.X95/Ua/ZNH.K', 1),
('00000001', 'Non molestiae dolor ', 'yresgrtges', 'yrtgesyrtges', '$2y$10$WLWEKtcvHfEty0DSVuEiaOegx4sh/aj9LY54IlzQ70VP.R/nkTP9a', 0),
('11111111', 'Non molestiae dolor ', 'ythbstdhbd', 'maroan9@gmail.com', '$2y$10$uKy0C776A3uIRfpzf8aEneFVLDcQSk67rX2nfMnJF8R.8L4EsMqCu', 0),
('111111119', 'MarioRomeu', 'iuniuygcnuyht', 'munij@mailinator.net', '$2y$10$fMhiR4u68MESXkhTXa/pc.PY.vRiABuyVeXofeo10gCGaOj8TGfau', 0),
('11111118', 'Marquitos34', 'Magnam dolor archite', 'hosiw@mailinator.com', '$2y$10$6PUHQ0NIkC1nb3UHkUI7h.ozkhW2w1pLdY4qv9bQ5lXnkmmLoEKHi', 0),
('12345678', 'isabel', 'C/ Virgen del Puerto 3', 'isabel@midominio.es', '$2y$10$1MwUnR3VhpRFNxSdrwYabusrTsABQi/wD8Mhx7svMxlQ5TEe/JM/m', 0),
('19268745', 'pruebaMod', 'Calle modificada', 'ramona@mod.mod', '$2y$10$zZB37Eiunsln8tsn3dHavePI4lmeK.H.PL4TsK7L/N7Ko3gByw.mi', 0),
('22222222', 'maria', 'C/ Moreras 12', 'maria@midominio.es', '$2y$10$MjSBnNWMTj4Uy9n0yCrB2Os71VMq.Cai9cCLH3xn72gEio9qJVr4m', 0),
('33333333', 'jaime', 'Avda Capitï¿½n 102', 'jaime@midominio.es', '$2y$10$5Xb6Mf1SGQK08KNxrrMaQO69yl9B3chaTpGHTPfyoOXDZ1p8hQPdi', 0),
('3rwrq3wr2', 'sfdfsdf', 'sdfsfdsf', 'sdfsdfsdf', '$2y$10$xKfut/drdW3PSc.6ailpVOes4TbsmSZy1sgntzKcBtpe4g.xvm4p.', 0),
('44444444', 'marta', 'C/ Valeras 4', 'marta@midominio.es', '$2y$10$wrwC6iE0d.6Z903wWALkrOqt9..tdwVYLZPUIDX1hJEjV4c77TSB6', 0),
('55555555', 'juan', 'Plaza Miguel de Unamuno', 'juan@midominio.es', '$2y$10$wA5S9tCi4JoSRndeoi0GZeWfCSQ3YiU99hcICMvRfzABiK7LZz1gi', 0),
('66666666', 'manuel', 'C/Atocha 14', 'manuel@midominio.es', '$2y$10$yQUmmBljjH67F5i01FQXh.VJzSR/MVM9i1BWQWzlZLBTzuJEzY.eq', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineaspedidos`
--

CREATE TABLE `lineaspedidos` (
  `idPedido` int(4) NOT NULL,
  `nlinea` int(2) NOT NULL,
  `idProducto` int(6) DEFAULT NULL,
  `cantidad` int(3) NOT NULL,
  `precio` float NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lineaspedidos`
--

INSERT INTO `lineaspedidos` (`idPedido`, `nlinea`, `idProducto`, `cantidad`, `precio`) VALUES
(1, 0, 5, 5, 1),
(1, 1, 3, 10, 1),
(1, 2, 4, 10, 1),
(1, 3, 9, 10, 1),
(1, 4, 7, 7, 1),
(2, 1, 5, 10, 1),
(2, 2, 7, 10, 1),
(3, 1, 2, 1, 1),
(3, 2, 6, 2, 1),
(3, 3, 5, 45, 1),
(4, 1, 6, 2, 1),
(4, 2, 8, 2, 1),
(5, 1, 6, 2, 1),
(5, 2, 8, 2, 1),
(6, 1, 6, 2, 1),
(6, 2, 8, 2, 1),
(7, 1, 6, 2, 1),
(7, 2, 8, 2, 1),
(8, 1, 6, 2, 1),
(8, 2, 8, 2, 1),
(9, 1, 6, 2, 1),
(9, 2, 8, 2, 1),
(10, 1, 6, 2, 1),
(10, 2, 8, 2, 1),
(11, 1, 6, 2, 1),
(11, 2, 8, 2, 1),
(12, 1, 4, 2, 1),
(12, 3, 7, 5, 1),
(13, 2, 4, 1, 1),
(13, 3, 5, 4, 1),
(14, 1, 4, 4, 1),
(16, 1, 4, 3, 1),
(16, 2, 7, 2, 1),
(17, 1, 8, 3, 1),
(17, 2, 4, 3, 1),
(18, 1, 2, 1, 1),
(19, 1, 27, 5, 1),
(19, 2, 2, 6, 1),
(20, 1, 9, 5, 1),
(20, 2, 2, 1, 1),
(20, 3, 27, 2, 1),
(26, 1, 4, 3, 23),
(26, 2, 4, 3, 23),
(26, 3, 4, 3, 23),
(27, 1, 2, 1, 15.26),
(27, 2, 4, 2, 30.69),
(27, 3, 5, 3, 1),
(30, 1, 8, 1, 1),
(30, 2, 9, 2, 1),
(31, 1, 5, 1, 1),
(31, 2, 8, 1, 1),
(32, 1, 2, 1, 15.26),
(32, 2, 5, 1, 1),
(34, 1, 5, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(4) NOT NULL,
  `fecha` date NOT NULL,
  `dirEntrega` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nTarjeta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fechaCaducidad` date DEFAULT NULL,
  `matriculaRepartidor` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dniCliente` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`idPedido`, `fecha`, `dirEntrega`, `nTarjeta`, `fechaCaducidad`, `matriculaRepartidor`, `dniCliente`) VALUES
(1, '2016-01-20', 'C/ Valeras, 22', '111111', '2020-02-02', 'pbf-1144', '11111111'),
(2, '2016-02-10', 'C/ Princesa, 15', '333333', '2020-02-02', 'bbc-2589', '33333333'),
(3, '2019-11-09', '', NULL, NULL, NULL, '11111111'),
(5, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(7, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(8, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(9, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(10, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(11, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(12, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(13, '2019-11-10', '', NULL, NULL, NULL, '11111111'),
(14, '2019-11-10', '', NULL, NULL, NULL, '111111119'),
(15, '2019-11-14', '', NULL, NULL, NULL, '66666666'),
(16, '2019-11-18', '', NULL, NULL, NULL, '22222222'),
(17, '2019-11-18', '', NULL, NULL, NULL, '22222222'),
(18, '2019-11-18', '', NULL, NULL, NULL, '22222222'),
(19, '2019-11-18', '', NULL, NULL, NULL, '22222222'),
(20, '2019-11-18', '', NULL, NULL, NULL, '22222222'),
(21, '2020-02-10', '', NULL, NULL, NULL, '000000000'),
(22, '2020-02-10', '', NULL, NULL, NULL, '000000000'),
(23, '2020-02-10', '', NULL, NULL, NULL, '000000000'),
(24, '2020-02-10', '', NULL, NULL, NULL, '000000000'),
(25, '2020-02-10', '', NULL, NULL, NULL, '000000000'),
(26, '2020-02-10', '', NULL, NULL, NULL, '000000000'),
(27, '2020-02-10', '', NULL, NULL, NULL, '000000000'),
(28, '2020-02-10', '', NULL, NULL, NULL, '000000000'),
(29, '2020-02-10', '', NULL, NULL, NULL, '000000000'),
(30, '2020-02-10', '', NULL, NULL, NULL, '000000000'),
(31, '2020-02-10', '', NULL, NULL, NULL, '000000000'),
(32, '2020-02-10', '', NULL, NULL, NULL, '000000000'),
(33, '2020-02-10', '', NULL, NULL, NULL, '000000000'),
(34, '2020-02-10', '', NULL, NULL, NULL, '000000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int(6) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `idioma` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `autor` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `categoria` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `anyo` int(4) NOT NULL,
  `unidades` int(5) NOT NULL,
  `precio` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `nombre`, `idioma`, `foto`, `autor`, `categoria`, `anyo`, `unidades`, `precio`) VALUES
(2, 'Black Ice', 'italia', 'ACDCblackice.jpg', 'AC/DC', 'seco', 250, 100, 15.26),
(4, 'Sardinillas', 'espa?a', 'Contra3OST.jpg', 'dia', 'seco', 250, 100, 30.69),
(5, 'Mejillones', 'espa?a', 'david-arnold-hot-fuzz-ost.jpg', 'calvo', 'seco', 125, 100, 1),
(6, 'Fideos', 'italia', 'HAZYMOUNTAINSsmallHours.jpg', 'gallo', 'seco', 250, 100, 1),
(7, 'Galletas Cuadradas', 'francia', 'HollyHerndon-platform.jpg', 'gullon', 'seco', 800, 100, 1),
(8, 'Barquillos', 'espa?a', 'johncarpenteranthology-moviethemes-.jpg', 'cuetara', 'seco', 150, 100, 1),
(9, 'Leche entera', 'espa?a', 'SisterSmirkAnimals.jpg', 'pascual', 'frio', 1000, 100, 1),
(27, 'Back in Black', 'idioma', 'ACDC-back-in-black_512x.progressive.jpg', 'AC/DC', '', 0, 100, 19.99);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`dniCliente`);

--
-- Indices de la tabla `lineaspedidos`
--
ALTER TABLE `lineaspedidos`
  ADD PRIMARY KEY (`idPedido`,`nlinea`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
