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
class LogicaGeneral  {
    private $ci;
    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model("general/BaseDatosGral","dbGeneral");
        $this->ci->load->model("pedidos/BaseDatosPedidos","dbPedidos");
    } 
    public function getCiudades($where,$group=false)
    {
        $listaCiudades = $this->ci->dbGeneral->getCiudades($where,$group);
        if(count($listaCiudades) > 0)
        {
            $respuesta = array("mensaje"=>"Listado de ciudades",
                              "continuar"=>1,
                              "datos"=>$listaCiudades);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No existen ciudades",
                              "continuar"=>0,
                              "datos"=>"");    

        }
        return $respuesta;
    }

    public function getObservacionesUsuario($where)
    {
        $listaCiudades = $this->ci->dbGeneral->getObservacionesUsuario($where);
        if(count($listaCiudades) > 0)
        {
            $respuesta = array("mensaje"=>"Listado de obs",
                              "continuar"=>1,
                              "datos"=>$listaCiudades);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No existen obs",
                              "continuar"=>0,
                              "datos"=>array());    

        }
        return $respuesta;
    }
    
    public function getInfoPresentacion($where)
    {
        $infoPresentacion = $this->ci->dbGeneral->getPresentacionesProducto($where);
        $whereCaract = array("idPresentacion"=>$where['pre.idPresentacion'],
                            "idTienda"=>$where['pre.idTienda'],
                            "idEstado"=>1);
        $catacteriticasProducto = $this->ci->dbGeneral->getCaracteristicasProducto($whereCaract);
        if(count($infoPresentacion) > 0)
        {
            
            $infoPresentacion[0]['caracteristicas'] = $catacteriticasProducto;
            $respuesta = array("mensaje"=>"Info presentacion",
                              "continuar"=>1,
                              "datos"=>$infoPresentacion);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No hay info presentacion",
                              "continuar"=>0,
                              "datos"=>array());    

        }
        return $respuesta;
    }
    
    public function getBannersHome($where)
    {
        $banners = $this->ci->dbGeneral->getBannersHome($where);
        if(count($banners) > 0)
        {
            $respuesta = array("mensaje"=>"Listado de banners",
                              "continuar"=>1,
                              "datos"=>$banners);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No existen banners",
                              "continuar"=>0,
                              "datos"=>array());    

        }
        return $respuesta;
    }
    public function getProductos($where=array())
    {
        $productos = $this->ci->dbGeneral->getProductos($where);
        if(count($productos) > 0)
        {
            $respuesta = array("mensaje"=>"Listado de productos",
                              "continuar"=>1,
                              "datos"=>$productos);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No existen productos",
                              "continuar"=>0,
                              "datos"=>"");    

        }
        return $respuesta;
    }
    public function getSubcategorias($where=array())
    {
        $productos = $this->ci->dbGeneral->getSubcategorias($where);
        if(count($productos) > 0)
        {
            $respuesta = array("mensaje"=>"Listado de subcategorias",
                              "continuar"=>1,
                              "datos"=>$productos);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No existen subcategorias",
                              "continuar"=>0,
                              "datos"=>"");    

        }
        return $respuesta;
    }
    public function getNotificacionesPersona($where=array())
    {
        $noti = $this->ci->dbGeneral->getNotificacionesPersona($where);
        if(count($noti) > 0)
        {
            $respuesta = array("mensaje"=>"Listado de notificaciones",
                              "continuar"=>1,
                              "datos"=>$noti);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No existen notificaciones",
                              "continuar"=>0,
                              "datos"=>"");    

        }
        return $respuesta;
    }
    public function updateNotificacionesPersona($data,$where=array())
    {
        $noti = $this->ci->dbGeneral->updateNotificacionesPersona($data,$where);
        if(count($noti) > 0)
        {
            $respuesta = array("mensaje"=>"Listado de notificaciones",
                              "continuar"=>1,
                              "datos"=>$noti);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No existen notificaciones",
                              "continuar"=>0,
                              "datos"=>"");    

        }
        return $respuesta;
    }
    public function consultaSolicitudes($where)
    {
        $solicitudes = $this->ci->dbGeneral->consultaSolicitudes($where);
        if(count($solicitudes) > 0)
        {
            $respuesta = array("mensaje"=>"Listado de solicitudes",
                              "continuar"=>1,
                              "datos"=>$solicitudes);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No existen solicitudes",
                              "continuar"=>0,
                              "datos"=>"");    

        }
        return $respuesta;
    }
    public function cambioContrasena($where,$dataActualiza)
    {
        $salida = $this->ci->dbGeneral->cambioContrasena($where,$dataActualiza);
        if(count($salida) > 0)
        {
            $respuesta = array("mensaje"=>"La contraseña ha sido cambiada de manera exitosa",
                              "continuar"=>1,
                              "datos"=>$salida);            
        }
        else
        {
            $respuesta = array("mensaje"=>"La contraseña no ha podido ser cambiada, por favor intente de nuevo más tarde",
                              "continuar"=>0,
                              "datos"=>"");    

        }
        return $respuesta;
    }
    public function consultaConjuntos($where=array())
    {
        $conjuntos = $this->ci->dbGeneral->consultaConjuntos($where);
        if(count($conjuntos) > 0)
        {
            $respuesta = array("mensaje"=>"Listado de conjuntos",
                              "continuar"=>1,
                              "datos"=>$conjuntos);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No existen conjuntos",
                              "continuar"=>0,
                              "datos"=>"");    

        }
        return $respuesta;
    }
    public function getPresentacionesProductoVendedor($where_in=array(),$campo='')
    {
        $presentaciones = $this->ci->dbGeneral->getPresentacionesProductoVendedor($where_in,$campo);
        $productoInfo   = $this->ci->dbGeneral->getProductosVendedor();
        if(count($presentaciones) > 0)
        {
            $respuesta = array("mensaje"=>"Listado de presentaciones",
                              "continuar"=>1,
                              "datos"=>$presentaciones,
                              "infoProducto"=>$productoInfo[0]);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No existen presentaciones",
                              "continuar"=>0,
                              "datos"=>"",
                              "infoProducto"=>$productoInfo[0]);    

        }
        return $respuesta;
    }
    public function getPresentacionesProducto($where=array(),$campo='')
    {
        $presentaciones = $this->ci->dbGeneral->getPresentacionesProducto($where,$campo);
        $productoInfo   = $this->ci->dbGeneral->getProductos(array("idProducto"=>$where['pre.idProducto']));
        if(count($presentaciones) > 0)
        {
            $respuesta = array("mensaje"=>"Listado de presentaciones",
                              "continuar"=>1,
                              "datos"=>$presentaciones,
                              "infoProducto"=>$productoInfo[0]);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No existen presentaciones",
                              "continuar"=>0,
                              "datos"=>"",
                              "infoProducto"=>$productoInfo[0]);    

        }
        return $respuesta;
    }
    public function getPersonasPorPerfil($idPerfil)
    {
        $personas = $this->ci->dbGeneral->getPersonasClientes(array("idPerfil"=>$idPerfil));
        if(count($personas) > 0)
        {
            $respuesta = array("mensaje"=>"Listado de personas por perfil",
                              "continuar"=>1,
                              "datos"=>$personas);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No hay personas con este perfil",
                              "continuar"=>0,
                              "datos"=>"");    

        }
        return $respuesta;
    }

    public function insertaPedidoCliente($post)
    {
        //var_dump($_POST);die();
        ini_set('display_errors',0);
        $pedido['fechaPedido']  = date("Y-m-d H:i:s");
        $pedido['ip']           = getIP();
        $pedido['idPersona']    = $post['idPersona'];
        $pedido['valor']        = $post['totalCompra'];
        $pedido['valorDomicilio']  = $post['valorDomicilio'];
        $pedido['direccion']      = (isset($post['direccion']))?$post['direccion']:"";
        $pedido['telefono']      = (isset($post['telefono']))?$post['telefono']:"";
        $pedido['codigoPedido'] = generacodigo(10);
        $pedido['formaPago']    = $post['formaPago'];
        $pedido['idTienda']       = $post['idTienda'];
        //$pedido['eliminado']       = 0;
        $pedido['estadoPago']     = (isset($post['estadoPago']))?$post['estadoPago']:"";
        $pedido['transactionId']  = (isset($post['transactionId']))?$post['transactionId']:"";
        $pedido['reference_pol']  = (isset($post['reference_pol']))?$post['reference_pol']:"";
        $pedido['moneda']         = (isset($post['moneda']))?$post['moneda']:"";
        $pedido['entidad']        = (isset($post['entidad']))?$post['entidad']:"";
        
        $informacionUsuario     = $this->ci->dbGeneral->getInfoPersonas(array("idPersona"=>$post['idPersona']));
        
        $infoTienda             = $this->ci->dbGeneral->getInfoTienda(array("idTienda"=>$post['idTienda']));
        //$infoConjunto           = $this->ci->dbGeneral->consultaConjuntos(array("idConjunto"=>$informacionUsuario[0]['idConjunto'])); 

        //calcula la ester a la que le debe enviar el pedido
        //$calculaMiEster = $this->ci->dbGeneral->getInfoPersonas(array("idConjunto"=>$informacionUsuario[0]['idConjunto'],"idPerfil"=>_PERFIL_VENDEDOR,"estado"=>1,"eliminado"=>0));

        //traigo a la respectiva ester pero de la relacion de conjuntos.
        $calculaMiEster = $this->ci->dbGeneral->getInfoPersonas(array("idPersona"=>$informacionUsuario[0]['idPadre']));
        // $calculaMiEster = $this->ci->dbGeneral->getVendedoraConjunto(array("r.idConjunto"=>$informacionUsuario[0]['idConjunto']));
        //var_dump($calculaMiEster);die();
        $pedido['pedidoPara'] = _ID_USUARIO_ADMIN;
        //llamo la función que inserta el pedido
        $idPedido = $this->ci->dbGeneral->insertaPedido($pedido);
        //consulto los productos del pedido temporal
        $where['identificador'] = $post['identificador'];
        $productosTemporal = $this->ci->dbPedidos->getPedidoTemporal($where);
        //inserto los productos
        $contador = 0;
        foreach($productosTemporal as $prod)
        {
            $productoVar['idPedido']        = $idPedido;
            $productoVar['idProducto']      = $prod['idProducto'];
            $productoVar['idPresentacion']  = $prod['idPresentacion'];
            $productoVar['cantidad']        = $prod['cantidad'];
            $productoVar['idPersona']       = $post['idPersona'];
            //inserto detalle del producto
            $detProducto = $this->ci->dbGeneral->insertaDetalleProducto($productoVar);
            $contador++;
        }

        //verifico
        if($contador == count($productosTemporal))
        {
            $respuesta = array("mensaje"=>lang("lbl_pedidoReg").":<br><h2>".$idPedido."</h2>",
                              "continuar"=>1,
                              "datos"=>$idPedido);   

            $asuntoMensaje = "Nuevo pedido ".NOMBRE_APP;
            $mensajeenviar  = lang("lbl_saludo_pedido")."<br><br>";

            $mensajeenviar .= "<h2>".lang("lbl_customer_data")."</h2>";
            $mensajeenviar .= lang("lbl_nombre")." ".$informacionUsuario[0]['nombre']." ".$informacionUsuario[0]['apellido']."<br>";
            $mensajeenviar .= lang("lbl_telefono")." ".$informacionUsuario[0]['celular']."<br>";
            $mensajeenviar .= lang("lbl_direccion")." ".$informacionUsuario[0]['direccion']."<br>";
            $mensajeenviar .= "<h2>".lang("lbl_productos_solicitados")."</h2>";
            $sumaTotal  = 0;
           // echo "sdsdsdssdsdsd";
            foreach($productosTemporal as $prod2)
            {
                $sumaTotal += ($prod2['valor'] * $prod2['cantidad']);
                $mensajeenviar .= $prod2['nombrePresentacion']." ".lang("lbl_cantidad").": ".$prod2['cantidad']."Kgs<br>";

            }

            $mensajeenviar .= "<h2>".lang("lbl_total_pedido")."</h2>";
            $mensajeenviar .= "<h4>".$infoTienda[0]['currency'].number_format($sumaTotal,0,",",".")."</h4>";
            //debo notificar al administrador de la plataforma que llegó un pedido
            $mensaje = plantillaMail($mensajeenviar);
            sendMail($infoTienda[0]['correo_tienda'],$asuntoMensaje,$mensaje);

            //notifico a ester por medio de mensaje de texto
            //$mensajeDeTexto = "Esmeralda:  Hola: ".$calculaMiEster[0]['nombre']." ".$calculaMiEster[0]['apellido'].", Se ha realizado un nuevo pedido con el id: ".$idPedido.", debes revisar en la app.";
            //envio SMS para avisarle a Ester que debe de estar pendiende de dar el obsequi al usuario que se acaba de registrar
            //sendSms(_REMITE_SMS,"57".$calculaMiEster[0]['celular'],$mensajeDeTexto);

            //debo borrar el pedido temporal
            $borroPedidoTemporal = $this->ci->dbPedidos->borraPedidoTemporal(array('identificador'=>$post['identificador']));
        }
        else
        {
            $respuesta = array("mensaje"=>lang("lbl_pedidoNoReg"),
                               "continuar"=>0,
                               "datos"=>"");    

        }

        return $respuesta;

    }

    public function insertaPedidoVendedores($post)
    {
        $pedido['fechaPedido']  = date("Y-m-d H:i:s");
        $pedido['ip']           = getIP();
        $pedido['idPersona']    = $post['idPersona'];
        $pedido['valor']        = $post['totalCompra'];
        $pedido['codigoPedido'] = generacodigo(10);
        $pedido['formaPago']    = $post['formaPago'];
        $informacionUsuario = $this->ci->dbGeneral->getInfoPersonas(array("idPersona"=>$post['idPersona']));
        //calcula la ester a la que le debe enviar el pedido
        
        if($informacionUsuario[0]['idPerfil'] == _PERFIL_VENDEDOR)//cuando ester haga un pedido se lo debe enviar a su respectivo raul
        {
            $calculaMiEster = $this->ci->dbGeneral->getInfoPersonas(array("idPersona"=>$informacionUsuario[0]['idPadre'],"estado"=>1,"eliminado"=>0));
            $pedido['pedidoPara'] = $calculaMiEster[0]['idPersona'];
            $enviarNotificaciones = 1;
        }
        else if($informacionUsuario[0]['idPerfil'] == _PERFIL_ADMIN_VENTAS)//cuando raul haga el pedido le debe llegar a esmeralda.
        {
            $calculaMiEster = $this->ci->dbGeneral->getInfoPersonas(array("idPersona"=>_ID_USUARIO_ADMIN,"estado"=>1,"eliminado"=>0));
            //$pedido['pedidoPara'] = $calculaMiEster[0]['idPersona'];
            $pedido['pedidoPara'] = 0;

            $usuariosAdmin  = $this->ci->dbGeneral->getInfoPersonas(array("idPerfil"=>2,"estado"=>1,"eliminado"=>0));
            $usuariosSuperAdmin  = $this->ci->dbGeneral->getInfoPersonas(array("idPerfil"=>2,"estado"=>1,"eliminado"=>0));
            $enviarNotificaciones = 2;
        }   


        //llamo la función que inserta el pedido
        $idPedido = $this->ci->dbGeneral->insertaPedido($pedido);
        //consulto los productos del pedido temporal
        $where['identificador'] = $post['identificador'];
        $productosTemporal = $this->ci->dbPedidos->getPedidoTemporal($where);
        //inserto los productos
        $contador = 0;
        foreach($productosTemporal as $prod)
        {
            $productoVar['idPedido']        = $idPedido;
            $productoVar['idProducto']      = $prod['idProducto'];
            $productoVar['idPresentacion']  = $prod['idPresentacion'];
            $productoVar['cantidad']        = $prod['cantidad'];
            $productoVar['idPersona']       = $post['idPersona'];
            //inserto detalle del producto
            $detProducto = $this->ci->dbGeneral->insertaDetalleProducto($productoVar);
            $contador++;
        }

        //verifico
        if($contador == count($productosTemporal))
        {
            $respuesta = array("mensaje"=>"El pedido se ha registrado de manera exitosa. Su número de pedido es el:<br><h2>".$idPedido."</h2>",
                              "continuar"=>1,
                              "datos"=>$idPedido);   

            $asuntoMensaje = "Nuevo pedido desde Esmeralda App";
            $mensajeenviar  = "Hola, ha llegado un nuevo pedido de producto con la siguiente información<br><br>";

            $mensajeenviar .= "<h2>DATOS DEL CLIENTE</h2>";
            $mensajeenviar .= "Nombre: ".$informacionUsuario[0]['nombre']." ".$informacionUsuario[0]['apellido']."<br>";
            $mensajeenviar .= "Teléfonos: ".$informacionUsuario[0]['celular']."<br>";
            $mensajeenviar .= "<h2>PRODUCTOS SOLICITADOS</h2>";
            $sumaTotal  = 0;
           // echo "sdsdsdssdsdsd";
            foreach($productosTemporal as $prod2)
            {
                $sumaTotal += ($prod2['valor'] * $prod2['cantidad']);
                $mensajeenviar .= $prod2['nombrePresentacion']." Cantidad: ".$prod2['cantidad']."Kgs<br>";

            }

            $mensajeenviar .= "<h2>TOTAL DEL PEDIDO</h2>";
            $mensajeenviar .= "<h4>$".number_format($sumaTotal,0,",",".")."</h4>";
            //envio un mensaje al administrador general
            $mensaje = plantillaMail($mensajeenviar);
            sendMail(_ADMIN_PEDIDOS,$asuntoMensaje,$mensaje);

            if($enviarNotificaciones == 1)//envios para RAUL unicamente
            {
                //debo notificar al administrador de la plataforma que llegó un pedido
                sendMail($calculaMiEster[0]['email'],$asuntoMensaje,$mensaje);

                //notifico a ester por medio de mensaje de texto
                $mensajeDeTexto = "Esmeralda:  Hola: ".$calculaMiEster[0]['nombre']." ".$calculaMiEster[0]['apellido'].", Se ha realizado un nuevo pedido con el id: ".$idPedido.", debes revisar en la app.";
                //envio SMS para avisarle a Ester que debe de estar pendiende de dar el obsequi al usuario que se acaba de registrar
                sendSms(_REMITE_SMS,"57".$calculaMiEster[0]['celular'],$mensajeDeTexto);
            }
            else if($enviarNotificaciones == 2)//enviar a los admins
            {
                //notifico a los usuarios admin
                foreach($usuariosAdmin as $adminU)
                {
                    //sendMail(_ADMIN_PEDIDOS,$asuntoMensaje,$mensaje);
                    sendMail($adminU['email'],$asuntoMensaje,$mensaje);
                    //notifico a ester por medio de mensaje de texto
                    $mensajeDeTexto = "Esmeralda:  Hola: ".$adminU['nombre']." ".$adminU['apellido'].", Se ha realizado un nuevo pedido con el id: ".$idPedido.", debes revisar en la plataforma administrativa.";
                    //envio SMS para avisarle a Ester que debe de estar pendiende de dar el obsequi al usuario que se acaba de registrar
                    sendSms(_REMITE_SMS,"57".$adminU['celular'],$mensajeDeTexto);
                }
            }



            //debo borrar el pedido temporal
            $borroPedidoTemporal = $this->ci->dbPedidos->borraPedidoTemporal(array('identificador'=>$post['identificador']));
        }
        else
        {
            $respuesta = array("mensaje"=>"El pedido no pudo ser registrado de manera exitos, por favor intente de nuevo más tarde.",
                              "continuar"=>0,
                              "datos"=>"");    

        }

        return $respuesta;

    }



    public function insertaPedido($post)
    {
        //ini_set('displa_errors');
        //primero inserto el pedido y luego el detalle
        $pedido['fechaPedido'] = date("Y-m-d H:i:s");
        $pedido['ip']          = getIP();
        $pedido['idPersona']   = $post['usuario'];
        $pedido['valor']       = $post['totalCompra'];
        $pedido['codigoPedido']       = generacodigo(10);
        $pedido['formaPago']         = $post['formaPago'];

        $informacionUsuario = $this->ci->dbGeneral->getInfoPersonas(array("idPersona"=>$post['usuario']));
        //depende del pedido asigno pa persona a la que le debe llegar el pedido
        if($post['perfil'] == _PERFIL_VENDEDOR)//si es un perfil ester
        {
            //la persona que recibe el pedido debe der su respectivo Raul, osea el idPersonaPadre
            $pedido['pedidoPara'] = $informacionUsuario[0]['idPadre'];
        }
        else if($post['perfil'] == _PERFIL_COMPRADOR) //si es un perfil comprador
        {
            //la persona que recibe el pedido es la respectiva vendedora del conjunto residencial.
            //debo calcular la persona de perfil ester segun el conjunto residencial que tenga.
            $calculaMiEster = $this->ci->dbGeneral->getInfoPersonas(array("idConjunto"=>$informacionUsuario[0]['idConjunto'],"idPerfil"=>_PERFIL_VENDEDOR,"estado"=>1,"eliminado"=>0));

            $pedido['pedidoPara'] = $calculaMiEster[0]['idPersona'];
        }
        //llamo la función que inserta el pedido
        $idPedido = $this->ci->dbGeneral->insertaPedido($pedido);
        //ahora que tengo el id del pedido inserto el detalle
        $contador = 0;
        foreach($post['productos'] as $prod)
        {
            $productoVar['idPedido']    = $idPedido;
            $productoVar['idProducto']  = $prod['idProducto'];
            $productoVar['idPresentacion']  = $prod['idPresentacion'];
            $productoVar['cantidad']    = $prod['cantidad'];
            $productoVar['idPersona']   = $post['usuario'];
            //inserto detalle del producto
            $detProducto = $this->ci->dbGeneral->insertaDetalleProducto($productoVar);
            $contador++;
        }
        //ini_set("display_errors",1);
        if($contador == count($post['productos']))
        {
            $respuesta = array("mensaje"=>"El pedido se ha registrado de manera exitosa. Su número de pedido es el:<br><h2>".$idPedido."</h2>",
                              "continuar"=>1,
                              "datos"=>$idPedido);            
            $asuntoMensaje = "Nuevo pedido de Esmeralda App";
            $mensajeenviar  = "Hola, ha llegado un nuevo pedido de producto con la siguiente información<br><br>";

            $mensajeenviar .= "<h2>DATOS DEL CLIENTE</h2>";
            $mensajeenviar .= "Nombre: ".$informacionUsuario[0]['nombre']." ".$informacionUsuario[0]['apellido']."<br>";
            $mensajeenviar .= "Teléfonos: ".$informacionUsuario[0]['telefono']." - ".$informacionUsuario[0]['celular']."<br>";
            $mensajeenviar .= "<h2>PRODUCTOS SOLICITADOS</h2>";
            $sumaTotal  = 0;
           // echo "sdsdsdssdsdsd";
            foreach($post['productos'] as $prod2)
            {
                $infoProducto = $this->ci->dbGeneral->getPresentacionesProducto(array("pre.idProducto"=>$prod2['idProducto']));
                $sumaTotal += ($infoProducto[0]['valorKilo'] * $prod2['cantidad']);
                $mensajeenviar .= $infoProducto[0]['nombreProducto']." Cantidad: ".$prod2['cantidad']."Kgs<br>";

            }

            $mensajeenviar .= "<h2>TOTAL DEL PEDIDO</h2>";
            $mensajeenviar .= "<h4>$".number_format($sumaTotal,0,",",".")."</h4>";
            //debo notificar al administrador de la plataforma que llegó un pedido
            $mensaje = plantillaMail($mensajeenviar);
            sendMail(_ADMIN_PEDIDOS,$asuntoMensaje,$mensaje);
            //debo notificar a la respectiva ester
            sendMail($calculaMiEster[0]['email'],$asuntoMensaje,$mensaje);

        }
        else
        {
            $respuesta = array("mensaje"=>"El pedido no pudo ser registrado de manera exitos, por favor intente de nuevo más tarde.",
                              "continuar"=>0,
                              "datos"=>"");    

        }

        return $respuesta;
    }
    public function guardaPedido($post)
    {
        //lo primero que hago es insertar un pedido con la informacion basica del mismo
        $dataPedido['fechaPedido']  = date("Y-m-d h:i:s");
        $dataPedido['idPersona']    = $_SESSION['project']['info']['idPersona'];
        $dataPedido['idPersona']    = $_SESSION['project']['info']['idPersona'];
        $dataPedido['pedidoPara']   = 0;
        $dataPedido['ip']           = getIP();
        $dataPedido['formaPago']    = $post['formaPago'];
        $dataPedido['valor']        = $post['valor'];
        $dataPedido['codigoPedido'] = $_SESSION['refPedido'];
        $dataPedido['estadoPago']   = '000';
        //llamo la funcion que inserta el pedido
        $idPedido = $this->ci->dbGeneral->insertaPedido($dataPedido);
        if($idPedido > 0)
        {
            $contador = 0;
            foreach($_SESSION['pedido'] as $prod)
            {
                foreach($prod as $pres)
                {
                    $productoVar['idPedido']        = $idPedido;
                    $productoVar['idProducto']      = $pres['idProducto'];
                    $productoVar['idPresentacion']  = $pres['idPresentacion'];
                    $productoVar['cantidad']        = $pres['cantidad'];
                    //inserto detalle del producto
                    $detProducto = $this->ci->dbGeneral->insertaDetalleProducto($productoVar);
                    $contador++;
                }
            }
        }
        //valido para retornar
        $salida = array("mensaje"=>"Pedido realizado de manera exitosa, el número de pedido es: <br><h2>".$idPedido."</h2>",
                        "continuar"=>1,
                        "codigoPedido"=>$_SESSION['refPedido'],
                        "idPedido"=>$idPedido);
        return $salida;
    }
    public function actualizaPedido($data,$where)
    {
        $actualizaPedido = $this->ci->dbGeneral->actualizaPedido($data,$where);
    }
    public function insertaSolicitud($post)
    {
        $pedido = $this->ci->dbGeneral->insertaSolicitud($post);
        if(count($pedido) > 0)
        {
            $respuesta = array("mensaje"=>"El pedido se ha registrado de manera exitosa, el nro de pedido es el: <strong>".$pedido."</strong>. Debe realizar el pago del pedido en las próximas 24 horas vía Baloto, Efecty o consignación bancaria.",
                              "continuar"=>1,
                              "datos"=>array());            
        }
        else
        {
            $respuesta = array("mensaje"=>"No se ha podido realizar el pedido, intente denuevo más tarde",
                              "continuar"=>0,
                              "datos"=>"");    

        }
        return $respuesta;
    }
    public function getDepartamentos($where,$group=false)
    {
        $listaCiudades = $this->ci->dbGeneral->getDepartamentos($where);
        if(count($listaCiudades) > 0)
        {
            $respuesta = array("mensaje"=>"Listado de ciudades",
                              "continuar"=>1,
                              "datos"=>$listaCiudades);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No existen ciudades",
                              "continuar"=>0,
                              "datos"=>"");    

        }
        return $respuesta;
    }
    //consulto el listado de módulos de base de datos
    public function getModulos()
    {
        $listaModulos        = array();
        $where['r.idPerfil'] = $_SESSION['project']['info']['idPerfil'];
        $where['r.ver']      = 1;
        $where['m.estado']   = 1;
        $modulos             = $this->ci->dbGeneral->getDistCatModuloModulos($where);
        foreach($modulos as $m)
        {
            $modWhereIn[] = $m['idPadre'];
        }
        $modulosReal         = $this->ci->dbGeneral->getModulosIn($modWhereIn);
        //var_dump($modulosReal);
        //recorro las categorias de los módulos
        foreach($modulosReal as $mod)
        {
            $where['r.idPerfil']  = $_SESSION['project']['info']['idPerfil'];
            $where['m.idPadre']   = $mod['idModulo'];
            $where['m.estado']    = 1;
            $where['m.eliminado'] = 0;
            $modulosHijos        = $this->ci->dbGeneral->getModulos($where);
           
            //capturo la info del módulo
            $infoModulo          = $this->ci->dbGeneral->infoModulo(array("idModulo"=>$mod['idModulo']));
            $salidaParcial       = array("idPadre"=>$mod['idModulo'],
                                         "nombreModulo"=>$infoModulo[0]['nombreModulo'],
                                         "icono"=>$infoModulo[0]['icono'],
                                         "modulos"=>$modulosHijos);
            array_push($listaModulos,$salidaParcial);
        }
        return $listaModulos;
    }
    //consulto el listado de módulos de base de datos
    public function getModulosCompletos($padre)
    {
        $listaModulos        = array();
        $where['idPadre']    = $padre;
        //$where['estado']     = 1;
        $where['eliminado']  = 0;
        $modulos             = $this->ci->dbGeneral->infoModulo($where);
        //recorro las categorias de los módulos
        foreach($modulos as $mod)
        {
            $whereH['idPadre']      = $mod['idModulo'];
            //$whereH['estado']     = 1;
            $whereH['eliminado']  = 0;
            $modulosHijos        = $this->ci->dbGeneral->infoModulo($whereH);
            //capturo la info del módulo
            $salidaParcial       = array("idPadre"=>$mod['idModulo'],
                                         "nombreModulo"=>$mod['nombreModulo'],
                                         "icono"=>$mod['icono'],
                                         "estado"=>$mod['estado'],
                                         "eliminado"=>$mod['eliminado'],
                                         "modulos"=>$modulosHijos);
            array_push($listaModulos,$salidaParcial);
        }
        return $listaModulos;
    }
    public function infoModulo($idModulo)
    {
        $infoModulo          = $this->ci->dbGeneral->infoModulo(array("idModulo"=>$idModulo));
        return $infoModulo;
    }
    public function consultaPerfiles($where=array())
    {
        $where['estado']    = 1;
        $perfiles          = $this->ci->dbGeneral->consultaPerfiles($where);
        return $perfiles;
    }
    public function consultatiposDoc()
    {
        $where['estado']    = 1;
        $perfiles          = $this->ci->dbGeneral->consultatiposDoc($where);
        return $perfiles;
    }
    public function consultaSexo()
    {
        $where['estado']    = 1;
        $sexo          = $this->ci->dbGeneral->consultaSexo($where);
        return $sexo;
    }
    public function consultaProfesiones()
    {
        $where['estado']    = 1;
        $profesiones          = $this->ci->dbGeneral->consultaProfesiones($where);
        return $profesiones;
    }
    public function consultaCargos()
    {
        $where['estado']    = 1;
        $cargos          = $this->ci->dbGeneral->consultaCargos($where);
        return $cargos;
    }
    public function consultaAreas()
    {
        $where['estado']    = 1;
        $areas          = $this->ci->dbGeneral->consultaAreas($where);
        return $areas;
    }
    public function consultaCiudades()
    {
        $where['ID_PAIS']    = '057';
        $ciudades          = $this->ci->dbGeneral->getCiudades($where);
        return $ciudades;   
    }

    public function consultaEPS()
    {
        $where['estado']    = '1';
        $resultado          = $this->ci->dbGeneral->consultaEPS($where);
        return $resultado; 
    }
    public function consultaAFP()
    {
        $where['estado']    = '1';
        $resultado          = $this->ci->dbGeneral->consultaAFP($where);
        return $resultado; 

    }
    public function consultaCesantias()
    {
        $where['estado']    = '1';
        $resultado          = $this->ci->dbGeneral->consultaCesantias($where);
        return $resultado; 
    }
    public function consultaAseguradoras()
    {
        $where['estado']    = '1';
        $resultado          = $this->ci->dbGeneral->consultaAseguradoras($where);
        return $resultado; 
    }
    public function consultaOcupaciones()
    {
        $where['estado']    = '1';
        $resultado          = $this->ci->dbGeneral->consultaOcupaciones($where);
        return $resultado; 
    }
    public function consultaEstadoCivil()
    {
        $where['estado']    = '1';
        $resultado          = $this->ci->dbGeneral->consultaEstadoCivil($where);
        return $resultado; 
    }
    public function consultaEscolaridad()
    {
        $where['estado']    = '1';
        $resultado          = $this->ci->dbGeneral->consultaEscolaridad($where);
        return $resultado; 
    }
    public function consultaReligiones()
    {
        $where['estado']    = '1';
        $resultado          = $this->ci->dbGeneral->consultaReligiones($where);
        return $resultado; 
    }
    public function consultaGrupoEtnico()
    {
        $where['estado']    = '1';
        $resultado          = $this->ci->dbGeneral->consultaGrupoEtnico($where);
        return $resultado; 
    }
    public function getServicios()
    {
        $where['estado']    = '1';
        $where['especialista']    = '1';
        $resultado          = $this->ci->dbGeneral->getServicios($where);
        //var_dump($resultado);
        return $resultado; 
    }
    public function getServiciosQuery($where)
    {
        $resultado          = $this->ci->dbGeneral->getServicios($where);
        //var_dump($resultado);
        return $resultado; 
    }
    public function getEstadosPedido($where=array())
    {
        $resultado          = $this->ci->dbGeneral->getEstadosPedido($where);
        //var_dump($resultado);
        return $resultado; 
    }
    public function getPersonas($where)
    {
        $resultado          = $this->ci->dbGeneral->getInfoPersonas($where);
        //var_dump($resultado);
        return $resultado; 
    }
    public function getPersonasTienda($where)
    {
        $resultado          = $this->ci->dbGeneral->getPersonasTienda($where);
        //var_dump($resultado);
        return $resultado; 
    }
    public function getPersonasCruce($where)
    {
        $resultado          = $this->ci->dbGeneral->getInfoPersonasCruce($where);
        //var_dump($resultado);
        return $resultado; 
    }
    public function consultaCieDiez($where,$like)
    {
        $resultado          = $this->ci->dbGeneral->consultaCieDiez($where,$like);
        //var_dump($resultado);
        return $resultado; 
    }
    public function informeVentas($where=array())
    {
        $resultado          = $this->ci->dbPedidos->informeVentas($where);
        //var_dump($resultado);
        return $resultado; 
    }
    public function especialistasServicio($post)
    {
        extract($post);
        $where['rs.idServicio']    = $idServicio;
        $where['p.estado']         = '1';
        $resultado          = $this->ci->dbGeneral->especialistasServicio($where);
        return $resultado; 
    }
    public function getCiudadesVentas()
    {
        //extract($post);
        $resultado = $this->ci->dbGeneral->getCiudadesVentas();
        $respuesta = array("mensaje"=>"Listado de ciudades",
                              "continuar"=>1,
                              "datos"=>$resultado);   
        return $respuesta; 
    }
    public function getInfoTienda()
    {
        //extract($post);
        $resultado = $this->ci->dbGeneral->getInfoTienda();
        $respuesta = array("mensaje"=>"Info tienda",
                              "continuar"=>1,
                              "datos"=>$resultado);   
        return $respuesta; 
    }

    public function getInfoTiendaNew($idTienda)
    {
        $resultado = $this->ci->dbGeneral->getInfoTiendaNew(array("t.idTienda"=>$idTienda));
        $respuesta = array("mensaje"=>"Info tienda",
                              "continuar"=>1,
                              "datos"=>$resultado);   
        return $respuesta; 
    }

    public function consultaPerfilesPersist($id)
    {
        $salidaPerf = array();
        $where['estado']     = 1;
        $where['eliminado']  = 0;
        $perfiles            = $this->ci->dbGeneral->consultaPerfiles($where);
        //recorro los perfiles y verifico 
        foreach($perfiles as $per)
        {
            $wherePerfiles['idModulo']  =   $id;
            $wherePerfiles['idPerfil']  =   $per['idPerfil'];
            //verifico los privilegios si el perfil tiene asignado este módulo
            $relacionPerfMod    =   $this->ci->dbGeneral->consultaRelacionPerfil($wherePerfiles);
            //var_dump($relacionPerfMod[0]);
            $dataRecorre = array("idPerfil"=>$per['idPerfil'],
                                 "nombrePerfil"=>$per['nombrePerfil'],
                                 "ver"=>(count($relacionPerfMod) > 0)?$relacionPerfMod[0]['ver']:"0",
                                 "crear"=>(count($relacionPerfMod) > 0)?$relacionPerfMod[0]['crear']:"0",
                                 "editar"=>(count($relacionPerfMod) > 0)?$relacionPerfMod[0]['editar']:"0",
                                 "borrar"=>(count($relacionPerfMod) > 0)?$relacionPerfMod[0]['borrar']:"0");
            array_push($salidaPerf,$dataRecorre);
        }
        //var_dump($salidaPerf);
        return $salidaPerf;
    }


    
    public function consultatiendas($where=array())
    {
        $conjuntos = $this->ci->dbGeneral->consultatiendas($where);
        if(count($conjuntos) > 0)
        {
            $respuesta = array("mensaje"=>"Listado de tiendas",
                              "continuar"=>1,
                              "datos"=>$conjuntos);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No existen tiendas",
                              "continuar"=>0,
                              "datos"=>"");    

        }
        return $respuesta;
    }
    public function insertaComentario($post)
    {
        extract($post);
        $dataComentario['idTienda']         = $idTienda;
        $dataComentario['idPresentacion']   = $idPresentacion;
        $dataComentario['idUsuario']        = $idPersona;
        $dataComentario['comentario']       = $comentario;
        $dataComentario['ip']               = getIP();
        $dataComentario['fechaComentario']  = date("Y-m-d H:m:s");
        $dataComentario['estado']           = 1;
        $dataComentario['eliminado']        = 0;
        //lo primero que hago es insertar el comentario
        $insertaComentario = $this->ci->dbGeneral->insertaComentario($dataComentario);
        if($insertaComentario > 0)
        {
            //procedo a relacionar en la tabla de comentarios lo que ha insertado el usuario
            $dataRel['idTienda']         = $idTienda;
            $dataRel['idPresentacion']   = $idPresentacion;
            $dataRel['idComentario']     = $insertaComentario;
            $dataRel['idUsuario']        = $idPersona;
            $dataRel['calificacion']     = $calificacion;
            $dataRel['estado']           = 1;
            $dataRel['eliminado']        = 0;
            $relUsuario = $this->ci->dbGeneral->relacionVotoUsuario($dataRel);
            if($relUsuario > 0)
            {
                //obtengo la información de la prenda antes de insertarla, esto porque puede que en el momento que este procesando alguien más haya sumado un voto
                $infoPresentacion = $this->ci->dbGeneral->getPresentacionesProducto(array("pre.idPresentacion"=>$idPresentacion));
                //armo lo que voy a actualizar
                $dataPresentacion['puntos']     = ($infoPresentacion[0]['puntos'] + $calificacion);
                $dataPresentacion['votantes']   = ($infoPresentacion[0]['votantes'] + 1);
                //acualizo
                $actualizaProducto = $this->ci->dbGeneral->actualizoPresentacion($dataPresentacion,array("idPresentacion"=>$idPresentacion));
                if($actualizaProducto > 0)
                {
                    //actualizo el producto para sumarle los votos
                    //$respuesta = array("mensaje"=>"Your rating and comment have been successfully saved. Thank you very much!",
                    $respuesta = array("mensaje"=>"Su calificación y comentario se han guardado con éxito. ¡Muchos gracias!",
                                        "continuar"=>1,
                                        "datos"=>array()); 
                }  
                else
                {
                    //actualizo el producto para sumarle los votos
                    $respuesta = array("mensaje"=>"No se ha podido actualizar la prenda",
                                        "continuar"=>0,
                                        "datos"=>array()); 

                }
            }

        }
        else
        {
            $respuesta = array("mensaje"=>"No existen tiendas",
                              "continuar"=>0,
                              "datos"=>"");    

        }
        return $respuesta;

    }

    //8 nuevas presentaciones
    public function getInfoPresentacionNew($where)
    {
        $resultado = $this->ci->dbGeneral->getInfoPresentacionNew($where);
        $respuesta = array("mensaje"=>"Infotmacion de los nuevos productos",
                              "continuar"=>1,
                              "datos"=>$resultado);   
        return $respuesta; 
    }

    //get comentarios
    public function getInforComentarios($where)
    {
        $noti = $this->ci->dbGeneral->getInforComentarios($where);
        if(count($noti) > 0)
        {
            $respuesta = array("mensaje"=>"Listado de Comentarios",
                              "continuar"=>1,
                              "datos"=>$noti);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No existen Comentarios",
                              "continuar"=>0,
                              "datos"=>"");    
        }
        return $respuesta;
    }
    //get ciudades
    public function getInfoCiudades($where)
    {
        $noti = $this->ci->dbGeneral->getInfoCiudades($where);
        if(count($noti) > 0)
        {
            $respuesta = array("mensaje"=>"Listado de Ciudades",
                              "continuar"=>1,
                              "datos"=>$noti);            
        }
        else
        {
            $respuesta = array("mensaje"=>"No existen Ciudades",
                              "continuar"=>0,
                              "datos"=>"");    

        }
        return $respuesta;
    }
    //info tienda por ciudades
    public function infoTiendaUrl($where)
    {
        //extract($post);
        $resultado = $this->ci->dbGeneral->infoTiendaUrl($where);
        $respuesta = array("mensaje"=>"Info tienda por url",
                              "continuar"=>1,
                              "datos"=>$resultado);   
        return $respuesta; 
    }
    // tipo de documento
    public function InfoDocumentos(){
        $where['estado']        = 1;
        $resultado = $this->ci->dbGeneral->InfoDocumentos($where);
        $respuesta = array("mensaje"=>"Informacion de tipo documentos",
                              "continuar"=>1,
                              "datos"=>$resultado);   
        return $respuesta;
    }
    // tipo tienda
    public function infoTipoTienda(){
        $where['eliminado']        = 0;
        $resultado = $this->ci->dbGeneral->infoTipoTienda($where);
        $respuesta = array("mensaje"=>"Informacion del tipo tienda disponible",
                              "continuar"=>1,
                              "datos"=>$resultado);   
        return $respuesta;
    }
    // actualizacion automatica mantenimiento
    public function caducarTiendas($idEstado){
        //extract($_POST)
        $where['idEstado']        = $idEstado;
        $resultado = $this->ci->dbGeneral->caducarTiendas($where);
        $respuesta = array("mensaje"=>"todas las tiendas obtenidas",
                              "continuar"=>1,
                              "datos"=>$resultado);   
        return $respuesta;
    }
    //actualiza mantenimiento
    public function actualizaMantenimiento($tienda)
    {
        $where = $tienda;
        //var_dump($where);die();
        $dataActualiza['manteminiento'] = 1;
        $dataActualiza['caduca'] = 1;
        $response = $this->ci->dbGeneral->actualizaMiTienda($where,$dataActualiza);
        if($response > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");
        }
        return $respuesta;
    }
    //informacion de todas las tiendas
    public function getInfoTiendas($urlAmigable){
        //extract($_POST)
        $where['urlAmigable']        = $urlAmigable;
        $resultado = $this->ci->dbGeneral->getInfoTiendas($where);
        $respuesta = array("mensaje"=>"todas las tiendas obtenidas",
                              "continuar"=>1,
                              "datos"=>$resultado);   
        return $respuesta;
    }
    //logica insert historial membrecia
    public function insertdata($dataInserta){
        //extract($_POST)
        $resultado = $this->ci->dbGeneral->insertdata($dataInserta);
        $respuesta = array("mensaje"=>"todas las tiendas obtenidas",
                              "continuar"=>1,
                              "datos"=>$resultado);   
        return $respuesta;
    }
    //verificacion si email existe
    public function getEmail($email){
        //extract($_POST)
        $where['email']        = $email;
        $resultado = $this->ci->dbGeneral->getEmail($where);
        $respuesta = array("mensaje"=>"todos los email obtenidos",
                              "continuar"=>1,
                              "datos"=>$resultado);   
        return $respuesta;
    }
    //se obtienen los datos de creador de la tienda por el id
    public function getCreadorTienda($idPersona){
        // var_dump($idPersona);die();
        $where['idPersona']        = $idPersona;
        $resultado = $this->ci->dbGeneral->getCreadorTienda($where);
        $respuesta = array("mensaje"=>"todos los datos obtenidos",
                            "continuar"=>1,
                            "datos"=>$resultado);   
        return $respuesta;
    }
    //se obtiene informacion del login por el email
    public function getLogin($usuario){
        // var_dump($idPersona);die();
        $where['usuario']        = $usuario;
        $resultado = $this->ci->dbGeneral->getLogin($where);
        $respuesta = array("mensaje"=>"todos los datos obtenidos",
                            "continuar"=>1,
                            "datos"=>$resultado);   
        return $respuesta;
    }
    //inset pago de membresia
    public function insertdatapago($where,$dataInserta){
        //$where['codigoPago'] = $where;
       //var_dump($where);die();
        $resultado = $this->ci->dbGeneral->insertdatapago($where,$dataInserta);
        $respuesta = array("mensaje"=>"Tienda actualizada",
                              "continuar"=>1,
                              "datos"=>$resultado);   
        return $respuesta;
    }
    //actualiza fecha de membresia a 62 dias;
    public function updateTienda($tienda)
    {
        $where['idTienda']                      = $tienda;
        $fecha_actual                           = date('Y-m-d');
        $fechaSemana                            = date("Y-m-d",strtotime($fecha_actual."+ 1 week"));
        $fechaMes                               = date("Y-m-d",strtotime($fechaSemana."+ 2 month"));
        $dataActualiza['fechaInicioMembresia']  = date('Y-m-d');
        $dataActualiza['fechaCaducidad']        = $fechaMes;
        $dataActualiza['mesGratis']             = 1;
        $dataActualiza['manteminiento']         = 0;
        //var_dump($dataActualiza);die();
        $response = $this->ci->dbGeneral->actualizaMiTienda($where,$dataActualiza);
        if($response > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");
        }
        return $respuesta;
    }
    //actualiza 30 dias de membresia
    public function updatemes($tienda,$codigo,$mensajeMail)
    {
        $where['idTienda']                      = $tienda;
        $fecha_actual                           = date('Y-m-d');
        $fechaMes                               = date("Y-m-d",strtotime($fecha_actual."+ 1 month"));
        $dataActualiza['fechaInicioMembresia']  = $fecha_actual;
        $dataActualiza['fechaCaducidad']        = $fechaMes;
        $dataActualiza['manteminiento']         = 0;
        $dataActualiza['Plan']                  = 'web';
        $response = $this->ci->dbGeneral->actualizaMiTienda($where,$dataActualiza);
        if($response > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");
            
            $para = $mensajeMail;
            $asunto ="Recibo de pago Wcart";
            $fechaInicio = date('Y-m-d');
            $fecaCaducidad = $fechaMes;
            $pago = _PRECIO_PLAN_BASIC;
            $codigo = $codigo;
            $appMovil=0;
            $mensajeenviar = $this->mailPagoMembresia($fechaInicio,$fecaCaducidad,$pago,$codigo,$appMovil);
            $mensaje = plantillaMail($mensajeenviar);
            sendMail($para, $asunto, $mensaje);
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");
        }
        return $respuesta;
    }
    //actualiza membresia 12 meses
    public function updateSoloAno($tienda, $codigo,$mensajeMail)
    {
        $where['idTienda']                      = $tienda;
        $fecha_actual                           = date('Y-m-d');
        $fechaSoloAno                           = date("Y-m-d",strtotime($fecha_actual."+ 12 month"));
        $dataActualiza['fechaInicioMembresia']  = $fecha_actual;
        $dataActualiza['fechaCaducidad']        = $fechaSoloAno;
        $dataActualiza['manteminiento']         = 0;
        $response = $this->ci->dbGeneral->actualizaMiTienda($where,$dataActualiza);
        if($response > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");
            
            $para = $mensajeMail;
            $asunto ="Recibo de pago Wcart";
            $fechaInicio = date('Y-m-d');
            $fecaCaducidad = $fechaSoloAno;
            $pago = _PRECIO_PLAN_BASIC * _MESES_DE_COBRO_ANO_PLAN_BASIC;
            $codigo = $codigo;
            $appMovil =0;
            $mensajeenviar = $this->mailPagoMembresia($fechaInicio,$fecaCaducidad,$pago,$codigo,$appMovil);
            $mensaje = plantillaMail($mensajeenviar);
            sendMail($para, $asunto, $mensaje);
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");
        }
        return $respuesta;
    }
    //actualiza el pago con el codigo de membresia
    public function actualizaDatos($data,$where)
    {
        $actualizaPedido = $this->ci->dbGeneral->actualizaDatos($data,$where);
    }
    //info de la persona por el id de sesion
    public function getInfoUsuario($idPersona)
    {   
        $where['idPersona'] = $idPersona;
        $resultado          = $this->ci->dbGeneral->getInfoUsuario($where);
        //var_dump($resultado);
        return $resultado; 
    }
    //informacion de pedido por el id
    public function getInfopedido($pedido)
    {   
        $where['idMembresia'] = $pedido;
        $resultado          = $this->ci->dbGeneral->getInfopedido($where);
        //var_dump($resultado);
        return $resultado; 
    }
    //actualiza fecha de membresia a 13 meses y 7 dias dias;
    public function updateAnoApp($tienda, $codigo,$mensajeMail)
    {
        $where['idTienda']                      = $tienda;
        $fecha_actual                           = date('Y-m-d');
        $fechaSemana                            = date("Y-m-d",strtotime($fecha_actual."+ 1 week"));
        $fechaAno                               = date("Y-m-d",strtotime($fechaSemana."+ 13 month"));
        $dataActualiza['fechaInicioMembresia']  = $fecha_actual;
        $dataActualiza['fechaCaducidad']        = $fechaAno;
        $dataActualiza['mesGratis']             = 1;
        $dataActualiza['manteminiento']         = 0;
        $response = $this->ci->dbGeneral->actualizaMiTienda($where,$dataActualiza);
        if($response > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");
            
            $para = $mensajeMail;
            $asunto ="Recibo de pago Wcart";
            $fechaInicio = date('Y-m-d');
            $fecaCaducidad = $fechaAno ;
            $pago = _PRECIO_PLAN_BASIC * _MESES_DE_COBRO_ANO_PLAN_BASIC	;
            $codigo = $codigo;
            $appMovil =0;
            $mensajeenviar = $this->mailPagoMembresia($fechaInicio,$fecaCaducidad,$pago,$codigo,$appMovil);
            $mensaje = plantillaMail($mensajeenviar);
            sendMail($para, $asunto, $mensaje);
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");
        }
        return $respuesta;
    }
    //update la fecha de aduca cuando el plan no ha caducado a un mes
    public function updatePagoApp($tienda, $codigo,$mensajeMail)
    {
        $where['idTienda']                      = $tienda;
        $fecha_actual                           = date("Y-m-d");
        $fechaSemana                            = date("Y-m-d",strtotime($fecha_actual."+ 1 week"));
        $fechaMes                               = date("Y-m-d",strtotime($fechaSemana."+ 2 month"));
        $dataActualiza['fechaCaducidad']        = $fechaMes;
        $dataActualiza['Plan']                  = 'movil';
        $response = $this->ci->dbGeneral->actualizaMiTienda($where,$dataActualiza);
        if($response > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");

            $para = $mensajeMail;
            $asunto ="Recibo de pago Wcart";
            $fechaInicio = date('Y-m-d');
            $fecaCaducidad = $fechaMes ;
            $pago = _PRECIO_PLAN_BASIC * _MESES_DE_COBRO_ANO_PLAN_BASIC	;
            $codigo = $codigo;
            $appMovil =0;
            $mensajeenviar = $this->mailPagoMembresia($fechaInicio,$fecaCaducidad,$pago,$codigo,$appMovil);
            $mensaje = plantillaMail($mensajeenviar);
            sendMail($para, $asunto, $mensaje);
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");
        }
        return $respuesta;
    }
    //update la fecha de aduca cuando el plan no ha caducado a un año
    public function updatePagoAnoWeb($tienda, $codigo,$mensajeMail)
    {
        $where['idTienda']                      = $tienda;
        $fecha_actual                           = date("Y-m-d");
        $fechaSoloAno                           = date("Y-m-d",strtotime($fecha_actual."+ 12 month"));
        $dataActualiza['fechaCaducidad']        = $fechaSoloAno;
        $dataActualiza['Plan']                  = 'web';
        $response = $this->ci->dbGeneral->actualizaMiTienda($where,$dataActualiza);
        if($response > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");
            
            $para = $mensajeMail;
            $asunto ="Recibo de pago Wcart";
            $fechaInicio = date('Y-m-d');
            $fecaCaducidad = $fechaSoloAno;
            $pago = _PRECIO_PLAN_BASIC * _MESES_DE_COBRO_ANO_PLAN_BASIC;
            $codigo = $codigo;
            $appMovil =0;
            $mensajeenviar = $this->mailPagoMembresia($fechaInicio,$fecaCaducidad,$pago,$codigo,$appMovil,$appMovil);
            $mensaje = plantillaMail($mensajeenviar);
            sendMail($para, $asunto, $mensaje);
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");
        }
        return $respuesta;
    }
    //update la fecha de aduca cuando el plan no ha caducado a un mes plan pro
    public function updatePagoMesPro($tienda, $codigo,$mensajeMail)
    {
        $where['idTienda']                      = $tienda;
        $fecha_actual                           = date("Y-m-d");
        $fechaMes                               = date("Y-m-d",strtotime($fecha_actual."+ 1 month"));
        $dataActualiza['fechaCaducidad']        = $fechaMes;
        $dataActualiza['Plan']                  = 'movil y web';
        $response = $this->ci->dbGeneral->actualizaMiTienda($where,$dataActualiza);
        if($response > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");
                               
            $para = $mensajeMail;
            $asunto ="Recibo de pago Wcart";
            $fechaInicio = date('Y-m-d');
            $fecaCaducidad = $fechaMes;
            $pago = _PRECIO_PLAN_PRO;
            $codigo = $codigo;
            $appMovil =1;
            $mensajeenviar = $this->mailPagoMembresia($fechaInicio,$fecaCaducidad,$pago,$codigo,$appMovil);
            $mensaje = plantillaMail($mensajeenviar);
            sendMail($para, $asunto, $mensaje);
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");
        }
        return $respuesta;
    }
    //update la fecha de aduca cuando el plan no ha caducado a un año plan pro
    public function updatePagoAnoPro($tienda, $codigo,$mensajeMail)
    {
        $where['idTienda']                      = $tienda;
        $fecha_actual                           = date("Y-m-d");
        $fechaSoloAno                           = date("Y-m-d",strtotime($fecha_actual."+ 12 month"));
        $dataActualiza['fechaCaducidad']        = $fechaSoloAno;
        $dataActualiza['Plan']                  = 'movil y web';
        $response = $this->ci->dbGeneral->actualizaMiTienda($where,$dataActualiza);
        if($response > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");
                               
            $para = $mensajeMail;
            $asunto ="Recibo de pago Wcart";
            $fechaInicio = date('Y-m-d');
            $fecaCaducidad = $fechaSoloAno;
            $pago = _PRECIO_PLAN_PRO * _MESES_DE_COBRO_ANO_PLAN_PRO;
            $codigo = $codigo;
            $appMovil =1;
            $mensajeenviar = $this->mailPagoMembresia($fechaInicio,$fecaCaducidad,$pago,$codigo,$appMovil);
            $mensaje = plantillaMail($mensajeenviar);
            sendMail($para, $asunto, $mensaje);
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");
        }
        return $respuesta;
    }
    //cuando el usuario compra por primera vez plan pro mensual
    public function updateTiendapro($tienda,$codigo,$mensajeMail)
    {
        $where['idTienda']                      = $tienda;
        $fecha_actual                           = date('Y-m-d');
        $fechaSemana                            = date("Y-m-d",strtotime($fecha_actual."+ 1 week"));
        $fechaMes                               = date("Y-m-d",strtotime($fechaSemana."+ 2 month"));
        $dataActualiza['fechaInicioMembresia']  = $fecha_actual;
        $dataActualiza['fechaCaducidad']        = $fechaMes;
        $dataActualiza['mesGratis']             = 1;
        $dataActualiza['manteminiento']         = 0;
        $dataActualiza['Plan']                  = 'movil y web';
        //var_dump($dataActualiza);die();
        $response = $this->ci->dbGeneral->actualizaMiTienda($where,$dataActualiza);
        if($response > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");
            
            $para = $mensajeMail;
            $asunto ="Recibo de pago Wcart";
            $fechaInicio = date('Y-m-d');
            $fecaCaducidad = $fechaMes;
            $pago = _PRECIO_PLAN_PRO;
            $codigo = $codigo;
            $appMovil =1;
            $mensajeenviar = $this->mailPagoMembresia($fechaInicio,$fecaCaducidad,$pago,$codigo,$appMovil);
            $mensaje = plantillaMail($mensajeenviar);
            sendMail($para, $asunto, $mensaje);
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");
        }
        return $respuesta;
    }
    //cuando el usuario compra solo plan pro
    public function updateTiendaMespro($tienda, $codigo,$mensajeMail)
    {
        $where['idTienda']                      = $tienda;
        $fecha_actual                           = date('Y-m-d');
        $fechaMes                               = date("Y-m-d",strtotime($fecha_actual."+ 1 month"));
        $dataActualiza['fechaInicioMembresia']  = $fecha_actual;
        $dataActualiza['fechaCaducidad']        = $fechaMes;
        $dataActualiza['mesGratis']             = 1;
        $dataActualiza['manteminiento']         = 0;
        $dataActualiza['Plan']                  = 'movil y web';
        //var_dump($dataActualiza);die();
        $response = $this->ci->dbGeneral->actualizaMiTienda($where,$dataActualiza);
        if($response > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");

            $para = $mensajeMail;
            $asunto ="Recibo de pago Wcart";
            $fechaInicio = date('Y-m-d');
            $fecaCaducidad = $fechaMes;
            $pago = _PRECIO_PLAN_PRO;
            $codigo = $codigo;
            $appMovil =1;
            $mensajeenviar = $this->mailPagoMembresia($fechaInicio,$fecaCaducidad,$pago,$codigo,$appMovil);
            $mensaje = plantillaMail($mensajeenviar);
            sendMail($para, $asunto, $mensaje);
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");
        }
        return $respuesta;
    }
    //actualiza fecha de membresia a 13 meses y 7 dias dias plan pro
    public function updateAnoPro($tienda,$codigo,$mensajeMail)
    {
        $where['idTienda']                      = $tienda;
        $fecha_actual                           = date('Y-m-d');
        $fechaSemana                            = date("Y-m-d",strtotime($fecha_actual."+ 1 week"));
        $fechaAno                               = date("Y-m-d",strtotime($fechaSemana."+ 13 month"));
        $dataActualiza['fechaInicioMembresia']  = $fecha_actual;
        $dataActualiza['fechaCaducidad']        = $fechaAno;
        $dataActualiza['mesGratis']             = 1;
        $dataActualiza['manteminiento']         = 0;
        $dataActualiza['Plan']                  = 'movil y web';
        $response = $this->ci->dbGeneral->actualizaMiTienda($where,$dataActualiza);
        if($response > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");
                               
            $para = $mensajeMail;
            $asunto ="Recibo de pago Wcart";
            $fechaInicio = date('Y-m-d');
            $fecaCaducidad = $fechaAno;
            $pago = _PRECIO_PLAN_PRO;
            $codigo = $codigo;
            $appMovil =1;
            $mensajeenviar = $this->mailPagoMembresia($fechaInicio,$fecaCaducidad,$pago,$codigo,$appMovil);
            $mensaje = plantillaMail($mensajeenviar);
            sendMail($para, $asunto, $mensaje);
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");
        }
        return $respuesta;
    }
    //inserta registro a la base de datos con datos de pagos, mientras termina la transaccion
    public function insetCodigo($data, $email){
        $dataInserta['idTienda']        = $_SESSION['project']['info']['idTienda'];
        $dataInserta['codigoPago']      = $data;
        $dataInserta['estadoPago']      = 0;
        $dataInserta['ip']              = getIP();
        $dataInserta['fechaPago']       = date('Y-m-d H:m:s');
        $dataInserta['nombrePersona']   = $email;
        $resultado = $this->ci->dbGeneral->insetCodigo($dataInserta);
        $respuesta = array("mensaje"=>"data insert",
                            "continuar"=>1,
                            "datos"=>$resultado);   
        return $respuesta;
    }
     // consulta automatica de pagos donde estadoPago=0
     public function eliminaPagos($estadoPago){
        //extract($_POST)
        $where['estadoPago']      = $estadoPago;
        $resultado = $this->ci->dbGeneral->eliminaPagos($where);
        $respuesta = array("mensaje"=>"consultados para eliminar",
                              "continuar"=>1,
                              "datos"=>$resultado);   
        return $respuesta;
    }
    //insert a la tabla eliminados
    public function eliminados($dataInserta){
        //extract($_POST)
        $resultado = $this->ci->dbGeneral->eliminados($dataInserta);
        $respuesta = array("mensaje"=>"se agrego a la tabla eliminados",
                              "continuar"=>1,
                              "datos"=>$resultado);   
        return $respuesta;
    }
     // se elimina de la tabla 
     public function eliminar($idMembresia){
        //extract($_POST)
        $where['idMembresia']      = $idMembresia;
        $resultado = $this->ci->dbGeneral->eliminar($where);
        $respuesta = array("mensaje"=>"registro eliminado exitosamente",
                              "continuar"=>1,
                              "datos"=>$resultado);   
        return $respuesta;
    }
    //funcion para plantilla de correo
    public function mailPagoMembresia($fechaInicio,$fecaCaducidad,$pago,$codigo, $appMovil)
	{	
		$salida['fechaInicio']=$fechaInicio;
		$salida['fecaCaducidad']=$fecaCaducidad;
        $salida['pago']=$pago;
        $salida['codigo'] = $codigo;
        $salida['appMovil'] =$appMovil;
		return $this->ci->load->view("mailes/pagoMembresia",$salida,true);
		 
	}
    //eliminar cuenta de la tienda
    public function eliminaCuenta($usuario){
        // var_dump($idPersona);die();
        $where['idPersona']         = $usuario;
        $dataInserta['eliminado']   = 1;
        $resultado = $this->ci->dbGeneral->eliminaCuenta($where,$dataInserta);
        $respuesta = array("mensaje"=>"Se eliminaron los datos",
                            "continuar"=>1,
                            "datos"=>$resultado);   
        return $respuesta;
    }
    //actualiza 30 dias de membresia solo app movil
    public function updatemesApp($tienda,$codigo,$mensajeMail)
    {
        $where['idTienda']                      = $tienda;
        $fecha_actual                           = date('Y-m-d');
        $fechaMes                               = date("Y-m-d",strtotime($fecha_actual."+ 1 month"));
        $dataActualiza['fechaInicioMembresia']  = $fecha_actual;
        $dataActualiza['fechaCaducidad']        = $fechaMes;
        $dataActualiza['manteminiento']         = 0;
        $dataActualiza['Plan']                  = 'movil';
        $response = $this->ci->dbGeneral->actualizaMiTienda($where,$dataActualiza);
        if($response > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");
            
            $para = $mensajeMail;
            $asunto ="Recibo de pago Wcart";
            $fechaInicio = date('Y-m-d');
            $fecaCaducidad = $fechaMes;
            $pago = _PRECIO_PLAN_BASIC;
            $codigo = $codigo;
            $appMovil=0;
            $mensajeenviar = $this->mailPagoMembresia($fechaInicio,$fecaCaducidad,$pago,$codigo,$appMovil);
            $mensaje = plantillaMail($mensajeenviar);
            sendMail($para, $asunto, $mensaje);
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");
        }
        return $respuesta;
    }
    //update la fecha de aduca cuando el plan no ha caducado a un año plan app movil
    public function updatePagoAnoApp($tienda, $codigo,$mensajeMail)
    {
        $where['idTienda']                      = $tienda;
        $fecha_actual                           = date("Y-m-d");
        $fechaSoloAno                           = date("Y-m-d",strtotime($fecha_actual."+ 12 month"));
        $dataActualiza['fechaCaducidad']        = $fechaSoloAno;
        $dataActualiza['Plan']                  = 'movil';
        $response = $this->ci->dbGeneral->actualizaMiTienda($where,$dataActualiza);
        if($response > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");
                               
            $para = $mensajeMail;
            $asunto ="Recibo de pago Wcart";
            $fechaInicio = date('Y-m-d');
            $fecaCaducidad = $fechaSoloAno;
            $pago = _PRECIO_PLAN_PRO * _MESES_DE_COBRO_ANO_PLAN_PRO;
            $codigo = $codigo;
            $appMovil =1;
            $mensajeenviar = $this->mailPagoMembresia($fechaInicio,$fecaCaducidad,$pago,$codigo,$appMovil);
            $mensaje = plantillaMail($mensajeenviar);
            sendMail($para, $asunto, $mensaje);
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");
        }
        return $respuesta;
    } 
    //se verifica usuario por id
    public function verificaUsuario($usuario){
        // var_dump($idPersona);die();
        $where['idPersona']         = $usuario;
        $resultado = $this->ci->dbGeneral->verificaUsuario($where);
        $respuesta = array("mensaje"=>"Se eliminaron los datos",
                            "continuar"=>1,
                            "datos"=>$resultado);   
        return $respuesta;
    }
    
    
    
    
    
    
    //update la fecha de aduca cuando el plan app no ha caducado a un mes
    /*public function updatePagoApp($tienda, $codigo,$mensajeMail)
    {
        $where['idTienda']                      = $tienda;
        $fecha_actual                           = date("Y-m-d");
        $fechaSemana                            = date("Y-m-d",strtotime($fecha_actual."+ 1 week"));
        $fechaMes                               = date("Y-m-d",strtotime($fechaSemana."+ 2 month"));
        $dataActualiza['fechaCaducidad']        = $fechaMes;
        $dataActualiza['Plan']                  = 'movil';
        $response = $this->ci->dbGeneral->actualizaMiTienda($where,$dataActualiza);
        if($response > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");

            $para = $mensajeMail;
            $asunto ="Recibo de pago Wcart";
            $fechaInicio = date('Y-m-d');
            $fecaCaducidad = $fechaMes ;
            $pago = _PRECIO_PLAN_BASIC * _MESES_DE_COBRO_ANO_PLAN_BASIC	;
            $codigo = $codigo;
            $appMovil =0;
            $mensajeenviar = $this->mailPagoMembresia($fechaInicio,$fecaCaducidad,$pago,$codigo,$appMovil);
            $mensaje = plantillaMail($mensajeenviar);
            sendMail($para, $asunto, $mensaje);
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");
        }
        return $respuesta;
    }*/
    /*public function pruebaLogica(){
        $para = "gabiel.ramirez@gmail.com,farezprieeto@outlook.com";
        $asunto ="Bienvenido a Wannabe Digital y a sus sistema Wcart.";
        $mensajeenviar = $this->mailPagoMembresia("2023-2-16","2023-4-23","170.000","1234567","0");
        $mensaje = plantillaMail($mensajeenviar);
        echo $mensaje;
        sendMail($para, $asunto, $mensaje);
    }*/
 }