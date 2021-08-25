<?php
/*

	("`-''-/").___....''"`-._
      `6_ 6  )   `-.  (     ).`-.__.`) 
      (_Y_.)'  ._   )  `._ `. ``-..-'
    _..`..'_..-_/  /..'_.' ,'
   (il),-''  (li),'  ((!.-'

   Desarrollado por @orugal
   https://github.com/orugal
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class Notificaciones extends CI_Controller 
{
	function __construct() 
    {
        parent::__construct();
        $this->load->model("notificaciones/LogicaNotificaciones", "logicaNoti");
        $this->load->model("general/LogicaGeneral", "logica");
        $this->load->model("general/BaseDatosGral","dbGeneral");
        $this->load->helper('language');
        $this->lang->load('spanish');
    }

    public function notificaciones($idModulo)
    {
        if(validaIngreso())
        {
            /*******************************************************************************************/
            /* ESTA SECCIÓN DE CÓDIGO  ES MUY IMPORTANTE YA QUE ES LA QUE CONTROLARÁ EL MÓDULO VISITADO*/
            /*******************************************************************************************/
            //si no se declara está variable en cada inicio del módulo no se podrán consultar los privilegios
            $_SESSION['moduloVisitado']     =   $idModulo;
            //antes de pintar la plantilla del módulo valido si hay permisos de ver ese módulo para evitar que ingresen al módulo vía URL
            if(getPrivilegios()[0]['ver'] == 1)
            { 
                //sendFCM("App ventas Wannabe","La opción más fácil, económica y rápida de vender tus productos online.","fYJVwh1WFgo:APA91bHzSwXU0oev_V1EVCANzngMitTBzt69EYLAz3vIoFJjIIUEPcO-Agn1tM1sx1qWK45q__zHOgJkbDf7YkmZ8n5Cn3nUOWSQ076zAmEsSsieQNG5o5m3KskLjZbN7qsblcrS1DSd");
                //info Módulo
                $infoModulo                 = $this->logica->infoModulo($idModulo);
                $listaUsuarios              = $this->logica->getPersonas(array('eliminado'=>0,'estado'=>1,'FCMToken !='=>''));
                $opc                        = "home";
                $salida['titulo']           = lang("titulo")." - ".$infoModulo[0]['nombreModulo'];
                $salida['centro']           = "notificaciones/home";
                $salida['infoModulo']       = $infoModulo[0];
                $salida['listaUsuarios']     = $listaUsuarios;
                $this->load->view("app/index",$salida);
            }
            else
            {
                $opc                   = "home";
                $salida['titulo']      = lang("titulo")." - Área Restringida";
                $salida['centro']      = "error/areaRestringida";
                $this->load->view("app/index",$salida);
            }
        }
        else
        {
            header('Location:'.base_url()."login");
        }
    }

    public function sendNotificacionPush()
    {
        //var_dump($_POST);
        $listaUsuarios              = $this->logica->getPersonas(array('eliminado'=>0,'estado'=>1,'FCMToken !='=>''));
        $count = 0;
        foreach($listaUsuarios as $lu)
        {
            sendFCM($_POST['tituloNotificacion'],$_POST['mensajeNotificacion'],$lu['FCMToken']);
            
            //registro la notificacion en la base de datos
            $datosNotificacion['idPersona'] = $lu['idPersona'];
            $datosNotificacion['tipo']      = 'mensaje';
            $datosNotificacion['titulo']    = $_POST['tituloNotificacion'];
            $datosNotificacion['mensaje']   = $_POST['mensajeNotificacion'];
            $datosNotificacion['fecha']     = date("Y-m-d H:i:s");

            $insertoNotificacion = $this->dbGeneral->insertaNotificacion($datosNotificacion);

            $count++;
        }
        if(count($listaUsuarios) == $count)
        {
            $salida = array("mensaje"=>"Se han enviado ".count($listaUsuarios)." notificaciones de manera exitosa.");
        }
        else
        {
            $salida = array("mensaje"=>"Se han enviado ".$count." notificaciones de manera exitosa.");
        }
        echo json_encode($salida);
    }

}