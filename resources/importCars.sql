CREATE DATABASE IF NOT EXISTS importCars;
USE importCars;

CREATE TABLE IF NOT EXISTS marcas (
	idmarca INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    marca VARCHAR(25) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS paisesdeorigen (
	idpais INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    pais VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS monedas (
	idmoneda INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    moneda VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS familias (
	idfamilia INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    familia VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS categorias (
	idcategoria INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    categoria VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS codigoscomunes (
	idcodigocomun INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    codigo VARCHAR(15) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS tiposproductos (
	idtipoproducto INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    tipoproducto VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS codigostransacciones(
	idcodigotransaccion INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    codigo INT NOT NULL,
    nombrecodigo VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS sucursales (
	idsucursal INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombresuc VARCHAR(20) NOT NULL,
    telefonosuc VARCHAR(10) NOT NULL,
    correosuc VARCHAR(100) NOT NULL UNIQUE,
    direccionsuc VARCHAR(150) NOT NULL
);

CREATE TABLE IF NOT EXISTS contactos(
	idcontacto INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    contacto VARCHAR(70) NOT NULL,
    tipocontacto ENUM('Correo Electronico','Telefono Fijo','Telefono Celular')
);

CREATE TABLE IF NOT EXISTS parametros (
	idparametro INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombreemp VARCHAR(30) NOT NULL UNIQUE,
    direccionemp VARCHAR(150) NOT NULL,
    porcentaje NUMERIC(5,2),
    registro INT NULL,
    giroempresa VARCHAR(80) NOT NULL,
    nit VARCHAR(20) NOT NULL,
    dui VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS parametroscontactos(
	idparamcontactos INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    idparametro INT NOT NULL,
    idcontacto INT NOT NULL,
    
    CONSTRAINT fkparam
    FOREIGN KEY (idparametro)
    REFERENCES parametros(idparametro) ON UPDATE CASCADE ON DELETE CASCADE,
    
    CONSTRAINT fkcontacto
    FOREIGN KEY (idcontacto)
    REFERENCES contactos(idcontacto) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS proveedores (
	idproveedor INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombreprov VARCHAR(25) NOT NULL,
    telefonoprov VARCHAR(10) NOT NULL UNIQUE,
    correoprov VARCHAR(100) NOT NULL UNIQUE,
    codigoprov INT NOT NULL UNIQUE,
    codigomaestroprov INT NOT NULL,
    duiprov VARCHAR(20) NOT NULL UNIQUE,
    idmoneda INT NOT NULL,
    numeroregistroprov INT NOT NULL,
    
    CONSTRAINT fkprovmoneda
    FOREIGN KEY (idmoneda)
    REFERENCES monedas(idmoneda) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS modelos (
	idmodelo INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    modelo VARCHAR(50) NOT NULL UNIQUE,
    idmarca INT NOT NULL,
    
    CONSTRAINT fkmarcamodel
    FOREIGN KEY (idmarca)
    REFERENCES marcas(idmarca) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS cajas (
	idcaja INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombrecaja VARCHAR(20) NOT NULL UNIQUE,
    nombreequipo VARCHAR(20) NOT NULL,
    seriequipo VARCHAR(15) NOT NULL UNIQUE,
    modeloequipo VARCHAR(20) NOT NULL,
    idsucursal INT NOT NULL,
    
    CONSTRAINT fkcajasucursal
    FOREIGN KEY (idsucursal)
    REFERENCES sucursales(idsucursal) ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE IF NOT EXISTS cajeros (
	idcajero INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombrecajero VARCHAR(20) NOT NULL UNIQUE,
    estadocajero BOOLEAN NOT NULL,
    fechaingreso DATE NOT NULL,
    idcaja INT NOT NULL,
    
    CONSTRAINT fkcajeroacaja
    FOREIGN KEY (idcaja)
    REFERENCES cajas(idcaja) ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE IF NOT EXISTS empleados(
	idempleado INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombreemp VARCHAR(60) NOT NULL,
    telefonoemp VARCHAR(10) NOT NULL UNIQUE,
    correoemp VARCHAR(100) NOT NULL UNIQUE,
    nacimientoemp DATE NOT NULL,
    duiemp VARCHAR(20) NOT NULL UNIQUE,
    estadoempleado ENUM('Activo', 'Inactivo' , 'Ausente con justificación' , 'Ausente sin justificación') NOT NULL,
    genero ENUM('Masculino' , 'Femenino') NOT NULL,
    cargo ENUM('Jefe', 'Gerente' , 'Vendedor') NOT NULL
);

CREATE TABLE IF NOT EXISTS usuarios(
	idusuario INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombreus VARCHAR(50) NOT NULL UNIQUE,
    contrasenia VARCHAR(150) NOT NULL,
    pin VARCHAR(10) NOT NULL,
    tipousuario ENUM('Administrador' , 'Gerente' , 'Vendedor') NOT NULL,
    idempleado INT NOT NULL, 
    estadousuario ENUM('Activo' , 'Inactivo' , 'Bloqueado') NOT NULL,
    
    CONSTRAINT fkusuarioemp
    FOREIGN KEY (idempleado)
    REFERENCES empleados(idempleado) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS vendedores (
	idvendedor INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    idusuario INT NOT NULL UNIQUE,
    idcaja INT NOT NULL,
    
    CONSTRAINT fkusuariovendedor
    FOREIGN KEY (idusuario)
    REFERENCES usuarios(idusuario) ON UPDATE CASCADE ON DELETE CASCADE,
    
    CONSTRAINT fkvendedorcaja
    FOREIGN KEY (idcaja)
    REFERENCES cajas(idcaja) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS bodegas (
	idbodega INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    numerobod INT NOT NULL,
    direccionbod VARCHAR(150),
    idsucursal INT NOT NULL,
    
    CONSTRAINT fksucursalbod
    FOREIGN KEY (idsucursal) 
    REFERENCES sucursales(idsucursal) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS familiasbodegas(
	idfamiliabodega INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    idbodega INT NOT NULL,
    idfamilia INT NOT NULL,
    
    CONSTRAINT fkfamiliabodega
    FOREIGN KEY (idfamilia) 
    REFERENCES familias(idfamilia) ON UPDATE CASCADE ON DELETE CASCADE,
    
    CONSTRAINT fkbodegafamilia
    FOREIGN KEY (idfamilia) 
    REFERENCES bodegas(idbodega) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS productos(
	idproducto INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombreprod VARCHAR(50) NOT NULL,
    imagen VARCHAR(150),
    descripcionprod VARCHAR(150) NOT NULL,
    precio NUMERIC(6,2) NOT NULL,
    preciodesc NUMERIC(6,2) NOT NULL,
    anioinicial INT NOT NULL,
    aniofinal INT NOT NULL,
    idcodigocomun INT NOT NULL,
    idtipoproducto INT NOT NULL,
    idcategoria INT NOT NULL,
    idmodelo INT NOT NULL,
    idpais INT NOT NULL,
    estadoproducto ENUM('Escaso', 'Existente' , 'Sin existencias') NOT NULL,
    
    CONSTRAINT fkcodigoprod
    FOREIGN KEY (idcodigocomun)
    REFERENCES codigoscomunes(idcodigocomun) ON UPDATE CASCADE ON DELETE CASCADE,
    
    CONSTRAINT fkpaisprod
    FOREIGN KEY (idpais)
    REFERENCES paisesdeorigen(idpais) ON UPDATE CASCADE ON DELETE CASCADE,
    
    CONSTRAINT fkcategoriaprod
    FOREIGN KEY (idcategoria)
    REFERENCES categorias(idcategoria) ON UPDATE CASCADE ON DELETE CASCADE,

    CONSTRAINT fkmodeloprod
    FOREIGN KEY (idmodelo)
    REFERENCES modelos(idmodelo) ON UPDATE CASCADE ON DELETE CASCADE,

    CONSTRAINT fktipoprod
    FOREIGN KEY (idtipoproducto)
    REFERENCES tiposproductos(idtipoproducto) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS encabezadostransacciones (
    idencatransaccion INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nocomprobante INT NOT NULL UNIQUE,
    fechatransac NUMERIC(8,2) NOT NULL,
    lote INT NOT NULL,
    npoliza INT NOT NULL,
    idbodega INT NOT NULL,
    idcajero INT NOT NULL,
    tipopago ENUM('Efectivo' , 'Tarjeta') NOT NULL,
    idcodigotransaccion INT NOT NULL,
    idcliente INT NOT NULL,
    idvendedor INT NOT NULL,
    idproveedor INT NOT NULL,
    idparametro INT NOT NULL,

    CONSTRAINT fkbogtransac
    FOREIGN KEY (idbodega)
    REFERENCES bodegas(idbodega) ON UPDATE CASCADE ON DELETE CASCADE,
    
    CONSTRAINT fkcajerotrasac
    FOREIGN KEY (idcajero)
    REFERENCES cajeros(idcajero) ON UPDATE CASCADE ON DELETE CASCADE,
    
    CONSTRAINT fkcodigotransac
    FOREIGN KEY (idcodigotransaccion)
    REFERENCES codigostransacciones(idcodigotransaccion) ON UPDATE CASCADE ON DELETE CASCADE,
    
    CONSTRAINT fkvendedortransac
    FOREIGN KEY (idvendedor)
    REFERENCES vendedores(idvendedor) ON UPDATE CASCADE ON DELETE CASCADE,
    
    CONSTRAINT fkprovtransac
    FOREIGN KEY (idproveedor)
    REFERENCES proveedores(idproveedor) ON UPDATE CASCADE ON DELETE CASCADE,
    
    CONSTRAINT fkparametrotransac
    FOREIGN KEY (idparametro)
    REFERENCES parametros(idparametro) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS detallestransacciones (
    iddetalletransaccion INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    correlativo INT NOT NULL UNIQUE,
    cantidad INT NOT NULL,
    preciounitario NUMERIC(8,2) NOT NULL,
    ventanosujeta NUMERIC(5,2) NULL,
    ventaexenta NUMERIC(5,2) NULL,
    ventaafecta NUMERIC(5,2) NULL,
    descuento NUMERIC(5,2) NOT NULL,
    valordescuento NUMERIC(8,2) NOT NULL,
    sumas NUMERIC(8,2) NOT NULL,
    subtotal NUMERIC(8,2) NOT NULL,
    ventatotal NUMERIC(8,2) NOT NULL,
    iva NUMERIC(5,2) NOT NULL,
    observaciones VARCHAR(200) NULL,
    idbodegaentrada INT NULL,
    idbodegasalida INT NULL,
    idproducto INT NOT NULL,
    descripcion VARCHAR(100) NOT NULL,
    idencatransaccion INT NOT NULL,

    CONSTRAINT fkbodentradadetalletransac
    FOREIGN KEY (idbodegaentrada)
    REFERENCES bodegas(idbodega) ON UPDATE CASCADE ON DELETE CASCADE,
    
    CONSTRAINT fkbodsalidadetalletransac
    FOREIGN KEY (idbodegasalida)
    REFERENCES bodegas(idbodega) ON UPDATE CASCADE ON DELETE CASCADE,
    
    CONSTRAINT fkproddetalletransac
    FOREIGN KEY (idproducto)
    REFERENCES productos(idproducto) ON UPDATE CASCADE ON DELETE CASCADE,
    
    CONSTRAINT fkencadetalletransac
    FOREIGN KEY (idencatransaccion)
    REFERENCES encabezadostransacciones(idencatransaccion) ON UPDATE CASCADE ON DELETE CASCADE
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
	('España'),
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
	
	insert into monedas(moneda) values
	('Dolar'),
	('Euro'),
	('Libra'),
	('Peso Argentino'),
	('Yen'),
	('Yuan'),
	('Libra Esterlina'),
	('Peso Mexicano'),
	('Peso Colombiano'),
	('Rublo');
	
	insert into proveedores(nombre, telefono, correo, fechaCompra, saldoInicial, saldoActual, codigoProv, codigoMaestroProv, dui, idmoneda, numeroRegistroProv) values
	('Mercury', '4365-5632', 'mercury@gmail.com', '4/11/2020', 500.00, 250.00, 123, 1233, '234356234-0', 1, 1),
	('Maybach', '4125-5632', 'maybach@gmail.com', '11/06/2020', 500.00, 250.00, 124, 1244, '23656234-0', 2, 2),
	('Pontiac', '5265-6832', 'pontiac@gmail.com', '4/11/2021', 500.00, 250.00, 125, 1255, '236516234-0', 1, 3),
	('Chrysler', '4365-2132', 'chrysler@gmail.com', '4/01/2022', 500.00, 250.00, 126, 1266, '224356234-0', 3, 4),
	('Ford', '5365-3432', 'ford@gmail.com', '12/03/2014', 500.00, 250.00, 127, 1277, '23435524-1', 4, 5),
	('Suzuki', '4667-3232', 'suzuki@gmail.com', '10/08/2016', 500.00, 250.00, 128, 1288, '234352334-5', 1, 6),
	('Buick', '2364-4662', 'buik@gmail.com', '4/11/2020', 500.00, 250.00, 129, 1299, '43435624-5', 1, 7),
	('Isuzu', '2363-5237', 'isuzu@gmail.com', '5/03/2020', 500.00, 250.00, 131, 1311, '536256434-7', 2, 8),
	('GMC', '5325-5674', 'gmc@gmail.com', '7/2/2020', 500.00, 250.00, 132, 1322, '234346234-8', 2, 9),
	('Cadillac', '8265-3731', 'cadillac@gmail.com', '9/5/2021', 500.00, 250.00, 134, 1344, '22656234-0', 2, 10),
	('Porsche', '7228-5581', 'porsche@gmail.com', '9/8/2021', 500.00, 250.00, 123, 1233, '21356234-5', 2, 11),
	('Chevrolet', '3371-5638', 'chevrolet@gmail.com', '10/5/2021', 500.00, 250.00, 123, 1233, '232376234-0', 1, 12),
	('Toyota', '7265-9682', 'toyota@gmail.com', '4/11/2022', 500.00, 250.00, 123, 1233, '23356624-4', 1, 13),
	('Porsche', '0194-5924', 'porsche@gmail.com', '7/5/2022', 500.00, 250.00, 123, 1233, '245356234-0', 1, 14),
	('Isuzu', '1296-0492', 'isuzu@gmail.com', '8/5/2022', 500.00, 250.00, 123, 1233, '23435234-5', 1, 15),
	('Dodge', '1964-5127', 'dodge@gmail.com', '10/2/2020', 500.00, 250.00, 123, 1233, '23435634-0', 1, 16),
	('Nissan', '4024-3712', 'nissan@gmail.com', '12/5/2020', 500.00, 250.00, 123, 1233, '23463234-6', 3, 17),
	('Tesla', '1572-7633', 'tesla@gmail.com', '4/11/2018', 500.00, 250.00, 123, 1233, '23432334-6', 2, 18),
	('Dodge', '8366-2539', 'dodge@gmail.com', '4/11/2018', 500.00, 250.00, 123, 1233, '2343124434-6', 1, 19),
	('Plymouth', '7363-8636', 'plymouth@gmail.com', '4/11/2018', 500.00, 250.00, 123, 1233, '234238234-0', 1, 20);
	
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
	
	insert into codigoComun(nomenclatura, codigo) values
	('PDI', 0001823),
	('PDD', 0001824),
	('PTI', 0001832),
	('PTD', 0001842),
	('FDD', 0001930),
	('FDI', 0001931),
	('FTD', 0001903),
	('FTI', 0001913),
	('RD', 0002043),
	('RI', 0002034);
	
	insert into tiposProductos(tipoProducto) values
	('Faroles'),
	('Retrovisor'),
	('Puerta'),
	('Bomper'),
	('Capo');
	
	insert into empleados(nombreemp, telefonoemp, correoemp, nacimientoemp, duiemp, estadoempleado, genero, cargo) values
	('Annamaria Sheffield', '1971-3740', 'asheffield0@sogou.com', '6/2/2003', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Elianore Boggon', '4518-8750', 'eboggon1@techcrunch.com', '6/8/2003', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Germaine Antonietti', '3341-5203', 'gantonietti2@canalblog.com', '8/7/1998', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Susanna Jahns', '9403-0016', 'sjahns3@facebook.com', '5/2/2001', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Ruperto Lundon', '8564-9955', 'rlundon4@ucsd.edu', '1/2/1997', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Isabella Phillpot', '1971-3740', 'iphillpot5@google.fr', '1/7/2000', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Pauly Budge', '3130-8699', 'pbudge6@is.gd', '4/5/2002', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Neely Bawden', '1971-3740', 'nbawden7@diigo.com', '5/5/1998', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Ignaz Cuvley', '8472-5129', 'icuvley8@china.com.cn', '8/4/2000', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Barri Acheson', '3811-2812', 'bacheson9@google.nl', '9/3/2001', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Zsazsa Hassen', '8312-7176', 'zhassena@zimbio.com', '8/4/2003', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Scarface Bessant', '2055-3964', 'sbessantb@icq.com', '6/2/2003', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Edithe Britt', '1971-3740', 'ebrittc@illinois.edu', '6/12/2003', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Bartholomew Chstney', '8652-4778', 'bchstneyd@adobe.com', '1/6/2003', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Shayla Woodfield', '7079-6484', 'swoodfielde@hatena.ne.jp', '3/3/2001', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Sisile Sleight', '1971-3740', 'ssleightf@businessweek.com', '6/2/2003', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Evelin Fery', '1971-3740', 'eferyg@omniture.com', '6/4/1998', '32434523-2', 'Inactivo', 'Masculino', 'Jefe'),
	('Pietrek Peris', '8905-6928', 'pperish@cornell.edu', '6/6/2002', '32434523-2', 'Inactivo', 'Masculino', 'Jefe'),
	('Mellisa Anstee', '1936-8789', 'mansteei@google.co.jp', '9/11/1997', '32434523-2', 'Inactivo', 'Masculino', 'Jefe'),
	('Nevin Oke', '2536-1122', 'nokej@home.pl', '2/3/1999', '32434523-2', 'Inactivo', 'Masculino', 'Jefe'),
	('Daniel Hernández', '7053-7276', 'daniel123hernandez15@gmail.com', '20/12/2004', '06795006-2', 'Activo', 'Masculino', 'Jefe');
	
	insert into usuarios(nombre, contrasenia, pin, tipousuario, idempleado, estadousuario) values
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
	('Nevin', 'Sheffield', '12345678', 'Gerente', 20, 'Activo'),
	('dani', '$2y$10$Lh3Le1sR3Ys301TFgCGgeu5bdaRv27gWxO/4O66BUJQlGjji4n8Mm', '12345678', 'Administrador', 21, 'Inactivo');
	
	insert into productos(nombre, imagen, descripcion, precio, anio, idCodigoComun, idTipoProducto, idProveedor, idCategoria, idModelo, idPais, estadoProducto) values
	('escape ford','foto','escape', 90.00, 2000,  1 , 5, 5, 1, 1, 1, 'Existente'),
	('escape ford','foto','escape', 90.00, 2000 , 2 , 4, 5, 1, 1, 1, 'Existente'),
	('escape ford','foto','escape', 90.00, 2000 , 3 , 3, 5, 1, 1, 1, 'Existente'),
	('escape ford','foto','escape', 90.00, 2000 , 4 , 1, 5, 1, 1, 1, 'Existente'),
	('escape ford','foto','escape', 90.00, 2000 , 5 , 2, 5, 1, 1, 1, 'Existente'),
	('escape ford','foto','escape', 90.00, 2000 , 6 , 5, 5, 1, 1, 1, 'Existente'),
	('escape ford','foto','escape', 90.00, 2000 , 7 , 4, 5, 1, 1, 1, 'Existente'),
	('escape ford','foto','escape', 90.00, 2000 , 8 , 3, 5, 1, 1, 1, 'Existente'),
	('escape ford','foto','escape', 90.00, 2000 , 9 , 2, 5, 1, 1, 1, 'Existente'),
	('escape ford','foto','escape', 90.00, 2000 , 10 , 1, 5, 1, 1, 1, 'Existente'),
	('foco Maybach','foto','foco', 80.00, 2018 , 1 , 5, 2, 3, 11, 4, 'Existente'),
	('foco Maybach','foto','foco', 80.00, 2018 , 2 , 4, 2, 3, 11, 4, 'Existente'),
	('foco Maybach','foto','foco', 80.00, 2018 , 3 , 3, 2, 3, 11, 4, 'Existente'),
	('foco Maybach','foto','foco', 80.00, 2018 , 4 , 2, 2, 3, 11, 4, 'Existente'),
	('foco Maybach','foto','foco', 80.00, 2018 , 5 , 1, 2, 3, 11, 4, 'Existente'),
	('foco Maybach','foto','foco', 80.00, 2018 , 6 , 5, 2, 3, 11, 4, 'Existente'),
	('foco Maybach','foto','foco', 80.00, 2018 , 7 , 4, 2, 3, 11, 4, 'Existente'),
	('foco Maybach','foto','foco', 80.00, 2018 , 8 , 3, 2, 3, 11, 4, 'Existente'),
	('foco Maybach','foto','foco', 80.00, 2018 , 9 , 2, 2, 3, 11, 4, 'Existente'),
	('foco Maybach','foto','foco', 80.00, 2018 , 10 , 1, 2, 3, 11, 4, 'Existente');
	
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