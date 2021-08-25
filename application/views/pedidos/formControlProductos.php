<form role="form"  ng-controller="pedidos" id="formAgregaProductos" ng-init="misPedidosInit()" ng-submit="procesaPedido(<?php echo $edita ?>)">    
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h2 class="modal-title"><?php echo $titulo ?></h2>
    <p class="text-justify">
      Seleccione los productos que desea agregar al pedido
    </p>
  </div>
    <div class="modal-body">    

        <div class="row">
          <div class="col col-lg-12">
              <div class="form-group label-floating">
                <label class="control-label" for="idProducto">Seleccione el producto</label>
                <select tabindex="1"  id="idProducto" name="idProducto" class="form-control" ng-model='idProducto' ng-change="getPresentacionesProd()">
                    <option value="">Seleccione un producto</option>
                  <?php foreach($productos as $prod){ ?>
                      <option value="<?php echo $prod['idProducto'] ?>"><?php echo $prod['nombreProducto'] ?></option>
                  <?php } ?>
                </select>
              </div> 
          </div>

          <div class="col col-lg-12" id="listadoPresentaciones">
            
          </div>
  </div>
  <div class="modal-footer">
    <button type="button"  data-dismiss="modal" class="btn  btn-default">TERMINAR</button>
    <?php if(getPrivilegios()[0]['crear'] == 1 && $edita == 0){ ?>
      <button type="submit" class="btn btn-raised btn-primary"><?php echo $labelBtn ?></button>
    <?php } ?>
    
    <?php if(getPrivilegios()[0]['editar'] == 1 && $edita == 1){ ?>
      <button type="submit" class="btn btn-raised btn-primary"><?php echo $labelBtn ?></button>
    <?php } ?>

  </div>
</form>