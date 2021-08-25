<div class="container-fluid" ng-controller="ingresoProducto" ng-init="initIngresoProduco()" id="contenidoIngreso">
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
                            <li><a class="btn" ng-click="cargaPlantillaProducto('',0)"><i class="fa fa-fw fa-plus"></i> AGREGAR PRODUCTO</a></li>
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
    <div class="row">
        <div class="col-lg-12">
            <form class="form-inline">
              <div class="form-group  label-floating">
                <label class="control-label" for="tipoDocumento">Filtrar por palabra</label>
                <input type="text" class="form-control" ng-model="q" placeholder=""><br>
              </div>
            </form>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">FECHA</th>
                            <th class="text-center">CANTIDAD</th>
                            <th class="text-center">CAJAS</th>
                            <th class="text-center">PRODUCTO</th>
                            <th class="text-center">RECIBIDO POR</th>
                            <th class="text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($listaEntradas as $pedidos){ 
                            ?>
                            <tr>
                                <td style="vertical-align: middle" class="text-center"><?php echo $pedidos['idInventario'] ?></td>
                                <td style="vertical-align: middle" class="text-center"><?php echo traduceFecha($pedidos['fechaRecibido']) ?> </td>
                                <td style="vertical-align: middle" class="text-center"><?php echo $pedidos['cantidadKilos'] ?>Kgs </td>
                                <td style="vertical-align: middle" class="text-center"><?php echo $pedidos['cantidadCajas'] ?> </td>
                                <td style="vertical-align: middle" class="text-center"><?php echo $pedidos['nombreProducto'] ?> </td>
                                <td style="vertical-align: middle" class="text-center"><?php echo $pedidos['nombre'] ?> <?php echo $pedidos['apellido'] ?></td>
                               
                                <td  class="text-center">

                                    <?php if(getPrivilegios()[0]['editar'] == 1){ ?>
                                        <a ng-click="cargaPlantillaProducto(<?php echo $pedidos['idInventario'] ?>,1)" title="Editar usuario" class="btn btn-primary btn-fab btn-fab-mini"><i class="material-icons">edit</i></a><!-- 
                                        <a ng-click="generaDatosAcceso(ulist.idPersona)" title="Generar datos de acceso" class="btn btn-primary btn-fab btn-fab-mini"><i class="material-icons">https</i></a> -->
                                    <?php }?>
                                    <?php if(getPrivilegios()[0]['editar'] == 1){ ?>
                                       <!--  <a href="<?php echo base_url() ?>Pedidos/detalleMiPedido/<?php echo $infoModulo['idModulo'] ?>/<?php echo ($pedidos['idInventario']) ?>" title="Ver detalle del pedido"  class="btn btn-primary btn-fab btn-fab-mini btn-xs"><i class="material-icons">list</i></a> -->
                                    <?php }?>
                                    <!-- <?php if(getPrivilegios()[0]['borrar'] == 1){ ?>
                                        <a ng-click="borraUsuario(ulist.idPersona)" title="Eliminar"  class="btn btn-danger btn-fab btn-fab-mini btn-xs"><i class="material-icons">delete</i></a>
                                    <?php } ?> -->
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.row -->
 </div>
<!-- /.container-fluid -->