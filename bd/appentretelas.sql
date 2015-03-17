-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-03-2015 a las 08:55:14
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `appentretelas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE IF NOT EXISTS `compras` (
`idCompra` int(6) NOT NULL,
  `rutProveedor` int(10) NOT NULL,
  `codDocCompra` tinyint(2) NOT NULL DEFAULT '1',
  `numeroDocCompra` mediumint(7) NOT NULL DEFAULT '0',
  `codProducto` varchar(12) NOT NULL,
  `cantidadComprada` float NOT NULL,
  `valorCompraNetoProducto` int(5) NOT NULL DEFAULT '0',
  `fechaCompra` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`idCompra`, `rutProveedor`, `codDocCompra`, `numeroDocCompra`, `codProducto`, `cantidadComprada`, `valorCompraNetoProducto`, `fechaCompra`) VALUES
(3, 170678605, 1, 1000, '0030165000', 1, 500, '2015-02-04 22:18:19'),
(4, 170678605, 1, 1000, '0050005000', 2, 450, '2015-02-04 22:18:19'),
(5, 170678605, 1, 1003, '0030165000', 1, 500, '2015-02-04 22:18:45'),
(6, 170678605, 1, 1003, '0050005000', 2, 550, '2015-02-04 22:18:45'),
(7, 170678605, 1, 1002, '0050005000', 1, 550, '2015-02-04 22:19:02'),
(8, 170678605, 1, 1210, '0050005000', 1, 550, '2015-02-05 02:28:59'),
(9, 170678605, 1, 1210, '0250065000', 2, 670, '2015-02-05 02:29:00'),
(10, 170678605, 1, 1021, '0250065000', 2, 670, '2015-02-05 02:44:10'),
(11, 170678605, 1, 1021, '0200147000', 2, 0, '2015-02-05 02:44:10'),
(12, 170678605, 1, 1008, '0050005000', 3, 550, '2015-02-06 23:34:49'),
(13, 112544, 1, 225, '0030165000', 200, 990, '2015-03-08 22:46:42'),
(14, 112544, 1, 225, '0050005000', 100, 1050, '2015-03-08 22:46:42'),
(15, 66564894, 1, 984, '0050005000', 600, 990, '2015-03-08 22:48:40'),
(16, 112544, 1, 879, '1102117848', 100, 990, '2015-03-09 00:19:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comunaschile`
--

CREATE TABLE IF NOT EXISTS `comunaschile` (
  `idComuna` smallint(5) NOT NULL DEFAULT '0',
  `nombreComuna` text,
  `idRegion` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comunaschile`
--

INSERT INTO `comunaschile` (`idComuna`, `nombreComuna`, `idRegion`) VALUES
(1101, 'Iquique', 1),
(1107, 'Alto Hospicio', 1),
(1401, 'Pozo Almonte', 1),
(1402, 'Camiña', 1),
(1403, 'Colchane', 1),
(1404, 'Huara', 1),
(1405, 'Pica', 1),
(2101, 'Antofagasta', 2),
(2102, 'Mejillones', 2),
(2103, 'Sierra Gorda', 2),
(2104, 'Taltal', 2),
(2201, 'Calama', 2),
(2202, 'Ollagüe', 2),
(2203, 'San Pedro de Atacama', 2),
(2301, 'Tocopilla', 2),
(2302, 'María Elena', 2),
(3101, 'Copiapó', 3),
(3102, 'Caldera', 3),
(3103, 'Tierra Amarilla', 3),
(3201, 'Chañaral', 3),
(3202, 'Diego de Almagro', 3),
(3301, 'Vallenar', 3),
(3302, 'Alto del Carmen', 3),
(3303, 'Freirina', 3),
(3304, 'Huasco', 3),
(4101, 'La Serena', 4),
(4102, 'Coquimbo', 4),
(4103, 'Andacollo', 4),
(4104, 'La Higuera', 4),
(4105, 'Paiguano', 4),
(4106, 'Vicuña', 4),
(4201, 'Illapel', 4),
(4202, 'Canela', 4),
(4203, 'Los Vilos', 4),
(4204, 'Salamanca', 4),
(4301, 'Ovalle', 4),
(4302, 'Combarbalá', 4),
(4303, 'Monte Patria', 4),
(4304, 'Punitaqui', 4),
(4305, 'Río Hurtado', 4),
(5101, 'Valparaíso', 5),
(5102, 'Casablanca', 5),
(5103, 'Concón', 5),
(5104, 'Juan Fernández', 5),
(5105, 'Puchuncaví', 5),
(5107, 'Quintero', 5),
(5109, 'Viña del Mar', 5),
(5201, 'Isla de Pascua', 5),
(5301, 'Los Andes', 5),
(5302, 'Calle Larga', 5),
(5303, 'Rinconada', 5),
(5304, 'San Esteban', 5),
(5401, 'La Ligua', 5),
(5402, 'Cabildo', 5),
(5403, 'Papudo', 5),
(5404, 'Petorca', 5),
(5405, 'Zapallar', 5),
(5501, 'Quillota', 5),
(5502, 'Calera', 5),
(5503, 'Hijuelas', 5),
(5504, 'La Cruz', 5),
(5506, 'Nogales', 5),
(5601, 'San Antonio', 5),
(5602, 'Algarrobo', 5),
(5603, 'Cartagena', 5),
(5604, 'El Quisco', 5),
(5605, 'El Tabo', 5),
(5606, 'Santo Domingo', 5),
(5701, 'San Felipe', 5),
(5702, 'Catemu', 5),
(5703, 'Llaillay', 5),
(5704, 'Panquehue', 5),
(5705, 'Putaendo', 5),
(5706, 'Santa María', 5),
(5801, 'Quilpué', 5),
(5802, 'Limache', 5),
(5803, 'Olmué', 5),
(5804, 'Villa Alemana', 5),
(6101, 'Rancagua', 6),
(6102, 'Codegua', 6),
(6103, 'Coinco', 6),
(6104, 'Coltauco', 6),
(6105, 'Doñihue', 6),
(6106, 'Graneros', 6),
(6107, 'Las Cabras', 6),
(6108, 'Machalí', 6),
(6109, 'Malloa', 6),
(6110, 'Mostazal', 6),
(6111, 'Olivar', 6),
(6112, 'Peumo', 6),
(6113, 'Pichidegua', 6),
(6114, 'Quinta de Tilcoco', 6),
(6115, 'Rengo', 6),
(6116, 'Requínoa', 6),
(6117, 'San Vicente', 6),
(6201, 'Pichilemu', 6),
(6202, 'La Estrella', 6),
(6203, 'Litueche', 6),
(6204, 'Marchihue', 6),
(6205, 'Navidad', 6),
(6206, 'Paredones', 6),
(6301, 'San Fernando', 6),
(6302, 'Chépica', 6),
(6303, 'Chimbarongo', 6),
(6304, 'Lolol', 6),
(6305, 'Nancagua', 6),
(6306, 'Palmilla', 6),
(6307, 'Peralillo', 6),
(6308, 'Placilla', 6),
(6309, 'Pumanque', 6),
(6310, 'Santa Cruz', 6),
(7101, 'Talca', 7),
(7102, 'Constitución', 7),
(7103, 'Curepto', 7),
(7104, 'Empedrado', 7),
(7105, 'Maule', 7),
(7106, 'Pelarco', 7),
(7107, 'Pencahue', 7),
(7108, 'Río Claro', 7),
(7109, 'San Clemente', 7),
(7110, 'San Rafael', 7),
(7201, 'Cauquenes', 7),
(7202, 'Chanco', 7),
(7203, 'Pelluhue', 7),
(7301, 'Curicó', 7),
(7302, 'Hualañé', 7),
(7303, 'Licantén', 7),
(7304, 'Molina', 7),
(7305, 'Rauco', 7),
(7306, 'Romeral', 7),
(7307, 'Sagrada Familia', 7),
(7308, 'Teno', 7),
(7309, 'Vichuquén', 7),
(7401, 'Linares', 7),
(7402, 'Colbún', 7),
(7403, 'Longaví', 7),
(7404, 'Parral', 7),
(7405, 'Retiro', 7),
(7406, 'San Javier', 7),
(7407, 'Villa Alegre', 7),
(7408, 'Yerbas Buenas', 7),
(8101, 'Concepción', 8),
(8102, 'Coronel', 8),
(8103, 'Chiguayante', 8),
(8104, 'Florida', 8),
(8105, 'Hualqui', 8),
(8106, 'Lota', 8),
(8107, 'Penco', 8),
(8108, 'San Pedro de la Paz', 8),
(8109, 'Santa Juana', 8),
(8110, 'Talcahuano', 8),
(8111, 'Tomé', 8),
(8112, 'Hualpén', 8),
(8201, 'Lebu', 8),
(8202, 'Arauco', 8),
(8203, 'Cañete', 8),
(8204, 'Contulmo', 8),
(8205, 'Curanilahue', 8),
(8206, 'Los Álamos', 8),
(8207, 'Tirúa', 8),
(8301, 'Los Ángeles', 8),
(8302, 'Antuco', 8),
(8303, 'Cabrero', 8),
(8304, 'Laja', 8),
(8305, 'Mulchén', 8),
(8306, 'Nacimiento', 8),
(8307, 'Negrete', 8),
(8308, 'Quilaco', 8),
(8309, 'Quilleco', 8),
(8310, 'San Rosendo', 8),
(8311, 'Santa Bárbara', 8),
(8312, 'Tucapel', 8),
(8313, 'Yumbel', 8),
(8314, 'Alto Biobío', 8),
(8401, 'Chillán', 8),
(8402, 'Bulnes', 8),
(8403, 'Cobquecura', 8),
(8404, 'Coelemu', 8),
(8405, 'Coihueco', 8),
(8406, 'Chillán Viejo', 8),
(8407, 'El Carmen', 8),
(8408, 'Ninhue', 8),
(8409, 'Ñiquén', 8),
(8410, 'Pemuco', 8),
(8411, 'Pinto', 8),
(8412, 'Portezuelo', 8),
(8413, 'Quillón', 8),
(8414, 'Quirihue', 8),
(8415, 'Ránquil', 8),
(8416, 'San Carlos', 8),
(8417, 'San Fabián', 8),
(8418, 'San Ignacio', 8),
(8419, 'San Nicolás', 8),
(8420, 'Treguaco', 8),
(8421, 'Yungay', 8),
(9101, 'Temuco', 9),
(9102, 'Carahue', 9),
(9103, 'Cunco', 9),
(9104, 'Curarrehue', 9),
(9105, 'Freire', 9),
(9106, 'Galvarino', 9),
(9107, 'Gorbea', 9),
(9108, 'Lautaro', 9),
(9109, 'Loncoche', 9),
(9110, 'Melipeuco', 9),
(9111, 'Nueva Imperial', 9),
(9112, 'Padre las Casas', 9),
(9113, 'Perquenco', 9),
(9114, 'Pitrufquén', 9),
(9115, 'Pucón', 9),
(9116, 'Saavedra', 9),
(9117, 'Teodoro Schmidt', 9),
(9118, 'Toltén', 9),
(9119, 'Vilcún', 9),
(9120, 'Villarrica', 9),
(9121, 'Cholchol', 9),
(9201, 'Angol', 9),
(9202, 'Collipulli', 9),
(9203, 'Curacautín', 9),
(9204, 'Ercilla', 9),
(9205, 'Lonquimay', 9),
(9206, 'Los Sauces', 9),
(9207, 'Lumaco', 9),
(9208, 'Purén', 9),
(9209, 'Renaico', 9),
(9210, 'Traiguén', 9),
(9211, 'Victoria', 9),
(10101, 'Puerto Montt', 10),
(10102, 'Calbuco', 10),
(10103, 'Cochamó', 10),
(10104, 'Fresia', 10),
(10105, 'Frutillar', 10),
(10106, 'Los Muermos', 10),
(10107, 'Llanquihue', 10),
(10108, 'Maullín', 10),
(10109, 'Puerto Varas', 10),
(10201, 'Castro', 10),
(10202, 'Ancud', 10),
(10203, 'Chonchi', 10),
(10204, 'Curaco de Vélez', 10),
(10205, 'Dalcahue', 10),
(10206, 'Puqueldón', 10),
(10207, 'Queilén', 10),
(10208, 'Quellón', 10),
(10209, 'Quemchi', 10),
(10210, 'Quinchao', 10),
(10301, 'Osorno', 10),
(10302, 'Puerto Octay', 10),
(10303, 'Purranque', 10),
(10304, 'Puyehue', 10),
(10305, 'Río Negro', 10),
(10306, 'San Juan de la Costa', 10),
(10307, 'San Pablo', 10),
(10401, 'Chaitén', 10),
(10402, 'Futaleufú', 10),
(10403, 'Hualaihué', 10),
(10404, 'Palena', 10),
(11101, 'Coihaique', 11),
(11102, 'Lago Verde', 11),
(11201, 'Aisén', 11),
(11202, 'Cisnes', 11),
(11203, 'Guaitecas', 11),
(11301, 'Cochrane', 11),
(11302, 'O Higgins', 11),
(11303, 'Tortel', 11),
(11401, 'Chile Chico', 11),
(11402, 'Río Ibáñez', 11),
(12101, 'Punta Arenas', 12),
(12102, 'Laguna Blanca', 12),
(12103, 'Río Verde', 12),
(12104, 'San Gregorio', 12),
(12201, 'Cabo de Hornos', 12),
(12202, 'Antártica', 12),
(12301, 'Porvenir', 12),
(12302, 'Primavera', 12),
(12303, 'Timaukel', 12),
(12401, 'Natales', 12),
(12402, 'Torres del Paine', 12),
(13101, 'Santiago', 13),
(13102, 'Cerrillos', 13),
(13103, 'Cerro Navia', 13),
(13104, 'Conchalí', 13),
(13105, 'El Bosque', 13),
(13106, 'Estación Central', 13),
(13107, 'Huechuraba', 13),
(13108, 'Independencia', 13),
(13109, 'La Cisterna', 13),
(13110, 'La Florida', 13),
(13111, 'La Granja', 13),
(13112, 'La Pintana', 13),
(13113, 'La Reina', 13),
(13114, 'Las Condes', 13),
(13115, 'Lo Barnechea', 13),
(13116, 'Lo Espejo', 13),
(13117, 'Lo Prado', 13),
(13118, 'Macul', 13),
(13119, 'Maipú', 13),
(13120, 'Ñuñoa', 13),
(13121, 'Pedro Aguirre Cerda', 13),
(13122, 'Peñalolén', 13),
(13123, 'Providencia', 13),
(13124, 'Pudahuel', 13),
(13125, 'Quilicura', 13),
(13126, 'Quinta Normal', 13),
(13127, 'Recoleta', 13),
(13128, 'Renca', 13),
(13129, 'San Joaquín', 13),
(13130, 'San Miguel', 13),
(13131, 'San Ramón', 13),
(13132, 'Vitacura', 13),
(13201, 'Puente Alto', 13),
(13202, 'Pirque', 13),
(13203, 'San José de Maipo', 13),
(13301, 'Colina', 13),
(13302, 'Lampa', 13),
(13303, 'Tiltil', 13),
(13401, 'San Bernardo', 13),
(13402, 'Buin', 13),
(13403, 'Calera de Tango', 13),
(13404, 'Paine', 13),
(13501, 'Melipilla', 13),
(13502, 'Alhué', 13),
(13503, 'Curacaví', 13),
(13504, 'María Pinto', 13),
(13505, 'San Pedro', 13),
(13601, 'Talagante', 13),
(13602, 'El Monte', 13),
(13603, 'Isla de Maipo', 13),
(13604, 'Padre Hurtado', 13),
(13605, 'Peñaflor', 13),
(14101, 'Valdivia', 14),
(14102, 'Corral', 14),
(14103, 'Lanco', 14),
(14104, 'Los Lagos', 14),
(14105, 'Máfil', 14),
(14106, 'Mariquina', 14),
(14107, 'Paillaco', 14),
(14108, 'Panguipulli', 14),
(14201, 'La Unión', 14),
(14202, 'Futrono', 14),
(14203, 'Lago Ranco', 14),
(14204, 'Río Bueno', 14),
(15101, 'Arica', 15),
(15102, 'Camarones', 15),
(15201, 'Putre', 15),
(15202, 'General Lagos', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correlativonumticket`
--

CREATE TABLE IF NOT EXISTS `correlativonumticket` (
`numTicket` smallint(5) NOT NULL,
  `rutVendedor` int(10) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Volcado de datos para la tabla `correlativonumticket`
--

INSERT INTO `correlativonumticket` (`numTicket`, `rutVendedor`) VALUES
(17, 170678605),
(18, 170678605),
(19, 171141346),
(20, 171141346),
(21, 170678605),
(22, 170678605),
(23, 170678605),
(24, 171141346),
(25, 170678605),
(26, 171141346),
(27, 171141346),
(28, 171141346),
(29, 171141346),
(30, 170678605),
(31, 171141346),
(32, 171141346),
(33, 171141346),
(34, 171141346),
(35, 170678605),
(36, 171141346),
(37, 171141346),
(38, 170678605),
(39, 170678605),
(40, 171141346),
(41, 170678605),
(42, 171141346),
(43, 171141346),
(44, 170678605),
(45, 171141346),
(46, 170678605),
(47, 170678605),
(48, 170678605),
(49, 170678605),
(50, 170678605),
(51, 170678605),
(52, 170678605),
(53, 171141346),
(54, 170678605),
(55, 170678605);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doccompra`
--

CREATE TABLE IF NOT EXISTS `doccompra` (
  `numeroDocCompra` mediumint(7) NOT NULL DEFAULT '0',
  `rutProveedor` int(10) NOT NULL DEFAULT '0',
  `fechaEmisionDoc` date NOT NULL,
  `totalNeto` mediumint(8) NOT NULL DEFAULT '0',
  `valorIvaDoc` mediumint(8) NOT NULL DEFAULT '0',
  `valorTotalDoc` mediumint(8) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `doccompra`
--

INSERT INTO `doccompra` (`numeroDocCompra`, `rutProveedor`, `fechaEmisionDoc`, `totalNeto`, `valorIvaDoc`, `valorTotalDoc`) VALUES
(225, 112544, '2015-03-08', 303000, 57570, 360570),
(879, 112544, '2015-03-09', 99000, 18810, 117810),
(984, 66564894, '2015-03-08', 594000, 112860, 706860),
(1000, 170678605, '2015-02-01', 1400, 266, 1666),
(1002, 170678605, '2015-02-02', 550, 105, 654),
(1003, 170678605, '2015-02-02', 1600, 304, 1904),
(1008, 170678605, '2015-02-02', 1650, 314, 1963),
(1021, 170678605, '2015-02-02', 1340, 255, 1594),
(1210, 170678605, '2015-02-02', 1890, 359, 2249);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentosdecompra`
--

CREATE TABLE IF NOT EXISTS `documentosdecompra` (
`codDocCompra` tinyint(2) NOT NULL,
  `nombreDocCompra` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `documentosdecompra`
--

INSERT INTO `documentosdecompra` (`codDocCompra`, `nombreDocCompra`) VALUES
(1, 'Factura Afecta'),
(2, 'Factura Exenta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentosdepago`
--

CREATE TABLE IF NOT EXISTS `documentosdepago` (
`codDocPago` tinyint(2) NOT NULL,
  `nombreDocPago` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `documentosdepago`
--

INSERT INTO `documentosdepago` (`codDocPago`, `nombreDocPago`) VALUES
(1, 'Sin definir'),
(2, 'Boleta'),
(3, 'Factura'),
(4, 'Voucher transbank'),
(5, 'Factura afecta'),
(6, 'Factura exenta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locales`
--

CREATE TABLE IF NOT EXISTS `locales` (
`idLocal` tinyint(3) NOT NULL,
  `passLocal` varchar(50) NOT NULL,
  `estadoActivo` tinyint(1) NOT NULL,
  `nombreLocal` varchar(70) NOT NULL,
  `correoLocal` varchar(70) NOT NULL,
  `direccionLocal` varchar(70) NOT NULL,
  `telefonoLocal` int(11) NOT NULL,
  `fechaRegistroLocal` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `locales`
--

INSERT INTO `locales` (`idLocal`, `passLocal`, `estadoActivo`, `nombreLocal`, `correoLocal`, `direccionLocal`, `telefonoLocal`, `fechaRegistroLocal`) VALUES
(1, '123', 1, 'Entre Telas', 'entretelas@gmail.com', 'Chacabuco #123', 82431509, '2014-12-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mediosdepago`
--

CREATE TABLE IF NOT EXISTS `mediosdepago` (
`codMedioPago` tinyint(2) NOT NULL,
  `nombreMedioPago` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `mediosdepago`
--

INSERT INTO `mediosdepago` (`codMedioPago`, `nombreMedioPago`) VALUES
(1, 'Sin definir'),
(2, 'Efectivo'),
(3, 'Cheque'),
(4, 'Transbank'),
(5, 'Crédito'),
(6, 'Orden de compra'),
(7, 'Depósito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `codProducto` varchar(12) NOT NULL,
  `nombreProducto` varchar(150) NOT NULL,
  `valorVentaNetoProducto` int(5) NOT NULL,
  `stockCriticoProducto` mediumint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`codProducto`, `nombreProducto`, `valorVentaNetoProducto`, `stockCriticoProducto`) VALUES
('0030165000', 'Blackout liso blanco', 832, 0),
('0050005000', 'Buzo franela burdeo', 916, 460),
('0120016150', 'Nuevo Producto 2', 890, 0),
('0150014160', 'Nuevo Producto 3', 870, 0),
('0150017120', 'Nuevo producto 1', 860, 0),
('0200147000', 'Felpa liso mostaza', 832, 0),
('0250065000', 'Gasa ramie blanco', 832, 1),
('1102117848', 'gatica', 1200, 50),
('1112000', 'economia', 125000, 0),
('1112211544', 'el nueivero', 44450, 0),
('1112541547', 'decimas', 1520, 30),
('1112554100', 'negrullo', 112500, 0),
('1125400', 'shining', 15000, 0),
('112551000', 'tisha', 15000, 10),
('11255441', 'el nuevox', 12254, 0),
('1154', 'papa negro', 521451, 0),
('11548748', 'miau', 11500, 0),
('12200125', 'marywella', 125000, 0),
('1222001158', 'GOODBYE', 11540000, 0),
('1231231231', 'Nuevo producto 5', 890, 0),
('1231234561', 'Nuevo Producto 6', 890, 0),
('1234561235', 'Nuevo Producto 7', 890, 0),
('1234567891', 'Nuevo producto 4', 890, 0),
('1237894561', 'Nuevo Producto 8', 890, 0),
('12545', 'q wea', 442100, 0),
('1254544000', 'la wellita', 1250, 0),
('211254', 'holaaa', 45465, 0),
('21221454', 'gato', 11500, 0),
('4125420', 'shuenke', 15000, 0),
('44551025', 'la zardina', 150000, 0),
('4564561254', 'Nuevo Producto 10', 890, 0),
('4965985', 'axdcfsd', 1450, 0),
('565111', 'perro', 5440, 0),
('7458965874', 'Nuevo producto 11', 890, 0),
('7894561231', 'Nuevo producto 9 ', 890, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE IF NOT EXISTS `proveedores` (
  `rutProveedor` int(10) NOT NULL,
  `nombreProveedor` varchar(70) NOT NULL,
  `giroProveedor` varchar(70) DEFAULT NULL,
  `direccionProveedor` varchar(70) DEFAULT NULL,
  `idRegion` tinyint(3) DEFAULT NULL,
  `idComuna` mediumint(6) DEFAULT NULL,
  `telefonoProveedor` int(10) DEFAULT NULL,
  `mailProveedor` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`rutProveedor`, `nombreProveedor`, `giroProveedor`, `direccionProveedor`, `idRegion`, `idComuna`, `telefonoProveedor`, `mailProveedor`) VALUES
(19, 'Inventario inicial', NULL, NULL, NULL, NULL, NULL, NULL),
(112544, 'nuevo proveedor1', 'computadores', 'nueva calle', 13, 13401, 22131, 'asd'),
(66564894, 'erwin', 'vendedor callejero', 'su casa', 14, 14101, 56808437, 'erwin@hotmail.com'),
(170678605, 'alvaro', 'insumos electronicos', 'general montecinos #2685', 14, 14101, 82431508, 'alvaro.mc2@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regioneschile`
--

CREATE TABLE IF NOT EXISTS `regioneschile` (
  `idRegion` tinyint(3) NOT NULL DEFAULT '0',
  `nombreRegion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `regioneschile`
--

INSERT INTO `regioneschile` (`idRegion`, `nombreRegion`) VALUES
(1, 'Tarapacá'),
(2, 'Antofagasta'),
(3, 'Atacama'),
(4, 'Coquimbo'),
(5, 'Valparaíso'),
(6, 'Libertador Gral. Bernardo O''Higgins'),
(7, 'Maule'),
(8, 'Bío-bío'),
(9, 'Araucanía'),
(10, 'Los Lagos'),
(11, 'Aysén del Gral. Carlos Ibáñez del Campo'),
(12, 'Magallanes y de la Antártica Chilena'),
(13, 'Metropolitana'),
(14, 'Los Ríos'),
(15, 'Arica y Parinacota');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedores`
--

CREATE TABLE IF NOT EXISTS `vendedores` (
  `rutVendedor` int(10) NOT NULL,
  `nombreVendedor` varchar(70) NOT NULL,
  `apellidoPatVendedor` varchar(70) NOT NULL,
  `apellidoMatVendedor` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `vendedores`
--

INSERT INTO `vendedores` (`rutVendedor`, `nombreVendedor`, `apellidoPatVendedor`, `apellidoMatVendedor`) VALUES
(170678605, 'Alvaro', 'Troncoso', 'Vivanco'),
(171141346, 'Marysol', 'Zuaznabar', 'Carvajal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE IF NOT EXISTS `ventas` (
`idVenta` mediumint(6) NOT NULL,
  `fechaVenta` datetime NOT NULL,
  `idLocal` tinyint(3) NOT NULL,
  `rutVendedor` int(10) NOT NULL,
  `numTicket` smallint(5) NOT NULL,
  `codDocPago` tinyint(2) NOT NULL DEFAULT '1',
  `numDocPago` mediumint(7) NOT NULL DEFAULT '0',
  `codMedioPago` tinyint(2) NOT NULL DEFAULT '1',
  `codProducto` varchar(12) NOT NULL,
  `cantidadVendida` float NOT NULL DEFAULT '0',
  `porcentajeDescuento` tinyint(3) NOT NULL DEFAULT '0',
  `estadoPagado` tinyint(1) NOT NULL DEFAULT '0',
  `estadoConfirmado` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=104 ;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`idVenta`, `fechaVenta`, `idLocal`, `rutVendedor`, `numTicket`, `codDocPago`, `numDocPago`, `codMedioPago`, `codProducto`, `cantidadVendida`, `porcentajeDescuento`, `estadoPagado`, `estadoConfirmado`) VALUES
(42, '2015-02-16 00:33:34', 1, 170678605, 17, 2, 3, 2, '0030165000', 2, 1, 1, 1),
(43, '2015-02-16 01:02:02', 1, 170678605, 17, 2, 3, 2, '0050005000', 1, 0, 1, 1),
(44, '2015-02-16 01:03:58', 1, 170678605, 17, 2, 3, 2, '0200147000', 1, 0, 1, 1),
(45, '2015-02-16 01:12:38', 1, 170678605, 18, 2, 4, 2, '0030165000', 1, 0, 1, 1),
(46, '2015-02-16 01:19:22', 1, 171141346, 19, 2, 2102, 2, '0050005000', 1, 0, 1, 1),
(47, '2015-02-16 01:19:34', 1, 171141346, 19, 2, 2102, 2, '0150017120', 2, 0, 1, 1),
(48, '2015-02-16 01:21:37', 1, 171141346, 20, 2, 23336, 2, '0250065000', 1, 0, 1, 1),
(49, '2015-02-16 01:21:40', 1, 171141346, 20, 2, 23336, 2, '0050005000', 3, 0, 1, 1),
(50, '2015-02-16 01:22:23', 1, 170678605, 21, 2, 149, 2, '0030165000', 1, 0, 1, 1),
(51, '2015-02-16 01:23:01', 1, 170678605, 22, 3, 1254, 3, '0250065000', 2, 0, 1, 1),
(52, '2015-02-16 01:23:28', 1, 170678605, 23, 2, 434, 2, '0050005000', 2, 0, 1, 1),
(53, '2015-02-16 01:23:56', 1, 171141346, 24, 2, 545, 2, '0050005000', 1, 0, 1, 1),
(54, '2015-02-16 01:24:34', 1, 170678605, 25, 2, 343, 2, '0030165000', 3, 0, 1, 1),
(55, '2015-02-16 01:25:40', 1, 171141346, 26, 2, 4376, 2, '0030165000', 2, 0, 1, 1),
(56, '2015-02-16 01:26:06', 1, 171141346, 27, 2, 234, 2, '0030165000', 3, 0, 1, 1),
(57, '2015-02-16 01:37:30', 1, 171141346, 28, 2, 2565, 2, '0030165000', 2, 0, 1, 1),
(58, '2015-02-16 01:38:52', 1, 171141346, 29, 2, 9898, 2, '0050005000', 1, 0, 1, 1),
(59, '2015-02-16 01:40:38', 1, 170678605, 30, 2, 111, 2, '0050005000', 2, 0, 1, 1),
(60, '2015-02-16 01:44:40', 1, 171141346, 31, 2, 434, 2, '0030165000', 1, 0, 1, 1),
(61, '2015-02-16 01:46:36', 1, 171141346, 32, 2, 0, 2, '0050005000', 3, 0, 0, 1),
(62, '2015-02-16 01:50:26', 1, 171141346, 33, 2, 3244, 2, '0030165000', 1, 0, 1, 1),
(63, '2015-02-16 01:52:46', 1, 171141346, 34, 2, 1212, 2, '0050005000', 3.3, 0, 1, 1),
(64, '2015-02-16 01:52:53', 1, 171141346, 34, 2, 1212, 2, '0120016150', 5, 0, 1, 1),
(65, '2015-02-16 01:52:56', 1, 171141346, 34, 2, 1212, 2, '0150014160', 9, 0, 1, 1),
(66, '2015-02-16 02:01:46', 1, 171141346, 34, 2, 1212, 2, '0030165000', 1, 0, 1, 1),
(67, '2015-02-17 00:40:43', 1, 170678605, 35, 2, 0, 2, '0030165000', 1, 0, 0, 1),
(68, '2015-02-17 00:48:31', 1, 171141346, 36, 2, 0, 2, '0050005000', 2, 0, 0, 1),
(69, '2015-02-17 00:49:58', 1, 171141346, 37, 2, 0, 2, '0200147000', 1, 0, 0, 1),
(70, '2015-02-17 00:52:48', 1, 170678605, 38, 2, 0, 2, '0050005000', 4, 0, 0, 1),
(71, '2015-02-17 01:01:29', 1, 170678605, 39, 2, 0, 2, '0200147000', 3, 0, 0, 1),
(72, '2015-02-17 01:02:04', 1, 171141346, 40, 2, 0, 2, '0030165000', 3, 0, 0, 0),
(73, '2015-02-24 01:34:50', 1, 170678605, 46, 1, 0, 1, '0050005000', 1, 0, 0, 0),
(74, '2015-03-05 16:30:48', 1, 170678605, 47, 2, 1000, 2, '4564561254', 10, 10, 1, 1),
(75, '2015-03-05 16:31:52', 1, 170678605, 47, 2, 1000, 2, '0050005000', 50, 0, 1, 1),
(89, '2015-03-05 18:34:29', 1, 170678605, 48, 1, 0, 1, '0050005000', 3, 100, 1, 1),
(90, '2015-03-05 18:34:30', 1, 170678605, 48, 1, 0, 1, '1112000', 3, 50, 1, 1),
(91, '2015-03-05 18:34:32', 1, 170678605, 48, 1, 0, 1, '0030165000', 1, 0, 1, 1),
(92, '2015-03-05 18:59:46', 1, 170678605, 49, 1, 0, 1, '0030165000', 100, 0, 1, 1),
(93, '2015-03-05 19:00:03', 1, 170678605, 49, 1, 0, 1, '0050005000', 10, 0, 1, 1),
(94, '2015-03-05 19:00:11', 1, 170678605, 49, 1, 0, 1, '0050005000', 10, 0, 1, 1),
(95, '2015-03-05 19:00:29', 1, 170678605, 49, 1, 0, 1, '0050005000', 10, 0, 1, 1),
(96, '2015-03-05 19:00:52', 1, 170678605, 49, 1, 0, 1, '0030165000', 100, 0, 1, 1),
(97, '2015-03-05 19:01:11', 1, 170678605, 49, 1, 0, 1, '4564561254', 1, 0, 1, 1),
(98, '2015-03-05 19:01:23', 1, 170678605, 49, 1, 0, 1, '4564561254', 2, 0, 1, 1),
(99, '2015-03-05 19:28:38', 1, 170678605, 50, 1, 0, 1, '0030165000', 1, 0, 1, 1),
(100, '2015-03-07 21:43:01', 1, 170678605, 51, 2, 11, 2, '0030165000', 1, 0, 1, 1),
(101, '2015-03-07 21:44:34', 1, 170678605, 52, 3, 111255, 3, '0050005000', 2, 0, 1, 1),
(102, '2015-03-07 21:45:03', 1, 171141346, 53, 2, 225, 2, '1112211544', 2, 0, 1, 1),
(103, '2015-03-09 00:21:00', 1, 170678605, 54, 2, 1500, 2, '1102117848', 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistacompras`
--
CREATE TABLE IF NOT EXISTS `vistacompras` (
`codProducto` varchar(12)
,`nombreProducto` varchar(150)
,`SUM(``SUM(compras.cantidadComprada)``)` double
,`stockCriticoProducto` mediumint(9)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistacomprastemporal`
--
CREATE TABLE IF NOT EXISTS `vistacomprastemporal` (
`codProducto` varchar(12)
,`nombreProducto` varchar(150)
,`SUM(compras.cantidadComprada)` double
,`stockCriticoProducto` mediumint(9)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistatemporal`
--
CREATE TABLE IF NOT EXISTS `vistatemporal` (
`codProducto` varchar(12)
,`nombreProducto` varchar(150)
,`SUM(compras.cantidadComprada)` double
,`stockCriticoProducto` mediumint(9)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistaventas`
--
CREATE TABLE IF NOT EXISTS `vistaventas` (
`codProducto` varchar(12)
,`nombreProducto` varchar(150)
,`SUM(``SUM(ventas.cantidadVendida)``)` double
,`stockCriticoProducto` mediumint(9)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vistaventastemporal`
--
CREATE TABLE IF NOT EXISTS `vistaventastemporal` (
`codProducto` varchar(12)
,`nombreProducto` varchar(150)
,`SUM(ventas.cantidadVendida)` double
,`stockCriticoProducto` mediumint(9)
);
-- --------------------------------------------------------

--
-- Estructura para la vista `vistacompras`
--
DROP TABLE IF EXISTS `vistacompras`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistacompras` AS select `vistacomprastemporal`.`codProducto` AS `codProducto`,`vistacomprastemporal`.`nombreProducto` AS `nombreProducto`,sum(`vistacomprastemporal`.`SUM(compras.cantidadComprada)`) AS `SUM(``SUM(compras.cantidadComprada)``)`,`vistacomprastemporal`.`stockCriticoProducto` AS `stockCriticoProducto` from `vistacomprastemporal` group by `vistacomprastemporal`.`codProducto`,`vistacomprastemporal`.`nombreProducto`,`vistacomprastemporal`.`stockCriticoProducto`;

-- --------------------------------------------------------

--
-- Estructura para la vista `vistacomprastemporal`
--
DROP TABLE IF EXISTS `vistacomprastemporal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistacomprastemporal` AS select `productos`.`codProducto` AS `codProducto`,`productos`.`nombreProducto` AS `nombreProducto`,sum(`compras`.`cantidadComprada`) AS `SUM(compras.cantidadComprada)`,`productos`.`stockCriticoProducto` AS `stockCriticoProducto` from (`productos` join `compras`) where ((`productos`.`codProducto` = `compras`.`codProducto`) and (cast(`compras`.`fechaCompra` as date) <= '2015-03-09')) group by `productos`.`codProducto`,`productos`.`nombreProducto`,`productos`.`stockCriticoProducto` union select `productos`.`codProducto` AS `codProducto`,`productos`.`nombreProducto` AS `nombreProducto`,0 AS `0`,`productos`.`stockCriticoProducto` AS `stockCriticoProducto` from `productos` group by `productos`.`codProducto`,`productos`.`nombreProducto`,`productos`.`stockCriticoProducto`;

-- --------------------------------------------------------

--
-- Estructura para la vista `vistatemporal`
--
DROP TABLE IF EXISTS `vistatemporal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistatemporal` AS select `productos`.`codProducto` AS `codProducto`,`productos`.`nombreProducto` AS `nombreProducto`,sum(`compras`.`cantidadComprada`) AS `SUM(compras.cantidadComprada)`,`productos`.`stockCriticoProducto` AS `stockCriticoProducto` from (`productos` join `compras`) where ((`productos`.`codProducto` = `compras`.`codProducto`) and (cast(`compras`.`fechaCompra` as date) <= '$fechaInventario')) group by `productos`.`codProducto`,`productos`.`nombreProducto`,`productos`.`stockCriticoProducto` union select `productos`.`codProducto` AS `codProducto`,`productos`.`nombreProducto` AS `nombreProducto`,0 AS `0`,`productos`.`stockCriticoProducto` AS `stockCriticoProducto` from `productos` group by `productos`.`codProducto`,`productos`.`nombreProducto`,`productos`.`stockCriticoProducto`;

-- --------------------------------------------------------

--
-- Estructura para la vista `vistaventas`
--
DROP TABLE IF EXISTS `vistaventas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistaventas` AS select `vistaventastemporal`.`codProducto` AS `codProducto`,`vistaventastemporal`.`nombreProducto` AS `nombreProducto`,sum(`vistaventastemporal`.`SUM(ventas.cantidadVendida)`) AS `SUM(``SUM(ventas.cantidadVendida)``)`,`vistaventastemporal`.`stockCriticoProducto` AS `stockCriticoProducto` from `vistaventastemporal` group by `vistaventastemporal`.`codProducto`,`vistaventastemporal`.`nombreProducto`,`vistaventastemporal`.`stockCriticoProducto`;

-- --------------------------------------------------------

--
-- Estructura para la vista `vistaventastemporal`
--
DROP TABLE IF EXISTS `vistaventastemporal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vistaventastemporal` AS select `productos`.`codProducto` AS `codProducto`,`productos`.`nombreProducto` AS `nombreProducto`,sum(`ventas`.`cantidadVendida`) AS `SUM(ventas.cantidadVendida)`,`productos`.`stockCriticoProducto` AS `stockCriticoProducto` from (`productos` join `ventas`) where ((`productos`.`codProducto` = `ventas`.`codProducto`) and (cast(`ventas`.`fechaVenta` as date) <= '2015-03-09')) group by `productos`.`codProducto`,`productos`.`nombreProducto`,`productos`.`stockCriticoProducto` union select `productos`.`codProducto` AS `codProducto`,`productos`.`nombreProducto` AS `nombreProducto`,0 AS `0`,`productos`.`stockCriticoProducto` AS `stockCriticoProducto` from `productos` group by `productos`.`codProducto`,`productos`.`nombreProducto`,`productos`.`stockCriticoProducto`;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
 ADD PRIMARY KEY (`idCompra`);

--
-- Indices de la tabla `comunaschile`
--
ALTER TABLE `comunaschile`
 ADD PRIMARY KEY (`idComuna`);

--
-- Indices de la tabla `correlativonumticket`
--
ALTER TABLE `correlativonumticket`
 ADD PRIMARY KEY (`numTicket`);

--
-- Indices de la tabla `doccompra`
--
ALTER TABLE `doccompra`
 ADD PRIMARY KEY (`numeroDocCompra`,`rutProveedor`);

--
-- Indices de la tabla `documentosdecompra`
--
ALTER TABLE `documentosdecompra`
 ADD PRIMARY KEY (`codDocCompra`);

--
-- Indices de la tabla `documentosdepago`
--
ALTER TABLE `documentosdepago`
 ADD PRIMARY KEY (`codDocPago`);

--
-- Indices de la tabla `locales`
--
ALTER TABLE `locales`
 ADD PRIMARY KEY (`idLocal`);

--
-- Indices de la tabla `mediosdepago`
--
ALTER TABLE `mediosdepago`
 ADD PRIMARY KEY (`codMedioPago`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
 ADD PRIMARY KEY (`codProducto`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
 ADD PRIMARY KEY (`rutProveedor`);

--
-- Indices de la tabla `regioneschile`
--
ALTER TABLE `regioneschile`
 ADD PRIMARY KEY (`idRegion`);

--
-- Indices de la tabla `vendedores`
--
ALTER TABLE `vendedores`
 ADD PRIMARY KEY (`rutVendedor`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
 ADD PRIMARY KEY (`idVenta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
MODIFY `idCompra` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `correlativonumticket`
--
ALTER TABLE `correlativonumticket`
MODIFY `numTicket` smallint(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT de la tabla `documentosdecompra`
--
ALTER TABLE `documentosdecompra`
MODIFY `codDocCompra` tinyint(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `documentosdepago`
--
ALTER TABLE `documentosdepago`
MODIFY `codDocPago` tinyint(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `locales`
--
ALTER TABLE `locales`
MODIFY `idLocal` tinyint(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `mediosdepago`
--
ALTER TABLE `mediosdepago`
MODIFY `codMedioPago` tinyint(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
MODIFY `idVenta` mediumint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=104;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
