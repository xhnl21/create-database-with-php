-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-12-2019 a las 23:35:28
-- Versión del servidor: 5.7.9
-- Versión de PHP: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `furion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `demo`
--

DROP TABLE IF EXISTS `demo`;
CREATE TABLE IF NOT EXISTS `demo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `var` int(11) NOT NULL,
  `nam` int(11) NOT NULL,
  `int` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `demo`
--

INSERT INTO `demo` (`id`, `var`, `nam`, `int`) VALUES
(1, 2, 22, 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `furion`
--

DROP TABLE IF EXISTS `furion`;
CREATE TABLE IF NOT EXISTS `furion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `var` int(11) NOT NULL,
  `nam` int(11) NOT NULL,
  `int` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `furion`
--

INSERT INTO `furion` (`id`, `var`, `nam`, `int`) VALUES
(1, 2, 22, 22);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
