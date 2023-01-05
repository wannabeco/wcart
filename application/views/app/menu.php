<!-- Navigation -->
        <nav class="navbar navbar-fixed-top  navbar-default" role="navigation" style="background: #333333;box-shadow:0px 0px 10px #999">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar" style="color:#005064"></span>
                    <span class="icon-bar" style="color:#005064"></span>
                    <span class="icon-bar" style="color:#005064"></span>
                </button>
                <?php if($_SESSION['project']['info']['idPerfil'] == 6){?>
                    <a class="navbar-brand" href="<?php echo base_url() ?>App" style="text-transform: capitalize">
                         <strong>
                            <img src="<?php echo base_url() ?>res/img/favicon.png" width="7%" style="border-radius:50%" alt="Icono Wannabe.com.co"> 
                            <!-- <?php echo lang("titulo")?> --> Wcart
                            <?php if(count($infoTienda) > 0){?>
                                /   <?php echo $infoTienda['datos'][0]['nombreTienda'] ?>
                            <?php }?>
                        </strong>
                    </a>
                    <?php if(count($infoTienda) > 0){
                        //si tiene solo plan de app, url de aplicacion para android y ios
                        //var_dump($infoTienda['datos']);die();
                            if($infoTienda['datos'][0]['Plan'] === 'movil'){ 
                                if($infoTienda['datos'][0]['urlAppStore'] !="" ){
                            ?>
                            <a class="navbar-brand" href="<?php echo $infoTienda['datos'][0]['urlAppStore']; ?>" style="" target="_blank">
                                <strong> Mi app Android</strong>
                            </a>
                            <?php } if($infoTienda['datos'][0]['urlAppIos'] !=""){ ?>
                            <a class="navbar-brand" href="<?php echo $infoTienda['datos'][0]['urlAppIos']; ?>" style="" target="_blank">
                                <strong> Mi app Ios</strong>
                            </a>
                         <?php //si tiene solo plan de app y web, url de aplicacion para android, ios y web 
                               } } } if($infoTienda['datos'][0]['Plan'] === 'movil y web'){ ?>
                            <a class="navbar-brand" href="<?php echo _URL_TIENDAS.$infoTienda['datos'][0]['urlAmigable']; ?>" style="" target="_blank">
                                <strong> ver mi tienda</strong>
                            </a>
                            <?php if($infoTienda['datos'][0]['urlAppStore'] !=""){ ?>
                            <a class="navbar-brand" href="<?php echo $infoTienda['datos'][0]['urlAppStore']; ?>" style="" target="_blank">
                                <strong> Mi app Android</strong>
                            </a>
                            <?php } if($infoTienda['datos'][0]['urlAppIos'] !=""){?>
                            <a class="navbar-brand" href="<?php echo $infoTienda['datos'][0]['urlAppIos']; ?>" style="" target="_blank">
                                <strong> Mi app Ios</strong>
                            </a>
                    <?php  }}?>
                <?php } else { ?>
                    <a class="navbar-brand" href="<?php echo base_url() ?>App" style="text-transform: capitalize">
                         <strong>
                            <img src="<?php echo base_url() ?>res/img/favicon.png" width="7%" style="border-radius:50%" alt="Icono Wannabe.com.co"> 
                            <?php echo lang("titulo")?> / admin
                        </strong>
                    </a>
                <?php }?>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
            <!-- Mensajitos
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong> <?php echo $_SESSION['project']['info']['nombre'] ?> <?php echo $_SESSION['project']['info']['apellido'] ?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong> <?php echo $_SESSION['project']['info']['nombre'] ?> <?php echo $_SESSION['project']['info']['apellido'] ?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong> <?php echo $_SESSION['project']['info']['nombre'] ?> <?php echo $_SESSION['project']['info']['apellido'] ?> </strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>-->


                <!-- Alertas y notificaciones-->
                <!-- Notificaciones
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>-->

                <!-- Perfil del usuario de la empresa-->
                <li class="dropdown">
                    <a href="#" style="color:#fff;background:#333 !important" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>  <?php echo $_SESSION['project']['info']['nombre'] ?>  <?php echo $_SESSION['project']['info']['apellido'] ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo base_url() ?>PerfilUsuario/datosUsuario"><i class="fa fa-fw fa-user"></i> Mis datos</a>
                        </li>
                        <!--<li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>-->
                        <!--<li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>-->
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo base_url()?>Login/logout"><i class="fa fa-fw fa-power-off"></i> Cerrar sesión </a>
                        </li>
                    </ul>
                    
                </li>
            </ul>

           <!-- Menú lateral-->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav  panel-group "  id="accordion">
                    <?php foreach($modulos as $modMenu){ ?>
                        <li>
                            <a style="color:#000" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $modMenu['idPadre']?>" class="" aria-expanded="true" ><i class="fa fa-fw <?php if($modMenu['icono'] != ""){ echo $modMenu['icono']; }else{ echo 'fa-circle';}?>"></i> <?php echo ($modMenu['nombreModulo']) ?></a>
                            <?php if(count($modMenu['modulos']) > 0){ ?>
                                <ul style="background: transparent;padding-top: 0;padding:0 0 0 5px" id="collapse<?php echo $modMenu['idPadre']?>" class="panel-collapse collapse in" aria-expanded="false">
                                    <?php foreach($modMenu['modulos'] as $hijos){ ?>
                                        <li style="list-style:none">
                                            <a style="color:#444" href="<?php echo base_url()?><?php echo $hijos['urlModulo'] ?><?php echo $hijos['idModulo'] ?>"><i class="fa fa-fw <?php if($hijos['icono'] != ""){ echo $hijos['icono']; }else{ echo 'fa-circle';}?>"></i> <?php echo ($hijos['nombreModulo']) ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- /.navbar-collapse fa-circle-->
        </nav>