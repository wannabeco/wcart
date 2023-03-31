<h2>Recibo de pago</h2>
<p> Gracias por su compra!</p>
<p> A continuacion podra ver la información detallada de su compra. </p><br>

<table style="width: 600px;">
    <thead></thead>
    <tbody>
        <tr>
            <td>Código de pago:</td>
            <td style="margin-left: 50px;"><?php echo $codigo;?></td>
        </tr>
        <tr>
            <td>Valor membresia</td>
            <td style="margin-left: 50px;">$<?php echo $pago;?></td>
        </tr>
        <tr>
            <td>Iva</td>
            <td style="margin-left: 50px;"> $ 00.</td>
        </tr>
        <tr>
            <td>Otros</td>
            <td style="margin-left: 50px;"> $ 00.</td>
        </tr>
        <tr>
            <td><hr></td>
            <td><hr></td>
        </tr>
        <tr>
            <td><strong> Total</strong></td>
            <td style="margin-left: 50px;"><strong>$<?php echo $pago;?></strong></td>
        </tr>
        <tr>
            <td><hr></td>
            <td><hr></td>
        </tr>
        <tr>
            <td>Fecha Inicial</td>
            <td style="margin-left: 50px;"><?php echo $fechaInicio?></td>
        </tr>
        <tr>
            <td>Fecha Finaliza</td>
            <td style="margin-left: 50px;"><?php echo $fecaCaducidad?></td>
        </tr>
        <?php if($appMovil = "0"){?>
        <tr>
            <td>Pagina Web</td>
            <td style="margin-left: 50px;">ya disponible</td>
        </tr>
        <?php } if($appMovil = "1"){ ?>
        <tr>
            <td>Aplicacion en App store</td>
            <td style="margin-left: 50px;">7 dias</td>
        </tr>
        <tr>
            <td>Aplicacion en Play store</td>
            <td style="margin-left: 50px;">7 dias</td>
        </tr>
        <tr>
            <td>Pagina Web</td>
            <td style="margin-left: 50px;">ya disponible</td>
        </tr>
        <?php } ?>
        <tr>
            <td>
                Recuerda, para administrar tu tienda <a href="http://www.wabeshop.com/admin" target="_blank" class="position">Aquí</a>.    
            </td>
        </tr>
        
    </tbody>
</table><br><br>

