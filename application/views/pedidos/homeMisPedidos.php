<div class="container-fluid" ng-controller="pedidos" ng-init="misPedidosInit()" id="contenedorUsuarios" data-infoTienda ='<?php echo $infoTienda;?>'>
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
                <table class="table table-hover table-striped" id="tablaPedido">
                    <thead>
                        <tr>
                            <!-- <th class="text-center">ID</th> -->
                            <th class="text-center">Id Pedido</th>
                            <th class="text-center">Codigo Pedido</th>
                            <th class="text-center"><?php echo lang("text19.17")?></th>
                            <th class="text-center"><?php echo lang("lbl_not_5")?></th>
                            <th class="text-center"><?php echo lang("text22")?></th>
                            <th class="text-center"><?php echo lang("text40")?></th>
                            <th class="text-center"><?php echo lang("text19.18")?></th>
                            <th class="text-center"><?php echo lang("text19.19")?></th>
                            <th class="text-center"><?php echo lang("lblAcciones")?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($listaPedidos as $pedidos){ 
                            ?>
                            <tr>
                                <td><?php echo $pedidos['idPedido'] ?></td> 
                                <td><?php echo $pedidos['codigoPedido'] ?></td> 
                                <td><?php echo $pedidos['fechaPedido'] ?> </td>
                                <td><?php echo $pedidos['nombre'] ?> <?php echo $pedidos['apellido'] ?></td>
                                <!-- <td>{{ulist.nombreArea}}</td>
                                <td>{{ulist.nombreCargo}}</td> -->
                                <!-- <td style="vertical-align: middle"></td> -->
                                <td style="vertical-align: middle" align="center">$ <?php echo number_format($pedidos['valor'],0,',','.') ?></td>
                                <td>
                                    <?php if( $pedidos['formaPago'] == 1){?>
                                        <span class="label label-primary"><?php echo lang("lbl_pago_1")?></span>
                                    <?php }else if( $pedidos['formaPago'] == 3){?>
                                        <span class="label label-clear"><?php echo lang("lbl_pago_2")?></span>
                                    <?php }else if( $pedidos['formaPago'] == 2){?>
                                       <span class="label label-success"> PAYULatam</span>
                                    <?php }else if( $pedidos['formaPago'] == 4){?>                            
                                        <span class="label label-warning">Wompi </span>
                                    <?php }else if( $pedidos['formaPago'] == 5){?>                            
                                        <span class="label label-danger">Stripe</span>
                                    <?php }else if( $pedidos['formaPago'] == 6){?>                            
                                        <span class="label label-info"><?php echo lang("lbl_pago_3")?></span>
                                    <?php }else{?>
                                        <span class="label label-default"><?php echo lang("lbl_pago_4")?></span>
                                    <?php }?>
                                    
                                </td>
                                <td style="vertical-align: middle" align="left">    
                                    <span class="label <?php echo estadoPago($pedidos['estadoPago'])['label'] ?>"><?php echo estadoPago($pedidos['estadoPago'])['texto'] ?></span>
                                </td>
                                <td style="vertical-align: middle" align="center" <?php if($pedidos['estadoPedido'] == 5){ ?> colspan="1"<?php }?>>
                                    <span class="label <?php echo $pedidos['label'] ?>"><?php echo $pedidos['nombreEstadoPedido'] ?></span>
                                </td>

                                <td  class="text-center">
                                    <!-- <?php if(getPrivilegios()[0]['editar'] == 1){ ?>
                                        <a ng-click="cargaPlantillaControl(ulist.idPersona,1)" title="Editar usuario" class="btn btn-primary btn-fab btn-fab-mini"><i class="material-icons">edit</i></a>
                                        <a ng-click="generaDatosAcceso(ulist.idPersona)" title="Generar datos de acceso" class="btn btn-primary btn-fab btn-fab-mini"><i class="material-icons">https</i></a>
                                    <?php }?> -->
                                    <?php if(getPrivilegios()[0]['editar'] == 1){ ?>
                                        <a href="<?php echo base_url() ?>Pedidos/detalleMiPedido/<?php echo $infoModulo['idModulo'] ?>/<?php echo ($pedidos['idPedido']) ?>" title="Ver detalle del pedido"  class="btn btn-primary btn-fab btn-fab-mini btn-xs"><i class="material-icons">list</i></a>
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