<form role="form" enctype="multipart/form-data"  ng-controller="gestionTienda" ng-init="initProductos()" id="formulario" ng-submit="infoComentarios(<?php echo $ver ?>)">    
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">Comentarios</h2>
        <p class="text-justify">
            <?php echo $datos['nombrePresentacion']?>
        </p>
    </div>
    <div class="modal-body">    
        <div class="row">
            <?php if(count($infoComentarios) > 0){?>
                <?php foreach($infoComentarios as $idComentario){?>
                    <div class="col col-lg-12" style="border-bottom:1px solid #ccc; padding: 3% ;">    
                        <h3 style="position:relative; float:left; margin: 0 0 5px 0; width:100%; font-weight:bold">
                            <?php echo $idComentario['nombre']." ".$idComentario['apellido'];?>
                            <!-- calificacion -->
                                <label style="position:relative; float:right; " for="">
                                    <?php 
                                        for($i = 1; $i <= $idComentario['calificacion']; $i++){
                                            echo "<i title='Calificación' class='fas fa-star text-primary'></i>";
                                        }
                                        $estrellas = 5- $idComentario['calificacion'];                          
                                        for($a = 1;$a <= $estrellas; $a++){
                                            echo "<i title='Calificación' class='far fa-star text-primary'></i>";
                                        }
                                    ?> 
                                </label> 
                        </h3>
                        <p style="position:relative; float:left; margin: 0 0 0 0; width: 100%;" class="text-justify">
                            <?php echo $idComentario['comentario']?><br>
                            <small><?php echo traduceFecha($idComentario['fechaComentario'])?></small>
                            <?php if(getPrivilegios()[0]['borrar'] == 1){ ?>
                                <a ng-click="eliminarComentario(<?php echo $idComentario['idCom'];?>,<?php echo $idComentario['idPresentacion'];?>,<?php echo $idComentario['votantes'];?>,<?php echo $idComentario['puntos'];?>,<?php echo $idComentario['calificacion'];?>)" title="Eliminar comentario" style="position:relative; float:right; cursor:pointer; " class="text-danger">Eliminar comentario</a>
                            <?php } ?>
                            <!--  -->
                        </p>    
                    </div>
                <?php }?>
                <?php } else { ?>
                    <div class="col col-lg-12" style="border-bottom:1px solid #ccc; padding: 3% ;"> 
                        <div class="alert alert-primary" role="alert">
                            No hay comentarios para este producto.
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button"  data-dismiss="modal" class="btn  btn-info"><?php echo lang('reg_btn_cancelar') ?></button>
    </div>
</form>
