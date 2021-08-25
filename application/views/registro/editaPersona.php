<form role="form"  ng-controller="registroEmpresas" ng-init="registroInit()" id="formAgregaModulo" ng-submit="procesoEditaData()">    
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h2 class="modal-title"><?php echo $titulo ?></h2>
    <p class="text-justify">
      En este módulo podrás editar la información del cliente.
    </p>
  </div>
  <div class="modal-body">        
      <div class="col-lg-12">
           <div class="form-group">
            <label>Nombres</label>
            <input tabindex="1" id="nombre" name="nombre"  class="ember-view cajasRegistro ember-text-field form-control login-input" type="text" value="<?php if(isset($datos['nombre']) && $datos['nombre'] != ""){ echo $datos['nombre']; }?>">
          </div>
      </div>
      <div class="col-lg-12">
           <div class="form-group">
            <label>Apellidos</label>
            <input tabindex="1" id="apellido" name="apellido" class="ember-view cajasRegistro ember-text-field form-control login-input"  type="text" value="<?php if(isset($datos['apellido']) && $datos['apellido'] != ""){ echo $datos['apellido']; }?>">
          </div>
      </div>
      <div class="col-lg-12">
           <div class="form-group">
            <label>Correo</label>
            <input tabindex="1" id="email" name="email" class="ember-view cajasRegistro ember-text-field form-control login-input"  type="email" value="<?php if(isset($datos['email']) && $datos['email'] != ""){ echo $datos['email']; }?>">
          </div>
      </div>
      <div class="col-lg-12">
           <div class="form-group">
            <label>Celular</label>
            <input tabindex="1" id="celular" name="celular" class="ember-view cajasRegistro ember-text-field form-control login-input"  type="number" value="<?php if(isset($datos['celular']) && $datos['celular'] != ""){ echo $datos['celular']; }?>">
          </div>
      </div>
      <div class="col-lg-12">
           <div class="form-group">
            <label>Vendedora</label>
            <select class="ember-view cajasRegistro ember-text-field form-control login-input" id="idPadre" name="idPadre">
                  <option value="">Seleccione la vendedora</option>
                  <?php foreach($vendedoras  as $vende){?>
                    <option <?php if(isset($datos['idPersona']) && $datos['idPadre'] == $vende['idPersona']){ ?>selected<?php }?> value="<?php echo $vende['idPersona']?>"><?php echo $vende['nombre']?> <?php echo $vende['apellido']?></option>
                  <?php }?>
              </select>
          </div>
      </div>
      <div class="col-lg-12">
           <div class="form-group">
            <label>Conjunto</label>
            <select class="ember-view cajasRegistro ember-text-field form-control login-input" id="conjunto" name="idConjunto">
                  <option value="">Seleccione el conjunto residencial</option>
                  <?php foreach($conjuntos as $conju){?>
                    <option <?php if(isset($datos['idConjunto']) && $datos['idConjunto'] == $conju['idConjunto']){ ?>selected<?php }?> value="<?php echo $conju['idConjunto']?>"><?php echo $conju['nombreConjunto']?></option>
                  <?php }?>
              </select>
          </div>
      </div><!-- 
      <div class="col-lg-12">
           <div class="form-group">
            <input tabindex="1" id="direccion" name="direccion" ng-model="direccion" class="ember-view cajasRegistro ember-text-field form-control login-input" placeholder="Torre y apartamento" type="text" value="<?php if(isset($datos['']) && $datos[''] != ""){ echo $datos[''] ;}?>">
          </div>
      </div> -->
      <div class="col-lg-12">
           <div class="form-group">
            <label>Torre</label>
            <input tabindex="1" id="torre" style="text-transform: uppercase;" name="torre"  class="ember-view cajasRegistro ember-text-field form-control login-input" type="text" value="<?php if(isset($datos['torre']) && $datos['torre'] != ""){ echo $datos['torre']; }?>">
          </div>
      </div>
      <div class="col-lg-12">
            <label>Apartamento</label>
           <div class="form-group">
            <input tabindex="1" id="apto" name="apto"  style="text-transform: uppercase;"  class="ember-view cajasRegistro ember-text-field form-control login-input" type="text" value="<?php if(isset($datos['apto']) && $datos['apto'] != ""){ echo $datos['apto']; }?>">
          </div>
          <input type="hidden" name="idPersona" value="<?php echo $datos['idPersona']?>"> 
          <input type="hidden" name="movil" value="1"> 
      </div>


  </div>
  <div class="modal-footer">
    <button type="button"  data-dismiss="modal" class="btn  btn-default"><?php echo lang('reg_btn_cancelar') ?></button>
    
      <button type="submit" class="btn btn-raised btn-primary"><?php echo $labelBtn ?></button>
    

  </div>
</form>