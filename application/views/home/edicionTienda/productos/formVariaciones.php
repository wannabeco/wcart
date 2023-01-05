<form role="form" enctype="multipart/form-data"  ng-controller="gestionTienda" ng-init="initVariaciones()" id="formulario" ng-submit="procesaVariaciones()">    
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h2 class="modal-title"><?php echo $titulo ?></h2>
      <p class="text-justify">
        <?php echo lang("lbl_caracteristicas")?> <?php echo $infoProducto['nombrePresentacion']?>
      </p>
  </div>
  <div class="modal-body">
        <div id="contVariaciones">
            <?php foreach($variaciones as $datos){?>
               <div class="row variacionesList" data-idvariacion="<?php echo $datos['idVariacion']?>" data-nueva="0" id="panelVariacion<?php echo $datos['idVariacion']?>">
                  <div class="col col-lg-12 col-md-12">
                    <br><button type="button" class="close" title="Eliminar esta variación" ng-click="eliminaVariacion(<?php echo $datos['idVariacion']?>)">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="col col-lg-6 col-md-6">
                      <div class="form-group  label-floating">
                          <label class="control-label" for="nombreVariacion"><?php echo lang("text21")?></label>
                            <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="nombreVariacion<?php echo $datos['idVariacion']?>" name="nombreVariacion"  class="form-control" value="<?php echo (isset($datos['nombreVariacion']))?$datos['nombreVariacion']:''; ?>" type="text">
                      </div>
                   </div>
                   <div class="col col-lg-6 col-md-6">
                      <div class="form-group  label-floating">
                          <label class="control-label" for="valorPresentacion"><?php echo lang("text22")?> *</label>
                            <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="valorPresentacion<?php echo $datos['idVariacion']?>" name="valorPresentacion"  class="form-control" value="<?php echo (isset($datos['valorPresentacion']))?$datos['valorPresentacion']:''; ?>" type="text">
                      </div>
                   </div>
                   <!-- <div class="col col-lg-4 col-md-4">
                      <div class="form-group  label-floating">
                          <label class="control-label" for="valorAntes<?php echo $datos['idVariacion']?>">Valor anterior</label>
                            <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="valorAntes<?php echo $datos['idVariacion']?>" name="valorAntes"  class="form-control" value="<?php echo (isset($datos['valorAnterior']))?$datos['valorAnterior']:''; ?>" type="text">
                        <p class="help-block">Sin puntos, sin $. Sólo si aplica</p>
                      </div>
                   </div>
                   <div class="col col-lg-4 col-md-4">
                      <div class="form-group  label-floating">
                          <label class="control-label" for="variacion">Descuento</label>
                            <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="descuento<?php echo $datos['idVariacion']?>" name="descuento"  class="form-control" value="<?php echo (isset($datos['descuento']))?$datos['descuento']:''; ?>" type="text">
                        <p class="help-block">Sin puntos, sin %. Sólo si aplica</p>
                      </div>
                   </div> -->
               </div>
               <!-- <div style="height:1px;background:#ccc;width:100%"></div> -->
           <?php }?>
        </div>
       <input type="hidden" id="idPresentacion" value="<?php echo $idPresentacion?>">
  </div>
  <div class="modal-footer">
    <button type="button"  data-dismiss="modal" class="btn  btn-default"><?php echo lang('reg_btn_cancelar') ?></button>
    <?php if(getPrivilegios()[0]['crear'] == 1 && $edita == 0){ ?>
      <button type="button" ng-click="agregarVariacion()" class="btn btn-raised btn-info"><?php echo lang("btn_agregar")?></button>
    <?php } ?>
    <?php if(getPrivilegios()[0]['crear'] == 1 && $edita == 0){ ?>
      <button type="submit" class="btn btn-raised btn-primary"><?php echo $labelBtn ?></button>
    <?php } ?>
    <?php if(getPrivilegios()[0]['editar'] == 1 && $edita == 1){ ?>
      <button type="submit" class="btn btn-raised btn-primary"><?php echo $labelBtn ?></button>
    <?php } ?>
  </div>
</form>
<style>
  .variacionesList:nth-child(even) {background: #f6f6f6}
  .variacionesList:nth-child(odd) {background: #ffffff}
</style>