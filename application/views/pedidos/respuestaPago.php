<div class="container-fluid" ng-controller="pedidos" ng-init="nuevoPedidoInit()" id="contenedorUsuarios">

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
                Resumen de la transacción
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="active">
                     <a href="<?php echo base_url() ?>Pedidos/misPedidos/37">Pedidos</a>
                </li>
                <li class="active">
                     Resumen de la transacción
                </li>
            </ol>
        </div>
    </div> 
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
                <?php
                        if (strtoupper($firma) != strtoupper($firmacreada)) {
                        ?>
                            <table class="table">
                            <tr>
                            <td>Estado de la transaccion</td>
                            <td><span class="label <?php echo $claseLabel ?>"><?php echo $estadoTx; ?></span></td>
                            </tr>
                            <tr><!-- 
                            <tr>
                            <td>ID de la transaccion</td>
                            <td><?php echo $transactionId; ?></td>
                            </tr> -->
                            <tr>
                            <td>Codigo de pago PAYU</td>
                            <td><?php echo $reference_pol; ?></td> 
                            </tr>
                            <tr>
                            <td>Código del pedido</td>
                            <td><?php echo $referenceCode; ?></td> 
                            </tr>
                            <tr>
                            <td>Método de pago</td>
                            <td><?php echo $lapPaymentMethod; ?></td> 
                            </tr>

                            <!-- 
                            <tr>
                            <td>Referencia de la transaccion</td>
                            <td><?php echo $referenceCode; ?></td>
                            </tr>
                            <tr> -->
                            <?php
                            if($pseBank != null) {
                            ?>
                                <tr>
                                <td>cus </td>
                                <td><?php echo $cus; ?> </td>
                                </tr>
                                <tr>
                                <td>Banco </td>
                                <td><?php echo $pseBank; ?> </td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                            <td>Valor total</td>
                            <td>$<?php echo number_format($TX_VALUE); ?></td>
                            </tr>
                            <!-- <tr>
                            <td>Moneda</td>
                            <td><?php echo $currency; ?></td>
                            </tr>
                            <tr>
                            <td>Descripci贸n</td>
                            <td><?php echo ($extra1); ?></td>
                            </tr>
                            <tr>
                            <td>Entidad:</td>
                            <td><?php echo ($lapPaymentMethod); ?></td>
                            </tr> --><!-- 
                            <tr>
                                <td colspan="2" align="center">
                                    <a href="<?php echo _DOMINIO ?>pedidos" class="btn btn-skin">Ver mis pedidos</a>
                                </td>
                            </tr> -->
                            </table>
                        <?php
                        }
                        else
                        {
                        ?>
                            <h1>Error validando firma digital.</h1>
                        <?php
                        }
                        ?>
                                <a href="<?php echo base_url() ?>Pedidos/misPedidos/37" class="btn btn-primary">Regresar los pedidos</a>

        </div>
    </div>
    <!-- /.row -->
 </div>
<!-- /.container-fluid -->