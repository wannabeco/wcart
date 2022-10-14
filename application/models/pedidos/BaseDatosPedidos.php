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

class BaseDatosPedidos extends CI_Model {
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
        $this->tableDeptos               = "app_departamentos"; 
        $this->tableCiudad               = "app_ciudades"; 
        $this->tableMails                = "app_mails";
        $this->tableInfoPago             = "app_estadopago";
        $this->tableLogin                = "app_login";
        $this->tableEmpresas             = "app_empresas";
        $this->tablePersonas             = "app_personas";
        $this->tablePerfiles             = "app_perfiles";
        $this->tableAreas                = "app_areas";
        $this->tableModulos              = "app_modulos";
        $this->tableRelPerfilModulo      = "app_rel_perfil_modulo";
        $this->tablePagos                = "app_pagos_cliente";
        $this->tablePedidos              = "app_pedidos";
        $this->tableDetallePedidos       = "app_detalle_pedido";
        $this->tableEstadoPedido         = "app_estado_pedido";
        $this->tableProductos            = "app_productos";
        $this->tableCiudadesVenta        = "app_ciudades_venta";
        $this->tablePresentaciones       = "app_presentacion_producto";
        $this->tablePedidosTmp           = "app_pedido_temporal";
        $this->tableConjuntos            = "app_conjuntos";
        $this->tableGanancias            = "app_estaditicas_vendedor";
        $this->tableInventario           = "app_inventario_producto";
        $this->tablePersonasEntrega      = "app_remitentes_limon";
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


    //inserto las estadisticas de venta
    public function insertaVentas($dataInserta)
    {
        $this->db->insert($this->tableGanancias,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    } 

    //actualiza el pedido temporal
    public function updatePedidoTemporal($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tablePedidosTmp,$dataActualiza);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    //actualiza el pedido temporal
    public function updatePedido($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tablePedidos,$dataActualiza);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    public function verificaPedidoTemp($where="")
    {
        $this->db->select("*");
        $this->db->where($where);
        $this->db->from($this->tablePedidosTmp);
        $id = $this->db->get();
        // print_r($this->db->last_query());die();
        return $id->result_array();
    }
    public function getInfoRemitentes($where=array())
    {
        $this->db->select("*");
        if(count($where) > 0)
        {
            $this->db->where($where);
        }
        $this->db->from($this->tablePersonasEntrega);
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }
    public function getInventario($where=array())
    {
        $this->db->select("*");
        if(count($where) > 0)
        {
            $this->db->where($where);
        }        
        $this->db->from($this->tableInventario." i");
        $this->db->join($this->tablePersonasEntrega." per","per.idRemitente = i.idPersonaEntrega","inner");
        $this->db->join($this->tablePersonas." pe","pe.idPersona = i.idPersonaRecibe","inner");
        $this->db->join($this->tableProductos." pro","pro.idProducto = i.idProducto","inner");
        $this->db->order_by('idInventario','DESC');
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }
    public function sumaTotalInventario($where=array())
    {
        $this->db->select("sum(cantidadKilos) as totalKilos");
        if(count($where) > 0)
        {
            $this->db->where($where);
        }        
        $this->db->from($this->tableInventario);
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }
    public function insertaPedidoTemp($dataInserta)
    {
        $this->db->insert($this->tablePedidosTmp,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    public function registraProductoStock($dataInserta)
    {
        $this->db->insert($this->tableInventario,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    public function registraRemitente($dataInserta)
    {
        $this->db->insert($this->tablePersonasEntrega,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    //copear y pegar este query las veces que sea necesario realizar actualizaciones en las tablas de la db, recordar cambiar el nombre
    public function actualizaRemitente($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tablePersonasEntrega,$dataActualiza);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    //copear y pegar este query las veces que sea necesario realizar actualizaciones en las tablas de la db, recordar cambiar el nombre
    public function actualizaProductoStock($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tableInventario,$dataActualiza);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    //copear y pegar este query las veces que sea necesario realizar actualizaciones en las tablas de la db, recordar cambiar el nombre
    public function actualizaPedidoTemp($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tablePedidosTmp,$dataActualiza);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    //elimina item de un pedido
    public function eliminaItemTemporal($where)
    {
        $this->db->where($where);
        $this->db->delete($this->tablePedidosTmp);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }

    public function borraPedidoTemporal($where)
    {
        $this->db->where($where);
        $this->db->delete($this->tablePedidosTmp);
        //$this->db->from($this->tablePedidosTmp);
        return $this->db->affected_rows();
    }
    public function getPedidoTemporal($where)
    {
        $this->db->select("*");
        if(count($where) > 0)
        {            
            $this->db->where($where);
        }
        $this->db->from($this->tablePedidosTmp." d");
        $this->db->join($this->tableProductos." p","p.idProducto = d.idProducto",'INNER');
        $this->db->join($this->tablePresentaciones." pre","pre.idPresentacion=d.idPresentacion",'INNER');
        $this->db->order_by("d.idPresentacion","ASC");
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }

    ///logica desde acá
    public function getPedidos($where=array())
    {
        $this->db->select("*,p.direccion as direccionPedido, p.telefono as telefonoPedido,p.idTienda as tienda");
        if(count($where) > 0)
        {            
            $this->db->where($where);
        }
        $this->db->from($this->tablePedidos." p");
        $this->db->join($this->tablePersonas." per","per.idPersona=p.idPersona",'INNER');
        $this->db->join($this->tableEstadoPedido." e","e.idEstadoPedido=p.estadoPedido",'INNER');
        $this->db->join($this->tableConjuntos." c","c.idConjunto=per.idConjunto",'LEFT');
        //$this->db->join($this->tableCiudadesVenta." ciu","ciu.idCiudad=p.idCiudad",'INNER');
        $this->db->order_by("idPedido","DESC");
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    } 

    ///listado de pedidos que Raul le hace a Esmeralda
    public function misPedidos($where=array())
    {
        $this->db->select("*,p.direccion as direccionPedido, p.telefono as telefonoPedido ");
        if(count($where) > 0)
        {            
            $this->db->where($where);
        }
        $this->db->from($this->tablePedidos." p");
        $this->db->join($this->tablePersonas." per","per.idPersona=p.idPersona",'INNER');
        $this->db->join($this->tableEstadoPedido." e","e.idEstadoPedido=p.estadoPedido",'INNER');
        //$this->db->join($this->tableCiudadesVenta." ciu","ciu.idCiudad=p.idCiudad",'INNER');
        $this->db->order_by("idPedido","DESC");
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }  

    ///listado de pedidos que Raul le hace a Esmeralda
    public function misPedidosHome($where=array())
    {
        $this->db->select("*,p.direccion as direccionPedido, p.telefono as telefonoPedido ");
        if(count($where) > 0)
        {            
            $this->db->where($where);
        }
        $this->db->from($this->tablePedidos." p");
        $this->db->join($this->tablePersonas." per","per.idPersona=p.idPersona",'INNER');
        $this->db->join($this->tableEstadoPedido." e","e.idEstadoPedido=p.estadoPedido",'INNER');
        //$this->db->join($this->tableCiudadesVenta." ciu","ciu.idCiudad=p.idCiudad",'INNER');
        $this->db->order_by("idPedido","DESC");
        $this->db->limit(10);
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }   

    ///logica desde acá
    public function productosPedidos($where=array())
    {
        $this->db->select("*");
        if(count($where) > 0)
        {            
            $this->db->where($where);
        }
        $this->db->from($this->tableDetallePedidos." d");
        $this->db->join($this->tableProductos." p","p.idProducto = d.idProducto",'INNER');
        //$this->db->join($this->tablePersonas." per","per.idPersona=d.idPersona",'INNER');
        $this->db->join($this->tablePresentaciones." pre","pre.idPresentacion=d.idPresentacion",'INNER');
        $this->db->order_by("d.idDetalle","ASC");
        //$this->db->group_by("d.idDetalle");
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    } 

    ///logica desde acá
    public function informeVentas($where=array())
    {
        $this->db->select("*");
        if(count($where) > 0)
        {            
            $this->db->where($where);
        }
        $this->db->from($this->tablePedidos." p");
        $this->db->join($this->tableDetallePedidos." dp","dp.idPedido=p.idPedido",'INNER');
        $this->db->join($this->tableProductos." pro","pro.idProducto=dp.idProducto",'INNER');
        $this->db->join($this->tablePersonas." per","per.idPersona=p.idPersona",'INNER');
        $this->db->join($this->tablePresentaciones." pre","pre.idPresentacion=dp.idPresentacion",'INNER');
        $this->db->order_by("p.fechaPedido","ASC");
        //$this->db->order_by("p.fechaEntrega","ASC");
        //$this->db->group_by("d.idDetalle");
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    } 
}

?>