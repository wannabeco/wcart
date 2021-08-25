<?php
//Verificamos la operacion o estado de Grocery crud

if(isset($estado) && ($estado == 'add' || $estado == 'edit')) {

//Generamos el script Jquery que controlara los combos dinamicamente
echo '<script type="text/javascript">';

echo '$(document).ready(function() {';
for($i = 0; $i <= sizeof($combos)-1; $i++)
{
    //tomamos las variavles que asignamos en $datos del controlador
    $phpVarSel = sprintf(' $(\'select[name="%s"]\');',$combos[$i]);
    //echo 'var '.$combos[$i].' = $('select[name="'.$combos[$i].'"]');';
    echo 'var '.$combos[$i].' = '.$phpVarSel;

    //asignamos el icono
    if($i != sizeof($combos)-1) {
        echo '$(\'#'.$combos[$i].'_input_box').append('<img src="'.$icon_ajax.'" border="0" id="'.$combos[$i].'_ajax_loader" class="dd_ajax_loader" style="display: none;">\');';
    }


    if($i > 0 && $estado == 'add') {

    //Si estamos añadiendo un nuevo registro
            //Ocultamos los combos de jerarquía inferior

    echo '$(\'#'.$combos[$i].'_input_box\').hide()';
    echo $combos[$i].'.children().remove().end();';

    }
}


for($i = 1; $i <= sizeof($combos)-1; $i++):

/Añadimos los datos a los combos de jerarquia inferior
echo $combos[$i-1].'.change(function() {';

echo 'var select_value = this.value;';
echo '$(\'#'.$combos[$i-1].'_ajax_loader\').show();';

//Borramos todos los datos anteriores
echo $combos[$i].'.find('option').remove();';

echo 'var myOptions = "";';
//Asignamos el nuevo llistado que traemos de buscarlocalidades()

echo '$.getJSON(''.$url[$i].''+select_value, function(data) {';
//listamos los datos

echo $combos[$i].'.append('<option value=""></option>');';
echo '$.each(data, function(key, val) {';

echo $combos[$i].'.append(';
echo '$('<option></option>').val(val.value).html(val.property)';

echo ');';
echo '});';

echo '$('#'.$combos[$i].'_input_box').show();';

for($x = $i+1; $x <= sizeof($combos)-1; $x++):
  echo '$('#'.$combos[$x].'_input_box').hide();';

endfor;

  echo $combos[$i-1].'.each(function(){';
echo '$(this).trigger("liszt:updated");';

echo '});';
echo $combos[$i].'.each(function(){';

echo '$(this).trigger("liszt:updated");';
echo '});';

echo '$('#'.$combos[$i-1].'_ajax_loader').hide();';
echo '});';

echo '});';
endfor;

echo '});';
echo '</script>';

}
?>