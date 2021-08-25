<form role="form"  ng-controller="registroEmpresas" ng-init="registroInit()" id="formPedidoExterno" ng-submit="realizaPedidoExterno()">    
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h2 class="modal-title"><?php echo $titulo ?></h2>
    <p class="text-justify">
      Realiza un pedido a nombre del usuario
    </p>
  </div>
  <div class="modal-body"> 
      <div class="col-lg-12">
           <div class="form-group">
            <label>Cantidad de kilos a comprar</label>
            <input tabindex="1" id="cantidad" name="cantidad" class="ember-view cajasRegistro ember-text-field form-control login-input"  type="text" value="1">

            <input type="hidden" id="idPersona" name="idPersona" value="<?php echo $datos['idPersona']?>"> 
            <input type="hidden" id="movil" name="movil" value="1"> 

          </div>
      </div>


  </div>
  <div class="modal-footer">
    <button type="button"  data-dismiss="modal" class="btn  btn-default"><?php echo lang('reg_btn_cancelar') ?></button>
    
      <button type="submit" class="btn btn-raised btn-primary"><?php echo $labelBtn ?></button>
    

  </div>
</form>