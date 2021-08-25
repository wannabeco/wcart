<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Registro extends CI_Controller 
{
	function __construct() 
    {
        parent::__construct();
        $this->load->model("registro/LogicaRegistro", "logicaReg");
        $this->load->model("general/LogicaGeneral", "logicaGen");
        $this->load->model("pedidos/LogicaPedidos", "logicaPedidos");
       	$this->load->helper('language');
    	$this->lang->load('spanish');
    }
	public function index()	
	{
		$this->login();
	}
	public function registroEmpresas()
	{
		$salida['titulo'] = lang("tituloRegistroEmp");
		$salida['centro'] = "registro/empresas";
		$salida['listaDeptos']	=		getDepartamentos('057',"ARRAY");
		$this->load->view("registro/index",$salida);
	}
	public function registroPersonas()
	{
		$salida['titulo'] = lang("tituloRegistroEmp");
		$salida['centro'] = "registro/personas";
		$salida['listaDeptos']	=		getDepartamentos('057',"ARRAY");
		$this->load->view("registro/index",$salida);
	}

	//Funciones para el AJAX
	public function getCiudades()
	{
		if(validaInApp("web"))//esta validación me hará consultas más seguras
		{
			extract($_POST);
			$ciudades =  getCiudades('057',$idDepto,"JSON");
			echo $ciudades;
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta); 
		}
	}
	public function insertaEmpresas()
	{
		if(validaInApp("web"))//esta validación me hará consultas más seguras
		{
			$procesoEmpresa = $this->logicaReg->insertaEmpresa($_POST);
			echo json_encode($procesoEmpresa);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta); 
		}
	}
	public function insertaPersonas()
	{
		if(validaInApp("web"))//esta validación me hará consultas más seguras
		{
			$procesoPersona = $this->logicaReg->insertaPersona($_POST);
			echo json_encode($procesoPersona);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta); 
		}
	}
	public function editaPersonas()
	{
		if(validaInApp("movil"))//esta validación me hará consultas más seguras
		{
			$procesoPersona = $this->logicaReg->actualizaPersona($_POST);
			echo json_encode($procesoPersona);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta); 
		}
	}
	public function guardaSeguimiento()
	{
		if(validaInApp("movil"))//esta validación me hará consultas más seguras
		{
			$seguimiento = $this->logicaReg->guardaSeguimiento($_POST);
			echo json_encode($seguimiento);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta); 
		}
	}

	/*Carga de la plantilla de edición de los módulos*/
	public function plantillaActualizaDatos()
	{
		extract($_POST);
		$whereC 			     = array("idCiudad"=>1);
		$infoPersonas	     = $this->logicaGen->getPersonas(array('idPersona'=>$id));
		$ciudades 			 = $this->logicaGen->consultaConjuntos($whereC);
		$vendedoras 		 = $this->logicaGen->getPersonas(array('idPerfil'=>5));
		//var_dump($vendedoras);
		$perfiles		  	 = $this->logicaGen->consultaPerfilesPersist($id); 
		$salida["titulo"] 	 = "Editar datos de ".$infoPersonas[0]['nombre']." ".$infoPersonas[0]['apellido'];
		$salida["datos"]  	 = $infoPersonas[0];
		$salida["idEdita"] 	 = $id;
		$salida["conjuntos"] = $ciudades['datos'];
		$salida["vendedoras"] = $vendedoras;
		$salida["labelBtn"]  = "EDITAR INFORMACIÓN";
		$salida["perfiles"]  = $perfiles;

		echo $this->load->view("registro/editaPersona",$salida,true);
	}

	/*Carga de la plantilla de edición de los módulos*/
	public function plantillaPedidoExterno()
	{
		extract($_POST);
		$whereC 			     = array("idCiudad"=>1);
		$infoPersonas	     = $this->logicaGen->getPersonas(array('idPersona'=>$id));
		$ciudades 			 = $this->logicaGen->consultaConjuntos($whereC);
		$vendedoras 		 = $this->logicaGen->getPersonas(array('idPerfil'=>5));
		//var_dump($vendedoras);
		$perfiles		  	 = $this->logicaGen->consultaPerfilesPersist($id); 
		$salida["titulo"] 	 = "Solicitar pedido para ".$infoPersonas[0]['nombre']." ".$infoPersonas[0]['apellido'];
		$salida["datos"]  	 = $infoPersonas[0];
		$salida["idEdita"] 	 = $id;
		$salida["conjuntos"] = $ciudades['datos'];
		$salida["vendedoras"] = $vendedoras;
		$salida["labelBtn"]  = "HACER PEDIDO";
		$salida["perfiles"]  = $perfiles;

		echo $this->load->view("registro/plantillaPedido",$salida,true);
	}

	public function procesaPedidoCallCenter()
	{
		extract($_POST);
		//var_dump($_POST);die();
		$respuesta = $this->logicaPedidos->pedidoTemporal($_POST);
		//inserto el pedido final
		$pedidoFinal = $this->logicaGen->insertaPedidoCliente($_POST);
		echo json_encode($pedidoFinal);
	}

	/*Carga de la plantilla de edición de los módulos*/
	public function plantillaLlamada()
	{
		extract($_POST);
		$whereC 			     = array("idCiudad"=>1);
		$infoPersonas	     = $this->logicaGen->getPersonas(array('idPersona'=>$id));
		$ciudades 			 = $this->logicaGen->consultaConjuntos($whereC);
		$vendedoras 		 = $this->logicaGen->getPersonas(array('idPerfil'=>5));
		//var_dump($vendedoras);
		$perfiles		  	 = $this->logicaGen->consultaPerfilesPersist($id); 
		$salida["titulo"] 	 = "Seguimiento a ".$infoPersonas[0]['nombre']." ".$infoPersonas[0]['apellido'];
		$salida["datos"]  	 = $infoPersonas[0];
		$salida["idEdita"] 	 = $id;
		$salida["conjuntos"] = $ciudades['datos'];
		$salida["vendedoras"] = $vendedoras;
		$salida["labelBtn"]  = "GUARDAR REGISTRO";
		$salida["perfiles"]  = $perfiles;

		echo $this->load->view("registro/llamada",$salida,true);
	}
}
?>