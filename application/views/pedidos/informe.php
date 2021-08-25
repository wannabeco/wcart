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
                <?php echo $infoModulo['nombreModulo'] ?> <!--<small>Estructura de las áreas de su empresa</small>-->
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
            <li>
                <?php echo $infoModulo['nombreModulo'] ?>
            </li>
        </ol>
        </div>
    </div> 
    <!-- /.row -->

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
           <table class="table">
                <thead>
                    <tr>
                        <th>NOMBRE</th>
                        <th>APELLIDO</th>
                        <th>PRODUCTO</th>
                        <th>PRESENTACIÓN</th>
                        <th class="text-center">CANTIDAD</th>
                        <th class="text-center">COSTO</th>
                    </tr>
                </thead>
                <tbody>
               <?php $sumaCant=0;$sumaCosto=0; foreach($informe as $info){ ?>
                    <tr>
                        <td><?php echo $info['nombre'] ?></td>
                        <td><?php echo $info['apellido'] ?></td>
                        <td><?php echo $info['nombreProducto'] ?></td>
                        <td><?php echo $info['nombrePresentacion'] ?></td>
                        <td class="text-center"><?php echo $info['cantidad'] ?></td>
                        <td class="text-center">$<?php echo number_format($info['valorPresentacion']) ?></td>
                    </tr>
               <?php $sumaCant+=$info['cantidad']; 
                    $sumaCosto += $info['valorPresentacion'];
                } ?>
               </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-right">TOTAL</th>
                        <th class="text-center"><?php echo $sumaCant ?></th>
                        <th class="text-center">$<?php echo number_format($sumaCosto) ?></th>
                    </tr>
                </tfoot>
           </table>
        </div>
    </div>

    <!-- /.row -->
 </div>
<!-- /.container-fluid -->