<div class="container-fluid" ng-controller="modulos" ng-init="adminInit()" id="contenedorModulos">

<div id="modalCategoria" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <div class="modal-content">
          <form role="form" ng-submit="agregarCategoria()" id="formAgregaPersona">    
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h2 class="modal-title">Agregar nueva categoría</h2>
            <p class="text-justify">
                Las categorías de los módulos ayudan a ordenar el menú de la aplicación
            </p>
          </div>
          <div class="modal-body">  
            <!--<div class="alert alert-primary alert-dismissable">
                <i class="fa fa-info-circle"></i> <?php echo lang("txtPersona4") ?>
            </div>  -->          
              <div class="form-group" id="cajaNombreEmpresa">
                  <input tabindex="1" autocomplete="off" id="categoria" name="categoria" ng-model="categoria" class="ember-view ember-text-field form-control login-input" placeholder="Escriba el nombre de la categoría"  type="text">
                  <p class="help-block">Nombre que identificará la categorría de los módulos</p>
               </div>
          </div>
          <div class="modal-footer">
           <button type="button"  data-dismiss="modal" class="btn  btn-default"><?php echo lang('reg_btn_cancelar') ?></button>
            <button type="submit" class="btn btn-raised btn-primary">GUARDAR CATEGORÍA</button>
          </div>
          </form>
        </div>

      </div>
    </div>


<div id="modalNModulo" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content" id="modalCreaModulo">
        
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

    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-primary alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="fa fa-info-circle"></i> Esta zona es muy importante para la aplicación aquí los súper administradores pueden asignar módulos a los perfiles.
            </div>
        </div>
    </div>
    <!-- /.row -->
    <!--<div class="row">
        <div class="col-lg-12">
                <form class="form-inline">
                  <div class="form-group">
                    <label for="exampleInputName2">Filtro por palabra: </label>
                    <input type="text" class="form-control" id="exampleInputName2" placeholder="">
                  </div>
                </form>
        </div>
    </div>-->
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <h2>
                CATEGORÍAS 

                <?php if(getPrivilegios()[0]['crear'] == 1){ ?>
                <div class="btn-group" >
                    <button type="button" class="btn dropdown-toggle"
                            data-toggle="dropdown">
                      <?php echo lang("lblAcciones") ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                      
                        <li role="separator" class="divider"></li><li class="dropdown-header"><?php echo lang("lblSeleccioneOpc") ?></li>
                        <li><a class="btn" data-toggle="modal" data-target="#modalCategoria"><i class="fa fa-fw fa-plus"></i> AGREGAR NUEVA CATEGORÍA</a></li>
                    </ul>
                </div>
                <?php } ?>
            </h2>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <!--<th class="text-center">ID CATEGORÍA</th>-->
                            <th>NOMBRE CATEGORÍA</th>
                            <!--<th class="text-center">ÍCONO</th>-->
                            <th class="text-center">ESTADO</th>
                            <th class="text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="categorias in modulos">
                            <!--<td class="text-center">{{categorias.idPadre}}</td>-->
                            <td>{{categorias.nombreModulo}}</td>
                            <!--<td class="text-center">Icono</td>-->
                            <td class="text-center">
                                <span class="label label-success" ng-if="categorias.estado==1" value="1" >ACTIVO</span>
                                <span class="label label-default" ng-if="categorias.estado==0" value="0" >INACTIVO</span>
                            </td>
                            <td  class="text-center">
                                <!--<a href="javascript:void(0)" title="Editar" class="btn btn-primary btn-fab btn-fab-mini"><i class="material-icons">edit</i></a>-->
                                <!--<a href="javascript:void(0)" title="Eliminar" class="btn btn-danger btn-fab btn-fab-mini"><i class="material-icons">delete</i></a>-->
                                <?php if(getPrivilegios()[0]['ver'] == 1){ ?>
                                    <a ng-click="consultaModulosCategoria(categorias.idPadre)" title="Ver los módulos de la categoría {{categorias.nombreModulo}}" class="btn btn-default btn-fab btn-fab-mini"><i class="material-icons">view_headline</i></a>
                                <?php }?>
                                <?php if(getPrivilegios()[0]['editar'] == 1){ ?>
                                    <a ng-click="estadoCategoriaPrincipal(categorias.idPadre,categorias.estado)" ng-if="categorias.estado==1" title="Apagar categoría {{categorias.nombreModulo}}" class="btn btn-default btn-fab btn-fab-mini"><i class="material-icons">visibility_off</i></a>

                                    <a ng-click="estadoCategoriaPrincipal(categorias.idPadre,categorias.estado)" ng-if="categorias.estado==0" title="Encender categoría {{categorias.nombreModulo}}" class="btn btn-primary btn-fab btn-fab-mini"><i class="material-icons">visibility</i></a>
                                <?php } ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.row -->

    <div class="row" id="panelModulo" style="display:none">
        <div class="col-lg-12">
            <h2>
                MÓDULOS DE LA CATEGORÍA  
                <?php if(getPrivilegios()[0]['crear'] == 1){ ?>
                    <div class="btn-group" >
                        <button type="button" class="btn dropdown-toggle"
                                data-toggle="dropdown">
                          <?php echo lang("lblAcciones") ?> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li role="separator" class="divider"></li><li class="dropdown-header"><?php echo lang("lblSeleccioneOpc") ?></li>
                            <li><a class="btn" ng-click="cargaPlantillaCreacionModulos('',0)"><i class="fa fa-fw fa-plus"></i> AGREGAR NUEVO MÓDULO</a></li>
                        </ul>
                    </div>
                <?php }?>
            </h2>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <!--<th class="text-center">ID CATEGORÍA</th>-->
                            <th>NOMBRE MÓDULO</th>
                            <!--<th class="text-center">ÍCONO</th>-->
                            <th class="text-center">ESTADO</th>
                            <th class="text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="categorias in modulosInternos">
                            <!--<td class="text-center">{{categorias.idPadre}}</td>-->
                            <td>{{categorias.nombreModulo}}</td>
                            <!--<td class="text-center">Icono</td>-->
                            <td class="text-center">
                                <span class="label label-success" ng-if="categorias.estado==1" value="1" >ACTIVO</span>
                                <span class="label label-default" ng-if="categorias.estado==0" value="0" >INACTIVO</span>
                            </td>
                            <td  class="text-center">
                                <!--<a href="javascript:void(0)" title="Editar" class="btn btn-primary btn-fab btn-fab-mini"><i class="material-icons">edit</i></a>-->
                                <!--<a href="javascript:void(0)" title="Eliminar" class="btn btn-danger btn-fab btn-fab-mini"><i class="material-icons">delete</i></a>-->
                                <?php if(getPrivilegios()[0]['ver'] == 1){ ?>
                                    <a ng-click="cargaPlantillaCreacionModulos(categorias.idPadre,1)" title="Ver configuración del módulo {{categorias.nombreModulo}}" class="btn btn-primary btn-fab btn-fab-mini"><i class="material-icons">description</i></a>
                                <?php } ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>    

    <div class="row" id="panelModulo" style="display:none">
       <div class="col-lg-12">
       </div>
    </div>   

 </div>
            <!-- /.container-fluid -->