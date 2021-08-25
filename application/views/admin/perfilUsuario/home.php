<div class="container-fluid" ng-controller="perfilUsuario" ng-init="initPerfilUsuarios()" id="contenedorPerfilUsuario">

<div id="modalFoto" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content" id="modalCrea">
            <form role="form"  id="formFotoPerfil" ng-submit="cambioFotoPerfil()" enctype="multipart/form-data">    
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h2 class="modal-title">CAMBIAR FOTO DE PERFIL</h2>
                  <p class="text-justify">
                    Podrá elegir de su computadora una fotografía para acompañar su perfil. Esta fotografía debe estar en formato PNG, JPG ó GIF, no debe ser mayor a 2 MB y debe guardar la proporción de tamaño de 800 X 800 máximo (Cuadrado perfecto).
                  </p>
                </div>
                <div class="modal-body"> 
                    <input type="file" class="file" name="fotoPerfil" />
                    <input id="idUsuarioFoto" name="idUsuarioFoto"  class="form-control" value="<?php echo (isset($datos['idPersona']))?$datos['idPersona']:''; ?>" type="hidden">
                </div>
              <div class="modal-footer">
                <button type="button"  data-dismiss="modal" class="btn  btn-default"><?php echo lang('reg_btn_cancelar') ?></button>
                  <!--<button type="submit" class="btn btn-raised btn-primary">CAMBIAR FOTO</button>-->
              </div>
            </form>
        </div>
    </div>
</div>
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">

                Perfil del usuario
                <?php  $_SESSION['project']['info']['nombre'] ?> <?php  $_SESSION['project']['info']['apellido'] ?> <!--<small>Estructura de las áreas de su empresa</small>-->
                
                <!--<?php if(getPrivilegios()[0]['crear'] == 1){ ?>
                    <div class="btn-group" >
                        <button type="button" class="btn dropdown-toggle"
                                data-toggle="dropdown">
                          <?php echo lang("lblAcciones") ?> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          
                            <li role="separator" class="divider"></li><li class="dropdown-header"><?php echo lang("lblSeleccioneOpc") ?></li>
                            <li><a class="btn" ng-click="cargaPlantillaControl('',0)"><i class="fa fa-fw fa-plus"></i> AGREGAR NUEVO USUARIO</a></li>
                        </ul>
                    </div>
                <?php } ?>-->
            </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>
            </li>
            <li class="active">
                 Perfil de usuario
            </li>
        </ol>
        </div>
    </div> 

    <div class="row">
        <div class="col col-lg-6 col-md-6">
            <h3 class="text-center">DATOS PERSONALES</h3>
            <div class="row">
                <div class="col col-lg-12 col-md-12" style="border-right:1px solid #E1E1E1">
                    <div class="row">
                        <form role="form" name="dataUsuario" id="dataUsuario" ng-submit="procesaDataUsuario()">
                            <div class="col col-lg-12">
                                <div class="row-picture" style="margin:10% 0 0 0">
                                <a data-toggle="modal" data-target="#modalFoto" style="cursor: pointer">
                                    <?php if($datos['icono'] != ""){ ?>
                                    <center>
                                        <div style="box-shadow:inset 0px 0px 3px #999;border:1px solid #999;border-radius:200px;width:150px;height:150px;background: url(<?php echo base_url()."res/fotos/personas/".$datos['idPersona']."/".$datos['icono'] ?>) no-repeat center center;background-size:120% "></div>
                                        <!--<img class="img img-circle" id="miniatura" src="<?php echo base_url()."res/fotos/personas/".$datos['idPersona']."/".$datos['icono'] ?>" alt="icon" width="35%">-->
                                    </center><br><br>
                                  <?php }else{ ?>
                                        <center><img class="img img-circle" id="miniatura" src="<?php echo base_url()."res/img/user.jpg" ?>" alt="icon" width="25%"></center><br><br>
                                  <?php } ?>
                                  </a>
                                </div>
                                <center><span class="small" style="margin:-10% 0 0 0">Click sobre la foto para cambiarla</span></center><br><br>
                            </div>
                            <div class="col col-lg-6">
                                <div class="form-group label-floating">
                                    <label class="control-label" for="tipoDocumento">Tipo de documento</label>
                                    <select  id="tipoDocumento" name="tipoDocumento" class="form-control">
                                        <option value=""></option>
                                      <?php foreach($selects['tiposDoc'] as $listaTD){ ?>
                                          <option value="<?php echo $listaTD['idTipoDoc'] ?>" <?php echo (isset($datos['tipoDocumento']) && $listaTD['idTipoDoc'] == $datos['tipoDocumento'])?'selected':''; ?>><?php echo $listaTD['nombreTipoDoc'] ?></option>
                                      <?php } ?>
                                    </select>
                                </div> 
                            </div>

                            <div class="col col-lg-6">
                                <div class="form-group  label-floating">
                                    <label class="control-label" for="nroDocumento">Documento de identidad</label>
                                      <input autocomplete="off" id="nroDocumento" name="nroDocumento"  class="form-control" value="<?php echo (isset($datos['nroDocumento']))?$datos['nroDocumento']:''; ?>" type="text">
                                  <p class="help-block"></p>
                                </div>
                            </div>

                            <div class="col col-lg-6">
                                <div class="form-group  label-floating">
                                  <label class="control-label" for="nombre">Nombre del usuario</label>
                                  <input  autocomplete="off" id="nombre" name="nombre"  class="form-control" value="<?php echo (isset($datos['nombre']))?$datos['nombre']:''; ?>"  type="text">
                                  <p class="help-block"></p>
                                </div> 
                            </div>
                           <div class="col col-lg-6">
                                <div class="form-group label-floating">
                                  <label class="control-label" for="apellido">Apellido del usuario</label>
                                  <input tabindex="6" autocomplete="off" id="apellido" name="apellido"  class="form-control" value="<?php echo (isset($datos['apellido']))?$datos['apellido']:''; ?>"  type="text">
                                  <p class="help-block"></p>
                                </div> 
                            </div>
                            <div  class="col col-lg-6">
                                <div class="form-group  label-floating">
                                    <label class="control-label" for="fechaNacimiento">Fecha de nacimiento</label>
                                      <input  autocomplete="off" id="fechaNacimiento" name="fechaNacimiento"  class="form-control" value="<?php echo (isset($datos['fechaNacimiento']))?date('Y-m-d',strtotime($datos['fechaNacimiento'])):''; ?>" type="text">
                                  <p class="help-block"></p>
                                </div>
                            </div>

                            <div class="col col-lg-6">
                                <div class="form-group  label-floating">
                                  <label class="control-label" for="direccion"> Dirección de residencia</label>
                                  <input  autocomplete="off" id="direccion" name="direccion"  class="form-control" value="<?php echo (isset($datos['direccion']))?$datos['direccion']:''; ?>"  type="text">
                                  <p class="help-block"></p>
                                </div> 
                            </div>
                            <div class="col col-lg-6">
                                <div class="form-group  label-floating">
                                  <label class="control-label" for="barrio"> Barrio</label>
                                  <input tabindex="8" autocomplete="off" id="barrio" name="barrio"  class="form-control" value="<?php echo (isset($datos['barrio']))?$datos['barrio']:''; ?>"  type="text">
                                  <p class="help-block"></p>
                                </div> 
                            </div>
                           <div class="col col-lg-6">
                                <div class="form-group  label-floating">
                                  <label class="control-label" for="telefono">Teléfono de contacto</label>
                                  <input  autocomplete="off" id="telefono" name="telefono"  class="form-control" value="<?php echo (isset($datos['telefono']))?$datos['telefono']:''; ?>"  type="text">
                                  <p class="help-block">Sin caracteres especiales</p>
                                </div> 
                            </div>
                           <div class="col col-lg-6">
                                <div class="form-group  label-floating">
                                  <label class="control-label" for="celular">Celular de contacto</label>
                                  <input  autocomplete="off" id="celular" name="celular"  class="form-control" value="<?php echo (isset($datos['celular']))?$datos['celular']:''; ?>"  type="text">
                                  <p class="help-block">Sin caracteres especiales</p>
                                </div> 
                            </div>

                          <div class="col col-lg-6">
                              <div class="form-group  label-floating">
                                <label class="control-label" for="idSexo">Sexo</label>
                                <select  id="idSexo" name="idSexo" class="form-control">
                                    <option value=""></option>
                                  <?php foreach($selects['sexo'] as $listaSexo){ ?>
                                      <option value="<?php echo $listaSexo['idSexo'] ?>" <?php echo (isset($datos['idSexo']) && $listaSexo['idSexo'] == $datos['idSexo'])?'selected':''; ?>><?php echo $listaSexo['nombreSexo'] ?></option>
                                  <?php } ?>
                                </select>
                              </div> 
                          </div>

                        <div  class="col col-lg-6">
                          <div class="form-group  label-floating">
                              <label class="control-label" for="email">Correo electrónico</label>
                                <input autocomplete="off" id="email" name="email"  class="form-control" value="<?php echo (isset($datos['email']))?$datos['email']:''; ?>" type="text">
                                <p class="help-block">Este dato será el usuario de inicio de sesión</p>
                          </div>
                          <input id="idUsuario" name="idUsuario"  class="form-control" value="<?php echo (isset($datos['idPersona']))?$datos['idPersona']:''; ?>" type="hidden">
                        </div>
                        <div  class="col col-lg-12 text-center">
                         <button type="submit" class="btn btn-raised btn-primary">ACTUALIZAR INFORMACIÓN</button>
                        </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col col-lg-6 col-md-6">
            <h3 class="text-center">CAMBIO DE CLAVE</h3>
             <div class="row">
                <div class="col col-lg-12 col-md-12" style="border-right:1px solid #E1E1E1">
                    <div class="row"  style="padding: 5%">
                        <form role="form" method="post" ng-submit="cambioClaveUsuario()" id="formCambioClave">
                            <div  class="col col-lg-12">
                              <div class="form-group  label-floating">
                                  <label class="control-label" for="claveActual">Contraseña actual</label>
                                    <input autocomplete="off" id="claveActual" name="claveActual"  class="form-control" type="password">
                                    <p class="help-block">Escriba la clave con la ingresa actualmente</p>
                              </div>
                            </div>

                            <div  class="col col-lg-12">
                              <div class="form-group  label-floating">
                                  <label class="control-label" for="nClave">Nueva contraseña</label>
                                    <input autocomplete="off" id="nClave" name="nClave"  class="form-control" type="password">
                                    <p class="help-block">Escriba una nueva clave para su sesión.</p>
                              </div>
                            </div>

                            <div  class="col col-lg-12">
                              <div class="form-group  label-floating">
                                  <label class="control-label" for="rClave">Repita la nueva contraseña</label>
                                    <input autocomplete="off" id="rClave" name="rClave"  class="form-control" type="password">
                                    <p class="help-block">Debe volver a escribir la nueva clave.</p>
                              </div>
                            </div>
                            <div  class="col col-lg-12 text-center">
                             <button type="submit" class="btn btn-raised btn-primary">CAMBIAR CONTRASEÑA</button>
                            </div>
                        </form>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
   
 </div>
<!-- /.container-fluid -->