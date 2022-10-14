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

    class BaseDatosMiTienda extends CI_Model {
    
        private $tableTiendas                =   "";
        private $tableTipoTienda             =   "";
        private $tablePaises                 =   "";
        private $tableDepartamentos          =   "";
        private $tableCiudades               =   "";
        private $categorias                  =   "";

        public function __construct() 
        {
            parent::__construct();
            //asignación de las tablas, siempre se deben asignar las tablas que se vayan a usar.
            $this->load->database();
            $this->tableTiendas             = "app_tiendas";
            $this->tableTipoTienda          = "app_tipo_tienda";
            $this->tablePaises              = "app_paises";
            $this->tableDepartamentos       = "app_departamentos";
            $this->tableCiudades            = "app_ciudades";
            $this->categorias               = "app_productos";
    
        }
        //copear y pegar este query las veces que sea necesario para hacer una inserción, recordar cambiar el nombre
        //public function queryInsert($dataInserta)
        // {
        //     $this->db->insert($this->tablePersonas,$dataInserta);
        //     //print_r($this->db->last_query());die();
        //     return $this->db->insert_id();
        // }
        //copear y pegar este query las veces que sea necesario realizar actualizaciones en las tablas de la db, recordar cambiar el nombre
        // public function queryUpdate($where,$dataActualiza)
        // {
        //     $this->db->where($where);
        //     $this->db->update($this->tablePersonas,$dataActualiza);
        //     //print_r($this->db->last_query());die();
        //     return $this->db->affected_rows();
        // }

    //copear y pegar este query las veces que sea necesario realizar seleccion de datos en las tablas de la db, recordar cambiar el nombre
        public function infoTienda($where="")
        {
            $this->db->select("*");
            $this->db->where($where);
            $this->db->from($this->tableTiendas);
            $id = $this->db->get();
            //print_r($this->db->last_query());die();
            return $id->result_array();
        }
        //categorias
        public function infocategorias($where="")
        {
            $this->db->select("*");
            $this->db->where($where);
            $this->db->from($this->categorias);
            $id = $this->db->get();
            //print_r($this->db->last_query());die();
            return $id->result_array();
        }

        //tipo de tienda
        public function infoTipoTienda($where="")
        {
            $this->db->select("*");
            $this->db->where($where);
            $this->db->from($this->tableTipoTienda);
            $id = $this->db->get();
            //print_r($this->db->last_query());die();
            return $id->result_array();
        }

        //diseno tienda
        public function infoDisenoTienda($where=""){
            $this->db->select("*");
            if(count($where)>0){
                $this->db->where($where);   
            }
            $this->db->from($this->tableTiendas);
            $id = $this->db->get();
                //print_r($this->db->last_query());die();
                return $id->result_array();
            
        }

        //info de paises
        public function infopaises($where="")
        {
            $this->db->select("*");
            $this->db->where($where);
            $this->db->from($this->tablePaises);
            $id = $this->db->get();
            //print_r($this->db->last_query());die();
            return $id->result_array();
        }
        //info departamentos
        public function infodepartamentos($where="")
        {
            $this->db->select("*");
            $this->db->where($where);
            $this->db->from($this->tableDepartamentos);
            $id = $this->db->get();
            //print_r($this->db->last_query());die();
            return $id->result_array();
        }
        //info ciudades
        public function infociudades($where="")
        {
            $this->db->select("*");
            $this->db->where($where);
            $this->db->from($this->tableCiudades);
            $id = $this->db->get();
            //print_r($this->db->last_query());die();
            return $id->result_array();
        }
        //actualizar datos basicos
        public function actualizaMiTienda($data,$where)
        {
            $this->db->where($where);
            $this->db->update($this->tableTiendas,$data);
            //print_r($this->db->last_query());die();
            return $this->db->affected_rows();
        }
        //actualiza Pagos
        public function actualizaPagos($data,$where)
        {
            $this->db->where($data,$where);
            $this->db->update($this->tableTiendas,$data);
            //print_r($this->db->last_query());die();
            return $this->db->affected_rows();
        }
    }

?>