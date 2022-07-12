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
	public function cargaPlantillaactualizaProductos()
	{	
		if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
		{
			$where['idTienda']   = $_SESSION['project']['info']['idTienda'];
		}
	}
	

}
