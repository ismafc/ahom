-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 04-07-2012 a las 23:40:56
-- Versión del servidor: 5.5.20
-- Versión de PHP: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `ahorramo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario`
--

CREATE TABLE IF NOT EXISTS `calendario` (
  `fecha` date NOT NULL,
  `idTipoDia` int(2) NOT NULL,
  PRIMARY KEY (`fecha`),
  KEY `idTipoDia` (`idTipoDia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combinaciones_servicios_ahorro`
--

CREATE TABLE IF NOT EXISTS `combinaciones_servicios_ahorro` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `idServicioAhorro` int(3) NOT NULL,
  `combinacion` int(5) NOT NULL,
  `idTipoLlamada` int(3) DEFAULT NULL,
  `NumeroLineas` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idServicioAhorro` (`idServicioAhorro`),
  KEY `idTipoLlamada` (`idTipoLlamada`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compatibilidades`
--

CREATE TABLE IF NOT EXISTS `compatibilidades` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `idCompatibilidad` int(3) NOT NULL,
  `idContrato` int(3) NOT NULL,
  `idServicioAhorro` int(3) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idCompatibilidad` (`idCompatibilidad`),
  KEY `idContrato` (`idContrato`),
  KEY `idServicioAhorro` (`idServicioAhorro`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=392 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE IF NOT EXISTS `consultas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idMiembro` int(11) NOT NULL,
  `correo` varchar(63) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` enum('ERROR_WEB','ERROR_LECTURA','CONSULTA','SUGERENCIA','OTROS') COLLATE utf8_unicode_ci NOT NULL,
  `texto` varchar(1023) COLLATE utf8_unicode_ci NOT NULL,
  `estado` enum('NUEVA','LEIDA','CONTESTADA') COLLATE utf8_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `idRespuesta` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idMiembro` (`idMiembro`),
  KEY `idRespuesta` (`idRespuesta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contratos`
--

CREATE TABLE IF NOT EXISTS `contratos` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `idOperador` int(2) NOT NULL,
  `cuota_alta` double NOT NULL,
  `cuota_mensual` double NOT NULL,
  `fraccion_minima` int(3) NOT NULL,
  `unidad_tarificacion` int(3) NOT NULL,
  `consumo_minimo` double NOT NULL,
  `base_consumo_gratis` double NOT NULL,
  `consumo_gratis` double NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `idOperador` (`idOperador`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=68 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costes`
--

CREATE TABLE IF NOT EXISTS `costes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idContrato` int(3) NOT NULL,
  `idTipoDia` int(2) NOT NULL,
  `franja_hora_inicio` int(5) NOT NULL,
  `franja_hora_fin` int(5) NOT NULL,
  `idTipoLlamada` int(2) NOT NULL,
  `intervalo_desde` int(6) NOT NULL,
  `intervalo_hasta` int(6) NOT NULL,
  `establecimiento_llamada` double NOT NULL,
  `idZonaInternacional` int(3) DEFAULT NULL,
  `coste` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idTipoDia` (`idTipoDia`),
  KEY `idContrato` (`idContrato`),
  KEY `idTipoLlamada` (`idTipoLlamada`),
  KEY `idZonaInternacional` (`idZonaInternacional`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1267 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costes_ahorro`
--

CREATE TABLE IF NOT EXISTS `costes_ahorro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idServicioAhorro` int(3) NOT NULL,
  `idTipoLlamada` int(2) NOT NULL,
  `idTipoDia` int(2) NOT NULL,
  `intervalo_desde` int(6) NOT NULL,
  `intervalo_hasta` int(6) NOT NULL,
  `establecimiento_llamada` double DEFAULT NULL,
  `coste` double DEFAULT NULL,
  `porcentaje_descuento_total` double DEFAULT NULL,
  `porcentaje_descuento_tiempo` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idTipoDia` (`idTipoDia`),
  KEY `idServicioAhorro` (`idServicioAhorro`),
  KEY `idTipoLlamada` (`idTipoLlamada`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=125 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `errores_proceso_facturas`
--

CREATE TABLE IF NOT EXISTS `errores_proceso_facturas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idMiembro` int(11) NOT NULL,
  `archivo` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `error` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idMiembro` (`idMiembro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadisticas_basicas`
--

CREATE TABLE IF NOT EXISTS `estadisticas_basicas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idMiembro` int(11) NOT NULL,
  `telefono` varchar(31) COLLATE utf8_unicode_ci NOT NULL,
  `coste_real` double NOT NULL,
  `coste_calculado` double NOT NULL,
  `fecha` datetime NOT NULL,
  `numero_facturas` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idMiembro` (`idMiembro`,`telefono`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE IF NOT EXISTS `facturas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idMiembro` int(11) NOT NULL,
  `periodo` varchar(63) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(127) COLLATE utf8_unicode_ci DEFAULT NULL,
  `coste` double NOT NULL,
  `numero_movil_llamante` varchar(63) COLLATE utf8_unicode_ci NOT NULL,
  `idOperador` int(2) NOT NULL,
  `titular` varchar(63) COLLATE utf8_unicode_ci NOT NULL,
  `edad_titular` int(3) unsigned zerofill DEFAULT NULL,
  `idParentesco` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `periodo` (`periodo`,`coste`,`numero_movil_llamante`),
  KEY `idMiembro` (`idMiembro`),
  KEY `idOperador` (`idOperador`),
  KEY `idParentesco` (`idParentesco`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `identificacion_operador`
--

CREATE TABLE IF NOT EXISTS `identificacion_operador` (
  `prefijo` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `idOperador` int(2) NOT NULL,
  PRIMARY KEY (`prefijo`),
  KEY `idOperador` (`idOperador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `identificacion_zonas`
--

CREATE TABLE IF NOT EXISTS `identificacion_zonas` (
  `prefijo` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `idOperador` int(2) NOT NULL,
  `idZona` int(3) NOT NULL,
  PRIMARY KEY (`prefijo`,`idOperador`),
  KEY `idOperador` (`idOperador`),
  KEY `idZona` (`idZona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `llamadas`
--

CREATE TABLE IF NOT EXISTS `llamadas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idFactura` int(11) NOT NULL,
  `numero_telefono_llamado` varchar(31) COLLATE utf8_unicode_ci NOT NULL,
  `idTipoLlamada` int(2) NOT NULL,
  `idTipoDia` int(2) NOT NULL,
  `inicio_llamada` datetime NOT NULL,
  `duracion` int(6) NOT NULL,
  `idZonaInternacional` int(3) DEFAULT NULL,
  `coste` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idTipoDia` (`idTipoDia`),
  KEY `idFactura` (`idFactura`),
  KEY `idTipoLlamada` (`idTipoLlamada`),
  KEY `idZonaInternacional` (`idZonaInternacional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `llamadas_a_revisar`
--

CREATE TABLE IF NOT EXISTS `llamadas_a_revisar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idFactura` int(11) NOT NULL,
  `numero_telefono_llamado` varchar(31) COLLATE utf8_unicode_ci NOT NULL,
  `idTipoDia` int(2) NOT NULL,
  `inicio_llamada` datetime NOT NULL,
  `duracion` int(6) NOT NULL,
  `coste` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idFactura` (`idFactura`,`idTipoDia`),
  KEY `idTipoDia` (`idTipoDia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `llamada_tipo`
--

CREATE TABLE IF NOT EXISTS `llamada_tipo` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tipo` (`tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL,
  `idMiembro` int(11) NOT NULL,
  `Inicio` datetime NOT NULL,
  `Fin` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idMiembro` (`idMiembro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miembros`
--

CREATE TABLE IF NOT EXISTS `miembros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Login` varchar(63) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Creado` datetime NOT NULL,
  `Activado` datetime DEFAULT NULL,
  `Nombre` varchar(31) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Apellido1` varchar(31) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Apellido2` varchar(31) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Calle` varchar(63) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Numero` int(4) unsigned DEFAULT NULL,
  `Piso` int(2) unsigned DEFAULT NULL,
  `Escalera` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Puerta` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Poblacion` varchar(63) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Provincia` varchar(63) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Pais` varchar(63) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Telefono` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Fax` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Correo` varchar(63) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Movil` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Edad` int(3) unsigned DEFAULT NULL,
  `Sexo` enum('H','M') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Postal` char(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Nacimiento` int(11) DEFAULT NULL,
  `Estado` enum('ACTIVO','BLOQUEADO','INACTIVO','PROVISIONAL') COLLATE utf8_unicode_ci NOT NULL,
  `Tarjeta` char(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Caducidad` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Login` (`Login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tabla de usuarios registrados' AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moviles_dudosos`
--

CREATE TABLE IF NOT EXISTS `moviles_dudosos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_movil_llamante` varchar(31) COLLATE utf8_unicode_ci NOT NULL,
  `numero_movil` varchar(31) COLLATE utf8_unicode_ci NOT NULL,
  `idMiembro` int(11) NOT NULL,
  `idOperadorPropuesto` int(2) NOT NULL,
  `idOperadorPosible` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_movil_llamante` (`numero_movil_llamante`,`numero_movil`,`idMiembro`,`idOperadorPosible`),
  KEY `idOperadorPropuesto` (`idOperadorPropuesto`),
  KEY `idOperadorPosible` (`idOperadorPosible`),
  KEY `idMiembro` (`idMiembro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE IF NOT EXISTS `noticias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `titulo` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` varchar(4096) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mime` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imagen` longblob,
  `alto` int(4) DEFAULT NULL,
  `ancho` int(4) DEFAULT NULL,
  `posicion` enum('ARRIBA','ABAJO','DERECHA','IZQUIERDA') COLLATE utf8_unicode_ci DEFAULT 'ABAJO',
  `mimeMiniatura` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imagenMiniatura` longblob,
  `altoMiniatura` int(4) DEFAULT NULL,
  `anchoMiniatura` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operadores`
--

CREATE TABLE IF NOT EXISTS `operadores` (
  `id` int(2) NOT NULL,
  `nombre` varchar(31) COLLATE utf8_unicode_ci NOT NULL,
  `nombre_oficial` varchar(127) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parentescos`
--

CREATE TABLE IF NOT EXISTS `parentescos` (
  `id` int(2) NOT NULL,
  `parentesco` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prefijos_internacionales`
--

CREATE TABLE IF NOT EXISTS `prefijos_internacionales` (
  `pais` varchar(63) COLLATE utf8_unicode_ci NOT NULL,
  `prefijo` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE IF NOT EXISTS `respuestas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idConsulta` int(11) NOT NULL,
  `texto` varchar(1023) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` enum('OK','NO_OK','NO_OK_OLD') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idConsulta` (`idConsulta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_basicos`
--

CREATE TABLE IF NOT EXISTS `resultados_basicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idFactura` int(11) NOT NULL,
  `idContrato` int(3) NOT NULL,
  `idCompatibilidad` int(3) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `coste` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idContrato` (`idContrato`),
  KEY `idFactura` (`idFactura`),
  KEY `idCompatibilidad` (`idCompatibilidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_detallados`
--

CREATE TABLE IF NOT EXISTS `resultados_detallados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idLlamada` int(11) NOT NULL,
  `idResultadoBasico` int(11) NOT NULL,
  `coste` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idLlamada` (`idLlamada`),
  KEY `idResultadoBasico` (`idResultadoBasico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados_numeros_servicios_ahorro`
--

CREATE TABLE IF NOT EXISTS `resultados_numeros_servicios_ahorro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idResultadoBasico` int(11) NOT NULL,
  `numero_telefono` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `idServicioAhorro` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idResultadoBasico` (`idResultadoBasico`),
  KEY `idServicioAhorro` (`idServicioAhorro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resumen_telefonos`
--

CREATE TABLE IF NOT EXISTS `resumen_telefonos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idMiembro` int(11) NOT NULL,
  `numero_telefono_llamante` varchar(31) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `numero_telefono_llamado` varchar(31) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `idTipoLlamada` int(2) NOT NULL,
  `numero_llamadas` int(8) NOT NULL,
  `tiempo_llamado` int(8) NOT NULL,
  `coste` double NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idMiembro` (`idMiembro`,`numero_telefono_llamante`,`numero_telefono_llamado`),
  KEY `idTipoLlamada` (`idTipoLlamada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_ahorro`
--

CREATE TABLE IF NOT EXISTS `servicios_ahorro` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(31) COLLATE utf8_unicode_ci NOT NULL,
  `idOperador` int(11) NOT NULL,
  `cuota_alta` double NOT NULL,
  `cuota_mensual` double NOT NULL,
  `condicion_cuota_mensual` double NOT NULL,
  `cuota_vodafone` double NOT NULL,
  `cuota_movistar` double NOT NULL,
  `cuota_amena` double NOT NULL,
  `cuota_fijo` double NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`),
  KEY `idOperador` (`idOperador`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_dias`
--

CREATE TABLE IF NOT EXISTS `tipos_dias` (
  `id` int(2) NOT NULL,
  `nombre` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_llamadas`
--

CREATE TABLE IF NOT EXISTS `tipos_llamadas` (
  `id` int(2) NOT NULL,
  `nombre` varchar(63) COLLATE utf8_unicode_ci NOT NULL,
  `idOperador` int(2) DEFAULT NULL,
  `idLlamadaTipo` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idOperador` (`idOperador`),
  KEY `idLlamadaTipo` (`idLlamadaTipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonas_internacionales`
--

CREATE TABLE IF NOT EXISTS `zonas_internacionales` (
  `id` int(3) NOT NULL,
  `nombre` varchar(63) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calendario`
--
ALTER TABLE `calendario`
  ADD CONSTRAINT `calendario_ibfk_1` FOREIGN KEY (`idTipoDia`) REFERENCES `tipos_dias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `combinaciones_servicios_ahorro`
--
ALTER TABLE `combinaciones_servicios_ahorro`
  ADD CONSTRAINT `combinaciones_servicios_ahorro_ibfk_1` FOREIGN KEY (`idServicioAhorro`) REFERENCES `servicios_ahorro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `combinaciones_servicios_ahorro_ibfk_2` FOREIGN KEY (`idTipoLlamada`) REFERENCES `tipos_llamadas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `compatibilidades`
--
ALTER TABLE `compatibilidades`
  ADD CONSTRAINT `compatibilidades_ibfk_1` FOREIGN KEY (`idServicioAhorro`) REFERENCES `servicios_ahorro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `compatibilidades_ibfk_3` FOREIGN KEY (`idContrato`) REFERENCES `contratos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`idMiembro`) REFERENCES `miembros` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `consultas_ibfk_2` FOREIGN KEY (`idRespuesta`) REFERENCES `respuestas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `contratos`
--
ALTER TABLE `contratos`
  ADD CONSTRAINT `contratos_ibfk_1` FOREIGN KEY (`idOperador`) REFERENCES `operadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `costes`
--
ALTER TABLE `costes`
  ADD CONSTRAINT `costes_ibfk_1` FOREIGN KEY (`idTipoDia`) REFERENCES `tipos_dias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `costes_ibfk_2` FOREIGN KEY (`idTipoLlamada`) REFERENCES `tipos_llamadas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `costes_ibfk_3` FOREIGN KEY (`idZonaInternacional`) REFERENCES `zonas_internacionales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `costes_ibfk_4` FOREIGN KEY (`idContrato`) REFERENCES `contratos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `costes_ahorro`
--
ALTER TABLE `costes_ahorro`
  ADD CONSTRAINT `costes_ahorro_ibfk_1` FOREIGN KEY (`idTipoLlamada`) REFERENCES `tipos_llamadas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `costes_ahorro_ibfk_2` FOREIGN KEY (`idTipoDia`) REFERENCES `tipos_dias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `costes_ahorro_ibfk_3` FOREIGN KEY (`idServicioAhorro`) REFERENCES `servicios_ahorro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `errores_proceso_facturas`
--
ALTER TABLE `errores_proceso_facturas`
  ADD CONSTRAINT `errores_proceso_facturas_ibfk_1` FOREIGN KEY (`idMiembro`) REFERENCES `miembros` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estadisticas_basicas`
--
ALTER TABLE `estadisticas_basicas`
  ADD CONSTRAINT `estadisticas_basicas_ibfk_1` FOREIGN KEY (`idMiembro`) REFERENCES `miembros` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`idMiembro`) REFERENCES `miembros` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `facturas_ibfk_2` FOREIGN KEY (`idOperador`) REFERENCES `operadores` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `facturas_ibfk_3` FOREIGN KEY (`idParentesco`) REFERENCES `parentescos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `identificacion_operador`
--
ALTER TABLE `identificacion_operador`
  ADD CONSTRAINT `identificacion_operador_ibfk_1` FOREIGN KEY (`idOperador`) REFERENCES `operadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `identificacion_zonas`
--
ALTER TABLE `identificacion_zonas`
  ADD CONSTRAINT `identificacion_zonas_ibfk_1` FOREIGN KEY (`idOperador`) REFERENCES `operadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `identificacion_zonas_ibfk_2` FOREIGN KEY (`idZona`) REFERENCES `zonas_internacionales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `llamadas`
--
ALTER TABLE `llamadas`
  ADD CONSTRAINT `llamadas_ibfk_1` FOREIGN KEY (`idFactura`) REFERENCES `facturas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `llamadas_ibfk_2` FOREIGN KEY (`idTipoLlamada`) REFERENCES `tipos_llamadas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `llamadas_ibfk_3` FOREIGN KEY (`idTipoDia`) REFERENCES `tipos_dias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `llamadas_ibfk_4` FOREIGN KEY (`idZonaInternacional`) REFERENCES `zonas_internacionales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `llamadas_a_revisar`
--
ALTER TABLE `llamadas_a_revisar`
  ADD CONSTRAINT `llamadas_a_revisar_ibfk_1` FOREIGN KEY (`idFactura`) REFERENCES `facturas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `llamadas_a_revisar_ibfk_2` FOREIGN KEY (`idTipoDia`) REFERENCES `tipos_dias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`idMiembro`) REFERENCES `miembros` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `moviles_dudosos`
--
ALTER TABLE `moviles_dudosos`
  ADD CONSTRAINT `moviles_dudosos_ibfk_1` FOREIGN KEY (`idMiembro`) REFERENCES `miembros` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `moviles_dudosos_ibfk_2` FOREIGN KEY (`idOperadorPropuesto`) REFERENCES `operadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `moviles_dudosos_ibfk_3` FOREIGN KEY (`idOperadorPosible`) REFERENCES `operadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`idConsulta`) REFERENCES `consultas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `resultados_basicos`
--
ALTER TABLE `resultados_basicos`
  ADD CONSTRAINT `resultados_basicos_ibfk_1` FOREIGN KEY (`idFactura`) REFERENCES `facturas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resultados_basicos_ibfk_2` FOREIGN KEY (`idContrato`) REFERENCES `contratos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `resultados_detallados`
--
ALTER TABLE `resultados_detallados`
  ADD CONSTRAINT `resultados_detallados_ibfk_1` FOREIGN KEY (`idLlamada`) REFERENCES `llamadas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resultados_detallados_ibfk_2` FOREIGN KEY (`idResultadoBasico`) REFERENCES `resultados_basicos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `resultados_numeros_servicios_ahorro`
--
ALTER TABLE `resultados_numeros_servicios_ahorro`
  ADD CONSTRAINT `resultados_numeros_servicios_ahorro_ibfk_1` FOREIGN KEY (`idResultadoBasico`) REFERENCES `resultados_basicos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resultados_numeros_servicios_ahorro_ibfk_2` FOREIGN KEY (`idServicioAhorro`) REFERENCES `servicios_ahorro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `resumen_telefonos`
--
ALTER TABLE `resumen_telefonos`
  ADD CONSTRAINT `resumen_telefonos_ibfk_1` FOREIGN KEY (`idMiembro`) REFERENCES `miembros` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resumen_telefonos_ibfk_2` FOREIGN KEY (`idTipoLlamada`) REFERENCES `tipos_llamadas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicios_ahorro`
--
ALTER TABLE `servicios_ahorro`
  ADD CONSTRAINT `servicios_ahorro_ibfk_1` FOREIGN KEY (`idOperador`) REFERENCES `operadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tipos_llamadas`
--
ALTER TABLE `tipos_llamadas`
  ADD CONSTRAINT `tipos_llamadas_ibfk_1` FOREIGN KEY (`idOperador`) REFERENCES `operadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tipos_llamadas_ibfk_2` FOREIGN KEY (`idLlamadaTipo`) REFERENCES `llamada_tipo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
