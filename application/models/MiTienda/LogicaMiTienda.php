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
class LogicaMiTienda  {
    private $ci;
    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model("MiTienda/BaseDatosMiTienda","dbMiTienda");//reemplazar por el archivo de base de datos real
    } 
    //info tienda
    public function infoTienda($idTienda){
        $where['idTienda'] = $idTienda;
        $infoTienda=$this->ci->dbMiTienda->infoTienda($where);
        return $infoTienda;
    }
    //info tipo
    public function infoTipoTienda(){
        $where['eliminado'] = 0;
        $TipoTienda=$this->ci->dbMiTienda->infoTipoTienda($where);
        return $TipoTienda;
    }
    public function infoDisenoTienda(){
        $DisenoTienda=$this->ci->dbMiTienda->infoDisenoTienda(array());
        return $DisenoTienda;
    }
    //info paises
    public function infopaises(){
        $where['ID_PAIS']= '057';
        $paises=$this->ci->dbMiTienda->infopaises($where);
        return $paises;
    }
    //info departamentos
    public function infodepartamentos($idpais){
        $where['estado'] = 1;
        $where['ID_PAIS'] = $idpais;
        $departamentos=$this->ci->dbMiTienda->infodepartamentos($where);
        return $departamentos;
    }
    //info ciudades
    public function infociudades($idpais, $idDepartamentos){
        $where['estado'] = 1;
        $where['ID_PAIS'] = $idpais;
        $where['ID_DPTO'] = $idDepartamentos;
        $ciudades=$this->ci->dbMiTienda->infociudades($where);
        return $ciudades;
    }
    //insertar logos
    
    //actualiza datos tienda
    public function actualizaMiTienda($data)
    {
        extract($data);
        //var_dump($data);die();
        $where = array("idTienda"=>$idTienda);
        unset($data['idTienda']);
        $idTienda = $this->ci->dbMiTienda->actualizaMiTienda($data,$where);
        if($idTienda > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");

        }
        return $respuesta;
    }
    
    public function actualizaPagos($data){
        extract($data);
        
        //var_dump($data);die();
        $where = array("idTienda"=>$idTienda);
        unset($data['idTienda']);
        
        $idTienda = $this->ci->dbMiTienda->actualizaPagos($data,$where);
        if($idTienda > 0)
        {
            $respuesta = array("mensaje"=>"La información ha sido modificada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser modificada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");

        }
        return $respuesta;
    }
    
 }