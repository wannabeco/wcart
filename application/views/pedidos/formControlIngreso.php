<form role="form"  ng-controller="ingresoProducto" id="formAgregaInventario" ng-init="initIngresoProduco()" ng-submit="procesaStockProducto(<?php echo $edita ?>)">    
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h2 class="modal-title"><?php echo $titulo ?></h2>
    <p class="text-justify">
      Complete el formulario para registrar la información del stock de producto
    </p>
  </div>
    <div class="modal-body">    
        <h4>DATOS DEL PRODUCTO</h4>
          <div class="row">
              <div class="col col-lg-6">
                  <div class="form-group label-floating">
                    <label class="control-label" for="idProducto">Seleccione el producto</label>
                    <select tabindex="1"  id="idProducto" name="idProducto" class="form-control">
                        <option value="">Seleccione un producto</option>
                      <?php foreach($productos as $prod){ ?>
                          <option value="<?php echo $prod['idProducto'] ?>" <?php if(isset($datos['idProducto']) && $datos['idProducto'] == $prod['idProducto']){ ?>selected <?php }?>><?php echo $prod['nombreProducto'] ?></option>
                      <?php } ?>
                    </select>
                  </div> 
              </div>
              <div  class="col col-lg-6">
                <div class="form-group  label-floating">
                    <label class="control-label" for="idRemision">Id Remisión</label>
                      <input tabindex="2" autocomplete="off" id="idRemision" name="idRemision"  class="form-control" value="<?php echo (isset($datos['idRemision']))?$datos['idRemision']:''; ?>" type="text">
                  <p class="help-block"></p>
                </div>
              </div>

              <div  class="col col-lg-6">
                <div class="form-group  label-floating">
                    <label class="control-label" for="cantidadKilos">Cantidad Kilos</label>
                      <input tabindex="2" autocomplete="off" id="cantidadKilos" name="cantidadKilos"  class="form-control" value="<?php echo (isset($datos['cantidadKilos']))?$datos['cantidadKilos']:''; ?>" type="text">
                  <p class="help-block"></p>
                </div>
              </div>
              
              <div  class="col col-lg-6">
                <div class="form-group  label-floating">
                    <label class="control-label" for="cantidadCajas">Cantidad Cajas</label>
                      <input tabindex="2" autocomplete="off" id="cantidadCajas" name="cantidadCajas"  class="form-control" value="<?php echo (isset($datos['cantidadCajas']))?$datos['cantidadCajas']:''; ?>" type="text">
                  <p class="help-block"></p>
                </div>
              </div>
              
              <div  class="col col-lg-12">
                <div class="form-group  label-floating">
                    <label class="control-label" for="observaciones">Observaciones</label>
                      <input tabindex="2" autocomplete="off" id="observaciones" name="observaciones"  class="form-control" value="<?php echo (isset($datos['observaciones']))?$datos['observaciones']:''; ?>" type="text">
                  <p class="help-block"></p>
                </div>
              </div>

      </div>

              <h4>DATOS DEL LA PERSONA QUE ENTREGA</h4>
          <div class="row">
              <div  class="col col-lg-6">
                <div class="form-group  label-floating">
                    <label class="control-label" for="cedulaPersona">Documento de identidad</label>
                      <input tabindex="2" autocomplete="off" id="cedulaPersona" name="cedulaPersona"  class="cajasOcultas form-control" value="<?php echo (isset($datos['cedulaPersona']))?$datos['cedulaPersona']:''; ?>" type="text" ng-blur="buscaPersonaEntrega()">
                  <p class="help-block"></p>
                </div>
              </div>
              <div  class="col col-lg-6">
                <div class="form-group  label-floating">
                    <label class="control-label" for="nombrePersona">Nombre Persona</label>
                      <input tabindex="2" autocomplete="off" id="nombrePersona" name="nombrePersona"  class="cajasOcultas form-control" value="<?php echo (isset($datos['nombrePersona']))?$datos['nombrePersona']:''; ?>" type="text" disabled="disabled">
                  <p class="help-block"></p>
                </div>
              </div>

              <div  class="col col-lg-6">
                <div class="form-group  label-floating">
                    <label class="control-label" for="apellidoPersona">Apellido Persona</label>
                      <input tabindex="2" autocomplete="off" id="apellidoPersona" name="apellidoPersona"  class="cajasOcultas form-control" value="<?php echo (isset($datos['apellidoPersona']))?$datos['apellidoPersona']:''; ?>" type="text" disabled="disabled">
                  <p class="help-block"></p>
                </div>
              </div>

              <div  class="col col-lg-6">
                <div class="form-group  label-floating">
                    <label class="control-label" for="celularPersona">Número de celular</label>
                      <input tabindex="2" autocomplete="off" id="celularPersona" name="celularPersona"  class="cajasOcultas form-control" value="<?php echo (isset($datos['celularPersona']))?$datos['celularPersona']:''; ?>" type="text" disabled="disabled">
                  <p class="help-block"></p>
                </div>
              </div>

              <input type="hidden" name="idPersonaEntrega" id="idPersonaEntrega"  value="<?php echo (isset($datos['idPersonaEntrega']))?$datos['idPersonaEntrega']:''; ?>">
              <input type="hidden" name="edita" id="edita" value="<?php echo $edita ?>">
              <input type="hidden" name="idInventario" id="idInventario" value="<?php echo $idInventario ?>">
          </div>
  </div>
  <div class="modal-footer">
    <button type="button"  data-dismiss="modal" class="btn  btn-default">CANCELAR</button>
    <?php if(getPrivilegios()[0]['crear'] == 1 && $edita == 0){ ?>
      <button type="submit" class="btn btn-raised btn-primary"><?php echo $labelBtn ?></button>
    <?php } ?>
    
    <?php if(getPrivilegios()[0]['editar'] == 1 && $edita == 1){ ?>
      <button type="submit" class="btn btn-raised btn-primary"><?php echo $labelBtn ?></button>
    <?php } ?>

  </div>
</form>
<script type="text/javascript">
  <?php if($edita == 1){ ?>
  $(document).ready(function(){
    $('.cajasOcultas').removeAttr('disabled');
  });
<?php } ?>
</script>