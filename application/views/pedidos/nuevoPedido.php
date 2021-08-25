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
                Nuevo pedido <small>Código: <?php echo $_SESSION['refPedido'] ?></small>
                
                <?php if(getPrivilegios()[0]['crear'] == 1){ ?>
                    <div class="btn-group" >
                        <button type="button" class="btn dropdown-toggle"
                                data-toggle="dropdown">
                          <?php echo lang("lblAcciones") ?> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          
                            <li role="separator" class="divider"></li><li class="dropdown-header"><?php echo lang("lblSeleccioneOpc") ?></li>
                            <li><a class="btn" ng-click="cargaPlantillaAgregaProducto('',0)"><i class="fa fa-fw fa-plus"></i> AGREGAR PRODUCTO</a></li>
                        </ul>
                    </div>
                <?php } ?> 
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="active">
                     <a href="<?php echo base_url() ?>Pedidos/misPedidos/<?php echo $infoModulo['idModulo'] ?>">Pedidos</a>
                </li>
                <li class="active">
                     Nuevo pedido
                </li>
            </ol>
        </div>
    </div> 
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive" id='tableResultadoPedido'>
                <!-- <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>PRODUCTO</th>
                            <th>PRESENTACIÓN</th>
                            <th>CANTIDAD</th>
                            <th>VALOR UNITARIO</th>
                            <th>VALOR TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table> -->
            </div>
        </div>
    </div>
    <!-- /.row -->
 </div>
<!-- /.container-fluid -->