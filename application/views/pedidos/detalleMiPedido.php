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
                 <a href="<?php echo base_url() ?>Pedidos/misPedidos/<?php echo $infoModulo['idModulo'] ?>"><?php echo $infoModulo['nombreModulo'] ?></a>
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
                        <strong>Fecha del pedido</strong><br> <?php echo traduceFecha($infoPedido['fechaPedido']) ?> a las <?php echo explode(" ",$infoPedido['fechaPedido'])[1] ?>
                    </div>
                    <?php if($infoPedido['estadoPedido'] == 4){ ?>
                        <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                            <strong>Fecha de pago y despacho</strong><br> 
                            <?php if(($infoPedido['estadoPedido'] == 4 && $infoPedido['estadoPago'] == _ID_ESTADO_PAGO)){ ?>
                                <?php echo traduceFecha($infoPedido['fechaEntrega']) ?> a las <?php echo explode(" ",$infoPedido['fechaEntrega'])[1] ?>
                            <?php }else{ ?>
                                El pedido no ha sido despachado a&uacute;n
                            <?php } ?>
                        </div>
                    <?php } ?>


                    <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                        <strong>Código de pedido</strong><br> <?php echo $infoPedido['codigoPedido'] ?>  
                    </div>
                    <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                        <strong>Forma de pago</strong><br> 
                        <?php if( $infoPedido['formaPago'] == 1){?>
                            Contra entrega Efectivo
                        <?php }else if( $infoPedido['formaPago'] == 3){?>
                            Contraentrega datafono
                        <?php }else if( $infoPedido['formaPago'] == 2){?>
                            PAYULatam (<?php echo $infoPedido['entidad']?>)
                        <?php }else if( $infoPedido['formaPago'] == 4){?>                            
                            Wompi (<?php echo $infoPedido['entidad']?>)
                        <?php }else if( $infoPedido['formaPago'] == 5){?>                            
                            Stripe (<?php echo $infoPedido['entidad']?>)
                        <?php }else if( $infoPedido['formaPago'] == 6){?>                            
                            Payment on pick up
                        <?php }else{?>
                            Otros
                        <?php }?>
                    </div>
                    <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                        <strong>Estado Pedido</strong><br> 
                        <label class="label <?php echo $infoPedido['label'] ?>"><?php echo $infoPedido['nombreEstadoPedido'] ?>  </label>
                    </div>
                    <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                        <strong>Estado del pago</strong><br> 
                        <span class="label <?php echo estadoPago($infoPedido['estadoPago'])['label'] ?>"><?php echo estadoPago($infoPedido['estadoPago'])['texto'] ?></span>
                    </div>
                    <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                        <strong>Direccion</strong><br>
                        <?php echo $infoPedido['direccion'] ?>
                    </div>
                    <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                        <strong>Celular</strong><br>
                        <?php echo $infoPedido['celular'] ?>
                    </div>
                    <!--<?php if( $infoPedido['formaPago'] != 1){?>
                        <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                            <strong>Id transacción PAYU</strong><br>
                            <?php echo $infoPedido['transactionId'] ?>
                        </div>
                        <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                            <strong>Moneda</strong><br>
                            <?php echo $infoPedido['moneda'] ?>
                        </div>
                        <div class="col col-lg-4 text-left" style="margin:0 0 2% 0">
                            <strong>Entidad</strong><br>
                            <?php echo $infoPedido['entidad'] ?>
                        </div>
                    <?php } ?>-->
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
                            <th>CATEGORIA</th>
                            <th>PEDIDO</th>
                            <th class="text-center">CANTIDAD</th>
                            <th class="text-center">VALOR KILO</th>
                            <th class="text-center">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  $totalPedido=0;foreach($productosPedido as $pedidos){ 
                                $valorKilosComprados = ($pedidos['valorPresentacion'] * $pedidos['cantidad']);
                                $totalPedido         +=$valorKilosComprados;
                            ?>
                            <tr>
                                <!-- <td style="vertical-align: middle" class="text-center"><?php echo $pedidos['idPedido'] ?></td> -->
                                <td style="vertical-align: middle"><?php echo $pedidos['nombreProducto'] ?></td>
                                <td style="vertical-align: middle"><?php echo $pedidos['nombrePresentacion'] ?></td>
                                <!-- <td>{{ulist.nombreArea}}</td>
                                <td>{{ulist.nombreCargo}}</td> -->
                                <!-- <td style="vertical-align: middle"></td> -->
                                <td style="vertical-align: middle" align="center">
                                    <?php echo $pedidos['cantidad'] ?>
                                </td>
                                <td style="vertical-align: middle" align="center">
                                    $<?php echo number_format($pedidos['valorPresentacion'],0,",","."); ?>
                                </td>
                                <td  class="text-center">
                                    $<?php echo number_format($valorKilosComprados,0,",",".");?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="4" class="text-right">
                                <h4>VALOR DOMICILIO</h4>
                            </td>
                            <td class="text-center">
                                <h4>$<?php echo number_format($infoPedido['valorDomicilio'],0,",","."); ?></h4>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">
                                <h4>VALOR PEDIDO</h4>
                            </td>
                            <td class="text-center">
                                <h4>$<?php echo number_format($infoPedido['valor'],0,",","."); ?></h4>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">
                                <h4>TOTAL</h4>
                            </td>
                            <td class="text-center">
                                <h4>$<?php echo number_format($infoPedido['valor'] + $infoPedido['valorDomicilio'],0,",","."); ?></h4>
                            </td>
                        </tr>
                      
                    </tbody>
                </table>
               

            </div>
        </div>

        <?php  if($_SESSION['project']['info']['idPerfil'] == _PERFIL_ADMIN or $_SESSION['project']['info']['idPerfil'] == 6){?>
                    
                        
                    <div class="row">
                        <div class="col col-lg-12">
                            <h2>Gestionar el pedido</h2>
                        </div>
                        <div class="col col-lg-3">
                            <select name="estadoPago" class="form-control" id="estadoPago" style="padding: 5px 8px">
                                <option value="">Estado del pago</option>
                                <option value="000" <?php if($infoPedido['estadoPago'] == '000'){ ?> selected <?php }?> >Esperando pago</option>
                                <option value="998" <?php if($infoPedido['estadoPago'] == '998'){ ?> selected <?php }?> >Pago realizado</option>
                            </select>
                        </div>
                        <div class="col col-lg-3">
                            <select name="estadoPedido" class="form-control" id="estadoPedido" style="padding: 5px 8px">
                                <option value="">Estado del pedido</option>
                                <?php foreach($estados  as $est){?>
                                    <option value="<?php echo $est['idEstadoPedido'] ?>" <?php if($infoPedido['estadoPedido'] == $est['idEstadoPedido']){ ?> selected <?php }?>><?php echo $est['nombreEstadoPedido']?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col col-lg-2" style="margin:20px 0 0 0">
                            <input type="hidden" id="idPedido" name="idPedido" value="<?php echo $infoPedido['idPedido'] ?>">
                            <input type="button" style="background: #03a9f4 !important;color: #fff !important" name="" ng-click="gestionaPedido()" value="GESTIONAR" class="btn btn-primary">
                        </div>
                        <!-- boton imprimir factura
                        <div class="col col-lg-2"  style="margin:20px 0 0 0">
                                <a class="btn" target="_blank" style="background: #333 !important;color: #fff !important" href="<?php echo base_url()?>Pedidos/imprimeFacturaTicket/<?php echo $infoPedido['idPedido']?>" class="btn btn-info">VER FACTURA<a>
                        </div>-->
                     </div>
        <?php } ?>
    </div>
    <!-- /.row -->
 </div>
<!-- /.container-fluid -->