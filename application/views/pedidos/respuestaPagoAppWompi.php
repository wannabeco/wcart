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
            <center><img src="<?php echo base_url()?>assets/uploads/files/<?php echo $infoTienda['idTienda']?>/<?php echo $infoTienda['logoTienda']?>" width="50%"></center><br>
            <h4 class="text-center">
                <strong><?php echo lang("text35")?></strong>
            </h4>
        </div>
    </div> 
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
                <?php
                        ?>
                            <table class="table">
                            <tr>
                            <td><?php echo lang("text37")?></td>
                            <td><span class="label <?php echo $claseLabel ?>"><?php echo $estadoTx; ?></span></td>
                            </tr>
                            <tr>
                            <tr>
                            <td><?php echo lang("text38")?></td>
                            <td><?php echo $transactionId; ?></td>
                            </tr>
                            <tr>
                            <td><?php echo lang("text39")?></td>
                            <td><?php echo $referenceCode; ?></td> 
                            </tr>
                            <tr>
                            <td><?php echo lang("text40")?></td>
                            <td><?php echo $lapPaymentMethod; ?></td> 
                            </tr>
                           
                            <td><?php echo lang("text41")?></td>
                            <td><?php echo $infoTienda['currency']?><?php echo number_format($valor); ?></td>
                            </tr>
                            </table>
                        
                            <div class="alert alert-primary text-center">
                <strong><?php echo lang("text36")?></strong>
</div>

        </div>
    </div>
    <!-- /.row -->
 </div>
<!-- /.container-fluid -->