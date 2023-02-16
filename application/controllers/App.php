<?php
/*

	("`-''-/").___....''"`-._
      `6_ 6  )   `-.  (     ).`-.__.`) 
      (_Y_.)'  ._   )  `._ `. ``-..-'
    _..`..'_..-_/  /..'_.' ,'
   (il),-''  (li),'  ((!.-'

   Desarrollado por  @orugal
   https://github.com/orugal
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class App extends CI_Controller 
{
	function __construct() 
    {
        parent::__construct();
        $this->load->model("general/LogicaGeneral", "logica");
        $this->load->model("pedidos/LogicaPedidos", "logicaPedidos");
        $this->load->model("tienda/LogicaTienda", "logicaTienda");
       	$this->load->helper('language');
    	//$this->lang->load('spanish');
    }
	public function index()	
	{	
			$estadoTienda = estadoTiendaAdmin();
			if($estadoTienda['mostrar'] == 1)
			{
				if(validaIngreso())
				{
				//pondre una variable en session para poner la url del sitio y poder usar en los pagos online
				$_SESSION['base_url'] = base_url();
				//sendSms('573114881738','573114881738','Hola, estoy probando los mensajes de texto desde la app Esmeralda.');
				//var_dump($_SESSION['project']);
				//consulto el total de producto que se haya cargado hasta el momento
				$totalStockKilosDisp  	  = $this->logicaPedidos->sumaTotalInventario(array("movimiento"=>"entrada"));
				$totalStockKilosVend  	  = $this->logicaPedidos->sumaTotalInventario(array("movimiento"=>"salida"));
				//var_dump($totalStockKilosVend);
				$cantidadDistri			  = $this->logica->getPersonas(array('idPerfil'=>_PERFIL_ADMIN_VENTAS,"estado"=>1,"eliminado"=>0));
				$cantidadVend			  = $this->logica->getPersonas(array('idPerfil'=>_PERFIL_VENDEDOR,"estado"=>1,"eliminado"=>0));
				$totalStock 			  =  $totalStockKilosDisp[0]['totalKilos'] - $totalStockKilosVend[0]['totalKilos'];
				//listado de pedidos
				$listaPedidos             = $this->logicaPedidos->misPedidosHome();
				$opc = "home";
				$salida['titulo'] 	  = lang("titulo");
				$salida['totalStock'] = $totalStock;
				$salida['pedidos'] 	  = $listaPedidos;
				$salida['distri'] 	  = $cantidadDistri;
				$salida['vend'] 	  = $totalStockKilosVend;
				$salida['centro'] = "app/home";
				$this->load->view("app/index",$salida);
				}
				else
				{
					header('Location:'.base_url()."login");
				}
			}
			else
			{	
				header('Location:'.base_url()."pagoMembresia/pagoMembresia");
			}
		
	}	
	public function ajaxPedidos()
	{
		$listaPedidos    = $this->logicaPedidos->misPedidosHome();
		$salida['pedidos'] 	  = $listaPedidos;
		$this->load->view("app/pedidos",$salida,false);
	}
	public function menuEmpresa($opc)
	{
		$salida['menu']   = "app/menu";
		$salida['opc']    = $opc;
		return $this->load->view("app/menu",$salida,true);
	}
	public function areas()	
	{
		if(validaIngreso())
		{
			$opc 			  = "areas"	;//persistencia del menú
			$salida['titulo'] = lang("titulo")." - ".lang("tituloArea");
			$salida['centro'] = "app/areas/home";
			$salida['menu']   =  $this->menuEmpresa($opc);
			$this->load->view("app/index",$salida);
		}
		else
		{
			header('Location:'.base_url()."login");
		}
	}
	public function personas()	
	{
		if(validaIngreso())
		{
			$opc 			  = "personas"	;//persistencia del menú
			$salida['titulo'] = lang("tituloPersonas");
			$salida['centro'] = "app/personas/home";
			$salida['menu']   =  $this->menuEmpresa($opc);
			$this->load->view("app/index",$salida);
		}
		else
		{
			header('Location:'.base_url()."login");
		}
	}
	public function proyectos()	
	{
		if(validaIngreso())
		{

			$opc 			  = "proyectos"	;//persistencia del menú
			$salida['titulo'] = lang("titulo");
			$salida['centro'] = "app/tareas/home";
			$salida['menu']   =  $this->menuEmpresa($opc);
			$this->load->view("app/index",$salida);
		}
		else
		{
			header('Location:'.base_url()."login");
		}
	}
	public function infoProyecto()	
	{
		if(validaIngreso())
		{
			$opc 			  = "proyectos"	;//persistencia del menú
			$salida['titulo'] = lang("titulo");
			$salida['centro'] = "app/tareas/infoProyecto";
			$salida['menu']   =  $this->menuEmpresa($opc);
			$this->load->view("app/index",$salida);
		}
		else
		{
			header('Location:'.base_url()."login");
		}
	}
	public function reportes()	
	{
		if(validaIngreso())
		{
			$opc 			  = "reportes"	;//persistencia del menú
			$salida['titulo'] = lang("titulo");
			$salida['centro'] = "app/home";
			$salida['menu']   =  $this->menuEmpresa($opc);
			$this->load->view("app/index",$salida);
		}
		else
		{
			header('Location:'.base_url()."login");
		}
	}

	public function interfazDescarga()	
	{
		$salida['titulo'] = lang("titulo");
		$salida['centro'] = "registro/descargaApp";
		$this->load->view("registro/index",$salida);
	}
	
	public function registroEsmeralda()	
	{
		$salida['titulo'] = lang("titulo");
		$salida['centro'] = "registro/registroLimon";
		$this->load->view("registro/index",$salida);
	}
	
	public function registroEsmeraldaInterno()	
	{
		$_SESSION['noMail'] = true;
		$salida['titulo'] = lang("titulo");
		$salida['centro'] = "registro/registroLimon";
		$this->load->view("registro/index",$salida);
	}
	
	public function llamadasCallcenter()	
	{
		$_SESSION['noMail'] = true;
		$listaPersonas  = $this->logica->getPersonasPorPerfil(3);
		//var_dump($listaPersonas);
		// foreach($listaPersonas['datos'] as $lista)
		// {
		// 	if(strlen($lista['celular']) == 10)
		// 	{
		// 		echo '57-'.$lista['celular'].'<br>';
		// 	}
		// }
		$salida['titulo'] = lang("titulo");
		$salida['camposMostrar'] = 1;
		$salida['centro'] = "registro/llamadasCallcenter";
		$salida['personas'] = $listaPersonas['datos'];
		$this->load->view("registro/index",$salida);
	}
	
	public function listadoRegistrados()	
	{
		$_SESSION['noMail'] = true;
		$listaPersonas  = $this->logica->getPersonasPorPerfil(3);
		//var_dump($listaPersonas);
		// foreach($listaPersonas['datos'] as $lista)
		// {
		// 	if(strlen($lista['celular']) == 10)
		// 	{
		// 		echo '57-'.$lista['celular'].'<br>';
		// 	}
		// }
		$salida['titulo'] = lang("titulo");
		$salida['camposMostrar'] = 0;
		$salida['centro'] = "registro/llamadasCallcenter";
		$salida['personas'] = $listaPersonas['datos'];
		$this->load->view("registro/index",$salida);
	}

	public function configuracion()	
	{
		if(validaIngreso())
		{
			$salida['titulo'] = lang("titulo");
			$salida['centro'] = "app/home";
			$salida['menu']   =  $this->menuEmpresa();
			$this->load->view("app/index",$salida);
		}
		else
		{
			header('Location:'.base_url()."login");
		}
	}
	//funcion para realizar pruebas
	/*public function pruebaMail(){
		$this->logicaTienda->pruebaLogica();
	}*/
	//prueba de envio pago membresia
	public function pruebaEnvio(){
		$this->logica->pruebaLogica();
	}
}
?>