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
            <br>
            <center><img src="<?php echo base_url()?>assets/uploads/files/logoApp.png" width="50%"></center><br>
            <h1 class="page-header" style="font-size:1.8em">
                <strong><?php echo lang("text35")?></strong>
            </h1>
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
                                <td><?php echo lang("text37")?></td>
                                <td><span class="label <?php echo $claseLabel ?>"><?php echo $estadoTx; ?></span></td>
                            </tr>
                            <tr><!-- 
                            <tr>
                            <td>ID de la transaccion</td>
                            <td><?php echo $transactionId; ?></td>
                            </tr> -->
                            <tr>
                                <td><?php echo lang("cod_pago_label")?></td>
                                <td><?php echo $reference_pol; ?></td> 
                            </tr>
                            <tr>
                                <td><?php echo lang("cod_pedido_label")?></td>
                                <td><?php echo $referenceCode; ?></td> 
                            </tr>
                            <tr>
                                <td><?php echo lang("text40")?></td>
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
                                <td><?php echo lang("lbl_bank")?> </td>
                                <td><?php echo $pseBank; ?> </td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td><?php echo lang("text41")?></td>
                                <td><?php echo $infoTienda['currency']?><?php echo number_format($TX_VALUE); ?></td>
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
                            <div class="alert alert-primary text-center">
                                <strong><?php echo lang("text36")?></strong>
                            </div>


                        <?php
                        }
                        else
                        {
                        ?>
                            <h1>Error validando firma digital.</h1>
                        <?php
                        }
                        ?>
                                <!-- <h2><?php echo lang("text36")?></h2> -->

        </div>
    </div>
    <!-- /.row -->
 </div>
<!-- /.container-fluid -->