<?php
/*

    ("`-''-/").___....''"`-._
      `6_ 6  )   `-.  (     ).`-.__.`) 
      (_Y_.)'  ._   )  `._ `. ``-..-'
    _..`..'_..-_/  /..'_.' ,'
   (il),-''  (li),'  ((!.-'

   Desarrollado por @orugal
   https://github.com/orugal

   Este archivo modelo de base de datos se encargará de realizar los querys de inserción, selección, actualización, eliminación de la base de datos,
   aquí solo se obtiene información, aquí no se deben hacer condicionales ni nada por el estilo, eso de hace en el modelo de lógica.
   
*/
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BaseDatosHome extends CI_Model {
    private $tableDeptos                 =   "";
    private $tableCiudad                 =   "";
    private $tableMails                  =   "";
    private $tableInfoPago               =   "";
    private $tableEmpresas               =   "";
    private $tablePersonas               =   "";
    private $tableAreas                  =   "";
    public function __construct() 
    {
        parent::__construct();
        //asignación de las tablas, siempre se deben asignar las tablas que se vayan a usar.
        $this->load->database();
        $this->tablePersonas             = "app_personas";
        $this->tableNotificaciones       = "app_noti";
        $this->tableCategorias           = "app_productos";
        $this->tableSubCategorias        = "app_subproductos";
        $this->tableProductos            = "app_presentacion_producto";
        $this->tableRelLike              = "app_rel_likes";
        $this->tableTiendas              = "app_tiendas";
        $this->tablePedidoTemporal       = "app_pedido_temporal";
        $this->tableVariaciones          = "app_variaciones";
    }

    //--------------------------------------------------------------------------------------------------
    //copear y pegar este query las veces que sea necesario para hacer una inserción, recordar cambiar el nombre
    public function queryInsert($dataInserta)
    {
        $this->db->insert($this->tablePersonas,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    //copear y pegar este query las veces que sea necesario realizar actualizaciones en las tablas de la db, recordar cambiar el nombre
    public function queryUpdate($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tablePersonas,$dataActualiza);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
   //copear y pegar este query las veces que sea necesario realizar seleccion de datos en las tablas de la db, recordar cambiar el nombre
    public function querySelect($where="")
    {
        $this->db->select("*");
        $this->db->where($where);
        $this->db->from($this->tablePersonas);
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }  

    public function getInfoTienda($where="")
    {
        $this->db->select("*");
        $this->db->where($where);
        $this->db->from($this->tableTiendas);
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }
    public function getInfoTiendaLike($url="")
    {
        $this->db->select("*");
        //$this->db->where(arra);
        $this->db->like('dominioTienda',$url);
        $this->db->from($this->tableTiendas);
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }
    public function getCategorias($where="")
    {
        $this->db->select("*");
        $this->db->where($where);
        $this->db->from($this->tableCategorias);
        $this->db->order_by("orden","ASC");
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }  
    public function getSubcategorias($where="")
    {
        $this->db->select("*");
        $this->db->where($where);
        $this->db->from($this->tableSubCategorias);
        $this->db->order_by("nombreSubcategoria","ASC");
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }  
    public function getSubcategoriasAnidada($where="")
    {
        $this->db->select("*");
        $this->db->where($where);
        $this->db->from($this->tableSubCategorias." s");
        $this->db->join($this->tableCategorias." c","c.idProducto=s.idProducto","INNER");
        $this->db->order_by("s.idProducto","ASC");
        $this->db->order_by("s.nombreSubcategoria","ASC");
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }  


    public function getProductos($where=array())
    {
        $this->db->select("*");
        if(count($where) > 0)
        {
            $this->db->where($where);
        }

        $this->db->from($this->tableProductos." p");
        $this->db->join($this->tableCategorias." c","c.idProducto=p.idProducto","INNER");
        $this->db->join($this->tableSubCategorias." s","s.idSubcategoria=p.idSubcategoria and p.idProducto=s.idProducto","INNER");


        $this->db->order_by("idPresentacion","DESC");
        //$this->db->order_by("likes","DESC");
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }  
    public function getProductosAnidados($where=array())
    {
        $this->db->select("*");
        if(count($where) > 0)
        {
            $this->db->where($where);
        }
        $this->db->from($this->tableProductos." p");
        $this->db->join($this->tableCategorias." c","c.idProducto=p.idProducto","INNER");
        $this->db->join($this->tableSubCategorias." s","s.idSubcategoria=p.idSubcategoria and p.idProducto=s.idProducto","INNER");
        $this->db->order_by("c.idProducto","ASC");
        $this->db->order_by("s.idSubcategoria","ASC");
        $this->db->order_by("p.fecha","DESC");
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }  
    public function verificaLike($where=array())
    {
        $this->db->select("*");
        if(count($where) > 0)
        {
            $this->db->where($where);
        }
        $this->db->from($this->tableRelLike);
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    } 
    public function procesaLike($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tableProductos,$dataActualiza);
       // print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    public function ordenaCategorias($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tableCategorias,$dataActualiza);
       // print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    public function relLike($dataInserta)
    {
        $this->db->insert($this->tableRelLike,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    public function delRelLike($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tableRelLike,$dataActualiza);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    public function verificaCarrito($where=array())
    {
        $this->db->select("*");
        if(count($where) > 0)
        {
            $this->db->where($where);
        }
        $this->db->from($this->tablePedidoTemporal);
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }
    public function leerCarrito($where=array())
    {
        $this->db->select("pre.fotoPresentacion as fotoProducto,p.*,pre.*,sub.*,var.*,ti.*");
        $this->db->where($where);
        $this->db->from($this->tablePedidoTemporal." p");
        $this->db->join($this->tableProductos." pre","pre.idPresentacion=p.idPresentacion","INNER");
        $this->db->join($this->tableCategorias." cat","pre.idProducto = cat.idProducto","INNER");
        $this->db->join($this->tableSubCategorias." sub","sub.idSubcategoria = pre.idSubcategoria","INNER");
        $this->db->join($this->tableVariaciones." var","var.idVariacion = p.idVariacion","INNER");
        $this->db->join($this->tableTiendas." ti","ti.idTienda = p.idTienda","INNER");
        $this->db->order_by("idPedidoTemp","ASC");
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }  
    public function insertaEnCarro($dataInserta)
    {
        $this->db->insert($this->tablePedidoTemporal,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    public function actualizaPedido($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tablePedidoTemporal,$dataActualiza);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    public function agregaCategoria($dataInserta)
    {
        $this->db->insert($this->tableCategorias,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    public function actualizaCategoria($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tableCategorias,$dataActualiza);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    public function agregaSubCategoria($dataInserta)
    {
        $this->db->insert($this->tableSubCategorias,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    public function actualizaSubCategoria($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tableSubCategorias,$dataActualiza);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }

    public function agregaProducto($dataInserta)
    {
        $this->db->insert($this->tableProductos,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    public function infoProductoTotal($where=array())
    {
        $this->db->select("*");
        if(count($where) > 0)
        {
            $this->db->where($where);
        }
        $this->db->from($this->tableProductos);
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }
    public function actualizaProducto($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tableProductos,$dataActualiza);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    public function getVariaciones($where=array())
    {
        $this->db->select("*");
        if(count($where) > 0)
        {
            $this->db->where($where);
        }
        $this->db->from($this->tableVariaciones);
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    } 
    public function agregaVariacion($dataInserta)
    {
        $this->db->insert($this->tableVariaciones,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    public function actualizaVariacion($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tableVariaciones,$dataActualiza);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
}

?>