-- campos faltantes para calificacion en table app_presentacion_producto
ALTER TABLE app_presentacion_producto ADD puntos INT DEFAULT 0 AFTER agotado;
ALTER TABLE app_presentacion_producto ADD votantes INT DEFAULT 0 AFTER puntos;
-- table de comentarios
CREATE TABLE app_comentarios (
	idComentario INT auto_increment NOT NULL,
	idTienda INT NOT NULL,
	idPresentacion INT NOT NULL,
	idUsuario INT NOT NULL,
	comentario TEXT NULL,
	ip varchar(100) NULL,
	fechaComentario DATETIME NULL,
	estado INT DEFAULT 1 NULL,
	eliminado varchar(100) DEFAULT 0 NULL,
	CONSTRAINT app_comentarios_PK PRIMARY KEY (idComentario)
)
CREATE TABLE app_votos (
	idVotos INT auto_increment NOT NULL,
	idUsuario INT NULL,
	idTienda INT NULL,
	idPresentacion varchar(100) NULL,
	idComentario INT NULL,
	calificacion INT NULL,
	estado INT DEFAULT 1 NULL,
	eliminado INT DEFAULT 0 NULL,
	CONSTRAINT app_votos_PK PRIMARY KEY (idVotos)
)