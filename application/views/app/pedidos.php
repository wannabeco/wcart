<?php foreach($pedidos as $pedHome){ ?>
    <tr>
        <td><?php echo $pedHome['idPedido'] ?></td>
        <td><?php echo $pedHome['fechaPedido'] ?></td>
        <td><?php echo $pedHome['nombre'] ?> <?php echo $pedHome['apellido'] ?></td>
        <!--  <td></td>
        <td></td>
        <td></td> -->
        <td><span class="label <?php echo $pedHome['label'] ?>"><?php echo $pedHome['nombreEstadoPedido'] ?></span></td>
        <td>
            <?php if($pedHome['formaPago'] == 1){?>
                <span class="label label-primary">Pago con efectivo</span>
            <?php }elseif($pedHome['formaPago'] == 3){?>
                <span class="label label-primary">Pago con datafono</span>
            <?php }elseif($pedHome['formaPago'] == 2){?>
                <span class="label label-info">PAYU Latam)</span>
            <?php }elseif($pedHome['formaPago'] == 4){?>
                <span class="label label-danger">Wompi</span>
            <?php }elseif($pedHome['formaPago'] == 5){?>
                <span class="label label-default">Stripe</span>
            <?php }else{?>
                <span class="label label-info">Otro</span>
            <?php }?>
        </td>
        <td><span class="label <?php echo estadoPago($pedHome['estadoPago'])['label'] ?>"><?php echo estadoPago($pedHome['estadoPago'])['texto'] ?></span></td>
        <td>$<?php echo number_format($pedHome['valor'],0,',','.') ?></td>
        <td>
            <a href="<?php echo base_url() ?>Pedidos/detalleMiPedido/40/<?php echo $pedHome['idPedido'] ?>">Ver Pedido <i class="fa fa-arrow-circle-right"></i></a>
        </td>
</tr>
<?php } ?>