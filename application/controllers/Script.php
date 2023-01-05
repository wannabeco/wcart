<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Script extends CI_Controller 
{
	function __construct() 
    {
        parent::__construct();
        $this->load->model("general/LogicaGeneral", "logica");
        $this->load->model("home/LogicaHome", "logicaHome");
       	$this->load->helper('language');//mantener siempre.
    }
    
	//informacion de todas las tiendas
    public function caducarTiendas()
    {
       $idEstado = 1;
       $infoTiendas = $this->logica->caducarTiendas($idEstado);
       //var_dump($infoTiendas);die();
       if(count($infoTiendas['datos']) > 0){
        foreach ($infoTiendas['datos'] as $tiendas){
            $fechaCaduca            = $tiendas['fechaCaducidad'];
            $idTienda               = $tiendas['idTienda'];
            $where['idTienda']      = $tiendas['idTienda'];
            $where['plan']          = $tiendas['Plan'];
            $where['paquete']       = $tiendas['paquete'];
            $where['fechaInicio']   = $tiendas['fechaInicioMembresia'];
            $where['fechaFinal']    = $tiendas['fechaCaducidad'];
            $mantenimientos         = $tiendas['manteminiento'];
            $caduca                 = $tiendas['caduca'];
            if(date('Y-m-d') > $fechaCaduca){
                $tienda['idTienda'] = $idTienda;
                if($caduca == 0){
                    $mantenimiento = $this->logica->actualizaMantenimiento($tienda);
                    $insert = $this->logica->insertdata($where);
                    echo "para mantenimiento: ".$idTienda. "<br>";
                }
            }
            else{
                echo "no caduco: ".$idTienda. "<br>";
            }
        }
       }
       else{
            echo "no hay tiendas";
       }
    }
    // eliminacion automatica de pagos donde estadoPago=0
    public function eliminaPagos(){
        $estadoPago =0;
        $infoPago = $this->logica->eliminaPagos($estadoPago);
        //var_dump($infoPago);die();
        if(count($infoPago['datos'])>0){
            foreach ($infoPago['datos'] as $pagos){
                $where['idTienda']          = $pagos['idTienda'];
                $where['codigoPago']        = $pagos['codigoPago'];
                $where['idMembresia']       = $pagos['idMembresia'];
                $where['fechaPago']         = $pagos['fechaPago'];
                $where['fechaEliminado']    = date('Y-m-d H:m:s');
                $where['emailPago']         = $pagos['nombrePersona'];
                $eliminados = $this->logica->eliminados($where);
                if($eliminados['continuar'] == 1){
                    $idMembresia      = $pagos['idMembresia'];
                    $eliminar   = $this->logica->eliminar($idMembresia);
                }
                else{
                    echo "no se elimino: ".$pagos['idMembresia']."<br>";
                }
                
            }
        }
    }


}

       
