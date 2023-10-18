-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 17-10-2023 a las 19:23:46
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
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `sobrenome` varchar(100) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `ult_acesso` datetime DEFAULT NULL,
  `status` smallint(6) NOT NULL,
  `session_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `login`, `nome`, `sobrenome`, `senha`, `ult_acesso`, `status`, `session_id`) VALUES
(1, 'admin', 'MAC CUSCO', 'CUSCO', '30d81c2b428ea156c1cd370e47441d36', '2023-10-17 18:39:45', 1, '458d29104220349d4c8f0eecb92b01d0'),
(450, 'PFARFAN', 'PASCUAL', 'FARFAN', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-17 18:28:49', 1, '58b935ec6c3bc9aeeb090fd8ca3b1044'),
(480, 'mortega', 'MARGARITA', 'ORTEGA', 'e10adc3949ba59abbe56e057f20f883e', '2023-10-17 17:53:27', 1, '867262c9bdde85aa6c645a836dc98ea4'),
(459, 'DSEGOVIA', 'DAYLA', 'SEGOVIA', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-17 17:36:24', 1, '370752a47ac958264659aba75a2c76e4'),
(472, 'aloayza', 'armando', 'LOAYZA', '41a8cfe1555e6bd0a854357b53ece69a', '2023-10-17 17:30:07', 1, '36bd7f2d478085df5c70f960919f9955'),
(460, 'LOSCCO', 'LIZ', 'OSCCO', 'e10adc3949ba59abbe56e057f20f883e', '2023-10-17 17:25:19', 1, '4104abbf870e15d245a89f9ff48ff280'),
(485, 'mpasaporte01', 'migraciones', 'pasaporte', 'e10adc3949ba59abbe56e057f20f883e', '2023-10-17 17:22:35', 1, '99c8268044863449c1b7d0836ad657b3'),
(453, 'MMULTHUAPTFF', 'MARJORIE', 'PALOMINO', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-17 16:23:47', 1, '30bbe842e5d05fdc90ad5833416f0118'),
(484, 'mentregaverif', 'migraciones', 'entrega verificacio', 'e10adc3949ba59abbe56e057f20f883e', '2023-10-17 16:17:20', 1, 'b2b84a3d24ed16053693d7875318fe10'),
(474, 'ehuillca', 'EDWIN', 'HUILLCA ALEGRIA', '25f9e794323b453885f5181f1b624d0b', '2023-10-17 16:14:36', 1, '36bd7f2d478085df5c70f960919f9955'),
(461, 'GZAMBRANO', 'GABRIELA', 'ZAMBRANO', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-17 15:59:07', 1, 'f693cf7b35da5c556a13d0d71716e792'),
(448, 'LALVAREZ', 'LIA', 'ALVAREZ', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-17 15:58:43', 1, 'aa86c90281d07ca869ffa3f27a206b56'),
(446, 'HVENERO', 'HELBERT', 'VENERO', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-17 15:51:37', 1, '5da15972892baebc9f45178c37671599'),
(483, 'mpasaporte02', 'migraciones', 'pasaporte', 'e10adc3949ba59abbe56e057f20f883e', '2023-10-17 15:17:01', 1, '20c32dadb5b9ff4b6f27a8dfe06365a3'),
(481, 'djalixto', 'DELIA ', 'JALIXTO ', 'e10adc3949ba59abbe56e057f20f883e', '2023-10-17 15:02:46', 1, '867262c9bdde85aa6c645a836dc98ea4'),
(429, 'GCARDENAS', 'GUIDO', 'CARDENAS', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-17 14:08:05', 1, '4e1882643d43469b8bc6d5ccf124d252'),
(434, 'WDORADO', 'WILSON', 'DORADO', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-17 13:34:31', 1, 'af02c0dac73762c0d6a478757acf560a'),
(488, 'jcastro', 'JOSSELINE YAJAIDA', 'CASTRO ORTIZ', 'e10adc3949ba59abbe56e057f20f883e', '2023-10-17 13:25:57', 1, '3c2db746faba304cc2d3e52f67c3ecba'),
(487, 'cjaramillo', 'CRUZBEL ', 'CRUZ JARAMILLO', 'e10adc3949ba59abbe56e057f20f883e', '2023-10-17 12:21:30', 1, 'f92c24f9e65c684f47edca5eae9bbcb6'),
(475, 'jalvarez', 'JOSE ENRRIQUE', 'ALVAREZ HUAMANI', 'e10adc3949ba59abbe56e057f20f883e', '2023-10-17 12:19:31', 1, '531c9a4d0065840f576b8405b737362b'),
(457, 'MALVAREZ', 'MELVIN', 'ALVAREZ', '92ff5b227edaafe3f9306ea67b1439d2', '2023-10-17 12:01:18', 1, '3d41d48335c6deb85028155fed0268e7'),
(454, 'LVALENCIA', 'LUCERO', 'VALENCIA', '397cf4899455caf7fd956ba500889c0a', '2023-10-17 08:15:05', 1, '30bbe842e5d05fdc90ad5833416f0118'),
(433, 'CORTIZ', 'CARLOS', 'ORTIZ', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-17 08:12:23', 1, '488871678198ea41fd047369b1c851cd'),
(442, 'NMAMANI', 'NANCY', 'MAMANI', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-16 16:53:29', 1, 'ea778e2a4bb0536fdb608ba4506284da'),
(486, 'rhuanca', 'ROXANA', 'IMA HUANCA', 'e10adc3949ba59abbe56e057f20f883e', '2023-10-16 10:46:36', 1, 'cd0bf73bf12c0175576b96bc2ec587fc'),
(482, 'menrolamiento', 'migraciones', 'enrolamiento', 'e10adc3949ba59abbe56e057f20f883e', '2023-10-16 08:05:49', 1, 'edbc67288ee736f1b8735ead896e1d9c'),
(409, 'banconacion1', 'banconacion1', 'banconacion1', 'e10adc3949ba59abbe56e057f20f883e', '2023-10-13 14:21:55', 1, 'ed82c16e9a34744c5cd81c54a29738df'),
(407, 'ecortez', 'Erik', 'Cortez', 'a5cb78ab8a7f2e5e21bf6683ffd97ab3', '2023-10-13 09:03:28', 1, '238fc51fcbde725c74b5cff94d9a6bcf'),
(476, 'supervisor1', 'supervisor1', 'supervisor1', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-12 14:58:44', 1, 'f97e6393808ff7ea7d7b1dcd88483bab'),
(477, 'mverificaciones', 'mverificaciones', 'mverificaciones', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-12 12:23:06', 1, '2e1fd31da43aedf2297021c77c265404'),
(467, 'mentregas', 'mentregas', 'mentregas', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-12 12:22:32', 1, '436f4b52057f9df6cef17faf56f1e632'),
(426, 'PAPARICIO', 'PATRICIA', 'APARICIO', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-12 12:20:21', 1, '436f4b52057f9df6cef17faf56f1e632'),
(451, 'MVALDEIGLESIAS', 'MAGDA', 'VALDEIGLESIAS', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-12 11:07:25', 1, '65114656d30ed036814ed975f98d772c'),
(452, 'MCORBACHO', 'MIJAIL', 'CORBACHO', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-12 11:06:40', 1, '65114656d30ed036814ed975f98d772c'),
(422, 'KNIETO', 'KARLEN', 'NIETO', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-12 10:38:42', 1, '78e8878c104ff990c5d04c0fe6f2437e'),
(418, 'JCALLO', 'JUDIT', 'CALLO', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-12 10:34:08', 1, '4005a52f2ab8eb251625e7f4367bbf7f'),
(415, 'kguzman', 'Karen', 'Guzman', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-12 10:27:15', 1, '1b08129013dc0987dfa09c50d256d962'),
(412, 'reniec1', 'reniec1', 'reniec1', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-12 09:49:58', 1, '576d52b567b049f94ca3dc59c346fbab'),
(473, 'recepcion1', 'recepcion1', 'recepcion1', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-12 09:44:02', 1, '576d52b567b049f94ca3dc59c346fbab'),
(411, 'migraciones1', 'migraciones1', 'migraciones1', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-12 08:58:29', 1, '576d52b567b049f94ca3dc59c346fbab'),
(410, 'inpe1', 'inpe1', 'inpe1', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-12 08:56:49', 1, '576d52b567b049f94ca3dc59c346fbab'),
(462, 'aalvites', 'Ana', 'Alvites', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-11 16:51:24', 1, 'd3473ce3e3621bdddc14d803bf7bcd54'),
(6, 'RIMAHUANCA', 'ROXANA', 'IMA', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-11 15:04:25', 1, '9738104bfd0c5b8081fc1fa6d442c1d9'),
(445, 'KPUMA', 'KELY', 'PUMA', 'bab4323bce5296937fb9ce31968e4acb', '2023-10-11 12:40:16', 1, '10e6f3a1a34b898ea2ad36a1aedc0b34'),
(427, 'FSERRANO', 'FERNANDO', 'SERRANO', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(424, 'AARAGÓN', 'ADRIANA', 'ARAGÓN', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(423, 'LZEGARRA', 'LUZET', 'ZEGARRA', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(417, 'AMUNOS', 'ANA', 'MUNOZ', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(421, 'MTAMAYO', 'MARIA', 'TAMAYO', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(420, 'MRIVERA', 'MANUEL', 'RIVERA', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(419, 'TRIVERA', 'TERESA', 'RIVERA', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(447, 'RLLAULLE', 'ROSARIO', 'LLAULLE', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(425, 'RVILCAHUAMAN', 'ROSMERY', 'VILCAHUAMAN', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(443, 'EMEZA', 'EVELYN', 'MEZA', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(458, 'EFERNANDEZ', 'EVA', 'FERNANDEZ', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(439, 'DCURASI', 'DIEGO', 'CURASI', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(440, 'LCUTIPA', 'LUZ', 'CUTIPA', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(441, 'LCCHAS\'KA', 'LUZ', 'CCHASKA', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(436, 'CBUSTAMANTE', 'CARMEN', 'BUSTAMANTE', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(444, 'SMOLINA', 'SANDY', 'MOLINA', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(435, 'YANDRADE', 'YOLANDA', 'ANDRADE', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(432, 'YFIGUEROA', 'YENNY', 'FIGUEROA', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(438, 'GCCORI', 'GLADIS', 'CCORI', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(431, 'DSANCHEZ', 'DORIS', 'SANCHEZ', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(449, 'ASHIERLEY', 'SHIERLEY', 'ARAGON', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(437, 'MCCALLO', 'MARIANEL', 'CCALLO', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(456, 'AESQUIVEL', 'AMILCAR', 'ESQUIVEL', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(455, 'EPUMALLICA', 'EDEMIR', 'PUMALLICA', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(428, 'IFARFAN', 'IVETTE', 'FARFAN', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(430, 'AECHEGARAY', 'ALICIA', 'ECHEGARAY', 'bab4323bce5296937fb9ce31968e4acb', '0000-00-00 00:00:00', 1, 'x'),
(408, 'orientador1', 'orientador', 'orientador', 'bab4323bce5296937fb9ce31968e4acb', NULL, 1, ''),
(489, 'saguirre', 'SHIRLEY IVONNE', ' AGUIRRE AGUIRRE', 'e10adc3949ba59abbe56e057f20f883e', NULL, 1, ''),
(414, 'reniec3', 'reniec3', 'reniec3', 'bab4323bce5296937fb9ce31968e4acb', NULL, 1, ''),
(413, 'reniec2', 'reniec2', 'reniec2', 'bab4323bce5296937fb9ce31968e4acb', NULL, 1, ''),
(471, 'grtpe1', 'grtpe1', 'grtpe1', 'bab4323bce5296937fb9ce31968e4acb', NULL, 1, ''),
(470, 'grtc1', 'grtc1', 'grtc1', 'bab4323bce5296937fb9ce31968e4acb', NULL, 1, ''),
(469, 'gercetur1', 'gercetur1', 'gercetur1', 'bab4323bce5296937fb9ce31968e4acb', NULL, 1, ''),
(468, 'sunarp1', 'sunarp1', 'sunarp1', 'bab4323bce5296937fb9ce31968e4acb', NULL, 1, ''),
(466, 'macexpress1', 'macexpress1', 'macexpress1', 'bab4323bce5296937fb9ce31968e4acb', NULL, 1, ''),
(465, 'poderjudicial1', 'poderjudicial1', 'poderjudicial1', 'bab4323bce5296937fb9ce31968e4acb', NULL, 1, ''),
(464, 'essalud1', 'essalud1', 'essalud1', 'bab4323bce5296937fb9ce31968e4acb', NULL, 1, ''),
(463, 'sunedu1', 'sunedu1', 'sunedu1', 'bab4323bce5296937fb9ce31968e4acb', NULL, 1, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=490;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
