<form role="form" enctype="multipart/form-data"  ng-controller="gestionTienda" ng-init="initProductos()" id="formulario" data-infoTienda ='<?php echo (json_encode($tableTiendas));?>' ng-submit="cargaArchivo()">    
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">Carga masiva de imagenes</h2>
        <p class="text-justify">En este modulo se podra cargar todas las fotos que represente a los productos anteriormente cargados</p>
    </div>
    <div class="modal-body">    
        <div class="row">
            <div class="col col-lg-12 col-md-12">
                <div class="row">                
                    <div class="file-select" id="src-file1" >
                        <input type="file" id="imagenes" name ="imagenes[]" multiple value=""><br>
                    </div><br>
                    <p style=" position:relative; float:left; left:20px; margin-top:20px; rigth:20px; width: 95%;" class="col-md-12 text-justify"> 
                        Antes de realizar el cargue de fotos automaticos, asegurate de estar en los siguientes extenciones: <strong>.JPG, .PNG, .GIF, .JPEG</strong>, es importante recordar que solo se pueden un maximo de 10 archivos por carga.
                    </p><br> 
                    <button type="submit" class="btn btn-raised btn-primary" style="position:relative; float:right; right:20px;" id="cargarImagenes" name="cargarImagenes" ng-click="cargarImagenes()">Cargar imagenes</button>   
                </div>
            </div>
            <input type="hidden" name="idTienda" value="<?php echo (isset($tableTiendas['idTienda']))?$tableTiendas['idTienda']:''; ?>">
        </div>
    </div>
    
    <div class="modal-footer">
        <button type="button"  data-dismiss="modal" class="btn  btn-info"><?php echo lang('reg_btn_cancelar') ?></button>
    </div>
</form>


