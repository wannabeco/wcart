ALTER TABLE `app_banners` ADD `idCategoria` BIGINT NOT NULL AFTER `linkBanner`;
ALTER TABLE `app_banners` ADD `idSubcategoria` BIGINT NOT NULL AFTER `linkBanner`;
ALTER TABLE `app_presentacion_producto` ADD FULLTEXT (nombrePresentacion);
ALTER TABLE `app_productos` ADD FULLTEXT (nombrePresentacion);
ALTER TABLE `app_banners` ADD `idTienda` INT NOT NULL AFTER `idBanner`;