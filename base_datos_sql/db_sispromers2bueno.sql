-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 07-02-2011 a las 09:05:43
-- Versión del servidor: 5.0.45
-- Versión de PHP: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `db_sispromers2`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `archivo`
-- 

CREATE TABLE `archivo` (
  `idArchivo` int(11) NOT NULL auto_increment,
  `idMer` int(11) NOT NULL,
  `idPlanilla` int(11) NOT NULL,
  `archivo` varchar(150) NOT NULL,
  `fechaCreacion` date NOT NULL,
  PRIMARY KEY  (`idArchivo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `archivo`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `comunidad`
-- 

CREATE TABLE `comunidad` (
  `idComunidad` int(11) NOT NULL auto_increment,
  `idRegional` int(11) NOT NULL,
  `idDepartamento` int(11) NOT NULL,
  `idMunicipio` int(11) NOT NULL,
  `comunidad` varchar(150) NOT NULL,
  PRIMARY KEY  (`idComunidad`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `comunidad`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `consultoria`
-- 

CREATE TABLE `consultoria` (
  `idConsultoria` int(11) NOT NULL auto_increment,
  `idRegional` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `consultoria` text NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFinal` date NOT NULL,
  `estado` int(11) NOT NULL default '1' COMMENT '0=borrado; 1=habilitado; 2=desabilitado; 3=aprobado',
  `fechaCreacion` date NOT NULL,
  `fechaModificacion` date NOT NULL,
  PRIMARY KEY  (`idConsultoria`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `consultoria`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `contrato_llenar`
-- 

CREATE TABLE `contrato_llenar` (
  `idCL` int(11) NOT NULL auto_increment,
  `idMer` int(11) NOT NULL,
  `idPlanilla` int(11) NOT NULL,
  `nroContrato` int(11) default NULL,
  `idTipoContrato` int(100) default NULL,
  `idRegistroContrato` int(100) default NULL,
  `fechaInicio` date default NULL,
  `fechaFinal` date default NULL,
  `valor` float default NULL,
  `completo` varchar(100) default NULL,
  `certConformidad` varchar(100) default NULL,
  PRIMARY KEY  (`idCL`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `contrato_llenar`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cronograma`
-- 

CREATE TABLE `cronograma` (
  `idCronograma` int(11) NOT NULL auto_increment,
  `idConsultoria` int(11) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFinal` date NOT NULL,
  `detalle` varchar(255) NOT NULL,
  `mesAnio` date default NULL,
  `estado` int(11) NOT NULL default '1' COMMENT '1=habilitado; 2=desabilitado; 3=aprobado',
  PRIMARY KEY  (`idCronograma`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `cronograma`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `departamento`
-- 

CREATE TABLE `departamento` (
  `idDepartamento` int(11) NOT NULL auto_increment,
  `idRegional` int(11) NOT NULL,
  `departamento` varchar(150) NOT NULL,
  PRIMARY KEY  (`idDepartamento`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `departamento`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `formulario`
-- 

CREATE TABLE `formulario` (
  `idFormulario` int(11) NOT NULL auto_increment,
  `idMer` int(11) NOT NULL,
  `idPlanilla` int(11) NOT NULL,
  `archivo` varchar(255) default NULL,
  `cuenta` varchar(150) NOT NULL,
  `porcentaje` float NOT NULL,
  `observacion` text NOT NULL,
  PRIMARY KEY  (`idFormulario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `formulario`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `historial_archivo`
-- 

CREATE TABLE `historial_archivo` (
  `idHA` int(11) NOT NULL auto_increment,
  `estado` varchar(20) NOT NULL COMMENT 'add edit delete',
  `fecha` datetime NOT NULL,
  `idGerente` int(11) NOT NULL,
  `idArchivo` int(11) NOT NULL,
  `idMer` int(11) NOT NULL,
  `idPlanilla` int(11) NOT NULL,
  `archivo` varchar(150) NOT NULL,
  `informe` int(11) NOT NULL default '0' COMMENT '0=no reportado;1=reportado',
  `fechaInforme` date NOT NULL default '0000-00-00' COMMENT 'fecha de reporte de informe',
  PRIMARY KEY  (`idHA`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `historial_archivo`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `historial_contrato`
-- 

CREATE TABLE `historial_contrato` (
  `idHC` int(11) NOT NULL auto_increment,
  `estado` varchar(20) NOT NULL COMMENT 'add edit delete',
  `fecha` datetime NOT NULL,
  `idGerente` int(11) NOT NULL,
  `idCL` int(11) NOT NULL,
  `idMer` int(11) NOT NULL,
  `idPlanilla` int(11) NOT NULL,
  `nroContrato` int(11) NOT NULL,
  `idTipoContrato` int(11) NOT NULL,
  `idRegistroContrato` int(11) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFinal` date NOT NULL,
  `valor` float NOT NULL,
  `completo` varchar(100) NOT NULL,
  `certConformidad` varchar(100) NOT NULL,
  `informe` int(11) NOT NULL default '0' COMMENT '0=no reportado;1=reportado',
  `fechaInforme` date NOT NULL default '0000-00-00' COMMENT 'fecha de reporte de informe',
  PRIMARY KEY  (`idHC`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `historial_contrato`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `historial_formulario`
-- 

CREATE TABLE `historial_formulario` (
  `idHF` int(11) NOT NULL auto_increment,
  `fecha` datetime NOT NULL,
  `idGerente` int(11) NOT NULL,
  `idFormulario` int(11) NOT NULL,
  `idMer` int(11) NOT NULL,
  `idPlanilla` int(11) NOT NULL,
  `archivo` varchar(255) NOT NULL,
  `cuenta` varchar(150) NOT NULL,
  `porcentaje` float NOT NULL,
  `observacion` text NOT NULL,
  `informe` int(11) NOT NULL default '0' COMMENT '0=no reportado;1=reportado',
  `fechaInforme` date NOT NULL default '0000-00-00' COMMENT 'fecha de reporte de informe',
  PRIMARY KEY  (`idHF`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `historial_formulario`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `indicador`
-- 

CREATE TABLE `indicador` (
  `idIndicador` int(11) NOT NULL auto_increment,
  `idCronograma` int(11) NOT NULL,
  `indicador` text NOT NULL,
  PRIMARY KEY  (`idIndicador`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `indicador`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `mer`
-- 

CREATE TABLE `mer` (
  `idMer` int(11) NOT NULL auto_increment,
  `idRegional` int(11) NOT NULL,
  `idDepartamento` int(11) NOT NULL,
  `idMunicipio` int(11) NOT NULL,
  `idComunidad` int(11) NOT NULL,
  `idRubro` int(11) NOT NULL,
  `mer` varchar(255) NOT NULL,
  `unidadProductivaDedica` varchar(255) default NULL,
  `codigo` varchar(255) default NULL,
  `numeroSocios` int(11) default NULL,
  `direccion` varchar(255) default NULL,
  `zona` varchar(255) default NULL,
  `referencia` varchar(255) default NULL,
  `refTelefonica` int(11) default NULL,
  `refCelular` int(11) default NULL,
  `fechaInicio` date default NULL,
  `fechaFinal` date default NULL,
  `gestion` int(11) default NULL,
  `estado` int(11) NOT NULL default '1' COMMENT '0=borrado; 1=habilitado; 2=desabilitado',
  `fechaCreacion` date NOT NULL,
  `fechaModificacion` date NOT NULL,
  PRIMARY KEY  (`idMer`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `mer`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `meta`
-- 

CREATE TABLE `meta` (
  `idMeta` int(11) NOT NULL auto_increment,
  `idCronograma` int(11) NOT NULL,
  `meta` text NOT NULL,
  `cabezera` binary(1) NOT NULL,
  PRIMARY KEY  (`idMeta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `meta`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `municipio`
-- 

CREATE TABLE `municipio` (
  `idMunicipio` int(11) NOT NULL auto_increment,
  `idRegional` int(11) NOT NULL,
  `idDepartamento` int(11) NOT NULL,
  `municipio` varchar(150) NOT NULL,
  PRIMARY KEY  (`idMunicipio`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `municipio`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `municipio_mer`
-- 

CREATE TABLE `municipio_mer` (
  `idMM` int(11) NOT NULL auto_increment,
  `idConsultoria` int(11) NOT NULL,
  `idMunicipio` int(11) NOT NULL,
  `idMer` int(11) NOT NULL,
  PRIMARY KEY  (`idMM`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `municipio_mer`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `obtencion_credito16`
-- 

CREATE TABLE `obtencion_credito16` (
  `idObtencionCredito` int(11) NOT NULL auto_increment,
  `idMer` int(11) NOT NULL,
  `idPlanilla` int(11) NOT NULL,
  `solicitud` varchar(150) NOT NULL,
  `entidadFinanciera` varchar(150) NOT NULL,
  `prestamo` varchar(150) NOT NULL,
  `montoSolicitado` float NOT NULL,
  `mora` varchar(150) NOT NULL,
  `fechaUltimoRecibo` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`idObtencionCredito`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `obtencion_credito16`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `permiso`
-- 

CREATE TABLE `permiso` (
  `idRol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `permiso` int(11) NOT NULL,
  PRIMARY KEY  (`idRol`,`nombre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `permiso`
-- 

INSERT INTO `permiso` VALUES (0, 'archivo', 0);
INSERT INTO `permiso` VALUES (0, 'comunidad', 0);
INSERT INTO `permiso` VALUES (0, 'contrato_llenar', 0);
INSERT INTO `permiso` VALUES (0, 'departamento', 0);
INSERT INTO `permiso` VALUES (0, 'formulario', 0);
INSERT INTO `permiso` VALUES (0, 'historial_archivo', 0);
INSERT INTO `permiso` VALUES (0, 'historial_contrato', 0);
INSERT INTO `permiso` VALUES (0, 'historial_formulario', 0);
INSERT INTO `permiso` VALUES (0, 'mer', 0);
INSERT INTO `permiso` VALUES (0, 'municipio', 0);
INSERT INTO `permiso` VALUES (0, 'obtencion_credito16', 0);
INSERT INTO `permiso` VALUES (0, 'planilla', 0);
INSERT INTO `permiso` VALUES (0, 'pregunta', 0);
INSERT INTO `permiso` VALUES (0, 'pregunta_respuesta', 0);
INSERT INTO `permiso` VALUES (0, 'regional', 0);
INSERT INTO `permiso` VALUES (0, 'registro_contrato', 0);
INSERT INTO `permiso` VALUES (0, 'registroventas17', 0);
INSERT INTO `permiso` VALUES (0, 'responsable', 0);
INSERT INTO `permiso` VALUES (0, 'rubro', 0);
INSERT INTO `permiso` VALUES (0, 'tipo_contrato', 0);
INSERT INTO `permiso` VALUES (0, 'usuario', 0);
INSERT INTO `permiso` VALUES (0, 'permiso', 0);
INSERT INTO `permiso` VALUES (0, 'rol', 0);
INSERT INTO `permiso` VALUES (0, 'Reporte Mers', 0);
INSERT INTO `permiso` VALUES (0, 'consultoria', 0);
INSERT INTO `permiso` VALUES (0, 'cronograma', 0);
INSERT INTO `permiso` VALUES (0, 'indicador', 0);
INSERT INTO `permiso` VALUES (0, 'meta', 0);
INSERT INTO `permiso` VALUES (0, 'municipio_mer', 0);
INSERT INTO `permiso` VALUES (0, 'resultado', 0);
INSERT INTO `permiso` VALUES (0, 'responsable_consultoria', 0);
INSERT INTO `permiso` VALUES (1, 'comunidad', 15);
INSERT INTO `permiso` VALUES (1, 'departamento', 15);
INSERT INTO `permiso` VALUES (1, 'formulario', 8);
INSERT INTO `permiso` VALUES (1, 'mer', 8);
INSERT INTO `permiso` VALUES (1, 'municipio', 15);
INSERT INTO `permiso` VALUES (1, 'planilla', 15);
INSERT INTO `permiso` VALUES (1, 'regional', 15);
INSERT INTO `permiso` VALUES (1, 'responsable', 15);
INSERT INTO `permiso` VALUES (1, 'rubro', 15);
INSERT INTO `permiso` VALUES (1, 'tipo_contrato', 15);
INSERT INTO `permiso` VALUES (1, 'usuario', 15);
INSERT INTO `permiso` VALUES (1, 'matriz_marco_logico', 15);
INSERT INTO `permiso` VALUES (1, 'resumen_linea_base', 15);
INSERT INTO `permiso` VALUES (1, 'reporte_mml', 15);
INSERT INTO `permiso` VALUES (1, 'reporte_rubros', 15);
INSERT INTO `permiso` VALUES (1, 'reporte_mers_fortalecidas', 15);
INSERT INTO `permiso` VALUES (1, 'reporte_general', 15);
INSERT INTO `permiso` VALUES (1, 'indicador_impacto', 15);
INSERT INTO `permiso` VALUES (1, 'indicador_1', 15);
INSERT INTO `permiso` VALUES (1, 'indicador_2', 15);
INSERT INTO `permiso` VALUES (1, 'indicador_3', 15);
INSERT INTO `permiso` VALUES (1, 'indicador_4', 15);
INSERT INTO `permiso` VALUES (1, 'indicador_5', 15);
INSERT INTO `permiso` VALUES (1, 'indicador_6', 15);
INSERT INTO `permiso` VALUES (1, 'indicador_7', 15);
INSERT INTO `permiso` VALUES (1, 'indicador_8', 15);
INSERT INTO `permiso` VALUES (1, 'indicador_9', 15);
INSERT INTO `permiso` VALUES (1, 'indicador_10', 15);
INSERT INTO `permiso` VALUES (1, 'indicador_11', 15);
INSERT INTO `permiso` VALUES (1, 'indicador_12', 15);
INSERT INTO `permiso` VALUES (1, 'indicador_13', 15);
INSERT INTO `permiso` VALUES (1, 'indicador_14', 15);
INSERT INTO `permiso` VALUES (1, 'consultoria', 0);
INSERT INTO `permiso` VALUES (1, 'cronograma', 0);
INSERT INTO `permiso` VALUES (1, 'responsable_consultoria', 0);
INSERT INTO `permiso` VALUES (2, 'comunidad', 0);
INSERT INTO `permiso` VALUES (2, 'departamento', 0);
INSERT INTO `permiso` VALUES (2, 'formulario', 0);
INSERT INTO `permiso` VALUES (2, 'mer', 15);
INSERT INTO `permiso` VALUES (2, 'municipio', 0);
INSERT INTO `permiso` VALUES (2, 'planilla', 0);
INSERT INTO `permiso` VALUES (2, 'regional', 0);
INSERT INTO `permiso` VALUES (2, 'responsable', 0);
INSERT INTO `permiso` VALUES (2, 'rubro', 0);
INSERT INTO `permiso` VALUES (2, 'tipo_contrato', 0);
INSERT INTO `permiso` VALUES (2, 'usuario', 0);
INSERT INTO `permiso` VALUES (2, 'matriz_marco_logico', 8);
INSERT INTO `permiso` VALUES (2, 'resumen_linea_base', 8);
INSERT INTO `permiso` VALUES (2, 'reporte_mml', 0);
INSERT INTO `permiso` VALUES (2, 'reporte_rubros', 0);
INSERT INTO `permiso` VALUES (2, 'reporte_mers_fortalecidas', 0);
INSERT INTO `permiso` VALUES (2, 'reporte_general', 0);
INSERT INTO `permiso` VALUES (2, 'indicador_impacto', 0);
INSERT INTO `permiso` VALUES (2, 'indicador_1', 0);
INSERT INTO `permiso` VALUES (2, 'indicador_2', 0);
INSERT INTO `permiso` VALUES (2, 'indicador_3', 0);
INSERT INTO `permiso` VALUES (2, 'indicador_4', 0);
INSERT INTO `permiso` VALUES (2, 'indicador_5', 0);
INSERT INTO `permiso` VALUES (2, 'indicador_6', 0);
INSERT INTO `permiso` VALUES (2, 'indicador_7', 0);
INSERT INTO `permiso` VALUES (2, 'indicador_8', 0);
INSERT INTO `permiso` VALUES (2, 'indicador_9', 0);
INSERT INTO `permiso` VALUES (2, 'indicador_10', 0);
INSERT INTO `permiso` VALUES (2, 'indicador_11', 0);
INSERT INTO `permiso` VALUES (2, 'indicador_12', 0);
INSERT INTO `permiso` VALUES (2, 'indicador_13', 0);
INSERT INTO `permiso` VALUES (2, 'indicador_14', 0);
INSERT INTO `permiso` VALUES (2, 'consultoria', 0);
INSERT INTO `permiso` VALUES (2, 'cronograma', 0);
INSERT INTO `permiso` VALUES (2, 'responsable_consultoria', 0);
INSERT INTO `permiso` VALUES (4, 'comunidad', 0);
INSERT INTO `permiso` VALUES (4, 'departamento', 0);
INSERT INTO `permiso` VALUES (4, 'formulario', 0);
INSERT INTO `permiso` VALUES (4, 'mer', 0);
INSERT INTO `permiso` VALUES (4, 'municipio', 0);
INSERT INTO `permiso` VALUES (4, 'planilla', 0);
INSERT INTO `permiso` VALUES (4, 'regional', 0);
INSERT INTO `permiso` VALUES (4, 'responsable', 0);
INSERT INTO `permiso` VALUES (4, 'rubro', 0);
INSERT INTO `permiso` VALUES (4, 'tipo_contrato', 0);
INSERT INTO `permiso` VALUES (4, 'usuario', 0);
INSERT INTO `permiso` VALUES (4, 'matriz_marco_logico', 8);
INSERT INTO `permiso` VALUES (4, 'resumen_linea_base', 8);
INSERT INTO `permiso` VALUES (4, 'reporte_mml', 8);
INSERT INTO `permiso` VALUES (4, 'reporte_rubros', 8);
INSERT INTO `permiso` VALUES (4, 'reporte_mers_fortalecidas', 8);
INSERT INTO `permiso` VALUES (4, 'reporte_general', 8);
INSERT INTO `permiso` VALUES (4, 'indicador_impacto', 0);
INSERT INTO `permiso` VALUES (4, 'indicador_1', 0);
INSERT INTO `permiso` VALUES (4, 'indicador_2', 0);
INSERT INTO `permiso` VALUES (4, 'indicador_3', 0);
INSERT INTO `permiso` VALUES (4, 'indicador_4', 0);
INSERT INTO `permiso` VALUES (4, 'indicador_5', 0);
INSERT INTO `permiso` VALUES (4, 'indicador_6', 0);
INSERT INTO `permiso` VALUES (4, 'indicador_7', 0);
INSERT INTO `permiso` VALUES (4, 'indicador_8', 0);
INSERT INTO `permiso` VALUES (4, 'indicador_9', 0);
INSERT INTO `permiso` VALUES (4, 'indicador_10', 0);
INSERT INTO `permiso` VALUES (4, 'indicador_11', 0);
INSERT INTO `permiso` VALUES (4, 'indicador_12', 0);
INSERT INTO `permiso` VALUES (4, 'indicador_13', 0);
INSERT INTO `permiso` VALUES (4, 'indicador_14', 0);
INSERT INTO `permiso` VALUES (4, 'consultoria', 0);
INSERT INTO `permiso` VALUES (4, 'cronograma', 0);
INSERT INTO `permiso` VALUES (4, 'responsable_consultoria', 0);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `planilla`
-- 

CREATE TABLE `planilla` (
  `idPlanilla` int(11) NOT NULL auto_increment,
  `Nombre` varchar(150) NOT NULL,
  PRIMARY KEY  (`idPlanilla`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `planilla`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `pregunta`
-- 

CREATE TABLE `pregunta` (
  `idPregunta` int(11) NOT NULL auto_increment,
  `idPlanilla` int(11) NOT NULL,
  `pregunta` varchar(255) NOT NULL,
  PRIMARY KEY  (`idPregunta`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `pregunta`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `pregunta_respuesta`
-- 

CREATE TABLE `pregunta_respuesta` (
  `idPR` int(11) NOT NULL auto_increment,
  `idMer` int(11) NOT NULL,
  `idPlanilla` int(11) NOT NULL,
  `idCL` int(11) NOT NULL,
  `idPregunta` int(11) NOT NULL,
  `respuesta` varchar(50) default NULL,
  `respuesta2` varchar(50) NOT NULL COMMENT 'solo planilla 15',
  `fechaInicio` date NOT NULL default '0000-00-00' COMMENT 'solo planilla 15',
  `fechaFinal` date NOT NULL default '0000-00-00' COMMENT 'solo planilla 15',
  PRIMARY KEY  (`idPR`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `pregunta_respuesta`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `regional`
-- 

CREATE TABLE `regional` (
  `idRegional` int(11) NOT NULL auto_increment,
  `regional` varchar(100) NOT NULL,
  PRIMARY KEY  (`idRegional`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `regional`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `registroventas17`
-- 

CREATE TABLE `registroventas17` (
  `idRegistroVentas` int(11) NOT NULL auto_increment,
  `idMer` int(11) NOT NULL,
  `idPlanilla` int(11) NOT NULL,
  `nro` int(11) NOT NULL,
  `tipo` varchar(150) NOT NULL,
  `nombreComprador` varchar(150) NOT NULL,
  `detalle` varchar(255) NOT NULL,
  `precioUnitario` float NOT NULL,
  `cantidad` float NOT NULL,
  `valor` float NOT NULL,
  `fecha` date NOT NULL default '0000-00-00',
  `cumple` varchar(150) NOT NULL,
  PRIMARY KEY  (`idRegistroVentas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `registroventas17`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `registro_contrato`
-- 

CREATE TABLE `registro_contrato` (
  `idRegistroContrato` int(11) NOT NULL auto_increment,
  `registroContrato` varchar(255) NOT NULL,
  `idPlanilla` int(11) NOT NULL,
  PRIMARY KEY  (`idRegistroContrato`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `registro_contrato`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `responsable`
-- 

CREATE TABLE `responsable` (
  `idResponsable` int(11) NOT NULL auto_increment,
  `idGerente` int(11) NOT NULL,
  `idMer` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `habilitado` int(11) NOT NULL default '1',
  PRIMARY KEY  (`idResponsable`),
  UNIQUE KEY `idGerente` (`idGerente`,`idMer`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `responsable`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `responsable_consultoria`
-- 

CREATE TABLE `responsable_consultoria` (
  `idRC` int(11) NOT NULL auto_increment,
  `idUsuario` int(11) NOT NULL,
  `idConsultoria` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `habilitado` int(11) NOT NULL default '1',
  PRIMARY KEY  (`idRC`),
  UNIQUE KEY `idUsuario` (`idUsuario`,`idConsultoria`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `responsable_consultoria`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `resultado`
-- 

CREATE TABLE `resultado` (
  `idResultado` int(11) NOT NULL auto_increment,
  `idCronograma` int(11) NOT NULL,
  `resultado` text NOT NULL,
  `resultadoAlcanzar` int(11) NOT NULL,
  `cabezera` binary(1) NOT NULL,
  PRIMARY KEY  (`idResultado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `resultado`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rol`
-- 

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY  (`idRol`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `rol`
-- 

INSERT INTO `rol` VALUES (0, 'Default');
INSERT INTO `rol` VALUES (-1, 'Administrator');
INSERT INTO `rol` VALUES (1, 'Administrador Sistema');
INSERT INTO `rol` VALUES (2, 'Gerente');
INSERT INTO `rol` VALUES (3, 'Consultor de Gestión Empresarial');
INSERT INTO `rol` VALUES (4, 'Usuario solo Reportes');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `rubro`
-- 

CREATE TABLE `rubro` (
  `idRubro` int(11) NOT NULL auto_increment,
  `rubro` varchar(150) NOT NULL,
  `detalle` varchar(250) default NULL,
  `gestion2010` int(11) NOT NULL,
  `gestion2011` int(11) NOT NULL,
  `gestion2012` int(11) NOT NULL,
  PRIMARY KEY  (`idRubro`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `rubro`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tipo_contrato`
-- 

CREATE TABLE `tipo_contrato` (
  `idTipoContrato` int(11) NOT NULL auto_increment,
  `tipoContrato` varchar(255) NOT NULL,
  `idPlanilla` int(11) NOT NULL,
  PRIMARY KEY  (`idTipoContrato`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `tipo_contrato`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuario`
-- 

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL auto_increment,
  `idRol` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `paterno` varchar(150) default NULL,
  `materno` varchar(150) default NULL,
  `ci` int(11) NOT NULL,
  `cargo` varchar(150) default NULL,
  `email` varchar(150) NOT NULL,
  `login` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  PRIMARY KEY  (`idUsuario`),
  UNIQUE KEY `ci` (`ci`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- 
-- Volcar la base de datos para la tabla `usuario`
-- 

INSERT INTO `usuario` VALUES (1, -1, 'Luis Freddy', 'Velasco', 'Poma', 48773883, 'consultor de sistemas web', 'fredd_for@hotmail.com', 'freddy', 'eda56def9e82a3936a75aff3f4e66330');
INSERT INTO `usuario` VALUES (2, 1, 'Adolfo', 'Ruiz', NULL, 7654321, 'Especialista del BID', 'aruiz@fh.org', 'aruiz', '66fdf2d9ffcae25a01c9bb648ebaa631');
INSERT INTO `usuario` VALUES (3, 1, 'Juan Carlos', 'Suarez', NULL, 1234567, 'Encargado Nacional BID', 'jsuarez@fh.org', 'jsuarez', '6930c6f994ed8e65d49cb1e6f8649bdd');
INSERT INTO `usuario` VALUES (4, 4, 'Oscar', 'Montes', NULL, 12345678, 'Director Nacional', 'omontes@fh.org', 'omontes', '6c04cb806ed2c9339b52bd8818f05147');
INSERT INTO `usuario` VALUES (5, 2, 'Alvaro', 'Gallo', 'Subieta', 44332345, 'Consultor Gestión Empresarial-Cochabamba', 'agallo@fh.org', 'agallo', '51c1b2fd85f8d5780aa8b8616b4f71f2');
INSERT INTO `usuario` VALUES (6, 2, 'Lilian', 'Venegas', 'Ruiz', 44332346, 'Consultor Gestión Empresarial-Potosí', 'dasovic2009@hotmail.com', 'lvenegas', '929288676634a21ccb5e4c85a979d1c7');
INSERT INTO `usuario` VALUES (7, 2, 'David', 'Loayza', NULL, 44332347, 'Consultor Gestión Empresarial-Potosí', 'dasovic2009@hotmail.com', 'dloayza', '24f929bf006ccffbb8dd5f275fdf9514');
