<?php if(count($dataPedido) > 0){ ?>
<form id="formPago" method="post" action="https://gateway.payulatam.com/ppp-web-gateway/">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>PRODUCTO</th>
                <th>PRESENTACIÓN</th>
                <th class="text-center">CANTIDAD</th>
                <th class="text-center">VALOR UNITARIO</th>
                <th class="text-center">VALOR TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php $totalPagar =0; foreach($dataPedido as $datos){ ?>
                <?php foreach($datos as $data){ 
                        $precioCantidad  = ($data['valorPresentacion'] * $data['cantidad']);
                        $totalPagar     += $precioCantidad;
                    ?>
                    <tr>
                        <td><?php echo $data['nombreProducto'] ?></td>
                        <td><?php echo $data['nombrePresentacion'] ?></td>
                        <td class="text-center"><?php echo $data['cantidad'] ?></td>
                        <td class="text-center">$<?php echo number_format($data['valorPresentacion'],0,',','.') ?></td>
                        <td class="text-center">$<?php echo number_format($precioCantidad,0,',','.') ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">
                    <h2>TOTAL A PAGAR</h2>
                </th>
                <th class="text-center">
                    <h2>$<?php echo number_format($totalPagar,0,',','.') ?></h2>
                </th>
            </tr>
            <?php 
            //“ApiKey~merchantId~referenceCode~amount~currency”.
                $signature = md5(_PAYU_API_KEY.'~'._PAYU_ID_MERCADO.'~'.$_SESSION['refPedido'].'~'.$totalPagar.'~COP');
             ?>
            <tr>
                <th colspan="2" class="text-left">
                    <a href="<?php echo base_url() ?>Pedidos/misPedidos/37" type="button" ng-click="" class="btn btn-danger btn-envia">CANCELAR PEDIDO</a>
                    <button type="button" ng-click="refrescaPedido()" class="btn btn-primary btn-envia">REFRESCAR PEDIDO</button>
                </th>
                <th class="text-right"></th>
                <th class="text-right" style="vertical-align: middle;">
                    <select name="formaPago" id=formaPago>
                        <option value="">Forma de pago</option>
                        <option value="1">Contra entrega</option>
                        <option value="2">Pago online</option>
                    </select>
                </th>
                <th  class="text-right">
                    <input name="merchantId" id="merchantId"    type="hidden"  value="<?php echo _PAYU_ID_MERCADO?>">
                    <input name="accountId"     type="hidden"  value="<?php echo _PAYU_ID_CUENTA ?>" >
                    <input name="description"   type="hidden"  value="Pedido de producto"  >
                    <input name="apKey" id="apKey"   type="hidden"  value="<?php echo _PAYU_API_KEY ?>"  >
                    <input name="referenceCode" id="referenceCode" type="hidden"  value="<?php echo $_SESSION['refPedido'] ?>" >
                    <input name="amount"  id="amount"       type="hidden"  value="<?php echo $totalPagar ?>"   >
                    <input name="tax"           type="hidden"  value="0"  >
                    <input name="taxReturnBase" type="hidden"  value="0" >
                    <input name="currency" id="currency"    type="hidden"  value="COP" >
                    <input name="signature"  id="signature"   type="hidden"  value="<?php echo $signature ?>"  >
                    <input name="test"          type="hidden"  value="<?php echo _PAYU_TEST ?>" >
                    <input name="buyerEmail"    type="hidden"  value="<?php echo $_SESSION['project']['info']['email'] ?>" >
                    <input name="payerFullName"    type="hidden"  value="<?php echo $_SESSION['project']['info']['nombre'] ?> <?php echo $_SESSION['project']['info']['apellido'] ?>" >
                    <input name="responseUrl"    type="hidden"  value="<?php echo _PAYU_LINK_RESP ?>" >
                    <input name="confirmationUrl"    type="hidden"  value="<?php echo _PAYU_LINK_CONFIRM ?>" ><!-- 
                    <center><div class="g-recaptcha" data-sitekey="6LfQ5WcUAAAAANYXMCxCBjE7q7PlnN5M220M2wtu"></div></center> -->
                    <button type="button" ng-click="enviarFormPago();" class="btn btn-success">REALIZAR PAGO</button>
                </th>
            </tr>
        </tfoot>
    </table> 
</form>
<?php }else{ ?>
    <div class="alert alert-info">
      <strong>Atención!</strong> Debe agregar productos al pedido
    </div>
<?php } ?>