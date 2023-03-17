<?php
class LogicaRegistro  {
    private $ci;
    public function __construct()
    {
        $this->ci = get_instance();
        $this->ci->load->model("registro/BaseDatosRegistro","dbRegistro");
    } 
    public function verificaEmpresa($palabra,$campo,$tabla)
    {
        $select[$campo]     =   trim($palabra);
        //inserto los datos básicos de la empresa
        $dataEmpresa = $this->ci->dbRegistro->verificaEmpresa($select,$tabla);
        return $dataEmpresa;
    }

    /*
    * Inserta Empresas
    * Función que realiza el registro de los perfiles empresariales
    * @author Farez Prieto
    * @date 08 de Julio 2016
    * @return array $respuesta. Esta variable contiene 3 campos
    * mensaje: texto que define la acción
    * continuar: valor entero que retorna 1 si se cumplio el objetivo y si no se cumplió
    * datos: array de con información
    */
    public function insertaEmpresa($data)
    {
        extract($data);
        //antes de registrar la empresa debo verificar que no exista
        $verificoEmpresaNombre = $this->verificaEmpresa($nombre,"nombre","empresas");
        if(count($verificoEmpresaNombre) > 0)//la empresa existe y no debo permitirle el registro
        {
            $respuesta = array("mensaje"=>"El nombre de empresa que intenta crear ya existe en nuestra base de datos. Por favor verifique o intente recuperar su clave si es que la ha olvidado.",
                            "continuar"=>0,
                            "datos"=>"");
        }
        else
        {
            //ahora verifico que el mail no este registrado como persona
            $verificoPersonaMail = $this->verificaEmpresa($email,"email","personas");
            if(count($verificoPersonaMail) > 0)
            {  
                $respuesta = array("mensaje"=>"El correo electrónico que intenta registrar ya se encuentra registrado para un perfil tipo persona, por favor verifíquelo o reemplácelo.",
                            "continuar"=>0,
                            "datos"=>"");
            }
            else
            {
                //verifico que no este registrado el mail como empresa
                $verificoEmpresaMail = $this->verificaEmpresa($email,"email","empresas");
                if(count($verificoEmpresaMail) > 0)
                {  
                    $respuesta = array("mensaje"=>"El correo electrónico que intenta registrar ya se encuentra registrado, por favor verifíquelo o reemplácelo.",
                                "continuar"=>0,
                                "datos"=>"");
                }
                else
                {
                    //procedo a insertar la empresa
                    //armo la data que voy a insertar
                    $dataInsert['nombre']           =   trim($nombre);
                    $dataInsert['direccion']        =   trim($direccion);
                    $dataInsert['telefono']         =   trim($telefono);
                    $dataInsert['email']            =   trim($email);
                    $dataInsert['ciudad']           =   trim($ciudad);
                    $dataInsert['departamento']     =   trim($departamento);
                    //inserto los datos básicos de la empresa
                    $idEmpresa = $this->ci->dbRegistro->insertaEmpresa($dataInsert);
                   //die($idEmpresa);
                    //si la inserción es correcta debo notificar para hacer el resto de inserciones
                    if(trim($idEmpresa) > 0)
                    {
                        //después de haber insertado la empresa debo insertar el usuario y la clave para esta empresa
                        $dataInsertClave['idGeneral']   =   $idEmpresa;
                        $dataInsertClave['tipoLogin']   =   1;//tipo Empresa
                        $dataInsertClave['usuario']     =   $email;
                        $dataInsertClave['clave']       =   sha1($rclave);
                        $dataInsertClave['clave64']     =   base64_encode($rclave);
                        $dataInsertClave['cambioClave'] =   0;
                        //inserto la clave
                        $idLogin                        = $this->ci->dbRegistro->insertaClaveEmpresa($dataInsertClave);
                        if($idLogin > 0)
                        {
                            //proceso a insertar el demo que tienen las empresas de 90 días.
                            $dataInsertDemo['idEmpresa']     =   $idEmpresa;
                            $dataInsertDemo['descripcion']   =   "Demo Inicial de 90 días para que pruebes la aplicación.";
                            $dataInsertDemo['fechaInicio']   =   date("Y-m-d H:i:s");
                            $dataInsertDemo['fechaFin']      =   sumaDias(date("Y-m-d H:i:s"),DEFAULT_DEMO_DAYS);
                            $dataInsertDemo['cantComprada']  =   DEFAULT_DEMO_DAYS;
                            //inserto la clave
                            $idPago                          =   $this->ci->dbRegistro->insertaPago($dataInsertDemo);
                            if($idPago)
                            {
                                $mensajeenviar = "Registro de empresa exitoso Se ha realizado el registro de su empresa en la plataforma";
                                $mensaje = plantillaMail($mensajeenviar);
                                $envioMail                   =   sendMail($email, $mensaje);
                                if($envioMail == 1)
                                {
                                    $respuesta = array("mensaje"=>"La empresa se ha registrado exitosamente, por favor verifique su correo electrónico al cual llegarán instrucciones de activación de su cuenta.",
                                        "continuar"=>1,
                                        "datos"=>"");
                                }
                                else
                                {
                                    $respuesta = array("mensaje"=>"Oops!! Esto es bastante embarazoso, ha habido un error interno que no ha permitido registrar la empresa, por favor intentelo de nuevo más tarde.",
                                        "continuar"=>0,
                                        "datos"=>"");
                                }
                                
                            }
                            else
                            {
                                 $respuesta = array("mensaje"=>"Oops!! Esto es bastante embarazoso, ha habido un error interno que no ha permitido registrar la empresa, por favor intentelo de nuevo más tarde.",
                                        "continuar"=>0,
                                        "datos"=>"");
                            }
                            
                        }
                        else
                        {
                            $respuesta = array("mensaje"=>"Oops!! Esto es bastante embarazoso, ha habido un error interno que no ha permitido registrar la empresa, por favor intentelo de nuevo más tarde.",
                                        "continuar"=>0,
                                        "datos"=>"");
                        }
                    }
                    else
                    {
                        $respuesta = array("mensaje"=>"Oops!! Esto es bastante embarazoso, ha habido un error interno que no ha permitido registrar la empresa, por favor intentelo de nuevo más tarde.",
                                        "continuar"=>0,
                                        "datos"=>"");
                    }
                }
            }
        }
        return $respuesta;
    }

    public function actualizaPersona($data)
    {
        extract($data);
        //var_dump($data);die();
        unset($data['idPersona']);
        unset($data['movil']);
        $where = array("idPersona"=>$idPersona);
        $idPersona = $this->ci->dbRegistro->actualizaPersona($data,$where);
        if($idPersona > 0)
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
    public function updateTokenFCM($data)
    {
        extract($data);
        //var_dump($data);die();
        unset($data['idPersona']);
        unset($data['movil']);
        $where = array("idPersona"=>$idPersona);
        $idPersona = $this->ci->dbRegistro->actualizaPersona($data,$where);
        if($idPersona > 0)
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
    public function updateTokenFCMTienda($data)
    {
        extract($data);
        //var_dump($data);die();
        unset($data['idPersona']);
        unset($data['movil']);
        $where = array("idPersona"=>$idPersona,"idTienda"=>$idTienda);
        $dataInsert['FCMTokenTienda'] = $FCMToken;
        $idPersona = $this->ci->dbRegistro->actualizaRelacionCliente($dataInsert,$where);
        if($idPersona > 0)
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

    public function guardaSeguimiento($data)
    {
        extract($data);
        //var_dump($data);die();
        //$where = array("idPersona"=>$idPersona);
        $data['fechaLlamada'] = date('Y-m-d H:i:s');
        $idPersona = $this->ci->dbRegistro->guardaSeguimiento($data);
        if($idPersona > 0)
        {
            $respuesta = array("mensaje"=>"Información agregada exitosamente",
                               "continuar"=>1,
                               "datos"=>"");
        }
        else
        {
            $respuesta = array("mensaje"=>"La información no ha podido ser agregada, intente más tarde.",
                               "continuar"=>0,
                               "datos"=>"");

        }
        return $respuesta;
    }

    /*
    * Inserta Personas
    * Función que realiza el registro de los perfiles personales.
    * @author Farez Prieto
    * @date 08 de Julio 2016
    * @return array $respuesta. Esta variable contiene 3 campos
    * mensaje: texto que define la acción
    * continuar: valor entero que retorna 1 si se cumplio el objetivo y si no se cumplió
    * datos: array de con información
    */
    public function insertaPersona($data)
    {
        extract($data);
        //antes de registrar la persona debo verificar que no exista
        $verificoMailEnEmpresa = $this->verificaEmpresa(trim($email),"email","empresas");
        if(count($verificoMailEnEmpresa) > 0)//la empresa existe y no debo permitirle el registro
        {
            $respuesta = array("mensaje"=>"El correo electr&oacute;nico que intenta registrar pertenece a una cuenta empresarial, por favor verifique.",
                            "continuar"=>0,
                            "datos"=>"");
        }
        else
        {
            //ahora verifico que el mail no este registrado como persona
            $verificoPersonaMail = $this->verificaEmpresa($email,"email","personas");
            $maile = $verificoPersonaMail[0];
            //var_dump($maile["eliminado"]);die();
            if($maile["eliminado"] == 1){
                $dataActualiza["nombre"] = $data["nombre"];
                $dataActualiza["apellido"] = $data["apellido"];
                $dataActualiza["eliminado"] = 0;
                $where["email"] = $email;
                $actualizaPersona = $this->ci->dbRegistro->actualizaNuevo($dataActualiza,$where);
                if($actualizaPersona >0){

                    $respuesta = array("mensaje"=>"Su registro se ha llevado a cabo de manera exitosa.",
                                        "continuar"=>1,
                                        "datos"=>"");
                }
                else{
                    $respuesta = array("mensaje"=>"Oops!! Esto es bastante embarazoso, ha habido un error interno que no ha permitido registrar la empresa, por favor intentelo de nuevo más tarde.",
                                        "continuar"=>1,
                                        "datos"=>"");
                }
            }
            else if(count($verificoPersonaMail) > 0 && $email != '')
            {  
                $respuesta = array("mensaje"=>"El correo electrónico que ingresó; ya se encuentra registrado, por favor verifíquelo o pruebe con otro.",
                            "continuar"=>0,
                            "datos"=>"");
            }
            else
            {
                //verifico que el celular que esta ingresando no este registrado
                $verificocelular = $this->verificaEmpresa($celular,"celular","personas");
                if(count($verificocelular) > 0 && $celular != "")
                {
                    $respuesta = array("mensaje"=>"El número de celular ingresado ya se encuentra registrado, por favor verifíquelo o pruebe con otro.",
                            "continuar"=>0,
                            "datos"=>"");
                }
                else
                {
                    //procedo a insertar la empresa
                    //armo la data que voy a insertar
                    $dataInsert['nombre']           =   trim($nombre);
                    $dataInsert['apellido']         =   trim($apellido);
                    $dataInsert['email']            =   trim($email);
                    $dataInsert['ciudad']           =   trim($ciudad);
                    $dataInsert['celular']          =   trim($celular);
                    $dataInsert['departamento']     =   trim($departamento);
                    $dataInsert['idConjunto']       =   trim($idConjunto);
                    $dataInsert['direccion']        =   trim($direccion);
                    $dataInsert['torre']            =   trim($torre);
                    $dataInsert['apto']             =   trim($apto);
                    $dataInsert['fechaIngreso']     =   date("Y-m-d");
                    $dataInsert['idPerfil']         =   trim(_PERFIL_COMPRADOR);
                    //inserto los datos básicos de la empresa
                    $idPersona = $this->ci->dbRegistro->insertaPersona($dataInsert);
                    //si la inserción es correcta debo notificar para hacer el resto de inserciones
                    if(trim($idPersona) > 0)
                    {
                        //después de haber insertado la empresa debo insertar el usuario y la clave para esta empresa
                        $dataInsertClave['idGeneral']   =   $idPersona;
                        $dataInsertClave['tipoLogin']   =   2;//tipo Empresa
                        $dataInsertClave['usuario']     =   ($email != '' or $email != null)?$email:trim($celular);
                        $dataInsertClave['usuario2']    =   trim($celular);
                        $dataInsertClave['clave']       =   sha1($rclave);
                        $dataInsertClave['clave64']     =   base64_encode($rclave);
                        $dataInsertClave['cambioClave'] =   0;
                        //inserto la clave
                        $idLogin                        = $this->ci->dbRegistro->insertaClavePersona($dataInsertClave);
                        if($idLogin > 0)
                        {   //se realiza l envio de email, hacer cambio de empresa a la que se ha realizado el registro
                            //$envioMail  =   sendMail($email,"Registro exitoso","Se ha realizado el registro de su cuenta personal en la plataforma de Hoteles AR");
                            
                                $respuesta = array("mensaje"=>"Su registro se ha llevado a cabo de manera exitosa.",
                                    "continuar"=>1,
                                    "datos"=>"");
                            //cada vez que un usuario se registra se debe enviar una notificacion a la persona encargada con el dato del regalo de un Kilo de Limon.
                            //enviaRegaloUsuario($idPersona);
                            
                        }
                        else
                        {
                            $respuesta = array("mensaje"=>"Oops!! Esto es bastante embarazoso, ha habido un error interno que no ha permitido registrar la empresa, por favor intentelo de nuevo más tarde- Usuario",
                                        "continuar"=>0,
                                        "datos"=>"");
                        }
                    }
                    else
                    {
                        $respuesta = array("mensaje"=>"Oops!! Esto es bastante embarazoso, ha habido un error interno que no ha permitido registrar la empresa, por favor intentelo de nuevo más tarde. -Id Persona",
                                        "continuar"=>0,
                                        "datos"=>"");
                    }
                }
                
            }
        }
        return $respuesta;
    }

 }