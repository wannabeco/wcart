<form role="form"  ng-controller="registroEmpresas" ng-init="registroInit()" id="formAgregaModulo" ng-submit="guardaLlamadas(<?php echo $datos['idPersona']?>)">    
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h2 class="modal-title"><?php echo $titulo ?></h2>
    <p class="text-justify">
     Realizar seguimiento al usuario para saber su experiencia con el producto entregado.
    </p>
  </div>
  <div class="modal-body">        
      
      <div class="col-lg-12">
           <div class="form-group">
            <label>Observaciones</label>
            <textarea tabindex="1" id="observaciones" name="observaciones" placeholder="Escribe aquí las observaciones del usuario"  class="ember-view cajasRegistro ember-text-field form-control login-input" ></textarea>
          </div>
      </div>

      <div class="col-lg-12">
           <div class="form-group">
            <label>¿Agendar llamada para otro día?</label>
            <input tabindex="1" id="fechaLlamada" name="fechaAgenda" placeholder="Selecciona la fecha a agendar aquí"  class="ember-view cajasRegistro ember-text-field form-control login-input" type="text">
          </div>
          <input type="hidden" name="idPersona" value="<?php echo $datos['idPersona']?>">
      </div>


  </div>
  <div class="modal-footer">
    <button type="button"  data-dismiss="modal" class="btn  btn-default"><?php echo lang('reg_btn_cancelar') ?></button>
    
      <button type="submit" class="btn btn-raised btn-primary"><?php echo $labelBtn ?></button>
    

  </div>
</form>