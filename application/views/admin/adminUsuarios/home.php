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
                <?php echo $infoModulo['nombreModulo'] ?> <!--<small>Estructura de las áreas de su empresa</small>-->
                <?php if ($_SESSION['project']['info']['idPerfil'] == 6 || $_SESSION['project']['info']['idPerfil'] == 1){?>
                <button title="Exportar excel" ng-click="xportExcel()"><i class="fas fa-file-excel"></i></button><!-- boton exportar excel customers o usuarios en administrador-->
                <?php } ?>
                <?php if(getPrivilegios()[0]['crear'] == 1){ ?>
                    <div class="btn-group" >
                        <button type="button" class="btn dropdown-toggle"
                                data-toggle="dropdown">
                          <?php echo lang("lblAcciones") ?> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          
                            <li role="separator" class="divider"></li><li class="dropdown-header"><?php echo lang("lblSeleccioneOpc") ?></li>
                            <li><a class="btn" ng-click="cargaPlantillaControl('',0)"><i class="fa fa-fw fa-plus"></i><?php echo $tituloBoton ?></a></li>
                        </ul>
                    </div>
                <?php } ?>
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
                <table class="table table-hover table-striped" id="tableUsuarios">
                    <thead>
                        <tr>
                            <?php if ($_SESSION['project']['info']['idPerfil'] == 1 || $_SESSION['project']['info']['idPerfil'] == 2 ){ ?>
                            <th class="text-left">id Persona</th>
                            <?php }?>
                            <th>NOMBRE</th>
                            <!-- <th>AREA</th> -->
                            <!-- <th>CARGO</th> -->
                            <th>PERFIL</th>
                            <th>TELEFONO</th>
                            <th>EMAIL</th>
                            <?php if ($_SESSION['project']['info']['idPerfil'] == 1 || $_SESSION['project']['info']['idPerfil'] == 2 ){?>
                             <th class="text-center">ACCESO</th>
                            <?php }?>
                            <th class="text-center">ESTADO</th>
                            <?php if ($_SESSION['project']['info']['idPerfil'] == 1 || $_SESSION['project']['info']['idPerfil'] == 2 ){?>
                            <th class="text-center">ACCIONES</th>
                            <?php }?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="ulist in usuarios  | filter:q as results" ng-if="ulist.idPersona != 1">
                            <?php if ($_SESSION['project']['info']['idPerfil'] == 1 || $_SESSION['project']['info']['idPerfil'] == 2 ){ ?>
                            <td class="text-left">{{ulist.idPersona}}</td>
                            <?php }?>
                            <!-- <td class="text-center">{{ulist.nroDocumento}}</td> -->
                            <td>{{ulist.nombre}} {{ulist.apellido}}</td>
                            <!-- <td>{{ulist.nombreArea}}</td>
                            <td>{{ulist.nombreCargo}}</td> -->
                            
                            <td>{{ulist.nombrePerfil}}</td>
                            <td>{{ulist.celular}}</td>
                            <td>{{ulist.email}}</td>
                            <?php if ($_SESSION['project']['info']['idPerfil'] == 1 || $_SESSION['project']['info']['idPerfil'] == 2 ){?>
                            <td class="text-center">
                               <i class="material-icons" title="Este usuario posee datos de acceso a la plataforma. Usuario y clave">https</i>
                            </td>
                            <?php }?>
                            <td align="center">
                                <span class="label label-success" ng-if="ulist.estado==1" value="1" >ACTIVO</span>
                                <span class="label label-default" ng-if="ulist.estado==0" value="0" >INACTIVO</span>
                            </td>
                            <?php if ($_SESSION['project']['info']['idPerfil'] == 1 || $_SESSION['project']['info']['idPerfil'] == 2 ){?>
                            <td class="text-center">
                                <?php if(getPrivilegios()[0]['editar'] == 1){ ?>
                                    <a ng-click="cargaPlantillaControl(ulist.idPersona,1)" title="Editar usuario" class="btn btn-primary btn-fab btn-fab-mini"><i class="material-icons">edit</i></a>
                                    <a ng-click="generaDatosAcceso(ulist.idPersona)" title="Generar datos de acceso" class="btn btn-primary btn-fab btn-fab-mini"><i class="material-icons">https</i></a>
                                <?php }?>
                                <?php if(getPrivilegios()[0]['borrar'] == 1){ ?>
                                    <a ng-click="borraUsuario(ulist.idPersona)" title="Eliminar"  class="btn btn-danger btn-fab btn-fab-mini btn-xs"><i class="material-icons">delete</i></a>
                                <?php } ?>
                            </td>
                            <?php }?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.row -->
 </div>
<!-- /.container-fluid -->