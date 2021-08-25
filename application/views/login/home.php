<div class="container">
 
<script id="metamorph-1-start" type="text/x-placeholder"></script><script id="metamorph-21-start" type="text/x-placeholder"></script>
  <div class="row">
    <div class="col-lg-12">
        <div class="container-fluid text-center" style="margin-top:0%">
              <form class="form-signin" data-ember-action="2" id="formLogin" ng-submit="loginInApp()">
                <!--<h2 class="form-signin-heading"><?php echo lang("tituloBienvenida") ?></h2>-->
                <img src="<?php echo base_url()?>res/img/logo.png?<?php echo rand(0,1000)?>" width="auto"><br><br>
                <!-- <small class="text-muted"><?php echo lang("textoBienvenida") ?></small> -->
                <div class="row-picture" style="margin:10% 0 0 0">
                  <img class="img img-circle" id="miniatura" ng-src="{{fotoLogin}}" alt="icon" width="35%">
                </div>

                <input name="usuario"  autocomplete="off" ng-change="getPicture()" ng-model="usuario" id="usuario" class="ember-view ember-text-field form-control login-input" placeholder="<?php echo lang("placeHolderCorreo") ?>" type="text">
                
                <input name="clave"  autocomplete="off" ng-model="clave" id="clave" class="ember-view ember-text-field form-control login-input-pass" placeholder="<?php echo lang("placeHolderClave") ?>" type="password">

                <script id="metamorph-22-start" type="text/x-placeholder"></script><script id="metamorph-22-end" type="text/x-placeholder"></script>
                <button class="btn btn-raised btn-danger" style="background:#F72737" data-bindattr-3="3"><?php echo lang("labelBtnLogin") ?></button>
                <br>
                <a href="<?php echo base_url() ?>Inicio/recordarClave" class="text-danger" style="color:#F72737">¿Ha olvidado su clave?</a><br><br>
                <small>
                    Sistema de gestión de productos <br>
                    desarrollado por <a href="http://wannabe.com.co/" target="_blank" class="text-danger"><strong>Wannabe</strong></a><br>
                    V 1.0.0 &copy;<?php echo date("Y") ?>
                </small>

              </form>
      </div>
    </div>
  </div>

</div>