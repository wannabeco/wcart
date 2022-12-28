<?php
    $referencia   = $infpedido[0]['codigoPago'];
    $presioAppAno = _PRECIO_PLAN_BASIC * _MESES_DE_COBRO_ANO_PLAN_BASIC;
    $presioWebAno = _PRECIO_PLAN_PRO * _MESES_DE_COBRO_ANO_PLAN_PRO;
    //$Email = json_encode($usuario[0]['email']);
    //echo $Email."<br>";
?>
<div class="container-fluid" ng-controller="membresia"  ng-init="initCaduca()">
    <div class="container"><br>
    <center><img src="<?php echo base_url()?>assets/uploads/files/logoApp.png" width="50%"></center><br>
    <h3 class="text-center"><strong>Pago de Membresia wannabe</strong></h3><br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="background:#000;color:#fff"></th>
                <th style="background:#000;color:#fff">plan</th>
                <th style="background:#000;color:#fff" class="text-center"></th>
                <th style="background:#000;color:#fff" class="text-right"><?php echo lang("text34")?></th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td></td>
                    <?php if($proveedor == 'Appmes'){?>
                        <td>Membresia mes de App Movil</td>
                        <td class="text-center"></td>
                        <td class="text-right"><?php echo "$".number_format(_PRECIO_PLAN_BASIC);?></td>
                    <?php }else if($proveedor == 'AppAno'){?>
                        <td>Membresia año de App Movil</td>
                        <td class="text-center"></td>
                        <td class="text-right"><?php echo "$".number_format($presioAppAno);?></td>
                    <?php }else if($proveedor == 'WebMes'){?>
                        <td>Membresia mes de App Movil y pagina web</td>
                        <td class="text-center"></td>
                        <td class="text-right"><?php echo "$".number_format(_PRECIO_PLAN_PRO);?></td>
                    <?php }else if($proveedor == 'WebAno'){?>
                        <td>Membresia maño de App Movil y pagina web</td>
                        <td class="text-center"></td>
                        <td class="text-right"><?php echo "$".number_format($presioWebAno);?></td>
                    <?php } ?>
                </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan='3' style="padding-left: 30px;"><?php echo lang("text32")?></th>
                <?php if($proveedor == 'Appmes'){?>
                        <th class="text-right"><?php echo "$".number_format(_PRECIO_PLAN_BASIC);?></th>
                    <?php }else if($proveedor == 'AppAno'){?>
                        <th class="text-right"><?php echo "$".number_format($presioAppAno);?></th>
                    <?php }else if($proveedor == 'WebMes'){?>
                        <th class="text-right"><?php echo "$".number_format(_PRECIO_PLAN_PRO);?></th>
                    <?php }else if($proveedor == 'WebAno'){?>
                        <th class="text-right"><?php echo "$".number_format($presioWebAno);?></th>
                    <?php } ?>
            </tr>
        </tfoot>
    </table>

    <div class="alert alert-primary text-center" role="alert">
    <?php echo lang("text31")?>
    </div>
    </div>
    <?php if($proveedor == 'Appmes'){
        //“ApiKey~merchantId~referenceCode~amount~currency”.
        $llave = md5(_PAYU_API_KEY."~"._PAYU_ID_MERCADO."~".$referencia."~"._PRECIO_PLAN_BASIC."~COP");
    ?>
        <div class="container">
            <?php //var_dump($infoPedido);?>
                <center>
                <form method="post" id="theForm" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/">
                    <input name="merchantId"    id="merchantId"     type="hidden"   value="<?php echo _PAYU_ID_MERCADO?>">
                    <input name="accountId"                         type="hidden"   value="<?php echo _PAYU_ID_CUENTA?>">
                    <input name="description"                       type="hidden"   value="<?php echo _NOMBRE_TRANSACCION?>">
                    <input name="apiKey"         id="apKey"          type="hidden"   value="<?php echo _PAYU_API_KEY?>">
                    <input name="secret"                            type="hidden"   value="pRRXKOl8ikMmt9u">
                    <input name="referenceCode" id="referenceCode"  type="hidden"   value="<?php echo $referencia?>">
                    <input name="amount"                            type="hidden"   value="<?php echo sprintf('%.2f',_PRECIO_PLAN_BASIC)?>">
                    <input name="tax"                               type="hidden"   value="0">
                    <input name="taxReturnBase"                     type="hidden"   value="0">
                    <input name="currency"      id="currency"       type="hidden"   value="COP">
                    <input name="signature"     id="signature"      type="hidden"   value="<?php echo $llave?>">
                    <input name="test"                              type="hidden"   value="false" >
                    <input name="buyerEmail"                        type="hidden"   value="<?php echo $usuario[0]['email']; ?>" >
                    <input name="responseUrl"                       type="hidden"   value="<?php echo base_url()._PAYU_LINK_RESP_MEMBRESIA?>" >
                    <input name="confirmationUrl"                   type="hidden"   value="<?php echo base_url()._PAYU_LINK_CONFIRMACION_PAGO?>" > 
                    <button type="submit" class="btn btn-primary" style="background:#000;color:#fff"><?php echo lang("text30")?></button>               
                </form><br><br>
                <img src="<?php echo base_url()?>/res/img/payuPagos.jpg" width="100%" alt="">
                <a onclick="cerarPop()" class="btn btn-primary">CERRAR VENTANA</a>
                </center>
        </div>
        <?php }else if($proveedor == 'AppAno'){
            $llave = md5(_PAYU_API_KEY."~"._PAYU_ID_MERCADO."~".$referencia."~".$presioAppAno."~COP");
        ?>  
            <div class="container">
            <?php //var_dump($infoPedido);?>
                <!--<center>
                <form method="post" id="theForm" action="https://gateway.payulatam.com/ppp-web-gateway/">
                    <input name="merchantId" id="merchantId"    type="hidden"  value="<?php echo _PAYU_ID_MERCADO?>">
                    <input name="accountId"     type="hidden"  value="<?php echo _PAYU_ID_CUENTA?>">
                    <input name="description"   type="hidden"  value="<?php echo _NOMBRE_TRANSACCION?>">
                    <input name="apKey" id="apKey"   type="hidden"  value="<?php echo _PAYU_API_KEY?>">
                    <input name="referenceCode" id="referenceCode" type="hidden"  value="<?php echo $referencia?>">
                    <input name="amount"        type="hidden"  value="<?php echo sprintf('%.2f',$presioAppAno)?>">
                    <input name="tax"           type="hidden"  value="0">
                    <input name="taxReturnBase" type="hidden"  value="0">
                    <input name="currency" id="currency"    type="hidden"  value="COP">
                    <input name="signature"  id="signature"   type="hidden"  value="<?php echo $llave?>">
                    <input name="test"          type="hidden"  value="1" >
                    <input name="buyerEmail"    type="hidden"  value="<?php echo $usuario[0]['email']; ?>" >
                    <input name="responseUrl"    type="hidden"  value="<?php echo base_url()._PAYU_LINK_RESP_MEMBRESIA?>" >
                    <input name="confirmationUrl"    type="hidden"  value="<?php echo base_url()._PAYU_LINK_CONFIRMACION_PAGO?>" > 
                    <button type="submit" class="btn btn-primary" style="background:#000;color:#fff"><?php echo lang("text30")?></button>               
                </form><br><br>
                <img src="<?php echo base_url()?>/res/img/payuPagos.jpg" width="100%" alt="">
                <a onclick="cerarPop()" class="btn btn-primary">CERRAR VENTANA</a>
                </center>-->
                <center>
                <form method="post" id="theForm" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/">
                    <input name="merchantId"    id="merchantId"     type="hidden"   value="<?php echo _PAYU_ID_MERCADO?>">
                    <input name="accountId"                         type="hidden"   value="<?php echo _PAYU_ID_CUENTA?>">
                    <input name="description"                       type="hidden"   value="<?php echo _NOMBRE_TRANSACCION?>">
                    <input name="apiKey"         id="apKey"          type="hidden"   value="<?php echo _PAYU_API_KEY?>">
                    <input name="secret"                            type="hidden"   value="pRRXKOl8ikMmt9u">
                    <input name="referenceCode" id="referenceCode"  type="hidden"   value="<?php echo $referencia?>">
                    <input name="amount"                            type="hidden"   value="<?php echo sprintf('%.2f',$presioAppAno)?>">
                    <input name="tax"                               type="hidden"   value="0">
                    <input name="taxReturnBase"                     type="hidden"   value="0">
                    <input name="currency"      id="currency"       type="hidden"   value="COP">
                    <input name="signature"     id="signature"      type="hidden"   value="<?php echo $llave?>">
                    <input name="test"                              type="hidden"   value="false" >
                    <input name="buyerEmail"                        type="hidden"   value="<?php echo $usuario[0]['email']; ?>" >
                    <input name="responseUrl"                       type="hidden"   value="<?php echo base_url()._PAYU_LINK_RESP_MEMBRESIA?>" >
                    <input name="confirmationUrl"                   type="hidden"   value="<?php echo base_url()._PAYU_LINK_CONFIRMACION_PAGO?>" > 
                    <button type="submit" class="btn btn-primary" style="background:#000;color:#fff"><?php echo lang("text30")?></button>               
                </form><br><br>
                <img src="<?php echo base_url()?>/res/img/payuPagos.jpg" width="100%" alt="">
                <a onclick="cerarPop()" class="btn btn-primary">CERRAR VENTANA</a>
                </center>
        </div>
        <?php }else if($proveedor == 'WebMes'){
            $llave = md5(_PAYU_API_KEY."~"._PAYU_ID_MERCADO."~".$referencia."~"._PRECIO_PLAN_PRO."~COP");    
        ?>
            <div class="container">
            <?php //var_dump($infoPedido);?>
                <!--<center>
                <form method="post" id="theForm" action="https://gateway.payulatam.com/ppp-web-gateway/">
                    <input name="merchantId" id="merchantId"    type="hidden"  value="<?php echo _PAYU_ID_MERCADO?>">
                    <input name="accountId"     type="hidden"  value="<?php echo _PAYU_ID_CUENTA?>">
                    <input name="description"   type="hidden"  value="<?php echo _NOMBRE_TRANSACCION?>">
                    <input name="apKey" id="apKey"   type="hidden"  value="<?php echo _PAYU_API_KEY?>">
                    <input name="referenceCode" id="referenceCode" type="hidden"  value="<?php echo $referencia?>">
                    <input name="amount"        type="hidden"  value="<?php echo sprintf('%.2f',_PRECIO_PLAN_PRO)?>">
                    <input name="tax"           type="hidden"  value="0">
                    <input name="taxReturnBase" type="hidden"  value="0">
                    <input name="currency" id="currency"    type="hidden"  value="COP">
                    <input name="signature"  id="signature"   type="hidden"  value="<?php echo $llave?>">
                    <input name="test"          type="hidden"  value="1" >
                    <input name="buyerEmail"    type="hidden"  value="<?php echo $usuario[0]['email']; ?>" >
                    <input name="responseUrl"    type="hidden"  value="<?php echo base_url()._PAYU_LINK_RESP_MEMBRESIA?>" >
                    <input name="confirmationUrl"    type="hidden"  value="<?php echo base_url()._PAYU_LINK_CONFIRMACION_PAGO?>" > 
                    <button type="submit" class="btn btn-primary" style="background:#000;color:#fff"><?php echo lang("text30")?></button>               
                </form><br><br>
                <img src="<?php echo base_url()?>/res/img/payuPagos.jpg" width="100%" alt="">
                <a onclick="cerarPop()" class="btn btn-primary">CERRAR VENTANA</a>
                </center>-->
                <center>
                <form method="post" id="theForm" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/">
                    <input name="merchantId"    id="merchantId"     type="hidden"   value="<?php echo _PAYU_ID_MERCADO?>">
                    <input name="accountId"                         type="hidden"   value="<?php echo _PAYU_ID_CUENTA?>">
                    <input name="description"                       type="hidden"   value="<?php echo _NOMBRE_TRANSACCION?>">
                    <input name="apiKey"         id="apKey"          type="hidden"   value="<?php echo _PAYU_API_KEY?>">
                    <input name="secret"                            type="hidden"   value="pRRXKOl8ikMmt9u">
                    <input name="referenceCode" id="referenceCode"  type="hidden"   value="<?php echo $referencia?>">
                    <input name="amount"                            type="hidden"   value="<?php echo sprintf('%.2f',_PRECIO_PLAN_PRO)?>">
                    <input name="tax"                               type="hidden"   value="0">
                    <input name="taxReturnBase"                     type="hidden"   value="0">
                    <input name="currency"      id="currency"       type="hidden"   value="COP">
                    <input name="signature"     id="signature"      type="hidden"   value="<?php echo $llave?>">
                    <input name="test"                              type="hidden"   value="false" >
                    <input name="buyerEmail"                        type="hidden"   value="<?php echo $usuario[0]['email']; ?>" >
                    <input name="responseUrl"                       type="hidden"   value="<?php echo base_url()._PAYU_LINK_RESP_MEMBRESIA?>" >
                    <input name="confirmationUrl"                   type="hidden"   value="<?php echo base_url()._PAYU_LINK_CONFIRMACION_PAGO?>" > 
                    <button type="submit" class="btn btn-primary" style="background:#000;color:#fff"><?php echo lang("text30")?></button>               
                </form><br><br>
                <img src="<?php echo base_url()?>/res/img/payuPagos.jpg" width="100%" alt="">
                <a onclick="cerarPop()" class="btn btn-primary">CERRAR VENTANA</a>
                </center>
        </div>
        <?php }else if($proveedor == 'WebAno'){
            $llave = md5(_PAYU_API_KEY."~"._PAYU_ID_MERCADO."~".$referencia."~".$presioWebAno."~COP");    
        ?>
            <div class="container">
            <?php //var_dump($infoPedido);?>
                <!--<center>
                <form method="post" id="theForm" action="https://gateway.payulatam.com/ppp-web-gateway/">
                    <input name="merchantId" id="merchantId"    type="hidden"  value="<?php echo _PAYU_ID_MERCADO?>">
                    <input name="accountId"     type="hidden"  value="<?php echo _PAYU_ID_CUENTA?>">
                    <input name="description"   type="hidden"  value="<?php echo _NOMBRE_TRANSACCION?>">
                    <input name="apKey" id="apKey"   type="hidden"  value="<?php echo _PAYU_API_KEY?>">
                    <input name="referenceCode" id="referenceCode" type="hidden"  value="<?php echo $referencia?>">
                    <input name="amount"        type="hidden"  value="<?php echo sprintf('%.2f',$presioWebAno)?>">
                    <input name="tax"           type="hidden"  value="0">
                    <input name="taxReturnBase" type="hidden"  value="0">
                    <input name="currency" id="currency"    type="hidden"  value="COP">
                    <input name="signature"  id="signature"   type="hidden"  value="<?php echo $llave?>">
                    <input name="test"          type="hidden"  value="1" >
                    <input name="buyerEmail"    type="hidden"  value="<?php echo $usuario[0]['email']; ?>" >
                    <input name="responseUrl"    type="hidden"  value="<?php echo base_url()._PAYU_LINK_RESP_MEMBRESIA?>" >
                    <input name="confirmationUrl"    type="hidden"  value="<?php echo base_url()._PAYU_LINK_CONFIRMACION_PAGO?>" > 
                    <button type="submit" class="btn btn-primary" style="background:#000;color:#fff"><?php echo lang("text30")?></button>               
                </form><br><br>
                <img src="<?php echo base_url()?>/res/img/payuPagos.jpg" width="100%" alt="">
                <a onclick="cerarPop()" class="btn btn-primary">CERRAR VENTANA</a>
                </center>-->
                <center>
                <form method="post" id="theForm" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/">
                    <input name="merchantId"    id="merchantId"     type="hidden"   value="<?php echo _PAYU_ID_MERCADO?>">
                    <input name="accountId"                         type="hidden"   value="<?php echo _PAYU_ID_CUENTA?>">
                    <input name="description"                       type="hidden"   value="<?php echo _NOMBRE_TRANSACCION?>">
                    <input name="apiKey"         id="apKey"          type="hidden"   value="<?php echo _PAYU_API_KEY?>">
                    <input name="secret"                            type="hidden"   value="pRRXKOl8ikMmt9u">
                    <input name="referenceCode" id="referenceCode"  type="hidden"   value="<?php echo $referencia?>">
                    <input name="amount"                            type="hidden"   value="<?php echo sprintf('%.2f',$presioWebAno)?>">
                    <input name="tax"                               type="hidden"   value="0">
                    <input name="taxReturnBase"                     type="hidden"   value="0">
                    <input name="currency"      id="currency"       type="hidden"   value="COP">
                    <input name="signature"     id="signature"      type="hidden"   value="<?php echo $llave?>">
                    <input name="test"                              type="hidden"   value="false" >
                    <input name="buyerEmail"                        type="hidden"   value="<?php echo $usuario[0]['email']; ?>" >
                    <input name="responseUrl"                       type="hidden"   value="<?php echo base_url()._PAYU_LINK_RESP_MEMBRESIA?>" >
                    <input name="confirmationUrl"                   type="hidden"   value="<?php echo base_url()._PAYU_LINK_CONFIRMACION_PAGO?>" > 
                    <button type="submit" class="btn btn-primary" style="background:#000;color:#fff"><?php echo lang("text30")?></button>               
                </form><br><br>
                <img src="<?php echo base_url()?>/res/img/payuPagos.jpg" width="100%" alt="">
                <a onclick="cerarPop()" class="btn btn-primary">CERRAR VENTANA</a>
                </center>
        </div>
        <?php } ?>
</div>
<script>
    function cerarPop() {
        var cierre =1;
            window.close();
        return cierre;
    }
</script>