//cambios desde noviembre 16
ALTER TABLE `app_tiendas` ADD `Plan` ENUM('movil','movil y web') NOT NULL AFTER `fechaCaducidad`;
ALTER TABLE `app_tiendas` ADD `fechaInicioMembresia` DATETIME NOT NULL AFTER `estadoFunciona`;
ALTER TABLE `app_tiendas` ADD `caduca` INT(1) NOT NULL DEFAULT '0' AFTER `Plan`;


CREATE TABLE `wcart`.`app_historial_Membrecia` 
            ( `idHistorial` INT NOT NULL AUTO_INCREMENT , 
            `idtienda` INT(10) NOT NULL , 
            `plan` ENUM('movil','movil y web','','') NOT NULL , 
            `paquete` ENUM('anual','mensual','semestral','vitalicia') NOT NULL , 
            `fechaInicio` DATE NOT NULL , 
            `fechaFinal` DATE NOT NULL , 
            PRIMARY KEY (`idHistorial`)) ;

ALTER TABLE `app_historial_membrecia` CHANGE `plan` `plan` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE wcart.app_tiendas MODIFY COLUMN subdominio text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;

ALTER TABLE wcart.app_tiendas MODIFY COLUMN subdominio text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE wcart.app_tiendas MODIFY COLUMN subdominio text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE wcart.app_personas MODIFY COLUMN vendReferida bigint(20) NULL;
ALTER TABLE wcart.app_personas MODIFY COLUMN vendReferida bigint(20) NULL;
ALTER TABLE wcart.app_personas MODIFY COLUMN apto varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE wcart.app_personas MODIFY COLUMN apto varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE wcart.app_pedidos MODIFY COLUMN idCiudad bigint(20) NULL;
ALTER TABLE wcart.app_pedidos MODIFY COLUMN personaContacto text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE wcart.app_pedidos MODIFY COLUMN celular text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE wcart.app_pedidos MODIFY COLUMN observacion text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE wcart.app_pedidos MODIFY COLUMN fechaPago datetime NULL;
ALTER TABLE wcart.app_pedidos MODIFY COLUMN fechaEntrega datetime NULL;

CREATE TABLE wcart.app_pago_membresia (
	idMembresia INT auto_increment NOT NULL,
	idTienda varchar(100) NULL,
	idPersona varchar(100) NULL,
	ip varchar(100) NULL,
	estadoPedido varchar(100) NULL,
	formaPago varchar(100) NULL,
	transactionid varchar(250) NULL,
	reference_pol varchar(100) NULL,
	valor DOUBLE(15,2) NULL,
	moneda varchar(10) NULL,
	entidad varchar(100) NULL,
	codigoPago varchar(100) NULL,
	fechaPago DATETIME NULL,
	plan varchar(20) NULL,
	CONSTRAINT app_pago_membresia_PK PRIMARY KEY (idMembresia)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

ALTER TABLE wcart.app_pago_membresia CHANGE idPersona nombrePersona varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE wcart.app_pago_membresia CHANGE estadoPedido estadoPago varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE wcart.app_tiendas ADD mesGratis INT DEFAULT 0 NULL;
ALTER TABLE wcart.app_clientes_tienda MODIFY COLUMN FCMTokenTienda text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE wcart.app_fotos_temp MODIFY COLUMN idTienda varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE wcart.app_productos MODIFY COLUMN descProducto text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE wcart.app_tiendas MODIFY COLUMN backgroundCabezaHome varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '#FFC409' NULL;
ALTER TABLE wcart.app_tiendas ADD urlAppStore varchar(250) NULL;
ALTER TABLE wcart.app_tiendas ADD urlAppIos varchar(250) NULL;

CREATE TABLE wcart.app_pagos_eliminados (
	idPagoEliminado INT auto_increment NOT NULL,
	idTienda varchar(100) NULL,
	codigoPago varchar(100) NULL,
	idMembresia varchar(100) NULL,
	fechaPago DATETIME NULL,
	fechaEliminado DATETIME NULL,
	idEstado INT DEFAULT 0 NULL,
	CONSTRAINT app_pagos_eliminados_PK PRIMARY KEY (idPagoEliminado)
)
ALTER TABLE wcart.app_pagos_eliminados ADD emilPago varchar(250) NULL;
ALTER TABLE wcart.app_pagos_eliminados CHANGE emilPago emailPago varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
