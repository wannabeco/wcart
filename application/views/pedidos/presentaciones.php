<table class="table">
	<thead>
		<tr>
			<th>PRESENTACIÓN</th>
			<th class="text-center">VALOR UNIDAD</th>
			<th class="text-center">CANTIDAD</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($presentaciones['datos'] as $pres){ ?>
			<tr class="filasProducto" data-idpres="<?php echo $pres['idPresentacion']?>">
				<td><?php echo $pres['nombrePresentacion']?></td>
				<td class="text-center">$<?php echo number_format($pres['valorPresentacion'],0,',','.')?></td>
				<td class="text-center">
					<input type="text" class="cajaInt" name="caja<?php echo $pres['idPresentacion']?>" id="caja<?php echo $pres['idPresentacion']?>" >
				</td>
			</tr>
		<?php }?>
	</tbody>
</table>