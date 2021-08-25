<?php
class LogicaUsuarios  {
    private $ci;
    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model("admin/BaseDatosUsuarios","dbUsuarios");
        $this->ci->load->model("login/BaseDatosLogin","dbLogin");
    } 
    public function infoUsuario($idPersona="")
    {
        $where = array();
        if($idPersona != "")
        {
            $where['u.idPersona']    = $idPersona;
        }
        $where['u.eliminado'] = 0;
        //Valido el perfil de la sesion del usuario logueado para ver si es un admin de ventas, si es un admin ventas le traigo 
        //solo las vendedoras que son de su equipo de trabajo.
        if(isset($_SESSION['project']) && $_SESSION['project']['info']['idPerfil'] == _PERFIL_ADMIN_VENTAS)
        {
            $where['u.idPadre'] = $_SESSION['project']['info']['idPersona'];
        }

        $dataUsuario                  = $this->ci->dbUsuarios->infoUsuario($where);
        if(count($dataUsuario) > 0)
        {
            $respuesta = array("mensaje"=>"Información del usuarios consultada.",
                          "continuar"=>1,
                          "datos"=>$dataUsuario); 
        }
        else
        {
            $respuesta = array("mensaje"=>"No hay registros para la consulta realizada",
                          "continuar"=>0,
                          "datos"=>""); 
        }
        return $respuesta;

    }
    public function verificaVendedor($where)
    {
        $dataUsuario                  = $this->ci->dbUsuarios->infoUsuario($where);
        if(count($dataUsuario) > 0)
        {
            $respuesta = array("mensaje"=>"El vendedor es un vendedor válido.",
                          "continuar"=>1,
                          "datos"=>$dataUsuario); 
        }
        else
        {
            $respuesta = array("mensaje"=>"El código no pertenece a un vendedor válido. Por favor intente de nuevo",
                          "continuar"=>0,
                          "datos"=>""); 
        }
        return $respuesta;
    }
    public function borraUsuario($post)
    {
        extract($post);
        $data['estado']     =  0;
        $data['eliminado']  =  1;
        $where['idPersona'] = $idUsuario;
        $proceso            = $this->ci->dbUsuarios->actualizaUsuario($where,$data);
        if($proceso > 0)
        {
            auditoria("BORRADOPERSONA","Se ha borrado la información de la persona | ".$idUsuario);
            $respuesta = array("mensaje"=>"El usuario se ha eliminado correctamente.",
                          "continuar"=>1,
                          "datos"=>$proceso); 
        }
        else
        {
            $respuesta = array("mensaje"=>"No se ha podido eliminar el usuario, por favor intente de nuevo más tarde.",
                          "continuar"=>0,
                          "datos"=>""); 
        }

        return $respuesta;
    }
    public function generaDatosAcceso($post)
    {
        extract($post);
        $where1['u.idPersona']  = $idUsuario;
        $dataUsuario            = $this->ci->dbUsuarios->infoUsuario($where1);
        $clave                  =  generacodigo(5);
        $data['usuario']        =  $dataUsuario[0]['email'];
        $data['clave']          =  sha1($clave);
        $data['clave64']        =  base64_encode($clave);
        $data['estado']         = 1;

        $where['idGeneral']     = $idUsuario;
        $proceso                = $this->ci->dbUsuarios->generaDatosAcceso($where,$data);
        if($proceso > 0)
        {
            auditoria("GENDATOSACCESOPERSONA","Se ha generado una clave de acceso a la persona la persona | ".$idUsuario);
            //debo de enviar un correo electrónico al usuario al cuál le han generado una clave de acceso al sistema
            $respuesta = array("mensaje"=>"Se ha generado correctamente la clave de acceso del usuario.<br>Los datos de acceso son los siguientes:<br><br><strong>Usuario:</strong><br>".$dataUsuario[0]['email']."<br><strong>Clave:</strong><br>".$clave."",
                          "continuar"=>1,
                          "datos"=>$proceso); 
        }
        else
        {
            $respuesta = array("mensaje"=>"No se ha podido eliminar el usuario, por favor intente de nuevo más tarde.",
                          "continuar"=>0,
                          "datos"=>""); 
        }

        return $respuesta;
    }
    public function procesaUsuarios($post)
    {
        extract($post);
        if($edita == 1)//proceso de edición
        {   
            $where['idPersona'] = $idUsuario;
            unset($post['edita']);
            unset($post['idUsuario']);
            unset($post['perfilPadre']);
            $proceso            = $this->ci->dbUsuarios->actualizaUsuario($where,$post);
            if($proceso > 0)
            {
                auditoria("EDICIONPERSONA","Se ha actualizado la información de la persona | ".$where['idPersona']);
                $respuesta = array("mensaje"=>"La información del usuario se ha actualizado correctamente.",
                              "continuar"=>1,
                              "datos"=>$proceso); 
            }
            else
            {
                $respuesta = array("mensaje"=>"No se ha podido editar la información del usuario, por favor intente de nuevo más tarde.",
                              "continuar"=>0,
                              "datos"=>""); 
            }
        }
        else//proceso de inserción
        {
            /*$whereExiste['nroDocumento']     =   $nroDocumento;
            $yaExistePersona   = $this->ci->dbUsuarios->infoUsuario($whereExiste);
            if(count($yaExistePersona) == 0)
            {*/

                $whereExisteMail['email']     =   $email;
                $yaExistePersonaMail   = $this->ci->dbUsuarios->infoUsuario($whereExisteMail);
                if(count($yaExistePersonaMail) == 0)
                {
                    
                    unset($post['edita']);
                    unset($post['idUsuario']);
                    unset($post['perfilPadre']);
                    //var_dump($post);
                    //die("here");
                    $proceso            = $this->ci->dbUsuarios->agregaUsuario($post);

                    if($proceso > 0)
                    {
                        //cada vez que se cree un usuario debo insertarlo de una vez en la tabla del login.
                        $dataInserta['idGeneral']   =   $proceso;
                        $dataInserta['usuario']     =   $post['email'];
                        $dataInserta['tipoLogin']   =   2;
                        $usuarioLogin            = $this->ci->dbUsuarios->insertaUsuarioLogin($dataInserta);

                        auditoria("CREACIONPERSONA","Se ha creado la persona | ".$proceso);
                        
                        $respuesta = array("mensaje"=>"El nuevo usuario se ha insertado correctamente.",
                                      "continuar"=>1,
                                      "datos"=>$proceso); 
                    }
                    else
                    {
                        $respuesta = array("mensaje"=>"No se ha podido editar la información del usuario, por favor intente de nuevo más tarde.",
                                      "continuar"=>0,
                                      "datos"=>""); 
                    }
                }
                else
                {
                     $respuesta = array("mensaje"=>"El correo electrónico que intenta ingresar ya está en la base de datos, por favor verifique.",
                                  "continuar"=>0,
                                  "datos"=>"");
                }
            /*}
            else
            {
                $respuesta = array("mensaje"=>"La persona que intenta crear ya se encuentra registrara, por favor verifique.",
                                  "continuar"=>0,
                                  "datos"=>"");
            }*/

        }

        return $respuesta;
    }

    public function procesoCambioClave($post)
    {
        extract($post);
        //lo primero que debo hacer es verificar que la clave actual si sea la del usuario
        //verifico en la tabla de login el usuario y la clave
        $select["usuario"]     =   trim($_SESSION['project']['info']['email']);
        $select["clave"]       =   sha1(trim($claveActual));
        //inserto los datos básicos de la empresa
        $dataLogin = $this->ci->dbLogin->verificaUsuarioyClave($select);
        //si este login me envia data, quiere decir que la clave actual es correcta
        if(count($dataLogin) > 0)
        {
            //lugo de verificar la clave actual debo empezar a hacer el proceso de actualización de la clave para el usuario.
            $dataActualiza['clave']         =   sha1($rClave);
            $dataActualiza['clave64']       =   base64_encode($rClave);
            $dataActualiza['cambioClave']   =   0;
            $whereCambio['usuario']         =   $_SESSION['project']['info']['email'];

            $cambioClaveProc                =   $this->ci->dbUsuarios->cambioClave($whereCambio,$dataActualiza);

            if(count($cambioClaveProc) > 0)
            {
                $mensaje                     =  "Se ha realizado el cambio de contraseña para acceder al aplicativo de ".lang("titulo")."<br><br>";
                $mensaje                    .=  "Su nueva contraseña es: <h2>".$rClave."</h2>";
                sendMail($_SESSION['project']['info']['email'],"Cambio de contraseña - ".lang("titulo"),$mensaje);
                $respuesta = array("mensaje"=>"La contraseña se ha cambiado de manera exitosa.",
                                   "continuar"=>1,
                                   "datos"=>"");
            }
            else
            {
                $respuesta = array("mensaje"=>"No se ha podido cambiar la contraseña, por favor intente de nuevo más tarde.",
                                  "continuar"=>0,
                                  "datos"=>"");
            }

        }
        else
        {
            $respuesta = array("mensaje"=>"Parece que la clave actual no es correcta, por favor verifique.",
                                  "continuar"=>0,
                                  "datos"=>"");
        }
        return $respuesta;
    }
 }