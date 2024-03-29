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
class LogicaNotificaciones  {
    private $ci;
    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model("notificaciones/BaseNotificaciones","dbNotificaciones");//reemplazar por el archivo de base de datos real
        $this->ci->load->model("general/BaseDatosGral","dbGeneral");//reemplazar por el archivo de base de datos real
    } 
    public function getPedidos($where=array())
    {
        $dataPagos = $this->ci->dbPedidos->getPedidos($where);
        return $dataPagos;
    }
 }