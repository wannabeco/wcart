<div class="container-fluid" ng-controller="gestionTienda" ng-init="initProductos()" id="contenedor">

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
                            <li><a class="btn" ng-click="cargaPlantillaControlProductos('',0)" style="float:left;"><i class="fa fa-fw fa-plus"></i> Nuevo producto</a></li>
                            <li><a class="btn" ng-click="cargaPlantillaActualizaProductos('',1)" style="float:left;"><i class="fa fa-refresh"></i> Actualiza productos</a></li>
                            <li><a class="btn" ng-click="cargaPlantillaProductosMasivos('',1)" style="float:left;"><i class="fa fa-cloud-upload"></i> Carga de productos masivos</a></li>
                            <li><a class="btn" ng-click="cargaPlantillaCargaFotos('',1)" style="float:left;"><i class="fa fa-file-image-o"></i> Carga de imagenes</a></li>
                        </ul>
                        <!--boton de modal-->
                        <!--@if _app_variablesglobales si el valor es 0 no se mostrara el boton-->
                        <?php if(_DESHABILITA_BOTON_TUTORIALES == 1){?>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tutorial</button>
                        <?php } ?> 
                    </div>
                <?php }?>
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
    <!--<div class="row">
        <div class="col-lg-12">
            <form class="form-inline">
              <div class="form-group  label-floating">
                <label class="control-label" for="tipoDocumento">Filtrar por palabra</label>
                <input type="text" class="form-control" ng-model="q" placeholder=""><br>
              </div>
            </form>
        </div>
    </div>-->
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-hover table-striped" ng-if="productosLista.length > 0" id="tableProductos">
                    <thead>
                        <tr>
                            <th><?php echo lang("text4")?></th>
                            <th class="text-center"><?php echo lang("text19.16")?></th>
                            <th class="text-center"><?php echo lang("lbl_caracteristicas");?></th>
                            <th class="text-center"><?php echo lang("text2");?></th>
                            <th class="text-center"><?php echo lang("text3");?></th>
                            <th class="text-center"><?php echo lang("lbl_status")?></th>
                            <th class="text-center"><?php echo lang("lblAcciones")?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="prod in productosLista | filter:q as results">
                            <td style="vertical-align: middle">
                                <img src="<?php echo base_url()?>assets/uploads/files/<?php echo $_SESSION['project']['info']['idTienda']?>/{{prod.fotoPresentacion}}" width="50px" alt="">
                                <strong>{{prod.nombrePresentacion}}</strong><br>
                                <!-- <small>Valor unitario: ${{prod.valorPresentacion|number}}</small> -->
                            </td>
                            <td id="estrella{{prod.idPresentacion}}" style="vertical-align: middle" class="text-center">
                                    {{pintastrellas(prod.puntos, prod.votantes, prod.idPresentacion)}}
                            </td>
                            <td style="vertical-align: middle" class="text-center">
                                <?php if(getPrivilegios()[0]['editar'] == 1){ ?>
                                <a href="#" class="text-success" ng-click="variacionesProducto(prod.idPresentacion)"><?php echo lang("lbl_caracteristicas")?></a>
                                <?php }?>
                            </td>
                            <td style="vertical-align: middle" class="text-center">{{prod.nombreProducto}}</td>
                            <td style="vertical-align: middle" class="text-center">{{prod.nombreSubcategoria}}</td>
                            <td style="vertical-align: middle" align="center">
                                <!--<span class="label label-success" ng-if="prod.idEstado==1" value="1" >ON</span>-->
                                <span class="label label-success" ng-if="prod.idEstado==1" value="1" >Activo</span>
                                <!--<span class="label label-default" ng-if="prod.idEstado==0" value="0" >OFF</span>-->
                                <span class="label label-default" ng-if="prod.idEstado==0" value="0" >Inactivo</span>
                            </td>
                            <td  class="text-center">
                                <?php if(getPrivilegios()[0]['editar'] == 1){ ?>
                                    <a ng-click="cargaPlantillaControlProductos(prod.idPresentacion,1)" title="Editar" class="btn btn-primary btn-fab btn-fab-mini"><i class="material-icons">edit</i></a>
                                <?php }?>
                                <?php if(getPrivilegios()[0]['ver'] == 1){ ?>
                                    <a ng-click="cargaPlantillaComentarios(prod.idPresentacion,1)" title="Comentarios del producto" class="btn btn-primary btn-fab btn-fab-mini"><i class="material-icons">chat</i></a>    
                                <?php }?>
                                <?php if(getPrivilegios()[0]['borrar'] == 1){ ?>
                                    <a ng-click="eliminarProducto(prod.idPresentacion)" title="Eliminar"  class="btn btn-danger btn-fab btn-fab-mini btn-xs"><i class="material-icons">delete</i></a>
                                <?php } ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="alert alert-info" ng-if="productosLista.length == 0">
                  <strong>Vaya!</strong> aún no has creado ningún producto. <button class="btn" style="background:#fff;color:#333" ng-click="cargaPlantillaControlProductos('',0)">CREAR MI PRIMER PRODUCTO</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
 </div>
<!-- /.container-fluid -->
<!--modal de tutorial-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
            <h2 class="modal-title" id="myModalLabel" style="font-family: 'Roboto'; text-transform: uppercase;  color: #333;">Productos</h2>
          </div>
          <div class="modal-body">
          <div class="panelPopUp" id="popPricing">
                <div class="panelInternoPop" >
                    <!--codigo del video-->
                    <ul class="nav nav-pills nav-stacked col-md-3">
                        <li class="active"><a data-toggle="pill" href="#home">Carga Productos</a></li>
                        <li><a data-toggle="pill" href="#actualiza">Actualiza Productos</a></li>
                        <li><a data-toggle="pill" href="#carga">Carga Productos</a></li>
                        <li><a data-toggle="pill" href="#cargaimg">Carga imagenes</a></li>
                    </ul>
                    
                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active col-md-9">
                            <h3>Crear productos</h3>
                            <?php echo _TUTORIAL_PRODUCTOS?>
                        </div>
                        <div id="actualiza" class="tab-pane fade col-md-9">
                            <h3>Actualiza Productos</h3>
                            <?php echo _TUTORIAL_ACTUALIZA_MASIVOS?>
                        </div>
                        <div id="carga" class="tab-pane fade col-md-9">
                            <h3>Carga masiva de productos</h3>
                            <?php echo _TUTORIAL_PRODUCTOS_MASIVOS?>
                        </div>
                        <div id="cargaimg" class="tab-pane fade col-md-9">
                            <h3>Carga masiva de imágenes</h3>
                            <?php echo _TUTORIAL_IMAGENES_MASIVOS?>
                        </div>
                    </div>
              </div>
          </div>
          <div class="modal-footer"><br><br><br><br>
            <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color:#ed540e; color:#fff; bottom: 20px;right: 20px;">CLOSE WINDOW</button>
          </div>
        </div>
    </div>
</div>