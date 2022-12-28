
<div class="container-fluid" ng-controller="notificacionesApp" ng-init="initNotificaciones()" id="contenedorNotificaciones">
<div id="modalUsuarios" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content" id="modalCrea">
            <!--Form de creación -->
        </div>
    </div>
</div>

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?php echo $infoModulo['nombreModulo'] ?> <!--<small>Estructura de las áreas de su empresa</small>-->
                
             
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="active">
                     <?php echo $infoModulo['nombreModulo'] ?>
                </li>
            </ol>
        </div>
    </div> 
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="alert alert-primary" role="alert">
            <?php echo lang("lbl_not_1");?>
            </div>
            <form method="post" id="formulario" ng-submit="enviaNotificaciones()">
                <h4><strong><?php echo lang("lbl_not_2")?></strong></h4>
                <input type="text" name="tituloNotificacion" id="tituloNotificacion" data-validation="<?php echo lang("lbl_not_9")?>" class="form-control">
                <h4><strong><?php echo lang("lbl_not_3")?></strong></h4>
                <textarea name="mensajeNotificacion" id="mensajeNotificacion"  class="form-control"  data-validation="<?php echo lang("lbl_not_10")?>" style="width:100%"></textarea>
                <p><?php echo lang("lbl_not_4")?> <strong><?php echo count($listaUsuarios)?></strong> <?php echo lang("lbl_not_5")?></p>
                <p><?php echo lang("lbl_not_6")?> <a href="http://www.unicode.org/emoji/charts/full-emoji-list.html#1f610" target="_blank"><?php echo lang("lbl_not_7")?></a></p>
                <button class="btn btn-primary" style="float:right;background:#333;color:#fff"><?php echo lang("lbl_not_8")?></button>
            </form>
        </div>
        <div class="col-lg-6 text-center">
            <img src="<?php echo base_url()?>res/img/androidPhone.jpg" alt="" width="100%">
        </div>
    </div>
  
 </div>
<!-- /.container-fluid -->