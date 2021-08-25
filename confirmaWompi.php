<?php
session_start();
//require("application/config/constants.php");
//var_dump($_GET);die();
$urlService  = ($_GET['env'] == 'test')?"https://sandbox.wompi.co/v1/transactions/":"https://production.wompi.co/v1/transactions/";
$urlService .= $_GET['id'];
/*$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $urlService);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = json_decode(curl_exec($ch));*/


$res = file_get_contents($urlService);
$res = json_decode($res);

$dataPago['codigoPedido']       = $res->data->reference;
$dataPago['reference_pol']      = $res->data->id;
$dataPago['transaction_id']     = $res->data->id;
$dataPago['currency']           = $res->data->currency;
$dataPago['payment_method']     = $res->data->payment_method->type;//.' '.$res->data->payment_method->extra->name;
$dataPago['fechaPago']          = date("Y-m-d H:i:s",strtotime($res->data->extra->created_at));
$dataPago['value']              = substr($res->data->amount_in_cents,0,strlen($res->data->amount_in_cents)-2);
//valido el estado del pago
if($res->data->status == 'APPROVED')//transaccion aprobada
{
    $dataPago['state_pol']        = '998';
}
else if($res->data->status == 'DECLINED')//transaccion aprobada
{
    $dataPago['state_pol']        = '000';
} 
else
{
    $dataPago['state_pol']        = '000';
}  
curl_close($ch);
$_SESSION['confirmaWompi'] = $dataPago;
//die();
//print_r($_SESSION['confirmaWompi']);die();
echo "<script>document.location = '".$_SESSION['base_url']."Pedidos/confirmacionPagoWompi'</script>";
?>