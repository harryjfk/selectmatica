
CREATE TABLE IF NOT EXISTS `nomencladores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `tipo` enum('cargo','tipo_carga','ocupacion','fletador','mod_flatamento','tipo_viaje','operacion','consolidadora') NOT NULL,
  `activo` tinyint(1) DEFAULT '1' COMMENT '0-Inactivo, 1-Activo',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`,`tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=157 ;

--
-- Volcado de datos para la tabla `nomencladores`
--

INSERT INTO `nomencladores` (`id`, `nombre`, `slug`, `tipo`, `activo`) VALUES
(2, 'Espacialista de Pago', 'espacialista_de_pago', 'ocupacion', 1),
(3, 'Negociador', 'negociador', 'ocupacion', 1),
(118, 'Capitán', 'capitan', 'cargo', 1),
(122, 'Director', 'director', 'cargo', 1),
(125, 'WHEAT IN BULK', 'wheat_in_bulk', 'tipo_carga', 1),
(141, 'Primer Oficial', 'primer_oficial', 'cargo', 1),
(142, 'ACANDO', 'acando', 'fletador', 1),
(143, 'MUR SHIPPING', 'mur_shipping', 'fletador', 1),
(144, 'SUCDEN', 'sucden', 'fletador', 1),
(145, 'NAVISION', 'navision', 'fletador', 1),
(146, 'Importación', 'importacion', 'tipo_viaje', 1),
(147, 'Exportación', 'exportacion', 'tipo_viaje', 1),
(148, 'Voyage', 'voyage', 'mod_flatamento', 1),
(149, 'TC', 'tce', 'mod_flatamento', 1),
(150, 'Load', 'load', 'operacion', 1),
(151, 'Bunker', 'bunker', 'operacion', 1),
(152, 'FLET NEW', 'flet_new', 'fletador', 1),
(153, 'Administrador de Sistema', 'administrador_de_sistema', 'cargo', 1),
(154, 'Rice', 'rice', 'tipo_carga', 1),
(155, 'Candy', 'candy', 'consolidadora', 1),
(156, 'Zimbala', 'zimbala', 'consolidadora', 1);

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `seguridad_grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_grupo` varchar(255) DEFAULT NULL,
  `essistema` tinyint(1) DEFAULT '0' COMMENT '0-no es de sistema, 1- es de sistema',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `seguridad_grupo`
--

INSERT INTO `seguridad_grupo` (`id`, `nombre_grupo`, `essistema`) VALUES
(1, 'Super Administrador', 0),
(5, 'Director', 0),
(11, 'Operaciones', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguridad_grupo_rol`
--

CREATE TABLE IF NOT EXISTS `seguridad_grupo_rol` (
  `grupoid` int(11) NOT NULL,
  `rol` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`grupoid`,`rol`),
  KEY `rol` (`rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `seguridad_grupo_rol`
--

INSERT INTO `seguridad_grupo_rol` (`grupoid`, `rol`) VALUES
(1, 'ROLE_BUQUES_DELETE'),
(11, 'ROLE_BUQUES_DELETE'),
(1, 'ROLE_BUQUES_EDIT'),
(11, 'ROLE_BUQUES_EDIT'),
(1, 'ROLE_BUQUES_NEW'),
(11, 'ROLE_BUQUES_NEW'),
(1, 'ROLE_BUQUES_VIEW'),
(11, 'ROLE_BUQUES_VIEW'),
(1, 'ROLE_COMBUS_PREV_DELETE'),
(1, 'ROLE_COMBUS_PREV_EDIT'),
(1, 'ROLE_COMBUS_PREV_NEW'),
(1, 'ROLE_COMBUS_PREV_VIEW'),
(1, 'ROLE_DAYLI_POSITION_CREATE'),
(1, 'ROLE_DAYLI_POSITION_DELETE'),
(1, 'ROLE_DAYLI_POSITION_EDIT'),
(1, 'ROLE_DAYLI_POSITION_VIEW'),
(1, 'ROLE_GRUPO_USUARIO_DELETE'),
(1, 'ROLE_GRUPO_USUARIO_EDIT'),
(1, 'ROLE_GRUPO_USUARIO_NEW'),
(1, 'ROLE_GRUPO_USUARIO_VIEW'),
(1, 'ROLE_MARINO_DELETE'),
(11, 'ROLE_MARINO_DELETE'),
(1, 'ROLE_MARINO_EDIT'),
(11, 'ROLE_MARINO_EDIT'),
(1, 'ROLE_MARINO_NEW'),
(11, 'ROLE_MARINO_NEW'),
(1, 'ROLE_MARINO_VIEW'),
(11, 'ROLE_MARINO_VIEW'),
(1, 'ROLE_MONEDA_DELETE'),
(1, 'ROLE_MONEDA_EDIT'),
(1, 'ROLE_MONEDA_NEW'),
(1, 'ROLE_MONEDA_VIEW'),
(1, 'ROLE_NOMENCLADORES_DELETE'),
(11, 'ROLE_NOMENCLADORES_DELETE'),
(1, 'ROLE_NOMENCLADORES_EDIT'),
(11, 'ROLE_NOMENCLADORES_EDIT'),
(1, 'ROLE_NOMENCLADORES_NEW'),
(11, 'ROLE_NOMENCLADORES_NEW'),
(1, 'ROLE_NOMENCLADORES_VIEW'),
(11, 'ROLE_NOMENCLADORES_VIEW'),
(1, 'ROLE_PUERTOS_DELETE'),
(11, 'ROLE_PUERTOS_DELETE'),
(1, 'ROLE_PUERTOS_EDIT'),
(11, 'ROLE_PUERTOS_EDIT'),
(1, 'ROLE_PUERTOS_NEW'),
(11, 'ROLE_PUERTOS_NEW'),
(1, 'ROLE_PUERTOS_VIEW'),
(11, 'ROLE_PUERTOS_VIEW'),
(1, 'ROLE_REPORTE_OPERACIONES'),
(1, 'ROLE_REPORTE_OPERACIONES_DIR'),
(1, 'ROLE_SALVAS_CREATE'),
(1, 'ROLE_SALVAS_VIEW'),
(1, 'ROLE_TRAZA_VIEW'),
(1, 'ROLE_USUARIO_DELETE'),
(1, 'ROLE_USUARIO_EDIT'),
(1, 'ROLE_USUARIO_NEW'),
(1, 'ROLE_USUARIO_VIEW'),
(1, 'ROLE_VIAJE_EDIT'),
(1, 'ROLE_VIAJE_NEW'),
(1, 'ROLE_VIAJE_VIEW'),
(1, 'ROLE_VIAJE_VIEW_SPECIAL_DATA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguridad_salvas`
--

CREATE TABLE IF NOT EXISTS `seguridad_salvas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comentario` varchar(255) DEFAULT NULL,
  `fecha_salva` datetime NOT NULL,
  `nombre_fichero` varchar(255) NOT NULL,
  `idusuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idusuario` (`idusuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguridad_secciones`
--

CREATE TABLE IF NOT EXISTS `seguridad_secciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Volcado de datos para la tabla `seguridad_secciones`
--

INSERT INTO `seguridad_secciones` (`id`, `nombre`) VALUES
(3, 'Nomencladores'),
(5, 'Monedas'),
(7, 'Zonas Geográficas'),
(9, 'Usuarios'),
(10, 'Grupos de Usuarios'),
(11, 'Salvas Base de datos'),
(13, 'Marinos'),
(14, 'Puertos'),
(15, 'Buques'),
(16, 'Posición'),
(17, 'Reportes'),
(18, 'Posición diaria'),
(19, 'Combustibles Previstos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguridad_secciones_roles`
--

CREATE TABLE IF NOT EXISTS `seguridad_secciones_roles` (
  `rol` varchar(50) NOT NULL,
  `seccionid` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`rol`),
  KEY `seccionid` (`seccionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `seguridad_secciones_roles`
--

INSERT INTO `seguridad_secciones_roles` (`rol`, `seccionid`, `nombre`) VALUES
('ROLE_BUQUES_DELETE', 15, 'Eliminar'),
('ROLE_BUQUES_EDIT', 15, 'Editar'),
('ROLE_BUQUES_NEW', 15, 'Crear'),
('ROLE_BUQUES_VIEW', 15, 'Ver'),
('ROLE_COMBUS_PREV_DELETE', 19, 'Eliminar'),
('ROLE_COMBUS_PREV_EDIT', 19, 'Editar'),
('ROLE_COMBUS_PREV_NEW', 19, 'Crear'),
('ROLE_COMBUS_PREV_VIEW', 19, 'Ver'),
('ROLE_DAYLI_POSITION_CREATE', 17, 'Crear'),
('ROLE_DAYLI_POSITION_DELETE', 17, 'Eliminar'),
('ROLE_DAYLI_POSITION_EDIT', 17, 'Editar'),
('ROLE_DAYLI_POSITION_VIEW', 17, 'Ver'),
('ROLE_GRUPO_USUARIO_DELETE', 10, 'Eliminar'),
('ROLE_GRUPO_USUARIO_EDIT', 10, 'Editar'),
('ROLE_GRUPO_USUARIO_NEW', 10, 'Crear'),
('ROLE_GRUPO_USUARIO_VIEW', 10, 'Ver'),
('ROLE_MARINO_DELETE', 13, 'Eliminar'),
('ROLE_MARINO_EDIT', 13, 'Editar'),
('ROLE_MARINO_NEW', 13, 'Nuevo'),
('ROLE_MARINO_VIEW', 13, 'Ver'),
('ROLE_MONEDA_DELETE', 5, 'Eliminar'),
('ROLE_MONEDA_EDIT', 5, 'Editar'),
('ROLE_MONEDA_NEW', 5, 'Crear'),
('ROLE_MONEDA_VIEW', 5, 'Ver'),
('ROLE_NOMENCLADORES_DELETE', 3, 'Eliminar'),
('ROLE_NOMENCLADORES_EDIT', 3, 'Editar'),
('ROLE_NOMENCLADORES_NEW', 3, 'Crear'),
('ROLE_NOMENCLADORES_VIEW', 3, 'Ver'),
('ROLE_PUERTOS_DELETE', 14, 'Eliminar'),
('ROLE_PUERTOS_EDIT', 14, 'Editar'),
('ROLE_PUERTOS_NEW', 14, 'Nuevo'),
('ROLE_PUERTOS_VIEW', 14, 'Ver'),
('ROLE_REPORTE_OPERACIONES', 17, 'Reportes de operaciones'),
('ROLE_REPORTE_OPERACIONES_DIR', 17, 'Reportes de operaciones para directivos'),
('ROLE_SALVAS_CREATE', 11, 'Crear'),
('ROLE_SALVAS_VIEW', 11, 'Ver'),
('ROLE_TRAZA_VIEW', 9, 'Ver Trazas'),
('ROLE_USUARIO_DELETE', 9, 'Eliminar'),
('ROLE_USUARIO_EDIT', 9, 'Editar'),
('ROLE_USUARIO_NEW', 9, 'Crear'),
('ROLE_USUARIO_VIEW', 9, 'Ver'),
('ROLE_VIAJE_EDIT', 16, 'Editar'),
('ROLE_VIAJE_NEW', 16, 'Crear'),
('ROLE_VIAJE_VIEW', 16, 'Ver'),
('ROLE_VIAJE_VIEW_SPECIAL_DATA', 16, 'Ver datos privados');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguridad_traza`
--

CREATE TABLE IF NOT EXISTS `seguridad_traza` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) NOT NULL,
  `accion` varchar(255) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `tabla` varchar(25) DEFAULT NULL,
  `idregistro` varchar(100) DEFAULT NULL,
  `observacion` text,
  `fecha` datetime NOT NULL,
  `metadatos` text,
  PRIMARY KEY (`id`),
  KEY `idusuario` (`usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=541 ;

--
-- Estructura de tabla para la tabla `seguridad_usuario_grupo`
--

CREATE TABLE IF NOT EXISTS `seguridad_usuario_grupo` (
  `usuarioid` int(11) NOT NULL DEFAULT '0',
  `grupoid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usuarioid`,`grupoid`),
  KEY `grupoid` (`grupoid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `seguridad_usuario_grupo`
--

INSERT INTO `seguridad_usuario_grupo` (`usuarioid`, `grupoid`) VALUES
(8, 1),
(9, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `primer_apellido` varchar(255) DEFAULT NULL,
  `segundo_apellido` varchar(255) DEFAULT NULL,
  `nick` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contrasenya` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `esadmin` tinyint(1) DEFAULT '0' COMMENT 'si es admin no se puede borrar el usuario',
  `idcargo` int(11) DEFAULT NULL,
  `idocupacion` int(11) DEFAULT NULL,
  `creado` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nick` (`nick`),
  UNIQUE KEY `email` (`email`),
  KEY `idcargo` (`idcargo`),
  KEY `idocupacion` (`idocupacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `primer_apellido`, `segundo_apellido`, `nick`, `email`, `contrasenya`, `salt`, `esadmin`, `idcargo`, `idocupacion`, `creado`) VALUES
(8, 'Edgar', 'Rodríguez', 'de Vera', 'admin', 'admin@localhost.com', '3fSa9VUHFfDDwYWwQRkXVZyalGiqweK6H+AsSDMD+INZ0Gvr7sGURQR7tAs4JMHTqeXz60WNJG78QGtda6IoHA==', 'e0ea831a680c9f2fc3cdad9f1e9763c50ca789e8', 1, 153, 3, '2016-01-07 23:13:35'),
(9, 'opsdir', 'opsdir', 'opsdir', 'opsdir', 'opsdir@notrthsouth.gr', 'wngVRVmySW5TeulFYlYJxTyaKsUq+bSu4Q/pI4SEdCZhxDxGvBoA002Qw6q3p8LV15gd/c7axFE/s+xoix+qSQ==', '97b2d318b1efe1754d1d4f4776da3d2f25916dbd', 0, 118, NULL, '2016-04-27 08:55:57');

-- --------------------------------------------------------

-- Filtros para la tabla `seguridad_grupo_rol`
--
ALTER TABLE `seguridad_grupo_rol`
  ADD CONSTRAINT `seguridad_grupo_rol_ibfk_1` FOREIGN KEY (`grupoid`) REFERENCES `seguridad_grupo` (`id`),
  ADD CONSTRAINT `seguridad_grupo_rol_ibfk_2` FOREIGN KEY (`rol`) REFERENCES `seguridad_secciones_roles` (`rol`);

--
-- Filtros para la tabla `seguridad_salvas`
--
ALTER TABLE `seguridad_salvas`
  ADD CONSTRAINT `seguridad_salvas_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `seguridad_secciones_roles`
--
ALTER TABLE `seguridad_secciones_roles`
  ADD CONSTRAINT `seguridad_secciones_roles_ibfk_1` FOREIGN KEY (`seccionid`) REFERENCES `seguridad_secciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `seguridad_usuario_grupo`
--
ALTER TABLE `seguridad_usuario_grupo`
  ADD CONSTRAINT `seguridad_usuario_grupo_ibfk_1` FOREIGN KEY (`usuarioid`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `seguridad_usuario_grupo_ibfk_2` FOREIGN KEY (`grupoid`) REFERENCES `seguridad_grupo` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`idcargo`) REFERENCES `nomencladores` (`id`),
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`idocupacion`) REFERENCES `nomencladores` (`id`);
