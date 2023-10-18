-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 17-10-2023 a las 19:24:04
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `novosga2019`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usu_serv`
--

CREATE TABLE `usu_serv` (
  `unidade_id` int(11) NOT NULL,
  `servico_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usu_serv`
--

INSERT INTO `usu_serv` (`unidade_id`, `servico_id`, `usuario_id`) VALUES
(1, 1, 409),
(1, 1, 472),
(1, 1, 474),
(1, 1, 480),
(1, 1, 481),
(1, 61, 417),
(1, 63, 460),
(1, 63, 465),
(1, 63, 472),
(1, 63, 474),
(1, 63, 480),
(1, 63, 481),
(1, 65, 412),
(1, 65, 446),
(1, 65, 472),
(1, 65, 474),
(1, 65, 480),
(1, 65, 481),
(1, 74, 487),
(1, 82, 435),
(1, 82, 436),
(1, 82, 437),
(1, 82, 438),
(1, 82, 439),
(1, 82, 440),
(1, 82, 441),
(1, 82, 442),
(1, 82, 443),
(1, 82, 444),
(1, 82, 445),
(1, 82, 472),
(1, 82, 474),
(1, 82, 480),
(1, 82, 481),
(1, 87, 433),
(1, 87, 434),
(1, 87, 468),
(1, 87, 472),
(1, 87, 474),
(1, 87, 480),
(1, 87, 481),
(1, 97, 461),
(1, 97, 463),
(1, 97, 472),
(1, 97, 474),
(1, 97, 480),
(1, 97, 481),
(1, 127, 410),
(1, 127, 429),
(1, 127, 430),
(1, 127, 431),
(1, 127, 432),
(1, 127, 472),
(1, 127, 474),
(1, 127, 480),
(1, 127, 481),
(1, 130, 466),
(1, 130, 472),
(1, 130, 474),
(1, 130, 475),
(1, 130, 480),
(1, 130, 481),
(1, 147, 447),
(1, 147, 448),
(1, 147, 449),
(1, 147, 464),
(1, 147, 472),
(1, 147, 474),
(1, 147, 480),
(1, 147, 481),
(1, 147, 489),
(1, 157, 413),
(1, 157, 446),
(1, 157, 472),
(1, 157, 474),
(1, 157, 480),
(1, 157, 481),
(1, 158, 480),
(1, 158, 481),
(1, 259, 411),
(1, 259, 418),
(1, 259, 419),
(1, 259, 420),
(1, 259, 421),
(1, 259, 422),
(1, 259, 423),
(1, 259, 424),
(1, 259, 425),
(1, 259, 426),
(1, 259, 427),
(1, 259, 428),
(1, 259, 472),
(1, 259, 474),
(1, 259, 480),
(1, 259, 481),
(1, 259, 483),
(1, 259, 485),
(1, 260, 467),
(1, 260, 472),
(1, 260, 474),
(1, 260, 480),
(1, 260, 481),
(1, 260, 484),
(1, 265, 451),
(1, 265, 452),
(1, 265, 453),
(1, 265, 454),
(1, 265, 455),
(1, 265, 456),
(1, 265, 470),
(1, 265, 471),
(1, 265, 472),
(1, 265, 474),
(1, 265, 480),
(1, 265, 481),
(1, 273, 450),
(1, 273, 472),
(1, 273, 474),
(1, 273, 480),
(1, 273, 481),
(1, 302, 457),
(1, 302, 458),
(1, 302, 459),
(1, 302, 469),
(1, 302, 472),
(1, 302, 474),
(1, 302, 480),
(1, 302, 481),
(1, 302, 488),
(1, 334, 450),
(1, 334, 472),
(1, 334, 474),
(1, 334, 480),
(1, 334, 481),
(1, 336, 414),
(1, 336, 446),
(1, 336, 472),
(1, 336, 474),
(1, 336, 480),
(1, 336, 481),
(1, 612, 6),
(1, 612, 415),
(1, 612, 417),
(1, 612, 462),
(1, 612, 472),
(1, 612, 474),
(1, 612, 480),
(1, 612, 481),
(1, 612, 486),
(1, 701, 450),
(1, 701, 472),
(1, 701, 474),
(1, 701, 480),
(1, 701, 481),
(1, 740, 472),
(1, 740, 474),
(1, 740, 477),
(1, 740, 480),
(1, 740, 481),
(1, 740, 484),
(1, 839, 480),
(1, 839, 481),
(1, 839, 484),
(1, 840, 480),
(1, 840, 481),
(1, 840, 482),
(1, 948, 480),
(1, 948, 481);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usu_serv`
--
ALTER TABLE `usu_serv`
  ADD PRIMARY KEY (`unidade_id`,`servico_id`,`usuario_id`),
  ADD KEY `usu_serv_ibfk_1` (`servico_id`,`unidade_id`),
  ADD KEY `usu_serv_ibfk_2` (`usuario_id`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usu_serv`
--
ALTER TABLE `usu_serv`
  ADD CONSTRAINT `usu_serv_ibfk_1` FOREIGN KEY (`servico_id`,`unidade_id`) REFERENCES `uni_serv` (`servico_id`, `unidade_id`),
  ADD CONSTRAINT `usu_serv_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
