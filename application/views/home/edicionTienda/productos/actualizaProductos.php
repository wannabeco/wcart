<form role="form" enctype="multipart/form-data"  ng-controller="gestionTienda" ng-init="initProductos()" id="formulario" data-infoTienda ='<?php echo (json_encode($tableTiendas));?>' ng-submit="cargaArchivo()">    
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">Actualiza Productos</h2>
        <p class="text-justify">En este modulo se podra actualizar productos al mismo tiempo</p>
    </div>
    <div class="modal-body">    
        <p> Para realizar la actualización masiva de los productos, es necesario descargar el siguiente documento y realizar los respectivos cambio.
            <?php if ($_SESSION['project']['info']['idPerfil'] == 6){?>
                <a href="<?php echo base_url()?>res/archivos/ActualizaProductos.xlsx" download class="fa fa-file-excel fa-2x" style="with: 10px;" title="Exportar excel"></a>
            <?php } ?>
        </p><br>
            <p> Una vez tenga el archivo actualizado, realice nuevamente el cargue del mismo.</p>
                    <div class="row">
                    <div class="col col-lg-12 col-md-12">
                        <div class="row">
                            <button class="btn btn-primary">
                                <input type="file" id="csv_file" name ="csv_file">   
                            </button><br> 
                            <p style=" position:relative; float:left; left:20px;"> 
                                Antes de hacer el cargue de archivo, por favor verifique que los cambios estén correctos y el formato de excel este en <strong>.CSV</strong>.
                            </p><br>
                            <p class="col col-lg-12" style=" position:relative; float:left; left:20px;">
                              <i class="fa fa-windows" aria-hidden="true"></i> CSV (delimitado por comas) (*.csv).
                            </p><br>
                            <p class="col col-lg-12" style=" position:relative; float:left; left:20px;">
                              <i class="fa fa-apple" aria-hidden="true"></i> Valores separados por comas (.csv).
                            </p><br> 
                              
                        </div>
                    </div>
                    <input type="hidden" name="idTienda" value="<?php echo (isset($tableTiendas['idTienda']))?$tableTiendas['idTienda']:''; ?>">
                </div>
    </div>
    <div class="modal-footer">
    <button type="submit" class="btn btn-raised btn-primary" style="position:relative; float:right; right:20px;" id="cargaCSV" name="cargaCSV" ng-click="cargaCSV()">Actualizar Productos</button>
        <button type="button"  data-dismiss="modal" class="btn  btn-info" style="right:20px;"><?php echo lang('reg_btn_cancelar') ?></button>
    </div>
</form><br><br>
