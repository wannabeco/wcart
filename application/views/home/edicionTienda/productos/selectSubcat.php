<label class="control-label" for="idSubcategoria">Subcategory *</label>
<select tabindex="2" autocomplete="off" id="idSubcategoria" name="idSubcategoria" class="form-control">
	<option value=""></option>
	<?php foreach($data as $catList){?>
	  <option <?php if(isset($catList['idSubcategoria']) && $catList['idSubcategoria'] == $persistencia){ ?>selected<?php } ?> value="<?php echo $catList['idSubcategoria']?>">
	  	<?php echo $catList['nombreSubcategoria']?>
	  </option>
	<?php }?>
</select>
<!-- <p class="help-block">Seleccione la subcategoría a la que pertenecera</p> -->