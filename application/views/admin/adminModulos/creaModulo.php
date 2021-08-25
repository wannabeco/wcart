<form role="form"  ng-controller="modulosProcesador" id="formAgregaModulo" ng-submit="procesaModulos(<?php echo $edita ?>)">    
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h2 class="modal-title"><?php echo $titulo ?></h2>
    <p class="text-justify">
      Los módulos son los encargados de lograr el funcionamiento de la aplicación, estos deben ser creados por programadores con experiencia en codeigniter.
    </p>
  </div>
  <div class="modal-body">        
    <div class="form-group">
      <input tabindex="1" autocomplete="off" id="nombreModulo" name="nombreModulo"  class="ember-view ember-text-field form-control login-input" value="<?php echo (isset($datos['nombreModulo']))?$datos['nombreModulo']:''; ?>" placeholder="Escriba nombre del módulo"  type="text">
      <p class="help-block">Nombre que identificará el módulo</p>
    </div>        
    <div class="form-group">
      <input tabindex="1" autocomplete="off" id="urlModulo" name="urlModulo"  class="ember-view ember-text-field form-control login-input" value="<?php echo (isset($datos['urlModulo']))?$datos['urlModulo']:''; ?>" placeholder="Escriba la ruta del controlador del módulo"  type="text">
      <p class="help-block">Ruta donde está la lógica de programación del módulo</p>
    </div> 
    <?php if($edita == 1){ ?>
    <div class="form-group">
      <select class=" form-control" id="estado" name="estado">
        <option value="1" <?php if($datos['estado'] == 1){?>selected<?php }?>>Activo</option>
        <option value="0" <?php if($datos['estado'] == 0){?>selected<?php }?>>Inactivo</option>
      </select>
      <p class="help-block">Ruta donde está la lógica de programación del módulo</p>
    </div> 
    <?php } ?>
    
      <div class="form-group">
        <input tabindex="1" autocomplete="off" id="idPadre" name="idPadre" value="<?php echo $padre ?>" type="hidden">
        <input tabindex="1" autocomplete="off" id="idEditar" name="idEditar" value="<?php echo $idEdita ?>" type="hidden">
        <p class="help-block">Ruta donde está la lógica de programación del módulo</p>
      </div> 
      <br>

    <p class="text-justify">
      Seleccione los perfiles que pueden ver este módulo y los provilegios que tendrá dentro del mismo.
    </p>
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th colspan="4" class="text-center">PRIVILEGIOS</th>
            </tr>
            <tr>
                <th>PERFILES</th>
                <th class="text-center">VER</th>
                <th class="text-center">CREAR</th>
                <th class="text-center">EDITAR</th>
                <th class="text-center">BORRAR</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($perfiles as $p){ ?>
              <tr class="modulosLista" rel="<?php echo $p['idPerfil'] ?>">
                  <td><?php echo $p['nombrePerfil'] ?></td>
                  <td class="text-center"><input type="checkbox" id="ver<?php echo $p['idPerfil'] ?>" value="1" <?php if(isset($p['ver']) && $p['ver'] == 1){ ?>checked="checked"<?php }?>></td>
                  <td class="text-center"><input type="checkbox" id="crear<?php echo $p['idPerfil'] ?>" value="1" <?php if(isset($p['crear']) && $p['crear'] == 1){ ?>checked="checked"<?php }?>></td>
                  <td class="text-center"><input type="checkbox" id="editar<?php echo $p['idPerfil'] ?>" value="1" <?php if(isset($p['editar']) && $p['editar'] == 1){ ?>checked="checked"<?php }?>></td>
                  <td class="text-center"><input type="checkbox" id="borrar<?php echo $p['idPerfil'] ?>" value="1" <?php if(isset($p['borrar']) && $p['borrar'] == 1){ ?>checked="checked"<?php }?>></td>
              </tr>
            <?php } ?>
        </tbody>
    </table>


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