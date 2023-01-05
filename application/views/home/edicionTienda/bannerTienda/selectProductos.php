<label class="control-label" for="idPresentacion">Productos *</label>
<select tabindex="2" autocomplete="off" id="idPresentacion" name="idPresentacion" class="form-control">
	<option value=""></option>
	<?php foreach($productos as $catList){?>
	  <option <?php if(isset($catList['idPresentacion']) && $catList['idPresentacion'] == $persistencia){ ?>selected<?php } ?> value="<?php echo $catList['idPresentacion']?>">
	  	<?php echo $catList['nombrePresentacion']?>
	  </option>
	<?php }?>
</select>
<!-- <p class="help-block">Seleccione la subcategoría a la que pertenecera</p> -->