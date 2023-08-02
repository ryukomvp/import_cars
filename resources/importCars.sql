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