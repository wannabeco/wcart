<div class="container">
 
<script id="metamorph-1-start" type="text/x-placeholder"></script><script id="metamorph-21-start" type="text/x-placeholder"></script>
  <div class="row">
    <div class="col-lg-12">
        <div class="container-fluid text-center" style="margin-top:10%">
              <form class="form-signin" data-ember-action="2" id="formLogin" ng-submit="loginInApp()">
                <h1><strong>PLATAFORMA<br>DE PAGOS</strong></h1>
                <!--<h2 class="form-signin-heading"><?php echo lang("tituloBienvenida") ?></h2>-->
                <!-- <img src="<?php echo base_url()?>res/img/logo.png" width="80%"><br><br> -->
                <!-- <small class="text-muted"><?php echo lang("textoBienvenida") ?></small> -->
                <!-- <div class="row-picture" style="margin:10% 0 0 0">
                  <img class="img img-circle" id="miniatura" ng-src="{{fotoLogin}}" alt="icon" width="35%">
                </div> -->
                <div class="input-group">
                  <span class="input-group-addon" style="padding: 0;margin: -5px 0 0 0;vertical-align:0 !important">
                    <img src="<?php echo base_url()?>res/img/img1.jpg" width="40px">
                  </span>
                  <input name="usuario"  autocomplete="off" ng-change="getPicture()" ng-model="usuario" id="usuario" class="ember-view ember-text-field form-control login-input" placeholder="<?php echo lang("placeHolderCorreo") ?>" type="text">
                </div>
                <div class="input-group">
                      <span class="input-group-addon" style="padding: 0;margin: -5px 0 0 0;vertical-align:0 !important">
                         <img src="<?php echo base_url()?>res/img/img1.jpg" width="40px">
                      </span>
                  <input name="clave"  autocomplete="off" ng-model="clave" id="clave" class="ember-view ember-text-field form-control login-input-pass" placeholder="<?php echo lang("placeHolderClave") ?>" type="password">
                </div>

                <script id="metamorph-22-start" type="text/x-placeholder"></script><script id="metamorph-22-end" type="text/x-placeholder"></script>
                <button class="btn btn-raised btn-primary btn-despegar" data-bindattr-3="3"><?php echo lang("labelBtnLogin") ?></button>
                <br><br>
               <!--  <a href="<?php echo base_url() ?>Inicio/recordarClave">¿Ha olvidado su clave?</a><br> -->

              </form>
      </div>
    </div>
  </div>

</div>