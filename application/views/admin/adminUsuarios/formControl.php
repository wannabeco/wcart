<form role="form"  ng-controller="procesaGuardado" id="formAgregaPersona" ng-submit="procesaUsuario(<?php echo $edita ?>)">    
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h2 class="modal-title"><?php echo $titulo ?></h2>
    <p class="text-justify">
      Creación de usuarios administradores, vendedores y vendedoras.
    </p>
  </div>
    <div class="modal-body">    

        <div class="row">
          
          <!-- <div  class="col col-lg-6">
            <div class="form-group  label-floating">
                <label class="control-label" for="nroDocumento">Documento de identidad</label>
                  <input tabindex="2" autocomplete="off" id="nroDocumento" name="nroDocumento"  class="form-control" value="<?php echo (isset($datos['nroDocumento']))?$datos['nroDocumento']:''; ?>" type="text">
              <p class="help-block"></p>
            </div>
          </div> -->
          <!--<div  class="col col-lg-6">
            <div class="form-group  label-floating">
                <label class="control-label" for="ciudadExpedicionCedula">Ciudad de expedición documento</label>
                <select tabindex="3"  id="ciudadExpedicionCedula" name="ciudadExpedicionCedula" class="form-control">
                    <option value=""></option>
                    <?php foreach($selects['ciudades'] as $listaProf){ 
                        $cidDoc = $listaProf['ID_DPTO']."-".$listaProf['ID_CIUDAD'];
                      ?>
                        <option value="<?php echo $cidDoc ?>" <?php echo (isset($datos['ciudadExpedicionCedula']) && $cidDoc == $datos['ciudadExpedicionCedula'])?'selected':''; ?>><?php echo $listaProf['NOMBRE'] ?></option>
                    <?php } ?>
                </select>
            </div>
          </div>-->


          <!-- <div  class="col col-lg-6">
            <div class="form-group  label-floating">
                <label class="control-label" for="fechaNacimiento">Fecha de nacimiento</label>
                  <input tabindex="4" autocomplete="off" id="fechaNacimiento" name="fechaNacimiento"  class="form-control" value="<?php echo (isset($datos['fechaNacimiento']))?$datos['fechaNacimiento']:''; ?>" type="text">
              <p class="help-block"></p>
            </div>
          </div> -->

       

        
            <div class="col col-lg-6">
                <div class="form-group  label-floating">
                  <label class="control-label" for="nombre">Nombre del usuario</label>
                  <input tabindex="5" autocomplete="off" id="nombre" name="nombre"  class="form-control" value="<?php echo (isset($datos['nombre']))?$datos['nombre']:''; ?>"  type="text">
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

        
            <div class="col col-lg-6">
                <div class="form-group  label-floating">
                  <label class="control-label" for="direccion"> Dirección de residencia</label>
                  <input tabindex="7" autocomplete="off" id="direccion" name="direccion"  class="form-control" value="<?php echo (isset($datos['direccion']))?$datos['direccion']:''; ?>"  type="text">
                  <p class="help-block"></p>
                </div> 
            </div>
           <!-- <div class="col col-lg-6">
                <div class="form-group  label-floating">
                  <label class="control-label" for="barrio"> Barrio</label>
                  <input tabindex="8" autocomplete="off" id="barrio" name="barrio"  class="form-control" value="<?php echo (isset($datos['barrio']))?$datos['barrio']:''; ?>"  type="text">
                  <p class="help-block"></p>
                </div> 
            </div>-->
           <!--<div class="col col-lg-6">
                <div class="form-group  label-floating">
                  <label class="control-label" for="telefono">Teléfono de contacto</label>
                  <input tabindex="9" autocomplete="off" id="telefono" name="telefono"  class="form-control" value="<?php echo (isset($datos['telefono']))?$datos['telefono']:''; ?>"  type="text">
                  <p class="help-block">Sin caracteres especiales</p>
                </div> 
            </div>-->
           <div class="col col-lg-6">
                <div class="form-group  label-floating">
                  <label class="control-label" for="celular">Celular de contacto</label>
                  <input tabindex="10" autocomplete="off" id="celular" name="celular"  class="form-control" value="<?php echo (isset($datos['celular']))?$datos['celular']:''; ?>"  type="text">
                  <p class="help-block">Sin caracteres especiales</p>
                </div> 
            </div>
        

        
          <!--<div class="col col-lg-6">
              <div class="form-group  label-floating">
                <label class="control-label" for="idSexo">Sexo</label>
                <select tabindex="11"  id="idSexo" name="idSexo" class="form-control">
                    <option value=""></option>
                  <?php foreach($selects['sexo'] as $listaSexo){ ?>
                      <option value="<?php echo $listaSexo['idSexo'] ?>" <?php echo (isset($datos['idSexo']) && $listaSexo['idSexo'] == $datos['idSexo'])?'selected':''; ?>><?php echo $listaSexo['nombreSexo'] ?></option>
                  <?php } ?>
                </select>
              </div> 
          </div>-->

          <!--<div  class="col col-lg-6">
            <div class="form-group label-floating">
                <label class="control-label" for="idArea">Area</label>
                <select tabindex="14"  id="idArea" name="idArea" class="form-control">
                    <option value=""></option>
                    <?php foreach($selects['areas'] as $listaAreas){ ?>
                        <option value="<?php echo $listaAreas['idArea'] ?>" <?php echo (isset($datos['idArea']) && $listaAreas['idArea'] == $datos['idArea'])?'selected':''; ?>><?php echo $listaAreas['nombreArea'] ?></option>
                    <?php } ?>
                </select>
            </div>
          </div>

        
          <div class="col col-lg-6">
              <div class="form-group label-floating">
                <label class="control-label" for="idCargo">Cargo a desempeñar</label>
                <select tabindex="15"  id="idCargo" name="idCargo" class="ember-view ember-text-field form-control">
                    <option value=""></option>
                  <?php foreach($selects['cargos'] as $cargos){ ?>
                      <option value="<?php echo $cargos['idCargo'] ?>" <?php echo (isset($datos['idCargo']) && $cargos['idCargo'] == $datos['idCargo'])?'selected':''; ?>><?php echo $cargos['nombreCargo'] ?></option>
                  <?php } ?>
                </select>
              </div> 
          </div>
          <div  class="col col-lg-6">
              <div class="form-group label-floating">
                <label class="control-label" for="contrato">Tipo de contrato</label>
                <select tabindex="16"  id="contrato" name="contrato" class="ember-view ember-text-field form-control">
                    <option value=""></option>
                    <option value="INDEFINIDO" <?php echo (isset($datos['contrato']) && 'INDEFINIDO' == $datos['contrato'])?'selected':''; ?>>INDEFINIDO</option>
                </select>
              </div> 
           </div>   

          <div  class="col col-lg-6">
            <div class="form-group  label-floating">
                <label class="control-label" for="salario">Salario</label>
                  <input tabindex="17" autocomplete="off" id="salario" name="salario"  class="form-control" value="<?php echo (isset($datos['salario']))?$datos['salario']:''; ?>" type="text">
              <p class="help-block"></p>
            </div>
          </div>-->

          <!-- <div  class="col col-lg-6">
            <div class="form-group  label-floating">
                <label class="control-label" for="fechaIngreso">Fecha Ingreso</label>
                  <input tabindex="19" autocomplete="off" id="fechaIngreso" name="fechaIngreso"  class="form-control" value="<?php echo (isset($datos['fechaIngreso']))?$datos['fechaIngreso']:''; ?>" type="text">
              <p class="help-block"></p>
            </div>
          </div> -->
<!--
          <div  class="col col-lg-6">
            <div class="form-group label-floating">
                <label class="control-label" for="id_eps">EPS</label>
                <select tabindex="20"  id="id_eps" name="id_eps" class="form-control">
                    <option value=""></option>
                    <?php foreach($selects['eps'] as $epss){ ?>
                        <option value="<?php echo $epss['id_eps'] ?>" <?php echo (isset($datos['id_eps']) && $epss['id_eps'] == $datos['id_eps'])?'selected':''; ?>><?php echo $epss['des_eps'] ?></option>
                    <?php } ?>
                </select>
            </div>
          </div>

          <div  class="col col-lg-6">
            <div class="form-group label-floating">
                <label class="control-label" for="id_afp">AFP</label>
                <select tabindex="21"  id="id_afp" name="id_afp" class="form-control">
                    <option value=""></option>
                    <?php foreach($selects['afp'] as $afps){ ?>
                        <option value="<?php echo $afps['id_afp'] ?>" <?php echo (isset($datos['id_afp']) && $afps['id_afp'] == $datos['id_afp'])?'selected':''; ?>><?php echo $afps['des_afp'] ?></option>
                    <?php } ?>
                </select>
            </div>
          </div>

          <div  class="col col-lg-6">
            <div class="form-group label-floating">
                <label class="control-label" for="id_app_cesantias">Fondo de cesantias</label>
                <select tabindex="22"  id="id_app_cesantias" name="id_app_cesantias" class="form-control">
                    <option value=""></option>
                    <?php foreach($selects['cesantias'] as $cesantiass){ ?>
                        <option value="<?php echo $cesantiass['id_app_cesantias'] ?>" <?php echo (isset($datos['id_app_cesantias']) && $cesantiass['id_app_cesantias'] == $datos['id_app_cesantias'])?'selected':''; ?>><?php echo $cesantiass['nombrefondocesantias'] ?></option>
                    <?php } ?>
                </select>
            </div>
          </div>-->


       

         
            <div  class="col col-lg-6">
              <div class="form-group  label-floating">
                  <label class="control-label" for="email">Correo electrónico</label>
                    <input tabindex="23" autocomplete="off" id="email" name="email"  class="form-control" value="<?php echo (isset($datos['email']))?$datos['email']:''; ?>" type="text">
                    <p class="help-block">Este dato será el usuario de inicio de sesión</p>
              </div>
            </div>

          <!--<div class="col col-lg-6">
              <div class="form-group label-floating">
                <label class="control-label" for="tipoUsuario">Tipo de usuario</label>
                <select tabindex="24"  id="tipoUsuario" name="tipoUsuario" class="ember-view ember-text-field form-control">
                    <option value=""></option>
                    <option value="1" <?php echo (isset($datos['tipoUsuario']) && $datos['tipoUsuario'] == 1)?'selected':''; ?>>Administrativo</option>
                    <option value="2" <?php echo (isset($datos['tipoUsuario']) && $datos['tipoUsuario'] == 2)?'selected':''; ?>>Operativo</option>
                </select>
              </div> 
          </div>-->


          <div class="col col-lg-6">
              <div class="form-group label-floating">
                <label class="control-label" for="idTienda">Tienda</label>
                <select tabindex="1"  id="idTienda" name="idTienda" class="form-control">
                    <option value=""></option>
                  <?php foreach($selects['tiendas'] as $tienda){ ?>
                      <option value="<?php echo $tienda['idTienda'] ?>" <?php echo (isset($datos['idTienda']) && $tienda['idTienda'] == $datos['idTienda'])?'selected':''; ?>><?php echo $tienda['nombreTienda'] ?></option>
                  <?php } ?>
                </select>
              </div> 
          </div>

            <div  class="col col-lg-6">
              <div class="form-group label-floating">
                <label class="control-label" for="idPerfil">Perfil de usuario</label>
                <select tabindex="25"  id="idPerfil" name="idPerfil" class="ember-view ember-text-field form-control">
                    <option value=""></option>
                  <?php foreach($selects['perfiles'] as $perfiles){ ?>
                    <?php if($perfiles['idPerfil'] != 1){?>
                      <option value="<?php echo $perfiles['idPerfil'] ?>" <?php echo (isset($datos['idPerfil']) && $perfiles['idPerfil'] == $datos['idPerfil'])?'selected':''; ?>><?php echo $perfiles['nombrePerfil'] ?></option>
                    <?php }?>
                  <?php } ?>
                </select>
              </div> 
            </div>

            
           <!-- <div  class="col col-lg-6">
              <div class="form-group  label-floating">
                  <label class="control-label" for="idConjunto">Conjunto residencial</label>
                  <select tabindex="3"  id="idConjunto" name="idConjunto" class="form-control">
                      <option value=""></option>
                      <?php foreach($selects['conjuntos'] as $conjuntos){ 
                          $idConjunto = $conjuntos['idConjunto'];
                        ?>
                          <option value="<?php echo $idConjunto ?>" <?php echo (isset($datos['idConjunto']) && $idConjunto == $datos['idConjunto'])?'selected':''; ?>><?php echo $conjuntos['nombreConjunto'] ?></option>
                      <?php } ?>
                  </select>
              </div>
            </div>-->

            

           <!-- <div  class="col col-lg-6">
              <div class="form-group  label-floating">
                <?php //var_dump($selects['subdis']); ?>
                  <label class="control-label" for="idPadre">Distrbuidor Padre <small>Sólo para vendedores</small></label>
                  <select tabindex="3"  id="idPadre" name="idPadre" class="form-control">
                      <option value="1">Administrador</option>
                      <?php foreach($selects['subdis']['datos'] as $subDis){ 
                        ?>
                          <option value="<?php echo $subDis['idPersona'] ?>" <?php echo (isset($datos['idPadre']) && $subDis['idPersona'] == $datos['idPadre'])?'selected':''; ?>><?php echo $subDis['nombre'] ?> <?php echo $subDis['apellido'] ?></option>
                      <?php } ?>
                  </select>
              </div>
            </div>-->
            <!--
            <div  class="col col-lg-6">
              <div class="form-group  label-floating">
                <?php //var_dump($selects['subdis']); ?>
                  <label class="control-label" for="vendReferida">Referida por <small>Sólo para vendedores</small></label>
                  <select tabindex="3"  id="vendReferida" name="vendReferida" class="form-control">
                      <option value="">Ninguna</option>
                      <?php foreach($selects['vend']['datos'] as $vendedores){ 
                        ?>
                          <option value="<?php echo $vendedores['idPersona'] ?>" <?php echo (isset($datos['vendReferida']) && $vendedores['idPersona'] == $datos['vendReferida'])?'selected':''; ?>><?php echo $vendedores['nombre'] ?> <?php echo $vendedores['apellido'] ?> [ME-<?php echo $vendedores['idPersona'] ?>]</option>
                      <?php } ?>
                  </select>
              </div>
            </div>-->
            

            <div  class="col col-lg-6">
                <?php if($edita == 1){ ?>
                  <div class="form-group  label-floating"">
                    <label class="control-label" for="estado">Estado del usuario</label>
                    <select tabindex="26" class=" form-control" id="estado" name="estado">
                      <option value="1" <?php if($datos['estadoU'] == 1){?>selected<?php }?>>Activo</option>
                      <option value="0" <?php if($datos['estadoU'] == 0){?>selected<?php }?>>Inactivo</option>
                    </select>
                  </div> 
                  <input id="idUsuario" name="idUsuario" value="<?php echo $idUsuario ?>" type="hidden">
                <?php } ?>
                  <input id="perfilPadre" name="perfilPadre" value="<?php echo $perfil ?>" type="hidden">
                  <!-- <input id="idPadre" name="idPadre" value="<?php echo $idPadre ?>" type="hidden"> -->
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