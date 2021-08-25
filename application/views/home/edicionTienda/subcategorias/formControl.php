<form role="form"  ng-controller="gestionTienda" ng-init="initSubcategorias()" id="formulario" ng-submit="procesaSubCategoria(<?php echo $edita ?>)">    
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h2 class="modal-title"><?php echo $titulo ?></h2>
      <p class="text-justify">
        Completa la información para poder editar o crear una subcategoría
      </p>
  </div>
  <div class="modal-body">    
      <div class="form-group  label-floating">
          <label class="control-label" for="idProducto">Categoría</label>
            <select tabindex="2" autocomplete="off" id="idProducto" name="idProducto"  class="form-control">
              <option value=""></option>
              <?php foreach($selects['categorias'] as $catList){?>
                <option <?php if(isset($datos['idProducto']) && $datos['idProducto'] == $catList['idProducto']){ ?>selected<?php } ?> value="<?php echo $catList['idProducto']?>"><?php echo $catList['nombreProducto']?></option>
              <?php }?>
            </select>
            <p class="help-block">Seleccione la categoría a la que pertenecera</p>

      </div>
      <div class="form-group  label-floating">
          <label class="control-label" for="nombreSubcategoria">Nombre de la subcategoria</label>
            <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="nombreSubcategoria" name="nombreSubcategoria"  class="form-control" value="<?php echo (isset($datos['nombreSubcategoria']))?$datos['nombreSubcategoria']:''; ?>" type="text">
        <p class="help-block"></p>
        <input type="hidden" name="idSubcategoria" value="<?php echo $idProducto?>">

      </div>
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