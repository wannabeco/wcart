<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class BaseDatosUsuarios extends CI_Model {
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
        $this->tablePedidos              = "app_pedidos";
        $this->tableTiposDoc             = "app_tipos_doc";

    }
    public function agregaUsuario($dataInserta)
    {
        $this->db->insert($this->tablePersonas,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    public function insertaUsuarioLogin($dataInserta)
    {
        $this->db->insert($this->tableLogin,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->insert_id();
    }
    public function actualizaUsuario($where,$dataInserta)
    {
        $this->db->where($where);
        $this->db->update($this->tablePersonas,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    public function cambioClave($where,$dataInserta)
    {
        $this->db->where($where);
        $this->db->update($this->tableLogin,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    public function generaDatosAcceso($where,$dataInserta)
    {
        $this->db->where($where);
        $this->db->update($this->tableLogin,$dataInserta);
        //print_r($this->db->last_query());die();
        return $this->db->affected_rows();
    }
    public function infoUsuario($where="")
    {
        $this->db->select("u.*,u.estado as estadoU,p.nombrePerfil,a.nombreArea,D.nombreTipoDoc,t.NOMBRE,C.NOMBRE,l.*");
        if(count($where) > 0)
        {
            $this->db->where($where);
        }
        $this->db->from($this->tablePersonas." u");
        $this->db->join($this->tablePerfiles." p","p.idPerfil=u.idPerfil","INNER");
        $this->db->join($this->tableAreas." a","a.idArea=u.idArea","INNER");
        $this->db->join($this->tableTiposDoc." D","D.idTipoDoc=u.tipoDocumento","INNER");
        $this->db->join($this->tableDeptos." t","t.ID_DPTO=u.departamento","INNER");
        $this->db->join($this->tableCiudad." C","C.ID_CIUDAD=u.ciudad","INNER");
        $this->db->join($this->tableLogin." l","l.idGeneral=u.idPersona","LEFT");
        if ($_SESSION['project']['info']['idPerfil'] == 6 ){
        $this->db->join($this->tablePedidos." ped","u.idPersona=ped.idPersona","LEFT");
        }
        $this->db->group_by('u.idPersona');
        $id = $this->db->get();
        //print_r($this->db->last_query());die();
        return $id->result_array();
    }    
}

?>