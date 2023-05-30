-- Database: importcars

-- DROP DATABASE IF EXISTS importcars;

/*CREATE DATABASE importcars
    WITH
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Spanish_Spain.1252'
    LC_CTYPE = 'Spanish_Spain.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1
    IS_TEMPLATE = False;*/
	
	CREATE TYPE estadosFacturas AS ENUM(
		'En revisión' , 'Devolución' , 'Finalizada' , 'Pendiente a finalizar'
	);
	
	CREATE TYPE tiposUsuarios AS ENUM(
		'Administrador' , 'Gerente' , 'Vendedor'
	);

	CREATE TYPE estadosUsuarios AS ENUM(
		'Activo' , 'Inactivo' , 'Bloqueado'
	);
	
	CREATE TYPE tiposDocumentos AS ENUM(
		'DUI' , 'Pasaporte' , 'NIT'
	);
	
	CREATE TYPE estadosEmpleados AS ENUM(
		'Activo', 'Inactivo' , 'Ausente con justificación' , 'Ausente sin justificación'
	);
	
	CREATE TYPE estadosProductos AS ENUM(
		'Escaso', 'Existente' , 'Sin existencias'
	);

	CREATE TYPE generos AS ENUM(
		'Masculino', 'Femenino' , 'Pendejo sin cerebro'
	);
	
	CREATE TYPE cargos AS ENUM(
		'Jefe', 'Gerente' , 'Vendedor'
	);
	
	create table paisesDeOrigen(
		
		idPais serial primary key not null,
		pais varchar(30) not null
		
	);

	create table marcas(
		
		idMarca serial primary key not null,
		marca varchar(25) not null
		
	);
	
	create table familias(
		
		idFamilia serial primary key not null,
		familia varchar(30) not null
		
	);
	
	create table categorias(
		
		idCategoria serial primary key not null,
		categoria varchar(50) not null
		
	);
	
	create table proveedores(
		
		idProveedor serial primary key not null,
		nombre varchar(25) not null,
		telefono varchar(10) not null,
		correo varchar(100) not null,
		fechaCompra date,
		saldoInicial numeric(5,2),
		saldoActual numeric(5,2),
		codigoProv int,
		codigoMaestroProv int,
		dui varchar(20),
		moneda varchar(20),
		numeroRegistroProv int
	
	);
	
	create table modelos(
		
		idModelo serial primary key not null,
		modelo varchar(50) not null,
		idMarca int not null,
		
		constraint fkmarcamod
		foreign key (idmarca)
		references marcas(idmarca)
		
	);
	
	create table sucursales(
		
		idSucursal serial primary key not null,
		nombre varchar(20) not null,
		telefono varchar(10) not null,
		correo varchar(100) not null,
		direccion varchar(150) not null
		
	);
	
	create table bodegas(
		
		idBodega serial primary key not null,
		numeroBodega int not null,
		direccion varchar(150),
		idSucursal int not null,
		
		constraint fkSucursalBod
		foreign key (idSucursal)
		references sucursales(idSucursal)
		
	);
	
	create table familiasBodegas(
	
		idFamiliaBodega serial primary key not null,
		idBodega int not null,
		idFamilia int not null,
		
		constraint fkFamiliaBodegaBod
		foreign key (idBodega)
		references bodegas(idBodega),
		
		constraint fkFamiliaBodegaFam
		foreign key (idFamilia)
		references familias(idFamilia)
		
	);
	
	
	create table empleados(
		
		idEmpleado serial primary key not null,
		nombre varchar(60) not null,
		telefono varchar(10) not null,
		correo varchar(100) not null,
		nacimiento date not null,
		tipoDocumento tiposDocumentos,
		documento varchar(20) not null,
		estadoEmpleado estadosEmpleados,
		genero generos,
		cargo cargos
	);
	
	create table usuarios(
		
		idUsuario serial primary key not null,
		nombre varchar(50) not null,
		contrasenia varchar(150) not null,
		pin varchar(10) not null,
		tipoUsuario tiposUsuarios,
		idEmpleado int not null,
		estadoUsuario estadosUsuarios,

		constraint fkEmpleadoUs
		foreign key (idEmpleado)
		references empleados(idEmpleado)
	);
	
	create table productos(
		
		idProducto serial primary key not null,
		nombre varchar(50) not null,
		codigoComun int not null,
		imagen varchar(150),
		descripcion varchar(150) not null,
		precio numeric(5,2) not null,
		anio int,
		idProveedor int not null,
		idCategoria int not null,
		idModelo int not null,
		idPais int not null,
		estadoProducto estadosProductos,
		
		constraint fkProveedorProd
		foreign key (idProveedor)
		references proveedores(idProveedor),
		
		constraint fkCategoriaProd
		foreign key (idCategoria)
		references categorias(idCategoria),
		
		constraint fkModeloProd
		foreign key (idModelo)
		references modelos(idModelo),
		
		constraint fkPaisprod
		foreign key (idPais)
		references paisesDeOrigen(idPais)
	);
	
	create table comisionesVentas(
		
		idComisionVenta serial primary key not null,
		comision numeric(5,2) not null,
		idProducto int not null,
		
		constraint fkProductoCom
		foreign key (idProducto)
		references productos(idProducto)
		
	);
	
	create table entradas(
		
		idEntrada serial primary key not null,
		descripcion varchar(30) not null,
		idProducto int not null,
		cantidad int not null,
		precio numeric(5,2) not null,
		fechaEntrada date not null,
		idEmpleado int not null,
		
		constraint fkProductoEnt
		foreign key (idProducto)
		references productos(idProducto),
		
		constraint fkEmpleadoEnt
		foreign key (idEmpleado)
		references empleados(idEmpleado)
		
	);
	
	create table lotes(
		
		idLote serial primary key not null,
		idProducto int not null,
		existencia int not null,
		idSucursal int not null,
		
		constraint fkProducoLot
		foreign key (idProducto)
		references productos(idProducto),
		
		constraint fkSucursalLote
		foreign key (idSucursal)
		references sucursales(idSucursal)
		
	);
	
	create table facturas(
		
		idFactura serial primary key not null,
		serieFactura int not null,
		fecha date not null,
		estadoFactura estadosFacturas,
		idComisionVenta int not null,
		idEmpleado int not null,
		
		constraint fkComisionFact
		foreign key (idComisionVenta)
		references comisionesVentas(idComisionVenta),
		
		constraint fkEmpleadoFact
		foreign key (idEmpleado)
		references empleados(idEmpleado)
		
	);
	
	create table detallesFacturas(
		
		idDetalleFactura serial primary key not null,
		idLote int not null,
		cantidad int not null,
		descuento int not null,
		idFactura int not null,
		
		constraint fkLoteDetFact
		foreign key (idLote)
		references lotes(idLote),
		
		constraint fkFacturaDetFact
		foreign key (idFactura)
		references facturas(idFactura)
		
	);

	insert into paisesDeOrigen(pais) values
	('El Salvador'),
	('Honduras'),
	('china'),
	('Japon'),
	('Alemania'),
	('Estados Unidos'),
	('Suiza'),
	('Inglaterra'),
	('Espana'),
	('Rusia'),
	('Costa Rica'),
	('Nicaragua'),
	('Brasil'),
	('Argentina'),
	('Portugal'),
	('Holanda'),
	('Polonia'),
	('Mexico'),
	('Canada'),
	('Colombia');
	
	insert into marcas(marca) values
	('Mercury'),
	('Maybach'),
	('Pontiac'),
	('Chrysler'),
	('Ford'),
	('Suzuki'),
	('Buick'),
	('Isuzu'),
	('GMC'),
	('Cadillac'),
	('Porsche'),
	('Chevrolet'),
	('Toyota'),
	('Porsche'),
	('Isuzu'),
	('Dodge'),
	('Nissan'),
	('Tesla'),
	('Dodge'),
	('Plymouth');
	
	insert into familias(familia) values
	('Escape'),
	('Puerta Derecha'),
	('Puerta Izquierda'),
	('Retrovisor Derecho'),
	('Retrovisor Izquierdo'),
	('Foco Trasero Derecho'),
	('Foco Trasero Izquierdo'),
	('Foco Delantero Derecho'),
	('Foco Delantero Izquierdo'),
	('Manubrio'),
	('Espejos'),
	('para Choques');
	
	insert into categorias(categoria) values
	('Escapes'),
	('Puertas'),
	('Focos'),
	('Lamparas'),
	('Manubrios'),
	('Chapa'),
	('Para Choques'),
	('Espejos'),
	('Retrovisores');
	
	insert into proveedores(nombre, telefono, correo, fechaCompra, saldoInicial, saldoActual, codigoProv, codigoMaestroProv, dui, moneda, numeroRegistroProv) values
	('Mercury', '4365-5632', 'mercury@gmail.com', '4/11/2020', 500.00, 250.00, 123, 1233, '234356234-0', 'Dolar', 1),
	('Maybach', '4125-5632', 'maybach@gmail.com', '11/06/2020', 500.00, 250.00, 124, 1244, '23656234-0', 'Dolar', 2),
	('Pontiac', '5265-6832', 'pontiac@gmail.com', '4/11/2021', 500.00, 250.00, 125, 1255, '236516234-0', 'Dolar', 3),
	('Chrysler', '4365-2132', 'chrysler@gmail.com', '4/01/2022', 500.00, 250.00, 126, 1266, '224356234-0', 'Dolar', 4),
	('Ford', '5365-3432', 'ford@gmail.com', '12/03/2014', 500.00, 250.00, 127, 1277, '23435524-1', 'Dolar', 5),
	('Suzuki', '4667-3232', 'suzuki@gmail.com', '10/08/2016', 500.00, 250.00, 128, 1288, '234352334-5', 'Dolar', 6),
	('Buick', '2364-4662', 'buik@gmail.com', '4/11/2020', 500.00, 250.00, 129, 1299, '43435624-5', 'Dolar', 7),
	('Isuzu', '2363-5237', 'isuzu@gmail.com', '5/03/2020', 500.00, 250.00, 131, 1311, '536256434-7', 'Dolar', 8),
	('GMC', '5325-5674', 'gmc@gmail.com', '7/2/2020', 500.00, 250.00, 132, 1322, '234346234-8', 'Dolar', 9),
	('Cadillac', '8265-3731', 'cadillac@gmail.com', '9/5/2021', 500.00, 250.00, 134, 1344, '22656234-0', 'Dolar', 10),
	('Porsche', '7228-5581', 'porsche@gmail.com', '9/8/2021', 500.00, 250.00, 123, 1233, '21356234-5', 'Dolar', 11),
	('Chevrolet', '3371-5638', 'chevrolet@gmail.com', '10/5/2021', 500.00, 250.00, 123, 1233, '232376234-0', 'Dolar', 12),
	('Toyota', '7265-9682', 'toyota@gmail.com', '4/11/2022', 500.00, 250.00, 123, 1233, '23356624-4', 'Dolar', 13),
	('Porsche', '0194-5924', 'porsche@gmail.com', '7/5/2022', 500.00, 250.00, 123, 1233, '245356234-0', 'Dolar', 14),
	('Isuzu', '1296-0492', 'isuzu@gmail.com', '8/5/2022', 500.00, 250.00, 123, 1233, '23435234-5', 'Dolar', 15),
	('Dodge', '1964-5127', 'dodge@gmail.com', '10/2/2020', 500.00, 250.00, 123, 1233, '23435634-0', 'Dolar', 16),
	('Nissan', '4024-3712', 'nissan@gmail.com', '12/5/2020', 500.00, 250.00, 123, 1233, '23463234-6', 'Dolar', 17),
	('Tesla', '1572-7633', 'tesla@gmail.com', '4/11/2018', 500.00, 250.00, 123, 1233, '23432334-6', 'Dolar', 18),
	('Dodge', '8366-2539', 'dodge@gmail.com', '4/11/2018', 500.00, 250.00, 123, 1233, '2343124434-6', 'Dolar', 19),
	('Plymouth', '7363-8636', 'plymouth@gmail.com', '4/11/2018', 500.00, 250.00, 123, 1233, '234238234-0', 'Dolar', 20);
	
	insert into modelos(modelo, idMarca) values
	('modf1', 5),
	('modf2', 5),
	('modf3', 5),
	('modf4', 5),
	('modf5', 5),
	('modf6', 5),
	('modf7', 5),
	('modf8', 5),
	('modf9', 5),
	('modf10', 5),
	('modm1', 2),
	('modm2', 2),
	('modm3', 2),
	('modm4', 2),
	('modm5', 2),
	('modm6', 2),
	('modm7', 2),
	('modm8', 2),
	('modm9', 2),
	('modm10', 2);
	
	insert into sucursales(nombre, telefono, correo, direccion) values
	('Sucursal1', '2343-2363', 'sucursal1@gmail.com', 'sucursal1'),
	('Sucursal2', '2343-2363', 'sucursal2@gmail.com', 'sucursal2'),
	('Sucursal3', '5343-2631', 'sucursal3@gmail.com', 'sucursal3'),
	('Sucursal4', '2537-3351', 'sucursal4@gmail.com', 'sucursal4'),
	('Sucursal5', '3231-2363', 'sucursal5@gmail.com', 'sucursal5'),
	('Sucursal6', '2357-9343', 'sucursal6@gmail.com', 'sucursal6'),
	('Sucursal7', '1346-1373', 'sucursal7@gmail.com', 'sucursal7'),
	('Sucursal8', '1233-2363', 'sucursal8@gmail.com', 'sucursal8'),
	('Sucursal9', '7313-6235', 'sucursal9@gmail.com', 'sucursal9'),
	('Sucursal10', '3435-1636', 'sucursal10@gmail.com', 'sucursal10'),
	('Sucursal11', '6233-3637', 'sucursal11@gmail.com', 'sucursal11'),
	('Sucursal12', '5231-1231', 'sucursal12@gmail.com', 'sucursal12'),
	('Sucursal13', '5347-1643', 'sucursal13@gmail.com', 'sucursal13'),
	('Sucursal14', '5235-1213', 'sucursal14@gmail.com', 'sucursal14'),
	('Sucursal15', '2134-1636', 'sucursal15@gmail.com', 'sucursal15'),
	('Sucursal16', '4231-2318', 'sucursal16@gmail.com', 'sucursal16'),
	('Sucursal17', '2639-1634', 'sucursal17@gmail.com', 'sucursal17'),
	('Sucursal18', '2283-6231', 'sucursal18@gmail.com', 'sucursal18'),
	('Sucursal19', '1431-1363', 'sucursal19@gmail.com', 'sucursal19'),
	('Sucursal20', '2236-1635', 'sucursal20@gmail.com', 'sucursal20');
	
	insert into bodegas(numeroBodega, direccion, idSucursal) values
	(1, 'bodega1', 1),
	(2, 'bodega2', 2),
	(3, 'bodega3', 3),
	(4, 'bodega4', 4),
	(5, 'bodega5', 5),
	(6, 'bodega6', 6),
	(7, 'bodega7', 7),
	(8, 'bodega8', 8),
	(9, 'bodega9', 9),
	(10, 'bodega10', 10),
	(11, 'bodega11', 11),
	(12, 'bodega12', 12),
	(13, 'bodega13', 13),
	(14, 'bodega14', 14),
	(15, 'bodega15', 15),
	(16, 'bodega16', 16),
	(17, 'bodega17', 17),
	(18, 'bodega18', 18),
	(19, 'bodega19', 19),
	(20, 'bodega20', 20);
	
	insert into familiasBodegas(idBodega, idFamilia) values
	(1, 1),
	(2, 2),
	(3, 3),
	(4, 4),
	(5, 5),
	(6, 6),
	(7, 7),
	(8, 8),
	(9, 9),
	(10, 10),
	(11, 11),
	(12, 12),
	(13, 1),
	(14, 2),
	(15, 3),
	(16, 4),
	(17, 5),
	(18, 6),
	(19, 7),
	(20, 8);
	
	insert into empleados(nombre, telefono, correo, nacimiento, tipoDocumento, documento, estadoEmpleado) values
	('Annamaria Sheffield', '1971-3740', 'asheffield0@sogou.com', '6/2/2003', 'DUI', '32434523-2', 'Activo'),
	('Elianore Boggon', '4518-8750', 'eboggon1@techcrunch.com', '6/8/2003', 'DUI', '32434523-2', 'Activo'),
	('Germaine Antonietti', '3341-5203', 'gantonietti2@canalblog.com', '8/7/1998', 'DUI', '32434523-2', 'Activo'),
	('Susanna Jahns', '9403-0016', 'sjahns3@facebook.com', '5/2/2001', 'DUI', '32434523-2', 'Activo'),
	('Ruperto Lundon', '8564-9955', 'rlundon4@ucsd.edu', '1/2/1997', 'DUI', '32434523-2', 'Activo'),
	('Isabella Phillpot', '1971-3740', 'iphillpot5@google.fr', '1/7/2000', 'DUI', '32434523-2', 'Activo'),
	('Pauly Budge', '3130-8699', 'pbudge6@is.gd', '4/5/2002', 'DUI', '32434523-2', 'Activo'),
	('Neely Bawden', '1971-3740', 'nbawden7@diigo.com', '5/5/1998', 'Pasaporte', '32434523-2', 'Activo'),
	('Ignaz Cuvley', '8472-5129', 'icuvley8@china.com.cn', '8/4/2000', 'Pasaporte', '32434523-2', 'Activo'),
	('Barri Acheson', '3811-2812', 'bacheson9@google.nl', '9/3/2001', 'Pasaporte', '32434523-2', 'Activo'),
	('Zsazsa Hassen', '8312-7176', 'zhassena@zimbio.com', '8/4/2003', 'Pasaporte', '32434523-2', 'Activo'),
	('Scarface Bessant', '2055-3964', 'sbessantb@icq.com', '6/2/2003', 'Pasaporte', '32434523-2', 'Activo'),
	('Edithe Britt', '1971-3740', 'ebrittc@illinois.edu', '6/12/2003', 'Pasaporte', '32434523-2', 'Activo'),
	('Bartholomew Chstney', '8652-4778', 'bchstneyd@adobe.com', '1/6/2003', 'Pasaporte', '32434523-2', 'Activo'),
	('Shayla Woodfield', '7079-6484', 'swoodfielde@hatena.ne.jp', '3/3/2001', 'Pasaporte', '32434523-2', 'Activo'),
	('Sisile Sleight', '1971-3740', 'ssleightf@businessweek.com', '6/2/2003', 'NIT', '32434523-2', 'Activo'),
	('Evelin Fery', '1971-3740', 'eferyg@omniture.com', '6/4/1998','NIT', '32434523-2', 'Inactivo'),
	('Pietrek Peris', '8905-6928', 'pperish@cornell.edu', '6/6/2002', 'NIT', '32434523-2', 'Inactivo'),
	('Mellisa Anstee', '1936-8789', 'mansteei@google.co.jp', '9/11/1997', 'NIT', '32434523-2', 'Inactivo'),
	('Nevin Oke', '2536-1122', 'nokej@home.pl', '2/3/1999', 'NIT', '32434523-2', 'Inactivo');
	
	insert into usuarios(nombre, contrasenia, pin, tipoUsuario, idEmpleado, estadoUsuario) values
	('Annamaria', 'Sheffield', '12345678', 'Administrador', 1, 'Activo'),
	('Elianore', 'Boggon', '12345678', 'Administrador', 2, 'Activo'),
	('Germaine', 'Antonietti', '12345678', 'Administrador', 3, 'Activo'),
	('Susanna', 'Jahns', '12345678', 'Administrador', 4, 'Activo'),
	('Ruperto', 'Lundon', '12345678', 'Administrador', 5, 'Activo'),
	('Isabella', 'Phillpot', '12345678', 'Administrador', 6, 'Activo'),
	('Pauly', 'Budge', '12345678', 'Administrador', 7, 'Activo'),
	('Neely', 'Bawden', '12345678', 'Administrador', 8, 'Activo'),
	('Ignaz', 'Cuvley', '12345678', 'Administrador', 9, 'Activo'),
	('Barri', 'Sheffield', '12345678', 'Administrador', 10, 'Activo'),
	('Zsazsa', 'Chstney', '12345678', 'Administrador', 11, 'Activo'),
	('Scarface', 'Sheffield', '12345678', 'Administrador', 12, 'Activo'),
	('Edithe', 'Sleight', '12345678', 'Administrador', 13, 'Activo'),
	('Bartholomew', 'Sheffield', '12345678', 'Administrador', 14, 'Activo'),
	('Shayla', 'Sheffield', '12345678', 'Administrador', 15, 'Activo'),
	('Sisile', 'Sleight', '12345678', 'Administrador', 16, 'Inactivo'),
	('Evelin', 'Anstee', '12345678', 'Administrador', 17, 'Activo'),
	('Pietrek', 'Sheffield', '12345678', 'Gerente', 18, 'Inactivo'),
	('Mellisa', 'Anstee', '12345678', 'Gerente', 19, 'Activo'),
	('Nevin', 'Sheffield', '12345678', 'Gerente', 20, 'Activo');
	
	insert into productos(nombre, codigoComun, descripcion, precio, anio, idProveedor, idCategoria, idModelo, idPais, estadoProducto) values
	('escape ford', 00001, 'escape', 90.00, 2000 , 5, 1, 1, 1, 'Existente'),
	('escape ford', 00001,'escape', 90.00, 2000 , 5, 1, 1, 1, 'Existente'),
	('escape ford', 00001,'escape', 90.00, 2000 , 5, 1, 1, 1, 'Existente'),
	('escape ford', 00001,'escape', 90.00, 2000 , 5, 1, 1, 1, 'Existente'),
	('escape ford', 00001,'escape', 90.00, 2000 , 5, 1, 1, 1, 'Existente'),
	('escape ford', 00001,'escape', 90.00, 2000 , 5, 1, 1, 1, 'Existente'),
	('escape ford', 00001,'escape', 90.00, 2000 , 5, 1, 1, 1, 'Existente'),
	('escape ford', 00001,'escape', 90.00, 2000 , 5, 1, 1, 1, 'Existente'),
	('escape ford', 00001,'escape', 90.00, 2000 , 5, 1, 1, 1, 'Existente'),
	('escape ford', 00001,'escape', 90.00, 2000 , 5, 1, 1, 1, 'Existente'),
	('foco Maybach', 00001,'foco', 80.00, 2018 , 2, 3, 11, 4, 'Existente'),
	('foco Maybach', 00001,'foco', 80.00, 2018 , 2, 3, 11, 4, 'Existente'),
	('foco Maybach', 00001,'foco', 80.00, 2018 , 2, 3, 11, 4, 'Existente'),
	('foco Maybach', 00001,'foco', 80.00, 2018 , 2, 3, 11, 4, 'Existente'),
	('foco Maybach', 00001,'foco', 80.00, 2018 , 2, 3, 11, 4, 'Existente'),
	('foco Maybach', 00001,'foco', 80.00, 2018 , 2, 3, 11, 4, 'Existente'),
	('foco Maybach', 00001,'foco', 80.00, 2018 , 2, 3, 11, 4, 'Existente'),
	('foco Maybach', 00001,'foco', 80.00, 2018 , 2, 3, 11, 4, 'Existente'),
	('foco Maybach', 00001,'foco', 80.00, 2018 , 2, 3, 11, 4, 'Existente'),
	('foco Maybach', 00001,'foco', 80.00, 2018 , 2, 3, 11, 4, 'Existente');
	
	insert into comisionesVentas(comision, idProducto) values
	(90.00, 1),
	(90.00, 2),
	(90.00, 3),
	(90.00, 4),
	(90.00, 5),
	(90.00, 6),
	(90.00, 7),
	(90.00, 8),
	(90.00, 9),
	(90.00, 10),
	(90.00, 11),
	(90.00, 12),
	(90.00, 13),
	(90.00, 14),
	(90.00, 15),
	(90.00, 16),
	(90.00, 17),
	(90.00, 18),
	(90.00, 19),
	(90.00, 20);
	
	 
	insert into entradas(descripcion, idProducto, cantidad, precio, fechaEntrada, idEmpleado) values
	 ('entrada de focos', 2, 200, 900.00, '12/2/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/2/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/5/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/6/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/6/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/6/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/10/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/10/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/10/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/10/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/10/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/11/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/11/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/11/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/12/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/12/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/12/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/12/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/12/2022', 1),
	 ('entrada de focos', 2, 200, 900.00, '12/12/2022', 1);
	 

	insert into lotes(idProducto, existencia, idSucursal) values
	 (1, 200, 1),
	 (2, 200, 1),
	 (3, 200, 1),
	 (4, 200, 5),
	 (5, 200, 5),
	 (6, 200, 4),
	 (7, 200, 2),
	 (8, 200, 7),
	 (9, 200, 8),
	 (10, 200, 2),
	 (11, 200, 3),
	 (12, 200, 3),
	 (13, 200, 3),
	 (14, 200, 4),
	 (15, 200, 4),
	 (16, 200, 12),
	 (17, 200, 5),
	 (18, 200, 5),
	 (19, 200, 2),
	 (20, 200, 2);
	 
	 insert into facturas(serieFactura, fecha, estadoFactura, idComisionVenta, idEmpleado) values
	 (1, '12/2/2022', 'Finalizada', 1, 1),
	 (2, '12/2/2022', 'Finalizada', 2, 2),
	 (3, '12/2/2022', 'Finalizada', 3, 3),
	 (4, '11/2/2022', 'Finalizada', 4, 4),
	 (5, '09/5/2022', 'Finalizada', 5, 5),
	 (6, '09/5/2022', 'Finalizada', 6, 6),
	 (7, '09/5/2022', 'Finalizada', 7, 7),
	 (8, '04/5/2022', 'Finalizada', 8, 8),
	 (9, '04/5/2022', 'Finalizada', 9, 9),
	 (10, '04/10/2022', 'Finalizada', 10, 10),
	 (11, '04/10/2022', 'Finalizada', 11, 11),
	 (12, '04/09/2022', 'Finalizada', 12, 12),
	 (13, '04/06/2022', 'Finalizada', 13, 13),
	 (14, '04/05/2022', 'Finalizada', 14, 14),
	 (15, '03/05/2022', 'Finalizada', 15, 15),
	 (16, '03/05/2022', 'Finalizada', 16, 16),
	 (17, '03/04/2022', 'Finalizada', 17, 17),
	 (18, '03/04/2022', 'Finalizada', 18, 18),
	 (19, '03/04/2022', 'Finalizada', 19, 19),
	 (20, '03/04/2022', 'En revisión', 20, 20);
	 
	 insert into detallesFacturas(idLote, cantidad, descuento, idFactura) values
	 (1, 20, 5, 1),
	 (2, 15, 10, 2),
	 (3, 12, 4, 3),
	 (4, 3, 12, 4),
	 (5, 2, 14, 5),
	 (6, 4, 0, 6),
	 (7, 5, 0, 7),
	 (8, 23, 14, 8),
	 (9, 6, 15, 9),
	 (10, 2, 15, 9),
	 (11, 2, 15, 10),
	 (12, 3, 20, 10),
	 (13, 4, 15, 11),
	 (14, 6, 20, 12),
	 (15, 8, 10, 13),
	 (16, 1, 0, 14),
	 (17, 3, 0, 15),
	 (18, 2, 0, 16),
	 (19, 7, 0, 16),
	 (20, 8, 14, 20);
	 
