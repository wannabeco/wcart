ALTER TABLE app_tiendas ADD terminos INT DEFAULT 0 NULL;
ALTER TABLE app_banners MODIFY COLUMN tipoLink enum('producto','url','sinAccion') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE app_banners MODIFY COLUMN idCategoria bigint(20) NULL;
ALTER TABLE app_banners MODIFY COLUMN idSubcategoria bigint(20) NULL;



