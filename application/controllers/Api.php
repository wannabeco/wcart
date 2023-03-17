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
ini_set("display_errors",0);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Headers: Content-Type,x-prototype-version,x-requested-with');
defined('BASEPATH') OR exit('No direct script access allowed');
//ajuste para las nuevas versiones de ANGULAR JS

$json = file_get_contents('php://input');
$json = json_decode($json,true);
if(count($json) > 0)
{
    $_POST = $json;
}
else
{
    $_POST = $_POST;
}
class Api extends CI_Controller 
{
	function __construct() 
    {
        parent::__construct();
        $this->load->model("general/LogicaGeneral", "logica");//la idea es que este archivo siempre esté ya que aquí se consultan cosas que son muy globales.
        $this->load->model("administrativos/LogicaAdministrativos", "ladminis");//aquí se debe llamar la lógica correspondiente al módulo que se esté haciendo.
        $this->load->model("login/LogicaLogin", "logicaLogin");
        $this->load->model("registro/LogicaRegistro", "logicaReg");
        $this->load->model("admin/LogicaUsuarios", "logicaUsuarios");
        $this->load->model("pedidos/LogicaPedidos", "logicaPedidos");
        $this->load->model("tienda/logicaTienda", "logicaTienda");//aqui se llama la logica para crear una nueva tiendas
       	$this->load->helper('language');//mantener siempre.
    	$this->lang->load('spanish');//mantener siempre.
        $this->load->library('Excel',"excel");
        $this->load->model("home/BaseDatosHome","dbHome");//logica home, para obtener lo banner
    }

    /*
    * Login desde las aps móviles
    * @author Farez Prieto
    * @date 20 Marzo 2019
    */
    public function login()
    {
    	extract($_POST);
    	//súper acceso a la app
		if(validaInApp($movil))//esta validación me hará consultas más seguras
		{
			$post['idPerfil'] 	= _PERFIL_COMPRADOR;//limito a perfil comprador
			$post['usuario'] 	= $username;
			$post['clave'] 		= $contrasena;
            $codigoTienda       = (isset($_POST['idTienda']))?$_POST['idTienda']:"";
			//busco la foto con la palabra que envien
			$logueo = $this->logicaLogin->getLoginUsuario($post,array(),$codigoTienda);
            //var_dump($logueo["datos"]);die();
            if($logueo["datos"]["eliminado"] == 0){

                $respuesta = array("mensaje"=>"Bienvenido".$logueo['datos']['nombre']." ".$logueo['datos']['apellido'],
                               "continuar"=>1,
                               "datos"=>$logueo["datos"]); 
                echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
            }
            else{
                $respuesta = array("mensaje"=>"Usuario o Contraseña son incorrectos",
                               "continuar"=>0,
                               "datos"=>""); 

                echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
            }
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                               "continuar"=>0,
                               "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}
    }

    /*
    * Login desde las aps móviles
    * @author Farez Prieto
    * @date 20 Marzo 2019
    */
    public function loginVendedores()
    {
        extract($_POST);
        //súper acceso a la app
        if(validaInApp($movil))//esta validación me hará consultas más seguras
        {
            $whereIn   = array(_PERFIL_VENDEDOR,_PERFIL_ADMIN_VENTAS,1);//limito a perfil comprador

            $post['usuario']    = $username;
            $post['clave']      = $contrasena;
            //busco la foto con la palabra que envien
            $logueo = $this->logicaLogin->getLoginUsuario($post,$whereIn);
            echo json_encode($logueo);
        }
        else
        {
            $respuesta = array("mensaje"=>"Acceso no admitido.",
                               "continuar"=>0,
                               "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
        }
    }
    /*
    * Recordar  clave
    * @author Farez Prieto
    * @date 20 Marzo 2019
    */
    public function olvidoClave()
    {
    	extract($_POST);
    	//súper acceso a la app
		if(validaInApp($movil))//esta validación me hará consultas más seguras
		{
			$post['usuario'] 	= $email;

            if($email === ''){
                $respuesta = array("mensaje"=>"Por favor ingrese un correo electronico.",
                              "continuar"=>0,
                              "datos"=>""); 
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);    
            }
            else{
                //busco la foto con la palabra que envien
			$logueo = $this->logicaLogin->cambioClave($post);
			echo json_encode($logueo, JSON_UNESCAPED_UNICODE);
            }
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}
    }

    /*
    * Actualización de información
    * @author Farez Prieto
    */
    public function actualizaData()
    {
        extract($_POST);
        //súper acceso a la app
        if(validaInApp($movil))//esta validación me hará consultas más seguras
        {
            //busco la foto con la palabra que envien
            $respuesta = $this->logicaReg->actualizaPersona($_POST);
        }
        else
        {
            $respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
    }
    public function updateTokenFCM()
    {
        extract($_POST);
        //súper acceso a la app
        if(validaInApp($movil))//esta validación me hará consultas más seguras
        {
            //busco la foto con la palabra que envien
            $respuesta = $this->logicaReg->updateTokenFCMTienda($_POST);
        }
        else
        {
            $respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
    }

    public function FCM($titulo,$mensaje)
    {
        $tokenDevice = 'dmJdcJXcRqc:APA91bHiUHLazsHNQt6nhBThj_OY1UgOcV4Q-7bFhe-Zr1CTMRQYTu2zcX6Iy1lJOqYbkLNHmqR-1auD58her-6tJnD45VPGI73CKt-Ffx41GJa8If6P0D9KUrCvMVNKmsiHfRVrKa97';
        sendFCM($mensaje,$titulo,$tokenDevice);
    }

    //funcion de verificacion de vendedor por medio del codigo
    public function verificaVendedor()
    {
        //var_dump($_POST);
        //estraigo el id del vendedor
        $pedazos    = explode("-",$_POST['codVende']);
        $idUsuario  = (count($pedazos) == 2)?$pedazos[1]:0;
        $where['u.idPersona']  = $idUsuario;
        $where['u.idPerfil']   = _PERFIL_VENDEDOR;
        $respuesta  = $this->logicaUsuarios->verificaVendedor($where);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

    /*
    * Registro de usuarios
    * @author Farez Prieto
    * @date 20 Marzo 2019
    * Esta función puede consultar las ciudades o los departamentos
    */
    public function getCiudades()
    {
    	extract($_POST);
    	//súper acceso a la app
		if(validaInApp($movil))//esta validación me hará consultas más seguras
		{
			if($query == 'depto')
	    	{
				$post['ID_PAIS'] 	= '057';
				$group = true;
	    	}
	    	else if($query == 'ciudad')
	    	{
				$post['ID_PAIS'] 	= '057';
				$post['ID_DPTO'] 	= $depto;
				$group = true;
	    	}

			//busco la foto con la palabra que envien
			$logueo = $this->logica->getDepartamentos($post,$group);
			echo json_encode($logueo);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}
    }
    public function getNotificacionesPersonaSinLeer()
    {
    	extract($_POST);
    	//súper acceso a la app
		if(validaInApp($movil))//esta validación me hará consultas más seguras
		{
			$post['idTienda']  = $_POST['idTienda'];
			$post['idPersona']  = $_POST['idPersona'];
			$post['estado']     = 0;
			//busco la foto con la palabra que envien
			$noti = $this->logica->getNotificacionesPersona($post);
			echo json_encode($noti);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}
    }
    public function getNotificacionesPersona()
    {
    	extract($_POST);
    	//súper acceso a la app
		if(validaInApp($movil))//esta validación me hará consultas más seguras
		{
			$post['idPersona'] = $_POST['idPersona'];
			$post['idTienda']  = $_POST['idTienda'];
			//busco la foto con la palabra que envien
            $noti = $this->logica->getNotificacionesPersona($post);
            $unoti = $this->logica->updateNotificacionesPersona(array('estado'=>1,'estado'=>$_POST['idTienda'],'idPersona'=>$_POST['idPersona']),$post);
			echo json_encode($noti);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}
    }
    /*
    * Registro de usuarios
    * @author Farez Prieto
    * @date 20 Marzo 2019
    */
    public function registroUsuarios()
    {
        //var_dump($_POST);die();
    	extract($_POST);
    	//súper acceso a la app
		if(validaInApp($movil))//esta validación me hará consultas más seguras
		{

			$post['nombre'] 			= $nombre;
			$post['apellido'] 			= $apellido;
			$post['email'] 				= $email;
			$post['celular'] 			= $celular;
			$post['rclave'] 			= $rclave;
			$post['ciudad'] 			= 0;
			$post['departamento'] 		= 0;
            $post['idConjunto']         = 0;
            $post['direccion']          = (isset($direccion))?$direccion:"";
            $post['torre']              = "";
            $post['apto']               = "";
			$post['aceptaTerminos'] 	= $terminos;
			//busco la foto con la palabra que envien
			$logueo = $this->logicaReg->insertaPersona($post);
			echo json_encode($logueo);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}
    }

    /*
    * Get Servicios
    * @author Farez Prieto
    * @date 20 Marzo 2019
    */
    public function getServicios()
    {

    }

    /*
    * Get productos
    * @author Farez Prieto
    * @date 20 Marzo 2019
    */
    public function getProductos()
    {
    	extract($_POST);
    	//súper acceso a la app
		if(isset($movil) && validaInApp($movil))//esta validación me hará consultas más seguras
		{
            if(isset($idProducto))
            {

			     $where['idProducto'] 	= $idProducto;
                 $where['idEstado']     = 1;
            }
            else
            {
                $where['idEstado']     = 1;
                //$where = array();
            }



            if(isset($idTienda))
            {
			     $where['idTienda'] 	= $idTienda;
            }
			//busco la foto con la palabra que envien
			$productos = $this->logica->getProductos($where);
			
			echo json_encode($productos, JSON_UNESCAPED_UNICODE);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}

    }
    public function getSubcategorias()
    {
    	extract($_POST);
    	//súper acceso a la app
		if(isset($movil) && validaInApp($movil))//esta validación me hará consultas más seguras
		{
            if(isset($idCategoria))
            {

			     $where['idProducto'] 	= $idCategoria;
                 $where['idEstado']     = 1;
            }
            else
            {
                $where['idEstado']     = 1;
                //$where = array();
            }

            if(isset($idTienda))
            {
			     $where['idTienda'] 	= $idTienda;
            }
			//busco la foto con la palabra que envien
			$productos = $this->logica->getSubcategorias($where);
			echo json_encode($productos, JSON_UNESCAPED_UNICODE);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}

    }
    
    
    
    
    public function getInfoPresentacion()
    {
    	extract($_POST);
    	//súper acceso a la app
		if(isset($movil) && validaInApp($movil))//esta validación me hará consultas más seguras
		{
			$where['pre.idPresentacion'] 	= $idPresentacion;
            if(isset($idTienda))
            {
			     $where['pre.idTienda'] 	= $idTienda;
            }
			$productos = $this->logica->getInfoPresentacion($where);
			echo json_encode($productos, JSON_UNESCAPED_UNICODE);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}

    }

    public function getPresentacionesVendedor()
    {
        extract($_POST);
        //echo $idPerfil;
        //súper acceso a la app
        if(isset($movil) && validaInApp($movil))//esta validación me hará consultas más seguras
        {
            if(isset($idPerfil))
            {
                if($idPerfil == _PERFIL_VENDEDOR) // si es una vendedora
                {
                    $campo = 'valorPresentacionD as valorVenta';
                    $where = array();
                }

                else if($idPerfil == _PERFIL_ADMIN_VENTAS)//RAUL
                {
                    $campo = 'valorPresentacion as valorVenta';
                    $where = array();
                }
                else
                {
                    $campo = '';
                }
            }
            //$where['pre.idProducto']       = ($idProducto != '')?$idProducto:2;
            $presentaciones            = $this->logica->getPresentacionesProductoVendedor($where,$campo);
            echo json_encode($presentaciones);
        }
        else
        {
            $respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
        }
    }

    public function getPresentaciones()
    {
        extract($_POST);
        //echo $idPerfil;
        //var_dump($_POST);die();
        //súper acceso a la app
        if(isset($movil) && validaInApp($movil))//esta validación me hará consultas más seguras
        {
            if(isset($idPerfil))
            {
                $campo = 'valorPresentacion as valorVenta';
                //$where['pre.app'] = "clientes";
            }
            $where['pre.idProducto']       = ($idProducto != '')?$idProducto:2;
            $where['pre.idsubcategoria']   = ($idSubcategoria != '')?$idSubcategoria:2;
            $where['pre.idEstado']   = 1;
            $presentaciones            = $this->logica->getPresentacionesProducto($where,$campo);
            echo json_encode($presentaciones, JSON_UNESCAPED_UNICODE);
        }
        else
        {
            $respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
        }
    }

    /*
    * Inserta Solicitud
    * @author Farez Prieto
    * @date 20 Marzo 2019
    */
    public function insertaSolicitud()
    {
    	//var_dump($_POST);
    	extract($_POST);
    	//súper acceso a la app
		if(validaInApp($movil))//esta validación me hará consultas más seguras
		{
			$post['idPersona'] 	= $usuario;
			$post['idProducto'] = $servicio;
			$post['direccion'] = $direccion1;
			$post['persona'] = $persona1;
			$post['telefono'] = $telefono1;
			$post['cantidad'] = $cantidad;
			$post['texto'] = $texto;
			$post['fechaSolicitud'] = date("Y-m-d");
			$post['horaSolicitud'] = date("H:i:s");
			$post['ip'] = getIP();
			$post['lat'] = 0;
			$post['lon'] = 0;
			//busco la foto con la palabra que envien
			//busco la foto con la palabra que envien
			//busco la foto con la palabra que envien
			$productos = $this->logica->insertaSolicitud($post);
			echo json_encode($productos);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}

    }


    /*
    * Inserta pedido
    * @author Farez Prieto
    * @date 23 Abril 2019
    */
    public function insertaPedido()
    {
        extract($_POST);
        //súper acceso a la app
        if(validaInApp($movil))//esta validación me hará consultas más seguras
        {
            //busco la foto con la palabra que envien
            $productos = $this->logica->insertaPedido($_POST);
            echo json_encode($productos);
        }
        else
        {
            $respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
        }

    }


    public function insertaPedidoCliente()
    {
        //var_dump($_POST);die();
        extract($_POST);
        //súper acceso a la app
        if(validaInApp($movil))//esta validación me hará consultas más seguras
        {
            //busco la foto con la palabra que envien
            $productos = $this->logica->insertaPedidoCliente($_POST);
            echo json_encode($productos);
        }
        else
        {
            $respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
        }

    }
    
    
    //proceso donde realizo el cargo a la tarjeta por medio de stripe
    public function pagoConStripe()
    {

        //traigo la información de la tienda para saber la data de configuración de Stripe
        
        $infoTienda         = $this->logica->getInfoTiendaNew($_POST['idTienda']);

        require_once('application/libraries/stripe-php/init.php');
        //var_dump($_POST);
        \Stripe\Stripe::setApiKey($infoTienda['datos'][0]['stripe_secret']);
     
        //echo $this->config->item('stripe_secret');
     
     try {
        $charge = \Stripe\Charge::create ([
                "amount" => 100 * $_POST['totalCompra'],
                "currency" => "USD",
                "source" => $_POST['source']['source']['id'],
                "description" => $infoTienda['datos'][0]['nombreTransaccion'] 
        ]);
        
        //en la variable $charge irá la información del pago si fue exitoso o no
        //print_r($charge);
        //acá debo crear el pedido con el pago exitoso
        //armo la información para hacer el pedido
        $post['idPersona']      = $_POST['idPersona'];
        $post['totalCompra']    = $_POST['totalCompra'];
        $post['valorDomicilio'] = $_POST['valorDomicilio'];
        $post['direccion']      = $_POST['direccion'];
        $post['telefono']       = $_POST['telefono'];
        $post['formaPago']      = $_POST['formaPago'];
        $post['identificador']      = $_POST['identificador'];
        $post['estadoPago']     = 998;
        $post['transactionId']  = $charge->id;
        $post['reference_pol']  = "";
        $post['idTienda']       = $_POST['idTienda'];
        $post['moneda']         = $charge->currency;
        $post['entidad']        = "CARD ".$charge->payment_method_details->card->brand." ".$charge->payment_method_details->card->last4;
        
        
        $salida = $this->logica->insertaPedidoCliente($post);
     }
     catch(Stripe_CardError $e) {
          // Since it's a decline, Stripe_CardError will be caught
          $body = $e->getJsonBody();
          $err  = $body['error'];
        
          /*print('Status is:' . $e->getHttpStatus() . "\n");
          print('Type is:' . $err['type'] . "\n");
          print('Code is:' . $err['code'] . "\n");
          // param is '' in this case
          print('Param is:' . $err['param'] . "\n");
          print('Message is:' . $err['message'] . "\n");*/
          $salida = array("mensaje"=>"An unexpected error has occurred, please try again later","continuar"=>1,"datos"=>array());
        } catch (Stripe_InvalidRequestError $e) {
          // Invalid parameters were supplied to Stripe's API
          //print("Error 1 ".$e);
          $salida = array("mensaje"=>"An unexpected error has occurred, please try again later","continuar"=>1,"datos"=>array());
        } catch (Stripe_AuthenticationError $e) {
            //print("Error 2 ".$e);
          // Authentication with Stripe's API failed
          // (maybe you changed API keys recently)
          $salida = array("mensaje"=>"An unexpected error has occurred, please try again later","continuar"=>1,"datos"=>array());
        } catch (Stripe_ApiConnectionError $e) {
             //print("Error 3 ".$e);
          // Network communication with Stripe failed
          $salida = array("mensaje"=>"An unexpected error has occurred, please try again later","continuar"=>1,"datos"=>array());
        } catch (Stripe_Error $e) {
           // print("Error 4 ".$e);
          // Display a very generic error to the user, and maybe send
          // yourself an email
          $salida = array("mensaje"=>"An unexpected error has occurred, please try again later","continuar"=>1,"datos"=>array());
        } catch (Exception $e) {
            //print("Error 5 ".$e);
          // Something else happened, completely unrelated to Stripe
          $salida = array("mensaje"=>"your card has been declined, please try another card","continuar"=>1,"datos"=>array());
        }
        
        echo json_encode($salida);
        
    }
    
    
    public function getConfigApp()
    {
        $configuracion = array('ventaMinima'=>_CONFIG_VENTA_MINIMA,
                               'quienesSomos'=>_CONFIG_URL_QUIENES,
                               'celularWhatsapp'=>_CONFIG_CELULAR_WHATSAPP,
                               'valorDomicilio'=>_CONFIG_VALOR_DOMICILIO,
                               'minimoDomicilio'=>_CONFIG_PEDIDO_MINIMO_DOMICILIO,
                               'urlPoliticas'=>_CONFIG_POLITICAS);
        echo json_encode($configuracion); 
    }
    public function procesoPagoOnline($idPedido,$proveedor,$idTienda)
    {   
        $infoPedido         = $this->logicaPedidos->getPedidos(array("idPedido"=>($idPedido)));
        $productosPedido    = $this->logicaPedidos->productosPedidos(array("d.idPedido"=>($idPedido)));
        $infoTienda         = $this->logica->getInfoTiendaNew($idTienda);
        //consulto la info de la tienda
		$salida['titulo']       = "Pasarela de pago";
		$salida['centro']       = "registro/pagoOnline";
		$salida['infoPedido']   = $infoPedido[0];
		$salida['infoTienda']   = $infoTienda['datos'][0];
		$salida['productosPedido']  = $productosPedido;
		$salida['proveedor']    = $proveedor;
		$this->load->view("registro/indexPago",$salida);
    }

    public function verificaEstadoPedido()
    {
         //var_dump($_POST);die();
         extract($_POST);
         //súper acceso a la app
         if(validaInApp($movil))//esta validación me hará consultas más seguras
         {
             //busco la foto con la palabra que envien
             $infoPedido = $this->logicaPedidos->getPedidos(array("idPedido"=>($idPedido)));
             $respuesta = array("mensaje"=>"DATA DEL PEDIDO",
                               "continuar"=>1,
                               "datos"=>$infoPedido); 
             echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
         }
         else
         {
             $respuesta = array("mensaje"=>"Acceso no admitido.",
                               "continuar"=>0,
                               "datos"=>""); 
 
             echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
         }
    }

    //pedido para ester y para raul
    public function insertaPedidoVendedores()
    {
        //var_dump($_POST);die();
        extract($_POST);
        //súper acceso a la app
        if(validaInApp($movil))//esta validación me hará consultas más seguras
        {
            //busco la foto con la palabra que envien
            $productos = $this->logica->insertaPedidoVendedores($_POST);
            echo json_encode($productos);
        }
        else
        {
            $respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
        }

    }

    public function getBannersHome()
    {
        extract($_POST);
        //súper acceso a la app
        if(validaInApp($movil))//esta validación me hará consultas más seguras
        {   
            $where['b.idTienda'] 	    = $idTienda;
            $where['b.idEstado'] 	    = $estado;
            //traigo los banners para la app
            $bannersHome = $this->logica->getBannersHome($where);
            echo json_encode($bannersHome);
        }
        else
        {
            $respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
        }

    }


    /*
    * Lee el carrito
    * @author Farez Prieto
    * @date 3 de Abril 2019
    */
    public function leeCarrito()
    {
        extract($_POST);
        //súper acceso a la app
        if(validaInApp($movil))//esta validación me hará consultas más seguras
        {
            $respuesta = array("mensaje"=>"Data Carrito",
                              "continuar"=>1,
                              "datos"=>$_SESSION['carrito']); 
        }
        else
        {
            $respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

        }

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
    }

    /*
    * Agrega al carrito
    * @author Farez Prieto
    * @date 3 de Abril 2019
    */
    public function agregaCarrito()
    {
        //var_dump($_POST);
        extract($_POST);
        //súper acceso a la app
        if(validaInApp($movil))//esta validación me hará consultas más seguras
        {
           //unset($_SESSION['carrito']);
            $datos = array('idProducto'=>$servicio,
                            'cantidad'=>$cantidad);
            //$productos[$servicio] = $datos;
            $_SESSION['carrito'][] = $datos;
            
            $respuesta = array("mensaje"=>"Producto agregado al carrito",
                              "continuar"=>1,
                              "datos"=>$_SESSION['carrito']); 
        }
        else
        {
            $respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
    }

    /*
    * Consulta Solicitud
    * @author Farez Prieto
    * @date 20 Marzo 2019
    */
    public function consultaSolicitudes()
    {
    	//var_dump($_POST);
    	extract($_POST);
    	//súper acceso a la app
		if(validaInApp($movil))//esta validación me hará consultas más seguras
		{
            if($filtro == 1)//mis pedidos hechos
            {
			     $post['p.idPersona'] 	= $usuario;
            }
            else if($filtro == 2)//pedidos para mi
            {
                $post['p.pedidoPara']    = $usuario;
            }
            else
            {
                $post['p.idPersona']    = $usuario;
            }
			if(isset($idPedido))
			{
				$post['p.idPedido'] 	= $idPedido;
			}
			$solicitudes = $this->logica->consultaSolicitudes($post);
			echo json_encode($solicitudes);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}

    }
    /*
    * Get Info persona
    * @author Faarez Prieto
    */
    public function getInfoUsuario()
    {
    	extract($_POST);
    	//súper acceso a la app
		if(validaInApp($movil))//esta validación me hará consultas más seguras
		{
			$post['idPersona'] 	= $idusuario;
			//busco la foto con la palabra que envien
			$logueo = $this->logicaUsuarios->infoUsuario($idusuario);
			echo json_encode($logueo);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}
    }
    /*
    * getCiudadesVentas
    * @author Farez Prieto
    */
    public function getCiudadesVentas()
    {
        extract($_POST);
        //súper acceso a la app
        if(validaInApp($movil))//esta validación me hará consultas más seguras
        {
            //$post['idPersona']    = $idusuario;
            //busco la foto con la palabra que envien
            $ciudades = $this->logica->getCiudadesVentas();
            echo json_encode($ciudades);
        }
        else
        {
            $respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
        }
    }
    /*
    * getConjuntos
    * @author Farez Prieto
    */
    public function getConjuntos()
    {
        //$post['idCiudad'] = 1;
        //$post['movil'] = 'movil';
        extract($_POST);
        //súper acceso a la app
        if(validaInApp($movil))//esta validación me hará consultas más seguras
        {
            $where = array("idCiudad"=>$idCiudad);
            $ciudades = $this->logica->consultaConjuntos($where);
            echo json_encode($ciudades);
        }
        else
        {
            $respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
        }
    }

    public function getDataRegistrada()
    {
        extract($_POST);
        $conjuntos           = $this->logica->consultaConjuntos();
        $consultaInfoUsuario = $logueo = $this->logicaUsuarios->infoUsuario($idusuario);

        $salidaArray = array("conjuntos"=>$conjuntos['datos'],
                             "dataUsuario"=>$consultaInfoUsuario['datos']);

        $respuesta = array("mensaje"=>"Información del usuario ",
                            "continuar"=>1,
                            "datos"=>$salidaArray); 
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
    }
    //mis pedidos, se actualiza $misPedidos = $this->logicaPedidos->misPedidos($quere); se asigna p a p.idpersona
    public function misPedidos()
    {
        extract($_POST);
        $where = array("p.idPersona"=>$idPersona,"p.idTienda"=>$idTienda);
        $misPedidos = $this->logicaPedidos->misPedidos($where);
        echo json_encode($misPedidos);
    }

    public function getPedido()
    {
        extract($_POST);
        $infoPedido      = $this->logicaPedidos->getPedidos(array("idPedido"=>($idSolicitud)));
        $productosPedido = $this->logicaPedidos->productosPedidos(array("idPedido"=>($idSolicitud)));

        if(count($infoPedido) > 0 && countsftps($productosPedido) > 0)
        {   
            $datosPedidos['infoPedido']      = $infoPedido[0];
            $datosPedidos['productosPedido'] = $productosPedido;

            $respuesta = array("mensaje"=>"Información del pedido ",
                              "continuar"=>1,
                              "datos"=>$datosPedidos); 

        }
        else
        {
             $respuesta = array("mensaje"=>"No hay productos para este pedido",
                              "continuar"=>0,
                              "datos"=>""); 

        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

    public function getEstadisticas()
    {
        extract($_POST);
        //calculo las fechas depende del filtro que venga
        if($filtro == 'hoy')
        {
            $fechaIni   =   date("Y-m-d 00:00:00");
            $fechaFin   =   date("Y-m-d 23:59:59");
        }
        else if($filtro == 'ayer')
        {
            $fechaIni   =   restaDias(date("Y-m-d 00:00:00"),1);
            $fechaFin   =   restaDias(date("Y-m-d 23:59:59"),1);
            //echo $fechaIni." - ".$fechaFin;
        }
        else if($filtro == 'semana')
        {
            $year=date("Y");
            $month=date("m");
            $day=date("d");
            # Obtenemos el numero de la semana
            $semana=date("W",mktime(0,0,0,$month,$day,$year));
            # Obtenemos el día de la semana de la fecha dada
            $diaSemana=date("w",mktime(0,0,0,$month,$day,$year));
            # el 0 equivale al domingo...
            if($diaSemana==0)
            {
                $diaSemana=7;
            }
            # A la fecha recibida, le restamos el dia de la semana y obtendremos el lunes
            $fechaIni=date("Y-m-d 00:00:00",mktime(0,0,0,$month,$day-$diaSemana+1,$year));
            # A la fecha recibida, le sumamos el dia de la semana menos siete y obtendremos el domingo
            $fechaFin=date("Y-m-d 23:59:59",mktime(0,0,0,$month,$day+(7-$diaSemana),$year));
            //echo $fechaIni." - ".$fechaFin;
        }
        else if($filtro == 'mes')
        {
            $fechaIni   =   date("Y-m-01 00:00:00");
            $fechaFin   =   date("Y-m-31 23:59:59"); 
            //echo $fechaIni." - ".$fechaFin;
        }
        else if($filtro == 'todo')
        {
            $fechaIni   =   '';
            $fechaFin   =   ''; 
            //echo $fechaIni." - ".$fechaFin;
        }
        //si las fechas vienen llenas
        if($fechaIni != '')
        {
            $estatics  = $this->logicaPedidos->getEstadisticas(array("idPersona"=>$idPersona,
                                                                     "fecha >="=>$fechaIni,
                                                                     "fecha <="=>$fechaFin));
        }
        else
        {
            $estatics  = $this->logicaPedidos->getEstadisticas(array("idPersona"=>$idPersona));
        }
        $respuesta = array("mensaje"=>"Estadisticas del usuario",
                          "continuar"=>1,
                          "datos"=>$estatics); 
    

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }
    public function getMisClientes()
    {
        extract($_POST);
        $clientes  = $this->logica->getPersonas(array("idPadre"=>$idPersona));
        $respuesta = array("mensaje"=>"Lista de clientes",
                          "continuar"=>1,
                          "datos"=>$clientes);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

    public function getPedidosPersona()
    {
        extract($_POST);
        //calculo las fechas depende del filtro que venga
        if($filtro == 'hoy')
        {
            $fechaIni   =   date("Y-m-d 00:00:00");
            $fechaFin   =   date("Y-m-d 23:59:59");
        }
        else if($filtro == 'ayer')
        {
            $fechaIni   =   restaDias(date("Y-m-d 00:00:00"),1);
            $fechaFin   =   restaDias(date("Y-m-d 23:59:59"),1);
            //echo $fechaIni." - ".$fechaFin;
        }
        else if($filtro == 'semana')
        {
            $year=date("Y");
            $month=date("m");
            $day=date("d");
            # Obtenemos el numero de la semana
            $semana=date("W",mktime(0,0,0,$month,$day,$year));
            # Obtenemos el día de la semana de la fecha dada
            $diaSemana=date("w",mktime(0,0,0,$month,$day,$year));
            # el 0 equivale al domingo...
            if($diaSemana==0)
            {
                $diaSemana=7;
            }
            # A la fecha recibida, le restamos el dia de la semana y obtendremos el lunes
            $fechaIni=date("Y-m-d 00:00:00",mktime(0,0,0,$month,$day-$diaSemana+1,$year));
            # A la fecha recibida, le sumamos el dia de la semana menos siete y obtendremos el domingo
            $fechaFin=date("Y-m-d 23:59:59",mktime(0,0,0,$month,$day+(7-$diaSemana),$year));
            //echo $fechaIni." - ".$fechaFin;
        }
        else if($filtro == 'mes')
        {
            $fechaIni   =   date("Y-m-01 00:00:00");
            $fechaFin   =   date("Y-m-31 23:59:59"); 
            //echo $fechaIni." - ".$fechaFin;
        }
        $pedidos  = $this->logicaPedidos->getPedidos(array("p.pedidoPara"=>$idPersona,
                                                          "p.fechaPedido >="=>$fechaIni,
                                                          "p.fechaPedido <="=>$fechaFin));
        //recorro y armo un super arreglo
        $salida = array();
        foreach($pedidos as $ped)
        {
            //echo $ped['pedidoPadre'];
            $productosPedido = $this->logicaPedidos->productosPedidos(array("idPedido"=>$ped['idPedido']));
            $infoPedido      = $this->logicaPedidos->getPedidos(array("idPedido"=>$ped['pedidoPadre']));
            //var_dump($infoPedido);
            if(count($infoPedido) > 0)
            {
                $infoComprador   = $this->logica->getPersonas(array("idPersona"=>$infoPedido[0]['idPersona']));
            }
            else
            {
                $infoComprador   = array();
            }
            //saco los productos del pedido
            $arrayNuevo = array("dataPedido"=>$ped,
                                "dataComprador"=>$infoComprador,
                                "productosPedido"=>$productosPedido);
            array_push($salida ,$arrayNuevo);
        }

        
         $respuesta = array("mensaje"=>"Pedidos del usuario",
                          "continuar"=>1,
                          "datos"=>$salida); 
    

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

     public function getComprasVendedor()
    {
        extract($_POST);
        //calculo las fechas depende del filtro que venga
        if($filtro == 'hoy')
        {
            $fechaIni   =   date("Y-m-d 00:00:00");
            $fechaFin   =   date("Y-m-d 23:59:59");
        }
        else if($filtro == 'ayer')
        {
            $fechaIni   =   restaDias(date("Y-m-d 00:00:00"),1);
            $fechaFin   =   restaDias(date("Y-m-d 23:59:59"),1);
        }
        else if($filtro == 'semana')
        {
            $year=date("Y");
            $month=date("m");
            $day=date("d");
            # Obtenemos el numero de la semana
            $semana=date("W",mktime(0,0,0,$month,$day,$year));
            # Obtenemos el día de la semana de la fecha dada
            $diaSemana=date("w",mktime(0,0,0,$month,$day,$year));
            # el 0 equivale al domingo...
            if($diaSemana==0)
            {
                $diaSemana=7;
            }
            # A la fecha recibida, le restamos el dia de la semana y obtendremos el lunes
            $fechaIni=date("Y-m-d 00:00:00",mktime(0,0,0,$month,$day-$diaSemana+1,$year));
            # A la fecha recibida, le sumamos el dia de la semana menos siete y obtendremos el domingo
            $fechaFin=date("Y-m-d 23:59:59",mktime(0,0,0,$month,$day+(7-$diaSemana),$year));
            //echo $fechaIni." - ".$fechaFin;
        }
        else if($filtro == 'mes')
        {
            $fechaIni   =   date("Y-m-01 00:00:00");
            $fechaFin   =   date("Y-m-31 23:59:59"); 
            //echo $fechaIni." - ".$fechaFin;
        }

        $pedidos  = $this->logicaPedidos->getPedidos(array("p.idPersona"=>$idPersona,
                                                          "p.fechaPedido >="=>$fechaIni,
                                                          "p.fechaPedido <="=>$fechaFin));
        //recorro y armo un super arreglo
        $salida = array();
        foreach($pedidos as $ped)
        {
            $productosPedido = $this->logicaPedidos->productosPedidos(array("idPedido"=>$ped['idPedido']));
            //saco los productos del pedido
            $arrayNuevo = array("dataPedido"=>$ped,
                                "productosPedido"=>$productosPedido);
            array_push($salida ,$arrayNuevo);
        }

        
         $respuesta = array("mensaje"=>"Pedidos del usuario",
                          "continuar"=>1,
                          "datos"=>$salida); 
    

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

    public function agregaPedidoTemporal()
    {   
        extract($_POST);
        if(validaInApp($movil)){
            $respuesta = $this->logicaPedidos->pedidoTemporal($_POST);
            // echo json_encode($respuesta);
        }
        else{

            $respuesta = array("mensaje"=>"Acceso no admitido",
                          "continuar"=>0,
                          "datos"=>""); 
            }
            

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

    public function gestionaPedidoRecibido()
    {
        extract($_POST);
        $respuesta = $this->logicaPedidos->gestionaPedidoRecibido($_POST);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

    public function getEstadosPedido()
    {   
        $estados = $this->logica->getEstadosPedido();
        echo json_encode($estados);
    }

    public function updatePedidoTemporal()
    {
        $where['idPedidoTemp']      = $_POST['idPedidoTemp'];
        $where['idTienda']          = $_POST['idTienda'];
        $dataActualiza['cantidad']  = $_POST['cantidad'];
        $identificador              = $_POST['identificador'];
        $respuesta = $this->logicaPedidos->updatePedidoTemporal($where,$dataActualiza);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

    public function eliminaItemTemporal()
    {
        $where['idPedidoTemp']              = $_POST['idItem'];
        // $dataActualiza['eliminado']         = 1;
        $respuesta = $this->logicaPedidos->eliminaItemTemporal($where);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }
    
    public function getPedidoTemporal()
    {
        $where = array("identificador"=>$_POST['identificador'],"d.idTienda"=>$_POST['idTienda'],"d.eliminado"=>0);
        $respuesta = $this->logicaPedidos->getPedidoTemporal($where);
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

    public function cambioContrasena()
    {
        //primero debo verificar si la clave actual es la correcta
        $post['usuario']    = $_POST['correo'];
        $post['clave']      = $_POST['aclave'];
        //busco la foto con la palabra que envien
        $logueo = $this->logicaLogin->getLoginUsuario($post);
        //echo json_encode($logueo);
        //var_dump($logueo);
        if($logueo['datos'] != '')
        {
            $where['idGeneral']         = $_POST['idPersona'];
            $dataActualiza['clave']     = sha1($_POST['rnclave']);
            $dataActualiza['clave64']   = base64_encode($_POST['rnclave']);
            $respuesta                  = $this->logica->cambioContrasena($where,$dataActualiza);
        }
        else
        {
            $respuesta = array("mensaje"=>"La contraseña actual no es correcta, por favor verifique",
                            "continuar"=>0,
                            "datos"=>"");
        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }

    public function sendMensaje()
    {

       /*  curl -X POST \ https://api.nexmo.com/beta/messages \ -H 'Authorization: Bearer' $JWT \ -H 'Content-Type: application/json' \ -d '{ "from":{ "type":"whatsapp", "number":"WHATSAPP_NUMBER" }, "to":{ "type":"whatsapp", "number":"TO_NUMBER" }, "message":{ "content":{ "type":"template", "template":{ "name":"whatsapp:hsm:technology:nexmo:verify", "parameters":[ { "default":"Nexmo Verification" }, { "default":"64873" }, { "default":"10" } ] } } } } ' */

       define("WHATSAPP_NUMBER",    "573114881738");
       define("TO_NUMBER",          "573043499416");

            /*$msg = array
            (
                //'api_key'   => "3183231b",
                //'api_secret'=> "o2s3hpHsramp62Rg",
                'from'   => array('type'=>'WHATSAPP','number'=>WHATSAPP_NUMBER),
                'to'   => array('type'=>'WHATSAPP','number'=>TO_NUMBER),
                'message'   => array('content'=>array('type'=>'text','text'=>'Probando envío de mensajes...'))
            );*/

            $json['from']['type']               = "whatsapp";
            $json['from']['number']             = WHATSAPP_NUMBER;
            $json['to']['type']                 = "whatsapp";
            $json['to']['number']               = TO_NUMBER;
            $json['message']['content']['type'] = "text";
            $json['message']['content']['text'] = "Probando envío de mensajes...";
            //echo print_r(json_encode($json));die();
            $headers = array
            (
                //'Authorization: Bearer 3183231b:o2s3hpHsramp62Rg',
                'Content-Type: application/json',
                'Accept: application/json',
            );
            try
            {
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://api.nexmo.com/v0.1/messages' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch, CURLOPT_USERPWD, "3183231b:o2s3hpHsramp62Rg");
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($json) );
            $result = curl_exec($ch );
            curl_close( $ch );
            echo $result;
            }
            catch(Exception $e){
                echo $e;
                echo "inside catch";
            }
    }


    public function getPedidosTienda()
    {
        extract($_POST);
        //echo $idPedido;
        $wherePedidos["p.idPersona"] = $idPersona;
        $wherePedidos["p.idTienda"]  = $idTienda;
        if(isset($_POST["idPedido"]))
        {
            $wherePedidos["p.idPedido"]  = $idPedido;
        }
        $pedidos  = $this->logicaPedidos->getPedidos($wherePedidos);
        //recorro y armo un super arreglo
        $salida = array();
        foreach($pedidos as $ped)
        {
            $productosPedido = $this->logicaPedidos->productosPedidos(array("idPedido"=>$ped['idPedido']));
            //saco los productos del pedido
            $arrayNuevo = array("dataPedido"=>$ped,
                                "productosPedido"=>$productosPedido);
            array_push($salida ,$arrayNuevo);
        }
        
        $respuesta = array("mensaje"=>"Pedidos del usuario",
                          "continuar"=>1,
                          "datos"=>$salida); 
    

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    }
    //información de la tienda
    public function infoTienda()
    {
        extract($_POST);
        $infoTienda         = $this->logica->getInfoTiendaNew($idTienda);
        echo json_encode($infoTienda, JSON_UNESCAPED_UNICODE);
    }
    //insert comentarios
    public function insertaComentario()
    {
        extract($_POST);
        if(validaInApp($movil))//esta validación me hará consultas más seguras
		{
            extract($_POST);
            $infoTienda         = $this->logica->insertaComentario($_POST);
            echo json_encode($infoTienda, JSON_UNESCAPED_UNICODE);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}
    }
    //get comentarios
    public function getInforComentarios()
    {
        extract($_POST);
    	//súper acceso a la app
		if(validaInApp($movil))//esta validación me hará consultas más seguras
		{
			$post['idPresentacion']     = $_POST['idPresentacion'];
            $post['p.eliminado']          =$_POST['eliminado'];
			//busco la foto con la palabra que envien
			$noti = $this->logica->getInforComentarios($post);
			echo json_encode($noti);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}    
    }

    //informacion 8 nueva  presentacion 
    public function infoPresentacionNew()
    {
        extract($_POST);
        //súper acceso a la app
        if(validaInApp($movil))//esta validación me hará consultas más seguras
        {
            $post['pre.idTienda']           = $_POST['idTienda'];
            $post['pre.idEstado']           = $_POST['idEstado'];
            $post['nuevo']              = $_POST['nuevo'];
            $infoNew         = $this->logica->getInfoPresentacionNew($post);
            echo json_encode($infoNew);
        }
        else{
            
            $respuesta = array("mensaje"=>"Acceso no admitido a consultar los 8 primeros productos.",
                              "continuar"=>0,
                              "datos"=>""); 
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        }
        
    }

    //ciudades
    public function getInforCiudades()
    {
        extract($_POST);
    	//súper acceso a la app
		if(validaInApp($movil))//esta validación me hará consultas más seguras
		{
			//$post['ID_PAIS']            = $_POST['ID_PAIS'];
			$post['ID_DPTO']            = $_POST['ID_DPTO'];

			//busco la foto con la palabra que envien
			$res = $this->logica->getInfoCiudades($post);
			echo json_encode($res);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido a consulta de ciudades.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}    
    }
    //get tiendas por url amigable
    public function infoTiendaUrl()
    {   
        extract($_POST);
        if(validaInApp($movil))//esta validación me hará consultas más seguras
		{
        $post['urlAmigable']            = $_POST['urlAmigable'];
        $infoTienda         = $this->logica->infoTiendaUrl($post);
        echo json_encode($infoTienda, JSON_UNESCAPED_UNICODE);
        }
        else{
            $respuesta = array("mensaje"=>"Acceso no admitido a consultar la tienda por url.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
        }
    }
    // consultar tipo de documento
    public function InfoDocumentos()
    {
        extract($_POST);
        if(validaInApp($movil))//esta validación me hará consultas más seguras
		{
            $infoDocumento         = $this->logica->InfoDocumentos();
            echo json_encode($infoDocumento, JSON_UNESCAPED_UNICODE);
        }
        else{
            $respuesta = array("mensaje"=>"Acceso no admitido a consultar los documentos.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
        }
    }
    //crear nueva tienda
    public function crearTienda()
    {
        extract($_POST);
        if(validaInApp($movil))//esta validación me hará consultas más seguras
		{
            extract($_POST);
            $_FILES = $_POST['logoTienda'];
            $crearTienda         = $this->logicaTienda->crearTienda($_POST,$_FILES);
            echo json_encode($crearTienda, JSON_UNESCAPED_UNICODE);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}
    }
    // informacion de los tipos de tienda
    public function infoTipoTienda(){
        extract($_POST);
        if(validaInApp($movil))//esta validación me hará consultas más seguras
		{
            $infoTipoTienda         = $this->logica->infoTipoTienda();
            echo json_encode($infoTipoTienda, JSON_UNESCAPED_UNICODE);
        }
        else{
            $respuesta = array("mensaje"=>"Acceso no admitido a consultar los documentos.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
        }
    }
    //se obtiene la informacion de solo los banner
    public function getBanners()
    {
        extract($_POST);
        //súper acceso a la app
        if(validaInApp($movil))//esta validación me hará consultas más seguras
        {   
            $where['idTienda'] 	    = $idTienda;
            $where['idEstado'] 	     = $estado;
            //traigo los banners para la app
            $bannersHome = $this->dbHome->getBanner($where);
            echo json_encode($bannersHome);
        }
        else
        {
            $respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
        }

    }
    //todos las presentaciones por idTienda
    public function getAllPresentaciones(){
        extract($_POST);
        //súper acceso a la app
        if(validaInApp($movil))//esta validación me hará consultas más seguras
        {   
            $where['idTienda'] 	    = $idTienda;
            $where['idEstado'] 	    = $idEstado;
            //traigo los banners para la app
            $bannersHome = $this->dbHome->getAllPresentaciones($where);
            echo json_encode($bannersHome);
        }
        else
        {
            $respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
        }
    }
    
    //informacion del usuario por id
    public function getUsuario()
    {
        extract($_POST);
        //súper acceso a la app
        if(validaInApp($movil))//esta validación me hará consultas más seguras
        {   
            $where['idPersona'] 	    = $idPersona;
            $where['eliminado'] 	    = $eliminado;
            //traigo los banners para la app
            $respuesta = $this->dbHome->getUsuario($where);
            // echo json_encode($respuesta);
        }
        else
        {
            $respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 
        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
    }
   //presentacion por id
   public function getInfoPresentacionid()
    {
    	extract($_POST);
    	//súper acceso a la app
		if(isset($movil) && validaInApp($movil))//esta validación me hará consultas más seguras
		{
			$where['pre.idPresentacion'] 	= $idPresentacion;
            $where['pre.idEstado']          = $idEstado;
            if(isset($idTienda))
            {
			     $where['pre.idTienda'] 	= $idTienda;
            }
			$productos = $this->logica->getInfoPresentacion($where);
			echo json_encode($productos, JSON_UNESCAPED_UNICODE);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}

    }
    //informacion de tiendas 
    public function getInfoTiendas()
    {
    	extract($_POST);
        //var_dump($_POST);die();
    	//súper acceso a la app
		if(isset($movil) && validaInApp($movil))//esta validación me hará consultas más seguras
		{
            $where          = $_POST['urlAmigable'];
			$productos = $this->logica->getInfoTiendas($where);
			echo json_encode($productos, JSON_UNESCAPED_UNICODE);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}
    }
    //se obtienen los email de personas
    public function getEmail()
    {
    	extract($_POST);
        //var_dump($_POST);die();
    	//súper acceso a la app
		if(isset($movil) && validaInApp($movil))//esta validación me hará consultas más seguras
		{
            $where          = $_POST['email'];
			$emailes = $this->logica->getEmail($where);
			echo json_encode($emailes, JSON_UNESCAPED_UNICODE);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}
    }
    // informacion del dueño de la tienda por id
    public function getCreadorTienda()
    {
    	extract($_POST);
        // var_dump($_POST);die();
    	//súper acceso a la app
		if(isset($movil) && validaInApp($movil))//esta validación me hará consultas más seguras
		{
            $where 	        = $_POST['idPersona'];
            $respuesta = $this->logica->getCreadorTienda($where);
			echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}

    }
    //informacion de login con email
    public function getLogin()
    {
    	extract($_POST);
        // var_dump($_POST);die();
    	//súper acceso a la app
		if(isset($movil) && validaInApp($movil))//esta validación me hará consultas más seguras
		{
            $where 	        = $_POST['usuario'];
            $respuesta = $this->logica->getLogin($where);
			echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}

    }
    public function eliminaCuenta()
    {
    	extract($_POST);
        // var_dump($_POST);die();
    	//súper acceso a la app
		if(isset($movil) && validaInApp($movil))//esta validación me hará consultas más seguras
		{
            $where 	        = $_POST['idUsuario'];
            $respuesta = $this->logica->eliminaCuenta($where);
			echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE); 
		}

    }
}
?>