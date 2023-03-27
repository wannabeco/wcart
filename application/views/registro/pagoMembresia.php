<?php
    $referencia   = $infpedido[0]['codigoPago'];

    if($proveedor == 'Appmes'){
        $precio = _PRECIO_PLAN_BASIC;
        $nombreTrans="Pago memebresia plan Sitio web 1 mes";
    }
    else if($proveedor == 'AppAno'){
        $precio =  _PRECIO_PLAN_BASIC * _MESES_DE_COBRO_ANO_PLAN_BASIC;
        $nombreTrans="Pago memebresia plan Sitio web 1 año";
    }
    else if($proveedor == 'WebMes'){
        $precio =  _PRECIO_PLAN_PRO;
        $nombreTrans="Pago memebresia plan pro 1 mes";
    }
    else if($proveedor == 'WebAno'){
        $precio =  _PRECIO_PLAN_PRO * _MESES_DE_COBRO_ANO_PLAN_PRO;
        $nombreTrans="Pago memebresia plan pro 1 año";
    }
    else if($proveedor == 'movilMes'){
        $precio =  _PRECIO_PLAN_APP;
        $nombreTrans="Pago memebresia plan App movil 1 mes";
    }
    else if($proveedor == 'movilAno'){
        $precio =  _PRECIO_PLAN_APP * _MESES_DE_COBRO_ANO_PLAN_APP;
        $nombreTrans="Pago memebresia plan App movil 1 año";
    }


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
                    <td><?php echo $nombreTrans; ?></td>
                    <td class="text-center"></td>
                    <td class="text-right"><?php echo "$".number_format($precio);?></td>
                </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan='3' style="padding-left: 30px;"><?php echo lang("text32")?></th>
                <th class="text-right"><?php echo "$".number_format($precio);?></th>
            </tr>
        </tfoot>
    </table>

    <div class="alert alert-primary text-center" role="alert">
    <?php echo lang("text31")?>
    </div>
    </div>
    <?php 
    //“ApiKey~merchantId~referenceCode~amount~currency”.
            $llave = md5(_PAYU_API_KEY."~"._PAYU_ID_MERCADO."~".$referencia."~".$precio."~COP");
        ?>
        <div class="container">
            <center>
                <form method="post" id="theForm" action="https://checkout.payulatam.com/ppp-web-gateway-payu/">
                <!--<form method="post" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/">-->
                    <input name="accountId"                         type="hidden"   value="<?php echo _PAYU_ID_CUENTA?>">
                    <!--<input name="accountId"                         type="hidden"   value="512321">-->
                    <input name="merchantId"    id="merchantId"     type="hidden"   value="<?php echo _PAYU_ID_MERCADO?>">
                    <!--<input name="merchantId"    id="merchantId"     type="hidden"   value="508029">-->
                    <input name="description"                       type="hidden"   value="<?php echo $nombreTrans; ?>">
                    <!--<input name="secret"                            type="hidden"   value="pRRXKOl8ikMmt9u">-->
                    <input name="referenceCode" id="referenceCode"  type="hidden"   value="<?php echo $referencia?>">
                    <input name="amount"                            type="hidden"   value="<?php echo sprintf('%.2f',$precio)?>">
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
</div>
<script>
    function cerarPop() {
        var cierre =1;
            window.close();
        return cierre;
    }
</script>