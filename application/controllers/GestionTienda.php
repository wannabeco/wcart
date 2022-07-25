<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class GestionTienda extends CI_Controller 
{
	function __construct() 
    {
        parent::__construct();
        $this->load->model("general/LogicaGeneral", "logica");
        $this->load->model("home/LogicaHome", "logicaHome");
        $this->load->model("tienda/LogicaTienda", "logicaTienda");
       	$this->load->helper('language');//mantener siempre.
    }
	public function categorias($idModulo)	
	{
		//valido que haya una sesión de usuario, si no existe siempre lo enviaré al login
		if(validaIngreso())
		{
			$estadoTienda = estadoTiendaAdmin();
			if($estadoTienda['mostrar'] == 1)
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
					$salida['centro'] 	   = "home/edicionTienda/categorias/home";
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
				$opc = "home";
				$salida['titulo'] 	  	= "Licencia expirada";
				$salida['dataLicencia'] = $estadoTienda;
				$salida['centro'] 		= "app/homeCaducidad";
				$this->load->view("app/index",$salida);
			}
//			
		}
		else
		{
			header('Location:'.base_url()."login");
		}
	}

	public function getCategoriasAdmin()
	{
		if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
		{
			$where['idTienda']   = $_SESSION['project']['info']['idTienda'];
		}
		$where['idEstado']   = 1;
		$categorias	     = $this->logicaHome->getCategorias($where);
		echo json_encode($categorias);
	}
	public function procesaCategoria()
	{
		$_POST['idTienda']   = $_SESSION['project']['info']['idTienda'];
		$categorias	     = $this->logicaHome->procesaCategoria($_POST);
		echo json_encode($categorias);
	}
	public function eliminaCategoria()
	{
		$_POST['idTienda']   = $_SESSION['project']['info']['idTienda'];
		$categorias	     = $this->logicaHome->eliminaCategoria($_POST);
		echo json_encode($categorias);
	}


	public function plantillaCreaCategoria()
	{
		extract($_POST);
		//listados 
		//$tiposDoc		  	 = $this->logica->consultatiposDoc(); 
		//$sexo		  	 	 = $this->logica->consultaSexo(); 
		//$perfiles  	 	 = $this->logica->consultaPerfiles(); 
		$salida["selects"]   = array();
		if($edita == 1)
		{	
			//busca la info de la categoria
			$infoCategoria	     = $this->logicaHome->infoCategoria($idProducto);
			$salida["titulo"] 	 = lang("text26");
			$salida["datos"]  	 = $infoCategoria['datos'][0];
			$salida["idProducto"] = $idProducto;
			$salida["edita"]  	 = $edita;
			$salida["labelBtn"]  = lang("btn_guardar");
		}
		else
		{
			$salida["titulo"] 	 = lang("text25");
			$salida["datos"] 	 = array();
			$salida["edita"]  	 = $edita;
			$salida["idProducto"] = $idProducto;
			$salida["labelBtn"]  = lang("reg_btn_crea");
		}
		echo $this->load->view("home/edicionTienda/categorias/formControl",$salida,true);
	}

	//subcategorias
	public function subcategorias($idModulo)	
	{
		//valido que haya una sesión de usuario, si no existe siempre lo enviaré al login
		if(validaIngreso())
		{

			$estadoTienda = estadoTiendaAdmin();
			if($estadoTienda['mostrar'] == 1)
			{
				//var_dump($_SESSION['project']['info']);die();
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
					$salida['centro'] 	   = "home/edicionTienda/subcategorias/home";
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
				$opc = "home";
				$salida['titulo'] 	  	= "Licencia expirada";
				$salida['dataLicencia'] = $estadoTienda;
				$salida['centro'] 		= "app/homeCaducidad";
				$this->load->view("app/index",$salida);
			}
		}
		else
		{
			header('Location:'.base_url()."login");
		}
	}
	//productos
	public function productos($idModulo)	
	{
		//valido que haya una sesión de usuario, si no existe siempre lo enviaré al login
		if(validaIngreso())
		{

			$estadoTienda = estadoTiendaAdmin();
			if($estadoTienda['mostrar'] == 1)
			{
				//var_dump($_SESSION['project']['info']);die();
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
					$salida['centro'] 	   = "home/edicionTienda/productos/home";
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
				$opc = "home";
				$salida['titulo'] 	  	= "Licencia expirada";
				$salida['dataLicencia'] = $estadoTienda;
				$salida['centro'] 		= "app/homeCaducidad";
				$this->load->view("app/index",$salida);
			}
		}
		else
		{
			header('Location:'.base_url()."login");
		}
	}
	//funciones para la creción y edición de las subcategorias
	public function getSubCategoriasAdmin()
	{
		if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
		{
			$where['s.idTienda']   = $_SESSION['project']['info']['idTienda'];
		}
		$where['s.idEstado']   = 1;
		$subCategorias	     = $this->logicaHome->getSubcategoriasAnidada($where);
		echo json_encode($subCategorias);
	}

	public function plantillaCreaSubCategoria()
	{
		extract($_POST);
		
		if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
		{
			$where['idTienda']   = $_SESSION['project']['info']['idTienda'];
		}
		$where['idEstado']   = 1;
		$categorias	     = $this->logicaHome->getCategorias($where); 

		$salida["selects"]   = array("categorias"=>$categorias['datos']);
		if($edita == 1)
		{	
			//busca la info de la categoria
			$infoSubCategoria	     = $this->logicaHome->getSubcategorias(array("idSubcategoria"=>$idSubcategoria));
			$salida["titulo"] 	 = "Editar el Subcategoría ";
			$salida["datos"]  	 = $infoSubCategoria['datos'][0];
			$salida["idProducto"] = $idSubcategoria;
			$salida["edita"]  	 = $edita;
			$salida["labelBtn"]  = "EDITAR SUBCATEGORÍA";
		}
		else
		{
			$salida["titulo"] 	 = "Agregar nueva Subcategoría";
			$salida["datos"] 	 = array();
			$salida["edita"]  	 = $edita;
			$salida["idProducto"] = $idSubcategoria;
			$salida["labelBtn"]  = "CREAR SUBCATEGORÍA";
		}
		echo $this->load->view("home/edicionTienda/subcategorias/formControl",$salida,true);
	}
	public function procesaSubCategoria()
	{
		$_POST['idTienda']   = $_SESSION['project']['info']['idTienda'];
		$resultado	     = $this->logicaHome->procesaSubCategoria($_POST);
		echo json_encode($resultado);
	}
	public function eliminaSubCategoria()
	{
		$_POST['idTienda']   = $_SESSION['project']['info']['idTienda'];
		$resultado	     = $this->logicaHome->eliminaSubCategoria($_POST);
		echo json_encode($resultado);
	}
	//todo el tema de los productos
	public function getProductosAdmin()
	{
		if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
		{
			$where['p.idTienda']   = $_SESSION['project']['info']['idTienda'];
		}
		$where['p.idEstado']   = 1;
		$categorias	     = $this->logicaHome->getProductosAnidados($where);
		//voy aca.
		//var_dump($categorias);die();
		echo json_encode($categorias);
	}

	public function plantillaCreaSubProductos()
	{
		extract($_POST);
		
		if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
		{
			$where['idTienda']   = $_SESSION['project']['info']['idTienda'];
		}
		$where['idEstado']   = 1;
		$categorias	     = $this->logicaHome->getCategorias($where); 

		$salida["selects"]   = array("categorias"=>$categorias['datos']);
		if($edita == 1)
		{	
			//busca la info de la categoria
			$infoProducto	       		= $this->logicaHome->infoProducto(array("idPresentacion"=>$idPresentacion));
			$salida["titulo"] 	        = lang("text18");
			$salida["datos"]  	        = $infoProducto['datos'][0];
			$salida["idPresentacion"]   = $idPresentacion;
			$salida["persistencia"]  	= 0;
			$salida["edita"]  	 		= $edita;
			$salida["labelBtn"]  		= lang("text18");
			$vista = $this->load->view("home/edicionTienda/productos/formControl",$salida,true);
			$respuesta = array("json"=>$infoProducto['datos'][0],"html"=>$vista);
		}
		else
		{
			$salida["titulo"] 	 = lang("text19");
			$salida["datos"] 	 = array();
			$salida["edita"]  	 = $edita;
			$salida["persistencia"]  = 0;
			$salida["idPresentacion"] = $idPresentacion;
			$salida["labelBtn"]  = lang("text19");
			$vista = $this->load->view("home/edicionTienda/productos/formControl",$salida,true);
			$respuesta = array("json"=>array(),"html"=>$vista);
		}
		echo json_encode($respuesta);
	}
	public function getSubcategoriasSel()
	{
		extract($_POST);
		if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
		{
			$where['idTienda']   = $_SESSION['project']['info']['idTienda'];
		}
		$where['idProducto']   = $categoria;
		$where['idEstado']     = 1;

		$listaSubcat = $this->logicaHome->getSubcategorias($where);
		$salida["data"] 	 	= $listaSubcat['datos'];
		$salida["persistencia"] = $persistencia;
		echo $this->load->view("home/edicionTienda/productos/selectSubcat",$salida,true);
	}

	public function procesaProducto()
	{
		if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
		{
			$where['idTienda']   = $_SESSION['project']['info']['idTienda'];
			$idTienda 			 = $_SESSION['project']['info']['idTienda'];
		}
		extract($_POST);
		if(isset($_FILES) && $_FILES['fotoPresentacion']['name'] != "")
		{
			@mkdir('assets/uploads/files/'.$idTienda,0777);

			$config['upload_path'] 	 = 'assets/uploads/files/'.$idTienda.'/';
	        $config['allowed_types'] = 'gif|jpg|png';
	        $config['max_size'] 	 = 20000048;
            // $config['max_width']     = 800;
            // $config['max_height']    = 800;
	        $config['encrypt_name']  = TRUE;
	        $file_element_name 		 = 'fotoPresentacion';
	        $this->load->library('upload', $config);

	        if(!$this->upload->do_upload($file_element_name))
	        {
	            $status = 'error';
	            $msg = $this->upload->display_errors();
	            //var_dump($msg);
	            $salida = array("mensaje"=>"No se ha podido realizar la carga de la foto de perfil, probablemente la falla sea porque ha superado el tamaño permitido de 2 MB ó no tenga el formato que se necesita: PNG, JPG ó GIF, supere. ".$msg,
            				"continuar"=>0,
            				"datos"=>array());
	        }
	        else
	        {
	            $data 					= $this->upload->data();
	            $_POST['fotoPresentacion']	=	$data['file_name'];
	            $_POST['idTienda']			=	$idTienda;
	            //procedo a actualizar la información del usuario
	            $salida 	 	=  $this->logicaHome->procesaProductos($_POST);        	
	        }
	    }
	    else
	    {
            $_POST['fotoPresentacion']	=	$_POST['fotoActual'];
            $_POST['idTienda']			=	$idTienda;
            //procedo a actualizar la información del usuario
            $salida 	 	=  $this->logicaHome->procesaProductos($_POST);   
	    }
        echo json_encode($salida);
	}


	public function procesaProductoNuevo()
	{
		if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
		{
			$_POST['idTienda']   = $_SESSION['project']['info']['idTienda'];
		}
        //procedo a actualizar la información del usuario
        $salida 	 	=  $this->logicaHome->procesaProductos($_POST);   
        echo json_encode($salida);
	}

	public function plantillaVariaciones()
	{
		extract($_POST);
		if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
		{
			$where['idTienda']   = $_SESSION['project']['info']['idTienda'];
		}
		$where['idEstado']   	   = 1;
		$where['idPresentacion']   = $idPresentacion;
		$edita = 0;
		//busca la info de la categoria
		$infoProducto	       		= $this->logicaHome->infoProducto($where);
		$variaciones	       		= $this->logicaHome->getVariaciones($where);
		$salida["titulo"] 	        = lang("text20");
		$salida["infoProducto"]     = $infoProducto['datos'][0];
		$salida["variaciones"]  	= $variaciones['datos'];
		$salida["idPresentacion"]   = $idPresentacion;
		$salida["edita"]  	 		= $edita;
		$salida["labelBtn"]  		= lang("btn_guardar");
		echo $this->load->view("home/edicionTienda/productos/formVariaciones",$salida,true);

	}
	public function procesaVariaciones()
	{
		$_POST['idTienda']   = $_SESSION['project']['info']['idTienda'];
		$resultado	     = $this->logicaHome->procesaVariaciones($_POST);
		echo json_encode($resultado);
	}
	public function eliminaProducto()
	{
		$_POST['idTienda']   = $_SESSION['project']['info']['idTienda'];
		$proceso	     = $this->logicaHome->eliminaProducto($_POST);
		echo json_encode($proceso);
	}
	public function eliminaVariacion()
	{
		$_POST['idTienda']   = $_SESSION['project']['info']['idTienda'];
		$proceso	     = $this->logicaHome->eliminaVariacion($_POST);
		echo json_encode($proceso);
	}
	public function ordenaCategorias()
	{
		$_POST['idTienda']   = $_SESSION['project']['info']['idTienda'];
		$proceso	     = $this->logicaHome->ordenaCategorias($_POST);
		echo json_encode($proceso);
	}

	//info de la tienda
	public function informacionTienda()	
	{
		//valido que haya una sesión de usuario, si no existe siempre lo enviaré al login
		if(validaIngreso())
		{
			$tiposTienda		 = $this->logicaTienda->getTiposTienda(array("eliminado"=>0));  
			$infoTienda	     = $this->logicaTienda->getInfoTienda(array("idTienda"=>$_SESSION['project']['info']['idTienda']));
			$salida["selects"]   = array("tiposTienda"=>$tiposTienda['datos']);

			$opc 				   = "home";
			$salida['titulo']      = lang("titulo")." - Información de la tienda";
			$salida['centro'] 	   = "home/edicionTienda/infoTienda/home";
			$salida['datos']	   = $infoTienda['datos'][0];
			$this->load->view("app/index",$salida);
		}
		else
		{
			header('Location:'.base_url()."login");
		}
	}

	public function cargaFoto()
	{
		if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
		{
			$idTienda 			 = $_SESSION['project']['info']['idTienda'];
		}

		extract($_POST);
		
		if(isset($_FILES) && $_FILES[$caja]['name'] != "")
		{
			@mkdir('assets/uploads/files/'.$idTienda,0777);

			$config['upload_path'] 	 = 'assets/uploads/files/'.$idTienda.'/';
	        $config['allowed_types'] = 'gif|jpg|png|webp';
	        $config['max_size'] 	 = 20000048;
            // $config['max_width']     = 800;
            // $config['max_height']    = 800;
	        $config['encrypt_name']  = TRUE;
	        $file_element_name 		 = $caja;
	        $this->load->library('upload', $config);

	        if(!$this->upload->do_upload($file_element_name))//si no carga
	        {
				$salida = array("mensaje"=>lang("text19.6"),
								"continuar"=>0,
								"urlCompleta"=>"",
								"foto"=>"",
								"datos"=>"");  
	        }
	        else //si carga
	        {
				
	            $data 					= $this->upload->data();
				//inserto la foto en la tabla de fotos temporales porque es probable que el usuario se arrepienta y no termine de crar el producto, entonces la foto quedara en el server ocupando espacio
				//al ponerla en esta tabla se puede correr un cron revisando que fotos en esta tablano fueron amarradas al producto y borrarlas.
				$fotoTemp		 = $this->logicaTienda->insertaFotoTemp(array("foto"=>$data['file_name'],"rutaFoto"=>"assets/uploads/files/".$idTienda."/".$data['file_name']));  

	            $salida = array("mensaje"=>lang("text19.7"),
            				    "continuar"=>1,
								"urlCompleta"=>base_url()."assets/uploads/files/".$idTienda."/".$data['file_name'],
								"foto"=>$data['file_name'],
            				    "datos"=>$data['file_name']);  	
	        }
	    }
	    else
	    {
			$salida = array("mensaje"=>lang("text19.8"),
							"continuar"=>0,
							"urlCompleta"=>"",
							"foto"=>"",
							"datos"=>""); 

	    }
        echo json_encode($salida);
	}
	//comentarios de los productos
	public function cargaPlantillaComentarios()
	{
		extract($_POST);
		
		if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
		{
			$where['idTienda']   = $_SESSION['project']['info']['idTienda'];
		}
		$where['idEstado']   = 1;
		$categorias	     = $this->logicaHome->getCategorias($where); 

		$salida["selects"]   = array("categorias"=>$categorias['datos']);
		$idComentario= "";
		if($ver == 1)
		{	
			//busca la info de la categoria
			$infoProducto	       		= $this->logicaHome->infoProducto(array("idPresentacion"=>$idPresentacion));
			$infoComentarios			= $this->logicaTienda->infoComentarios(array('com.idPresentacion'=>$idPresentacion, 'com.estado' => '1', 'com.eliminado' => '0'));
			//var_dump($infoComentarios);
			$salida["titulo"] 	        = lang("text18");
			$salida["datos"]  	        = $infoProducto['datos'][0];
			$salida["idPresentacion"]   = $idPresentacion;
			$salida["infoComentarios"]	= $infoComentarios;
			$salida["persistencia"]  	= 0;
			$salida["ver"]  	 		= $ver;
			$salida["labelBtn"]  		= lang("text18");
			$vista = $this->load->view("home/edicionTienda/productos/comentarios",$salida,true);
			$respuesta = array("json"=>$infoProducto['datos'][0],"html"=>$vista);
		}
		echo json_encode($respuesta);
	}
	//procesa comentarios
	public function infoComentarios()
	{
		if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
		{
			$_POST['id']   = $_SESSION['project']['info']['idTienda'];
		}
        $salida 	 	=  $this->logicaHome->infoComentarios($_POST);   
        echo json_encode($salida);
	}
	//elimina comentario
	public function eliminarComentario()
    {
		extract($_POST);
		$dataActualiza['eliminado']     	= 1;
		$where['idComentario']        		= $idComentario;
		$votantes							= $votantes - 1;
		$puntos								= $puntos - $calificacion;
		$resultado = $this->logicaTienda->eliminarComentario($where,$dataActualiza,$idPresentacion,$votantes,$puntos);
			if($resultado > 0)
			{		
				$salida = array("mensaje"=>"El comentario se la eliminado de manera corecta",
								"datos"=>$resultado,
								"continuar"=>1);
			}
			else
			{
				$salida = array("mensaje"=>"No se ha podido eliminar el comentario, intente de nuevo más tarde",
								"datos"=>array(),
								"continuar"=>0);
			}
			echo json_encode($salida);
    }
	//actualizar productos
	public function cargaPlantillaActualizaProductos()
	{
		extract($_POST);
		if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
		{
			$where['idTienda']   = $_SESSION['project']['info']['idTienda'];
		}
		$where['idEstado']   	= 1;
		$categorias	     		= $this->logicaHome->getCategorias($where); 
		$salida["selects"]   	= array("categorias"=>$categorias['datos']);
		$idComentario= "";
		//var_dump($ver);die();
		if($ver == '1')
		{	
			//busca la info de la categoria
			$infoProducto	       		= $this->logicaHome->infoProducto($where);
			//$infoComentarios			= $this->logicaTienda->actualizaProductos($where);
			$salida["titulo"] 	        = lang("text18");
			$salida["datos"]  	        = $infoProducto['datos'][0];
			$salida["idPresentacion"]   = $idPresentacion;
			//$salida["infoComentarios"]	= $infoComentarios;
			$salida["persistencia"]  	= 0;
			$salida["ver"]  	 		= $ver;
			$salida["labelBtn"]  		= lang("text18");
			$vista = $this->load->view("home/edicionTienda/productos/actualizaProductos",$salida,true);
			$respuesta = array("json"=>$infoProducto['datos'][0],"html"=>$vista);
		}
		echo json_encode($respuesta);
	}
	public function procesaDatacsv(){
		extract($_POST);
		//var_dump($_FILES);die();
		@mkdir('assets/uploads/actualizacion/');
		$salida=""; 
		$error ="";
		$config['upload_path'] = 'assets/uploads/actualizacion/';
		//var_dump($config);die();
        $config['allowed_types'] = 'csv';
        $config['max_size'] 	 = '100000';
        $this->load->library('upload', $config);
    	$this->upload->initialize($config);
		//var_dump($config);die();
    	if(!$this->upload->do_upload('csv_file')){
			$error_sistema = trim(strip_tags($this->upload->display_errors()));
			$salida = array("mensaje"=>$error_sistema,
                            "continuar"=>0,
                            "datos"=>"");
		}
    	else{		
			$data 							= $this->upload->data();
	        //leer archivo csv, permisos de escritura y array para guardar
			$file = 'assets/uploads/actualizacion/'.$data['file_name'];
			$openfile = fopen($file, "r");
			$cabecera = fgetcsv($openfile, 0,',');
			//se limpia cabecera
			$cabeceralimpia = explode(';',explode('\n',$cabecera[0])[0]);
			$ValidacionCabecera = array('codigoProducto','nombrePresentacion','marca','descripcionpres','nuevo','descuento','agotado','valorPresentacion','valorAntes');
			$errorcampos = 0;
			$erroresdeCampos= "";
			//recorre la cabecera y hace comparacion con validacion de cabecera
			foreach($cabeceralimpia as $infcabecera){
				if(!in_array($infcabecera, $ValidacionCabecera)){
					$errorcampos++;
					$erroresdeCampos.=$infcabecera.", ";
				}
			}
			if($errorcampos == 0){
				$arreglodata = array();
				while (($line = fgetcsv($openfile, 0,';')) !== FALSE) {
						array_push($arreglodata,$line);
				}
				fclose($openfile);
				$salida2 = array();
				//se recorre el arreglo
				foreach($arreglodata as $infoProductos){
					for($i=0; $i<count($cabeceralimpia);$i++){
						$cadena = str_replace('','',trim($infoProductos[$i]));
						$final[$cabeceralimpia[$i]]= $cadena;					
					}
					array_push($salida2,$final);
				}
				$conProductosRegistrados = 0;
				$conProductosNoRegistrados = 0;
				$noActualizados = array();
				//recorrido de registros.
				foreach($salida2 as $newData){
				$where['codigoProducto'] = $newData['codigoProducto'];
				$where['idTienda']   = $_SESSION['project']['info']['idTienda'];
				$newData2 = $newData;
				unset($newData['codigoProducto']);
				$proceso 	 	=  $this->logicaTienda->actualizaProductos($where,$newData);//guardado de registros
					if($proceso == '1'){
						$conProductosRegistrados++;
					}
					else{
						$conProductosNoRegistrados++;
						array_push($noActualizados,$newData2);
					}
				}
				//se inicia session, para hacer ejecuion de excel
				if(count($noActualizados)>0){
					$_SESSION['noActualizados'] = $noActualizados;
				}
				$salida = array("mensaje"=>"Se actualizaron ".$conProductosRegistrados. " productos, no se actualizaron ".$conProductosNoRegistrados." productos",
							"continuar"=>1,
							"datos"=>$noActualizados);			
			} 
			else{
				$salida = array("mensaje"=>"El formato de excel esta erroneo, los siguientes campos no se encontraron en el archivo: ".$erroresdeCampos." por favor verifique",
							"continuar"=>0,
							"datos"=>"");
			}
			
		echo json_encode($salida);
	}
}//exportar excel de datos no actualizados
public function datosexcel(){
	//var_dump($_SESSION['noActualizados']);die();
		$table           = "";
		$table .= "<table>";
			$table .= "<tr>";
				$table .= "<td>codigoProducto</td>";
				$table .= "<td>nombrePresentacion</td>";
				$table .= "<td>marca</td>";
				$table .= "<td>descripcionpres</td>";
				$table .= "<td>nuevo</td>";
				$table .= "<td>descuento</td>";
				$table .= "<td>agotado</td>";
				$table .= "<td>valorPresentacion</td>";
				$table .= "<td>valorAntes</td>";
			$table .= "</tr>";
			foreach ($_SESSION['noActualizados']  as $u){
			$table .= "<tr>";
				$table .= "<td>".$u['codigoProducto']."</td>";
				$table .= "<td>".$u['nombrePresentacion']."</td>";
				$table .= "<td>".$u['marca']."</td>";
				$table .= "<td>".$u['descripcionpres']."</td>";
				$table .= "<td>".$u['nuevo']."</td>";
				$table .= "<td>".$u['descuento']."</td>";
				$table .= "<td>".$u['agotado']."</td>";
				$table .= "<td>".$u['valorPresentacion']."</td>";
				$table .= "<td>".$u['valorAntes']."</td>";
			$table .= "</tr>";
			}
		$table .= "</table>";
		unset($_SESSION['noActualizados']);//se cierra sesion de la ejecucion de excel
		header("Pragma: public");
		header("Expires: 0");
		$filename = "registros_no_actualizados.xls";
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$filename");
		header("Pragma: no-cache");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		echo $table;
		die();
}
// carga de plantilla productos masivos
	public function cargaPlantillaProductosMasivos()
	{
		extract($_POST);
		if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
		{
			$where['idTienda']   = $_SESSION['project']['info']['idTienda'];
		}
		$where['idEstado']   	= 1;
		$categorias	     		= $this->logicaHome->getCategorias($where); 
		$salida["selects"]   	= array("categorias"=>$categorias['datos']);
		$idComentario= "";
		//var_dump($ver);die();
		if($ver == '1')
		{	
			//busca la info de la categoria
			$infoProducto	       		= $this->logicaHome->infoProducto($where);
			$salida["titulo"] 	        = lang("text18");
			$salida["datos"]  	        = $infoProducto['datos'][0];
			$salida["idPresentacion"]   = $idPresentacion;
			$salida["persistencia"]  	= 0;
			$salida["ver"]  	 		= $ver;
			$salida["labelBtn"]  		= lang("text18");
			$vista = $this->load->view("home/edicionTienda/productos/ProductosMasivos",$salida,true);
			$respuesta = array("json"=>$infoProducto['datos'][0],"html"=>$vista);
		}
		echo json_encode($respuesta);
	}
	//productos masivos
	public function procesaProductosMasivoscsv(){
		extract($_POST);
		//var_dump($_POST);die();
		@mkdir('assets/uploads/crearProductos/');
		$salida=""; 
		$error ="";
		$config['upload_path'] = 'assets/uploads/crearProductos/';
		//var_dump($config);die();
        $config['allowed_types'] = 'csv';
        $config['max_size'] 	 = '100000';
        $this->load->library('upload', $config);
    	$this->upload->initialize($config);
		//var_dump($config);die();
    	if(!$this->upload->do_upload('csv_file')){
			$error_sistema = trim(strip_tags($this->upload->display_errors()));
			$salida = array("mensaje"=>$error_sistema,
                            "continuar"=>0,
                            "datos"=>"");
		}
    	else{		
			$data 							= $this->upload->data();
	        //leer archivo csv, permisos de escritura y array para guardar
			$file = 'assets/uploads/crearProductos/'.$data['file_name'];
			$openfile = fopen($file, "r");
			$cabecera = fgetcsv($openfile, 0,';');
			//se limpia cabecera
			$cabeceralimpia = $cabecera;
			$ValidacionCabecera = array('codigoProducto','nombrePresentacion','marca','fotoPresentacion','foto2','foto3','foto4','foto5','descripcionpres','valorPresentacion','valorAntes','nuevo','descuento','agotado');
			$errorcampos = 0;
			$erroresdeCampos= "";
			//recorre la cabecera y hace comparacion con validacion de cabecera
			foreach($cabeceralimpia as $infcabecera){
				if(!in_array($infcabecera, $ValidacionCabecera)){	
					$errorcampos++;
					$erroresdeCampos.=$infcabecera.", ";
				}
			}
			if($errorcampos == 0){
					$arreglodata = array();
				while (($line = fgetcsv($openfile, 0,';')) !== FALSE) {
						array_push($arreglodata,$line);
				}
				fclose($openfile);
				$salida2 = array();
				//se recorre el arreglo
				foreach($arreglodata as $infoProductos){
					for($i=0; $i<count($cabeceralimpia);$i++){
						$cadena = str_replace('','',trim($infoProductos[$i]));
						$final[$cabeceralimpia[$i]]= $cadena;					
					}
					array_push($salida2,$final);
				}
				$conProductosRegistrados = 0;
				$conProductosNoRegistrados = 0;
				$noRegistrado = array();
				//recorrido de registros.
				foreach($salida2 as $newData){
				$newData['idProducto'] 		= $_POST['idProducto'];
				$newData['idTienda']   		= $_SESSION['project']['info']['idTienda'];
				$newData['idSubcategoria'] 	= $_POST['idSubcategoria'];
				$newData2 = $newData;
				$proceso 	 	=  $this->logicaTienda->insetProductos($newData);//guardado de registros
					if($proceso > 0 ){
						$conProductosRegistrados++;
					}
					else{
						$conProductosNoRegistrados++;
						array_push($noRegistrado,$newData2);
					}
				}
				//se inicia session, para hacer ejecuion de excel
				if(count($noRegistrado)>0){
					$_SESSION['noRegistrado'] = $noRegistrado;
				}
				$salida = array("mensaje"=>"Se registraron ".$conProductosRegistrados. " productos, no se registraron ".$conProductosNoRegistrados." productos",
							"continuar"=>1,
							"datos"=>$noRegistrado);			
			} 
			else{
				$salida = array("mensaje"=>"El formato de excel esta erroneo, los siguientes campos no se encontraron en el archivo: ".$erroresdeCampos." por favor verifique",
							"continuar"=>0,
							"datos"=>"");
			}
			
		echo json_encode($salida);
	}
	
}//exportar excel de datos no actualizados
public function datosexcelmasivo(){
	//var_dump($_SESSION['noActualizados']);die();
		$table           = "";
		$table .= "<table>";
			$table .= "<tr>";
				$table .= "<td>codigoProducto</td>";
				$table .= "<td>nombrePresentacion</td>";
				$table .= "<td>marca</td>";
				$table .= "<td>fotoPresentacion</td>";
				$table .= "<td>foto2</td>";
				$table .= "<td>foto3</td>";
				$table .= "<td>foto4</td>";
				$table .= "<td>foto5</td>";
				$table .= "<td>descripcionpres</td>";
				$table .= "<td>nuevo</td>";
				$table .= "<td>descuento</td>";
				$table .= "<td>agotado</td>";
				$table .= "<td>valorPresentacion</td>";
				$table .= "<td>valorAntes</td>";
			$table .= "</tr>";
			foreach ($_SESSION['noRegistrado']  as $u){
			$table .= "<tr>";
				$table .= "<td>".$u['codigoProducto']."</td>";
				$table .= "<td>".$u['nombrePresentacion']."</td>";
				$table .= "<td>".$u['marca']."</td>";
				$table .= "<td>".$u['fotoPresentacion']."</td>";
				$table .= "<td>".$u['foto2']."</td>";
				$table .= "<td>".$u['foto3']."</td>";
				$table .= "<td>".$u['foto4']."</td>";
				$table .= "<td>".$u['foto5']."</td>";
				$table .= "<td>".$u['descripcionpres']."</td>";
				$table .= "<td>".$u['nuevo']."</td>";
				$table .= "<td>".$u['descuento']."</td>";
				$table .= "<td>".$u['agotado']."</td>";
				$table .= "<td>".$u['valorPresentacion']."</td>";
				$table .= "<td>".$u['valorAntes']."</td>";
			$table .= "</tr>";
			}
		$table .= "</table>";
		unset($_SESSION['noRegistrado']);//se cierra sesion de la ejecucion de excel
		header("Pragma: public");
		header("Expires: 0");
		$filename = "registros_no_actualizados.xls";
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$filename");
		header("Pragma: no-cache");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		echo $table;
		die();
}
public function cargaPlantillaCargaFotos()
    {
        extract($_POST);
        if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
        {
            $where['idTienda']   = $_SESSION['project']['info']['idTienda'];
        }
        $where['idEstado']      = 1;
        $categorias             = $this->logicaHome->getCategorias($where); 
        $salida["selects"]      = array("categorias"=>$categorias['datos']);
        $idComentario= "";
        //var_dump($ver);die();
        if($ver == '1')
        {   
            //busca la info de la categoria
            $infoProducto               = $this->logicaHome->infoProducto($where);
            $salida["titulo"]           = lang("text18");
            $salida["datos"]            = $infoProducto['datos'][0];
            $salida["idPresentacion"]   = $idPresentacion;
            $salida["persistencia"]     = 0;
            $salida["ver"]              = $ver;
            $salida["labelBtn"]         = lang("text18");
            $vista = $this->load->view("home/edicionTienda/productos/cargaFotos",$salida,true);
            $respuesta = array("json"=>$infoProducto['datos'][0],"html"=>$vista);
        }
        echo json_encode($respuesta);
    }
    //cargar imagenes
    public function procesaDataimagenes(){
		extract($_POST);
		$data = array();
		$archivosNoCargados= 0;
		$archivosCargados= 0;
		$filesCount = count($_FILES['imagenes']['name']);
        for($i = 0; $i < $filesCount; $i++){
            $_FILES['imagene']['name'] 	= $_FILES['imagenes']['name'][$i];
            $_FILES['imagene']['type'] 	= $_FILES['imagenes']['type'][$i];
            $_FILES['imagene']['tmp_name'] = $_FILES['imagenes']['tmp_name'][$i];
			$_FILES['imagene']['error'] = $_FILES['imagenes']['error'][$i];
			$_FILES['imagene']['size'] = $_FILES['imagenes']['size'][$i];

			$idTienda	=   $_SESSION['project']['info']['idTienda'];
			@mkdir('assets/uploads/files/'.$idTienda,0777);
			$config['upload_path'] = 'assets/uploads/files/'.$idTienda.'/';
			//echo $config['upload_path'];
        	$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['overwrite'] = true;
        	$this->load->library('upload', $config);
    		$this->upload->initialize($config);
			if(!$this->upload->do_upload('imagene')) 
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
				$archivosNoCargados++;
			}
			else
			{
					$data 							= 	$this->upload->data();
					$dataImagen['foto']				=	$data['file_name'];
					$dataImagen['rutaFoto']			=	$config['upload_path'] = 'assets/uploads/files/'.$idTienda.'/'.$data['file_name'];
					$dataImagen['idTienda']			=   $_SESSION['project']['info']['idTienda'];
					$salida 	 	=  $this->logicaTienda->inserimagenes($dataImagen);	
					$archivosCargados++;
			}
			$salida = array("mensaje"=>"Las imagenes se han cargado correctamente: ".$archivosCargados." archivos, no se han cargado ".$archivosNoCargados." archivos.",
							"continuar"=>1,
							"datos"=>"");	
		}
    	
		echo json_encode($salida);
	}
}
