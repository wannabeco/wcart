<?php
/*
	("`-''-/").___....''"`-._
      `6_ 6  )   `-.  (     ).`-.__.`) 
      (_Y_.)'  ._   )  `._ `. ``-..-'
    _..`..'_..-_/  /..'_.' ,'
   (il),-''  (li),'  ((!.-'
   Desarrollado por @orugal
   https://github.com/orugal
   Controlador pedidos
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Pedidos extends CI_Controller 
{
	function __construct() 
    {
        parent::__construct();
        $this->load->model("general/LogicaGeneral", "logica");//la idea es que este archivo siempre esté ya que aquí se consultan cosas que son muy globales.
        $this->load->model("administrativos/LogicaAdministrativos", "ladminis");//aquí se debe llamar la lógica correspondiente al módulo que se esté haciendo.
        $this->load->model("login/LogicaLogin", "logicaLogin");
        $this->load->model("registro/LogicaRegistro", "logicaReg");
        $this->load->model("admin/LogicaUsuarios", "logicaUsuarios");
        $this->load->model("pedidos/LogicaPedidos", "logicaPedidos");
       	$this->load->helper('language');//mantener siempre.
    	$this->lang->load('spanish');//mantener siempre.
        // $this->load->library('Excel',"excel");
        $this->load->library('Pdf');
        $this->load->library('HTML_fpdf');
    }

    public function imprimeFacturaTicket($idPedido)
    {
        $infoPedido                 = $this->logicaPedidos->misPedidos(array("idPedido"=>($idPedido)));
        $productosPedido            = $this->logicaPedidos->productosPedidos(array("idPedido"=>($idPedido)));
        $pdf = new FPDF($orientation='P',$unit='mm', array(45,350));
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',8);    //Letra Arial, negrita (Bold), tam. 20
        $textypos = 5;
        //$pdf->setX(2);
        $pdf->setY(2);
        $pdf->setX(2);
        $pdf->Cell(5,$textypos,strtoupper(_CONFIG_NOMBRE_EMPRESA));
        $pdf->SetFont('Arial','',5);    //Letra Arial, negrita (Bold), tam. 20
        $textypos+=6;
        $pdf->setX(2);
        $pdf->Cell(5,$textypos,"NIT: ".strtoupper(_CONFIG_NIT_EMPRESA));
        $textypos+=5;
        $pdf->setX(2);
        $pdf->Cell(5,$textypos,strtoupper(_CONFIG_DIR_EMPRESA));
        $textypos+=5;
        $pdf->setX(2);
        $pdf->Cell(5,$textypos,strtoupper(_CONFIG_TEL_EMPRESA));
        $textypos+=6;
        $pdf->setX(2);
        $pdf->Cell(5,$textypos,'-------------------------------------------------------------------');
        $textypos+=6;
        $pdf->setX(2);
        $pdf->Cell(5,$textypos,'CANT.  ARTICULO       PRECIO               TOTAL');

        $total =0;
        $off = $textypos+6;
        foreach($productosPedido as $pro)
        {
            $pdf->setX(2);
            $pdf->Cell(5,$off,$pro["cantidad"]);
            $pdf->setX(6);
            $pdf->Cell(35,$off,  strtoupper(substr(utf8_decode($pro["nombrePresentacion"]), 0,12)) );
            $pdf->setX(20);
            $pdf->Cell(11,$off,  "$".number_format($pro["valorPresentacion"],0,".",",") ,0,0,"R");
            $pdf->setX(32);
            $pdf->Cell(11,$off,  "$ ".number_format($pro["cantidad"]*$pro["valorPresentacion"],0,".",",") ,0,0,"R");
            $total += $pro["cantidad"]*$pro["valorPresentacion"];
            $off+=6;
        }
        $textypos=$off+2;
        $pdf->setX(2);
        $pdf->Cell(5,$textypos,'-------------------------------------------------------------------');

        $textypos+=6;
        $pdf->setX(2);
        $pdf->Cell(5,$textypos,"DOMICILIO: " );
        $pdf->setX(38);
        $pdf->Cell(5,$textypos,"$ ".number_format($infoPedido[0]['valorDomicilio'],0,".",","),0,0,"R");
        
        $textypos+=6;
        $pdf->setX(2);
        $pdf->Cell(5,$textypos,"TOTAL PEDIDO: " );
        $pdf->setX(38);
        $pdf->Cell(5,$textypos,"$ ".number_format($total,0,".",","),0,0,"R");
        $textypos+=6;
        $pdf->setX(2);
        $pdf->Cell(5,$textypos,'-------------------------------------------------------------------');
        $textypos+=6;
        $pdf->setX(2);
        $pdf->Cell(5,$textypos,"TOTAL: " );
        $pdf->setX(38);
        $pdf->Cell(5,$textypos,"$ ".number_format($total + $infoPedido[0]['valorDomicilio'],0,".",","),0,0,"R");
        $pdf->SetFont('Arial','B',6);    //Letra Arial, negrita (Bold), tam. 20
        $pdf->setX(2);
        $pdf->Cell(5,$textypos+10,'GRACIAS POR SU COMPRA ');

        $pdf->output();
    }

    public function controlPedidos($idModulo)
    {
        if(validaIngreso())
        {
            /*******************************************************************************************/
            /* ESTA SECCIÓN DE CÓDIGO  ES MUY IMPORTANTE YA QUE ES LA QUE CONTROLARÁ EL MÓDULO VISITADO*/
            /*******************************************************************************************/
            //si no se declara está variable en cada inicio del módulo no se podrán consultar los privilegios
            $_SESSION['moduloVisitado']     =   $idModulo;
            //antes de pintar la plantilla del módulo valido si hay permisos de ver ese módulo para evitar que ingresen al módulo vía URL
            if(getPrivilegios()[0]['ver'] == 1)
            { 
                //info Módulo
                $infoModulo                 = $this->logica->infoModulo($idModulo);
                $listaPedidos               = $this->logicaPedidos->getPedidos(array());
                $opc                        = "home";
                $salida['titulo']           = lang("titulo")." - ".$infoModulo[0]['nombreModulo'];
                $salida['centro']           = "pedidos/home";
                $salida['infoModulo']       = $infoModulo[0];
                $salida['listaPedidos']     = $listaPedidos;
                $this->load->view("app/index",$salida);
            }
            else
            {
                $opc                   = "home";
                $salida['titulo']      = lang("titulo")." - Área Restringida";
                $salida['centro']      = "error/areaRestringida";
                $this->load->view("app/index",$salida);
            }
        }
        else
        {
            header('Location:'.base_url()."login");
        }
    }


    public function pedidosEntrantes($idModulo)
    {
        if(validaIngreso())
        {   
			$estadoTienda = estadoTiendaAdmin();
            var_dump($estadoTienda);die();
			if($estadoTienda['mostrar'] == 1)
			{
				/*******************************************************************************************/
                /* ESTA SECCIÓN DE CÓDIGO  ES MUY IMPORTANTE YA QUE ES LA QUE CONTROLARÁ EL MÓDULO VISITADO*/
                /*******************************************************************************************/
                //si no se declara está variable en cada inicio del módulo no se podrán consultar los privilegios
                $_SESSION['moduloVisitado']     =   $idModulo;
                //antes de pintar la plantilla del módulo valido si hay permisos de ver ese módulo para evitar que ingresen al módulo vía URL
                if(getPrivilegios()[0]['ver'] == 1)
                { 
                    unset($_SESSION['refPedido']);//elimino el codigo temporal del pedido
                    unset($_SESSION['pedido']);//elimino el array del pedido
                    //info Módulo
                    $infoModulo                 = $this->logica->infoModulo($idModulo);
                    $listadoDeEstados           = $this->logica->getEstadosPedido();

                    //$listaPedidos               = $this->logicaPedidos->misPedidos(array("p.idPersona"=>$_SESSION['project']['info']['idPersona']));
                    if($_SESSION['project']['info']['idPerfil'] == _PERFIL_ADMIN)//si es admin debe traer los pedidos solo para el admin
                    {
                        $listaPedidos               = $this->logicaPedidos->misPedidos();
                    }
                    else
                    {
                        $listaPedidos               = $this->logicaPedidos->misPedidos();
                    }
                    //var_dump($listaPedidos);
                    //die($_SESSION['project']['info']['idPerfil']);
                    $opc                        = "home";
                    $salida['titulo']           = lang("titulo")." - ".$infoModulo[0]['nombreModulo'];
                    $salida['estados']          = $listadoDeEstados;       
                    $salida['centro']           = "pedidos/homeMisPedidos";
                    $salida['infoModulo']       = $infoModulo[0];
                    $salida['listaPedidos']     = $listaPedidos;
                    $this->load->view("app/index",$salida);
                }
                else
                {
                    $opc                   = "home";
                    $salida['titulo']      = lang("titulo")." - Área Restringida";
                    $salida['centro']      = "error/areaRestringida";
                    $this->load->view("app/index",$salida);
                }
			}
			else
			{
				$idTienda 				= $_SESSION['project']['info']['idTienda'];
				$infoTienda     		= $this->logica->getInfoTiendaNew($idTienda);
				$opc 					= "home";
				$salida['titulo'] 	  	= "Licencia expirada";
				$salida['dataLicencia'] = $estadoTienda;
				$salida['infoTienda']   = $infoTienda;
				$salida['centro'] 		= "app/homeCaducidad";
				$this->load->view("app/index",$salida);
			}
        }
        else
        {
            header('Location:'.base_url()."login");
        }
    }

    public function ingresoProducto($idModulo)
    {
        if(validaIngreso())
        {
            /*******************************************************************************************/
            /* ESTA SECCIÓN DE CÓDIGO  ES MUY IMPORTANTE YA QUE ES LA QUE CONTROLARÁ EL MÓDULO VISITADO*/
            /*******************************************************************************************/
            //si no se declara está variable en cada inicio del módulo no se podrán consultar los privilegios
            $_SESSION['moduloVisitado']     =   $idModulo;
            //antes de pintar la plantilla del módulo valido si hay permisos de ver ese módulo para evitar que ingresen al módulo vía URL
            if(getPrivilegios()[0]['ver'] == 1)
            { 
                unset($_SESSION['refPedido']);//elimino el codigo temporal del pedido
                unset($_SESSION['pedido']);//elimino el array del pedido
                //info Módulo
                $infoModulo                 = $this->logica->infoModulo($idModulo);
                $listadoDeEstados           = $this->logica->getEstadosPedido();

                $listaEntradas              = $this->logicaPedidos->getInventario(array("movimiento"=>"entrada"));

                //var_dump($listaEntradas);
                //die($_SESSION['project']['info']['idPerfil']);
                $opc                        = "home";
                $salida['titulo']           = lang("titulo")." - ".$infoModulo[0]['nombreModulo'];
                $salida['estados']          = $listadoDeEstados;       
                $salida['centro']           = "pedidos/homeIngreso";
                $salida['infoModulo']       = $infoModulo[0];
                $salida['listaEntradas']     = $listaEntradas;
                $this->load->view("app/index",$salida);
            }
            else
            {
                $opc                   = "home";
                $salida['titulo']      = lang("titulo")." - Área Restringida";
                $salida['centro']      = "error/areaRestringida";
                $this->load->view("app/index",$salida);
            }
        }
        else
        {
            header('Location:'.base_url()."login");
        }

    }

    //Pedidos de Raul
    public function misPedidos($idModulo)
    {
        if(validaIngreso())
        {   
            $estadoTienda = estadoTiendaAdmin();
			if($estadoTienda['mostrar'] == 1)
			{
				/*******************************************************************************************/
            /* ESTA SECCIÓN DE CÓDIGO  ES MUY IMPORTANTE YA QUE ES LA QUE CONTROLARÁ EL MÓDULO VISITADO*/
            /*******************************************************************************************/
            //si no se declara está variable en cada inicio del módulo no se podrán consultar los privilegios
            $_SESSION['moduloVisitado']     =   $idModulo;
            //antes de pintar la plantilla del módulo valido si hay permisos de ver ese módulo para evitar que ingresen al módulo vía URL
            if(getPrivilegios()[0]['ver'] == 1)
            { 
                unset($_SESSION['refPedido']);//elimino el codigo temporal del pedido
                unset($_SESSION['pedido']);//elimino el array del pedido
                //info Módulo
                $infoModulo                 = $this->logica->infoModulo($idModulo);
                $listadoDeEstados           = $this->logica->getEstadosPedido();

                //$listaPedidos               = $this->logicaPedidos->misPedidos(array("p.idPersona"=>$_SESSION['project']['info']['idPersona']));
                // if($_SESSION['project']['info']['idPerfil'] == _PERFIL_ADMIN)//si es admin debe traer los pedidos solo para el admin
                // {
                    //tomo los pedidos de todas las personas que sean administradores de ventas
                    $wherePedido = array();
                    if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
                    {
                        $wherePedido['p.idTienda'] = $_SESSION['project']['info']['idTienda'];
                    }
                    
                    $listaPedidos               = $this->logicaPedidos->misPedidos($wherePedido);
                
                // }
                // else
                // {
                //     $listaPedidos               = $this->logicaPedidos->misPedidos(array("p.idPersona"=>$_SESSION['project']['info']['idPersona']));
                // }
                //var_dump($listaPedidos);
                //die($_SESSION['project']['info']['idPerfil']);
                $opc                        = "home";
                $salida['titulo']           = lang("titulo")." - ".$infoModulo[0]['nombreModulo'];
                $salida['estados']          = $listadoDeEstados;       
                $salida['centro']           = "pedidos/homeMisPedidos";
                $salida['infoModulo']       = $infoModulo[0];
                $salida['listaPedidos']     = $listaPedidos;
                $this->load->view("app/index",$salida);
            }
            else
            {
                $opc                   = "home";
                $salida['titulo']      = lang("titulo")." - Área Restringida";
                $salida['centro']      = "error/areaRestringida";
                $this->load->view("app/index",$salida);
            }
			}
			else
			{
				header('Location:'.base_url()."pagoMembresia/pagoMembresia");
			}
        }
        else
        {
            header('Location:'.base_url()."login");
        }
    }

    public function nuevoPedido($idModulo)
    {
        if(validaIngreso())
        {
            /*******************************************************************************************/
            /* ESTA SECCIÓN DE CÓDIGO  ES MUY IMPORTANTE YA QUE ES LA QUE CONTROLARÁ EL MÓDULO VISITADO*/
            /*******************************************************************************************/
            //si no se declara está variable en cada inicio del módulo no se podrán consultar los privilegios
            $_SESSION['moduloVisitado']     =   $idModulo;
            //antes de pintar la plantilla del módulo valido si hay permisos de ver ese módulo para evitar que ingresen al módulo vía URL
            if(getPrivilegios()[0]['ver'] == 1)
            { 
                if(!isset($_SESSION['refPedido']))
                {
                    $_SESSION['refPedido'] = generacodigo(10);
                }
                //info Módulo
                $infoModulo                 = $this->logica->infoModulo($idModulo);
                $opc                        = "home";
                $salida['titulo']           = lang("titulo")." - ".$infoModulo[0]['nombreModulo'];
                $salida['centro']           = "pedidos/nuevoPedido";
                $salida['infoModulo']       = $infoModulo[0];
                $this->load->view("app/index",$salida);
            }
            else
            {
                $opc                   = "home";
                $salida['titulo']      = lang("titulo")." - Área Restringida";
                $salida['centro']      = "error/areaRestringida";
                $this->load->view("app/index",$salida);
            }
        }
        else
        {
            header('Location:'.base_url()."login");
        }
    }

    public function pedidosEntrantesOld($idModulo)
    {
        if(validaIngreso())
        {
            /*******************************************************************************************/
            /* ESTA SECCIÓN DE CÓDIGO  ES MUY IMPORTANTE YA QUE ES LA QUE CONTROLARÁ EL MÓDULO VISITADO*/
            /*******************************************************************************************/
            //si no se declara está variable en cada inicio del módulo no se podrán consultar los privilegios
            $_SESSION['moduloVisitado']     =   $idModulo;
            //antes de pintar la plantilla del módulo valido si hay permisos de ver ese módulo para evitar que ingresen al módulo vía URL
            if(getPrivilegios()[0]['ver'] == 1)
            { 
                //info Módulo
                $infoModulo                 = $this->logica->infoModulo($idModulo);
                if($_SESSION['project']['info']['idPersona'] == _PERFIL_ADMIN)//si es admin debe traer los pedidos solo para el admin
                {
                    $listaPedidos               = $this->logicaPedidos->misPedidos(array("p.pedidoPara"=>0));
                }
                else
                {
                    $listaPedidos               = $this->logicaPedidos->misPedidos(array("p.pedidoPara"=>$_SESSION['project']['info']['idPersona']));
                }
                $opc                        = "home";
                $salida['titulo']           = lang("titulo")." - ".$infoModulo[0]['nombreModulo'];
                $salida['centro']           = "pedidos/homeEntrantes";
                $salida['infoModulo']       = $infoModulo[0];
                $salida['listaPedidos']     = $listaPedidos;
                $this->load->view("app/index",$salida);
            }
            else
            {
                $opc                   = "home";
                $salida['titulo']      = lang("titulo")." - Área Restringida";
                $salida['centro']      = "error/areaRestringida";
                $this->load->view("app/index",$salida);
            }
        }
        else
        {
            header('Location:'.base_url()."login");
        }
    }

    public function detallePedido($idModulo,$idPedido)
    {
        if(validaIngreso())
        {
            /*******************************************************************************************/
            /* ESTA SECCIÓN DE CÓDIGO  ES MUY IMPORTANTE YA QUE ES LA QUE CONTROLARÁ EL MÓDULO VISITADO*/
            /*******************************************************************************************/
            //si no se declara está variable en cada inicio del módulo no se podrán consultar los privilegios
            $_SESSION['moduloVisitado']     =   $idModulo;
            //antes de pintar la plantilla del módulo valido si hay permisos de ver ese módulo para evitar que ingresen al módulo vía URL
            if(getPrivilegios()[0]['ver'] == 1)
            { 
                //info Módulo
                $infoModulo                 = $this->logica->infoModulo($idModulo);
                $infoPedido                 = $this->logicaPedidos->getPedidos(array("idPedido"=>($idPedido)));
                $productosPedido            = $this->logicaPedidos->productosPedidos(array("idPedido"=>($idPedido)));
                $listadoDeEstados           = $this->logica->getEstadosPedido();
                //var_dump($listadoDeEstados);
                $opc                        = "home";
                $salida['titulo']           = lang("titulo")." - Detalle del pedido ".$idPedido;
                $salida['centro']           = "pedidos/detalle";
                $salida['infoModulo']       = $infoModulo[0];
                $salida['infoPedido']       = $infoPedido[0];
                $salida['productosPedido']  = $productosPedido;
                $salida['estados']          = $listadoDeEstados;
                $this->load->view("app/index",$salida);
            }
            else
            {
                $opc                   = "home";
                $salida['titulo']      = lang("titulo")." - Área Restringida";
                $salida['centro']      = "error/areaRestringida";
                $this->load->view("app/index",$salida);
            }
        }
        else
        {
            header('Location:'.base_url()."login");
        }
    }

    public function detalleMiPedido($idModulo,$idPedido)
    {
        if(validaIngreso())
        {
            /*******************************************************************************************/
            /* ESTA SECCIÓN DE CÓDIGO  ES MUY IMPORTANTE YA QUE ES LA QUE CONTROLARÁ EL MÓDULO VISITADO*/
            /*******************************************************************************************/
            //si no se declara está variable en cada inicio del módulo no se podrán consultar los privilegios
            $_SESSION['moduloVisitado']     =   $idModulo;
            //antes de pintar la plantilla del módulo valido si hay permisos de ver ese módulo para evitar que ingresen al módulo vía URL
            if(getPrivilegios()[0]['ver'] == 1)
            { 
                //info Módulo
                $infoModulo                 = $this->logica->infoModulo($idModulo);
                $infoPedido                 = $this->logicaPedidos->misPedidos(array("idPedido"=>($idPedido)));
                $productosPedido            = $this->logicaPedidos->productosPedidos(array("idPedido"=>($idPedido)));
                $listadoDeEstados           = $this->logica->getEstadosPedido();
                //var_dump($productosPedido);
                $opc                        = "home";
                $salida['titulo']           = lang("titulo")." - Detalle del pedido ".$idPedido;
                $salida['centro']           = "pedidos/detalleMiPedido";
                $salida['infoModulo']       = $infoModulo[0];
                $salida['infoPedido']       = $infoPedido[0];
                $salida['productosPedido']  = $productosPedido;
                $salida['estados']          = $listadoDeEstados;
                $this->load->view("app/index",$salida);
            }
            else
            {
                $opc                   = "home";
                $salida['titulo']      = lang("titulo")." - Área Restringida";
                $salida['centro']      = "error/areaRestringida";
                $this->load->view("app/index",$salida);
            }
        }
        else
        {
            header('Location:'.base_url()."login");
        }
    }
    public function cargaPlantillaAgregaProducto()
    {
        extract($_POST);
        if($edita == 1)
        {
            //$infoModulo          = $this->logica->infoModulo($id);
            $productos            = $this->logica->getProductos($id); 
            $salida["titulo"]    = "Editar productos del pedido";
            $salida["datos"]     = $infoModulo[0];
            $salida["padre"]     = $padre;
            $salida["edita"]     = $edita;
            $salida["idEdita"]   = $id;
            $salida["productos"] = $productos['datos'];
            $salida["labelBtn"]  = "EDITAR MÓDULO";
            $salida["perfiles"]  = $perfiles;
        }
        else
        {
            $productos            = $this->logica->getProductos();
            //var_dump($productos); 
            $salida["titulo"]    = "Agregar producto al pedido";
            $salida["datos"]     = array();
            $salida["edita"]     = $edita;
            $salida["idEdita"]   = "";
            $salida["productos"] = $productos['datos'];
            $salida["labelBtn"]  = "AGREGAR AL PEDIDO";
        }
        echo $this->load->view("pedidos/formControlProductos",$salida,true);
    }
    //para agregar el producto al stock
    public function cargaPlantillaProducto()
    {
        extract($_POST);
        if($edita == 1)
        {
            $infoModulo          = $this->logica->infoModulo($id);
            $inventario            = $this->logicaPedidos->getInventario(array("idInventario"=>$id)); 
            $productos            = $this->logica->getProductos(); 

            //var_dump($productos);
            $salida["titulo"]    = "Editar ingreso del producto";
            $salida["datos"]     = $inventario[0];
            $salida["edita"]     = $edita;
            $salida["idInventario"]   = $id;
            $salida["productos"] = $productos['datos'];
            $salida["labelBtn"]  = "EDITAR STOCK";
            //$salida["perfiles"]  = $perfiles;
        }
        else
        {
            //var_dump($productos); 
            $productos            = $this->logica->getProductos(); 
            $salida["titulo"]    = "Agregar producto al stock";
            $salida["datos"]     = array();
            $salida["edita"]     = $edita;
            $salida["idInventario"]   = "";
            $salida["productos"] =  $productos['datos'];
            $salida["labelBtn"]  = "AGREGAR AL STOCK";
        }
        echo $this->load->view("pedidos/formControlIngreso",$salida,true);
    }

    public function getPresentacionesProducto()
    {
        extract($_POST);
        $where['pre.idProducto']       = $idProducto;
        $presentaciones            = $this->logica->getPresentacionesProducto($where);
        //var_dump($presentaciones);
        $salida['presentaciones'] = $presentaciones;
        echo $this->load->view("pedidos/presentaciones",$salida,true);
    }
    public function agregaPedidoTmp()
    {
        foreach($_POST['productos'] as $infoPedido)
        {
            //consulto la informacion del producto
            $infoProducto = $this->logica->getProductos(array('idProducto'=>$infoPedido['idProducto']))['datos'];
            $infoPres     = $this->logica->getPresentacionesProducto(array('idPresentacion'=>$infoPedido['idPresentacion']))['datos'];

            $_SESSION['pedido'][$infoPedido['idProducto']][$infoPedido['idPresentacion']]['idPresentacion'] = $infoPedido['idPresentacion'];
            $_SESSION['pedido'][$infoPedido['idProducto']][$infoPedido['idPresentacion']]['cantidad']       = $infoPedido['cantidad'];
            $_SESSION['pedido'][$infoPedido['idProducto']][$infoPedido['idPresentacion']]['idProducto']     = $infoPedido['idProducto'];
            $_SESSION['pedido'][$infoPedido['idProducto']][$infoPedido['idPresentacion']]['nombreProducto'] = $infoProducto[0]['nombreProducto'];
            $_SESSION['pedido'][$infoPedido['idProducto']][$infoPedido['idPresentacion']]['nombrePresentacion'] = $infoPres[0]['nombrePresentacion'];
            $_SESSION['pedido'][$infoPedido['idProducto']][$infoPedido['idPresentacion']]['valorPresentacion'] = $infoPres[0]['valorPresentacion'];
            //array_push($salida, $pedido);

        }
        $salida = array("mensaje"=>"Productos agregados al pedido",
                        "continuar"=>1);
        echo  json_encode($salida);
    }
    public function refrescaPedido()
    {
       // pre($_SESSION['pedido']);
        $salida['dataPedido'] = (isset($_SESSION['pedido']))?$_SESSION['pedido']:array();
        echo  $this->load->view("pedidos/tablePedido",$salida,true);
    }



    public function gestionPedidoAdmin()
    {
        extract($_POST);
        $gestionPedidoAdmin = $this->logicaPedidos->gestionPedidoAdmin($_POST);
        echo json_encode($gestionPedidoAdmin);
    }

    public function getInfoRemitentes()
    {
        extract($_POST);
        $infoRemitente = $this->logicaPedidos->getInfoRemitentes(array("cedulaPersona"=>$documento));
        echo json_encode($infoRemitente);
    }


    public function registraIngresoStock()
    {
        //var_dump($_POST);
        extract($_POST);
        $ingreso = $this->logicaPedidos->registraIngresoStock($_POST);
        echo json_encode($ingreso);
    }
    //proceso demonio de Payu para la confirmacion

    public function confirmacionPago()
    {
        //var_dump($_POST);die();reference_sale
        extract($_POST);
        //debo actualizar la informacon del pedido con lo que me retorno payu
        $dataInserta['estadoPago']      = $state_pol;
        $dataInserta['transactionId']   = $transaction_id;
        $dataInserta['reference_pol']   = $reference_pol;
        $dataInserta['valor']           = $value;
        $dataInserta['moneda']          = $currency;
        $dataInserta['entidad']         = $payment_method;
        $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
        $condicion['codigoPedido']      = $reference_sale;
        $updatePedido                   = $this->logica->actualizaPedido($dataInserta,$condicion);
        //envia el mensaje al administrador de la tienda diciendo que el pedido llego
        $mensajeenviar  = "Confirmación de pago del pedido <strong>".$reference_sale."</strong><br><br>";
        $mensaje = plantillaMail($mensajeenviar);
        sendMail(_ADMIN_PEDIDOS,"Estado de pago del pedido ".$reference_sale,$mensaje);
    }

    public function confirmacionPagoWompi()
    {
        //var_dump($_SESSION['confirmaWompi']);
        extract($_SESSION['confirmaWompi']);
        //var_dump($_POST);die();reference_sale
        //extract($_POST);
        //debo actualizar la informacon del pedido con lo que me retorno payu
        $dataInserta['estadoPago']      = $state_pol;
        $dataInserta['transactionId']   = $transaction_id;
        $dataInserta['reference_pol']   = $reference_pol;
        $dataInserta['valor']           = $value;
        $dataInserta['moneda']          = $currency;
        $dataInserta['entidad']         = $payment_method;
        $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
        $condicion['codigoPedido']      = $codigoPedido;
        
        $infoPedido     = $this->logicaPedidos->getPedidos(array("codigoPedido"=>$codigoPedido));
        $infoTienda     = $this->logica->getInfoTiendaNew($infoPedido[0]['tienda']);
        
        $updatePedido                   = $this->logica->actualizaPedido($dataInserta,$condicion);
        //envia el mensaje al administrador de la tienda diciendo que el pedido llego
        //$mensajeMail  = "Confirmación de pago del pedido <strong>".$reference_sale."</strong><br><br>";
       // sendMail(_ADMIN_PEDIDOS,"Estado de pago del pedido ".$reference_sale,$mensajeMail);

       if ($state_pol == 998) {
            $estadoTx = "Transacción aprobada";
            $claseLabel = "label-success";
        }
        else
        {
            $estadoTx = "Transacción rechazada";
            $claseLabel = "label-danger";
        }


        $salida['estadoTx']         =   $estadoTx;
        $salida['currency']         =   $currency;
        $salida['referenceCode']    =   $codigoPedido;
        $salida['pseBank']          =   $payment_method;
        $salida['lapPaymentMethod'] =   $payment_method;
        $salida['transactionId']    =   $transaction_id;
        $salida['valor']    =   $value;


        $salida['titulo']      = "Respuesta de pago";
        $salida['titulo']      = lang("titulo")." - Resumen de la transacción";
        $salida['centro']      = "pedidos/respuestaPagoAppWompi";
        $salida['claseLabel']   = $claseLabel;
        $salida['infoTienda']   = $infoTienda['datos'][0];
        
		$this->load->view("registro/indexPago",$salida);
    }

    //Para los pagos de PAYU
    public function respuestaPago()
    {
        extract($_GET);
        //var_dump($_GET);die();

        
        $infoPedido     = $this->logicaPedidos->getPedidos(array("codigoPedido"=>$_GET['referenceCode']));
        $infoTienda     = $this->logica->getInfoTiendaNew($infoPedido[0]['tienda']);

        //var_dump($_SESSION['confirma']);
        $ApiKey             = $infoTienda['datos'][0]['payu_apikey'];

        $merchant_id        = $_GET['merchantId'];
        $referenceCode      = $_GET['referenceCode'];
        $TX_VALUE           = $_GET['TX_VALUE'];
        $New_value          = number_format($TX_VALUE, 1, '.', '');
        $currency           = $_GET['currency'];
        $transactionState   = $_GET['transactionState'];
        $firma_cadena       = "$ApiKey~$merchant_id~$referenceCode~$TX_VALUE~$currency";
        $firmacreada        = md5($firma_cadena);
        //echo $firmacreada;
        $firma              = $_GET['signature'];
        $reference_pol      = $_GET['reference_pol'];
        $cus                = $_GET['cus'];
        $extra1             = $_GET['description'];//confirmar con farez
        $pseBank            = $_GET['pseBank'];
        $lapPaymentMethod   = $_GET['lapPaymentMethod'];
        $transactionId      = $_GET['transactionId'];

        if ($_GET['transactionState'] == 4 ) {
            $estadoTx = lang("trans_aprobada");
            $claseLabel = "label-default";
        }
        else if ($_GET['transactionState'] == 6 ) {
            $estadoTx = lang("trans_rechazada");
            $claseLabel = "label-danger";
        }
        else if ($_GET['transactionState'] == 104 ) {
            $estadoTx = "Error";
            $claseLabel = "label-danger";
        }
        else if ($_GET['transactionState'] == 7 ) {
            $estadoTx = lang("trans_pendiente");
            $claseLabel = "label-warning";
        }
        else {
            $estadoTx=$_GET['mensaje'];
            $claseLabel = "";
        }

        //debo actualizar la informacon del pedido con lo que me retorno payu
        $dataInserta['estadoPago']      = $transactionState;
        $dataInserta['transactionId']   = $transactionId;
        $dataInserta['reference_pol']   = $reference_pol;
        $dataInserta['valor']           = $TX_VALUE;
        $dataInserta['moneda']          = $currency;
        $dataInserta['entidad']         = $lapPaymentMethod;
        $dataInserta['fechaPago']       = date("Y-m-d H:i:s");
        $condicion['codigoPedido']      = $referenceCode;
        
        //var_dump($condicion);
        $updatePedido                   = $this->logica->actualizaPedido($dataInserta,$condicion);
        
        $salida['estadoTx']         =   $estadoTx;
        $salida['ApiKey']           =   $ApiKey;
        $salida['merchant_id']      =   $merchant_id;
        $salida['referenceCode']    =   $referenceCode;
        $salida['TX_VALUE']         =   $TX_VALUE;
        $salida['New_value']        =   $New_value;
        $salida['currency']         =   $currency;
        $salida['transactionState'] =   $transactionState;
        $salida['firma_cadena']     =   $firma_cadena;
        $salida['firmacreada']      =   $firmacreada;
        $salida['firma']            =   $firma;
        $salida['reference_pol']    =   $reference_pol;
        $salida['cus']              =   $cus;
        $salida['extra1']           =   $extra1;
        $salida['pseBank']          =   $pseBank;
        $salida['lapPaymentMethod'] =   $lapPaymentMethod;
        $salida['transactionId']    =   $transactionId;

        $salida['infoTienda']       =   $infoTienda['datos'][0];

        $salida['titulo']      = lang("resp_pago");
        $salida['titulo']      = lang("titulo")." - ".lang("text35");
        $salida['centro']      = "pedidos/respuestaPagoApp";
        $salida['claseLabel']   = $claseLabel;
        
		$this->load->view("registro/indexPago",$salida);



        /*//debo sacar del código de referencia los pagos del usuario, primero debo hacer explode por el . porque en la primera posición está la fecha en tiemeestamp y la segunda posición serán los pagos que el seleccionó separados por -.
        $pedazos    = explode(".",$referenceCode);
        //ahora debo volver a hacer explode para tomar solo los pagos en un array
        $listaPagos = explode("-",$pedazos[1]);
        //consulto el periodo en el que se encuentra
        $condPedido['idPersona']    = $_SESSION['project']['info']['idPersona'];
        $condPedido['idPago']       = trim($listaPagos[0]);
        $infoPeriodo                = $this->ladminis->getPagos($condPedido);
        //traigo los pagos que están cargados
        $condicion['idPersona']     = $_SESSION['project']['info']['idPersona'];
        $condicion['periodoPago']   = trim($infoPeriodo[0]['periodoPago']);
        $infoPagos                  = $this->ladminis->getPagos($condicion);
        $infoPagosTotal             = $this->ladminis->getPagosNoßGroupWhereIn($condicion,$listaPagos);
        //debo insertar esta transacción en la tabla de pedidos de PAYU, pero primero debo verificar que no esté creado ya para evitar duplicidad
        //verifico
        $condiVerifica['idPago']    = trim($referenceCode);
        $verificacion               = $this->ladminis->verificaPedido($condiVerifica);
        //si nunca ha sido creada proceso a insertarla
        if(count($verificacion) == 0)
        {
            $dataInserta['estadoPago']      = $transactionState;
            $dataInserta['transactionId']   = $transactionId;
            $dataInserta['reference_pol']   = $reference_pol;
            $dataInserta['idPago']          = trim($referenceCode);
            $dataInserta['valor']           = $TX_VALUE;
            $dataInserta['moneda']          = $currency;
            $dataInserta['entidad']         = $lapPaymentMethod;
            $dataInserta['idpersona']       = $_SESSION['project']['info']['idPersona'];
            $dataInserta['fecha']           = date("Y-m-d H:i:s");
            $insercion                      = $this->ladminis->insertaPedido($dataInserta);
            $dataInsertaPago['idPedido']    = $insercion;
            $actualizoPagos                 = $this->ladminis->actualizaPagoWhereIn($dataInsertaPago,$listaPagos);
        }
        else//hago un update
        {
            $dataInserta['estadoPago']      = $transactionState;
            $dataInserta['transactionId']   = $transactionId;
            $dataInserta['reference_pol']   = $reference_pol;
            $dataInserta['idPago']          = trim($referenceCode);
            $dataInserta['valor']           = $TX_VALUE;
            $dataInserta['moneda']          = $currency;
            $dataInserta['entidad']         = $lapPaymentMethod;
            $dataInserta['idpersona']       = $_SESSION['project']['info']['idPersona'];
            $dataInserta['fecha']           = date("Y-m-d H:i:s");
            $condicionPago['idPago']        = trim($referenceCode); 
            $insercion                      = $this->ladminis->actualizaPedido($dataInserta,$condicionPago);
            //actualizo la tabla de los pagos inicial para marcar el pedido con el cual se pago el item
            $dataInsertaPago['idPedido']    = $verificacion[0]['idPedido'];
            $actualizoPagos                 = $this->ladminis->actualizaPagoWhereIn($dataInsertaPago,$listaPagos);
        }
        $salida['estadoTx']         =   $estadoTx;
        $salida['ApiKey']           =   $ApiKey;
        $salida['merchant_id']      =   $merchant_id;
        $salida['referenceCode']    =   $referenceCode;
        $salida['TX_VALUE']         =   $TX_VALUE;
        $salida['New_value']        =   $New_value;
        $salida['currency']         =   $currency;
        $salida['transactionState'] =   $transactionState;
        $salida['firma_cadena']     =   $firma_cadena;
        $salida['firmacreada']      =   $firmacreada;
        $salida['firma']            =   $firma;
        $salida['reference_pol']    =   $reference_pol;
        $salida['cus']              =   $cus;
        $salida['extra1']           =   $extra1;
        $salida['pseBank']          =   $pseBank;
        $salida['lapPaymentMethod'] =   $lapPaymentMethod;
        $salida['transactionId']    =   $transactionId;
        $opc                   = "home";
        $salida['titulo']      = "Respuesta de pago";
        $salida['centro']      = "administrativos/cargaPagos/respuestaPago";
        $salida['infoPagos']   = $infoPagos;
        $salida['infoPagosTotal']   = $infoPagosTotal;
        $salida['claseLabel']   = $claseLabel;
        $this->load->view("app/indexBlanco",$salida);*/
    }
    public function guardaPedido()
    {
        $insertaPedido = $this->logica->guardaPedido($_POST);
        echo json_encode($insertaPedido);
    }

    public function informeVentas($idModulo)
    {
        if(validaIngreso())
        {
            /*******************************************************************************************/
            /* ESTA SECCIÓN DE CÓDIGO  ES MUY IMPORTANTE YA QUE ES LA QUE CONTROLARÁ EL MÓDULO VISITADO*/
            /*******************************************************************************************/
            //si no se declara está variable en cada inicio del módulo no se podrán consultar los privilegios
            $_SESSION['moduloVisitado']     =   $idModulo;
            //antes de pintar la plantilla del módulo valido si hay permisos de ver ese módulo para evitar que ingresen al módulo vía URL
            if(getPrivilegios()[0]['ver'] == 1)
            { 
                //info Módulo
                $informe                    = $this->logica->informeVentas(array("pedidoPara"=>0));
                $infoModulo                 = $this->logica->infoModulo($idModulo);
                //ventasRelizadas();
                $opc                        = "home";
                $salida['titulo']           = lang("titulo")." - ".$infoModulo[0]['nombreModulo'];
                $salida['centro']           = "pedidos/informe";
                $salida['infoModulo']       = $infoModulo[0];
                $salida['informe']          = $informe;
                $this->load->view("app/index",$salida);
            }
            else
            {
                $opc                   = "home";
                $salida['titulo']      = lang("titulo")." - Área Restringida";
                $salida['centro']      = "error/areaRestringida";
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