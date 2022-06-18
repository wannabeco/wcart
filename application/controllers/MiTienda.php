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
class MiTienda extends CI_Controller 
{
	function __construct() 
    {
        parent::__construct();
        $this->load->model("general/LogicaGeneral", "logica");//la idea es que este archivo siempre esté ya que aquí se consultan cosas que son muy globales.
        $this->load->model("MiTienda/LogicaMiTienda", "LogicaMiTienda");//aquí se debe llamar la lógica correspondiente al módulo que se esté haciendo.
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
	public function miTienda($idModulo)
	{
		
		//valido que haya una sesión de usuario, si no existe siempre lo enviaré al login
		if(validaIngreso())
		{
			/*******************************************************************************************/
			/* ESTA SECCIÓN DE CÓDIGO  ES MUY IMPORTANTE YA QUE ES LA QUE CONTROLARÁ EL MÓDULO VISITADO*/
			/*******************************************************************************************/
			//si no se declara está variable en cada inicio del módulo no se podrán consultar los privilegios
			$_SESSION['moduloVisitado']		=	$idModulo;
			//antes de pintar la plantilla del módulo valido si hay permisos de ver ese módulo para evitar que ingresen al módulo vía URL
			if(getPrivilegios()[0]['ver'] == 1)
			{ 
				
				//info Módulo
				$infoModulo	      	           = $this->logica->infoModulo($idModulo);
				$infoTienda	      	           = $this->LogicaMiTienda->infoTienda($_SESSION['project']['info']['idTienda']);
				$infoTipoTienda	      	       = $this->LogicaMiTienda->infoTipoTienda();
				$infopaises					   = $this->LogicaMiTienda->infopaises();
				$infoDisenoTienda			   = $this->LogicaMiTienda->infoDisenoTienda();
				$opc 				           = "home";
				$salida['titulo']              = lang("titulo")." - ".$infoModulo[0]['nombreModulo'];
				$salida['centro'] 	           = "MiTienda/home";
				$salida['infoTienda'] 	       = $infoTienda[0];
				$salida['infoTipoTienda'] 	   = $infoTipoTienda;
				$salida['infopaises'] 	       = $infopaises;
				$salida['infoDisenoTienda']	   = $infoDisenoTienda;
				//var_dump($infoTienda[0]); die;
				$salida['infoModulo']          = $infoModulo[0];
				$this->load->view("app/index",$salida);
			}
			else
			{
				$opc 				   = "home";
				$salida['titulo']      = lang("titulo")." - Área Restringida";
				$salida['centro'] 	   = "error/areaRestringida";
				$this->load->view("app/index",$salida);
			}
		}
		else
		{
			header('Location:'.base_url()."login");
		}
	}
	public function getPaises(){
		$infopaises = $this->LogicaMiTienda->infopaises($_POST['ID_PAIS']);
		echo json_encode($infopaises);
	}
	public function getDepartamentos(){
		
		$infodepartamentos	= $this->LogicaMiTienda->infodepartamentos($_POST['idPais']);
		echo json_encode($infodepartamentos);
	}
	public function getCiudades(){
		
		$infociudades	= $this->LogicaMiTienda->infociudades($_POST['idPais'], $_POST['idDepartamentos']);
		echo json_encode($infociudades);
	}
	public function procesaDataTienda(){
		
		$actualizaMiTienda	= $this->LogicaMiTienda->actualizaMiTienda($_POST);
		echo json_encode($actualizaMiTienda);
	}
	public function procesaDataGrafico(){
		
		$actualizaGraficos	= $this->LogicaMiTienda->actualizaMiTienda($_POST);
		echo json_encode($actualizaGraficos);
	}
	//cargar logos
	
	public function procesaDatalogos(){
		
		extract($_POST);
		@mkdir('assets/uploads/files/'.$idTienda,0777);
		$salida=""; 
		$error ="";
		$config['upload_path'] = 'assets/uploads/files/'.$idTienda.'/';
		//echo $config['upload_path'];
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '20000';
        $config['max_width']  = '500';
        $config['max_height']  = '200';
        $this->load->library('upload', $config);
    	$this->upload->initialize($config);
		//var_dump($config);
    	if(!$this->upload->do_upload('logoTienda')) 
    	{	
			
			$error_sistema = trim(strip_tags($this->upload->display_errors()));
			// validacion tamano de imagen
			if($error_sistema == "The image you are attempting to upload doesn't fit into the allowed dimensions."){
				$error = lang("text_tamano_imagen_logo");
				$salida = array("mensaje"=>$error,
                               "continuar"=>0,
                               "datos"=>"");
				
			}
			//validacion formato de imagen
			else if($error_sistema == "The filetype you are attempting to upload is not allowed."){
				$error = lang("text_formato_imagen");
				$salida = array("mensaje"=>$error,
                               "continuar"=>0,
                               "datos"=>"");	
			}
			//validacion peso de imagen
			else if($error_sistema == "The file you are attempting to upload is larger than the permitted size."){
				$error = lang("text_peso_imagen");
		 		$salida = array("mensaje"=>$error,
                            "continuar"=>0,
                            "datos"=>"");	
			}
			
				// $salida = array("mensaje"=>$error_sistema,
                //                "continuar"=>0,
                //                "datos"=>"");
			
    	}
    	else
    	{
				$data 					= $this->upload->data();
	            $dataLogo['logoTienda']	=	$data['file_name'];
	            $dataLogo['idTienda']			=	$idTienda;
	            //procedo a actualizar la información del usuario
	            $salida 	 	=  $this->LogicaMiTienda->actualizaMiTienda($dataLogo);
			
		}
		echo json_encode($salida);
		
	}
	public function procesaDatafavicon(){
		
		extract($_POST);
		@mkdir('assets/uploads/files/'.$idTienda,0777);
		
		$config['upload_path'] = 'assets/uploads/files/'.$idTienda.'/';
		//echo $config['upload_path'];
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '1';
        $config['max_width']  = '1000';
        $config['max_height']  = '1000';
        $this->load->library('upload', $config);
    	$this->upload->initialize($config);
		//var_dump($config);
    	if(!$this->upload->do_upload('faviconTienda')) 
    	{
			$salida="";
			$error ="";
			$error_sistema = trim(strip_tags($this->upload->display_errors()));
			//validacion tamano de imagen
			if($error_sistema== "The image you are attempting to upload doesn't fit into the allowed dimensions."){
				$error = lang("text_tamano_imagen_favicon");
				$salida = array("mensaje"=>$error,
                               "continuar"=>0,
                               "datos"=>"");
			}
			//validacion formato de imagen
			else if($error_sistema == "The filetype you are attempting to upload is not allowed."){
				$error = lang("text_formato_imagen");
				$salida = array("mensaje"=>$error,
                               "continuar"=>0,
                               "datos"=>"");	
			}
			//validacion peso de imagen
			else if($error_sistema == "The file you are attempting to upload is larger than the permitted size."){
				$error = lang("text_peso_imagen");
		 		$salida = array("mensaje"=>$error,
                            "continuar"=>0,
                            "datos"=>"");	
			}
			
    	}
    	else
    	{
				$data 							= $this->upload->data();
	            $datafavicon['faviconTienda']		=	$data['file_name'];
	            $datafavicon['idTienda']			=	$idTienda;
	            //procedo a actualizar la información del usuario
	            $salida 	 	=  $this->LogicaMiTienda->actualizaMiTienda($datafavicon);
			
		}
		echo json_encode($salida);
		
	}

	//Actualiza Pagos
	public function procesaDataPagos(){
		
		$getActualizaPago	= $this->LogicaMiTienda->actualizaMiTienda($_POST);
		echo json_encode($getActualizaPago);
	}
	

	public function cargaPlantillaModal()
	{
	
	}
}
?>