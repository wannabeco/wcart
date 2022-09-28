<?php
/*

    ("`-''-/").___....''"`-._
      `6_ 6  )   `-.  (     ).`-.__.`) 
      (_Y_.)'  ._   )  `._ `. ``-..-'
    _..`..'_..-_/  /..'_.' ,'
   (il),-''  (li),'  ((!.-'

   Desarrollado por @orugal
   https://github.com/orugal

   Este archivo llamado lógica es el que se encargará de realizar procesos con la información obtenida de las
   bases de datos, aquí se realizan validaciones, armados de arreglos, procesos de calculos y muchos más por el estilo, aquí no deben
   realizarse querys directos a la base de datos, para eso se usa el archivo modelo de base de datos
   
*/
class LogicaPedidos  {
    private $ci;
    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model("pedidos/BaseDatosPedidos","dbPedidos");//reemplazar por el archivo de base de datos real
        $this->ci->load->model("general/BaseDatosGral","dbGeneral");//reemplazar por el archivo de base de datos real
    } 
    public function getPedidos($where=array())
    {
        $dataPagos = $this->ci->dbPedidos->getPedidos($where);
        return $dataPagos;
    }
    public function getEstadisticas($where=array())
    {
        $dataPagos = $this->ci->dbGeneral->getEstadisticas($where);
        return $dataPagos;
    }
    public function misPedidos($where=array())
    {
        $dataPagos = $this->ci->dbPedidos->misPedidos($where);
        return $dataPagos;
    }
    public function misPedidosHome($where=array())
    {
        $dataPagos = $this->ci->dbPedidos->misPedidosHome($where);
        return $dataPagos;
    }
    public function productosPedidos($where=array())
    {
        $dataPagos = $this->ci->dbPedidos->productosPedidos($where);
        return $dataPagos;
    }
    public function getInventario($where=array())
    {
        $inventario = $this->ci->dbPedidos->getInventario($where);
        return $inventario;
    }
    public function sumaTotalInventario($where=array())
    {
        $inventario = $this->ci->dbPedidos->sumaTotalInventario($where);
        return $inventario;
    }
    public function registraIngresoStock($post)
    {
        //var_dump($_SESSION['project']);die();
        extract($post);
        $actualizaProd = false;
        $actualizaUsu = false;

          //ahora verifico si actualizo o edito a la persona
         if($idRemitente != "")//actualizo
         {
            $dataRegistra = array("cedulaPersona"=>$cedulaPersona,
                                  "nombrePersona"=>$nombrePersona,
                                  "apellidoPersona"=>$apellidoPersona,
                                  "celularPersona"=>$celularPersona);
            $where = array("idRemitente"=>$idRemitente);
            $usuario = $this->ci->dbPedidos->actualizaRemitente($where,$dataRegistra);
            $actualizaUsu = true;
            $remitente = $idRemitente;
         }
         else//inserto
         {
            $dataRegistra = array("cedulaPersona"=>$cedulaPersona,
                                  "nombrePersona"=>$nombrePersona,
                                  "apellidoPersona"=>$apellidoPersona,
                                  "celularPersona"=>$celularPersona);
            $usuario = $this->ci->dbPedidos->registraRemitente($dataRegistra);
            $remitente = $usuario;
            $actualizaUsu = true;
         }
         //echo $remitente;die();
         //si afecto al usuario inserto el inventario
         if($actualizaUsu)
         {
             //lo primero que se debe de hacer es registrar la informacion del producto
            if($edita == 1)//quiere decir que es editar el ingreso
            {
              //$actualizaProd = true;

              $dataIngresa = array("idProducto"=>$idProducto,
                                   "consecutivo"=>generoConsecutivoInventario('entrada'),
                                   "idRemision"=>$idRemision,
                                   "cantidadKilos"=>$cantidadKilos,
                                   "cantidadCajas"=>$cantidadCajas,
                                   "idPersonaEntrega"=>$remitente,
                                   "observaciones"=>$observaciones,
                                   "idPersonaRecibe"=>$_SESSION['project']['info']['idPersona'],
                                   "fechaRecibido"=>date("Y-m-d H:i:s"),
                                   "observaciones"=>$observaciones);
              $whereP = array("idInventario"=>$idInventario);
              $inventario = $this->ci->dbPedidos->actualizaProductoStock($whereP,$dataIngresa);
              $salida = array("mensaje"=>"El producto ha sido modificado de manera correcta",
                              "continuar"=>1);
            }
            else//quiere decir que es un nuevo ingreso
            {

              $dataIngresa = array("idProducto"=>$idProducto,
                                   "consecutivo"=>generoConsecutivoInventario('entrada'),
                                   "idRemision"=>$idRemision,
                                   "cantidadKilos"=>$cantidadKilos,
                                   "cantidadCajas"=>$cantidadCajas,
                                   "idPersonaEntrega"=>$remitente,
                                   "observaciones"=>$observaciones,
                                   "idPersonaRecibe"=>$_SESSION['project']['info']['idPersona'],
                                   "fechaRecibido"=>date("Y-m-d H:i:s"),
                                   "observaciones"=>$observaciones);
              $inventario = $this->ci->dbPedidos->registraProductoStock($dataIngresa);
              //$actualizaProd = true;
              $salida = array("mensaje"=>"El producto ha sido ingresado de manera correcta",
                              "continuar"=>1);

            }
         }
        return $salida;
    }
    public function getInfoRemitentes($where=array())
    {
        $remitentes = $this->ci->dbPedidos->getInfoRemitentes($where);
        if(count($remitentes) > 0)
        {
            $salida =array("mensaje"=>"Existe el remitente",
                           "continuar"=>1,
                           "datos"=>$remitentes);
        }
        else
        {
            $salida =array("mensaje"=>"No existe el remitente",
                           "continuar"=>0,
                           "datos"=>array());

        }
        return $salida;
    }
    public function updatePedidoTemporal($where=array(),$dataActualiza=array())
    {
        $dataPagos = $this->ci->dbPedidos->updatePedidoTemporal($where,$dataActualiza);
        return $dataPagos;
    }
    public function eliminaItemTemporal($where=array(),$dataActualiza=array())
    {
        $dataPedidos = $this->ci->dbPedidos->updatePedidoTemporal($where,$dataActualiza);
        return $dataPedidos;
    }
    public function pedidoTemporal($post)
    {

        //primero verifico si ya est'a agregada la presentacion para ese identificados
        $whereVerifica['identificador']   = $post['identificador'];
        $whereVerifica['idProducto']      = $post['idProducto'];
        $whereVerifica['idPresentacion']  = $post['idPresentacion'];
        $verificaPedidoTmp = $this->ci->dbPedidos->verificaPedidoTemp($whereVerifica);

        if(count($verificaPedidoTmp) == 0)//no existe hay que insertar
        {
          $dataInserta['idProducto']      = $post['idProducto'];
          $dataInserta['idPresentacion']  = $post['idPresentacion'];
          $dataInserta['cantidad']        = $post['cantidad'];
          $dataInserta['idPersona']       = 0;
          $dataInserta['idTienda']       = $post['idTienda'];
          $dataInserta['identificador']   = $post['identificador'];
          $dataInserta['valor']           = $post['valor'];
          $resultPedidoTmp  = $this->ci->dbPedidos->insertaPedidoTemp($dataInserta);

          $salida = array("mensaje"=>"Agregado al pedido",
                          "continuar"=>1);
        }
        else//no existe hay que actualizar
        {
          $dataInserta['idProducto']      = $post['idProducto'];
          $dataInserta['idPresentacion']  = $post['idPresentacion'];
          $dataInserta['cantidad']        = $post['cantidad'];
          $dataInserta['idPersona']       = 0;
          $dataInserta['identificador']   = $post['identificador'];
          $dataInserta['valor']           = $post['valor'];
          $dataInserta['idTienda']       = $post['idTienda'];

          $whereUpdate['identificador']   = $post['identificador'];
          $whereUpdate['idProducto']      = $post['idProducto'];
          $whereUpdate['idPresentacion']  = $post['idPresentacion'];
          $resultPedidoTmp  = $this->ci->dbPedidos->actualizaPedidoTemp($whereUpdate,$dataInserta);
          $salida = array("mensaje"=>"Actualizo el pedido",
                          "continuar"=>1);

        }
        return $salida;
    }
    //gestiona los pedidos de los administradores
    public function gestionPedidoAdmin($post)
    {
        extract($post);
        //actualizar el pedido
        //actualizo la informacion del pedido
       // die($estadoPedido);
        $wherePedido     = array("idPedido"=>$idPedido);
        $dataActualiza   = array("estadoPedido"=>$estadoPedido,"estadoPago"=>$estadoPago,"fechaEntrega"=>date("Y-m-d H:i:s"));
        $actualizoPedido = $this->ci->dbPedidos->updatePedido($wherePedido,$dataActualiza);
        $infoPedido      = $this->ci->dbPedidos->getPedidos(array("p.idPedido"=>$idPedido));
        $productosPedido = $this->ci->dbPedidos->productosPedidos(array("idPedido"=>$idPedido));
        //var_dump($infoPedido);
        //si el pedido es actualizado y el pago es realizado entonces descuento cantidad del stock, o mejor dicho agrego un movimiento de salida.
       /* if($estadoPago == _ID_ESTADO_PAGO)//realizo el moviento y todo lo que con el lleve. @todo _ID_ESTADO_PAGO esta en el modulo de variables globales
        {
            foreach($productosPedido as $pPed)
            {
              //inserto el movimiento
              $dataInserta          = array("consecutivo"=>generoConsecutivoInventario('salida'),
                                            "idProducto"=>$pPed['idProducto'],
                                            "cantidadKilos"=>$pPed['cantidad'],
                                            "idPersonaRecibe"=>$infoPedido[0]['idPersona'],
                                            "idPersonaEntrega"=>$_SESSION['project']['info']['idPersona'],
                                            "movimiento"=>"salida",
                                            "idPedido"=>$idPedido,
                                            "fechaSalida"=>date("Y-m-d H:i:s"),
                                          );
              $registroSalidaStock  = $this->ci->dbPedidos->registraProductoStock($dataInserta); 
              //terminar esto 
            }
        }*/
        
        if($actualizoPedido)
        {
            $tituloMensaje = "Hola, ".$infoPedido[0]['nombre'];
            if($estadoPedido == 4)//Despachado
            {
                $mensaje  = "El pedido número ".$infoPedido[0]['idPedido']." ha sido despachado, debes estar pendiente.";
            }
            else if($estadoPedido == 6)//En tramite
            {
                $mensaje  = "El pedido número ".$infoPedido[0]['idPedido']." está en proceso de preparación.";
            }
            else if($estadoPedido == 5)//Cancelado
            {
                $mensaje  = "El pedido número ".$infoPedido[0]['idPedido']." ha sido cancelado.";
            }
            else if($estadoPedido == 2)//Pendiente
            {
                $mensaje  = "El pedido número ".$infoPedido[0]['idPedido']." ha sido recibido.";
            }

            $envioFCM = sendFCM($tituloMensaje,$mensaje,$infoPedido[0]['FCMToken']);
            //registro la notificacion en la base de datos
            $datosNotificacion['idPersona'] = $infoPedido[0]['idPersona'];
            $datosNotificacion['tipo']      = 'mensaje';
            $datosNotificacion['titulo']    = 'Cambio de estado del pedido '.$infoPedido[0]['idPedido'];
            $datosNotificacion['mensaje']   = $mensaje;
            $datosNotificacion['fecha']     = date("Y-m-d H:i:s");

            $insertoNotificacion = $this->ci->dbGeneral->insertaNotificacion($datosNotificacion);

            $salida = array("mensaje"=>"El pedido ha sido actualizado de manera correcta",
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"El pedido ha sido actualizado de manera correcta",
                            "continuar"=>0);

        }
        return $salida;

    }
    //gestiona los pedidos desde la app movil
    public function gestionaPedidoRecibido($post)
    {
        extract($post);
        $infoPedido      = $this->ci->dbPedidos->getPedidos(array("idPedido"=>$idPedido));
        $productosPedido = $this->ci->dbPedidos->productosPedidos(array("idPedido"=>$idPedido));
        $cantProductosPed = count($productosPedido);
        //actualizo la informacion del pedido
        $wherePedido     = array("idPedido"=>$idPedido);
        $dataActualiza   = array("estadoPedido"=>$idEstado,"fechaEntrega"=>date("Y-m-d H:i:s"));
        $actualizoPedido = $this->ci->dbPedidos->updatePedido($wherePedido,$dataActualiza);
        $incremento      = 0;

        //var_dump($productosPedido);die();
        if($idEstado == 4)
        {
          foreach($productosPedido as $pPed)
          {
              //consulto la información de la persona a la que le hicieron el pedido para saber el perfil.
              $informacionUsuario = $this->ci->dbGeneral->getInfoPersonas(array("idPersona"=>$infoPedido[0]['pedidoPara']));
              //var_dump($informacionUsuario[0]['idPerfil']);
              //valido el perfil para saber que ganancia darle a la persona.
              if($informacionUsuario[0]['idPerfil'] == _PERFIL_VENDEDOR)//cuando ester haga un pedido se lo debe enviar a su respectivo raul
              {
                $gananciaTotal = $pPed['gananciaVend'] * $pPed['cantidad'];
                $gananciaUnitaria = $pPed['gananciaVend'];
              }
              else if($informacionUsuario[0]['idPerfil'] == _PERFIL_ADMIN_VENTAS)//cuando raul haga el pedido le debe llegar a esmeralda.
              {
                $gananciaTotal = $pPed['gananciaDist'] * $pPed['cantidad'];
                $gananciaUnitaria = $pPed['gananciaDist'];
              }
              //echo $gananciaUnitaria;

              //debo insertar cada uno de los
              $dataInserta = array("idPersona"=>$post['idPersona'],
                                   "idPedido"=>$pPed['idPedido'],
                                   "idProducto"=>$pPed['idProducto'],
                                   "idPresentacion"=>$pPed['idPresentacion'],
                                   "cantidad"=>$pPed['cantidad'],
                                   "gananciaUnitaria"=>$gananciaUnitaria,
                                   "gananciaTotal"=>$gananciaTotal,
                                   "fecha"=>date("Y-m-d H:i:s"));
              //inserto la ganancia de la persona.
              $ventas = $this->ci->dbPedidos->insertaVentas($dataInserta);
              if($ventas > 0)
              {
                $incremento++;
              }
          }
          $mensajeGanancia = ($gananciaTotal > 0)?"La ganancia en este pedido fue de: $".number_format($gananciaTotal,0,',','.'):"";
          if($cantProductosPed == $incremento)
          {
              $salida = array("mensaje"=>"El pedido se ha actualizado de manera correcta.".$mensajeGanancia,
                              "continuar"=>1,
                              "ganancia"=>$gananciaTotal,
                              "gananciaMostrar"=>"$".number_format($gananciaTotal,0,',','.'));

          }
          else
          {
              $salida = array("mensaje"=>"El pedido no ha podido ser actualizado, intente de nuevo más tarde",
                              "continuar"=>0,
                              "gananciaMostrar"=>"$".number_format($gananciaTotal,0,',','.'));
          }
        }
        else if($idEstado == 6)//si el estado se pone en estado de trámite debo duplicar la info del pedido para pasarsela al adistribuidor
        {
            $infoPedido         = $this->ci->dbPedidos->getPedidos(array("p.idPedido"=>$idPedido));
            $productosPedido    = $this->ci->dbPedidos->productosPedidos(array("idPedido"=>$idPedido));
            //var_dump($productosPedido);die();
            $informacionUsuario = $this->ci->dbGeneral->getInfoPersonas(array("idPersona"=>$post['idPersona']));
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
                $enviarNotificaciones = 2;
                $usuariosAdmin  = $this->ci->dbGeneral->getInfoPersonas(array("idPerfil"=>2,"estado"=>1,"eliminado"=>0));
                $usuariosSuperAdmin  = $this->ci->dbGeneral->getInfoPersonas(array("idPerfil"=>2,"estado"=>1,"eliminado"=>0));
                $enviarNotificaciones = 2;
            }  
            //var_dump($infoPedido);
            //armo la informacion del pedido
            $pedido['fechaPedido']  = date("Y-m-d H:i:s");
            $pedido['ip']           = getIP();
            $pedido['idPersona']    = $post['idPersona'];
            $pedido['valor']        = $infoPedido[0]['valor'];
            $pedido['codigoPedido'] = generacodigo(10);
            $pedido['formaPago']    = $infoPedido[0]['formaPago'];
            $pedido['pedidoPadre']  = $idPedido;
            //procedo a insertar el pedido.
            $idPedido = $this->ci->dbGeneral->insertaPedido($pedido);

            $contador = 0;
            foreach($productosPedido as $prod)
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
            if($contador == count($productosPedido))
            {
                $respuesta = array("mensaje"=>"El pedido se ha registrado de manera exitosa. Su número de pedido es el:<br><h2>".$idPedido."</h2>",
                                  "continuar"=>1,
                                  "datos"=>$idPedido);   

                $asuntoMensaje = "Nuevo pedido desde Esmeralda App";
                $mensaje  = "Hola, ha llegado un nuevo pedido de producto con la siguiente información<br><br>";

                $mensaje .= "<h2>DATOS DEL CLIENTE</h2>";
                $mensaje .= "Nombre: ".$informacionUsuario[0]['nombre']." ".$informacionUsuario[0]['apellido']."<br>";
                $mensaje .= "Teléfonos: ".$informacionUsuario[0]['celular']."<br>";
                $mensaje .= "<h2>PRODUCTOS SOLICITADOS</h2>";
                $sumaTotal  = 0;
               // echo "sdsdsdssdsdsd";
                foreach($productosPedido as $prod2)
                {
                    $consultaDataPresent  = $this->ci->dbGeneral->getPresentacionesProducto(array('idPresentacion'=>$prod2['idPresentacion']));
                    if($informacionUsuario[0]['idPerfil'] == _PERFIL_VENDEDOR)//cuando ester haga un pedido se lo debe enviar a su respectivo raul
                    {
                        $sumaTotal += ($prod2['valorPresentacionD'] * $prod2['cantidad']);
                    }
                    else
                    {
                        $sumaTotal += ($prod2['valorPresentacion'] * $prod2['cantidad']);
                    }
                    $mensaje .= $prod2['nombrePresentacion']." Cantidad: ".$prod2['cantidad']."Kgs<br>";

                }
                //actualizo el valor del pedido
                $dataActualiza2   = array("valor"=>$sumaTotal,"fechaEntrega"=>date("Y-m-d H:i:s"));
                $actualizoPedido2 = $this->ci->dbPedidos->updatePedido(array('idPedido'=>$idPedido),$dataActualiza2);

                $mensaje .= "<h2>TOTAL DEL PEDIDO</h2>";
                $mensaje .= "<h4>$".number_format($sumaTotal,0,",",".")."</h4>";
                //envio un mensaje al administrador general
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
             $salida = array("mensaje"=>"El pedido se ha puesto en trámite de manera exitosa.",
                            "continuar"=>1,
                            "datos"=>"");  
          }
          else
          {
              $salida = array("mensaje"=>"El pedido no pudo ser registrado de manera exitos, por favor intente de nuevo más tarde.",
                                "continuar"=>0,
                                "datos"=>"");    

          }


            //var_dump($pedido);

        }
        else
        {
              $salida = array("mensaje"=>"El pedido ha sido actualizado de manera correcta.",
                              "continuar"=>0,
                              "gananciaMostrar"=>0);

        }

        return $salida;
    }

    public function getPedidoTemporal($where)
    {
        //$where['identificador'] = $identificador;
        $resultado = $this->ci->dbPedidos->getPedidoTemporal($where);
        if(count($resultado) > 0 )//hay productos en el pedido temporal
        {
           $suma = 0;
           foreach($resultado as $r)
           {
              $suma += ($r['cantidad'] * $r['valor']);
           }
           $salida = array("mensaje"=>"Listado de productos del pedido",
                           "datos"=>$resultado,
                           "total"=>$suma,
                           "continuar"=>1);           
        }
        else//no hay pedidos en el temporal
        {
            $salida = array("mensaje"=>"No hay productos en el pedido",
                            "datos"=>array(),
                            "total"=>0,
                            "continuar"=>0);
        }
        return $salida;
    }
 }