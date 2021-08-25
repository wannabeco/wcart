<?php
/*

	("`-''-/").___....''"`-._
      `6_ 6  )   `-.  (     ).`-.__.`) 
      (_Y_.)'  ._   )  `._ `. ``-..-'
    _..`..'_..-_/  /..'_.' ,'
   (il),-''  (li),'  ((!.-'

   Desarrollado por @orugal
   https://github.com/orugal
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Usuarios extends CI_Controller 
{
	function __construct() 
    {
        parent::__construct();
        $this->load->model("general/LogicaGeneral", "logica");
        $this->load->model("admin/LogicaUsuarios", "logicaUsuarios");
       	$this->load->helper('language');
    	$this->lang->load('spanish');
    }
    /*
    * Funcion inicial del módulo de creación de usuarios
    * @author Farez Prieto
    * @date 11 de Noviembre de 2016
    * @param $idModulo Este parámetro siempre lo enviará el menú y siempre se deberá recibir en la función del módulo principal, no olvidar esto.
    * Esta función permite inicializar este módulo, dentro de ella siempre se debe declarar la variable de session $_SESSION['moduloVisitado'] con el $idModulo Pasado por parámetro
    * y a continuación siempre se debe llamar la función del helper llamada getPrivilegios, la función está en el archivo helpers/funciones_helper.php
    * Tenga en cuenta que cada llamado ajax que haga a una plantilla gráfica que incluya botones de ver,editar, crear, borrar debe siempre llamar la función getPrivilegios.
    */
	public function adminUsuarios($idModulo)	
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
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = lang("titulo")." - ".$infoModulo[0]['nombreModulo'];
				$salida['centro'] 	   = "admin/adminUsuarios/home";
				$salida['tituloBoton'] = ($_SESSION['project']['info']['idPerfil'] == _PERFIL_ADMIN_VENTAS)?'Nuevo vendedor':'Nuevo usuario';
				$salida['infoModulo']  = $infoModulo[0];
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
	public function getUsuarios()
	{
		$usuarios	     = $this->logicaUsuarios->infoUsuario();
		echo json_encode($usuarios);
	}
	//realiza el proceso de guardar o eliminar usuarios
	public function procesaUsuarios()
	{
		$proceso	     = $this->logicaUsuarios->procesaUsuarios($_POST);
		echo json_encode($proceso);
	}

	//realiza el proceso de guardar o eliminar usuarios
	public function borraUsuario()
	{
		$proceso	     = $this->logicaUsuarios->borraUsuario($_POST);
		echo json_encode($proceso);
	}
	//Genera el usuario y la clave de acceso para el usuario seleccionado
	public function generaDatosAcceso()
	{
		$proceso	     = $this->logicaUsuarios->generaDatosAcceso($_POST);
		echo json_encode($proceso);
	}

	public function cargaPlantillaCreacionUsuarios()
	{
		extract($_POST);
		//listados 

		$wherePerfiles       = ($_SESSION['project']['info']['idPerfil'] == _PERFIL_ADMIN_VENTAS)?array("idPerfil"=>_PERFIL_VENDEDOR):array(); 
		$perfiles  	 	 	 = $this->logica->consultaPerfiles($wherePerfiles); 
		$tiendas			 = $this->logica->consultatiendas();
		//var_dump($conjuntos);


		$salida["selects"]   = array("perfiles"=>$perfiles,
									  "tiendas"=>$tiendas['datos']);
		if($edita == 1)
		{
			$infoUsuario	     = $this->logicaUsuarios->infoUsuario($idUsuario);
			//var_dump($infoUsuario);

			$salida["titulo"] 	 = ($_SESSION['project']['info']['idPerfil'] == _PERFIL_ADMIN_VENTAS)?'Editar nuevo vendedor':'Editar nuevo usuario';
			$salida["datos"]  	 = $infoUsuario['datos'][0];
			$salida["idUsuario"] = $idUsuario;
			$salida["edita"]  	 = $edita;
			$salida["perfil"]  	 = $_SESSION['project']['info']['idPerfil'];
			$salida["idPadre"] 	 = $_SESSION['project']['info']['idPersona'];
			$salida["labelBtn"]  = "EDITAR USUARIO";
		}
		else
		{
			$salida["titulo"] 	 = ($_SESSION['project']['info']['idPerfil'] == _PERFIL_ADMIN_VENTAS)?'Agregar nuevo vendedor':'Agregar nuevo usuario';
			$salida["datos"] 	 = array();
			$salida["edita"]  	 = $edita;
			$salida["idUsuario"] = $idUsuario;
			$salida["perfil"]  	 = $_SESSION['project']['info']['idPerfil'];
			$salida["idPadre"] 	 = $_SESSION['project']['info']['idPersona'];
			$salida["labelBtn"]  = "CREAR USUARIO";
		}
		echo $this->load->view("admin/adminUsuarios/formControl",$salida,true);
	}
}
?>