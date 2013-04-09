-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 03-02-2013 a las 20:00:57
-- Versión del servidor: 5.5.22
-- Versión de PHP: 5.3.10-1ubuntu3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `proyecto2012`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_item`
--

CREATE TABLE IF NOT EXISTS `categoria_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL,
  `categoria_padre_id` int(11) DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_padre_id` (`categoria_padre_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `categoria_item`
--

INSERT INTO `categoria_item` (`id`, `descripcion`, `categoria_padre_id`, `borrado`) VALUES
(1, 'Informacion personal', 17, 0),
(2, 'Educacion', 2, 0),
(17, 'Grupos', 17, 0),
(18, 'categoria-leandro2', 19, 0),
(19, 'categoria-leandro3', 18, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_plantilla`
--

CREATE TABLE IF NOT EXISTS `categoria_plantilla` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL,
  `categoria_padre_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `categoria_padre_id` (`categoria_padre_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `categoria_plantilla`
--

INSERT INTO `categoria_plantilla` (`id`, `descripcion`, `categoria_padre_id`) VALUES
(1, 'CV Laboral para desarrollo web', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE IF NOT EXISTS `configuracion` (
  `nombre` varchar(255) NOT NULL,
  `itemsxpag` int(11) NOT NULL,
  `estiloactual` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`nombre`, `itemsxpag`, `estiloactual`) VALUES
('cv manager', 2, 'estilo2.css');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dato_item`
--

CREATE TABLE IF NOT EXISTS `dato_item` (
  `id_di` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `entidad_otorgante` varchar(255) DEFAULT NULL,
  `entidad_destinataria` varchar(255) DEFAULT NULL,
  `caracter` varchar(255) DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_di`),
  KEY `usuario_id` (`usuario_id`,`item_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Volcado de datos para la tabla `dato_item`
--

INSERT INTO `dato_item` (`id_di`, `usuario_id`, `item_id`, `contenido`, `fecha_inicio`, `fecha_fin`, `entidad_otorgante`, `entidad_destinataria`, `caracter`, `borrado`) VALUES
(55, 5, 3, 'Alejandro', NULL, NULL, NULL, NULL, NULL, 0),
(56, 5, 4, 'Greco', NULL, NULL, NULL, NULL, NULL, 0),
(57, 5, 20, '2012-12-12', NULL, NULL, NULL, NULL, NULL, 0),
(59, 5, 7, 'Ingles', NULL, NULL, NULL, NULL, NULL, 0),
(60, 5, 18, 'Redes', NULL, NULL, NULL, NULL, NULL, 0),
(62, 5, 23, 'Amigos', NULL, NULL, NULL, NULL, NULL, 0),
(63, 7, 3, 'Greco', NULL, NULL, NULL, NULL, NULL, 0),
(64, 7, 4, 'Alejandro', NULL, NULL, NULL, NULL, NULL, 0),
(65, 4, 3, 'Madrid', NULL, NULL, NULL, NULL, NULL, 0),
(66, 4, 4, 'Federico', NULL, NULL, NULL, NULL, NULL, 0),
(67, 7, 23, 'Amigos', NULL, NULL, NULL, NULL, NULL, 0),
(68, 7, 20, '2013-01-16', NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estilo`
--

CREATE TABLE IF NOT EXISTS `estilo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `estilo`
--

INSERT INTO `estilo` (`id`, `nombre`) VALUES
(1, 'estilo1.css'),
(3, 'estilo2.css');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `tipo_item_id` int(11) NOT NULL,
  `buscable` tinyint(1) DEFAULT NULL,
  `repetible` tinyint(1) DEFAULT NULL,
  `tipo_input` varchar(128) NOT NULL,
  `borrado` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_item_id` (`tipo_item_id`),
  KEY `categoria_id` (`categoria_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `item`
--

INSERT INTO `item` (`id`, `categoria_id`, `descripcion`, `tipo_item_id`, `buscable`, `repetible`, `tipo_input`, `borrado`) VALUES
(1, 1, 'Informacion personal', 1, 0, 0, 'text', 0),
(2, 1, '<hr>', 2, 0, 0, 'string', 0),
(3, 1, 'Apellido', 3, 1, 0, 'text', 0),
(4, 1, 'Nombre', 3, 1, 0, 'text', 0),
(5, 2, 'Educacion', 1, 0, 0, 'string', 0),
(6, 2, '<hr>', 2, 0, 0, 'string', 0),
(7, 2, 'Idiomas', 3, 1, 1, 'text', 0),
(18, 2, 'Cursos', 3, 1, 1, 'text', 0),
(20, 1, 'Fecha de nac', 3, 1, 0, 'date', 0),
(21, 17, 'Grupos', 1, 0, 0, 'text', 0),
(22, 17, '<hr>', 2, 0, 0, 'text', 0),
(23, 17, 'Nombre', 3, 1, 1, 'text', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_usuario`
--

CREATE TABLE IF NOT EXISTS `perfil_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `perfil` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `perfil_usuario`
--

INSERT INTO `perfil_usuario` (`id`, `perfil`) VALUES
(1, 'admin'),
(2, 'usuario'),
(3, 'secretario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantilla`
--

CREATE TABLE IF NOT EXISTS `plantilla` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `categoria_id` (`categoria_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `plantilla`
--

INSERT INTO `plantilla` (`id`, `descripcion`, `categoria_id`, `borrado`) VALUES
(1, 'Laboral', 1, 0),
(16, 'Educacion', NULL, 0),
(17, 'Personal', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantilla_item`
--

CREATE TABLE IF NOT EXISTS `plantilla_item` (
  `id_plantilla` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  PRIMARY KEY (`id_plantilla`,`id_item`),
  KEY `id_item` (`id_item`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `plantilla_item`
--

INSERT INTO `plantilla_item` (`id_plantilla`, `id_item`, `orden`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 3),
(1, 4, 4),
(1, 5, 6),
(1, 6, 7),
(1, 7, 8),
(1, 18, 9),
(1, 20, 5),
(1, 21, 10),
(1, 22, 11),
(1, 23, 12),
(16, 5, 1),
(16, 6, 2),
(16, 7, 3),
(16, 18, 4),
(17, 1, 1),
(17, 2, 2),
(17, 3, 3),
(17, 4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_item`
--

CREATE TABLE IF NOT EXISTS `tipo_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tipo_item`
--

INSERT INTO `tipo_item` (`id`, `descripcion`, `activo`) VALUES
(1, 'label', 1),
(2, 'separador', 1),
(3, 'item', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE IF NOT EXISTS `ubicacion` (
  `idusuario` int(11) NOT NULL,
  `latitud` float NOT NULL,
  `longitud` float NOT NULL,
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`idusuario`, `latitud`, `longitud`) VALUES
(4, -27.1256, 133.385),
(5, 40.0814, -103.393),
(7, -22.9715, -59.9177);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `perfil_usuario_id` int(11) NOT NULL,
  `cv_publico` tinyint(1) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`),
  KEY `perfil_usuario_id` (`perfil_usuario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`uid`, `username`, `password`, `perfil_usuario_id`, `cv_publico`, `activo`) VALUES
(4, 'fede', 'fede', 2, 0, 1),
(5, 'admin', 'admin', 1, 0, 1),
(6, 'secretaria', 'secretaria', 3, 0, 1),
(7, 'ale', 'ale', 2, 1, 1),
(8, 'juan', 'juan', 3, 1, 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categoria_item`
--
ALTER TABLE `categoria_item`
  ADD CONSTRAINT `categoria_item_ibfk_1` FOREIGN KEY (`categoria_padre_id`) REFERENCES `categoria_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `categoria_plantilla`
--
ALTER TABLE `categoria_plantilla`
  ADD CONSTRAINT `categoria_plantilla_ibfk_1` FOREIGN KEY (`categoria_padre_id`) REFERENCES `categoria_plantilla` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `dato_item`
--
ALTER TABLE `dato_item`
  ADD CONSTRAINT `dato_item_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`tipo_item_id`) REFERENCES `tipo_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `item_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categoria_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `plantilla`
--
ALTER TABLE `plantilla`
  ADD CONSTRAINT `plantilla_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria_plantilla` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `plantilla_item`
--
ALTER TABLE `plantilla_item`
  ADD CONSTRAINT `plantilla_item_ibfk_1` FOREIGN KEY (`id_item`) REFERENCES `item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plantilla_item_ibfk_2` FOREIGN KEY (`id_plantilla`) REFERENCES `plantilla` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`perfil_usuario_id`) REFERENCES `perfil_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
