<div class="container-fluid" ng-controller="gestionTienda" ng-init="initBanner()" id="contenedorUsuarios">

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
                <?php if(getPrivilegios()[0]['crear'] == 1){ ?>
                    <div class="btn-group" >
                        <button type="button" class="btn dropdown-toggle"
                                data-toggle="dropdown">
                          <?php echo lang("lblAcciones") ?> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li role="separator" class="divider"></li><li class="dropdown-header"><?php echo lang("lblSeleccioneOpc") ?></li>
                            <li><a class="btn" ng-click="cargaPlantillaControlBanner('',0)"><i class="fa fa-fw fa-plus"></i> New Banner</a></li>
                        </ul>
                    </div>
                <?php } ?>
            </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>App"><i class="fa fa-home"></i> Home</a>
            </li>
            <li class="active">
                 <?php echo $infoModulo['nombreModulo'] ?>
            </li>
        </ol>
        </div>
    </div> 
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <form class="form-inline">
              <div class="form-group  label-floating">
                <label class="control-label" for="tipoDocumento">Filter</label>
                <input type="text" class="form-control" ng-model="q" placeholder=""><br>
              </div>
            </form>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-hover table-striped" ng-if="Banners.length > 0">
                    <thead>
                        <tr>
                            <!-- <th class="text-center">ID CATEGORÍA</th> -->
                            <th width="80px" class="text-center">POSITION</th>
                            <th><?php echo strtoupper(lang("text2"))?></th>
                            <th class="text-center"><?php echo lang("lbl_status")?></th>
                            <th class="text-center"><?php echo lang("lblAcciones")?></th>
                        </tr>
                    </thead>
                    <tbody id="tableBanner">
                        <tr ng-repeat="cat in Banners | filter:q as results">
                            <td class="text-center ordenador" data-id="{{cat.idBanner}}">
                                <span class="glyphicon glyphicon-move seleccionador" title="Ordenar contenido" style="cursor:move"></span>
                            </td>
                            <!-- <td class="text-center">{{cat.idBanner}}</td> -->
                            <td>
                            <img src="<?php echo base_url()?>assets/uploads/files/<?php echo $_SESSION['project']['info']['idTienda'] ?>/{{cat.fotoBanner}}" id="fotoBanner" name="fotoBanner" width="180px"alt=""> 
                                {{cat.tituloBanner}}
                            </td>
                            <td align="center">
                                <span class="label label-success" ng-if="cat.idEstado==1" value="1" >ON</span>
                                <span class="label label-default" ng-if="cat.idEstado==0" value="0" >OFF</span>
                            </td>
                            <td  class="text-center">
                                <?php if(getPrivilegios()[0]['editar'] == 1){ ?>
                                    <a ng-click="cargaPlantillaControlBanner(cat.idBanner,1)" title="<?php echo lang("lbl_boton_edita")?>" class="btn btn-primary btn-fab btn-fab-mini"><i class="material-icons">edit</i></a>
                                <?php }?>
                                <?php if(getPrivilegios()[0]['borrar'] == 1){ ?>
                                    <a ng-click="eliminaBanner(cat.idBanner,'<?php echo lang('lbl_confirm')?>')" title="<?php echo lang("lbl_boton_borra")?>"  class="btn btn-danger btn-fab btn-fab-mini btn-xs"><i class="material-icons">delete</i></a>
                                <?php } ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="alert alert-info" ng-if="Banners.length == 0">
                  <strong>Vaya!</strong> aún no has creado ningun banner. <button class="btn" style="background:#fff;color:#333" ng-click="cargaPlantillaControlBanner('',0)">CREAR MI PRIMERA BANNER</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
 </div>
<!-- /.container-fluid -->