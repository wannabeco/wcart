<div class="container">
    <script id="metamorph-1-start" type="text/x-placeholder"></script><script id="metamorph-21-start" type="text/x-placeholder"></script>
    <div class="container text-center" style="margin-top:8%">
        <center><img src="<?php echo base_url()?>res/img/logo.png" width="50%"></center>
        <h2 class="form-signin-heading">Regístrese Ahora</h2>
        <small class="text-muted">Con su registro le regalamos 1Kg de limón Tahití de exportación.</small><br><br>
        <fieldset>
        <form ng-submit="registraUsuario()">
          <div class="row">
            <h5><strong>Paso1:</strong> Escriba el código del vendedor que se contactó con usted.</h5>  
            <div class="col-lg-12">
                 <div class="form-group" id="cajaNombreEmpresa">
                  <input style="text-transform: uppercase;" tabindex="1" id="codVende" name="codVende" ng-model="codVende" class="ember-view cajasRegistro ember-text-field form-control login-input" placeholder="Código del vendedor" type="text" ng-blur="verificaVendedor()">
                  <div class="alert alert-info" id="dataVendedorConsultado">Aqui se mostrara el vendedor</div>
                </div>
            </div>
          </div>

          <div class="row" id="contDatosReg">
            <h5><strong>Paso2:</strong> Complete su información personal.</h5>
            <div class="col-lg-12">
                 <div class="form-group">
                  <input tabindex="1" id="nombre" name="nombre" ng-model="nombre" class="ember-view cajasRegistro ember-text-field form-control login-input" placeholder="Nombre" type="text" readonly="">
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="form-group">
                  <input tabindex="1" id="apellido" name="apellido" ng-model="apellido" class="ember-view cajasRegistro ember-text-field form-control login-input" placeholder="Apellido" type="text" readonly="">
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="form-group">
                  <input tabindex="1" id="correo" name="correo" ng-model="correo" class="ember-view cajasRegistro ember-text-field form-control login-input" placeholder="Correo electrónico" type="email" readonly="">
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="form-group">
                  <input tabindex="1" id="celular" name="celular" ng-model="celular" class="ember-view cajasRegistro ember-text-field form-control login-input" placeholder="Número de celular" type="number" readonly="">
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="form-group">
                  <select readonly="" class="ember-view cajasRegistro ember-text-field form-control login-input" type="text" ng-model="conjunto" id="conjunto">
                      <option value="">Seleccione el conjunto residencial</option>
                      <option ng-repeat="con in conjuntos" value="{{con.idConjunto}}">{{con.nombreConjunto}}</option>
                  </select>
                </div>
            </div><!-- 
            <div class="col-lg-12">
                 <div class="form-group">
                  <input tabindex="1" id="direccion" name="direccion" ng-model="direccion" class="ember-view cajasRegistro ember-text-field form-control login-input" placeholder="Torre y apartamento" type="text" readonly="">
                </div>
            </div> -->
            <div class="col-lg-12">
                 <div class="form-group">
                  <input tabindex="1" id="torre" name="torre" ng-model="torre" class="ember-view cajasRegistro ember-text-field form-control login-input" placeholder="Torre" type="text" readonly="">
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="form-group">
                  <input tabindex="1" id="apto" name="apto" ng-model="apto" class="ember-view cajasRegistro ember-text-field form-control login-input" placeholder="Apartamento" type="text" readonly="">
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="form-group">
                  <input tabindex="1" id="clave" name="clave" ng-model="clave" class="ember-view cajasRegistro ember-text-field form-control login-input" placeholder="Contraseña" type="password" readonly="">
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="form-group">
                  <input tabindex="1" id="rclave" name="rclave" ng-model="rclave" class="ember-view cajasRegistro ember-text-field form-control login-input" placeholder="Repita la contraseña" type="password" readonly="">
                </div>
            </div>
            <div class="col-lg-12">
                  <p style="font-size: 0.8em;text-align: justify"><input type="checkbox" id="terminos" value="1">  Ley de Protección de Datos Personales: La autorización suministrada en el presente formulario faculta a Esmeralda Quality Fruit para que dé a sus datos aquí recopilados el tratamiento señalado en la <a ng-click="popTerminos()" style="color:#008043">"Política de Privacidad para el Tratamiento de Datos Personales"</a> de Esmeralda Quality Fruit, el cual incluye, entre otras, el envío de información promocional, así como la invitación a eventos. El titular de los datos podrá, en cualquier momento, solicitar que la información sea modificada, actualizada o retirada de las bases de datos de Esmeralda Quality Fruit. </p>
            </div>
          </div>
           <input type="hidden" name="codigoVendedorC" id="codigoVendedorC" value="">
        


        

            <br><br>
          <script id="metamorph-22-start" type="text/x-placeholder"></script><script id="metamorph-22-end" type="text/x-placeholder"></script>
          <button class="btn btn-raised btn-primary" data-bindattr-3="3">RECLAMAR MI OBSEQUIO</button>
          <br><br><br>
          <a href="<?php echo base_url()?>" class="ember-view cajasRegistro btn btn-sm btn-default"> <?php echo lang("reg_btn_cancelar") ?> </a>
          </fieldset>
        </form>
  </div>
</div>