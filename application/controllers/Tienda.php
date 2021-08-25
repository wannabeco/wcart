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
class Tienda extends CI_Controller 
{
	function __construct() 
    {
        parent::__construct();
        $this->load->model("general/LogicaGeneral", "logica");
        $this->load->model("home/LogicaHome", "logicaHome");
        $this->load->model("tienda/LogicaTienda", "logicaTienda");
       	$this->load->helper('language');
    	$this->lang->load('spanish');
    }
	public function index()	
	{
		
	}
	public function crearTienda()	
	{
        //var_dump($_POST);die();
		$proceso =  $this->logicaTienda->crearTienda($_POST,$_FILES);
		echo json_encode($proceso);
	}

}
?>