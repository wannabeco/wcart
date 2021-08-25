<div class="container-fluid" ng-controller="pedidos" ng-init="pedidosInit()" id="contenedorUsuarios">

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
                Detalle del pedido: <strong><?php echo $infoPedido['idPedido'] ?></strong> <!--<small>Estructura de las áreas de su empresa</small>-->
                <!-- 
                <?php if(getPrivilegios()[0]['crear'] == 1){ ?>
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
            <li class="active">
                 <a href="<?php echo base_url() ?>Pedidos/controlPedidos/<?php echo $infoModulo['idModulo'] ?>"><?php echo $infoModulo['nombreModulo'] ?></a>
            </li>
            <li>
                Detalle del pedido: <strong><?php echo $infoPedido['idPedido'] ?></strong>
            </li>
        </ol>
        </div>
    </div> 
    <!-- /.row -->
     <div class="row">
        <div class="col-lg-12">
            <p>
            <!-- <blockquote> -->
                <div class="row">
                    <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                        <strong>Cliente</strong><br> 
                        <!--  <?php if($infoPedido['icono'] != ""){ ?>
                          <img class="img img-circle" src="<?php echo base_url() ?>res/fotos/personas/<?php echo $infoPedido['idPersona'] ?>/<?php echo $infoPedido['icono'] ?>" alt="Foto usuario" width="30%">
                          <?php }else{ ?>
                          <img class="img img-circle" src="<?php echo base_url() ?>res/img/user.jpg" alt="Foto usuario" width="30%" >
                          <?php } ?> -->
                        <?php echo $infoPedido['nombre']." ".$infoPedido['apellido'] ?>
                    </div>
                    <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                        <strong>Número de teléfono</strong><br> <?php echo $infoPedido['telefono'] ?>
                    </div>
                    <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                        <strong>Fecha del pedido</strong><br> <?php echo traduceFecha($infoPedido['fechaPedido']) ?>  
                    </div>
                    <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                        <strong>Estado</strong><br> <?php echo $infoPedido['nombreEstadoPedido'] ?>  
                    </div>
                    <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                        <strong>Ciudad</strong><br> <?php echo $infoPedido['nombreCiudad'] ?>  
                    </div>
                    <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                        <strong>Persona que recibe</strong><br> <?php echo $infoPedido['personaContacto'] ?>  
                    </div>
                    <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                        <strong>Dirección de entrega</strong><br> <?php echo $infoPedido['direccionPedido'] ?>  
                    </div>
                    <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                        <strong>Teléfono de entrega</strong><br> <?php echo $infoPedido['telefonoPedido'] ?>  
                    </div>
                    <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                        <strong>Forma de pago</strong><br> 
                        <?php if( $infoPedido['formaPago'] == 1){?>
                            Contra entrega
                        <?php }else{?>
                            Transferencia Bancaria
                        <?php }?>
                    </div>
                    <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                        <strong>Estado Pedido</strong><br> <?php echo $infoPedido['nombreEstadoPedido'] ?>  
                    </div>
                    <div class="col col-lg-6 text-left" style="margin:0 0 2% 0">
                        <strong>Observación del pedido</strong><br> <?php echo $infoPedido['observacion'] ?>  
                    </div>
                </div>
                <!-- <small><strong>Fecha de Entrega:</strong> Lunes 4 de Julio de 2016</small> -->
              <!-- </blockquote>  --> 
            </p>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <!-- <th class="text-center">ID</th> -->
                            <th>PRODUCTO</th>
                            <!-- <th>AREA</th> -->
                            <!-- <th>CARGO</th> -->
                            <!-- <th>VALOR PEDIDO</th> -->
                            <th class="text-center">CANTIDAD</th>
                            <th class="text-center">VALOR KILO</th>
                            <th class="text-center">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  $totalPedido=0;foreach($productosPedido as $pedidos){ 
                                $valorKilosComprados = ($pedidos['valorKilo'] * $pedidos['cantidad']);
                                $totalPedido         +=$valorKilosComprados;
                            ?>
                            <tr>
                                <!-- <td style="vertical-align: middle" class="text-center"><?php echo $pedidos['idPedido'] ?></td> -->
                                <td style="vertical-align: middle"><?php echo $pedidos['nombreProducto'] ?></td>
                                <!-- <td>{{ulist.nombreArea}}</td>
                                <td>{{ulist.nombreCargo}}</td> -->
                                <!-- <td style="vertical-align: middle"></td> -->
                                <td style="vertical-align: middle" align="center">
                                    <?php echo $pedidos['cantidad'] ?>Kgs
                                </td>
                                <td style="vertical-align: middle" align="center">
                                    $<?php echo number_format($pedidos['valorKilo'],0,",","."); ?>
                                </td>
                                <td  class="text-center">
                                    $<?php echo number_format($valorKilosComprados,0,",",".");?>
                                    <!-- <?php if(getPrivilegios()[0]['editar'] == 1){ ?>
                                        <a ng-click="cargaPlantillaControl(ulist.idPersona,1)" title="Editar usuario" class="btn btn-primary btn-fab btn-fab-mini"><i class="material-icons">edit</i></a>
                                        <a ng-click="generaDatosAcceso(ulist.idPersona)" title="Generar datos de acceso" class="btn btn-primary btn-fab btn-fab-mini"><i class="material-icons">https</i></a>
                                    <?php }?> -->
                                    <!-- <?php if(getPrivilegios()[0]['editar'] == 1){ ?>
                                        <a href="<?php echo base_url() ?>Pedidos/detallePedido/<?php echo $infoModulo['idModulo'] ?>/<?php echo ($pedidos['idPedido']) ?>" title="Ver detalle del pedido"  class="btn btn-primary btn-fab btn-fab-mini btn-xs"><i class="material-icons">list</i></a>
                                    <?php }?>
                                    <?php if(getPrivilegios()[0]['borrar'] == 1){ ?>
                                        <a ng-click="borraUsuario(ulist.idPersona)" title="Eliminar"  class="btn btn-danger btn-fab btn-fab-mini btn-xs"><i class="material-icons">delete</i></a>
                                    <?php } ?> -->
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="3" class="text-right">
                                <h4>VALOR ENVÍO</h4>
                            </td>
                            <td class="text-center">
                                <h4>$<?php echo number_format($infoPedido['valorEnvio'],0,",","."); ?></h4>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right">
                                <h4>TOTAL PRODUCTOS</h4>
                            </td>
                            <td class="text-center">
                                <h4>$<?php echo number_format($totalPedido,0,",","."); ?></h4>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right">
                                <h4>TOTAL A COBRAR</h4>
                            </td>
                            <td class="text-center">
                                <h4>$<?php echo number_format($totalPedido+$infoPedido['valorEnvio'],0,",","."); ?></h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right" colspan="4">
                                <select name="estadoPedido" style="padding: 5px 8px">
                                    <option value="">Seleccione</option>
                                    <?php foreach($estados  as $est){?>
                                        <option value=""><?php echo $est['nombreEstadoPedido']?></option>
                                    <?php }?>
                                </select>
                                <input type="button" name="" ng-click="gestionaPedido()" value="GESTIONAR" class="btn btn-primary">
                            </td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.row -->
 </div>
<!-- /.container-fluid -->