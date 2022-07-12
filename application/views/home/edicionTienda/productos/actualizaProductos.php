<form role="form" enctype="multipart/form-data"  ng-controller="gestionTienda" ng-init="initProductos()" id="formulario" ng-submit="actualizaProductos(<?php echo $ver ?>)">    
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">Actualiza Productos</h2>
        <p class="text-justify">En este modulo se podra actualizar productos al mismo tiempo</p>
    </div>
    <div class="modal-body">    
        <p> Para realizar la actualización masiva de los productos, es necesario descargar el siguiente documento y realizar los respectivos cambio.
            <?php if ($_SESSION['project']['info']['idPerfil'] == 6){?>
                <button title="Exportar excel" ng-click="xportExcel()"><i class="fa fa-file-excel"></i></button><!-- boton exportar excel customers o usuarios en administrador-->
            <?php } ?>
        </p>
            <p> Una vez tenga el archivo actualizado, realice nuevamente el cargue del mismo.</p>
            <form role="form" name="logos" method="POST" id="datalogos" ng-submit="procesaDatalogos()">
                    <div class="row">
                    <div class="col col-lg-12 col-md-12" style="border-right:1px solid #E1E1E1">
                        <div class="row">
                            <button class="btn btn-primary">
                                <input type="file" id="logoTienda" name ="logoTienda"value="">
                            </button><br> <p style=" position:relative; float:left; left:20px;"> Antes de hacer el cargue de archivo, por favor verifique que los cambios estén correctos.</p><br> 
                            <!-- vista de logo -->
                            <div id="visorLogo" style="width: 150px; height: 50px; margin:20px;"> </div>
                            <button type="submit" class="btn btn-raised btn-primary" style="position:relative; float:right; right:20px;" id="Productos" name="Productos" ng-click="cargaProductos()">Actualizar Productos</button>   
                        </div>
                    </div>
                    <input type="hidden" name="idTienda" value="<?php echo (isset($infoTienda['idTienda']))?$infoTienda['idTienda']:''; ?>">
                </div>
            </form>
    </div>
    <div class="modal-footer">
        <button type="button"  data-dismiss="modal" class="btn  btn-info"><?php echo lang('reg_btn_cancelar') ?></button>
    </div>
</form>
