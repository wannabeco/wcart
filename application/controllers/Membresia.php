<?php
/*

	("`-''-/").___....''"`-._
      `6_ 6  )   `-.  (     ).`-.__.`) 
      (_Y_.)'  ._   )  `._ `. ``-..-'
    _..`..'_..-_/  /..'_.' ,'
   (il),-''  (li),'  ((!.-'

   Desarrollado por @orugal
   https://github.com/orugal

   Este archivo es el controlador que realizara al cuál se harán los llamados desde las url en la página o en los procesos AJAX que se utilicen.
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Membresia extends CI_Controller 
{
	function __construct() 
    {
        parent::__construct();
        $this->load->model("general/LogicaGeneral", "logica");//la idea es que este archivo siempre esté ya que aquí se consultan cosas que son muy globales.
        $this->load->model("pedidos/LogicaPedidos", "logicaPedidos");
        //$this->load->model("admin/LogicaEnBlanco", "logicaUsuarios");//aquí se debe llamar la lógica correspondiente al módulo que se esté haciendo.
       	$this->load->helper('language');//mantener siempre.
    	$this->lang->load('spanish');//mantener siempre.
    }
    /*
    * Funcion inicial del módulo de creación de usuarios
    * @author Farez Prieto
    * @date 17 de Noviembre de 2016
    * @param $idModulo Este parámetro siempre lo enviará el menú y siempre se deberá recibir en la función del módulo principal, no olvidar esto.
    * Esta función permite inicializar este módulo, dentro de ella siempre se debe declarar la variable de session $_SESSION['moduloVisitado'] con el $idModulo Pasado por parámetro
    * y a continuación siempre se debe llamar la función del helper llamada getPrivilegios, la función está en el archivo helpers/funciones_helper.php
    * Tenga en cuenta que cada llamado ajax que haga a una plantilla gráfica que incluya botones de ver,editar, crear, borrar debe siempre llamar la función getPrivilegios.
    */

    //pop para pago payu
    public function procesoPagoOnline($idPedido,$proveedor,$pedido)
    {   
        $infpedido ="";
        $usuario         = $this->logica->getInfoUsuario($_SESSION['project']['info']['idPersona']);
        $infpedido = $this->logica->getInfopedido($pedido);
        //consulto la info de la tienda
		$salida['titulo']       = "Pasarela de pago";
		$salida['centro']       = "registro/pagoMembresia";
		$salida['usuario']      = $usuario;
		//$salida['infoTienda']  = $infoTienda['datos'][0];
		$salida['pedido']       = $pedido;
		$salida['infpedido']    = $infpedido;
		$salida['proveedor']    = $proveedor;
		$this->load->view("registro/indexPago",$salida);
    }
    //confirmacion de pago
	public function confirmacionPago()
    {
        extract($_POST);
        //debo actualizar la informacon del pedido con lo que me retorno payu
        $dataInserta['estadoPago']      = $state_pol;
        $dataInserta['transactionid']   = $transaction_id;
        $dataInserta['reference_pol']   = $reference_pol;
        $dataInserta['valor']           = $value;
        $dataInserta['moneda']          = $currency;
        $dataInserta['entidad']         = $payment_method;
        $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
        $dataInserta['ip']              = getIP();
        $condicion['codigoPedido']      = $reference_sale;
        $updatePedido                   = $this->logica->actualizaDatos($dataInserta,$condicion);
        //envia el mensaje al administrador de la tienda diciendo que el pedido llego
        $mensajeMail  = "Confirmación de pago del pedido <strong>".$reference_sale."</strong><br><br>";
        sendMail(_ADMIN_PEDIDOS,"Estado de pago del pedido ".$reference_sale,$mensajeMail);
    }
    
    //respuesta de pago
    public function respuestaPago()
    {   
        extract($_GET);
        //var_dump($_GET);die();
        $idTienda = $_SESSION['project']['info']['idTienda'];
        $infoTienda     = $this->logica->getInfoTiendaNew($idTienda);
        $mes = $infoTienda['datos'][0]['mesGratis'];
        $fechaCaducidad = $infoTienda['datos'][0]['fechaCaducidad'];
        $fehcaActual = date('Y,m,d,H:i:s');
        $idTransaccion = $_GET['referenceCode'];
        
        $ApiKey             = $infoTienda['datos'][0]['payu_apikey'];

        $merchant_id        = $_GET['merchantId'];
        $referenceCode      = $_GET['referenceCode'];
        $TX_VALUE           = $_GET['TX_VALUE'];
        $New_value          = number_format($TX_VALUE, 1, '.', '');
        $currency           = $_GET['currency'];
        $transactionState   = $_GET['transactionState'];
        $firma_cadena       = "$ApiKey~$merchant_id~$referenceCode~$TX_VALUE~$currency";
        $firmacreada        = md5($firma_cadena);
        //echo $firmacreada;
        $firma              = $_GET['signature'];
        $reference_pol      = $_GET['reference_pol'];
        $cus                = $_GET['cus'];
        $extra1             = $_GET['description'];//confirmar con farez
        $pseBank            = $_GET['pseBank'];
        $lapPaymentMethod   = $_GET['lapPaymentMethod'];
        $transactionId      = $_GET['transactionId'];

        

        if ($_GET['transactionState'] == 4 ) {
            
            $estadoTx = lang("trans_aprobada");
            $claseLabel = "label-default";
            
            if($fechaCaducidad < $fehcaActual){
                if($_GET['TX_VALUE'] == _PRECIO_PLAN_BASIC){
                    //insertar en la tabla
                    $estadoTx = lang("trans_aprobada");
                    $claseLabel = "label-success";

                    $where['codigoPago']            = $idTransaccion;
                    $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                    $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                    $dataInserta['estadoPago']      = $transactionState;
                    $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                    $dataInserta['transactionid']   = $transactionId;
                    $dataInserta['reference_pol']   = $reference_pol;
                    $dataInserta['valor']           = $TX_VALUE;
                    $dataInserta['moneda']          = $currency;
                    $dataInserta['entidad']         = $lapPaymentMethod;
                    $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                    $dataInserta['codigopago']      = $referenceCode;
                    //$dataInserta['Plan']            = "movil";
                    $dataInserta['ip']              = getIP();
                    $dataInserta['plan']            = "app1";
                    $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
                    $idTienda                       = $_SESSION['project']['info']['idTienda'];
                    $codigo                         = $idTransaccion;
                    $updateTienda = $this->logica->updatemes($idTienda,$codigo);

                } else if($_GET['TX_VALUE']== (_PRECIO_PLAN_BASIC * _MESES_DE_COBRO_ANO_PLAN_BASIC)){
                    //insertar en la tabla
                    $estadoTx = lang("trans_aprobada");
                    $claseLabel = "label-success";
                    $where['codigoPago']            = $idTransaccion;
                    $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                    $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                    $dataInserta['estadoPago']      = $transactionState;
                    $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                    $dataInserta['transactionid']   = $transactionId;
                    $dataInserta['reference_pol']   = $reference_pol;
                    $dataInserta['valor']           = $TX_VALUE;
                    $dataInserta['moneda']          = $currency;
                    $dataInserta['entidad']         = $lapPaymentMethod;
                    $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                    $dataInserta['codigopago']      = $referenceCode;
                    //$dataInserta['Plan']            = "movil";
                    $dataInserta['ip']              = getIP();
                    $dataInserta['plan']            = "app2";
                    $idTienda = $_SESSION['project']['info']['idTienda'];
                    $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
                    $codigo                         = $idTransaccion;
                    $updateTienda = $this->logica->updatePagoAnoApp($idTienda, $codigo );
                }
                else if($_GET['TX_VALUE']== _PRECIO_PLAN_PRO){
                    //insertar en la tabla
                    $estadoTx = lang("trans_aprobada");
                    $claseLabel = "label-success";
                    $where['codigoPago']                           = $idTransaccion;
                    $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                    $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                    $dataInserta['estadoPago']      = $transactionState;
                    $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                    $dataInserta['transactionid']   = $transactionId;
                    $dataInserta['reference_pol']   = $reference_pol;
                    $dataInserta['valor']           = $TX_VALUE;
                    $dataInserta['moneda']          = $currency;
                    $dataInserta['entidad']         = $lapPaymentMethod;
                    $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                    $dataInserta['codigopago']      = $referenceCode;
                    //$dataInserta['Plan']            = "movil y web";
                    $dataInserta['ip']              = getIP();
                    $dataInserta['plan']            = "web1";
                    $idTienda = $_SESSION['project']['info']['idTienda'];
                    $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
                    $codigo                         = $idTransaccion;
                    $updateTienda = $this->logica->updatePagoMesPro($idTienda,$codigo);
                }
                else if($_GET['TX_VALUE'] == (_PRECIO_PLAN_PRO * _MESES_DE_COBRO_ANO_PLAN_PRO)){
                    //insertar en la tabla
                    $estadoTx = lang("trans_aprobada");
                    $claseLabel = "label-success";
                    $where['codigoPago']                           = $idTransaccion;
                    $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                    $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                    $dataInserta['estadoPago']      = $transactionState;
                    $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                    $dataInserta['transactionid']   = $transactionId;
                    $dataInserta['reference_pol']   = $reference_pol;
                    $dataInserta['valor']           = $TX_VALUE;
                    $dataInserta['moneda']          = $currency;
                    $dataInserta['entidad']         = $lapPaymentMethod;
                    $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                    $dataInserta['codigopago']      = $referenceCode;
                    //$dataInserta['Plan']            = "movil y web";
                    $dataInserta['ip']              = getIP();
                    $dataInserta['plan']            = "web2";
                    $idTienda = $_SESSION['project']['info']['idTienda'];
                    $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
                    $codigo                         = $idTransaccion;
                    $updateTienda = $this->logica->updatePagoAnoPro($idTienda,$codigo);
                }
            }
            else if($fechaCaducidad > $fehcaActual){
                if($mes == 0){
                    if($_GET['TX_VALUE'] == _PRECIO_PLAN_BASIC){
                        //insertar en la tabla
                        $estadoTx = lang("trans_aprobada");
                        $claseLabel = "label-success";
                        $where['codigoPago']                           = $idTransaccion;
                        $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                        $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                        $dataInserta['estadoPago']      = $transactionState;
                        $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                        $dataInserta['transactionid']   = $transactionId;
                        $dataInserta['reference_pol']   = $reference_pol;
                        $dataInserta['valor']           = $TX_VALUE;
                        $dataInserta['moneda']          = $currency;
                        $dataInserta['entidad']         = $lapPaymentMethod;
                        $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                        $dataInserta['codigopago']      = $referenceCode;
                        //$dataInserta['Plan']            = "movil";
                        $dataInserta['ip']              = getIP();
                        $dataInserta['plan']            = "app1";
                        $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
                        $codigo                         = $idTransaccion;
                        $updateTienda = $this->logica->updatePagoApp($idTienda,$codigo);
    
                    }else if($_GET['TX_VALUE']== (_PRECIO_PLAN_BASIC * _MESES_DE_COBRO_ANO_PLAN_BASIC)){
                        //insertar en la tabla
                        $estadoTx = lang("trans_aprobada");
                        $claseLabel = "label-success";
                        $where['codigoPago']                           = $idTransaccion;
                        $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                        $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                        $dataInserta['estadoPago']      = $transactionState;
                        $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                        $dataInserta['transactionid']   = $transactionId;
                        $dataInserta['reference_pol']   = $reference_pol;
                        $dataInserta['valor']           = $TX_VALUE;
                        $dataInserta['moneda']          = $currency;
                        $dataInserta['entidad']         = $lapPaymentMethod;
                        $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                        $dataInserta['codigopago']      = $referenceCode;
                        //$dataInserta['Plan']            = "movil";
                        $dataInserta['ip']              = getIP();
                        $dataInserta['plan']            = "app2";
                        $idTienda = $_SESSION['project']['info']['idTienda'];
                        $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
                        $codigo                         = $idTransaccion;
                        $updateTienda = $this->logica->updateAno($idTienda,$codigo);
    
                    }else if($_GET['TX_VALUE']== _PRECIO_PLAN_PRO){
                        //insertar en la tabla
                        $estadoTx = lang("trans_aprobada");
                        $claseLabel = "label-success";
                        $where['codigoPago']                           = $idTransaccion;
                        $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                        $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                        $dataInserta['estadoPago']      = $transactionState;
                        $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                        $dataInserta['transactionid']   = $transactionId;
                        $dataInserta['reference_pol']   = $reference_pol;
                        $dataInserta['valor']           = $TX_VALUE;
                        $dataInserta['moneda']          = $currency;
                        $dataInserta['entidad']         = $lapPaymentMethod;
                        $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                        $dataInserta['codigopago']      = $referenceCode;
                        //$dataInserta['Plan']            = "movil y web";
                        $dataInserta['ip']              = getIP();
                        $dataInserta['plan']            = "web1";
                        $idTienda = $_SESSION['project']['info']['idTienda'];
                        $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
                        $codigo                         = $idTransaccion;
                        $updateTienda = $this->logica->updateTiendapro($idTienda,$codigo);
    
                    }else if($_GET['TX_VALUE'] == (_PRECIO_PLAN_PRO * _MESES_DE_COBRO_ANO_PLAN_PRO)){
                        //insertar en la tabla
                        $estadoTx = lang("trans_aprobada");
                        $claseLabel = "label-success";
                        $where['codigoPago']                           = $idTransaccion;
                        $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                        $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                        $dataInserta['estadoPago']      = $transactionState;
                        $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                        $dataInserta['transactionid']   = $transactionId;
                        $dataInserta['reference_pol']   = $reference_pol;
                        $dataInserta['valor']           = $TX_VALUE;
                        $dataInserta['moneda']          = $currency;
                        $dataInserta['entidad']         = $lapPaymentMethod;
                        $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                        $dataInserta['codigopago']      = $referenceCode;
                        //$dataInserta['Plan']            = "movil y web";
                        $dataInserta['ip']              = getIP();
                        $dataInserta['plan']            = "web2";
                        $idTienda = $_SESSION['project']['info']['idTienda'];
                        $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
                        $codigo                         = $idTransaccion;
                        $updateTienda = $this->logica->updateAnoPro($idTienda,$codigo);
    
                    }
                }
                else{
                    if($_GET['TX_VALUE'] == _PRECIO_PLAN_BASIC){
                        $estadoTx = lang("trans_aprobada");
                        $claseLabel = "label-success";

                        $where['codigopago']            = $idTransaccion;
                        $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                        $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                        $dataInserta['estadoPago']      = $transactionState;
                        $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                        $dataInserta['transactionid']   = $transactionId;
                        $dataInserta['reference_pol']   = $reference_pol;
                        $dataInserta['valor']           = $TX_VALUE;
                        $dataInserta['moneda']          = $currency;
                        $dataInserta['entidad']         = $lapPaymentMethod;
                        $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                        //$dataInserta['Plan']            = "movil y web";
                        $dataInserta['ip']              = getIP();
                        $dataInserta['plan']            = "app1";
                        $idTienda = $_SESSION['project']['info']['idTienda'];
                        $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
                        $codigo                         = $idTransaccion;
                        $updatemes = $this->logica->updatemes($idTienda,$codigo);
                    }
                    else if($_GET['TX_VALUE'] == (_PRECIO_PLAN_BASIC * _MESES_DE_COBRO_ANO_PLAN_BASIC)){

                        $estadoTx = lang("trans_aprobada");
                        $claseLabel = "label-success";

                        $where['codigopago']            = $idTransaccion;
                        $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                        $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                        $dataInserta['estadoPago']      = $transactionState;
                        $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                        $dataInserta['transactionid']   = $transactionId;
                        $dataInserta['reference_pol']   = $reference_pol;
                        $dataInserta['valor']           = $TX_VALUE;
                        $dataInserta['moneda']          = $currency;
                        $dataInserta['entidad']         = $lapPaymentMethod;
                        $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                        //$dataInserta['Plan']            = "movil y web";
                        $dataInserta['ip']              = getIP();
                        $dataInserta['plan']            = "app2";
                        $idTienda = $_SESSION['project']['info']['idTienda'];
                        $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
                        $codigo                         = $idTransaccion;
                        $updatemes = $this->logica->updatemes($idTienda,$codigo);
                    }
                    else if($_GET['TX_VALUE'] == _PRECIO_PLAN_PRO){

                        $estadoTx = lang("trans_aprobada");
                        $claseLabel = "label-success";

                        $where['codigopago']            = $idTransaccion;
                        $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                        $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                        $dataInserta['estadoPago']      = $transactionState;
                        $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                        $dataInserta['transactionid']   = $transactionId;
                        $dataInserta['reference_pol']   = $reference_pol;
                        $dataInserta['valor']           = $TX_VALUE;
                        $dataInserta['moneda']          = $currency;
                        $dataInserta['entidad']         = $lapPaymentMethod;
                        $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                        //$dataInserta['Plan']            = "movil y web";
                        $dataInserta['ip']              = getIP();
                        $dataInserta['plan']            = "web1";
                        $idTienda = $_SESSION['project']['info']['idTienda'];
                        $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
                        $codigo                         = $idTransaccion;
                        $updatemes = $this->logica->updatePagoMesPro($idTienda,$codigo);
                    }
                    else if($_GET['TX_VALUE'] == (_PRECIO_PLAN_PRO * _MESES_DE_COBRO_ANO_PLAN_PRO)){
                        
                        $estadoTx = lang("trans_aprobada");
                        $claseLabel = "label-success";

                        $where['codigopago']            = $idTransaccion;
                        $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                        $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                        $dataInserta['estadoPago']      = $transactionState;
                        $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                        $dataInserta['transactionid']   = $transactionId;
                        $dataInserta['reference_pol']   = $reference_pol;
                        $dataInserta['valor']           = $TX_VALUE;
                        $dataInserta['moneda']          = $currency;
                        $dataInserta['entidad']         = $lapPaymentMethod;
                        $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                        //$dataInserta['Plan']            = "movil y web";
                        $dataInserta['ip']              = getIP();
                        $dataInserta['plan']            = "web2";
                        $idTienda = $_SESSION['project']['info']['idTienda'];
                        $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
                        $codigo                         = $idTransaccion;
                        $updatemes = $this->logica->updatePagoAnoPro($idTienda,$codigo);
                    }
                    
                }
            }
            else if ($_GET['transactionState'] == 6 ) {
                $estadoTx = lang("trans_rechazada");
                $claseLabel = "label-danger";
    
                if($_GET['TX_VALUE'] == _PRECIO_PLAN_BASIC){
                        
                        $estadoTx = lang("trans_rechazada");
                        $claseLabel = "label-danger";

                        $where['codigopago']            = $idTransaccion;
                        $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                        $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                        $dataInserta['estadoPago']      = $transactionState;
                        $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                        $dataInserta['transactionid']   = $transactionId;
                        $dataInserta['reference_pol']   = $reference_pol;
                        $dataInserta['valor']           = $TX_VALUE;
                        $dataInserta['moneda']          = $currency;
                        $dataInserta['entidad']         = $lapPaymentMethod;
                        $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                        //$dataInserta['Plan']            = "movil y web";
                        $dataInserta['ip']              = getIP();
                        $dataInserta['plan']            = "app1";
                        $idTienda = $_SESSION['project']['info']['idTienda'];
                        $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
                }else if($_GET['TX_VALUE'] == (_PRECIO_PLAN_BASIC * _MESES_DE_COBRO_ANO_PLAN_BASIC)){
                        
                        $estadoTx = lang("trans_rechazada");
                        $claseLabel = "label-danger";

                        $where['codigopago']            = $idTransaccion;
                        $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                        $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                        $dataInserta['estadoPago']      = $transactionState;
                        $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                        $dataInserta['transactionid']   = $transactionId;
                        $dataInserta['reference_pol']   = $reference_pol;
                        $dataInserta['valor']           = $TX_VALUE;
                        $dataInserta['moneda']          = $currency;
                        $dataInserta['entidad']         = $lapPaymentMethod;
                        $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                        //$dataInserta['Plan']            = "movil y web";
                        $dataInserta['ip']              = getIP();
                        $dataInserta['plan']            = "app2";
                        $idTienda = $_SESSION['project']['info']['idTienda'];
                        $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
                }else if($_GET['TX_VALUE'] == _PRECIO_PLAN_PRO){

                    $estadoTx = lang("trans_rechazada");
                    $claseLabel = "label-danger";

                        $where['codigopago']            = $idTransaccion;
                        $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                        $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                        $dataInserta['estadoPago']      = $transactionState;
                        $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                        $dataInserta['transactionid']   = $transactionId;
                        $dataInserta['reference_pol']   = $reference_pol;
                        $dataInserta['valor']           = $TX_VALUE;
                        $dataInserta['moneda']          = $currency;
                        $dataInserta['entidad']         = $lapPaymentMethod;
                        $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                        $dataInserta['plan']            = "web1";
                        $dataInserta['ip']              = getIP();
                        $idTienda = $_SESSION['project']['info']['idTienda'];
                        $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);

                }else if($_GET['TX_VALUE'] == (_PRECIO_PLAN_PRO * _MESES_DE_COBRO_ANO_PLAN_PRO)){
                        
                        $estadoTx = lang("trans_rechazada");
                        $claseLabel = "label-danger";

                        $where['codigopago']            = $idTransaccion;
                        $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                        $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                        $dataInserta['estadoPago']      = $transactionState;
                        $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                        $dataInserta['transactionid']   = $transactionId;
                        $dataInserta['reference_pol']   = $reference_pol;
                        $dataInserta['valor']           = $TX_VALUE;
                        $dataInserta['moneda']          = $currency;
                        $dataInserta['entidad']         = $lapPaymentMethod;
                        $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                        $dataInserta['plan']            = "web2";
                        $dataInserta['ip']              = getIP();
                        $idTienda = $_SESSION['project']['info']['idTienda'];
                        $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
                }
            }
            else if ($_GET['transactionState'] == 104 ) {
                $estadoTx = "Error";
                $claseLabel = "label-danger";
    
                if($_GET['TX_VALUE'] == _PRECIO_PLAN_BASIC){

                    $estadoTx = "Error";
                    $claseLabel = "label-danger";
                        
                    $where['codigopago']            = $idTransaccion;
                    $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                    $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                    $dataInserta['estadoPago']      = $transactionState;
                    $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                    $dataInserta['transactionid']   = $transactionId;
                    $dataInserta['reference_pol']   = $reference_pol;
                    $dataInserta['valor']           = $TX_VALUE;
                    $dataInserta['moneda']          = $currency;
                    $dataInserta['entidad']         = $lapPaymentMethod;
                    $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                    //$dataInserta['Plan']            = "movil y web";
                    $dataInserta['ip']              = getIP();
                    $dataInserta['plan']            = "app1";
                    $idTienda = $_SESSION['project']['info']['idTienda'];
                    $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
            }else if($_GET['TX_VALUE'] == (_PRECIO_PLAN_BASIC * _MESES_DE_COBRO_ANO_PLAN_BASIC)){
                    
                    $estadoTx = "Error";
                    $claseLabel = "label-danger";

                    $where['codigopago']            = $idTransaccion;
                    $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                    $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                    $dataInserta['estadoPago']      = $transactionState;
                    $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                    $dataInserta['transactionid']   = $transactionId;
                    $dataInserta['reference_pol']   = $reference_pol;
                    $dataInserta['valor']           = $TX_VALUE;
                    $dataInserta['moneda']          = $currency;
                    $dataInserta['entidad']         = $lapPaymentMethod;
                    $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                    //$dataInserta['Plan']            = "movil y web";
                    $dataInserta['ip']              = getIP();
                    $dataInserta['plan']            = "app2";
                    $idTienda = $_SESSION['project']['info']['idTienda'];
                    $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
            }else if($_GET['TX_VALUE'] == _PRECIO_PLAN_PRO){

                    $estadoTx = "Error";
                    $claseLabel = "label-danger";
                    
                    $where['codigopago']            = $idTransaccion;
                    $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                    $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                    $dataInserta['estadoPago']      = $transactionState;
                    $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                    $dataInserta['transactionid']   = $transactionId;
                    $dataInserta['reference_pol']   = $reference_pol;
                    $dataInserta['valor']           = $TX_VALUE;
                    $dataInserta['moneda']          = $currency;
                    $dataInserta['entidad']         = $lapPaymentMethod;
                    $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                    $dataInserta['plan']            = "web1";
                    $dataInserta['ip']              = getIP();
                    $idTienda = $_SESSION['project']['info']['idTienda'];
                    $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);

            }else if($_GET['TX_VALUE'] == (_PRECIO_PLAN_PRO * _MESES_DE_COBRO_ANO_PLAN_PRO)){

                    $estadoTx = "Error";
                    $claseLabel = "label-danger";

                    $where['codigopago']            = $idTransaccion;
                    $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                    $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                    $dataInserta['estadoPago']      = $transactionState;
                    $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                    $dataInserta['transactionid']   = $transactionId;
                    $dataInserta['reference_pol']   = $reference_pol;
                    $dataInserta['valor']           = $TX_VALUE;
                    $dataInserta['moneda']          = $currency;
                    $dataInserta['entidad']         = $lapPaymentMethod;
                    $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                    $dataInserta['plan']            = "web2";
                    $dataInserta['ip']              = getIP();
                    $idTienda = $_SESSION['project']['info']['idTienda'];
                    $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
            }
            }
            else if ($_GET['transactionState'] == 7 ) {
                $estadoTx = lang("trans_pendiente");
                $claseLabel = "label-warning";
    
                if($_GET['TX_VALUE'] == _PRECIO_PLAN_BASIC){
                    
                    $estadoTx = lang("trans_pendiente");
                    $claseLabel = "label-warning";

                    $where['codigopago']            = $idTransaccion;
                    $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                    $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                    $dataInserta['estadoPago']      = $transactionState;
                    $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                    $dataInserta['transactionid']   = $transactionId;
                    $dataInserta['reference_pol']   = $reference_pol;
                    $dataInserta['valor']           = $TX_VALUE;
                    $dataInserta['moneda']          = $currency;
                    $dataInserta['entidad']         = $lapPaymentMethod;
                    $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                    //$dataInserta['Plan']            = "movil y web";
                    $dataInserta['ip']              = getIP();
                    $dataInserta['plan']            = "app1";
                    $idTienda = $_SESSION['project']['info']['idTienda'];
                    $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
            }else if($_GET['TX_VALUE'] == (_PRECIO_PLAN_BASIC * _MESES_DE_COBRO_ANO_PLAN_BASIC)){
                    
                    $estadoTx = lang("trans_pendiente");
                    $claseLabel = "label-warning";

                    $where['codigopago']            = $idTransaccion;
                    $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                    $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                    $dataInserta['estadoPago']      = $transactionState;
                    $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                    $dataInserta['transactionid']   = $transactionId;
                    $dataInserta['reference_pol']   = $reference_pol;
                    $dataInserta['valor']           = $TX_VALUE;
                    $dataInserta['moneda']          = $currency;
                    $dataInserta['entidad']         = $lapPaymentMethod;
                    $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                    //$dataInserta['Plan']            = "movil y web";
                    $dataInserta['ip']              = getIP();
                    $dataInserta['plan']            = "app2";
                    $idTienda = $_SESSION['project']['info']['idTienda'];
                    $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
            }else if($_GET['TX_VALUE'] == _PRECIO_PLAN_PRO){

                    $estadoTx = lang("trans_pendiente");
                    $claseLabel = "label-warning";

                    $where['codigopago']            = $idTransaccion;
                    $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                    $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                    $dataInserta['estadoPago']      = $transactionState;
                    $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                    $dataInserta['transactionid']   = $transactionId;
                    $dataInserta['reference_pol']   = $reference_pol;
                    $dataInserta['valor']           = $TX_VALUE;
                    $dataInserta['moneda']          = $currency;
                    $dataInserta['entidad']         = $lapPaymentMethod;
                    $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                    $dataInserta['plan']            = "web1";
                    $dataInserta['ip']              = getIP();
                    $idTienda = $_SESSION['project']['info']['idTienda'];
                    $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);

            }else if($_GET['TX_VALUE'] == (_PRECIO_PLAN_PRO * _MESES_DE_COBRO_ANO_PLAN_PRO)){
                    
                    $estadoTx = lang("trans_pendiente");
                    $claseLabel = "label-warning";

                    $where['codigopago']            = $idTransaccion;
                    $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                    $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                    $dataInserta['estadoPago']      = $transactionState;
                    $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                    $dataInserta['transactionid']   = $transactionId;
                    $dataInserta['reference_pol']   = $reference_pol;
                    $dataInserta['valor']           = $TX_VALUE;
                    $dataInserta['moneda']          = $currency;
                    $dataInserta['entidad']         = $lapPaymentMethod;
                    $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                    $dataInserta['plan']            = "web2";
                    $dataInserta['ip']              = getIP();
                    $idTienda = $_SESSION['project']['info']['idTienda'];
                    $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
            }
            }
            else {
                    $estadoTx=$_GET['mensaje'];
                    $claseLabel = "";
    
                if($_GET['TX_VALUE'] == _PRECIO_PLAN_BASIC){
                    
                    $estadoTx=$_GET['mensaje'];
                    $claseLabel = "";

                    $where['codigopago']            = $idTransaccion;
                    $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                    $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                    $dataInserta['estadoPago']      = $transactionState;
                    $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                    $dataInserta['transactionid']   = $transactionId;
                    $dataInserta['reference_pol']   = $reference_pol;
                    $dataInserta['valor']           = $TX_VALUE;
                    $dataInserta['moneda']          = $currency;
                    $dataInserta['entidad']         = $lapPaymentMethod;
                    $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                    //$dataInserta['Plan']            = "movil y web";
                    $dataInserta['ip']              = getIP();
                    $dataInserta['plan']            = "app1";
                    $idTienda = $_SESSION['project']['info']['idTienda'];
                    $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
            }else if($_GET['TX_VALUE'] == (_PRECIO_PLAN_BASIC * _MESES_DE_COBRO_ANO_PLAN_BASIC)){
                    
                    $estadoTx=$_GET['mensaje'];
                    $claseLabel = "";

                    $where['codigopago']            = $idTransaccion;
                    $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                    $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                    $dataInserta['estadoPago']      = $transactionState;
                    $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                    $dataInserta['transactionid']   = $transactionId;
                    $dataInserta['reference_pol']   = $reference_pol;
                    $dataInserta['valor']           = $TX_VALUE;
                    $dataInserta['moneda']          = $currency;
                    $dataInserta['entidad']         = $lapPaymentMethod;
                    $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                    //$dataInserta['Plan']            = "movil y web";
                    $dataInserta['ip']              = getIP();
                    $dataInserta['plan']            = "app2";
                    $idTienda = $_SESSION['project']['info']['idTienda'];
                    $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
            }else if($_GET['TX_VALUE'] == _PRECIO_PLAN_PRO){

                    $estadoTx=$_GET['mensaje'];
                    $claseLabel = "";

                    $where['codigopago']            = $idTransaccion;
                    $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                    $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                    $dataInserta['estadoPago']      = $transactionState;
                    $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                    $dataInserta['transactionid']   = $transactionId;
                    $dataInserta['reference_pol']   = $reference_pol;
                    $dataInserta['valor']           = $TX_VALUE;
                    $dataInserta['moneda']          = $currency;
                    $dataInserta['entidad']         = $lapPaymentMethod;
                    $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                    $dataInserta['plan']            = "web1";
                    $dataInserta['ip']              = getIP();
                    $idTienda = $_SESSION['project']['info']['idTienda'];
                    $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);

            }else if($_GET['TX_VALUE'] == (_PRECIO_PLAN_PRO * _MESES_DE_COBRO_ANO_PLAN_PRO)){
                    
                    $estadoTx=$_GET['mensaje'];
                    $claseLabel = "";

                    $where['codigopago']            = $idTransaccion;
                    $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
                    $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
                    $dataInserta['estadoPago']      = $transactionState;
                    $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
                    $dataInserta['transactionid']   = $transactionId;
                    $dataInserta['reference_pol']   = $reference_pol;
                    $dataInserta['valor']           = $TX_VALUE;
                    $dataInserta['moneda']          = $currency;
                    $dataInserta['entidad']         = $lapPaymentMethod;
                    $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
                    $dataInserta['plan']            = "web2";
                    $dataInserta['ip']              = getIP();
                    $idTienda = $_SESSION['project']['info']['idTienda'];
                    $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
            }
            }
        }
            
        //var_dump($_GET);die();
        else if ($_GET['transactionState'] == 7 ) {

            $estadoTx = "Transacción pendiente";
            $claseLabel = "label-danger";

            $where['codigopago']            = $idTransaccion;
            $estadoTx = lang("trans_pendiente");
            $claseLabel = "label-warning";
            $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
            $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
            $dataInserta['estadoPago']      = $transactionState;
            $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
            $dataInserta['transactionid']   = $transactionId;
            $dataInserta['reference_pol']   = $reference_pol;
            $dataInserta['valor']           = $TX_VALUE;
            $dataInserta['moneda']          = $currency;
            $dataInserta['entidad']         = $lapPaymentMethod;
            $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
            $dataInserta['codigopago']      = $referenceCode;
            //$dataInserta['Plan']            = "movil";
            $dataInserta['ip']              = getIP();
            $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
        }
        else if ($_GET['transactionState'] == 104 ) {
            $estadoTx = "Error";
            $claseLabel = "label-danger";

            $where['codigopago']            = $idTransaccion;
            $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
            $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
            $dataInserta['estadoPago']      = $transactionState;
            $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
            $dataInserta['transactionid']   = $transactionId;
            $dataInserta['reference_pol']   = $reference_pol;
            $dataInserta['valor']           = $TX_VALUE;
            $dataInserta['moneda']          = $currency;
            $dataInserta['entidad']         = $lapPaymentMethod;
            $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
            $dataInserta['codigopago']      = $referenceCode;
            //$dataInserta['Plan']            = "movil";
            $dataInserta['ip']              = getIP();
            $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
        }
        else if ($_GET['transactionState'] == 6 ) {
            $estadoTx = lang("trans_rechazada");
            $claseLabel = "label-danger";

            $where['codigopago']            = $idTransaccion;
            $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
            $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
            $dataInserta['estadoPago']      = $transactionState;
            $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
            $dataInserta['transactionid']   = $transactionId;
            $dataInserta['reference_pol']   = $reference_pol;
            $dataInserta['valor']           = $TX_VALUE;
            $dataInserta['moneda']          = $currency;
            $dataInserta['entidad']         = $lapPaymentMethod;
            $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
            $dataInserta['codigopago']      = $referenceCode;
            //$dataInserta['Plan']            = "movil";
            $dataInserta['ip']              = getIP();
            $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
        }
        else if ($_GET['transactionState'] == 998 ) {
            $estadoTx = lang("Pago realizado");
            $claseLabel = "label-success";

            $where['codigopago']            = $idTransaccion;
            $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
            $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
            $dataInserta['estadoPago']      = $transactionState;
            $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
            $dataInserta['transactionid']   = $transactionId;
            $dataInserta['reference_pol']   = $reference_pol;
            $dataInserta['valor']           = $TX_VALUE;
            $dataInserta['moneda']          = $currency;
            $dataInserta['entidad']         = $lapPaymentMethod;
            $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
            $dataInserta['codigopago']      = $referenceCode;
            //$dataInserta['Plan']            = "movil";
            $dataInserta['ip']              = getIP();
            $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
        }
        else if ($_GET['transactionState'] == 999 ) {
            $estadoTx = lang("Pago no realizado");
            $claseLabel = "label-danger";

            $where['codigopago']            = $idTransaccion;
            $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
            $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
            $dataInserta['estadoPago']      = $transactionState;
            $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
            $dataInserta['transactionid']   = $transactionId;
            $dataInserta['reference_pol']   = $reference_pol;
            $dataInserta['valor']           = $TX_VALUE;
            $dataInserta['moneda']          = $currency;
            $dataInserta['entidad']         = $lapPaymentMethod;
            $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
            $dataInserta['codigopago']      = $referenceCode;
            //$dataInserta['Plan']            = "movil";
            $dataInserta['ip']              = getIP();
            $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
        }
        else if ($_GET['transactionState'] == 000 ) {
            $estadoTx = lang("Esperando pago");
            $claseLabel = "label-default";

            $where['codigopago']            = $idTransaccion;
            $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
            $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
            $dataInserta['estadoPago']      = $transactionState;
            $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
            $dataInserta['transactionid']   = $transactionId;
            $dataInserta['reference_pol']   = $reference_pol;
            $dataInserta['valor']           = $TX_VALUE;
            $dataInserta['moneda']          = $currency;
            $dataInserta['entidad']         = $lapPaymentMethod;
            $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
            $dataInserta['codigopago']      = $referenceCode;
            //$dataInserta['Plan']            = "movil";
            $dataInserta['ip']              = getIP();
            $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
        }
        else{
            $estadoTx = lang("Otro estado");
            $claseLabel = "";

            $where['codigopago']            = $idTransaccion;
            $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
            $dataInserta['nombrePersona']   = $_GET['buyerEmail'];
            $dataInserta['estadoPago']      = $transactionState;
            $dataInserta['formaPago']       = $_GET['lapPaymentMethodType'];
            $dataInserta['transactionid']   = $transactionId;
            $dataInserta['reference_pol']   = $reference_pol;
            $dataInserta['valor']           = $TX_VALUE;
            $dataInserta['moneda']          = $currency;
            $dataInserta['entidad']         = $lapPaymentMethod;
            $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
            $dataInserta['codigopago']      = $referenceCode;
            //$dataInserta['Plan']            = "movil";
            $dataInserta['ip']              = getIP();
            $updatePedido                   = $this->logica->insertdatapago($where,$dataInserta);
        }

        //var_dump($_GET);die();
        $salida['estadoTx']         =   $estadoTx;
        $salida['ApiKey']           =   $ApiKey;
        $salida['merchant_id']      =   $merchant_id;
        $salida['referenceCode']    =   $referenceCode;
        $salida['TX_VALUE']         =   $TX_VALUE;
        $salida['New_value']        =   $New_value;
        $salida['currency']         =   $currency;
        $salida['transactionState'] =   $transactionState;
        $salida['firma_cadena']     =   $firma_cadena;
        $salida['firmacreada']      =   $firmacreada;
        $salida['firma']            =   $firma;
        $salida['reference_pol']    =   $reference_pol;
        $salida['cus']              =   $cus;
        $salida['extra1']           =   $extra1;
        $salida['pseBank']          =   $pseBank;
        $salida['lapPaymentMethod'] =   $lapPaymentMethod;
        $salida['transactionId']    =   $transactionId;
        $salida['infoTienda']       =   $infoTienda['datos'][0];
        $salida['titulo']      = lang("resp_pago");
        $salida['titulo']      = lang("titulo")." - ".lang("text35");
        $salida['centro']      = "pedidos/respuestaPagoMembresia";
        $salida['claseLabel']   = $claseLabel;
        
		$this->load->view("registro/indexPago",$salida);
    }
}
?>