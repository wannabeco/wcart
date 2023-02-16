<?php
class LogicaTienda  {
    private $ci;
    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model("tienda/BaseDatosTienda","dbTienda");
        $this->ci->load->model("registro/BaseDatosRegistro","dbRegistro");
    } 
    public function getInfoTienda($where)
    {
        $infoTienda = $this->ci->dbTienda->getInfoTienda($where);
        if(count($infoTienda) > 0)
        {
            $salida = array("mensaje"=>"información consultada","continuar"=>1,"datos"=>$infoTienda);
        }
        else
        {
            $salida = array("mensaje"=>"Información no existente con el filtro aplicado","continuar"=>0,"datos"=>array());
        }
        return $salida;
    }
    public function getTiposTienda($where)
    {
        $infoTipos = $this->ci->dbTienda->getTiposTienda($where);
        if(count($infoTipos) > 0)
        {
            $salida = array("mensaje"=>"información consultada","continuar"=>1,"datos"=>$infoTipos);
        }
        else
        {
            $salida = array("mensaje"=>"Información no existente con el filtro aplicado","continuar"=>0,"datos"=>array());
        }
        return $salida;
    }
    public function insertaFotoTemp($data)
    {
        $proceso = $this->ci->dbTienda->insertaFotoTemp($data);
        if($proceso > 0)
        {
            $salida = array("mensaje"=>"foto cargada","continuar"=>1,"datos"=>$proceso);
        }
        else
        {
            $salida = array("mensaje"=>"foto no cargada","continuar"=>0,"datos"=>array());
        }
        return $salida;
    }
    public function crearTienda($post,$files)
    {
        extract($post);
        //var_dump($post);die();
        //valido la información de correo para ver si la tienda ya existe
        $validoCorreoNegocio = $this->ci->dbTienda->getInfoTienda(array("correoTienda"=>$correoTienda,"idEstado"=>1));
        if(count($validoCorreoNegocio) > 0)
        {
            $salida = array("mensaje"=>"El correo del negocio ya se encuentra registrado con otra cuenta, por favor verifique","continuar"=>0,"datos"=>array());
        }
        else
        {
            //verifico que no exista una tienda con el mismo nombre
            $validoNombreTienda = $this->ci->dbTienda->getInfoTienda(array("nombreTienda"=>$nombreTienda,"idEstado"=>1));
            if(count($validoNombreTienda) > 0)
            {
                $salida = array("mensaje"=>"El nombre del negocio ya se encuentra registrado, por favor verifique","continuar"=>0,"datos"=>array());
            }
            else
            {
                //proceso a realizar la validación del número del correo del propietario. El perfil 6 es dueño de tienda
                $infoPropietario = $this->ci->dbTienda->getInfoPropietario(array("email"=>$email,"idPerfil"=>6,"estado"=>1,"eliminado"=>0));
                if(count($infoPropietario) > 0)
                {
                    $salida = array("mensaje"=>"El correo electrónico del propietario ya existe, por favor verifique o pruebe con otro","continuar"=>0,"datos"=>array());
                }
                else 
                {

                    //valido la url amigable de la tienda
                    $validoUrlAmigable = $this->ci->dbTienda->getInfoTienda(array("urlAmigable"=>$urlAmigable,"idEstado"=>1));
                    if(count($validoUrlAmigable) > 0)
                    {
                        $salida = array("mensaje"=>"La URL de tu tienda ya está en uso, por favor verifique o pruebe con otra","continuar"=>0,"datos"=>array());
                    }
                    else
                    {
                        $dataInsertaTienda['nombreTienda']          = $post['nombreTienda'];
                        $dataInsertaTienda['idTipoTienda']          = $post['idTipoTienda'];
                        $dataInsertaTienda['idPais']                = '057';
                        $dataInsertaTienda['idDepartamento']        = $post['idDepartamento'];
                        $dataInsertaTienda['idCiudad']              = $post['idCiudad'];
                        $dataInsertaTienda['direccionTienda']       = $post['direccionTienda'];
                        $dataInsertaTienda['telefonoTienda']        = $post['telefonoTienda'];
                        $dataInsertaTienda['correoTienda']          = $post['correoTienda'];
                        $dataInsertaTienda['celularTienda']         = "+57".$post['celularTienda'];
                        $dataInsertaTienda['faviconTienda']         = "";
                        $dataInsertaTienda['logoTienda']            = "";
                        $dataInsertaTienda['urlAmigable']           = str_replace(' ', '-', $post['urlAmigable']);
                        $dataInsertaTienda['urlFacebook']           = $post['urlFacebook'];
                        $dataInsertaTienda['urlInstagram']          = $post['urlInstagram'];
                        $dataInsertaTienda['urlLinkedin']           = $post['urlLinkedin'];
                        $dataInsertaTienda['urlTwitter']            = $post['urlTwitter'];
                        $dataInsertaTienda['paquete']               = 'mensual';
                        $dataInsertaTienda['estadoFunciona']        = 'normal';
                        $dataInsertaTienda['fechaIngreso']          = date('Y-m-d');
                        $dataInsertaTienda['fechaInicioMembresia']  = date('Y-m-d');
                        $dataInsertaTienda['fechaCaducidad']        = date('Y-m-d',strtotime($fecha_actual."- 1 days"));
                        $dataInsertaTienda['currency']              = "$";
                        $dataInsertaTienda['pagoPayu']              = "no";
                        $dataInsertaTienda['pagoWompi']             = "no";
                        $dataInsertaTienda['pagoStripe']            = "no";
                        $dataInsertaTienda['mensajeMantenimiento']  = "En este momento nos encontramos trabajando para ti en unos momentos volveremos a estar al 100% gracias por tu comprensión";
                        $dataInsertaTienda['idEstado']              = 1;
                        $dataInsertaTienda['terminos']              = 1;
                        //proceso a crear la tienda
                        $idNuevaTienda = $this->ci->dbTienda->crearTienda($dataInsertaTienda);
                        if($idNuevaTienda > 0)//la tienda se crea
                        {   
                            @mkdir('assets/uploads/files/'.$idNuevaTienda,0777);
                            if($dataInsertaTienda['logoTienda'] == ""){
                                //se copia logo de provicional
                                $origen= "assets/uploads/files/19.png";
                                $destino = "assets/uploads/files/".$idNuevaTienda."/f19.jpeg";
                                copy($origen,$destino);
                                $dataInserta['logoTienda'] = "f19.jpeg";
                                $where['idTienda'] = $idNuevaTienda;
                                $ActualizaTienda = $this->ci->dbTienda->actualizaTienda($dataInserta,$where);
                            if($dataInsertaTienda['faviconTienda'] == ""){
                                //se copia favicon de provicional
                                $origen1= "assets/uploads/files/favicon.png";
                                $destino1 = "assets/uploads/files/".$idNuevaTienda."/favicon.png";
                                copy($origen1,$destino1);
                                    $dataInserta['faviconTienda'] = "avicon.png";
                                    $where['idTienda'] = $idNuevaTienda;
                                    $ActualizaTienda = $this->ci->dbTienda->actualizaTienda($dataInserta,$where);
                                //proceso a crear el propietario
                                $dataTendero['nombre']      = $nombre;
                                $dataTendero['apellido']    = $apellido;
                                $dataTendero['email']       = $email;
                                $dataTendero['celular']     = $celular;
                                $dataTendero['idPerfil']    = 6;
                                $dataTendero['idTienda']    = $idNuevaTienda;
                                //inserto la data del tendero
                                $idTendero = $this->ci->dbTienda->creaTendero($dataTendero);
                                if($idTendero > 0)//si el tendero se crea
                                {
                                        //inserto el usuario y la clave del tendero
                                        $dataInsertClave['idGeneral']   =   $idTendero;
                                        $dataInsertClave['tipoLogin']   =   2;//tipo Empresa
                                        $dataInsertClave['usuario']     =   $email;
                                        $dataInsertClave['clave']       =   sha1($rclave);
                                        $dataInsertClave['clave64']     =   base64_encode($rclave);
                                        $dataInsertClave['cambioClave'] =   0;
                                        //inserto la clave
                                        $idLogin                        = $this->ci->dbRegistro->insertaClaveEmpresa($dataInsertClave);
                                        //luego de esto proceso a subir las fotos, para ello crearé funciones
                                        if($idLogin > 0)
                                        {
                                            $salida = array("mensaje"=>"La tienda ha sido creada de manera correcta","continuar"=>1,"datos"=>array("idTienda"=>$idNuevaTienda,"idTendero"=>$idTendero));
                                            $cargaLogo   = $this->cargaFotosTienda($files,"logoTienda",$idNuevaTienda,$idTendero);
                                            //envio de email al usuario de registro de la tienda exitoso.
                                            $para = $email;
                                            $asunto ="Bienvenido a Wannabe Digital y a sus sistema Wcart.";
                                            $mensajeenviar = $this->maileRegistroTiendas($usuario, $clave);
                                            $mensaje = plantillaMail($mensajeenviar);
                                            sendMail($para, $asunto, $mensaje);
                                            //fin de mensaje.

                                            //si viene el banner lo cargo
                                            if(isset($files) && $files['bannerTienda']['name'] != "")
                                            {
                                                $cargaBanner = $this->cargaFotosTienda($files,"bannerTienda",$idNuevaTienda,$idTendero);
                                            }
                                            
                                            if($cargaLogo['continuar'] == 1)
                                            {
                                                $salida = array("mensaje"=>"La tienda ha sido creada de manera correcta","continuar"=>1,"datos"=>array("idTienda"=>$idNuevaTienda,"idTendero"=>$idTendero));
                                            }
                                            else
                                            {
                                                $salida = array("mensaje"=>"La tienda ha sido creada de manera correcta","continuar"=>1,"datos"=>array("idTienda"=>$idNuevaTienda,"idTendero"=>$idTendero));
                                                // $salida = $cargaLogo;
                                            }
                                        }
                                        else
                                        {
                                            $salida = array("mensaje"=>"La data del login del propietario no pudo ser creada, por favor intente de nuevo más tarde.","continuar"=>0,"datos"=>array());
                                        }
                                    }
                                    else{
                                        $salida = array("mensaje"=>"La data no pudo ser creada, por favor intente de nuevo más tarde.","continuar"=>0,"datos"=>array());
                                    }

                                }
                            }
                            else
                            {
                                $salida = array("mensaje"=>"La data del propietario de la tienda no se ha podido registrar, por favor intente de nuevo más tarde.","continuar"=>0,"datos"=>array());
                            }
                        }
                        else
                        {
                            $salida = array("mensaje"=>"La tienda no ha podido ser creada.","continuar"=>0,"datos"=>array());

                        }
                    }


                }
            }

        }


        //var_dump($post);
        //$listaReservas = $this->ci->propiedadesDb->getHuellas($where);
        return $salida;
    }

    public function cargaFotosTienda($files,$fotoACargar,$idTienda,$idPropietario)
    {
        if(isset($files) && $files[$fotoACargar]['name'] != "")
		{
			@mkdir('./assets/uploads/files/'.$idTienda,0777);

			$config['upload_path'] 	 = './assets/uploads/files/'.$idTienda.'/';
	        $config['allowed_types'] = 'gif|jpg|png';
	        $config['max_size'] 	 = 50000;
            //$config['max_width']     = 800;
            //$config['max_height']    = 800;
	        $config['encrypt_name']  = TRUE;
	        $file_element_name 		 = $fotoACargar;

	        $this->ci->load->library('upload', $config);

	        if(!$this->ci->upload->do_upload($file_element_name))
	        {
	            $status = 'error';
	            $msg = $this->ci->upload->display_errors();
	           // var_dump($msg);
	            $salida = array("mensaje"=>$msg,
            				    "continuar"=>0);
	        }
	        else
	        {
                $data = $this->ci->upload->data();
	            $dataActualiza[$fotoACargar]	=	$data['file_name'];
	            $where['idTienda']		=	$idTienda;
	            $procesaFoto 	 	=  $this->ci->dbTienda->actualizaTienda($dataActualiza,$where);
                $salida = array("mensaje"=>"Foto cargada con éxito","continuar"=>1);
            }
        }
        else
        {
            $salida = array("mensaje"=>"No viene la foto del ".$fotoACargar,"continuar"=>0);
        }
        return $salida;
    }
    //Get comentarios
    public function infoComentarios($where){
        $infoComentario=$this->ci->dbTienda->infoComentarios($where);
        return $infoComentario;
    }
    //eliminar el comentario
    public function eliminarComentario($where,$dataActualiza,$idPresentacion,$votantes,$puntos){

        $eliminado=$this->ci->dbTienda->eliminarComentario($where,$dataActualiza);

        if($eliminado=1){
            $eliminado=$this->ci->dbTienda->eliminarVoto($where,$dataActualiza);
            if($eliminado=1){
                $wherePuntos['idPresentacion']      =$idPresentacion;
                $dataActualizaPuntos['puntos']      = $puntos;
                $dataActualizaPuntos['votantes']    = $votantes;
                $eliminado=$this->ci->dbTienda->quitarPuntos($wherePuntos,$dataActualizaPuntos);
            }
            else{
                $eliminado=0;
            }
        }
        return $eliminado;
    }
    //carga archivo excel
    public function actualizaProductos($where,$dataActualiza){
        $actualizaProductos=$this->ci->dbTienda->actualizaProductos($where,$dataActualiza);
        return $actualizaProductos;
    }
    //insert productos desde excel
    public function insetProductos($dataInsert){
        $insetProductos=$this->ci->dbTienda->inserProductos($dataInsert);
        return $insetProductos;
    }
    //insert imagenes a la tabla app_fotos_temp
    public function inserimagenes($dataImagen){
        $insetProductos=$this->ci->dbTienda->inserimagenes($dataImagen);
        return $insetProductos;
    }
    //funcion para plantilla de correo
    public function mailRegistroTiendas($usuario, $clave)
	{	
		$salida['usuario']=$usuario;
		$salida['clave']=$clave;
		return $this->ci->load->view("mailes/registroTiendas",$salida,true);
		 
	}
    public function pruebaLogica(){
        $para = "gabiel.ramirez@gmail.com,farezprieeto@outlook.com";
        $asunto ="Bienvenido a Wannabe Digital y a sus sistema Wcart.";
        $mensajeenviar = $this->mailRegistroTiendas("prueba", "12345");
        $mensaje = plantillaMail($mensajeenviar);
        echo $mensaje;
        sendMail($para, $asunto, $mensaje);
    }
 }