<form role="form" enctype="multipart/form-data"  ng-controller="gestionTienda" ng-init="initProductos()" id="formulario" ng-submit="procesaProducto(<?php echo $edita ?>)">    
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h2 class="modal-title"><?php echo $titulo ?></h2>
      <p class="text-justify">
        <?php echo lang("text1")?>
      </p>
  </div>
  <div class="modal-body">

               <div class="row">
               <div class="col col-lg-12">
                        <h3 style="margin:0 0 20px 0;font-weight:bold"><?php echo lang("text19.3")?></h3>
                </div>
                 <div class="col col-lg-6 col-md-6">
                    <div class="form-group  label-floating">
                        <label class="control-label" for="idProducto"><?php echo lang("text2")?> *</label>
                          <select tabindex="2" id="idProducto" name="idProducto"  class="form-control"  onchange="buscarSubCategorias(<?php echo $persistencia?>)">
                            <option value=""></option>
                            <?php foreach($selects['categorias'] as $catList){?>
                              <option <?php if(isset($datos['idProducto']) && $datos['idProducto'] == $catList['idProducto']){ ?>selected<?php } ?> value="<?php echo $catList['idProducto']?>"><?php echo $catList['nombreProducto']?></option>
                            <?php }?>
                          </select>
                    </div>
                 </div>
                 <div class="col col-lg-6 col-md-6">
                    <div class="form-group label-floating" id="subcaSel">
                        <label class="control-label" for="idSubcategoria"><?php echo lang("text3")?> *</label>
                          <select tabindex="2" autocomplete="off" id="idSubcategoria" name="idSubcategoria"  class="form-control" disabled>
                            <option value=""></option>
                          </select>
                    </div>
                 </div>
               </div>


               <div class="row">
                 <div class="col col-lg-12 col-md-12">
                    <div class="form-group  label-floating">
                        <label class="control-label" for="nombrePresentacion"><?php echo lang("text4")?> *</label>
                          <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="nombrePresentacion" name="nombrePresentacion"  class="form-control" value="<?php echo (isset($datos['nombrePresentacion']))?$datos['nombrePresentacion']:''; ?>" type="text" >
                      <p class="help-block"></p>
                    </div>
                 </div>
               </div>

               <div class="row">

                 <div class="col col-lg-4 col-md-4">
                    <div class="form-group  label-floating">
                        <label class="control-label" for="codigoProducto"><?php echo lang("text5")?></label>
                          <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="codigoProducto" name="codigoProducto"  class="form-control" value="<?php echo (isset($datos['codigoProducto']))?$datos['codigoProducto']:''; ?>" type="text" >
                    </div>
                 </div>
                 <div class="col col-lg-4 col-md-4">
                    <div class="form-group  label-floating">
                        <label class="control-label" for="marca"><?php echo lang("text6")?> *</label>
                          <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="marca" name="marca"  class="form-control" value="<?php echo (isset($datos['marca']))?$datos['marca']:''; ?>" type="text">
                    </div>
                 </div>

                 <div class="col col-lg-4 col-md-4">
                    <div class="form-group  label-floating">
                        <label class="control-label" for="nuevo"><?php echo lang("text7")?></label>
                          <select tabindex="2" id="nuevo" name="nuevo"  class="form-control">
                            <!--<option value="No" <?php if(isset($datos['nuevo']) && $datos['nuevo'] =='No'){ ?>selected<?php } ?>>NOT</option>-->
                            <option value="No" <?php if(isset($datos['nuevo']) && $datos['nuevo'] =='No'){ ?>selected<?php } ?>>No</option>
                            <!--<option value="Si" <?php if(isset($datos['nuevo']) && $datos['nuevo'] =='Si'){ ?>selected<?php } ?>>YES</option>-->
                            <option value="Si" <?php if(isset($datos['nuevo']) && $datos['nuevo'] =='Si'){ ?>selected<?php } ?>>Si</option>
                          </select>
                    </div>
                 </div>

               </div>

               <div class="row">
                 <div class="col col-lg-12 col-md-12">
                    <div class="form-group  label-floating">
                        <label class="control-label" for="descripcionPres"><?php echo lang("text8")?> *</label>
                          <textarea tabindex="2" autocomplete="off" id="descripcionPres" name="descripcionPres" style="height:200px"  class="form-control" type="text" ><?php echo (isset($datos['descripcionPres']))?$datos['descripcionPres']:''; ?></textarea>
                      <!-- <p class="help-block">Breve información del producto para el cliente. 110 Caracteres</p> -->
                    </div>
                 </div>
               </div>
              
              <div class="row">

              <div class="col col-lg-12">
                      <h3 style="margin:0 0 20px 0;font-weight:bold"><?php echo lang("text19.1")?> <small><?php echo lang("text19.2")?></small></h3>
              </div>

                <div class="col col-lg-2 text-center" style="position:relative">
                  <div id="preloaderfoto1" style="display:none;position:absolute"><img src="<?php echo base_url()?>res/img/preloader.gif" alt="" width="100%"></div>
                  <small><strong><?php echo lang("lbl_main_photo")?></strong></small>
                  <?php if(isset($datos['fotoPresentacion']) && $datos['fotoPresentacion'] != ""){?>
                      <img style="cursor:pointer" src="<?php echo base_url()?>assets/uploads/files/<?php echo $datos['idTienda']?>/<?php echo $datos['fotoPresentacion']?>" id="botonfoto1" width="100%"  alt="">
                  <?php }else{?>
                      <img src="<?php echo base_url()?>res/img/cargaFoto.png" id="botonfoto1" width="100%"  alt="">
                  <?php }?>
                  <input type="file" name="fotoFile1" id="fotoFile1" style="visibility:hidden" onchange="angular.element(this).scope().uploadPic('fotoFile1','fotoPresentacion','botonfoto1','preloaderfoto1')">
                  <input type="hidden" name="fotoPresentacion" id="fotoPresentacion" value="<?php echo (isset($datos['fotoPresentacion']))?$datos['fotoPresentacion']:''; ?>">
                </div>

                <div class="col col-lg-2 text-center" style="position:relative">
                   <div id="preloaderfoto2" style="display:none;position:absolute"><img src="<?php echo base_url()?>res/img/preloader.gif" alt="" width="100%"></div>
                  <small><strong><?php echo lang("lbl_photo")?> 2</strong></small>
                  <?php if(isset($datos['foto2']) && $datos['foto2'] != ""){?>
                      <img style="cursor:pointer" src="<?php echo base_url()?>assets/uploads/files/<?php echo $datos['idTienda']?>/<?php echo $datos['foto2']?>" id="botonfoto2" width="100%"  alt="">
                  <?php }else{?>
                      <img src="<?php echo base_url()?>res/img/cargaFoto.png" id="botonfoto2" width="100%"  alt="">
                  <?php }?>
                  <input type="file" name="fotoFile2" id="fotoFile2" style="visibility:hidden" onchange="angular.element(this).scope().uploadPic('fotoFile2','foto2','botonfoto2','preloaderfoto2')">
                  <input type="hidden" name="foto2" id="foto2" value="<?php echo (isset($datos['foto2']))?$datos['foto2']:''; ?>">
                </div>

                <div class="col col-lg-2 text-center" style="position:relative">
                   <div id="preloaderfoto3" style="display:none;position:absolute"><img src="<?php echo base_url()?>res/img/preloader.gif" alt="" width="100%"></div>
                  <small><strong><?php echo lang("lbl_photo")?> 3</strong></small>
                  <?php if(isset($datos['foto3']) && $datos['foto3'] != ""){?>
                      <img style="cursor:pointer" src="<?php echo base_url()?>assets/uploads/files/<?php echo $datos['idTienda']?>/<?php echo $datos['foto3']?>" id="botonfoto3" width="100%"  alt="">
                  <?php }else{?>
                      <img src="<?php echo base_url()?>res/img/cargaFoto.png" id="botonfoto3" width="100%"  alt="">
                  <?php }?>
                  <input type="file" name="fotoFile3" id="fotoFile3" style="visibility:hidden" onchange="angular.element(this).scope().uploadPic('fotoFile3','foto3','botonfoto3','preloaderfoto3')">
                  <input type="hidden" name="foto3" id="foto3" value="<?php echo (isset($datos['foto3']))?$datos['foto3']:''; ?>">
                </div>

                <div class="col col-lg-2 text-center" style="position:relative">
                   <div id="preloaderfoto4" style="display:none;position:absolute"><img src="<?php echo base_url()?>res/img/preloader.gif" alt="" width="100%"></div>
                  <small><strong><?php echo lang("lbl_photo")?> 4</strong></small>
                  <?php if(isset($datos['foto4']) && $datos['foto4'] != ""){?>
                      <img style="cursor:pointer" src="<?php echo base_url()?>assets/uploads/files/<?php echo $datos['idTienda']?>/<?php echo $datos['foto4']?>" id="botonfoto4" width="100%"  alt="">
                  <?php }else{?>
                      <img src="<?php echo base_url()?>res/img/cargaFoto.png" id="botonfoto4" width="100%"  alt="">
                  <?php }?>
                  <input type="file" name="fotoFile4" id="fotoFile4" style="visibility:hidden" onchange="angular.element(this).scope().uploadPic('fotoFile4','foto4','botonfoto4','preloaderfoto4')">
                  <input type="hidden" name="foto4" id="foto4" value="<?php echo (isset($datos['foto4']))?$datos['foto4']:''; ?>">
                </div>

                <div class="col col-lg-2 text-center" style="position:relative">
                   <div id="preloaderfoto5" style="display:none;position:absolute"><img src="<?php echo base_url()?>res/img/preloader.gif" alt="" width="100%"></div>
                  <small><strong><?php echo lang("lbl_photo")?> 5</strong></small>
                  <?php if(isset($datos['foto5']) && $datos['foto5'] != ""){?>
                      <img style="cursor:pointer" src="<?php echo base_url()?>assets/uploads/files/<?php echo $datos['idTienda']?>/<?php echo $datos['foto5']?>" id="botonfoto5" width="100%"  alt="">
                  <?php }else{?>
                      <img src="<?php echo base_url()?>res/img/cargaFoto.png" id="botonfoto5" width="100%"  alt="">
                  <?php }?>
                  <input type="file" name="fotoFile5" id="fotoFile5" style="visibility:hidden" onchange="angular.element(this).scope().uploadPic('fotoFile5','foto5','botonfoto5','preloaderfoto5')">
                  <input type="hidden" name="foto5" id="foto5" value="<?php echo (isset($datos['foto5']))?$datos['foto5']:''; ?>">
                </div>

                    
                <div class="col col-lg-12">
                      <p class="text-justify">
                        <?php echo lang("text12")?><br><br>
                      </p>
                 </div>

              </div>



               <!-- <?php if($edita == 1){?>
                 <div class="row">
                   <div class="col col-lg-12 col-md-12">
                      <div class="form-group  label-floating">
                        <label class="control-label" for="fotoPresentacion"><?php echo lang("text9")?></label>
                        <img src="<?php echo base_url()?>assets/uploads/files/<?php echo $datos['idTienda']?>/<?php echo $datos['fotoPresentacion']?>" width="
                        20%"><br>
                        <input type="hidden" name="fotoActual"  value="<?php echo (isset($datos['fotoPresentacion']))?$datos['fotoPresentacion']:'';?>">
                        <p class="text-justify">
                          <?php echo lang("text10")?>
                        </p>
                      </div>
                   </div>
                 </div>
               <?php }else{?>
                  <input type="hidden" name="fotoActual"  value="">
               <?php }?> -->


               <!-- <div class="row">
                 <div class="col col-lg-12 col-md-12">
                    <div class="form-group  label-floating">
                      <label class="control-label" for="fotoPresentacion"><?php echo lang("text11")?></label>
                      <input type="file" class="file" id="fotoPresentacion" name="fotoPresentacion" /><br>
                      
                      <p class="text-justify">
                        <?php echo lang("text12")?>
                      </p>
                    </div>
                 </div>
               </div>
                -->
               <!-- <div class="row">
                  <div class="col col-lg-12 col-md-12"><br>
                    <h4><strong>¿El producto tiene variación? *</strong></h4>
                    <p>La variación de un producto es cuando este tiene color, talla, peso, tamaño y estos tienen valor diferente. Active esta casita si el producto lo tiene.</p>
                  </div>
                 
                 <div class="col col-lg-12 col-md-12">
                      <input tabindex="2" autocomplete="off" ng-click="activaVariacion()" id="variacion2" name="variacion" <?php if(isset($datos['variacion']) && $datos['variacion'] == '0'){ echo "checked"; }?> type="radio" value="0"> <label for="variacion2">NO</label>&nbsp;&nbsp;&nbsp;&nbsp;

                      <input tabindex="2" autocomplete="off" ng-click="activaVariacion()" id="variacion1" name="variacion" <?php if(isset($datos['variacion']) && $datos['variacion'] == '1'){ echo "checked"; }?> type="radio" value="1"> <label for="variacion1">SI</label>
                 </div>
              </div> -->

               
               <div class="row">
                
               <div class="col col-lg-12">
                        <h3 style="margin:0 0 20px 0;font-weight:bold"><?php echo lang("text19.4")?></h3>
                </div>
              
                 <div class="col col-lg-4 col-md-4">
                    <div class="form-group  label-floating">
                        <label class="control-label" for="valorPresentacion"><?php echo lang("text13")?> *</label>
                          <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="valorPresentacion" name="valorPresentacion"  class="form-control" value="<?php echo (isset($datos['valorPresentacion']))?$datos['valorPresentacion']:''; ?>" type="text">
                      <p class="help-block"><?php echo lang("text17")?></p>
                    </div>
                 </div>
                 <div class="col col-lg-4 col-md-4">
                    <div class="form-group  label-floating">
                        <label class="control-label" for="valorAntes"><?php echo lang("text14")?></label>
                          <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="valorAntes" name="valorAntes"  class="form-control" value="<?php echo (isset($datos['valorAntes']))?$datos['valorAntes']:''; ?>" type="text">
                      <p class="help-block"><?php echo lang("text16")?>. <?php echo lang("text19.5")?></p>
                    </div>
                 </div>
                 <div class="col col-lg-4 col-md-4">
                    <div class="form-group  label-floating">
                        <label class="control-label" for="variacion"><?php echo lang("text15")?></label>
                          <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="descuento" name="descuento"  class="form-control" value="<?php echo (isset($datos['descuento']))?$datos['descuento']:''; ?>" type="text">
                      <p class="help-block"><?php echo lang("text16")?></p>
                    </div>
                 </div>

               </div>

               <div class="row">
                  <div class="col col-lg-12">
                            <h3 style="margin:0 0 20px 0;font-weight:bold"><?php echo lang("text19.10")?></h3>
                    </div>
                  <div class="col col-lg-4 col-md-4">
                        <div class="form-group  label-floating">
                            <label class="control-label" for="agotado"><?php echo lang("text19.11")?></label>
                              <select tabindex="2" id="agotado" name="agotado"  class="form-control">
                                <!--<option value="No" <?php if(isset($datos['agotado']) && $datos['agotado'] =='No'){ ?>selected<?php } ?>>NOT</option>-->
                                <option value="No" <?php if(isset($datos['agotado']) && $datos['agotado'] =='No'){ ?>selected<?php } ?>>No</option>
                                <!--<option value="Si" <?php if(isset($datos['agotado']) && $datos['agotado'] =='Si'){ ?>selected<?php } ?>>YES</option>-->
                                <option value="Si" <?php if(isset($datos['agotado']) && $datos['agotado'] =='Si'){ ?>selected<?php } ?>>Si</option>
                              </select>
                        </div>
                    </div>
               </div>



  
       <input type="hidden" name="idPresentacion" value="<?php echo $idPresentacion?>">

  </div>
  <div class="modal-footer">
    <button type="button"  data-dismiss="modal" class="btn  btn-default"><?php echo lang('reg_btn_cancelar') ?></button>
    <?php if(getPrivilegios()[0]['crear'] == 1 && $edita == 0){ ?>
      <button type="submit" class="btn btn-raised btn-primary" id="botonProcesar"><?php echo $labelBtn ?></button>
    <?php } ?>
    <?php if(getPrivilegios()[0]['editar'] == 1 && $edita == 1){ ?>
      <button type="submit" class="btn btn-raised btn-primary" id="botonProcesar"><?php echo $labelBtn ?></button>
    <?php } ?>
  </div>
</form>
<script type="text/javascript">
  <?php if($edita == 1){?>
    $(document).ready(function(){
      angular.element(document.getElementById('formulario')).scope().buscarSubCategorias('<?php echo $datos['idSubcategoria']?>');
      //angular.element(document.getElementById('formulario')).scope().activaVariacion();
    });
  <?php }?>
  function buscarSubCategorias(id)
  {
    angular.element(document.getElementById('formulario')).scope().buscarSubCategorias(id);
  }
</script>