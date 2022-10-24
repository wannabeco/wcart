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
class LogicaHome  {
    private $ci;
    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model("home/BaseDatosHome","dbHome");//reemplazar por el archivo de base de datos real
        $this->ci->load->model("general/BaseDatosGral","dbGeneral");//reemplazar por el archivo de base de datos real
    } 
    public function infoCategoria($idProducto)
    {
        $where['idProducto'] = $idProducto;
        if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
        {
            $where['idTienda']   = $_SESSION['project']['info']['idTienda'];
        }
        $resultado = $this->ci->dbHome->getCategorias($where);
        if(count($resultado) > 0)
        {
            $salida = array("mensaje"=>"Info de la categoria",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No existe la categoria seleccionada",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    public function getInfoTienda($url="",$idTienda="",$urlAmigable="")
    {
        if($url != "")
        {
            //$where['dominioTienda'] = $url;
            $resultado = $this->ci->dbHome->getInfoTiendaLike($url);
        }

        if($idTienda != "")
        {
            $where['idTienda'] = $idTienda;
            $resultado = $this->ci->dbHome->getInfoTienda($where);
        }

        if($urlAmigable != "")
        {
            $where['urlAmigable'] = $urlAmigable;
            $resultado = $this->ci->dbHome->getInfoTienda($where);
        }

        if(count($resultado) > 0)
        {
            $salida = array("mensaje"=>"Info de la tienda",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No existe la tienda seleccionada",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    public function eliminaCategoria($post)
    {
        $dataActualiza['idEstado'] = 0;
        $resultado = $this->ci->dbHome->actualizaCategoria($post,$dataActualiza);
        if($resultado > 0)
        {
            $salida = array("mensaje"=>lang("lbl_alert_exito_elimina"),
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No se ha podido eliminar la categoría, intente de nuevo más tarde",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    public function procesaCategoria($post)
    {
        extract($post);
        if($edita == 0)//agrega
        {
            unset($post['edita']);
            unset($post['idProducto']);
            $post['nombreProducto'] = mb_strtoupper($post['nombreProducto']);
            $resultado = $this->ci->dbHome->agregaCategoria($post);
            if($resultado > 0)
            {
                $salida = array("mensaje"=>lang("lbl_alert_exito"),
                                "datos"=>$resultado,
                                "continuar"=>1);
            }
            else
            {
                $salida = array("mensaje"=>"No se ha podido crear la categoría, intente de nuevo más tarde",
                                "datos"=>array(),
                                "continuar"=>0);
            }
        }
        else//actualiza
        {
            $where['idProducto']            = $idProducto;
            $dataActualiza['nombreProducto'] = mb_strtoupper($post['nombreProducto']);
            $resultado = $this->ci->dbHome->actualizaCategoria($where,$dataActualiza);
            if($resultado > 0)
            {
                $salida = array("mensaje"=>lang("lbl_alert_exito_edita"),
                                "datos"=>$resultado,
                                "continuar"=>1);
            }
            else
            {
                $salida = array("mensaje"=>"No se ha podido actualizar la categoría, intente de nuevo más tarde",
                                "datos"=>array(),
                                "continuar"=>0);
            }
        }
        return $salida;
    }
    public function getCategorias($where=array())
    {
        $resultado = $this->ci->dbHome->getCategorias($where);
        if(count($resultado) > 0)
        {
            $salida = array("mensaje"=>"categorias consultadas",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No hay categorías creadas",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    public function getSubcategorias($where=array())
    {
        $resultado = $this->ci->dbHome->getSubcategorias($where);
        if(count($resultado) > 0)
        {
            $salida = array("mensaje"=>"Subcategorias consultadas",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No hay Subcategorias creadas",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    public function getSubcategoriasAnidada($where=array())
    {
        $resultado = $this->ci->dbHome->getSubcategoriasAnidada($where);
        if(count($resultado) > 0)
        {
            $salida = array("mensaje"=>"Subcategorias consultadas",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No hay Subcategorias creadas",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    public function getProductos($where=array())
    {
        $resultado = $this->empaquetaPresentaciones($where);
        if(count($resultado) > 0)
        {
            $salida = array("mensaje"=>"productos consultados",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No hay productos creados",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    public function empaquetaPresentaciones($where)
    {
        $productos = $this->ci->dbHome->getProductos($where);
        $dataSalida = array();
        $primerVariacion =  0;
        foreach($productos as $prod)
        {
            $variaciones = $this->ci->dbHome->getVariaciones(array("idPresentacion"=>$prod['idPresentacion'],"idTienda"=>$prod['idTienda'],"idEstado"=>1));
            if(count($variaciones) > 0)
            {   $varSal = array();
                $primerVariacion = $variaciones[0]['idVariacion'];
                foreach($variaciones as $var)
                {
                    $varSal[$var['idVariacion']]['idVariacion'] = $var['idVariacion'];
                    $varSal[$var['idVariacion']]['idTienda'] = $var['idTienda'];
                    $varSal[$var['idVariacion']]['nombreVariacion'] = $var['nombreVariacion'];
                    $varSal[$var['idVariacion']]['valorPresentacion'] = $var['valorPresentacion'];
                    $varSal[$var['idVariacion']]['valorAnterior'] = $var['valorAnterior'];
                    $varSal[$var['idVariacion']]['descuento'] = $var['descuento'];
                    $varSal[$var['idVariacion']]['fotoPresentacion'] = $var['fotoPresentacion'];
                    $varSal[$var['idVariacion']]['idEstado'] = $var['idEstado'];
                }
            }
            else
            {
                $varSal = array();
                $primerVariacion = 0;
            }
            //consulto las varicaiones de la presentacion
            $array = array("idPresentacion"=>$prod['idPresentacion'],
                           "idTienda"=>$prod['idTienda'],
                           "variacion"=>$prod['variacion'],
                           "idProducto"=>$prod['idProducto'],
                           "idSubcategoria"=>$prod['idSubcategoria'],
                            "nombrePresentacion"=>$prod['nombrePresentacion'],
                            "marca"=>$prod['marca'],
                            "codigoProducto"=>$prod['codigoProducto'],
                            "fotoPresentacion"=>$prod['fotoPresentacion'],
                            "foto2"=>$prod['foto2'],
                            "foto3"=>$prod['foto3'],
                            "foto4"=>$prod['foto4'],
                            "foto5"=>$prod['foto5'],
                            "descuento"=>$prod['descuento'],
                            "valorPresentacion"=>$prod['valorPresentacion'],
                            "valorAntes"=>$prod['valorAntes'],
                            "descripcionCorta"=>$prod['descripcionCorta'],
                            "descripcionPres"=>$prod['descripcionPres'],
                            "agotado"=>$prod['agotado'],
                            "nuevo"=>$prod['nuevo'],
                            "likes"=>$prod['likes'],
                            "idEstado"=>$prod['idEstado'],
                            "primerVariacion"=>$primerVariacion,
                            "variaciones"=>$varSal
                        );
            array_push($dataSalida,$array);
        }
        return $dataSalida;
    }

    
    public function procesaLike($post)
    {

        extract($post);
        //lo primero es verificar si el id de usuario ya dio Like
        $yaDioLike = $this->ci->dbHome->verificaLike(array("idUsuario"=>$idUsuario,"idProducto"=>$idProducto,"eliminado"=>0,"idTienda"=>$idTienda));
        //consulto la info del producto
        $infoProducto = $this->ci->dbHome->getProductos(array("idPresentacion"=>$idProducto));
        if(count($yaDioLike) == 0)//no le ha dado like a ese producto
        {
            $dataActualiza['likes'] = $infoProducto[0]['likes'] + 1;
            $procesoLike = $this->ci->dbHome->procesaLike(array("idPresentacion"=>$idProducto),$dataActualiza);
            //luego de esto inserto el like del usuario en la tabla relacion de likes
            $dataInserta = array("idUsuario"=>$idUsuario,"idProducto"=>$idProducto,"idTienda"=>$idTienda);
            $insertoLikeRelacion = $this->ci->dbHome->relLike($dataInserta);
            $salida = array("mensaje"=>"Te gusta este producto!",
                            "datos"=>array(),
                            "continuar"=>1);
        }
        else
        {
            $dataActualiza['likes'] = $infoProducto[0]['likes'] - 1;
            $procesoLike = $this->ci->dbHome->procesaLike(array("idPresentacion"=>$idProducto),$dataActualiza);
            //luego de esto inserto el like del usuario en la tabla relacion de likes
            $whereElimina = array("idUsuario"=>$idUsuario,"idProducto"=>$idProducto,"idTienda"=>$idTienda);
            $insertoLikeRelacion = $this->ci->dbHome->delRelLike($whereElimina,array("eliminado"=>1));
            $salida = array("mensaje"=>"Ya no te gusta este producto",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        
        return $salida;
    }
    public function agregarCarrito($post)
    {
        extract($post);
        //primero que todo verifico que el producto no este agregado al carrito
        $whereCarrito['idPresentacion'] = $idProducto;
        $whereCarrito['idPersona']      = $idUsuario;
        $whereCarrito['proveedor']      = $proveedor;
        $whereCarrito['idTienda']       = $idTienda;
        $whereCarrito['idVariacion']    = $variacion;
        $whereCarrito['eliminado']      = 0;
        $verificaCarrito = $this->ci->dbHome->verificaCarrito($whereCarrito);
        //verifico si el usuario ya ha agregado ese producto al carro
        if(count($verificaCarrito) == 0)
        {
            $dataInserta['idPresentacion'] = $idProducto;
            $dataInserta['idPersona']      = $idUsuario;
            $dataInserta['proveedor']      = $proveedor;
            $dataInserta['idTienda']       = $idTienda;
            $dataInserta['idVariacion']    = $variacion;
            $dataInserta['cantidad']       = 1;
            //si no esta entonces lo ingreso
            $insertoEnCarro = $this->ci->dbHome->insertaEnCarro($dataInserta);
            if($insertoEnCarro > 0)
            {
                $salida = array("mensaje"=>"Producto agregado con éxito.",
                            "continuar"=>1,
                            "datos"=>$insertoEnCarro);
            }
            else
            {
                $salida = array("mensaje"=>"El producto no ha sido agregado.",
                            "continuar"=>0,
                            "datos"=>array());
            }
        }
        else
        {
            $salida = array("mensaje"=>"Este producto ya lo agregaste al carrito.",
                            "continuar"=>0,
                            "datos"=>array());
        }
        return $salida;
    }
    public function quitarDelCarrito($post)
    {
        extract($post);
        //primero que todo verifico que el producto no este agregado al carrito
        $whereCarrito['idPedidoTemp']   = $idRelacion;
        $whereCarrito['idPersona']      = $idUsuario;
        $whereCarrito['proveedor']      = $proveedor;
        $whereCarrito['idTienda']       = $idTienda;
        $dataActualiza['eliminado']     = 1;
        $quitaCarroProceso = $this->ci->dbHome->actualizaPedido($whereCarrito,$dataActualiza);
        //verifico si el usuario ya ha agregado ese producto al carro
        if($quitaCarroProceso > 0)
        {
            $salida = array("mensaje"=>"Eliminaste el producto del carrito.",
                        "continuar"=>1,
                        "datos"=>$quitaCarroProceso);

        }
        else
        {
            $salida = array("mensaje"=>"No se pudo eliminar el carrito.",
                            "continuar"=>0,
                            "datos"=>array());
        }
        return $salida;
    } 
    public function modificarCantidad($post)
    {
        extract($post);
        //primero que todo verifico que el producto no este agregado al carrito
        $whereCarrito['idPedidoTemp']   = $idRelacion;
        $whereCarrito['idPersona']      = $idUsuario;
        $whereCarrito['proveedor']      = $proveedor;
        $whereCarrito['idTienda']       = $idTienda;
        $dataActualiza['cantidad']      = $cantidad;
        $quitaCarroProceso = $this->ci->dbHome->actualizaPedido($whereCarrito,$dataActualiza);
        //verifico si el usuario ya ha agregado ese producto al carro
        if($quitaCarroProceso > 0)
        {
            $salida = array("mensaje"=>"Se ajustó la cantidad.",
                        "continuar"=>1,
                        "datos"=>$quitaCarroProceso);

        }
        else
        {
            $salida = array("mensaje"=>"No se pudo eliminar el carrito.",
                            "continuar"=>0,
                            "datos"=>array());
        }
        return $salida;
    }
    public function leerCarrito($post)
    {
        extract($post);
        $whereCarrito['p.idPersona']      = $idUsuario;
        $whereCarrito['p.proveedor']      = $proveedor;
        $whereCarrito['p.idTienda']       = $idTienda;
        $whereCarrito['p.eliminado']      = 0;
        $productosCarrito = $this->ci->dbHome->leerCarrito($whereCarrito);
        //verifico si el usuario ya ha agregado ese producto al carro
        if(count($productosCarrito) > 0)
        {
            $salida = array("mensaje"=>"Listado de productos carrito.",
                        "continuar"=>1,
                        "datos"=>$productosCarrito);

        }
        else
        {
            $salida = array("mensaje"=>"No hay productos cargados en el carrito.",
                            "continuar"=>0,
                            "datos"=>array());
        }
        return $salida;
    }
    public function procesaSubCategoria($post)
    {
        extract($post);
        if($edita == 0)//agrega
        {
            unset($post['edita']);
            $post['nombreSubcategoria'] = mb_strtoupper($post['nombreSubcategoria']);
            $resultado = $this->ci->dbHome->agregaSubCategoria($post);
            if($resultado > 0)
            {
                $salida = array("mensaje"=>"Subcategoría creada de manera exitosa",
                                "datos"=>$resultado,
                                "continuar"=>1);
            }
            else
            {
                $salida = array("mensaje"=>"No se ha podido crear la categoría, intente de nuevo más tarde",
                                "datos"=>array(),
                                "continuar"=>0);
            }
        }
        else//actualiza
        {
            $where['idSubcategoria']             = $idSubcategoria;
            $dataActualiza['nombreSubcategoria'] = mb_strtoupper($nombreSubcategoria);
            $dataActualiza['idProducto']         = $idProducto;
            $resultado = $this->ci->dbHome->actualizaSubCategoria($where,$dataActualiza);
            if($resultado > 0)
            {
                $salida = array("mensaje"=>"Subcategoría actualizada de manera exitosa",
                                "datos"=>$resultado,
                                "continuar"=>1);
            }
            else
            {
                $salida = array("mensaje"=>"No se ha podido actualizar la subcategoría, intente de nuevo más tarde",
                                "datos"=>array(),
                                "continuar"=>0);
            }
        }
        return $salida;
    }


    public function eliminaSubCategoria($post)
    {
        $dataActualiza['idEstado'] = 0;
        $resultado = $this->ci->dbHome->actualizaSubCategoria($post,$dataActualiza);
        if($resultado > 0)
        {
            $salida = array("mensaje"=>"La subcategoría se ha eliminado exitosamente",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No se ha podido eliminar la subcategoría, intente de nuevo más tarde",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    //procesos para los productos
    public function getProductosAnidados($where=array())
    {
        $resultado = $this->ci->dbHome->getProductosAnidados($where);
        if(count($resultado) > 0)
        {
            $salida = array("mensaje"=>"productos consultados",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No hay productos creados",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }

    public function procesaProductos($post)
    {
        extract($post);
        //var_dump($post);die();
        if($edita == 0)//agrega
        {
            unset($post['edita']);
            unset($post['fotoActual']);
            $post['nombrePresentacion'] = mb_strtoupper($post['nombrePresentacion']);
            $resultado = $this->ci->dbHome->agregaProducto($post);
            if($resultado > 0)
            {
                $salida = array("mensaje"=>"El producto se ha agregado de manera correcta",
                                "datos"=>$resultado,
                                "continuar"=>1);
            }
            else
            {
                $salida = array("mensaje"=>"El producto no se ha podido crear, intente de nuevo más tarde",
                                "datos"=>array(),
                                "continuar"=>0);
            }
        }
        else//actualiza
        {
            unset($post['edita']);
            unset($post['idPresentacion']);
            unset($post['fotoActual']);
            $where['idPresentacion']        = $idPresentacion;
            $post['nombrePresentacion']     = mb_strtoupper($nombrePresentacion);
            $resultado = $this->ci->dbHome->actualizaProducto($where,$post);
            if($resultado > 0)
            {
                $salida = array("mensaje"=>"Producto actualizado de manera exitosa",
                                "datos"=>$resultado,
                                "continuar"=>1);
            }
            else
            {
                $salida = array("mensaje"=>"No se ha podido actualizar el producto, intente de nuevo más tarde",
                                "datos"=>array(),
                                "continuar"=>0);
            }
        }
        return $salida;
    }


    public function infoProducto($where=array())
    {
        $resultado = $this->ci->dbHome->infoProductoTotal($where);
        if(count($resultado) > 0)
        {
            $salida = array("mensaje"=>"producto consultado",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No hay producto creadas",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    public function getVariaciones($where=array())
    {
        $resultado = $this->ci->dbHome->getVariaciones($where);
        if(count($resultado) > 0)
        {
            $salida = array("mensaje"=>"variaciones consultadas",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No hay variaciones creadas",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }


    //procesa las variaciones
    public function procesaVariaciones($post)
    {
        extract($post);
        if($nueva == 1)//agrega
        {
            $dataInsertar['nombreVariacion']          = mb_strtoupper($post['nombreVar']);
            $dataInsertar['valorPresentacion']  = $post['valor'];
            //$dataInsertar['valorAnterior']      = $post['valorAntes'];
            //$dataInsertar['descuento']          = $post['descuento'];
            $dataInsertar['idPresentacion']     = $post['idPresentacion'];
            $dataInsertar['idTienda']           = $post['idTienda'];
            $resultado = $this->ci->dbHome->agregaVariacion($dataInsertar);
            if($resultado > 0)
            {
                $salida = array("mensaje"=>"Categoría creada de manera exitosa",
                                "datos"=>$resultado,
                                "continuar"=>1);
            }
            else
            {
                $salida = array("mensaje"=>"No se ha podido crear la categoría, intente de nuevo más tarde",
                                "datos"=>array(),
                                "continuar"=>0);
            }
        }
        else//actualiza
        {
            $where['idVariacion']            = $idVariacion;

            $dataActualiza['nombreVariacion']          = mb_strtoupper($post['nombreVar']);
            $dataActualiza['valorPresentacion']  = $post['valor'];
            //$dataActualiza['valorAnterior']      = $post['valorAntes'];
            //$dataActualiza['descuento']          = $post['descuento'];
            $dataActualiza['idPresentacion']     = $post['idPresentacion'];
            $dataActualiza['idTienda']           = $post['idTienda'];

            $resultado = $this->ci->dbHome->actualizaVariacion($where,$dataActualiza);
            if($resultado > 0)
            {
                $salida = array("mensaje"=>"Categoría actualizada de manera exitosa",
                                "datos"=>$resultado,
                                "continuar"=>1);
            }
            else
            {
                $salida = array("mensaje"=>"No se ha podido actualizar la categoría, intente de nuevo más tarde",
                                "datos"=>array(),
                                "continuar"=>1);
            }
        }
        return $salida;
    }

    public function eliminaProducto($post)
    {
        extract($post);
        $dataActualiza['idEstado']      = 0;
        $where['idPresentacion']        = $idPresentacion;
        $where['idTienda']              = $idTienda;
        $resultado = $this->ci->dbHome->actualizaProducto($where,$dataActualiza);
        if($resultado > 0)
        {

            $dataActualizaV['idEstado']      = 0;
            $whereV['idPresentacion']        = $idPresentacion;
            $whereV['idTienda']              = $idTienda;
            $resultadoV = $this->ci->dbHome->actualizaVariacion($whereV,$dataActualizaV);
            //actualio todas las variaciones que tenga el producto
            $salida = array("mensaje"=>"El producto se la eliminado de manera corecta",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No se ha podido eliminar el producto, intente de nuevo más tarde",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    public function eliminaVariacion($post)
    {
        extract($post);
        $dataActualiza['idEstado']      = 0;
        $where['idVariacion']           = $idVariacion;
        $where['idTienda']              = $idTienda;
        $resultado = $this->ci->dbHome->actualizaVariacion($where,$dataActualiza);
        if($resultado > 0)
        {
            //actualio todas las variaciones que tenga el producto
            $salida = array("mensaje"=>"La variacion se ha eliminado de manera corecta",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No se ha podido eliminar la variacion, intente de nuevo más tarde",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    public function ordenaCategorias($post)
    {
        extract($post);
        $dataActualiza['orden']    = $orden;
        $where['idProducto']       = $id;
        $where['idTienda']         = $idTienda;
        $resultado = $this->ci->dbHome->ordenaCategorias($where,$dataActualiza);
        if($resultado > 0)
        {
            //actualio todas las variaciones que tenga el producto
            $salida = array("mensaje"=>"Orden realizado",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"Orden no realizado",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    // info de banner
    public function infoBanner($idBanner)
    {
        $where['idBanner'] = $idBanner;
        if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
        {
            $where['idTienda']   = $_SESSION['project']['info']['idTienda'];
        }
        $resultado = $this->ci->dbHome->getBanner($where);
        if(count($resultado) > 0)
        {
            $salida = array("mensaje"=>"Info de banners",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No existe la banners seleccionados",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }

    //procesa crar o actualizar banner
    public function procesaBanner($post)
    {   
        extract($post);
        // $idTienda       = "";
        $tipoLink       = "";
        $linkBanner     = "";
        $idCategoria    = "";
        $idSubcategoria = "";
        $idPresentacion = "";
        

        // var_dump($post);die();
        if($edita == 0)//agrega
        {
            unset($post['edita']);
            unset($post['idBanner']);
            $post['idTienda']           = mb_strtoupper($post['idTienda']);
            $post['tituloBanner']       = mb_strtoupper($post['tituloBanner']);
            //var_dump($post);die();
            $resultado = $this->ci->dbHome->procesaBanner($post);
            if($resultado > 0)
            {
                $salida =   "";
                $salida =   array("mensaje"=>lang("lbl_alert_exito"),
                                "datos"=>$resultado,
                                "continuar"=>1);
            }
            else
            {
                $salida =   array("mensaje"=>"No se ha podido crear el banner, intente de nuevo más tarde",
                                "datos"=>array(),
                                "continuar"=>0);
            }
        }
        else//actualiza
        {
            if($post["tipoLink"] === "producto"){

                $where['idBanner']                  = $idBanner;
                $dataActualiza['tituloBanner']      = mb_strtoupper($post['tituloBanner']);
                $dataActualiza['fotoBanner']        = $post['fotoBanner'];   
                $dataActualiza['tipoLink']          = $tipoLink;
                $dataActualiza['linkBanner']        = $linkBanner;
                $dataActualiza['idCategoria']       = $post['idCategoria'];
                $dataActualiza['idSubcategoria']    = $post['idSubcategoria'];
                $dataActualiza['idPresentacion']    = $post['idPresentacion'];

                $resultado = $this->ci->dbHome->actualizaBanner($where,$dataActualiza);
                if($resultado > 0)
                {
                    $salida =   array("mensaje"=>lang("lbl_alert_exito_edita"),
                                    "datos"=>$resultado,
                                    "continuar"=>1);
                }
                else
                {
                    $salida =   array("mensaje"=>"No se ha podido actualizar el banner, intente de nuevo más tarde",
                                    "datos"=>array(),
                                    "continuar"=>0);
                }

            }
            else if($post["tipoLink"] == "url"){

                $where['idBanner']                  = $idBanner;
                $dataActualiza['tituloBanner']      = mb_strtoupper($post['tituloBanner']);
                $dataActualiza['fotoBanner']        = $post['fotoBanner'];   
                $dataActualiza['tipoLink']          = $post['tipoLink'];
                $dataActualiza['linkBanner']        = $post['linkBanner'];
                $dataActualiza['idCategoria']       = $idCategoria;
                $dataActualiza['idSubcategoria']    = $idSubcategoria;
                $dataActualiza['idPresentacion']    = $idPresentacion;
                $resultado = $this->ci->dbHome->actualizaBanner($where,$dataActualiza);
                if($resultado > 0)
                {
                    $salida =   array("mensaje"=>lang("lbl_alert_exito_edita"),
                                    "datos"=>$resultado,
                                    "continuar"=>1);
                }
                else
                {
                    $salida =   array("mensaje"=>"No se ha podido actualizar el banner, intente de nuevo más tarde",
                                    "datos"=>array(),
                                    "continuar"=>0);
                }
            }
        }
        return $salida;
    }
    //se consulta los banner
    public function getBanner($where=array())
    {
        $resultado = $this->ci->dbHome->getBanner($where);
        if(count($resultado) > 0)
        {
            $salida = array("mensaje"=>"Banner consultados",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No hay banner creados",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    //se elimina el banner
    public function eliminaBanner($post)
    {
        $dataActualiza['idEstado'] = 0;
        $resultado = $this->ci->dbHome->eliminaBanner($post,$dataActualiza);
        if($resultado > 0)
        {
            $salida = array("mensaje"=>lang("lbl_alert_exito_elimina"),
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No se ha podido eliminar la categoría, intente de nuevo más tarde",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    //se ordenan los banner
    public function ordenaBanner($post)
    {
        extract($post);
        $dataActualiza['orden']     = $orden;
        $where['idBanner']          = $id;
        $resultado = $this->ci->dbHome->ordenaBanner($where,$dataActualiza);
        if($resultado > 0)
        {
            //actualio todas las variaciones que tenga el producto
            $salida = array("mensaje"=>"Orden realizado",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"Orden no realizado",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    //se obtienen todos los productos de la tienda
    public function getProductosTotal($where=array())
    {
        $resultado = $this->ci->dbHome->getProductosTotal($where);
        if(count($resultado) > 0)
        {
            $salida = array("mensaje"=>"presentaciones consultados",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No hay presentaciones consultadas",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    //informacion de todos los productos por idTienda
    public function getAllPresentaciones($where=array())
    {
        $resultado = $this->ci->dbHome->getAllPresentaciones($where);
        if(count($resultado) > 0)
        {
            $salida = array("mensaje"=>"Todos las presentaciones fueron consultadas",
                            "datos"=>$resultado,
                            "continuar"=>1);
        }
        else
        {
            $salida = array("mensaje"=>"No hay presentaciones consultadas",
                            "datos"=>array(),
                            "continuar"=>0);
        }
        return $salida;
    }
    
 }