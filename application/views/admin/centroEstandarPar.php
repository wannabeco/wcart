<div class="container-fluid" ng-controller="usuariosApp" ng-init="initUsuarios()" id="contenedorUsuarios">

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
                <?php echo $titulo ?> <!--<small>Estructura de las áreas de su empresa</small>-->
                
                <!-- <?php if(getPrivilegios()[0]['crear'] == 1){ ?>
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
                <?php } ?> -->
            </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>
            </li>
            <li>
                <?php if( isset($urlModulo) && ! empty($urlModulo) ){ ?>
                    <a href="<?php echo base_url($urlModulo.$infoModulo['idModulo']) ?>"> <?php echo $infoModulo['nombreModulo'] ?></a>
                <?php } else { ?>
                    <a href="<?php echo base_url() ?>Parametrizacion/parametrizacion/<?php echo $infoModulo['idModulo']?>"> Parametrización</a>
                <?php } ?>
            </li>
            <li class="active">
                 <?php echo $titulo ?>
            </li>
        </ol>
        </div>
    </div> 
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <?php echo $output->output; ?>
            </div>
        </div>
    </div>
    <!-- /.row -->
 </div>
<!-- /.container-fluid -->