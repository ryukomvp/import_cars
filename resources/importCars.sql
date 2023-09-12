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
        
CREATE TABLE IF NOT EXISTS codigosplazos(
    
    idcodigoplazo int AUTO_INCREMENT PRIMARY KEY not null,
    plazo varchar(30),
    dias int not null

);

CREATE TABLE IF NOT EXISTS sucursales (
	idsucursal INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombresuc VARCHAR(20) NOT NULL,
    telefonosuc VARCHAR(10) NOT NULL,
    correosuc VARCHAR(100) NOT NULL UNIQUE,
    direccionsuc VARCHAR(150) NOT NULL
);

CREATE TABLE IF NOT EXISTS plazos(
    
    idplazo int AUTO_INCREMENT PRIMARY KEY not null,
    descripcion varchar(30) not null,
    vencimiento date not null,
    idcodigoplazo int not null,
    tipoplazo ENUM('Contado', 'Credito') not null,

	CONSTRAINT fkcodigopla
    FOREIGN KEY (idcodigoplazo)
    REFERENCES codigosplazos(idcodigoplazo) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS contactos(
	idcontacto INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    telefonocontact VARCHAR(16) NOT NULL,
    celularcontact VARCHAR(16) NOT NULL,
    correocontac VARCHAR(70) NOT NULL, 
    idsucursal INT NOT NULL,
    
    CONSTRAINT fksucursalcontac
    FOREIGN KEY (idsucursal)
    REFERENCES sucursales(idsucursal) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS parametros (
	idparametro INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombreemp VARCHAR(50) NOT NULL UNIQUE,
    direccionemp VARCHAR(150) NOT NULL,
    porcentaje NUMERIC(5,2),
    registro INT NULL,
    giroempresa VARCHAR(80) NOT NULL,
    nit VARCHAR(20) NOT NULL,
    dui VARCHAR(20) NOT NULL,
    idcontacto INT NOT NULL,
    
    CONSTRAINT fkcontactoparam
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

CREATE TABLE IF NOT EXISTS clientes(
     
    idcliente int AUTO_INCREMENT PRIMARY KEY not null,
    nombre VARCHAR(100) NOT NULL,
    giro VARCHAR(30) NULL,
    dui VARCHAR(11) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    telefono VARCHAR(10) NOT NULL,
    contacto VARCHAR(10) NULL,
    descuento DECIMAL(5,2) NULL,
    exoneracion DECIMAL(5,2) NULL,
    fechaini DATE NOT NULL,
    tipocliente ENUM('Fiscal', 'Consumidor Final') NOT NULL,
    idplazo INT NOT NULL,
     
    CONSTRAINT fkclienteplazo
    FOREIGN KEY (idplazo)
    REFERENCES plazos(idplazo) ON UPDATE CASCADE ON DELETE CASCADE
 
);

CREATE TABLE IF NOT EXISTS usuarios(
	idusuario INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombreus VARCHAR(50) NOT NULL UNIQUE,
    contrasenia VARCHAR(150) NOT NULL,
    fechacontra DATE NULL,
    pin VARCHAR(10) NOT NULL,
    tipousuario ENUM('Administrador' , 'Gerente' , 'Vendedor') NOT NULL,
    idempleado INT NOT NULL, 
    estadousuario ENUM('Activo' , 'Inactivo' , 'Bloqueado') NOT NULL,
    intentos INT NOT NULL default 0,
    
    CONSTRAINT fkusuarioemp
    FOREIGN KEY (idempleado)
    REFERENCES empleados(idempleado) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS cajas (
	idcaja INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombrecaja VARCHAR(20) NOT NULL,
    nombreequipo VARCHAR(20) NOT NULL,
    serieequipo VARCHAR(15) NOT NULL UNIQUE,
    modeloequipo VARCHAR(20) NOT NULL,
    idsucursal INT NOT NULL,
    idusuario INT NOT NULL,
    
    CONSTRAINT fkcajasucursal
    FOREIGN KEY (idsucursal)
    REFERENCES sucursales(idsucursal) ON UPDATE CASCADE ON DELETE CASCADE,

    CONSTRAINT fkcajausuario
    FOREIGN KEY (idusuario)
    REFERENCES usuarios(idusuario) ON UPDATE CASCADE ON DELETE CASCADE	 
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
    nombreprod VARCHAR(70) NOT NULL,
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
    fechatransac DATE NOT NULL,
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
    REFERENCES parametros(idparametro) ON UPDATE CASCADE ON DELETE CASCADE,

    CONSTRAINT fkcliencatransaccion
    FOREIGN KEY (idcliente)
    REFERENCES clientes(idcliente) ON UPDATE CASCADE ON DELETE CASCADE
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

/*inserciones de datos*/

INSERT INTO paisesDeOrigen(pais) VALUES
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

INSERT INTO marcas(marca) VALUES
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
	('Nissan'),
	('Tesla'),
	('Dodge'),
	('Plymouth');

INSERT INTO familias(familia) VALUES
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
	('Para Choques');

INSERT INTO categorias(categoria) VALUES
	('Escapes'),
	('Puertas'),
	('Focos'),
	('Lamparas'),
	('Manubrios'),
	('Chapa'),
	('Para Choques'),
	('Espejos'),
	('Retrovisores');
	
INSERT INTO monedas(moneda) VALUES
	('Dolar'),
	('Euro'),
	('Libra'),
	('Peso Argentino'),
	('Yen'),
	('Yuan'),
	('Libra Esterlina'),
	('Peso Mexicano'),
	('Peso Colombiano'),
	('Bitcoin');

INSERT INTO codigosplazos(plazo, dias) VALUES
	('plazo1', 1),
    ('plazo2', 2),
    ('plazo3', 3),
    ('plazo4', 4),
    ('plazo5', 5),
    ('plazo6', 6),
    ('plazo7', 7);

INSERT INTO plazos(descripcion, vencimiento, idcodigoplazo, tipoplazo) VALUES
	('plazo para cliente 1', 14, 1, 'Contado'),
    ('plazo para cliente 2', 12, 2, 'Contado'),
    ('plazo para cliente 3', 10, 3, 'Contado'),
    ('plazo para cliente 4', 9, 4, 'Contado'),
    ('plazo para cliente 5', 20, 5, 'Contado'),
    ('plazo para cliente 6', 11, 6, 'Contado'),
    ('plazo para cliente 7', 5, 7, 'Contado');

INSERT INTO sucursales(nombresuc, telefonosuc, correosuc, direccionsuc) VALUES
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

INSERT INTO proveedores(nombreprov, telefonoprov, correoprov, codigoprov, codigomaestroprov, duiprov, idmoneda, numeroregistroprov) VALUES
	('Mercury', '4365-5632', 'mercury@gmail.com', 123, 1233, '234306234-0', 1, 1),
	('Maybach', '4125-5032', 'maybach@gmail.com', 124, 1244, '00656234-0', 2, 2),
	('Pontiac', '5265-6830', 'pontiac@gmail.com', 125, 1255, '236510004-0', 1, 3),
	('Chrysler', '4065-2132', 'chrysler@gmail.com', 126, 1266, '224356234-0', 3, 4),
	('Ford', '5365-3402', 'ford@gmail.com', 127, 1277, '23435524-9', 4, 5),
	('Suzuki', '4007-3232', 'suzuki@gmail.com', 128, 1288, '234095434-5', 1, 6),
	('Buick', '2364-4002', 'buik@gmail.com', 129, 1299, '43423454-5', 1, 7),
	('Isuzu', '2360-5237', 'isuzu@gmail.com', 131, 1311, '512346434-7', 2, 8),
	('GMC', '5325-5604', 'gmc@gmail.com', 732, 1322, '234340004-8', 2, 9),
	('Cadillac', '0005-3731', 'cadillac@gmail.com', 134, 1344, '00000000-0', 2, 10),
	('Chevrolet', '3300-5638', 'chevrolet@gmail.com', 320, 1233, '123876234-0', 1, 12),
	('Toyota', '7265-9002', 'toyota@gmail.com', 167, 1233, '23300024-4', 1, 13),
	('Porsche', '0194-5924', 'porsche@gmail.com', 098, 1233, '200086234-0', 1, 14),
	('Nissan', '4024-3002', 'nissan@gmail.com', 166, 1233, '12663234-6', 3, 17),
	('Tesla', '1572-7602', 'tesla@gmail.com', 111, 1233, '23465434-6', 2, 18),
	('Dodge', '8366-2539', 'dodge@gmail.com', 221, 1233, '2343124434-7', 1, 19),
	('Plymouth', '7363-8636', 'plymouth@gmail.com', 233, 1233, '234239457-0', 1, 20);

INSERT INTO clientes(nombre, giro, dui, correo, telefono, contacto, descuento, exoneracion, fechaini, tipocliente, idplazo) VALUES
	('Jonathan Kevin Murcia Hernandez', 'Empresario', '23456712-1', 'kdekevo@gmail.com', '3456-2345', 'contacto1', 43.50, 50.00, 2006, 'Fiscal', 1),
    ('Jose Antonio Castillo Letona', 'Empresario', '73337323-0', 'jdejosesito@gmail.com', '3346-2482', 'contacto2', 86.80, 30.00, 2007, 'Fiscal', 2),
    ('Jonathan Guillermo Parada Payes', 'Empresario', '46576748-2', 'cdecarbajal@gmail.com', '3226-2157', 'contacto3', 33.70, 60.00, 2008, 'Fiscal', 3),
    ('Juan Kevo Ramirez Carbajal', 'Empresario', '71456472-1', 'ddedaniel@gmail.com', '3590-2781', 'contacto4', 72.60, 100.00, 2009, 'Fiscal', 4),
    ('Diego Jose Murcia Hernandez', 'Empresario', '64567849-3', 'adeandre@gmail.com', '3419-6589', 'contacto5', 71.20, 20.00, 2014, 'Fiscal', 5),
    ('Cristian Andre Heriquez Pineda', 'Empresario', '68452672-4', 'adealec@gmail.com', '3418-7821', 'contacto6', 68.90, 23.00, 2012, 'Fiscal', 6),
    ('Alec Andre Marchelli Chavez', 'Empresario', '53362162-4', 'tdetanqueta@gmail.com', '6585-2367', 'contacto7', 22.70, 56.00, 2015, 'Fiscal', 7);

INSERT INTO modelos(modelo, idmarca) VALUES
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

INSERT INTO bodegas(numerobod, direccionbod, idsucursal) VALUES
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

INSERT INTO familiasBodegas(idbodega, idfamilia) VALUES
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

INSERT INTO codigoscomunes(codigo) VALUES
	('PDI0001823'),
	('PDD0001824'),
	('PTI0001832'),
	('PTD 0001842'),
	('FDD0001930'),
	('FDI0001931'),
	('FTD0001903'),
	('FTI0001913'),
	('RD0002043'),
	('RI0002034');

INSERT INTO tiposproductos(tipoproducto) VALUES
	('Faroles'),
	('Retrovisor'),
	('Puerta'),
	('Bomper'),
	('Capo');

INSERT INTO empleados(nombreemp, telefonoemp, correoemp, nacimientoemp, duiemp, estadoempleado, genero, cargo) VALUES
	('Annamaria Sheffield', '0971-3740', 'asheffield0@sogou.com', '2003-06-02', '02434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Elianore Boggon', '4518-8750', 'eboggon1@techcrunch.com', '2003-06-08', '12434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Germaine Antonietti', '3341-5203', 'gantonietti2@canalblog.com', '1998-08-07', '22434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Susanna Jahns', '9403-0016', 'sjahns3@facebook.com', '2001-05-02', '32434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Ruperto Lundon', '8564-9955', 'rlundon4@ucsd.edu', '1997-01-02', '42434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Isabella Phillpot', '1971-3740', 'iphillpot5@google.fr', '2000-01-01', '52434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Pauly Budge', '3130-8699', 'pbudge6@is.gd', '2002-04-05', '62434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Neely Bawden', '2971-3740', 'nbawden7@diigo.com', '1998-05-05', '72434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Ignaz Cuvley', '8472-5129', 'icuvley8@china.com.cn', '2000-08-04', '82434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Barri Acheson', '3811-2812', 'bacheson9@google.nl', '2001-09-03', '92434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Zsazsa Hassen', '8312-7176', 'zhassena@zimbio.com', '2003-08-04', '10434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Scarface Bessant', '2055-3964', 'sbessantb@icq.com', '2003-06-02', '11434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Edithe Britt', '3971-3740', 'ebrittc@illinois.edu', '2003-06-12', '13434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Bartholomew Chstney', '8652-4778', 'bchstneyd@adobe.com', '2003-01-06', '14434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Shayla Woodfield', '7079-6484', 'swoodfielde@hatena.ne.jp', '2001-03-03', '15434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Sisile Sleight', '4971-3740', 'ssleightf@businessweek.com', '2003-06-02', '16434523-2', 'Activo', 'Masculino', 'Jefe'),
	('Evelin Fery', '5971-3740', 'eferyg@omniture.com', '1998-06-04', '17434523-2', 'Inactivo', 'Masculino', 'Jefe'),
	('Pietrek Peris', '8905-6928', 'pperish@cornell.edu', '2002-06-06', '99434523-2', 'Inactivo', 'Masculino', 'Jefe'),
	('Mellisa Anstee', '1936-8789', 'mansteei@google.co.jp', '1997-09-11', '00434523-2', 'Inactivo', 'Masculino', 'Jefe'),
	('Nevin Oke', '2536-1122', 'nokej@home.pl', '1999-02-03', '20434523-2', 'Inactivo', 'Masculino', 'Jefe'),
	('Daniel Hernández', '7053-7276', 'daniel123hernandez15@gmail.com', '2010-10-10', '06795006-2', 'Activo', 'Masculino', 'Jefe');

INSERT INTO usuarios(nombreus, contrasenia, pin, tipousuario, idempleado, estadousuario) VALUES
	('Marchelli', '$2y$10$Lh3Le1sR3Ys301TFgCGgeu5bdaRv27gWxO/4O66BUJQlGjji4n8Mm', '12345678', 'Administrador', 1, 'Activo'),
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

INSERT INTO cajas (nombrecaja, nombreequipo, serieequipo, modeloequipo, idsucursal, idusuario) VALUES
        ('Caja 1','HP basic 1080','1098R3456P93', 'HP',1,1),
        ('Caja 2','HP basic 1080','09876B4567C1','HP',2,1),
        ('Caja 3','Dell Conveni','76543J345P12','DELL',1,1),
        ('Caja 1','MAC X','9876P098I754','MAC',2,1);

INSERT INTO cajeros (nombrecajero, estadocajero, fechaingreso, idcaja) VALUES
       ('Cajero 1', 1, '2023-07-10',1),
       ('Cajero 2', 1, '2023-06-05',1),
       ('Cajero 3', 1, '2023-07-20',1),
       ('Cajero 4', 1, '2023-05-24',1),
       ('Cajero 5', 1, '2023-04-01',1),
       ('Cajero 6', 1, '2023-06-12',1),
       ('Cajero 7', 1, '2023-07-09',1);

INSERT INTO contactos (telefonocontact, celularcontact, correocontac, idsucursal) VALUES
       ('7109-4312', '7109-4312', 'empresa1@gmail.com',1),
       ('0942-1234', '7788-6565', 'empresa2@gmail.com',2),
       ('7788-6565', '7655-0000', 'empresa3@gmail.com',3),
       ('7655-0000', '7655-0000', 'empresa4@gmail.com',4),
       ('0964-4566', '7655-7966', 'empresa5@gmail.com',5),
       ('1234-5678', '0005-0000', 'empresa6@gmail.com',6),
       ('0112-0987', '7655-0000', 'empresa7@gmail.com',1);

INSERT INTO parametros (nombreemp, direccionemp, porcentaje, registro, giroempresa, nit, dui, idcontacto) VALUES
       ('Importadora Pineda','calle 25 pasaje 1 casa 3', 23.0, 1,'Proveedor de repuestos','5632-286468-633-0','33233166-0',1),
       ('Distribuidora Repuestos S.A de C.V','calle 14 pasaje 2 casa 12', 13.0, 2,'Proveedor de repuestos','3232-234365-233-0','33232455-2',2),
       ('Importe Repuestos','calle 11 pasaje 5 casa 3', 10.0, 3,'Proveedor de repuestos','0122-223465-532-3','24556556-3',3),
       ('Repuestos Trasacciones','calle 40 pasaje 2 casa 6', 50.0, 4,'Proveedor de repuestos','2392-271535-233-1','32324556-6',4),
       ('Import Cars S.A de C.V','calle 12 pasaje 2 casa 8', 12.0, 5,'Proveedor de repuestos','2256-257165-236-2','32345566-7',5),
       ('Cars Repuestos','calle 23 pasaje 14 casa 7', 60.0, 6,'Proveedor de repuestos','5132-261345-245-2','15564556-8',6),
       ('Importa Repuestos S.A de C.V','calle 25 pasaje 1 casa 10', 80.0, 7,'Proveedor de repuestos','6378-226715-283-2','32671556-3',7);

INSERT INTO vendedores(idusuario, idcaja) VALUES
       (1,1),
       (2,2),
       (3,3),
       (4,4),
       (5,3),
       (6,1),
       (7,4);
       
INSERT INTO productos(nombreprod, descripcionprod, precio, preciodesc, anioinicial, aniofinal, idcodigocomun, idtipoproducto, idcategoria, idmodelo, idpais, estadoproducto) VALUES
       ('Foco frontal amarillo Toyota Corolla 2012', 'Foco frontal amarillo', 20.00, 15.00, 2010, 2017, 1, 1, 3, 1, 1,'Existente'),
       ('Retrovisor derecho Nissan Sentra 2017', 'Retrovisor derecho blanco', 20.00, 15.00, 2015, 2017, 2, 2, 9, 2, 2,'Existente'),
       ('Capo Toyota Supra MK4', 'Capo negro Toyota Supra 2002', 120.00, 115.00, 2002, 2020, 3, 5, 7, 3, 3,'Existente'),
       ('Puerta derecha delantera Mitsubishi Montero 2015', 'Puerta delantera gris', 100.00, 97.99, 2015, 2020, 4, 3, 2, 4, 4,'Existente'),
       ('Bomper trasero Mercedes Benz Clase A 2021', 'Bomper trasero gris', 60.00, 58.00, 2021, 2022, 5, 4, 7, 5, 5,'Existente'),
       ('Escape Hyundai El Antra 2017', 'Escape Hyundai EL Antra', 35.50, 33.99, 2017, 2020, 6, 4, 7, 6, 6,'Existente'),
       ('Foco delantero blanco Honda Civic SI 2020', 'Foco frontal blanco Honda Civic SI', 44.00, 43.00, 2020, 2022, 7, 1, 3, 7, 7,'Existente');

INSERT INTO codigostransacciones(codigo, nombrecodigo) VALUES
       (1234, 'codigo1'),
       (1235, 'codigo2'),
       (1236, 'codigo3'),
       (1237, 'codigo4'),
       (1238, 'codigo5'),
       (1239, 'codigo6'),
       (1210, 'codigo7');

INSERT INTO encabezadostransacciones(nocomprobante, fechatransac, lote, npoliza, idbodega, idcajero, tipopago, idcodigotransaccion, idcliente, idvendedor, idproveedor, idparametro) VALUES
       (1, '2015-01-01', 1213, 1234, 1, 1,'Efectivo', 1, 1, 1, 1, 1),
       (2, '2015-01-01', 1214, 1235, 2, 2,'Efectivo', 2, 2, 2, 2, 2),
       (3, '2015-01-01', 1215, 1236, 3, 3,'Efectivo', 3, 3, 3, 3, 3),
       (4, '2015-01-01', 1216, 1237, 4, 4,'Efectivo', 4, 4, 4, 4, 4),
       (5, '2015-01-01', 1217, 1238, 5, 5,'Efectivo', 5, 5, 5, 5, 5),
       (6, '2015-01-01', 1218, 1239, 6, 6,'Efectivo', 6, 6, 6, 6, 6),
       (7, '2015-01-01', 1219, 1230, 7, 7,'Efectivo', 7, 7, 7, 7, 7);

INSERT INTO detallestransacciones(correlativo, cantidad, preciounitario, ventanosujeta, ventaexenta, ventaafecta, descuento, valordescuento, sumas, subtotal, ventatotal, iva, observaciones, idbodegaentrada, idbodegasalida, idproducto, descripcion, idencatransaccion) VALUES
       (1, 50, 20.00, 15.00, 40.00, 34.00, 40.00, 20.00, 40.00, 34.00, 34.00, 19.00, 'Exelente', 1, 1, 1, 'Transaccion de producto', 1),
       (2, 60, 40.00, 20.00, 34.00, 40.00, 33.00, 19.00, 20.00, 33.00, 40.00, 40.00, 'Defectuoso', 2, 2, 2, 'Transaccion de producto', 2),
       (3, 70, 33.00, 40.00, 19.00, 33.00, 19.00, 33.00, 19.00, 33.00, 20.00, 19.00, 'Exelente', 3, 3, 3, 'Transaccion de producto', 3),
       (4, 80, 19.00, 60.00, 20.00, 19.00, 40.00, 19.00, 19.00, 40.00, 40.00, 20.00, 'Exelente', 4, 4, 4, 'Transaccion de producto', 4),
       (5, 90, 80.00, 34.00, 40.00, 34.00, 19.00, 20.00, 33.00, 20.00, 19.00, 34.00, 'Defectuoso', 5, 5, 5, 'Transaccion de producto', 5),
       (6, 100, 15.00, 12.00, 19.00, 19.00, 40.00, 20.00, 40.00, 19.00, 19.00, 33.00, 'Exelente', 6, 6, 6, 'Transaccion de producto', 6),
       (7, 110, 84.00, 19.00, 19.00, 40.00, 19.00, 19.00, 34.00, 20.00, 33.00, 40.00, 'Defectuoso', 7, 7, 7, 'Transaccion de producto', 7);



