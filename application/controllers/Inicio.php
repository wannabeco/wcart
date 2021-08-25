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
class Inicio extends CI_Controller 
{
	function __construct() 
    {
        parent::__construct();
        $this->load->model("general/LogicaGeneral", "logica");
       	$this->load->helper('language');
    	//$this->lang->load('spanish');
    }
	public function index()	
	{
		if(isset($_SESSION['project']))
		{
			header('Location:'.base_url()."App");
		}
		else
		{
			header('Location:'.base_url()."login");
		}
	}
	public function homeEmpresa()
	{
		
	}	
	public function recordarClave()
	{
		$salida['titulo'] = lang("titulo")." - Recordar Contraseña";
		$salida['centro'] = "login/recordarClave";
		$this->load->view("login/index",$salida);
	}
	public function cabeza()
	{
		if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
        {
			$infoTienda = $this->logica->getInfoTienda($_SESSION['project']['info']['idTienda']);
        }
        else
        {
        	$infoTienda = array();
        }
		$salida['infoTienda'] = $infoTienda;
		$salida['opc']    	  = "";
		$salida['modulos']    = $this->logica->getModulos(1);
		echo $this->load->view("app/menu",$salida,true);
	}
}
?>