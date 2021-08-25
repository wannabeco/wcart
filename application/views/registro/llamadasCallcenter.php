<div id="modal" class="modal fade" role="dialog"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content" id="modalData">
            <!--Form de creación -->
        </div>
    </div>
</div>

<!-- <div class="container"> -->
	<h3 class="text-center">LISTADO DE CLIENTES REGISTRADOS ESMERALDA QUALITY FRUIT (TOTAL <?php echo count($personas)?>)</h3>
	<div class="table-responsive">
		<table class="table" id="mytable">
			<thead>
				<tr>
					<th class="text-center" colspan="4">
						<div class="form-group">
							<input type="text" class="form-control pull-left" id="search" placeholder="Buscar en el listado">
						</div>
					</th>
					<th colspan="8">
						
					</th>
				</tr>
				<tr>
					<?php if($camposMostrar == 1){?>	
						<th>ID</th>
					<?php }?>
					<th>CLIENTE</th>
					<th>VENDEDORA</th>
					<th>CONJUNTO</th>
					<th>TORRE</th>
					<th>APTO</th>
					<th>EMAIL</th>
					<th>FECHA DE REGISTRO</th>
					<th>CELULAR</th>
					<?php if($camposMostrar == 1){?>
						<th>VENTAS</th>
						<th>OBS</th>
						<th>&nbsp;</th>
					<?php }?>
				</tr>
			</thead>
			<tbody>
				<?php $sumaTotalVentas = 0;foreach($personas as $per){ 
					$vendedora = $this->logica->getPersonas(array('idPersona'=>$per['idPadre']));
					$obsevaciones = $this->logica->getObservacionesUsuario(array('idPersona'=>$per['idPersona']));
					// $mensajeMostrar = (count($obsevaciones['datos']) > 0)?$obsevaciones['datos'][0]['observaciones']:'';
					$color = (count($obsevaciones['datos']) > 0)?'#fffabf':'';
				?>
					<tr style="background: <?php echo $color?>">
						<?php if($camposMostrar == 1){?>	
							<td style="vertical-align: middle"><?php echo $per['idPersona']?></td>
						<?php }?>
						<td style="vertical-align: middle"><?php echo $per['nombre']?> <?php echo $per['apellido']?></td>
						<td style="vertical-align: middle"><?php echo $vendedora[0]['nombre']?> <?php echo $vendedora[0]['apellido']?></td>
						<td style="vertical-align: middle"><?php echo $per['nombreConjunto']?></td>
						<td style="vertical-align: middle" class="text-center"><?php echo $per['torre']?></td>
						<td style="vertical-align: middle" class="text-center"><?php echo $per['apto']?></td>
						<td style="vertical-align: middle;width: 200px !important"><?php echo $per['email']?></td>
						<td style="vertical-align: middle"><?php echo $per['fechaIngreso']?></td>
						<td style="vertical-align: middle"><?php echo (strlen($per['celular']) == 7)?"035 ".$per['celular']."<span class='badge'>Número Fijo<span>":$per['celular']; ?></td>

						<?php if($camposMostrar == 1){?>	

							<td class="text-center" style="vertical-align: middle">
								<?php $cantidadVentas = cantidadComprasUsuario($per['idPersona']); ?>
								<?php $sumaTotalVentas += count($cantidadVentas);?>
								<?php echo count($cantidadVentas); ?>
							</td>
							<td style="vertical-align: middle">
								<?php if(count($obsevaciones['datos']) > 0){ ?>
									<ul style="padding: 0">
										<?php foreach($obsevaciones['datos'] as $obs){ ?>
											<li><?php echo $obs['observaciones'] ?></li>
										<?php }?>
									</ul>
								<?php }?>	
							</td>
							<td style="vertical-align: middle">
								<div class="btn-group">
								  <button type="button" class="btn btn-default dropdown-toggle"
								          data-toggle="dropdown">
								    ACCIONES <span class="caret"></span>
								  </button>

								  <ul class="dropdown-menu" role="menu">
								    <li><a style="cursor:pointer" ng-click="plantillaLlamada(<?php echo $per['idPersona']?>)"><i class="fa fa-phone"></i> Reporte de llamada</a></li>
								    <li><a style="cursor:pointer" ng-click="plantillaPedidoExterno(<?php echo $per['idPersona']?>)"><i class="fa fa-shopping-cart"></i> Hacer Pedido</a></li>
								    <li><a style="cursor:pointer" ng-click="plantillaActualizaDatos(<?php echo $per['idPersona']?>)"><i class="fa fa-edit"></i> Actualizar datos</a></li>
								    <!-- <li><a href="#"><i class="fa fa-key"></i> Enviar datos de ingreso</a></li> -->
								    <?php if(strlen($per['celular']) == 10){?>
									    <li><a target="_blank" href="https://api.whatsapp.com/send?phone=+57<?php echo $per['celular']?>&text=Hola, <?php echo $per['nombre'].' '.$per['apellido']?>, soy Esmeralda, de la empresa *Esmeralda Quality Fruit*, hace un par de días estuvimos cerca de su conjunto residencial entregando una prueba de nuestro producto, el limón tahití, hoy nos ponemos en contacto con ud para saber su opinión al respecto, tiene unos minutos de su tiempo?"><i class="fa fa-whatsapp"></i> Mensaje de Whatsapp</a></li>
									<?php }?>
								    <li class="divider"></li>
								    <!-- <li><a href="#">Acción #4</a></li> -->
								  </ul>
								</div>
							</td>
						<?php }?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<!-- </div> -->
<div style="position:fixed;bottom:0;padding: 0 2%;background: #fff;color: #333;z-index: 10;width: 100%;box-shadow: 0px 0px 3px #999">
	<h2>TOTAL VENTAS: <?php echo $sumaTotalVentas ?></h2>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
 // Write on keyup event of keyword input element
 $(document).ready(function(){
	 $("#search").keyup(function(){
	 _this = this;
	 // Show only matching TR, hide rest of them
	 $.each($("#mytable tbody tr"), function() {
	 if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
	 $(this).hide();
	 else
	 $(this).show();
	 });
	 });
});
</script>