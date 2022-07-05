<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class baseDatosTienda extends CI_Model {
    private $tableTipos                 =   "";
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->tableTiendas                 = "app_tiendas"; 
        $this->tablePersonas                = "app_personas"; 
        $this->tableTiposTienda             = "app_tipo_tienda"; 
        $this->tableFotosTemp               = "app_fotos_temp";
        $this->tableComentarios             = "app_comentarios";
        $this->tableProductos               = "app_presentacion_producto";
        $this->tableVotos                   = "app_votos";
    }
    public function getInfoTienda($where)
    {
        $this->db->select("*");
        $this->db->where($where);
        $this->db->from($this->tableTiendas);
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }
    public function getTiposTienda($where)
    {
        $this->db->select("*");
        $this->db->where($where);
        $this->db->from($this->tableTiposTienda);
        $this->db->order_by("nombreTipoTienda","ASC");
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }
    public function getInfoPropietario($where)
    {
        $this->db->select("*");
        $this->db->where($where);
        $this->db->from($this->tablePersonas);
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }
    // get comentarios
    public function infoComentarios($where)
    {
        $this->db->select("*,com.idComentario as idCom");
        $this->db->where($where);
        $this->db->from($this->tableComentarios." com");
        $this->db->join($this->tablePersonas." pro","com.idUsuario = pro.idPersona","INNER");
        $this->db->join($this->tableVotos." vo","com.idUsuario = vo.idUsuario","INNER");
        $this->db->join($this->tableProductos." prod","com.idPresentacion = prod.idPresentacion","INNER");
        $this->db->order_by("fechaComentario","DESC");
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }
    //get productos
    public function getProductos($where)
    {
        $this->db->select("*");
        $this->db->where($where);
        $this->db->from($this->tableProductos);
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }
    //actualiza comentarios
    public function actualizaComentarios($dataInserta,$where)
    {
        $this->db->where($where);
        $this->db->update($this->tableTiendas,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    //actualiza comentarios
    public function actualizaPresentacion($dataInserta,$where)
    {
        $this->db->where($where);
        $this->db->update($this->tableTiendas,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    public function getUsuarios($where)
    {
        $this->db->select("*");
        $this->db->where($where);
        $this->db->from($this->tableUsuarios);
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }
    public function crearTienda($dataInserta)
    {
        $this->db->insert($this->tableTiendas,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    public function insertaFotoTemp($dataInserta)
    {
        $this->db->insert($this->tableFotosTemp,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    public function creaTendero($dataInserta)
    {
        $this->db->insert($this->tablePersonas,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    public function actualizaTienda($dataInserta,$where)
    {
        $this->db->where($where);
        $this->db->update($this->tableTiendas,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    //elimina comentario
    public function eliminarComentario($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tableComentarios,$dataActualiza);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    //elimina Voto
    public function eliminarVoto($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tableVotos,$dataActualiza);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    //descuenta puntos y votantes
    public function quitarPuntos($where,$dataActualiza)
    {
        $this->db->where($where);
        $this->db->update($this->tableProductos,$dataActualiza);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
}

?>