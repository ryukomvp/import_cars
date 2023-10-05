-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-10-2023 a las 03:18:35
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `importcars`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacoras`
--

CREATE TABLE `bitacoras` (
  `idbitacora` int(11) NOT NULL,
  `mensaje` varchar(200) NOT NULL,
  `fechabitacora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodegas`
--

CREATE TABLE `bodegas` (
  `idbodega` int(11) NOT NULL,
  `numerobod` int(11) NOT NULL,
  `direccionbod` varchar(150) DEFAULT NULL,
  `idsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bodegas`
--

INSERT INTO `bodegas` (`idbodega`, `numerobod`, `direccionbod`, `idsucursal`) VALUES
(1, 1, 'bodega1', 1),
(2, 2, 'bodega2', 2),
(3, 3, 'bodega3', 3),
(4, 4, 'bodega4', 4),
(5, 5, 'bodega5', 5),
(6, 6, 'bodega6', 6),
(7, 7, 'bodega7', 7),
(8, 8, 'bodega8', 8),
(9, 9, 'bodega9', 9),
(10, 10, 'bodega10', 10),
(11, 11, 'bodega11', 11),
(12, 12, 'bodega12', 12),
(13, 13, 'bodega13', 13),
(14, 14, 'bodega14', 14),
(15, 15, 'bodega15', 15),
(16, 16, 'bodega16', 16),
(17, 17, 'bodega17', 17),
(18, 18, 'bodega18', 18),
(19, 19, 'bodega19', 19),
(20, 20, 'bodega20', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `idcaja` int(11) NOT NULL,
  `nombrecaja` varchar(20) NOT NULL,
  `nombreequipo` varchar(20) NOT NULL,
  `serieequipo` varchar(15) NOT NULL,
  `modeloequipo` varchar(20) NOT NULL,
  `idsucursal` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cajas`
--

INSERT INTO `cajas` (`idcaja`, `nombrecaja`, `nombreequipo`, `serieequipo`, `modeloequipo`, `idsucursal`, `idusuario`) VALUES
(1, 'Caja 1', 'HP basic 1080', '1098R3456P93', 'HP', 1, 1),
(2, 'Caja 2', 'HP basic 1080', '09876B4567C1', 'HP', 2, 1),
(3, 'Caja 3', 'Dell Conveni', '76543J345P12', 'DELL', 1, 1),
(4, 'Caja 1', 'MAC X', '9876P098I754', 'MAC', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajeros`
--

CREATE TABLE `cajeros` (
  `idcajero` int(11) NOT NULL,
  `nombrecajero` varchar(20) NOT NULL,
  `estadocajero` tinyint(1) NOT NULL,
  `fechaingreso` date NOT NULL,
  `idcaja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cajeros`
--

INSERT INTO `cajeros` (`idcajero`, `nombrecajero`, `estadocajero`, `fechaingreso`, `idcaja`) VALUES
(1, 'Cajero 1', 1, '2023-07-10', 1),
(2, 'Cajero 2', 1, '2023-06-05', 1),
(3, 'Cajero 3', 1, '2023-07-20', 1),
(4, 'Cajero 4', 1, '2023-05-24', 1),
(5, 'Cajero 5', 1, '2023-04-01', 1),
(6, 'Cajero 6', 1, '2023-06-12', 1),
(7, 'Cajero 7', 1, '2023-07-09', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idcategoria` int(11) NOT NULL,
  `categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idcategoria`, `categoria`) VALUES
(6, 'Chapa'),
(1, 'Escapes'),
(8, 'Espejos'),
(3, 'Focos'),
(4, 'Lamparas'),
(5, 'Manubrios'),
(7, 'Para Choques'),
(2, 'Puertas'),
(9, 'Retrovisores');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `giro` varchar(30) DEFAULT NULL,
  `dui` varchar(11) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `contacto` varchar(10) DEFAULT NULL,
  `descuento` decimal(5,2) DEFAULT NULL,
  `exoneracion` decimal(5,2) DEFAULT NULL,
  `fechaini` date NOT NULL,
  `tipocliente` enum('Fiscal','Consumidor Final') NOT NULL,
  `idplazo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idcliente`, `nombre`, `giro`, `dui`, `correo`, `telefono`, `contacto`, `descuento`, `exoneracion`, `fechaini`, `tipocliente`, `idplazo`) VALUES
(1, 'Jonathan Kevin Murcia Hernandez', 'Empresario', '23456712-1', 'kdekevo@gmail.com', '3456-2345', 'contacto1', 43.50, 50.00, '0000-00-00', 'Fiscal', 1),
(2, 'Jose Antonio Castillo Letona', 'Empresario', '73337323-0', 'jdejosesito@gmail.com', '3346-2482', 'contacto2', 86.80, 30.00, '0000-00-00', 'Fiscal', 2),
(3, 'Jonathan Guillermo Parada Payes', 'Empresario', '46576748-2', 'cdecarbajal@gmail.com', '3226-2157', 'contacto3', 33.70, 60.00, '0000-00-00', 'Fiscal', 3),
(4, 'Juan Kevo Ramirez Carbajal', 'Empresario', '71456472-1', 'ddedaniel@gmail.com', '3590-2781', 'contacto4', 72.60, 100.00, '0000-00-00', 'Fiscal', 4),
(5, 'Diego Jose Murcia Hernandez', 'Empresario', '64567849-3', 'adeandre@gmail.com', '3419-6589', 'contacto5', 71.20, 20.00, '0000-00-00', 'Fiscal', 5),
(6, 'Cristian Andre Heriquez Pineda', 'Empresario', '68452672-4', 'adealec@gmail.com', '3418-7821', 'contacto6', 68.90, 23.00, '0000-00-00', 'Fiscal', 6),
(7, 'Alec Andre Marchelli Chavez', 'Empresario', '53362162-4', 'tdetanqueta@gmail.com', '6585-2367', 'contacto7', 22.70, 56.00, '0000-00-00', 'Fiscal', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigoscomunes`
--

CREATE TABLE `codigoscomunes` (
  `idcodigocomun` int(11) NOT NULL,
  `codigo` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `codigoscomunes`
--

INSERT INTO `codigoscomunes` (`idcodigocomun`, `codigo`) VALUES
(5, 'FDD0001930'),
(6, 'FDI0001931'),
(7, 'FTD0001903'),
(8, 'FTI0001913'),
(2, 'PDD0001824'),
(1, 'PDI0001823'),
(4, 'PTD 0001842'),
(3, 'PTI0001832'),
(9, 'RD0002043'),
(10, 'RI0002034');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigosplazos`
--

CREATE TABLE `codigosplazos` (
  `idcodigoplazo` int(11) NOT NULL,
  `plazo` varchar(30) DEFAULT NULL,
  `dias` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `codigosplazos`
--

INSERT INTO `codigosplazos` (`idcodigoplazo`, `plazo`, `dias`) VALUES
(1, 'plazo1', 1),
(2, 'plazo2', 2),
(3, 'plazo3', 3),
(4, 'plazo4', 4),
(5, 'plazo5', 5),
(6, 'plazo6', 6),
(7, 'plazo7', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigostransacciones`
--

CREATE TABLE `codigostransacciones` (
  `idcodigotransaccion` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `nombrecodigo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `codigostransacciones`
--

INSERT INTO `codigostransacciones` (`idcodigotransaccion`, `codigo`, `nombrecodigo`) VALUES
(1, 1234, 'Venta'),
(2, 1235, 'Ingreso'),
(3, 1236, 'Recuento'),
(4, 1237, 'Traspaso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `idcontacto` int(11) NOT NULL,
  `telefonocontact` varchar(16) NOT NULL,
  `celularcontact` varchar(16) NOT NULL,
  `correocontac` varchar(70) NOT NULL,
  `idsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`idcontacto`, `telefonocontact`, `celularcontact`, `correocontac`, `idsucursal`) VALUES
(1, '7109-4312', '7109-4312', 'empresa1@gmail.com', 1),
(2, '0942-1234', '7788-6565', 'empresa2@gmail.com', 2),
(3, '7788-6565', '7655-0000', 'empresa3@gmail.com', 3),
(4, '7655-0000', '7655-0000', 'empresa4@gmail.com', 4),
(5, '0964-4566', '7655-7966', 'empresa5@gmail.com', 5),
(6, '1234-5678', '0005-0000', 'empresa6@gmail.com', 6),
(7, '0112-0987', '7655-0000', 'empresa7@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallestransacciones`
--

CREATE TABLE `detallestransacciones` (
  `iddetalletransaccion` int(11) NOT NULL,
  `correlativo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `preciounitario` decimal(8,2) NOT NULL,
  `ventanosujeta` decimal(5,2) DEFAULT NULL,
  `ventaexenta` decimal(5,2) DEFAULT NULL,
  `ventaafecta` decimal(5,2) DEFAULT NULL,
  `descuento` decimal(5,2) NOT NULL,
  `valordescuento` decimal(8,2) NOT NULL,
  `sumas` decimal(8,2) NOT NULL,
  `subtotal` decimal(8,2) NOT NULL,
  `ventatotal` decimal(8,2) NOT NULL,
  `iva` decimal(5,2) NOT NULL,
  `observaciones` varchar(200) DEFAULT NULL,
  `idbodegaentrada` int(11) DEFAULT NULL,
  `idbodegasalida` int(11) DEFAULT NULL,
  `idproducto` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallestransacciones`
--

INSERT INTO `detallestransacciones` (`iddetalletransaccion`, `correlativo`, `cantidad`, `preciounitario`, `ventanosujeta`, `ventaexenta`, `ventaafecta`, `descuento`, `valordescuento`, `sumas`, `subtotal`, `ventatotal`, `iva`, `observaciones`, `idbodegaentrada`, `idbodegasalida`, `idproducto`, `descripcion`) VALUES
(1, 1, 50, 20.00, 15.00, 40.00, 34.00, 40.00, 20.00, 40.00, 34.00, 34.00, 19.00, 'Exelente', 1, 1, 1, 'Transaccion de producto'),
(2, 2, 60, 40.00, 20.00, 34.00, 40.00, 33.00, 19.00, 20.00, 33.00, 40.00, 40.00, 'Defectuoso', 2, 2, 2, 'Transaccion de producto'),
(3, 3, 70, 33.00, 40.00, 19.00, 33.00, 19.00, 33.00, 19.00, 33.00, 20.00, 19.00, 'Exelente', 3, 3, 3, 'Transaccion de producto'),
(4, 4, 80, 19.00, 60.00, 20.00, 19.00, 40.00, 19.00, 19.00, 40.00, 40.00, 20.00, 'Exelente', 4, 4, 4, 'Transaccion de producto'),
(5, 5, 90, 80.00, 34.00, 40.00, 34.00, 19.00, 20.00, 33.00, 20.00, 19.00, 34.00, 'Defectuoso', 5, 5, 5, 'Transaccion de producto'),
(6, 6, 100, 15.00, 12.00, 19.00, 19.00, 40.00, 20.00, 40.00, 19.00, 19.00, 33.00, 'Exelente', 6, 6, 6, 'Transaccion de producto'),
(7, 7, 110, 84.00, 19.00, 19.00, 40.00, 19.00, 19.00, 34.00, 20.00, 33.00, 40.00, 'Defectuoso', 7, 7, 7, 'Transaccion de producto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `idempleado` int(11) NOT NULL,
  `nombreemp` varchar(60) NOT NULL,
  `telefonoemp` varchar(10) NOT NULL,
  `correoemp` varchar(100) NOT NULL,
  `nacimientoemp` date NOT NULL,
  `duiemp` varchar(20) NOT NULL,
  `estadoempleado` enum('Activo','Inactivo','Ausente con justificación','Ausente sin justificación') NOT NULL,
  `genero` enum('Masculino','Femenino') NOT NULL,
  `cargo` enum('Jefe','Gerente','Vendedor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`idempleado`, `nombreemp`, `telefonoemp`, `correoemp`, `nacimientoemp`, `duiemp`, `estadoempleado`, `genero`, `cargo`) VALUES
(1, 'Annamaria Sheffield', '0971-3740', 'asheffield0@sogou.com', '2003-06-02', '02434523-2', 'Activo', 'Masculino', 'Jefe'),
(2, 'Elianore Boggon', '4518-8750', 'eboggon1@techcrunch.com', '2003-06-08', '12434523-2', 'Activo', 'Masculino', 'Jefe'),
(3, 'Germaine Antonietti', '3341-5203', 'gantonietti2@canalblog.com', '1998-08-07', '22434523-2', 'Activo', 'Masculino', 'Jefe'),
(4, 'Susanna Jahns', '9403-0016', 'sjahns3@facebook.com', '2001-05-02', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
(5, 'Ruperto Lundon', '8564-9955', 'rlundon4@ucsd.edu', '1997-01-02', '42434523-2', 'Activo', 'Masculino', 'Jefe'),
(6, 'Isabella Phillpot', '1971-3740', 'iphillpot5@google.fr', '2000-01-01', '52434523-2', 'Activo', 'Masculino', 'Jefe'),
(7, 'Pauly Budge', '3130-8699', 'pbudge6@is.gd', '2002-04-05', '62434523-2', 'Activo', 'Masculino', 'Jefe'),
(8, 'Neely Bawden', '2971-3740', 'nbawden7@diigo.com', '1998-05-05', '72434523-2', 'Activo', 'Masculino', 'Jefe'),
(9, 'Ignaz Cuvley', '8472-5129', 'icuvley8@china.com.cn', '2000-08-04', '82434523-2', 'Activo', 'Masculino', 'Jefe'),
(10, 'Barri Acheson', '3811-2812', 'bacheson9@google.nl', '2001-09-03', '92434523-2', 'Activo', 'Masculino', 'Jefe'),
(11, 'Zsazsa Hassen', '8312-7176', 'zhassena@zimbio.com', '2003-08-04', '10434523-2', 'Activo', 'Masculino', 'Jefe'),
(12, 'Scarface Bessant', '2055-3964', 'sbessantb@icq.com', '2003-06-02', '11434523-2', 'Activo', 'Masculino', 'Jefe'),
(13, 'Edithe Britt', '3971-3740', 'ebrittc@illinois.edu', '2003-06-12', '13434523-2', 'Activo', 'Masculino', 'Jefe'),
(14, 'Bartholomew Chstney', '8652-4778', 'bchstneyd@adobe.com', '2003-01-06', '14434523-2', 'Activo', 'Masculino', 'Jefe'),
(15, 'Shayla Woodfield', '7079-6484', 'swoodfielde@hatena.ne.jp', '2001-03-03', '15434523-2', 'Activo', 'Masculino', 'Jefe'),
(16, 'Sisile Sleight', '4971-3740', 'ssleightf@businessweek.com', '2003-06-02', '16434523-2', 'Activo', 'Masculino', 'Jefe'),
(17, 'Evelin Fery', '5971-3740', 'eferyg@omniture.com', '1998-06-04', '17434523-2', 'Inactivo', 'Masculino', 'Jefe'),
(18, 'Pietrek Peris', '8905-6928', 'pperish@cornell.edu', '2002-06-06', '99434523-2', 'Inactivo', 'Masculino', 'Jefe'),
(19, 'Mellisa Anstee', '1936-8789', 'mansteei@google.co.jp', '1997-09-11', '00434523-2', 'Inactivo', 'Masculino', 'Jefe'),
(20, 'Nevin Oke', '2536-1122', 'nokej@home.pl', '1999-02-03', '20434523-2', 'Inactivo', 'Masculino', 'Jefe'),
(21, 'Daniel Hernández', '7053-7276', 'daniel123hernandez15@gmail.com', '2010-10-10', '06795006-2', 'Activo', 'Masculino', 'Jefe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encabezadostransacciones`
--

CREATE TABLE `encabezadostransacciones` (
  `idencatransaccion` int(11) NOT NULL,
  `nocomprobante` int(11) NOT NULL,
  `fechatransac` date NOT NULL,
  `lote` int(11) NOT NULL,
  `npoliza` int(11) NOT NULL,
  `idbodega` int(11) NOT NULL,
  `idcajero` int(11) NOT NULL,
  `tipopago` enum('Efectivo','Tarjeta') NOT NULL,
  `idcodigotransaccion` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idvendedor` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `idparametro` int(11) NOT NULL,
  `iddetalletransaccion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `encabezadostransacciones`
--

INSERT INTO `encabezadostransacciones` (`idencatransaccion`, `nocomprobante`, `fechatransac`, `lote`, `npoliza`, `idbodega`, `idcajero`, `tipopago`, `idcodigotransaccion`, `idcliente`, `idvendedor`, `idproveedor`, `idparametro`, `iddetalletransaccion`) VALUES
(1, 1, '2015-01-01', 1213, 1234, 1, 1, 'Efectivo', 1, 1, 1, 1, 1, 1),
(2, 2, '2015-01-01', 1214, 1235, 2, 2, 'Efectivo', 2, 2, 2, 2, 2, 2),
(3, 3, '2015-01-01', 1215, 1236, 3, 3, 'Efectivo', 3, 3, 3, 3, 3, 3),
(4, 4, '2015-01-01', 1216, 1237, 4, 4, 'Efectivo', 1, 4, 4, 4, 4, 4),
(5, 5, '2015-01-01', 1217, 1238, 5, 5, 'Efectivo', 2, 5, 5, 5, 5, 5),
(6, 6, '2015-01-01', 1218, 1239, 6, 6, 'Efectivo', 3, 6, 6, 6, 6, 6),
(7, 7, '2015-01-01', 1219, 1230, 7, 7, 'Efectivo', 1, 7, 7, 7, 7, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familias`
--

CREATE TABLE `familias` (
  `idfamilia` int(11) NOT NULL,
  `familia` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `familias`
--

INSERT INTO `familias` (`idfamilia`, `familia`) VALUES
(1, 'Escape'),
(11, 'Espejos'),
(8, 'Foco Delantero Derecho'),
(9, 'Foco Delantero Izquierdo'),
(6, 'Foco Trasero Derecho'),
(7, 'Foco Trasero Izquierdo'),
(10, 'Manubrio'),
(12, 'Para Choques'),
(2, 'Puerta Derecha'),
(3, 'Puerta Izquierda'),
(4, 'Retrovisor Derecho'),
(5, 'Retrovisor Izquierdo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familiasbodegas`
--

CREATE TABLE `familiasbodegas` (
  `idfamiliabodega` int(11) NOT NULL,
  `idbodega` int(11) NOT NULL,
  `idfamilia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `familiasbodegas`
--

INSERT INTO `familiasbodegas` (`idfamiliabodega`, `idbodega`, `idfamilia`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5),
(6, 6, 6),
(7, 7, 7),
(8, 8, 8),
(9, 9, 9),
(10, 10, 10),
(11, 11, 11),
(12, 12, 12),
(13, 13, 1),
(14, 14, 2),
(15, 15, 3),
(16, 16, 4),
(17, 17, 5),
(18, 18, 6),
(19, 19, 7),
(20, 20, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventariosbodegas`
--

CREATE TABLE `inventariosbodegas` (
  `idinventariobodega` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `idbodega` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventariossucursales`
--

CREATE TABLE `inventariossucursales` (
  `idinventariosucursales` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `idsucursal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `idmarca` int(11) NOT NULL,
  `marca` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`idmarca`, `marca`) VALUES
(7, 'Buick'),
(10, 'Cadillac'),
(12, 'Chevrolet'),
(4, 'Chrysler'),
(16, 'Dodge'),
(5, 'Ford'),
(9, 'GMC'),
(8, 'Isuzu'),
(2, 'Maybach'),
(1, 'Mercury'),
(14, 'Nissan'),
(17, 'Plymouth'),
(3, 'Pontiac'),
(11, 'Porsche'),
(6, 'Suzuki'),
(15, 'Tesla'),
(13, 'Toyota');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `idmodelo` int(11) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `idmarca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modelos`
--

INSERT INTO `modelos` (`idmodelo`, `modelo`, `idmarca`) VALUES
(1, 'modf1', 5),
(2, 'modf2', 5),
(3, 'modf3', 5),
(4, 'modf4', 5),
(5, 'modf5', 5),
(6, 'modf6', 5),
(7, 'modf7', 5),
(8, 'modf8', 5),
(9, 'modf9', 5),
(10, 'modf10', 5),
(11, 'modm1', 2),
(12, 'modm2', 2),
(13, 'modm3', 2),
(14, 'modm4', 2),
(15, 'modm5', 2),
(16, 'modm6', 2),
(17, 'modm7', 2),
(18, 'modm8', 2),
(19, 'modm9', 2),
(20, 'modm10', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE `monedas` (
  `idmoneda` int(11) NOT NULL,
  `moneda` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `monedas`
--

INSERT INTO `monedas` (`idmoneda`, `moneda`) VALUES
(10, 'Bitcoin'),
(1, 'Dolar'),
(2, 'Euro'),
(3, 'Libra'),
(7, 'Libra Esterlina'),
(4, 'Peso Argentino'),
(9, 'Peso Colombiano'),
(8, 'Peso Mexicano'),
(5, 'Yen'),
(6, 'Yuan');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paisesdeorigen`
--

CREATE TABLE `paisesdeorigen` (
  `idpais` int(11) NOT NULL,
  `pais` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `paisesdeorigen`
--

INSERT INTO `paisesdeorigen` (`idpais`, `pais`) VALUES
(5, 'Alemania'),
(14, 'Argentina'),
(13, 'Brasil'),
(19, 'Canada'),
(3, 'china'),
(20, 'Colombia'),
(11, 'Costa Rica'),
(1, 'El Salvador'),
(9, 'España'),
(6, 'Estados Unidos'),
(16, 'Holanda'),
(2, 'Honduras'),
(8, 'Inglaterra'),
(4, 'Japon'),
(18, 'Mexico'),
(12, 'Nicaragua'),
(17, 'Polonia'),
(15, 'Portugal'),
(10, 'Rusia'),
(7, 'Suiza');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros`
--

CREATE TABLE `parametros` (
  `idparametro` int(11) NOT NULL,
  `nombreemp` varchar(50) NOT NULL,
  `direccionemp` varchar(150) NOT NULL,
  `porcentaje` decimal(5,2) DEFAULT NULL,
  `registro` int(11) DEFAULT NULL,
  `giroempresa` varchar(80) NOT NULL,
  `nit` varchar(20) NOT NULL,
  `dui` varchar(20) NOT NULL,
  `idcontacto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `parametros`
--

INSERT INTO `parametros` (`idparametro`, `nombreemp`, `direccionemp`, `porcentaje`, `registro`, `giroempresa`, `nit`, `dui`, `idcontacto`) VALUES
(1, 'Importadora Pineda', 'calle 25 pasaje 1 casa 3', 23.00, 1, 'Proveedor de repuestos', '5632-286468-633-0', '33233166-0', 1),
(2, 'Distribuidora Repuestos S.A de C.V', 'calle 14 pasaje 2 casa 12', 13.00, 2, 'Proveedor de repuestos', '3232-234365-233-0', '33232455-2', 2),
(3, 'Importe Repuestos', 'calle 11 pasaje 5 casa 3', 10.00, 3, 'Proveedor de repuestos', '0122-223465-532-3', '24556556-3', 3),
(4, 'Repuestos Trasacciones', 'calle 40 pasaje 2 casa 6', 50.00, 4, 'Proveedor de repuestos', '2392-271535-233-1', '32324556-6', 4),
(5, 'Import Cars S.A de C.V', 'calle 12 pasaje 2 casa 8', 12.00, 5, 'Proveedor de repuestos', '2256-257165-236-2', '32345566-7', 5),
(6, 'Cars Repuestos', 'calle 23 pasaje 14 casa 7', 60.00, 6, 'Proveedor de repuestos', '5132-261345-245-2', '15564556-8', 6),
(7, 'Importa Repuestos S.A de C.V', 'calle 25 pasaje 1 casa 10', 80.00, 7, 'Proveedor de repuestos', '6378-226715-283-2', '32671556-3', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plazos`
--

CREATE TABLE `plazos` (
  `idplazo` int(11) NOT NULL,
  `descripcion` varchar(30) NOT NULL,
  `vencimiento` date NOT NULL,
  `idcodigoplazo` int(11) NOT NULL,
  `tipoplazo` enum('Contado','Credito') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `plazos`
--

INSERT INTO `plazos` (`idplazo`, `descripcion`, `vencimiento`, `idcodigoplazo`, `tipoplazo`) VALUES
(1, 'plazo para cliente 1', '0000-00-00', 1, 'Contado'),
(2, 'plazo para cliente 2', '0000-00-00', 2, 'Contado'),
(3, 'plazo para cliente 3', '0000-00-00', 3, 'Contado'),
(4, 'plazo para cliente 4', '0000-00-00', 4, 'Contado'),
(5, 'plazo para cliente 5', '0000-00-00', 5, 'Contado'),
(6, 'plazo para cliente 6', '0000-00-00', 6, 'Contado'),
(7, 'plazo para cliente 7', '0000-00-00', 7, 'Contado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL,
  `nombreprod` varchar(70) NOT NULL,
  `imagen` varchar(150) DEFAULT NULL,
  `descripcionprod` varchar(150) NOT NULL,
  `precio` decimal(6,2) NOT NULL,
  `preciodesc` decimal(6,2) NOT NULL,
  `anioinicial` int(11) NOT NULL,
  `aniofinal` int(11) NOT NULL,
  `idcodigocomun` int(11) NOT NULL,
  `idtipoproducto` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `idmodelo` int(11) NOT NULL,
  `idpais` int(11) NOT NULL,
  `estadoproducto` enum('Escaso','Existente','Sin existencias') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idproducto`, `nombreprod`, `imagen`, `descripcionprod`, `precio`, `preciodesc`, `anioinicial`, `aniofinal`, `idcodigocomun`, `idtipoproducto`, `idcategoria`, `idmodelo`, `idpais`, `estadoproducto`) VALUES
(1, 'Foco frontal amarillo Toyota Corolla 2012', NULL, 'Foco frontal amarillo', 20.00, 15.00, 2010, 2017, 1, 1, 3, 1, 1, 'Existente'),
(2, 'Retrovisor derecho Nissan Sentra 2017', NULL, 'Retrovisor derecho blanco', 20.00, 15.00, 2015, 2017, 2, 2, 9, 2, 2, 'Existente'),
(3, 'Capo Toyota Supra MK4', NULL, 'Capo negro Toyota Supra 2002', 120.00, 115.00, 2002, 2020, 3, 5, 7, 3, 3, 'Existente'),
(4, 'Puerta derecha delantera Mitsubishi Montero 2015', NULL, 'Puerta delantera gris', 100.00, 97.99, 2015, 2020, 4, 3, 2, 4, 4, 'Existente'),
(5, 'Bomper trasero Mercedes Benz Clase A 2021', NULL, 'Bomper trasero gris', 60.00, 58.00, 2021, 2022, 5, 4, 7, 5, 5, 'Existente'),
(6, 'Escape Hyundai El Antra 2017', NULL, 'Escape Hyundai EL Antra', 35.50, 33.99, 2017, 2020, 6, 4, 7, 6, 6, 'Existente'),
(7, 'Foco delantero blanco Honda Civic SI 2020', NULL, 'Foco frontal blanco Honda Civic SI', 44.00, 43.00, 2020, 2022, 7, 1, 3, 7, 7, 'Existente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `idproveedor` int(11) NOT NULL,
  `nombreprov` varchar(25) NOT NULL,
  `telefonoprov` varchar(10) NOT NULL,
  `correoprov` varchar(100) NOT NULL,
  `codigoprov` int(11) NOT NULL,
  `codigomaestroprov` int(11) NOT NULL,
  `duiprov` varchar(20) NOT NULL,
  `idmoneda` int(11) NOT NULL,
  `numeroregistroprov` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`idproveedor`, `nombreprov`, `telefonoprov`, `correoprov`, `codigoprov`, `codigomaestroprov`, `duiprov`, `idmoneda`, `numeroregistroprov`) VALUES
(1, 'Mercury', '4365-5632', 'mercury@gmail.com', 123, 1233, '234306234-0', 1, 1),
(2, 'Maybach', '4125-5032', 'maybach@gmail.com', 124, 1244, '00656234-0', 2, 2),
(3, 'Pontiac', '5265-6830', 'pontiac@gmail.com', 125, 1255, '236510004-0', 1, 3),
(4, 'Chrysler', '4065-2132', 'chrysler@gmail.com', 126, 1266, '224356234-0', 3, 4),
(5, 'Ford', '5365-3402', 'ford@gmail.com', 127, 1277, '23435524-9', 4, 5),
(6, 'Suzuki', '4007-3232', 'suzuki@gmail.com', 128, 1288, '234095434-5', 1, 6),
(7, 'Buick', '2364-4002', 'buik@gmail.com', 129, 1299, '43423454-5', 1, 7),
(8, 'Isuzu', '2360-5237', 'isuzu@gmail.com', 131, 1311, '512346434-7', 2, 8),
(9, 'GMC', '5325-5604', 'gmc@gmail.com', 732, 1322, '234340004-8', 2, 9),
(10, 'Cadillac', '0005-3731', 'cadillac@gmail.com', 134, 1344, '00000000-0', 2, 10),
(11, 'Chevrolet', '3300-5638', 'chevrolet@gmail.com', 320, 1233, '123876234-0', 1, 12),
(12, 'Toyota', '7265-9002', 'toyota@gmail.com', 167, 1233, '23300024-4', 1, 13),
(13, 'Porsche', '0194-5924', 'porsche@gmail.com', 98, 1233, '200086234-0', 1, 14),
(14, 'Nissan', '4024-3002', 'nissan@gmail.com', 166, 1233, '12663234-6', 3, 17),
(15, 'Tesla', '1572-7602', 'tesla@gmail.com', 111, 1233, '23465434-6', 2, 18),
(16, 'Dodge', '8366-2539', 'dodge@gmail.com', 221, 1233, '2343124434-7', 1, 19),
(17, 'Plymouth', '7363-8636', 'plymouth@gmail.com', 233, 1233, '234239457-0', 1, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `idsucursal` int(11) NOT NULL,
  `nombresuc` varchar(20) NOT NULL,
  `telefonosuc` varchar(10) NOT NULL,
  `correosuc` varchar(100) NOT NULL,
  `direccionsuc` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`idsucursal`, `nombresuc`, `telefonosuc`, `correosuc`, `direccionsuc`) VALUES
(1, 'Sucursal1', '2343-2363', 'sucursal1@gmail.com', 'sucursal1'),
(2, 'Sucursal2', '2343-2363', 'sucursal2@gmail.com', 'sucursal2'),
(3, 'Sucursal3', '5343-2631', 'sucursal3@gmail.com', 'sucursal3'),
(4, 'Sucursal4', '2537-3351', 'sucursal4@gmail.com', 'sucursal4'),
(5, 'Sucursal5', '3231-2363', 'sucursal5@gmail.com', 'sucursal5'),
(6, 'Sucursal6', '2357-9343', 'sucursal6@gmail.com', 'sucursal6'),
(7, 'Sucursal7', '1346-1373', 'sucursal7@gmail.com', 'sucursal7'),
(8, 'Sucursal8', '1233-2363', 'sucursal8@gmail.com', 'sucursal8'),
(9, 'Sucursal9', '7313-6235', 'sucursal9@gmail.com', 'sucursal9'),
(10, 'Sucursal10', '3435-1636', 'sucursal10@gmail.com', 'sucursal10'),
(11, 'Sucursal11', '6233-3637', 'sucursal11@gmail.com', 'sucursal11'),
(12, 'Sucursal12', '5231-1231', 'sucursal12@gmail.com', 'sucursal12'),
(13, 'Sucursal13', '5347-1643', 'sucursal13@gmail.com', 'sucursal13'),
(14, 'Sucursal14', '5235-1213', 'sucursal14@gmail.com', 'sucursal14'),
(15, 'Sucursal15', '2134-1636', 'sucursal15@gmail.com', 'sucursal15'),
(16, 'Sucursal16', '4231-2318', 'sucursal16@gmail.com', 'sucursal16'),
(17, 'Sucursal17', '2639-1634', 'sucursal17@gmail.com', 'sucursal17'),
(18, 'Sucursal18', '2283-6231', 'sucursal18@gmail.com', 'sucursal18'),
(19, 'Sucursal19', '1431-1363', 'sucursal19@gmail.com', 'sucursal19'),
(20, 'Sucursal20', '2236-1635', 'sucursal20@gmail.com', 'sucursal20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposproductos`
--

CREATE TABLE `tiposproductos` (
  `idtipoproducto` int(11) NOT NULL,
  `tipoproducto` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tiposproductos`
--

INSERT INTO `tiposproductos` (`idtipoproducto`, `tipoproducto`) VALUES
(4, 'Bomper'),
(5, 'Capo'),
(1, 'Faroles'),
(3, 'Puerta'),
(2, 'Retrovisor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposusuarios`
--

CREATE TABLE `tiposusuarios` (
  `idtipousuario` int(11) NOT NULL,
  `nombretipous` varchar(25) NOT NULL,
  `marcas` tinyint(1) DEFAULT NULL,
  `paisesdeorigen` tinyint(1) DEFAULT NULL,
  `monedas` tinyint(1) DEFAULT NULL,
  `familias` tinyint(1) DEFAULT NULL,
  `categorias` tinyint(1) DEFAULT NULL,
  `codigoscomunes` tinyint(1) DEFAULT NULL,
  `tiposproductos` tinyint(1) DEFAULT NULL,
  `codigostransacciones` tinyint(1) DEFAULT NULL,
  `codigosplazos` tinyint(1) DEFAULT NULL,
  `sucursales` tinyint(1) DEFAULT NULL,
  `plazos` tinyint(1) DEFAULT NULL,
  `contactos` tinyint(1) DEFAULT NULL,
  `parametros` tinyint(1) DEFAULT NULL,
  `proveedores` tinyint(1) DEFAULT NULL,
  `modelos` tinyint(1) DEFAULT NULL,
  `empleados` tinyint(1) DEFAULT NULL,
  `clientes` tinyint(1) DEFAULT NULL,
  `usuarios` tinyint(1) DEFAULT NULL,
  `cajas` tinyint(1) DEFAULT NULL,
  `cajeros` tinyint(1) DEFAULT NULL,
  `vendedores` tinyint(1) DEFAULT NULL,
  `bodegas` tinyint(1) DEFAULT NULL,
  `familiasbodegas` tinyint(1) DEFAULT NULL,
  `productos` tinyint(1) DEFAULT NULL,
  `encabezadostransacciones` tinyint(1) DEFAULT NULL,
  `detallestransacciones` tinyint(1) DEFAULT NULL,
  `tiposusuarios` tinyint(1) DEFAULT NULL,
  `bitacoras` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tiposusuarios`
--

INSERT INTO `tiposusuarios` (`idtipousuario`, `nombretipous`, `marcas`, `paisesdeorigen`, `monedas`, `familias`, `categorias`, `codigoscomunes`, `tiposproductos`, `codigostransacciones`, `codigosplazos`, `sucursales`, `plazos`, `contactos`, `parametros`, `proveedores`, `modelos`, `empleados`, `clientes`, `usuarios`, `cajas`, `cajeros`, `vendedores`, `bodegas`, `familiasbodegas`, `productos`, `encabezadostransacciones`, `detallestransacciones`, `tiposusuarios`, `bitacoras`) VALUES
(1, 'Administrador', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 'Gerente', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(3, 'Vendedor', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombreus` varchar(50) NOT NULL,
  `contrasenia` varchar(150) NOT NULL,
  `fechacontra` datetime DEFAULT NULL,
  `pin` varchar(10) NOT NULL,
  `idtipousuario` int(11) NOT NULL,
  `idempleado` int(11) NOT NULL,
  `estadousuario` enum('Activo','Inactivo','Bloqueado') NOT NULL,
  `intentos` int(11) NOT NULL DEFAULT 0,
  `codigoveri` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombreus`, `contrasenia`, `fechacontra`, `pin`, `idtipousuario`, `idempleado`, `estadousuario`, `intentos`, `codigoveri`) VALUES
(1, 'Marchelli', '$2y$10$Lh3Le1sR3Ys301TFgCGgeu5bdaRv27gWxO/4O66BUJQlGjji4n8Mm', NULL, '12345678', 1, 1, 'Activo', 0, 0),
(2, 'Elianore', 'Boggon', NULL, '12345678', 1, 2, 'Activo', 0, 0),
(3, 'Germaine', 'Antonietti', NULL, '12345678', 1, 3, 'Activo', 0, 0),
(4, 'Susanna', 'Jahns', NULL, '12345678', 1, 4, 'Activo', 0, 0),
(5, 'Ruperto', 'Lundon', NULL, '12345678', 1, 5, 'Activo', 0, 0),
(6, 'Isabella', 'Phillpot', NULL, '12345678', 1, 6, 'Activo', 0, 0),
(7, 'Pauly', 'Budge', NULL, '12345678', 1, 7, 'Activo', 0, 0),
(8, 'Neely', 'Bawden', NULL, '12345678', 1, 8, 'Activo', 0, 0),
(9, 'Ignaz', 'Cuvley', NULL, '12345678', 1, 9, 'Activo', 0, 0),
(10, 'Barri', 'Sheffield', NULL, '12345678', 1, 10, 'Activo', 0, 0),
(11, 'Zsazsa', 'Chstney', NULL, '12345678', 1, 11, 'Activo', 0, 0),
(12, 'Scarface', 'Sheffield', NULL, '12345678', 1, 12, 'Activo', 0, 0),
(13, 'Edithe', 'Sleight', NULL, '12345678', 1, 13, 'Activo', 0, 0),
(14, 'Bartholomew', 'Sheffield', NULL, '12345678', 1, 14, 'Activo', 0, 0),
(15, 'Shayla', 'Sheffield', NULL, '12345678', 1, 15, 'Activo', 0, 0),
(16, 'Sisile', 'Sleight', NULL, '12345678', 1, 16, 'Inactivo', 0, 0),
(17, 'Evelin', 'Anstee', NULL, '12345678', 1, 17, 'Activo', 0, 0),
(18, 'Pietrek', 'Sheffield', NULL, '12345678', 2, 18, 'Inactivo', 0, 0),
(19, 'Mellisa', 'Anstee', NULL, '12345678', 2, 19, 'Activo', 0, 0),
(20, 'Kevin', '$2y$10$1wWqmZ36Pts6cYlKBY1FN.kgn/HfUyCjF/JkWIO1M5xipDgFlFKna', NULL, '12345678', 2, 20, 'Activo', 0, 0),
(21, 'dani', '$2y$10$Lh3Le1sR3Ys301TFgCGgeu5bdaRv27gWxO/4O66BUJQlGjji4n8Mm', NULL, '12345678', 1, 21, 'Inactivo', 0, 0);

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `bitacoraUsuario` AFTER UPDATE ON `usuarios` FOR EACH ROW BEGIN
INSERT INTO bitacoras(mensaje, fechabitacora)
VALUES('EL usuario fue modificado', CURRENT_DATE);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedores`
--

CREATE TABLE `vendedores` (
  `idvendedor` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idcaja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vendedores`
--

INSERT INTO `vendedores` (`idvendedor`, `idusuario`, `idcaja`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 3),
(6, 6, 1),
(7, 7, 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  ADD PRIMARY KEY (`idbitacora`);

--
-- Indices de la tabla `bodegas`
--
ALTER TABLE `bodegas`
  ADD PRIMARY KEY (`idbodega`),
  ADD KEY `fksucursalbod` (`idsucursal`);

--
-- Indices de la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`idcaja`),
  ADD UNIQUE KEY `serieequipo` (`serieequipo`),
  ADD KEY `fkcajasucursal` (`idsucursal`),
  ADD KEY `fkcajausuario` (`idusuario`);

--
-- Indices de la tabla `cajeros`
--
ALTER TABLE `cajeros`
  ADD PRIMARY KEY (`idcajero`),
  ADD UNIQUE KEY `nombrecajero` (`nombrecajero`),
  ADD KEY `fkcajeroacaja` (`idcaja`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idcategoria`),
  ADD UNIQUE KEY `categoria` (`categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`),
  ADD KEY `fkclienteplazo` (`idplazo`);

--
-- Indices de la tabla `codigoscomunes`
--
ALTER TABLE `codigoscomunes`
  ADD PRIMARY KEY (`idcodigocomun`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `codigosplazos`
--
ALTER TABLE `codigosplazos`
  ADD PRIMARY KEY (`idcodigoplazo`);

--
-- Indices de la tabla `codigostransacciones`
--
ALTER TABLE `codigostransacciones`
  ADD PRIMARY KEY (`idcodigotransaccion`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`idcontacto`),
  ADD KEY `fksucursalcontac` (`idsucursal`);

--
-- Indices de la tabla `detallestransacciones`
--
ALTER TABLE `detallestransacciones`
  ADD PRIMARY KEY (`iddetalletransaccion`),
  ADD UNIQUE KEY `correlativo` (`correlativo`),
  ADD KEY `fkbodentradadetalletransac` (`idbodegaentrada`),
  ADD KEY `fkbodsalidadetalletransac` (`idbodegasalida`),
  ADD KEY `fkproddetalletransac` (`idproducto`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`idempleado`),
  ADD UNIQUE KEY `telefonoemp` (`telefonoemp`),
  ADD UNIQUE KEY `correoemp` (`correoemp`),
  ADD UNIQUE KEY `duiemp` (`duiemp`);

--
-- Indices de la tabla `encabezadostransacciones`
--
ALTER TABLE `encabezadostransacciones`
  ADD PRIMARY KEY (`idencatransaccion`),
  ADD UNIQUE KEY `nocomprobante` (`nocomprobante`),
  ADD KEY `fkbogtransac` (`idbodega`),
  ADD KEY `fkcajerotrasac` (`idcajero`),
  ADD KEY `fkcodigotransac` (`idcodigotransaccion`),
  ADD KEY `fkvendedortransac` (`idvendedor`),
  ADD KEY `fkprovtransac` (`idproveedor`),
  ADD KEY `fkparametrotransac` (`idparametro`),
  ADD KEY `fkcliencatransaccion` (`idcliente`),
  ADD KEY `fkencadetalletransac` (`iddetalletransaccion`);

--
-- Indices de la tabla `familias`
--
ALTER TABLE `familias`
  ADD PRIMARY KEY (`idfamilia`),
  ADD UNIQUE KEY `familia` (`familia`);

--
-- Indices de la tabla `familiasbodegas`
--
ALTER TABLE `familiasbodegas`
  ADD PRIMARY KEY (`idfamiliabodega`),
  ADD KEY `fkbodegafamilia` (`idfamilia`);

--
-- Indices de la tabla `inventariosbodegas`
--
ALTER TABLE `inventariosbodegas`
  ADD PRIMARY KEY (`idinventariobodega`),
  ADD UNIQUE KEY `idproducto` (`idproducto`),
  ADD KEY `fkinventariobodega` (`idbodega`);

--
-- Indices de la tabla `inventariossucursales`
--
ALTER TABLE `inventariossucursales`
  ADD PRIMARY KEY (`idinventariosucursales`),
  ADD UNIQUE KEY `idproducto` (`idproducto`),
  ADD KEY `fkinventariosucursal` (`idsucursal`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`idmarca`),
  ADD UNIQUE KEY `marca` (`marca`);

--
-- Indices de la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`idmodelo`),
  ADD UNIQUE KEY `modelo` (`modelo`),
  ADD KEY `fkmarcamodel` (`idmarca`);

--
-- Indices de la tabla `monedas`
--
ALTER TABLE `monedas`
  ADD PRIMARY KEY (`idmoneda`),
  ADD UNIQUE KEY `moneda` (`moneda`);

--
-- Indices de la tabla `paisesdeorigen`
--
ALTER TABLE `paisesdeorigen`
  ADD PRIMARY KEY (`idpais`),
  ADD UNIQUE KEY `pais` (`pais`);

--
-- Indices de la tabla `parametros`
--
ALTER TABLE `parametros`
  ADD PRIMARY KEY (`idparametro`),
  ADD UNIQUE KEY `nombreemp` (`nombreemp`),
  ADD KEY `fkcontactoparam` (`idcontacto`);

--
-- Indices de la tabla `plazos`
--
ALTER TABLE `plazos`
  ADD PRIMARY KEY (`idplazo`),
  ADD KEY `fkcodigopla` (`idcodigoplazo`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `fkcodigoprod` (`idcodigocomun`),
  ADD KEY `fkpaisprod` (`idpais`),
  ADD KEY `fkcategoriaprod` (`idcategoria`),
  ADD KEY `fkmodeloprod` (`idmodelo`),
  ADD KEY `fktipoprod` (`idtipoproducto`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idproveedor`),
  ADD UNIQUE KEY `telefonoprov` (`telefonoprov`),
  ADD UNIQUE KEY `correoprov` (`correoprov`),
  ADD UNIQUE KEY `codigoprov` (`codigoprov`),
  ADD UNIQUE KEY `duiprov` (`duiprov`),
  ADD KEY `fkprovmoneda` (`idmoneda`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`idsucursal`),
  ADD UNIQUE KEY `correosuc` (`correosuc`);

--
-- Indices de la tabla `tiposproductos`
--
ALTER TABLE `tiposproductos`
  ADD PRIMARY KEY (`idtipoproducto`),
  ADD UNIQUE KEY `tipoproducto` (`tipoproducto`);

--
-- Indices de la tabla `tiposusuarios`
--
ALTER TABLE `tiposusuarios`
  ADD PRIMARY KEY (`idtipousuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `nombreus` (`nombreus`),
  ADD KEY `fkusuarioemp` (`idempleado`),
  ADD KEY `fktipousuario` (`idtipousuario`);

--
-- Indices de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`idvendedor`),
  ADD UNIQUE KEY `idusuario` (`idusuario`),
  ADD KEY `fkvendedorcaja` (`idcaja`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacoras`
--
ALTER TABLE `bitacoras`
  MODIFY `idbitacora` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bodegas`
--
ALTER TABLE `bodegas`
  MODIFY `idbodega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `idcaja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cajeros`
--
ALTER TABLE `cajeros`
  MODIFY `idcajero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `codigoscomunes`
--
ALTER TABLE `codigoscomunes`
  MODIFY `idcodigocomun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `codigosplazos`
--
ALTER TABLE `codigosplazos`
  MODIFY `idcodigoplazo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `codigostransacciones`
--
ALTER TABLE `codigostransacciones`
  MODIFY `idcodigotransaccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `idcontacto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `detallestransacciones`
--
ALTER TABLE `detallestransacciones`
  MODIFY `iddetalletransaccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `idempleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `encabezadostransacciones`
--
ALTER TABLE `encabezadostransacciones`
  MODIFY `idencatransaccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `familias`
--
ALTER TABLE `familias`
  MODIFY `idfamilia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `familiasbodegas`
--
ALTER TABLE `familiasbodegas`
  MODIFY `idfamiliabodega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `inventariosbodegas`
--
ALTER TABLE `inventariosbodegas`
  MODIFY `idinventariobodega` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventariossucursales`
--
ALTER TABLE `inventariossucursales`
  MODIFY `idinventariosucursales` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `idmarca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `modelos`
--
ALTER TABLE `modelos`
  MODIFY `idmodelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `monedas`
--
ALTER TABLE `monedas`
  MODIFY `idmoneda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `paisesdeorigen`
--
ALTER TABLE `paisesdeorigen`
  MODIFY `idpais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `parametros`
--
ALTER TABLE `parametros`
  MODIFY `idparametro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `plazos`
--
ALTER TABLE `plazos`
  MODIFY `idplazo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `idsucursal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tiposproductos`
--
ALTER TABLE `tiposproductos`
  MODIFY `idtipoproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tiposusuarios`
--
ALTER TABLE `tiposusuarios`
  MODIFY `idtipousuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  MODIFY `idvendedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bodegas`
--
ALTER TABLE `bodegas`
  ADD CONSTRAINT `fksucursalbod` FOREIGN KEY (`idsucursal`) REFERENCES `sucursales` (`idsucursal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD CONSTRAINT `fkcajasucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursales` (`idsucursal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcajausuario` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cajeros`
--
ALTER TABLE `cajeros`
  ADD CONSTRAINT `fkcajeroacaja` FOREIGN KEY (`idcaja`) REFERENCES `cajas` (`idcaja`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fkclienteplazo` FOREIGN KEY (`idplazo`) REFERENCES `plazos` (`idplazo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD CONSTRAINT `fksucursalcontac` FOREIGN KEY (`idsucursal`) REFERENCES `sucursales` (`idsucursal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detallestransacciones`
--
ALTER TABLE `detallestransacciones`
  ADD CONSTRAINT `fkbodentradadetalletransac` FOREIGN KEY (`idbodegaentrada`) REFERENCES `bodegas` (`idbodega`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkbodsalidadetalletransac` FOREIGN KEY (`idbodegasalida`) REFERENCES `bodegas` (`idbodega`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkproddetalletransac` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `encabezadostransacciones`
--
ALTER TABLE `encabezadostransacciones`
  ADD CONSTRAINT `fkbogtransac` FOREIGN KEY (`idbodega`) REFERENCES `bodegas` (`idbodega`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcajerotrasac` FOREIGN KEY (`idcajero`) REFERENCES `cajeros` (`idcajero`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcliencatransaccion` FOREIGN KEY (`idcliente`) REFERENCES `clientes` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcodigotransac` FOREIGN KEY (`idcodigotransaccion`) REFERENCES `codigostransacciones` (`idcodigotransaccion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkencadetalletransac` FOREIGN KEY (`iddetalletransaccion`) REFERENCES `detallestransacciones` (`iddetalletransaccion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkparametrotransac` FOREIGN KEY (`idparametro`) REFERENCES `parametros` (`idparametro`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkprovtransac` FOREIGN KEY (`idproveedor`) REFERENCES `proveedores` (`idproveedor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkvendedortransac` FOREIGN KEY (`idvendedor`) REFERENCES `vendedores` (`idvendedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `familiasbodegas`
--
ALTER TABLE `familiasbodegas`
  ADD CONSTRAINT `fkbodegafamilia` FOREIGN KEY (`idfamilia`) REFERENCES `bodegas` (`idbodega`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkfamiliabodega` FOREIGN KEY (`idfamilia`) REFERENCES `familias` (`idfamilia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventariosbodegas`
--
ALTER TABLE `inventariosbodegas`
  ADD CONSTRAINT `fkinventariobodega` FOREIGN KEY (`idbodega`) REFERENCES `bodegas` (`idbodega`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventariossucursales`
--
ALTER TABLE `inventariossucursales`
  ADD CONSTRAINT `fkinventariosucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursales` (`idsucursal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD CONSTRAINT `fkmarcamodel` FOREIGN KEY (`idmarca`) REFERENCES `marcas` (`idmarca`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `parametros`
--
ALTER TABLE `parametros`
  ADD CONSTRAINT `fkcontactoparam` FOREIGN KEY (`idcontacto`) REFERENCES `contactos` (`idcontacto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `plazos`
--
ALTER TABLE `plazos`
  ADD CONSTRAINT `fkcodigopla` FOREIGN KEY (`idcodigoplazo`) REFERENCES `codigosplazos` (`idcodigoplazo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fkcategoriaprod` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`idcategoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcodigoprod` FOREIGN KEY (`idcodigocomun`) REFERENCES `codigoscomunes` (`idcodigocomun`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkmodeloprod` FOREIGN KEY (`idmodelo`) REFERENCES `modelos` (`idmodelo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkpaisprod` FOREIGN KEY (`idpais`) REFERENCES `paisesdeorigen` (`idpais`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fktipoprod` FOREIGN KEY (`idtipoproducto`) REFERENCES `tiposproductos` (`idtipoproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `fkprovmoneda` FOREIGN KEY (`idmoneda`) REFERENCES `monedas` (`idmoneda`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fktipousuario` FOREIGN KEY (`idtipousuario`) REFERENCES `tiposusuarios` (`idtipousuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkusuarioemp` FOREIGN KEY (`idempleado`) REFERENCES `empleados` (`idempleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `vendedores`
--
ALTER TABLE `vendedores`
  ADD CONSTRAINT `fkusuariovendedor` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkvendedorcaja` FOREIGN KEY (`idcaja`) REFERENCES `cajas` (`idcaja`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
