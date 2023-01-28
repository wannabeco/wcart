<form role="form"  ng-controller="gestionTienda" ng-init="initBanner()" id="formulario"   ng-submit="procesaBanner(<?php echo $edita ?>,'<?php echo lang('lbl_confirm')?>')">    
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h2 class="modal-title">New Banner</h2>
      <p class="text-justify">
        <?php echo lang("text1")?>
      </p>
  </div>

  <div class="modal-body">  
      <h3 style="margin:0 0 20px 0;font-weight:bold">Banner name</h3>
      <div class="form-group  label-floating">
          <label class="control-label" for="tituloBanner">Banner name</label>
            <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="tituloBanner" name="tituloBanner"  class="form-control" value="<?php echo (isset($datos['tituloBanner']))?$datos['tituloBanner']:''; ?>" type="text">
        <p class="help-block"></p>
        <input type="hidden" name="idBanner" id="idBanner" value="<?php echo $idBanner?>" >
      </div>
    <!-- foto del banner -->
      <h3 style="margin:0 0 20px 0;font-weight:bold">Banner Photo<small><br><?php echo lang("text19.2")?></small></h3>      
      <div class="form-group" style="position:relative">
          <div id="preloaderfoto3" style="display:none;position:absolute"><img src="<?php echo base_url()?>res/img/preloader.gif" alt="" width="100%"></div>
          <small>
            <strong>Banner photo</strong>
          </small><br>
          <?php if(isset($datos['fotoBanner']) && $datos['fotoBanner'] != ""){?>
              <img style="cursor:pointer" src="<?php echo base_url()?>assets/uploads/files/<?php echo $_SESSION['project']['info']['idTienda'] ?>/<?php echo $datos['fotoBanner']?>" id="botonfoto3" width="20%"  alt="">
          <?php }else{?>
              <img src="<?php echo base_url()?>res/img/cargaFoto.png" id="botonfoto3" width="20%"  alt="" style="cursor:pointer" >
          <?php }?>
          <input type="file" name="fotoFile3" id="fotoFile3" style="visibility:hidden" onchange="angular.element(this).scope().uploadFoto('fotoFile3','fotoBanner','botonfoto3','preloaderfoto3')">
          <input type="hidden" name="fotoBanner" id="fotoBanner" value="<?php echo (isset($datos['fotoBanner']))?$datos['fotoBanner']:''; ?>"  data-validation="<?php echo lang("text29")?>">
      </div>
      <!-- tipo de banner -->
      <div class="form-group label-floating">
          <label class="control-label" for="tipoLink">Tipo Banner</label>
          <select onchange="angular.element(document.getElementById('formulario')).scope().cambiaElemento()" name="tipoLink" id="tipoLink"  class="form-control">                               
                  <option  selected disabled value="0">Selecciones el Tipo de banner</option>
                  <option <?php if(isset($datos['tipoLink']) && $datos['tipoLink'] == "producto"){ ?>selected<?php } ?>  value="producto">producto</option>
                  <option <?php if(isset($datos['tipoLink']) && $datos['tipoLink'] == "url"){ ?>selected<?php } ?>  value="url">url</option>
          </select>
      </div> 

      <div class="form-group  label-floating elementos link">
          <label class="control-label" for="linkBanner">link Banner</label>
          <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="linkBanner" name="linkBanner"  class="form-control" value="<?php echo (isset($datos['linkBanner']))?$datos['linkBanner']:''; ?>" type="text">
          <p class="help-block"></p>
      </div>

      <!-- select de productos -->
     
        <!-- categoria -->
      
              <div class="form-group  label-floating elementos productos">
                  <label class="control-label" for="idProducto"><?php echo lang("text2")?> *</label>
                  <select tabindex="2" id="idProducto" name="idCategoria"  class="form-control"  onchange="angular.element(document.getElementById('formulario')).scope().buscarSubCategorias(<?php echo $persistencia?>)">
                    <option value=""></option>
                    <?php foreach($selects['categorias'] as $catList){?>
                    <option <?php if(isset($datos['idCategoria']) && $datos['idCategoria'] == $catList['idProducto']){ ?>selected<?php } ?> value="<?php echo $catList['idProducto']?>"><?php echo $catList['nombreProducto']?></option>
                    <?php }?>
                  </select>
              </div>

          <!-- subcategorias -->

              <div class="form-group label-floating elementos productos" id="subcaSel" >
                    <label class="control-label" for="idSubcategoria"><?php echo lang("text3")?> *</label>
                      <select tabindex="2" autocomplete="off" id="idSubcategoria" name="idSubcategoria"  class="form-control" disabled onchange="angular.element(document.getElementById('formulario')).scope().getProductos(<?php echo $Subcatecorias?>)" ng-model="idSubcategoria">
                        <option value=""></option>
                      </select>
                </div>

              <!-- producto -->
          <div class="form-group label-floating elementos productos" id="productosSel">
            <label class="control-label" for="idPresentacion">Producto*</label>
                <select tabindex="2" autocomplete="off" id="idPresentacion" name="idPresentacion"  class="form-control" disabled>
                    <option value=""></option>
                </select>
              <p class="help-block">Seleccione el producto al que corresponde el banner</p>
              <br>
          </div>


      <!-- <div class="form-group  label-floating">
      <label class="control-label" for="orden">Orden de banner</label>
            <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="orden" data-validation="<?php echo "orden is required"?>" name="orden"  class="form-control" value="<?php echo (isset($datos['orden']))?$datos['orden']:''; ?>" type="number">
      </div><br>
       -->

      <p class="text-justify">
        <?php echo lang("text42")?><br><br>
      </p>
  </div>
  <div class="modal-footer">
    <button type="button"  data-dismiss="modal" class="btn  btn-default"><?php echo lang('reg_btn_cancelar') ?></button>
    <?php if(getPrivilegios()[0]['crear'] == 1 && $edita == 0){ ?>
      <button type="submit" class="btn btn-raised btn-primary" ><?php echo $labelBtn ?></button>
    <?php } ?>
    <?php if(getPrivilegios()[0]['editar'] == 1 && $edita == 1){ ?>
      <button type="submit" class="btn btn-raised btn-primary" ><?php echo $labelBtn ?></button>
    <?php } ?>
  </div>
</form>
<style>
  .elementos{
    display:none;
  }
  #fotoFile3:hover{ cursor:pointer};
</style>
<script type="text/javascript">
  <?php if($edita == 1){ ?>
    $(document).ready(function(){

      angular.element(document.getElementById('formulario')).scope().buscarSubCategorias('<?php echo $datos['idSubcategoria']?>');
      angular.element(document.getElementById('formulario')).scope().cambiaElemento();
      setTimeout(function() 
      {
        angular.element(document.getElementById('formulario')).scope().getProductos('<?php echo $datos['idPresentacion']?>');
      }, 1000);
    });
  <?php }?>
  //se buscan las subcategorias
  function buscarSubCategorias(id)
  {
    angular.element(document.getElementById('formulario')).scope().buscarSubCategorias(id);
  }

</script>