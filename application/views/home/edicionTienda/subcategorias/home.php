<div class="container-fluid" ng-controller="gestionTienda" ng-init="initSubcategorias()" id="contenedorUsuarios">

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
                            <li><a class="btn" ng-click="cargaPlantillaControlSubcat('',0)"><i class="fa fa-fw fa-plus"></i> Nueva subcategoría</a></li>
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
                <table class="table table-hover table-striped" ng-if="subCategorias.length > 0">
                    <thead>
                        <tr>
                            <!-- <th class="text-center">ID SUBCATEGORIA</th> -->
                            <th>SUBCATEGORY</th>
                            <th>CATEGORY</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="subCat in subCategorias | filter:q as results">
                            <!-- <td class="text-center">{{subCat.idSubcategoria}}</td> -->
                            <td>{{subCat.nombreSubcategoria}}</td>
                            <td>{{subCat.nombreProducto}}</td>
                            <td align="center">
                                <span class="label label-success" ng-if="subCat.idEstado==1" value="1" >ON</span>
                                <span class="label label-default" ng-if="subCat.idEstado==0" value="0" >OFF</span>
                            </td>
                            <td  class="text-center">
                                <?php if(getPrivilegios()[0]['editar'] == 1){ ?>
                                    <a ng-click="cargaPlantillaControlSubcat(subCat.idSubcategoria,1)" title="Editar" class="btn btn-primary btn-fab btn-fab-mini"><i class="material-icons">edit</i></a>
                                <?php }?>
                                <?php if(getPrivilegios()[0]['borrar'] == 1){ ?>
                                    <a ng-click="eliminaSubCategoria(subCat.idSubcategoria)" title="Eliminar"  class="btn btn-danger btn-fab btn-fab-mini btn-xs"><i class="material-icons">delete</i></a>
                                <?php } ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="alert alert-info" ng-if="subCategorias.length == 0">
                  <strong>Vaya!</strong> aún no has creado ninguna subcategoría. <button class="btn" style="background:#fff;color:#333" ng-click="cargaPlantillaControlSubcat('',0)">CREAR MI PRIMERA SUBCATEGORÍA</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
 </div>
<!-- /.container-fluid -->
<!--modal de tutorial-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
            <h2 class="modal-title" id="myModalLabel" style="font-family: 'Roboto'; text-transform: uppercase;  color: #333;">Crear categorias</h2>
          </div>
          <div class="modal-body">
          <div class="panelPopUp" id="popPricing">
                <div class="panelInternoPop" >
                    <!--codigo del video-->
                <iframe width="560" height="315" src="https://www.youtube.com/embed/eBEmEfQZo1Q" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
              </div>
          </div>
          <div class="modal-footer"><br><br>
            <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color:#ed540e; color:#fff; bottom: 20px;right: 20px;">CLOSE WINDOW</button>
          </div>
        </div>
    </div>
</div>