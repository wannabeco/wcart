<form role="form" enctype="multipart/form-data"  ng-controller="gestionTienda" ng-init="initProductos()" id="formulario" ng-submit="cargaProductosMasivos()">    
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">Carga productos masivos</h2>
        <p class="text-justify">En este modulo se podra cargar productos al mismo tiempo.</p>
    </div>
    <div class="modal-body">    
        <p> Para realizar la el cargue masivo de productos, es necesario descargar el siguiente documento y ingrese los productos.
            <?php if ($_SESSION['project']['info']['idPerfil'] == 6){?>
                <a href="<?php echo base_url()?>res/archivos/ProductosMasivos.xlsx" download class="fa fa-file-excel fa-2x" style="with: 10px;" title="Exportar excel"></a>
            <?php } ?>
        </p><br>
            <p class="col col-lg-12">Antes de continuar, es necesario que seleccione la categoría y subcategoría a la cual realizara el cargue del producto.</p>
            <div class="row">
                 <div class="col col-lg-6 col-md-6">
                    <div class="form-group  label-floating">
                        <label class="control-label" for="idProducto"><?php echo lang("text2")?> *</label>
                          <select tabindex="2" id="idProducto" name="idProducto"  class="form-control"  onchange="buscarSubCategorias(<?php echo $persistencia?>)">
                            <option value=""></option>
                            <?php foreach($selects['categorias'] as $catList){?>
                              <option value="<?php echo $catList['idProducto']?>"><?php echo $catList['nombreProducto']?></option>
                            <?php }?>
                          </select>
                    </div>
                 </div>
                 <div class="col col-lg-6 col-md-6">
                    <div class="form-group label-floating" id="subcaSel">
                        <label class="control-label" for="idSubcategoria"><?php echo lang("text3")?> *</label>
                          <select tabindex="2" autocomplete="off" id="idSubcategoria" name="idSubcategoria"  class="form-control" disabled>
                            <option value=""></option>
                          </select>
                    </div>
                 </div>
               </div>
            
                <p class="col col-lg-12">Una vez tenga el archivo terminado, realice seleccione el documento a continuación</p>
                <div class="row">
                    <div class="col col-lg-12 col-md-12">
                        <div class="row">
                            <button class="btn btn-primary">
                                <input type="file" id="csv_file" name ="csv_file">   
                            </button><br> 
                            <p class="col col-lg-12" style=" position:relative; float:left; left:20px;"> 
                            Antes de hacer el cargue de archivo, por favor verifique que los campos estén correctos y el formato de Excel este en <strong>.CSV</strong>.
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
        <button type="submit" class="btn btn-raised btn-primary" style="position:relative; float:right; right:20px;" id="cargaCSV" name="cargaCSV" ng-click="cargaCSV()">Cargar Productos</button>
        <button type="button"  data-dismiss="modal" class="btn  btn-info" style="right:20px;"><?php echo lang('reg_btn_cancelar') ?></button>
    </div>
</form><br><br>
<script type="text/javascript">
  <?php if($ver == 1){?>
    $(document).ready(function(){
      angular.element(document.getElementById('formulario')).scope().buscarSubCategorias('<?php echo $datos['idSubcategoria']?>');
      //angular.element(document.getElementById('formulario')).scope().activaVariacion();
    });
  <?php }?>
  function buscarSubCategorias(id)
  {
    angular.element(document.getElementById('formulario')).scope().buscarSubCategorias(id);
  }
</script>