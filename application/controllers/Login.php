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
class Login extends CI_Controller 
{
	function __construct() 
    {
        parent::__construct();
        $this->load->model("general/LogicaGeneral", "logicaGen");
        $this->load->model("login/LogicaLogin", "logicaLogin");
       	$this->load->helper('language');
    	$this->lang->load('spanish');
    }
	public function index()	
	{

		if(isset($_SESSION['project']))
		{
			header('Location:'.base_url()."App");
		}
		else
		{
			$this->login();
			$_SESSION['inproject']	=	1;//esta sesión se activa para indicar que la aplicación esta arriba.
		}
		
	}
	public function logout()
	{
        auditoria("CIERREDESESION","Ha salido del sistema el usuario ".$_SESSION['project']['info']['nombre']." ".$_SESSION['project']['info']['apellido']." | ".$_SESSION['project']['info']['idPersona']);
		unset($_SESSION['project']);
		unset($_SESSION['pago']);
		header('Location:'.base_url()."login");
	}
	public function login()
	{
		$salida['titulo'] = lang("titulo");
		$salida['centro'] = "login/home";
		$this->load->view("login/index",$salida);
	}
	//Funciones para el AJAX
	public function getPicture()
	{
		if(validaInApp("web"))//esta validación me hará consultas más seguras
		{
			//busco la foto con la palabra que envien
			$imagen = $this->logicaLogin->getPictureLogin($_POST);
			echo json_encode($imagen);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta); 
		}
	}
	public function verificaIngreso($usuario="", $clave="")
	{	
		if($usuario!= "" && $clave != ""){
			$post['usuario'] = $usuario;
			$post['clave'] = $clave;
			
				$logueo = $this->logicaLogin->getLoginUsuario($post);
				if($logueo['continuar']==1){
					echo "<script> document.location='".base_url('App')."'</script>";
				}
				else{
					echo "<script> document.location='".base_url('login')."'</script>";
				}
		}
		else{
			//súper acceso a la app
			if(validaInApp("web"))//esta validación me hará consultas más seguras
			{
				//busco la foto con la palabra que envien
				$logueo = $this->logicaLogin->getLoginUsuario($_POST);
				echo json_encode($logueo);
			}
			else
			{
				$respuesta = array("mensaje"=>"Acceso no admitido.",
								"continuar"=>0,
								"datos"=>""); 

				echo json_encode($respuesta); 
			}	
		}
	}

	public function cambioClave()
	{
		//súper acceso a la app
		if(validaInApp("web"))//esta validación me hará consultas más seguras
		{
			//busco la foto con la palabra que envien
			$claveCambio = $this->logicaLogin->cambioClave($_POST);
			echo json_encode($claveCambio);
		}
		else
		{
			$respuesta = array("mensaje"=>"Acceso no admitido.",
                              "continuar"=>0,
                              "datos"=>""); 

            echo json_encode($respuesta); 
		}
	}
}
?>