<form role="form"  ng-controller="gestionTienda" ng-init="init()" id="formulario" ng-submit="procesaCategoria(<?php echo $edita ?>,'<?php echo lang('lbl_confirm')?>')">    
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h2 class="modal-title"><?php echo $titulo ?></h2>
      <p class="text-justify">
        <?php echo lang("text1")?>
      </p>
  </div>
  <div class="modal-body">  

    
      <h3 style="margin:0 0 20px 0;font-weight:bold"><?php echo lang("text23")?></h3>

      <div class="form-group  label-floating">
          <label class="control-label" for="nombreProducto"><?php echo lang("text27")?></label>
            <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="nombreProducto" data-validation="<?php echo lang("text28")?>" name="nombreProducto"  class="form-control" value="<?php echo (isset($datos['nombreProducto']))?$datos['nombreProducto']:''; ?>" type="text">
        <p class="help-block"></p>
        <input type="hidden" name="idProducto" value="<?php echo $idProducto?>">
      </div>


        

      <h3 style="margin:0 0 20px 0;font-weight:bold"><?php echo lang("text24")?> <small><?php echo lang("text19.2")?></small></h3>
    <div class="form-group" style="position:relative">
          <div id="preloaderfoto3" style="display:none;position:absolute"><img src="<?php echo base_url()?>res/img/preloader.gif" alt="" width="100%"></div>
        <small><strong><?php echo lang("lbl_photo_category")?></strong></small><br>
        <?php if(isset($datos['foto']) && $datos['foto'] != ""){?>
            <img style="cursor:pointer" src="<?php echo base_url()?>assets/uploads/files/<?php echo $datos['idTienda']?>/<?php echo $datos['foto']?>" id="botonfoto3" width="20%"  alt="">
        <?php }else{?>
            <img src="<?php echo base_url()?>res/img/cargaFoto.png" id="botonfoto3" width="20%"  alt="">
        <?php }?>
        <input type="file" name="fotoFile3" id="fotoFile3" style="visibility:hidden" onchange="angular.element(this).scope().uploadPic('fotoFile3','foto','botonfoto3','preloaderfoto3')">
        <input type="hidden" name="foto" id="foto" value="<?php echo (isset($datos['foto']))?$datos['foto']:''; ?>"  data-validation="<?php echo lang("text29")?>">
      </div>

      <p class="text-justify">
        <?php echo lang("text43")?><br><br>
      </p>
  </div>


  <div class="modal-footer">
    <button type="button"  data-dismiss="modal" class="btn  btn-default"><?php echo lang('reg_btn_cancelar') ?></button>
    <?php if(getPrivilegios()[0]['crear'] == 1 && $edita == 0){ ?>
      <button type="submit" class="btn btn-raised btn-primary"><?php echo $labelBtn ?></button>
    <?php } ?>
    <?php if(getPrivilegios()[0]['editar'] == 1 && $edita == 1){ ?>
      <button type="submit" class="btn btn-raised btn-primary"><?php echo $labelBtn ?></button>
    <?php } ?>
  </div>
</form>