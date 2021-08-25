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
class Parametrizacion extends CI_Controller 
{
	function __construct() 
    {
        parent::__construct();
        $this->load->model("general/LogicaGeneral", "logica");
        $this->load->model("admin/LogicaAdmin", "logicaAdmin");
       	$this->load->helper('language');
    	$this->lang->load('spanish');
		$this->load->database();
		$this->load->library('grocery_CRUD');
    }
    /*
    * Funcion inicial del módulo de creación de módulos
    * @author Farez Prieto
    * @date 9 de Noviembre de 2016
    * @param $idModulo Este parámetro siempre lo enviará el menú y siempre se deberá recibir en la función del módulo principal, no olvidar esto.
    * Esta función permite inicializar este módulo, dentro de ella siempre se debe declarar la variable de session $_SESSION['moduloVisitado'] con el $idModulo Pasado por parámetro
    * y a continuación siempre se debe llamar la función del helper llamada getPrivilegios, la función está en el archivo helpers/funciones_helper.php
    * Tenga en cuenta que cada llamado ajax que haga a una plantilla gráfica que incluya botones de ver,editar, crear, borrar debe siempre llamar la función getPrivilegios.
    */
	public function parametrizacion($idModulo)	
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
				$salida['centro'] 	   = "admin/parametrizacion/home";
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
	public function tiposDoumento($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_tipos_doc');
						$crud->set_subject('tipo de documento');
						//$crud->set_subject('Office');
						$crud->required_fields('nombreTipoDoc','estado');
						$crud->display_as('nombreTipoDoc','Nombre');
						$crud->set_relation('estado','app_estados','nombreEstado');
						$crud->columns('nombreTipoDoc','sigla','estado');
						$crud->fields('nombreTipoDoc','sigla','estado');
						$crud->unset_texteditor('nombreTipoDoc','sigla');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Tipo de documento";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function sexo($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_sexo');
						$crud->set_subject('sexo');
						//$crud->set_subject('Office');
						$crud->required_fields('nombreSexo','estado');
						$crud->display_as('nombreSexo','Nombre');
						$crud->set_relation('estado','app_estados','nombreEstado');
						$crud->columns('nombreSexo','estado');
						$crud->fields('nombreSexo','estado');
						$crud->unset_texteditor('nombreSexo');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Sexo";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function areasTrabajo($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_areas');
						$crud->set_subject('area de trabajo');
						//$crud->set_subject('Office');
						$crud->required_fields('nombreArea','estado');
						$crud->display_as('nombreArea','Nombre');
						$crud->set_relation('estado','app_estados','nombreEstado');
						$crud->columns('nombreArea','estado');
						$crud->fields('nombreArea','estado');
						$crud->unset_texteditor('nombreArea');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Áreas de trabajo";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function impuestos($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_impuestos');
						$crud->set_subject('Impuestos');
						//$crud->set_subject('Office');
						$crud->required_fields('nombreImpuesto','Nombre Impuesto');
						$crud->display_as('nombreImpuesto','Nombre Impuesto');
						$crud->display_as('valorImpuesto','Valor Impuesto');
						$crud->unset_texteditor('nombreImpuesto');
						$crud->unset_texteditor('valorImpuesto');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Impuestos";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function cargos($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_cargos');
						$crud->set_subject('cargo');
						//$crud->set_subject('Office');
						$crud->required_fields('nombreCargo','estado');
						$crud->display_as('nombreCargo','Nombre');
						$crud->set_relation('estado','app_estados','nombreEstado');
						$crud->columns('nombreCargo','estado');
						$crud->fields('nombreCargo','estado');
						$crud->unset_texteditor('nombreCargo');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Cargos";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function bancos($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_bancos');
						$crud->set_subject('entidad bancaria');
						//$crud->set_subject('Office');
						$crud->required_fields('nombreEntidad','tipoEntidad');
						$crud->display_as('nombreEntidad','Nombre');
						$crud->set_relation('tipoEntidad','app_tipo_entidad','nombreTipoEntidad');
						$crud->columns('nombreEntidad','tipoEntidad');
						$crud->fields('nombreEntidad','tipoEntidad');
						$crud->unset_texteditor('nombreEntidad');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Entidades bancarias";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function tiposCuenta($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_tipo_cuenta');
						$crud->set_subject('tipo de cuenta');
						//$crud->set_subject('Office');
						$crud->required_fields('nombreTipo','tipoEntidad');
						$crud->display_as('nombreTipo','Nombre');
						$crud->columns('nombreTipo');
						$crud->fields('nombreTipo');
						$crud->unset_texteditor('nombreTipo');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Tipos de cuenta";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function eps($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_listado_eps');
						$crud->set_subject('eps');
						//$crud->set_subject('Office');
						$crud->required_fields('des_eps','estado');
						$crud->display_as('des_eps','Nombre');
						$crud->set_relation('estado','app_estados','nombreEstado');
						$crud->columns('des_eps','estado');
						$crud->fields('des_eps','estado');
						$crud->unset_texteditor('des_eps');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Eps";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function afp($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_listado_afp');
						$crud->set_subject('eps');
						//$crud->set_subject('Office');
						$crud->required_fields('des_afp','estado');
						$crud->display_as('des_afp','Nombre');
						$crud->set_relation('estado','app_estados','nombreEstado');
						$crud->columns('des_afp','estado');
						$crud->fields('des_afp','estado');
						$crud->unset_texteditor('des_afp');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Afp";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function fondoCesantias($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_cesantias');
						$crud->set_subject('fondo cesantías');
						//$crud->set_subject('Office');
						$crud->required_fields('nombrefondocesantias','estado');
						$crud->display_as('nombrefondocesantias','Nombre');
						$crud->set_relation('estado','app_estados','nombreEstado');
						$crud->columns('nombrefondocesantias','estado');
						$crud->fields('nombrefondocesantias','estado');
						$crud->unset_texteditor('nombrefondocesantias');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Fondo de cesantías";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function perfiles($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_perfiles');
						$crud->set_subject('perfil');
						//$crud->set_subject('Office');
						$crud->required_fields('nombrePerfil','estado');
						$crud->display_as('nombrePerfil','Nombre');
						$crud->set_relation('estado','app_estados','nombreEstado');
						$crud->columns('idPerfil','nombrePerfil','estado');
						$crud->fields('nombrePerfil','estado');
						$crud->unset_texteditor('nombrePerfil');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Perfiles";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function tipoLimon($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_tipos_producto');
						$crud->set_subject('tipo de limón');
						//$crud->set_subject('Office');
						$crud->required_fields('nombreTipoProducto','nombreLargo','estado');
						$crud->display_as('nombreTipoProducto','Nombre');
						$crud->set_relation('estado','app_estados','nombreEstado');
						$crud->columns('nombreTipoProducto','nombreLargo','estado');
						$crud->fields('nombreTipoProducto','nombreLargo','estado');
						$crud->unset_texteditor('nombreTipoProducto');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Tipos de limón";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function tipoEstiba($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_tipo_estibas');
						$crud->set_subject('tipo de estiba');
						$crud->required_fields('nombreEstiba','estado');
						$crud->display_as('nombreEstiba','Nombre');
						$crud->set_relation('estado','app_estados','nombreEstado');
						$crud->set_relation('eliminado','app_eliminado','nombreTipoEliminado');
						$crud->columns('nombreEstiba','estado','peso','eliminado');
						$crud->fields('nombreEstiba','estado','peso');
						$crud->unset_texteditor('nombreEstiba');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Tipos de estiba";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function tipoContrato($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_tipo_contratos');
						$crud->set_subject('tipo de contrato');
						//$crud->set_subject('Office');
						$crud->required_fields('nombreTipoContrato','estado');
						$crud->display_as('nombreTipoContrato','Nombre');
						$crud->set_relation('estado','app_estados','nombreEstado');
						$crud->columns('nombreTipoContrato','estado');
						$crud->fields('nombreTipoContrato','estado');
						$crud->unset_texteditor('nombreTipoContrato');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Tipos de contrato";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function constantes($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_variablesglobales');
						$crud->set_subject('variable');
						//$crud->set_subject('Office');
						$crud->required_fields('variable','valor');
						$crud->display_as('variable','Nombre');
						$crud->columns('variable','valor');
						$crud->fields('variable','valor');
						$crud->unset_texteditor('variable','valor');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Variables globales";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function categorias($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_productos');
						$crud->set_subject('Categorías');
						//$crud->set_subject('Office');
						$crud->columns('idEstado','nombreProducto');
						$crud->required_fields('nombreProducto','descProducto');
						$crud->display_as('nombreProducto','Producto');
						$crud->set_relation('idEstado','app_estados','nombreEstado');

						//$crud->fields('nombreProducto','valorKilo');
						$crud->unset_texteditor('nombreProducto','descProducto');
						$crud->set_field_upload('foto','assets/uploads/files');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Categorías";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function subcategorias($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_subproductos');
						$crud->set_subject('Sub categorías');
						//$crud->set_subject('Office');
						$crud->columns('idProducto','nombreSubcategoria');
						$crud->required_fields('nombreSubcategoria','idEstado','idCategoria');
						$crud->display_as('nombreSubcategoria','Nombre subcategoría');
						$crud->display_as('nombreProducto','Categoria');
						$crud->display_as('idProducto','Categoria');
						$crud->display_as('idEstado','Estado');
						$crud->set_relation('idEstado','app_estados','nombreEstado');
						$crud->set_relation('idProducto','app_productos','nombreProducto');

						//$crud->fields('nombreProducto','valorKilo');
						$crud->unset_texteditor('nombreSubcategoria','descripcion');
						$crud->set_field_upload('foto','assets/uploads/files');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Sub categorías";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function estadosPedido($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_estado_pedido');
						$crud->set_subject('Estado Pedido');
						//$crud->set_subject('Office');
						$crud->required_fields('nombreEstadoPedido','label');
						$crud->display_as('nombreEstadoPedido','label');
						$crud->columns('nombreEstadoPedido','label');
						$crud->fields('nombreEstadoPedido','label');
						$crud->unset_texteditor('nombreEstadoPedido','label');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Productos venta";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
	public function ciudadesVentas($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_ciudades_venta');
						$crud->set_subject('ciudad');
						//$crud->set_subject('Office');
						$crud->required_fields('nombreCiudad','valorEnvio');
						$crud->display_as('idCiudad','nombreCiudad','valorEnvio');
						$crud->columns('nombreCiudad','valorEnvio');
						$crud->fields('nombreCiudad','valorEnvio');
						$crud->unset_texteditor('nombreCiudad','valorEnvio');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Ciudades venta";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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

	public function bannersApp($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_banners');
						$crud->set_subject('Banners');
						//$crud->set_subject('Office');

						$crud->set_field_upload('fotoBanner','assets/uploads/files');
						$crud->required_fields('tituloBanner','fotoBanner');
						$crud->set_relation('idEstado','app_estados','nombreEstado');
						$crud->set_relation('idPresentacion','app_presentacion_producto','nombrePresentacion');
						$crud->display_as('fotoBanner','Banner');
						$crud->display_as('tituloBanner','Nombre del banner');
						$crud->display_as('tipoLink','Tipo de banner');
						$crud->display_as('idPresentacion','Producto a redireccionar');
						$crud->display_as('linkBanner','Url para redireccionar<br><small>Agregar el http:// o https://</small>');
						$crud->columns('tituloBanner','fotoBanner','tipoLink');
						$crud->unset_texteditor('linkBanner');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Banners";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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


	public function presentacionesProducto($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_presentacion_producto');
					    $crud->set_subject('Producto');
						
						$crud->columns('idProducto','idSubcategoria','nombrePresentacion');
						
					    $crud->display_as('idProducto','Categoria');
					    $crud->display_as('idSubcategoria','Subcategoria');
					    $crud->display_as('nombrePresentacion','Nombre Producto');
					    $crud->display_as('valorPresentacion','Valor de venta');
					    $crud->display_as('descripcionPres','Descripción del producto <br><span class="small">Detalle el producto en un breve texto</span>');
					    $crud->display_as('valorAntes','Precio antes  <br><span class="small">Llenar cuando el producto cambie de precio</span>');
					    $crud->display_as('fotoPresentacion','Foto Principal<br><span class="small">Miniatura producto 500 x 500 PX</span>');
					    $crud->display_as('foto2','Foto 2 <br><span class="small">Foto de producto 800 x 600 PX</span>');
					    $crud->display_as('foto3','Foto 3 <br><span class="small">Foto de producto 800 x 600 PX</span>');
					    $crud->display_as('foto4','Foto 4 <br><span class="small">Foto de producto 800 x 600 PX</span>');
					    $crud->display_as('foto5','Foto 5 <br><span class="small">Foto de producto 800 x 600 PX</span>');
						
						$crud->required_fields('nombrePresentacion','valorPresentacion','fotoPresentacion','idProducto','idSubcategoria');
						
					 	$crud->set_field_upload('fotoPresentacion','assets/uploads/files');
					 	$crud->set_field_upload('foto2','assets/uploads/files');
					 	$crud->set_field_upload('foto3','assets/uploads/files');
					 	$crud->set_field_upload('foto4','assets/uploads/files');
					 	$crud->set_field_upload('foto5','assets/uploads/files');
					    $crud->set_relation('idProducto','app_productos','nombreProducto');
						$crud->set_relation('idSubcategoria','app_subproductos','nombreSubcategoria');
						
						$crud->unset_texteditor('descripcionPres');
						$crud->unset_clone();
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Cat&aacute;logo de productos";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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

	public function vendedorasConjunto($idModulo)
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_rel_conjunto_vendedora');
						$crud->set_subject('Relacion conjunto');

						//$crud->set_subject('Office');
						$crud->set_relation('idConjunto','app_conjuntos','nombreConjunto');
						$crud->set_relation('idPersona','app_personas','{nombre} {apellido}');

						//$crud->columns('idPersona','nombre','apellido','nombreconjunto');
						$crud->display_as('Nombres','Conjunto residencial');

						//$crud->fields('idConjunto','idPersona',);

						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Vendedoras conjunto";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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

	public function conjuntos($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_conjuntos');
						$crud->set_subject('conjunto');
						//$crud->set_subject('Office');
						$crud->set_relation('idCiudad','app_ciudades_venta','nombreCiudad');
						$crud->required_fields('nombreConjunto','direccionConjunto','idCiudad');
						$crud->display_as('idConjunto','nombreConjunto','direccionConjunto','cantidad Aptos');
						$crud->columns('nombreConjunto','idCiudad','direccionConjunto','cantAptos');

						$crud->fields('idCiudad','nombreConjunto','direccionConjunto','latConjunto','lonConjunto','telefonoConjunto','cantAptos');
						$crud->unset_texteditor('nombreConjunto','direccionConjunto','latConjunto','lonConjunto','telefonoConjunto','cantAptos');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Conjuntos residenciales";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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

	

	public function tiendas($idModulo)	
	{
		//ini_set("display_errors",'1');
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
					try{
						$crud = new grocery_CRUD();
						$crud->set_theme('datatables');
						$crud->set_table('app_tiendas');
						$crud->set_subject('Tiendas');
						//$crud->set_subject('Office');

						$crud->set_field_upload('bannerTienda','assets/uploads/files');
						$crud->set_field_upload('logoTienda','assets/uploads/files');
						$crud->set_field_upload('faviconTienda','assets/uploads/files');
						$crud->required_fields('nombreTienda','direccionTienda','dominioTienda','correoTienda','celularTienda','fechaIngreso','fechaCaduca');
						$crud->set_relation('idEstado','app_estados','nombreEstado');
						$crud->set_relation('idTipoTienda','app_tipo_tienda','nombreTipoTienda');
						$crud->display_as('bannerTienda','Banner');
						$crud->display_as('tituloTienda','Nombre de la tienda');
						$crud->display_as('tipoTienda','Tipo de la tienda');
						$crud->display_as('direccionTienda','Dirección física de la tienda');
						$crud->display_as('dominioTienda','Dominio de la tienda');
						$crud->display_as('correoTienda','Correo electrónico');
						$crud->display_as('celularTienda','Celular de contacto');
						$crud->display_as('urlFacebook','Página en Facebook');
						$crud->display_as('urlTwitter','Página en Twitter');
						$crud->display_as('urlInstagram','Página en Instagram');
						$crud->display_as('urlLinkedin','Página en Linkedin');
						$crud->display_as('logoTienda','Logotipo <small>500 X 500px</small>');
						$crud->display_as('faviconTienda','Ícono de la tienda <small>200px X 200px</small>');
						$crud->display_as('nombreTienda','Nombre de la tienda');
						$crud->columns('nombreTienda','dominioTienda');
						$crud->unset_texteditor('direccionTienda','FCMkey','nombreTienda','dominioTienda','correoTienda','celularTienda','urlFacebook','subdominio','urlTwitter','urlInstagram','urlLinkedin','faviconTienda');
						$crud->unset_clone();
						
						$output = $crud->render();
						
					}catch(Exception $e){
						show_error($e->getMessage().' --- '.$e->getTraceAsString());
					}
				//info Módulo
				$infoModulo	      	   = $this->logica->infoModulo($idModulo);
				$opc 				   = "home";
				$salida['titulo']      = "Tiendas";
				$salida['output'] 	   = $output;
				$salida['centro'] 	   = 'admin/centroEstandarPar';
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
}
?>