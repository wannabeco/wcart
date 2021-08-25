<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class baseDatosTienda extends CI_Model {
    private $tableTipos                 =   "";
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->tableTiendas               = "app_tiendas"; 
        $this->tablePersonas              = "app_personas"; 
        $this->tableTiposTienda           = "app_tipo_tienda"; 
        $this->tableFotosTemp           = "app_fotos_temp"; 
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
}

?>