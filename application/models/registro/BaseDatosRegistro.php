<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BaseDatosRegistro extends CI_Model {
    private $tableEmpresas                 =   "";
    private $tablePersonas                 =   "";
    private $tableClaveEmpresa             =   "";
    private $tablePagosEmpresa             =   "";
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->tableEmpresas               = "app_empresas"; 
        $this->tablePersonas               = "app_personas"; 
        $this->tableClaveEmpresa           = "app_login"; 
        $this->tablePagosEmpresa           = "app_estadopago"; 
        $this->tableLlamadas               = "app_llamadas"; 
    }
    public function verificaEmpresa($where,$tabla){
        $this->db->select("*");
        $this->db->where($where);
        if($tabla == "empresas")
        {
            $this->db->from($this->tableEmpresas);
        }
        else
        {
             $this->db->from($this->tablePersonas);
        }
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }
    //registro empresa
    public function insertaEmpresa($dataInserta){

        $this->db->insert($this->tableEmpresas,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    public function insertaClaveEmpresa($dataInserta){

        $this->db->insert($this->tableClaveEmpresa,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    public function insertaPago($dataInserta){

        $this->db->insert($this->tablePagosEmpresa,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    //registro persona
    public function insertaPersona($dataInserta){

        $this->db->insert($this->tablePersonas,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    //registro persona
    public function guardaSeguimiento($dataInserta){

        $this->db->insert($this->tableLlamadas,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    //registro persona
    public function actualizaPersona($dataInserta,$where){

        $this->db->where($where);
        $this->db->update($this->tablePersonas,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    public function insertaClavePersona($dataInserta){

        $this->db->insert($this->tableClaveEmpresa,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }

    /*$this->db->where($where);
    $this->db->update($this->tableViviendaPersona,$info);
    //print_r($this->db->last_query());die();
    return $this->db->affected_rows();*/
}

?>