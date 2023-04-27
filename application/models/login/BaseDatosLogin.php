<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BaseDatosLogin extends CI_Model {
    private $tableEmpresas              =   "";
    private $tablePersonas              =   "";
    private $tableLogin                 =   "";
    private $tableRegistrosLogin        =   "";
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
        $this->tableEmpresas               = "app_empresas"; 
        $this->tablePersonas               = "app_personas"; 
        $this->tableLogin                  = "app_login"; 
        $this->tableRegistrosLogin         = "app_registroslogin"; 
    }
    public function buscaEmpresa($where,$tabla){
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
    public function verificaUsuarioyClave($where,$whereIn=array())
    {
        $this->db->select("*, idGeneral as idusuario");
        $this->db->where($where);
        //$this->db->or_where(array("celular"=>$where['usuario']));
        if(isset($where['clave']))
        {
            $this->db->where(array("clave"=>$where['clave']));
        }
        if(count($whereIn) > 0)
        {
            $this->db->where_in('p.idPerfil',$whereIn);
        }
        $this->db->from($this->tableLogin." l");
        $this->db->join($this->tablePersonas." p","p.idPersona=l.idGeneral");
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }
    public function registraIngreso($dataInserta)
    {
        $this->db->insert($this->tableRegistrosLogin,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
}

?>