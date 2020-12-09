-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 09-12-2020 a las 09:17:00
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `feriacalzado`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aviso`
--

CREATE TABLE IF NOT EXISTS `aviso` (
  `id_aviso` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario_aviso` int(11) NOT NULL,
  `mensaje` varchar(250) NOT NULL,
  PRIMARY KEY (`id_aviso`),
  UNIQUE KEY `id_aviso_UNIQUE` (`id_aviso`),
  KEY `id_usuario_aviso` (`id_usuario_aviso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE IF NOT EXISTS `cargo` (
  `id_cargo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_cargo` varchar(45) NOT NULL,
  PRIMARY KEY (`id_cargo`),
  UNIQUE KEY `id_cargo_UNIQUE` (`id_cargo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `nombre_cargo`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE IF NOT EXISTS `carrito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `cantidad` double NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(400) NOT NULL,
  `imagen` varchar(400) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `imagen`) VALUES
(1, 'hombre', 'calzado de hombres', 'men.jpg'),
(2, 'mujer', 'calzado de mujer', 'women.jpg'),
(3, 'niños', 'calzado de niños', 'children.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `rut` varchar(45) NOT NULL,
  `telefono` varchar(45) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `id_cliente_UNIQUE` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE IF NOT EXISTS `detalle_pedido` (
  `id_detallePedido` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido_detalle` int(11) NOT NULL,
  `id_producto_detpedido` int(11) NOT NULL,
  PRIMARY KEY (`id_detallePedido`),
  UNIQUE KEY `id_detallePedido_UNIQUE` (`id_detallePedido`),
  KEY `id_producto_detpedido_idx` (`id_producto_detpedido`),
  KEY `id_pedido_detalle_idx` (`id_pedido_detalle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_producto`
--

CREATE TABLE IF NOT EXISTS `detalle_producto` (
  `id_detalle_producto` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto_detproducto` int(11) NOT NULL,
  `detalle_producto` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_detalle_producto`),
  UNIQUE KEY `id_detalle_producto_UNIQUE` (`id_detalle_producto`),
  KEY `id_producto_detproducto_idx` (`id_producto_detproducto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento`
--

CREATE TABLE IF NOT EXISTS `movimiento` (
  `id_movimiento` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_movimiento` varchar(45) NOT NULL,
  `id_usuario_movimiento` int(11) NOT NULL,
  `fechaHora` datetime NOT NULL,
  `observaciones` varchar(250) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  PRIMARY KEY (`id_movimiento`),
  UNIQUE KEY `id_movimiento_UNIQUE` (`id_movimiento`),
  KEY `id_proveedor_idx` (`id_proveedor`),
  KEY `id_usuario_movimiento` (`id_usuario_movimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_detalle`
--

CREATE TABLE IF NOT EXISTS `movimiento_detalle` (
  `id_movimientoDetalle` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `observacion_por_producto` varchar(250) DEFAULT NULL,
  `id_movimiento_fk` int(11) NOT NULL,
  `id_producto_movdetalle` int(11) NOT NULL,
  PRIMARY KEY (`id_movimientoDetalle`),
  UNIQUE KEY `id_movimientoDetalle_UNIQUE` (`id_movimientoDetalle`),
  KEY `id_movimiento_fk` (`id_movimiento_fk`),
  KEY `id_producto_movdetalle` (`id_producto_movdetalle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `num_calzado`
--

CREATE TABLE IF NOT EXISTS `num_calzado` (
  `id_numCalzado` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto_num_calzado` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`id_numCalzado`),
  UNIQUE KEY `id_calzado_UNIQUE` (`id_numCalzado`),
  KEY `id_producto_num_calzado_idx` (`id_producto_num_calzado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE IF NOT EXISTS `pago` (
  `id_pago` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedido` int(11) NOT NULL,
  `medio_pago` varchar(50) NOT NULL,
  `total` int(11) NOT NULL,
  PRIMARY KEY (`id_pago`),
  UNIQUE KEY `id_pago_UNIQUE` (`id_pago`),
  KEY `id_pedido` (`id_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `direccion` varchar(100) NOT NULL,
  `region` varchar(50) NOT NULL,
  `cp` varchar(20) NOT NULL,
  `ciudad` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `fecha_entrega` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_pedido`),
  UNIQUE KEY `id_pedido_UNIQUE` (`id_pedido`),
  KEY `id_usuario_idx` (`id_usuario`),
  KEY `id_cliente_idx` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(300) NOT NULL,
  `descripcion` text NOT NULL,
  `precio_compra` int(11) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `stock` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `color` varchar(100) NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `precio_venta` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `id_categoria_idx` (`id_categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio_compra`, `imagen`, `stock`, `id_categoria`, `color`, `estado`, `precio_venta`) VALUES
(1, 'taco de mujer', 'taco de mujer con diseño', 1000, 'mujer1.jpeg', 10, 2, 'amarillo', 1, 2000),
(2, 'zapato hombre', 'zapato de hombre tipo bototo', 1500, '1607497874.png', 5, 1, 'cafe', 1, 3000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE IF NOT EXISTS `proveedores` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL,
  `rut` varchar(45) NOT NULL,
  `telefono` varchar(45) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `ciudad` varchar(45) NOT NULL,
  `region` varchar(45) NOT NULL,
  PRIMARY KEY (`id_proveedor`),
  UNIQUE KEY `id_cliente_UNIQUE` (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `img_perfil` varchar(300) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `id_cargo_idx` (`id_cargo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `password`, `img_perfil`, `id_cargo`) VALUES
(1, 'n.becerra@live.cl', '40BD001563085FC35165329EA1FF5C5ECBDBBEEF', 'person_1.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE IF NOT EXISTS `ventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_detalle_pedido` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `id_pago` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `id_detalle_pedido` (`id_detalle_pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aviso`
--
ALTER TABLE `aviso`
  ADD CONSTRAINT `id_usuario_aviso` FOREIGN KEY (`id_usuario_aviso`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `id_pedido_detalle` FOREIGN KEY (`id_pedido_detalle`) REFERENCES `pedido` (`id_pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_producto_detpedido` FOREIGN KEY (`id_producto_detpedido`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_producto`
--
ALTER TABLE `detalle_producto`
  ADD CONSTRAINT `id_producto_detproducto` FOREIGN KEY (`id_producto_detproducto`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `movimiento`
--
ALTER TABLE `movimiento`
  ADD CONSTRAINT `id_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_usuario_movimiento` FOREIGN KEY (`id_usuario_movimiento`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `movimiento_detalle`
--
ALTER TABLE `movimiento_detalle`
  ADD CONSTRAINT `id_movimiento_fk` FOREIGN KEY (`id_movimiento_fk`) REFERENCES `movimiento` (`id_movimiento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_producto_movdetalle` FOREIGN KEY (`id_producto_movdetalle`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `num_calzado`
--
ALTER TABLE `num_calzado`
  ADD CONSTRAINT `id_producto_num_calzado` FOREIGN KEY (`id_producto_num_calzado`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `id_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `id_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `id_cargo` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id_cargo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `id_detalle_pedido` FOREIGN KEY (`id_detalle_pedido`) REFERENCES `detalle_pedido` (`id_detallePedido`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
