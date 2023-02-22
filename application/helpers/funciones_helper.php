<?php
function getIP() 
{
    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    } else {
        if (isset($GLOBALS['HTTP_SERVER_VARS']['HTTP_X_FORWARDER_FOR'])) {
            return $GLOBALS['HTTP_SERVER_VARS']['HTTP_X_FORWARDED_FOR'];
        } else {
            return $GLOBALS['HTTP_SERVER_VARS']['REMOTE_ADDR'];
        }
    }
}
function getDisp()
{
    return $_SERVER['HTTP_USER_AGENT'];
}
function pre($data, $die=0)
{
    echo "<pre>";print_r($data);echo "</pre>";
    if( $die ) die();
}
function acentos($cadena){ 
    $search  = explode(",","á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,Ã¡,Ã©,Ã*,Ã³,Ãº,Ã±,Ã,ÃÃ¡,ÃÃ©,ÃÃ*,ÃÃ³,ÃÃº,ÃÃ±,Ã“,Ã ,Ã‰,Ã ,Ãš,â€œ,â€ ,Â¿,ü");
    $replace = explode(",","á,é,í,ó,ú,ñ,Á,É,Í,Ó,Ú,Ñ,á,é,í,ó,ú,ñ,í,É,Í,Ó,Ú,Ñ,Ó,Á,É,Í,Ú,\",\",¿,&uuml;");
    $cadena  = str_replace($search, $replace, $cadena);
    return $cadena; 
} 

function traduceFecha($fecha)
{
    $fecha1 = explode(" ",$fecha);
    $fecha2 = explode("-",$fecha1[0]);

    return $fecha2[2]." de ".traducirMes($fecha2[1])." de ".$fecha2[0];
}



function eliminaCaracteres($cadena)
{
    $cadena = strtolower($cadena);
    $cadena = str_replace("á","a",strtolower($cadena));
    $cadena = str_replace("é","e",$cadena);
    $cadena = str_replace("í","i",$cadena);
    $cadena = str_replace("ó","o",$cadena);
    $cadena = str_replace("ú","u",$cadena);
    $cadena = str_replace("ñ","n",$cadena);
    $cadena = str_replace("Á","a",$cadena);
    $cadena = str_replace("É","e",$cadena);
    $cadena = str_replace("Í","i",$cadena);
    $cadena = str_replace("Ó","o",$cadena);
    $cadena = str_replace("Ú","u",$cadena);
    $cadena = str_replace("Ñ","n",$cadena);
    $cadena = str_replace(" ","_",$cadena);
    //$cadena = str_replace("_","-",$cadena);
    $cadena = str_replace(".","",$cadena);
    $cadena = str_replace(",","",$cadena);
    $cadena = str_replace("?","",$cadena);
    $cadena = str_replace("¿","",$cadena);
    $cadena = str_replace("!","",$cadena);
    $cadena = str_replace("¡","",$cadena);
    $cadena = str_replace("(","",$cadena);
    $cadena = str_replace(")","",$cadena);
    $cadena = str_replace("/","-",$cadena);
    $cadena = str_replace("'","",$cadena);
    $cadena = str_replace('"',"",$cadena);
    $cadena = str_replace('@',"",$cadena);
    $cadena = str_replace('#',"",$cadena);
    $cadena = str_replace('&',"",$cadena);
    $cadena = str_replace('=',"",$cadena);
    $cadena = str_replace('{',"",$cadena);
    $cadena = str_replace('}',"",$cadena);
    $cadena = str_replace('[',"",$cadena);
    $cadena = str_replace(']',"",$cadena);
    $cadena = str_replace('*',"",$cadena);
    $cadena = str_replace('|',"",$cadena);
    $cadena = str_replace('\/',"-",$cadena);
    $cadena = str_replace('$',"",$cadena);
    $cadena = str_replace(':',"",$cadena);
    $cadena = str_replace(';',"",$cadena);
    return $cadena;
}

function sendMail($para,$asunto,$mensaje)
{
    $ci = get_instance();
    $ci->load->library('email');
    $ci->load->model("general/baseDatosGral","baseGeneral");
    $ci->email->initialize(array(
        'protocol' => 'smtp',
        'smtp_host' => 'smtp.gmail.com',
        'smtp_user' => 'socialeswannabe@gmail.com',
        'smtp_pass' => 'wannabe2022*',
        'smtp_port' => 465,
        'smtp_crypto' => "ssl",
        'crlf' => "\r\n",
        'newline' => "\r\n",
        'mailtype'=>"html"
    ));
    $ci->email->from('socialeswannabe@gmail.com', NOMBRE_APP);
    $ci->email->to($para);
    //$ci->  email->cc('another@another-example.com');
    //$ci->  email->bcc('them@their-example.com');
    $ci->email->subject($asunto);
    $ci->email->message($mensaje);
    if($ci->email->send())//exitoso
    {
        $estado = 1;
    }
    else//fallido
    {
        $estado = 0;
    }

    $dataInserta['para']        = $para;
    $dataInserta['asunto']      = $asunto;
    $dataInserta['mensaje']     = $mensaje;
    $dataInserta['estado']      = $estado;
    $dataInserta['fechaEnvio']  = date("Y-m-d H:i:s");
    $dataInserta['ip']          = getIP();
    $EnvioMailDb                = $ci->baseGeneral->envioMailDB($dataInserta);

    return $estado;

}
//plantilla envio email
function plantillaMail($mensaje)
{
    $plantilla = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
        $plantilla .= '<html xmlns="http://www.w3.org/1999/xhtml">';
        $plantilla .= '<head> ';
            $plantilla .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';	 
            $plantilla .= '<title>Wcart</title>	'; 
            $plantilla .= '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>	';
        $plantilla .= '</head>';
        $plantilla .= '<body style="margin: 0; padding: 0;">';
            $plantilla .= '<br>';
            $plantilla .= '<table align="left" border="0" border="1" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">';
                $plantilla .= '<tr>';
                    $plantilla .= '<td align="left" bgcolor="#eee" style="padding: 20px 0 20px 40px; width:200px;">';
                        $plantilla .= '<img src="'.base_url('res/img/logo.png').'" alt="Logo Wcart" width="40%" style="display: block;" />';
                    $plantilla .= '</td>';
                $plantilla .= '</tr>';
                $plantilla .= '<tr>';
                    $plantilla .= '<td bgcolor="#f6f6f6" style="color:#444;padding: 20px 30px 20px 30px;font-family: Arial, sans-serif; font-size: 20px; text-aligne:justify;line-height:25px; " colspan="2">';

                        $plantilla .= $mensaje;

                    $plantilla .= '</td>';
                $plantilla .= '</tr>';
                $plantilla .= '<tr>';
                    $plantilla .= '<td bgcolor="#000" style="text-align:center;color:#fff;padding: 20px 20px 20px 20px;font-family: Arial, sans-serif; font-size: 25px;">No responder este mensaje';
                    $plantilla .= '</td>';
                $plantilla .= '</tr>';
            $plantilla .= '</table>';
        $plantilla .= '</body>';
        $plantilla .= '</html>';
        return $plantilla;
}
function generaHoras($desde,$hasta)
{
    $salida =   array();
    $hora       = date('0'.$desde.':30');
    for($a=$desde;$a<=$hasta;$a++)
    {
        $nuevaHora = strtotime('+30 minute',strtotime($hora));
        $nuevaHora = date('H:i',$nuevaHora);
        $dataHoras  = array("hora"=>$nuevaHora);
        $hora       = $nuevaHora;
        array_push($salida,$dataHoras);
    }
    return $salida;
}

function generaHorasSimple($desde,$hasta)
{
    $salida =   array();
    $hora       = date('0'.$desde.':00');
    for($a=$desde;$a<=$hasta;$a++)
    {
        $nuevaHora = strtotime('+60 minute',strtotime($hora));
        $nuevaHora = date('H:i',$nuevaHora);
        $dataHoras  = array("hora"=>$nuevaHora);
        $hora       = $nuevaHora;
        array_push($salida,$dataHoras);
    }
    return $salida;
}


function traducirMes($mes) {
    //realizo el switch de la variable del mes para traducirlo a espaï¿½ol
    switch ($mes) {
        CASE '01':$mes = 'Enero';
            Break;
        CASE '02':$mes = 'Febrero';
            Break;
        CASE '03':$mes = 'Marzo';
            Break;
        CASE '04':$mes = 'Abril';
            Break;
        CASE '05':$mes = 'Mayo';
            Break;
        CASE '06':$mes = 'Junio';
            Break;
        CASE '07':$mes = 'Julio';
            Break;
        CASE '08':$mes = 'Agosto';
            Break;
        CASE '09':$mes = 'Septiembre';
            Break;
        CASE '10':$mes = 'Octubre';
            Break;
        CASE '11':$mes = 'Noviembre';
            Break;
        CASE '12':$mes = 'Diciembre';
            Break;
    }
    return $mes;
}
function traduceDia($dia){
	$diaSalida = "";
	switch(strtolower($dia)){
		case 'sun':
			$diaSalida = "Domingo";
		break;
		case 'mon':
			$diaSalida = "Lunes";
		break;
		case 'tue':
			$diaSalida = "Martes";
		break;
		case 'wed':
			$diaSalida = "Miércoles";
		break;
		case 'thu':
			$diaSalida = "Jueves";
		break;
		case 'fri':
			$diaSalida = "Viernes";
		break;
		case 'sat':
			$diaSalida = "Sábado";
		break;
	}
	return $diaSalida;
}
function formatoFechaEspanol($fechaDb,$salida=true)
{
	$dateUnix = strtotime($fechaDb);
	$anoDoc = date("Y", $dateUnix);
	$perDoc = date("m", $dateUnix);
	$dia = date("d", $dateUnix);
	if($salida == true){
		echo $dia . " de " . TraducirMes($perDoc) . " del " . $anoDoc;
	}
	else{
		return $dia . " de " . TraducirMes($perDoc) . " del " . $anoDoc;
	}
}
function formatoFechaEspanolHora($fechaDb,$salida=true) {
    //echo $fechaDb."<hr>";
    $dateUnix = strtotime($fechaDb);
    $anoDoc = date("Y", $dateUnix);
    $perDoc = date("m", $dateUnix);
    $dia = date("d", $dateUnix);
    $hora = date("H", $dateUnix);
    $min = date("i", $dateUnix);
    //echo $perDoc;
    if($salida)
    {
        echo $dia . " de " . TraducirMes($perDoc) . " del " . $anoDoc." a las ".$hora.":".$min;
    }
    else
    {
        return $dia . " de " . TraducirMes($perDoc) . " del " . $anoDoc." a las ".$hora.":".$min;   
    }
}
function generacodigo($longitud){
    //Se define una cadena de caractares. Te recomiendo que uses esta.
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    //Obtenemos la longitud de la cadena de caracteres
    $longitudCadena=strlen($cadena);
     
    //Se define la variable que va a contener la contraseña
    $pass = "";
    //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
    $longitudPass=$longitud;
     
    //Creamos la contraseña
    for($i=1 ; $i<=$longitudPass ; $i++){
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        $pos=rand(0,$longitudCadena-1);
     
        //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
        $pass .= substr($cadena,$pos,1);
    }
    return $pass;
}

 
function cabeza()
{
    return 'home/cabeza';   
}
function pie()
{
    return 'home/pie';  
}
function label($label,$lang)
{
    $ci =& get_instance();
    $ci->lang->load('spanish_lang',$lang);
    $return = $ci->lang->line($label);
    if($return)
        return $return;
    else
        return $label;
}   


function validaIngreso()
{
    $salida =   false;
    if(isset($_SESSION['project']))
    {
        $salida = true;
    }
    else
    {
        $salida = false;
    }
    return $salida;
}

/*Esta función es la que me va a permitir saber si la app la estan consultando 
* de manera segura o estan intentando acceder a los metodos de ajax por otro medio
* @author Farez Prieto
* @input string $app Variable que me dice el tipo de app que consulta
* web   = Página web
* movil = Dispositivo móvil
* @return boolean
*/
function validaInApp($app="web")
{
    $salida = false;
    if($app == "web")//via web
    {
        if(isset($_SESSION['inproject']))//esta validación me hará consultas más seguras
        {
            $salida = true;
        }
        else
        {
            $salida = false;
        }
    }
    elseif($app == "movil")//via movil
    {
        $salida = true;
    }
    return $salida;
}

function sumaDias($fechaSuma,$dias)
{
    $fecha = date_create($fechaSuma);
    date_add($fecha, date_interval_create_from_date_string($dias.' days'));
    return date_format($fecha, 'Y-m-d H:i:s');
}


function restaDias($fechaResta,$dias)
{
  return date("Y-m-d H:i:s",strtotime($fechaResta."- ".$dias." days")); 
}

/*
* int $salida Define si la respuesta es en Array o en Json
* return string o array $listaDeptos
*/
function getDepartamentos($idPais="057",$salida="ARRAY"){
     $ci = get_instance();
     $ci->load->model("general/baseDatosGral","baseGeneral");
     $where['ID_PAIS']  =   $idPais;
     $listaDeptos  =   $ci->baseGeneral->getDepartamentos($where);
     if($salida == "ARRAY")
     {
        return $listaDeptos;
     }
     else if($salida == "JSON")
     {
        return json_encode($listaDeptos);  
     }
}
/*
* int $salida Define si la respuesta es en Array o en Json
* return string o array $listaDeptos
*/
function getCiudades($idPais="057",$idDepto,$salida="ARRAY"){
     $ci = get_instance();
     $ci->load->model("general/baseDatosGral","baseGeneral");
     $where['ID_PAIS']  =   $idPais;
     $where['ID_DPTO']  =   $idDepto;
     $listaCiudades  =   $ci->baseGeneral->getCiudades($where);
     if($salida == "ARRAY")
     {
        return $listaCiudades;
     }
     else if($salida == "JSON")
     {
         $respuesta = array("mensaje"=>"Listado de Ciudades",
                            "continuar"=>1,
                            "datos"=>$listaCiudades);    
        echo json_encode($respuesta);  
     }
}


/*
* Auditoría General
* Función que permite manejar una auditoría básica a la aplicación
* @author Farez Prieto
* @date 6 de diciembre de 2016
*/
function auditoria($tipo,$texto)
{
     $ci = get_instance();
     $ci->load->model("general/baseDatosGral","baseGeneral");
     $dataInsert['tipoAuditoria']   =   $tipo;
     $dataInsert['textAuditoria']   =   $texto;
     $dataInsert['idUsuario']       =   (isset($_SESSION['project']))?$_SESSION['project']['info']['idPersona']:0;
     $dataInsert['fecha']           =   date("Y-m-d H:i:s");
     $dataInsert['ip']              =   getIP();
     $auditoria                     =   $ci->baseGeneral->auditoria($dataInsert);
}

/*
* Envia regalo a los que se registran por primera vez
*
*/
function sendSms($remitente,$destinatario,$mensaje)
{
    $ci = get_instance();
    //cargo las librer'ias de los SMS
    // load library
    $ci->load->library('nexmo');
    // set response format: xml or json, default json
    $ci->nexmo->set_format('json');

    $from = $remitente;
    $to   = $destinatario;
    $message = array(
        'text' => $mensaje,
    );
    $response = $ci->nexmo->send_message($from, $to, $message);
    // echo "<h1>Text Message</h1>";
    // $ci->nexmo->d_print($response);
    // echo "<h3>Response Code: ".$ci->nexmo->get_http_status()."</h3>";
}

function enviaRegaloUsuario($idPersona)
{
    $ci = get_instance();
    $ci->load->model("general/baseDatosGral","baseGeneral");
    //informacion de la persona
    $infoPersona  = $ci->baseGeneral->getInfoPersonas(array("idPersona"=>$idPersona));
    //en la informacion de la persona viene el id del conjunto, con este aid traemos la vendedora correspondiente
    //$calculaEster = $ci->baseGeneral->getInfoPersonas(array("idConjunto"=>$infoPersona[0]['idConjunto'],"idPerfil"=>_PERFIL_VENDEDOR,"estado"=>1,"eliminado"=>0)); 
    $calculaEster = $ci->baseGeneral->getInfoPersonas(array("idPersona"=>$infoPersona[0]['idPadre'])); 
    //consulto la informaci'on del conjunto
    $infoConjunto = $ci->baseGeneral->consultaConjuntos(array("idConjunto"=>$infoPersona[0]['idConjunto']));
    //ahora que tengo a la ester correspondiente puedo hacer el pedido
    $pedido['fechaPedido']  = date("Y-m-d H:i:s");
    $pedido['ip']           = getIP();
    $pedido['idPersona']    = $idPersona;
    $pedido['valor']        = 0;
    $pedido['codigoPedido'] = generacodigo(10);
    $pedido['formaPago']    = 0;
    //$pedido['pedidoPara']   = $calculaEster[0]['idPersona'];
    $pedido['pedidoPara']   = $infoPersona[0]['idPadre'];
    $idPedido = $ci->dbGeneral->insertaPedido($pedido);
    //ahora debo insertar el detalle del pedido.
    $productoVar['idPedido']        = $idPedido;
    $productoVar['idProducto']      = _ID_PRODUCTO_REGALO;
    $productoVar['idPresentacion']  = _ID_PRES_PRODUCTO_REGALO;
    $productoVar['cantidad']        = _CANT_PRODUCTO_REGALO;
    //inserto detalle del producto
    $detProducto = $ci->dbGeneral->insertaDetalleProducto($productoVar);
    //ahora debo enviar el mensaje al doliente con la iformacion del pedido.
    $asuntoMensaje = "Nuevo usuario registrado";
    $mensaje  = "Hola, Se ha registrado un nuevo usuario a la plataforma, así que hay que enviarle su respectivo regalo de bienvenida. <br><br>";

    $mensaje .= "<h2>DATOS DEL CLIENTE</h2>";
    $mensaje .= "Nombre: ".$infoPersona[0]['nombre']." ".$infoPersona[0]['apellido']."<br>";
    $mensaje .= "Teléfonos: ".$infoPersona[0]['celular']."<br>";
    $mensaje .= "Torre: ".$infoPersona[0]['torre']."<br>";
    $mensaje .= "Apartamento: ".$infoPersona[0]['apto']."<br>";
    $mensaje .= "Conjunto residencial: ".$infoConjunto[0]['nombreConjunto']."<br>";
    //$mensaje .= "Dirección: ".$infoPersona[0]['direccion']."<br>";

    if(!isset($_SESSION['noMail']))
    {
        //notifico a ester por medio del mensaje de correo
        sendMail($calculaEster[0]['email'],$asuntoMensaje,$mensaje);
        sendMail('kyo20052@gmail.com',$asuntoMensaje,$mensaje);
        //notifico a ester por medio de mensaje de texto
        $mensajeDeTexto = "Esmeralda:  Usuario nuevo: ".$infoPersona[0]['nombre']." ".$infoPersona[0]['apellido'].", ".$infoPersona[0]['direccion'].", Entregar obsequio de bienvenida Id Pedido: ".$idPedido;
        //envio SMS para avisarle a Ester que debe de estar pendiende de dar el obsequi al usuario que se acaba de registrar
        sendSms(_REMITE_SMS,"57".$calculaEster[0]['celular'],$mensajeDeTexto);
    }


}
/*
* Funcion getPrivilegios
* Esta función es bastante importante ya que basandose en los datos de perfil del usuario logueado y módulo visitado
* le permitirá habilitar o deshabilitar los botones de ver, crear, editar, borrar.
* @author Farez Prieto @orugal
* @date 11 de Noviembre de 2016
*/
function getPrivilegios()
{
    $ci = get_instance();
    $ci->load->model("general/baseDatosGral","baseGeneral");
    //perfil del usuario logueado
    $where['idPerfil']  =   $_SESSION['project']['info']['idPerfil'];
    //módulo visitado
    $where['idModulo']  =   $_SESSION['moduloVisitado'];
    $privilegios        =   $ci->baseGeneral->consultaRelacionPerfil($where);
    return $privilegios;
}


/*Traigo los diagnosticos del paciente*/
function getDiagnosticos($idVisita,$idPaciente,$idEspecialista)
{
    $ci = get_instance();
    $ci->load->model("general/baseDatosGral","baseGeneral");
    //perfil del usuario logueado
    $where['c.idVisita']          =   $idVisita;
    $where['c.idPaciente']        =   $idPaciente;
    $where['c.idEspecialista']    =   $idEspecialista;
    $diagnosticos            =   $ci->baseGeneral->getDiagnosticos($where);
    return $diagnosticos;
}

function validaDiasLicencia()
{   
    if($_SESSION['tucomunidad']['trial'] == 1)
    {
        $vencimiento    =    vencimiento($_SESSION['tucomunidad']['diasComprados'],date("Y-m-d",strtotime($_SESSION['tucomunidad']['fechaActivacion'])));
        $vencimiento['licencia'] = 1;//trial
        $vencimiento['licenciaTxt'] = "Prueba gratis";//trial
    }
    else
    {
        if($_SESSION['tucomunidad']['pago'] == 1)
        {
             $vencimiento    =    vencimiento($_SESSION['tucomunidad']['diasComprados'],date("Y-m-d",strtotime($_SESSION['tucomunidad']['fechaActivacion'])));
             $vencimiento['licencia'] = 2;//compra
             $vencimiento['licenciaTxt'] = "Compra ".$vencimiento['diasComprados']." Días";//trial
        }
        else
        {
            echo "probablemente no tenga derecho de ingresar.";
        }
    }
    return $vencimiento;
}

/*
* @input int $diasCompra días que compró el usuario
* @input string $fechaAct fecha del día en que realizó la compra ó el demo
*/
function vencimiento($diasCompra,$fechaAct)
{
    $diasTrans                      = dias_transcurridos(date("Y-m-d",strtotime($fechaAct)),date("Y-m-d"));
    $diasRestantes                  = ($diasCompra - $diasTrans);
    $salida['diasComprados']        =  $diasCompra; 
    $salida['diasTranscurridos']    =  $diasTrans; 
    $salida['diasRestantes']        =  $diasRestantes; 
    $salida['aviso']                =  ($salida['diasRestantes'] <= 5)?1:0; 
    $salida['vencido']              =  ($salida['diasRestantes'] <= 0)?1:0; 
    $salida['por']                  =  (($diasTrans * 100) / $diasCompra); 
    return $salida;
}

function dias_transcurridos($fecha_i,$fecha_f)
{
    $dias   = (strtotime($fecha_i)-strtotime($fecha_f))/86400;
    $dias   = abs($dias); $dias = floor($dias);     
    return $dias;
}

function traerCabeza(){
    $opts = array("http"=>array( "method"=>"GET",
                  "header"=>"Accept-language: en\r\n" .
                  "Cookie:".session_name()."=".session_id()."\r\n"));

    $context = stream_context_create($opts);
    session_write_close();   // this is the key
    return file_get_contents(base_url().'inicio/cabeza/', false, $context);    
}
function traerPie(){
    $opts = array("http"=>array( "method"=>"GET",
                  "header"=>"Accept-language: en\r\n" .
                  "Cookie:".session_name()."=".session_id()."\r\n"));

    $context = stream_context_create($opts);
    session_write_close();   // this is the key
    return file_get_contents(base_url().'inicio/pie/', false, $context);
}

function insertaArchivosControlesAngularJS()
{

    $script  =   '<script type="text/javascript" src="'.base_url().'res/js/push.min.js"></script>';
    $script .=   '<script type="text/javascript" src="'.base_url().'res/js/areas/controller.js"></script>';
    $script .=   '<script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/0.0.11/push.min.js"></script>';
    $script .=   '<script type="text/javascript" src="'.base_url().'res/js/home/propiedadesController.js?'.rand(0,1000).'"></script>';
    $script .=   '<script type="text/javascript" src="'.base_url().'res/js/administracion/controller.js"></script>';
    $script .=   '<script type="text/javascript" src="'.base_url().'res/js/usuarios/controller.js"></script>';
    $script .=   '<script type="text/javascript" src="'.base_url().'res/js/listas/controller.js"></script>';;
    $script .=   '<script type="text/javascript" src="'.base_url().'res/js/perfilUsuario/controller.js"></script>';
    $script .=   '<script type="text/javascript" src="'.base_url().'res/js/administrativos/cargaPagos/controller.js"></script>';
    $script .=   '<script type="text/javascript" src="'.base_url().'res/js/pedidos/controller.js?'.rand(0,1000).'"></script>';
    $script .=   '<script type="text/javascript" src="'.base_url().'res/js/notificaciones/controller.js?'.rand(0,1000).'"></script>';
    $script .=   '<script type="text/javascript" src="'.base_url().'res/js/gestionTienda/controller.js?'.rand(0,1000).'"></script>';
    $script .=   '<script type="text/javascript" src="'.base_url().'res/js/MiTienda/controller.js?'.rand(0,1000).'"></script>';
    $script .=   '<script type="text/javascript" src="'.base_url().'res/js/membresia/controller.js?'.rand(0,1000).'"></script>';

    return $script;
}

function startConstantes()
{
    $ci = get_instance();
    $ci->load->model("general/baseDatosGral","baseGeneral");
    $variables   =   $ci->baseGeneral->getVariablesGlobales();
    $variablesSalida = "";
    foreach($variables as $vars)
    {
        $variablesSalida = "define('".$vars['variable']."','".$vars['valor']."');";
        eval($variablesSalida);
    }
}

function estadoPago($idEstado)
{
    if ($idEstado == 4 ) {
        $estadoTx = "Transacción aprobada";
        $claseLabel = "label-success";
    }
    else if ($idEstado == 6 ) {
        $estadoTx = "Transacción rechazada";
        $claseLabel = "label-danger";
    }
    else if ($idEstado == 104 ) {
        $estadoTx = "Error";
        $claseLabel = "label-danger";
    }
    else if ($idEstado == 7 ) {
        $estadoTx = "Transacción pendiente";
        $claseLabel = "label-warning";
    }
    else if ($idEstado == 998 ) {
        $estadoTx = "Pago realizado";
        $claseLabel = "label-success";
    }
    else if ($idEstado == 999 ) {
        $estadoTx = "Pago no realizado";
        $claseLabel = "label-danger";
    }
    else if ($idEstado == 000 ) {
        $estadoTx = "Esperando pago";
        $claseLabel = "label-default";
    }
    else {
        $estadoTx="Otro estado";
        $claseLabel = "";
    }

    return array('texto'=>$estadoTx,'label'=>$claseLabel);
}

function generoConsecutivoInventario($movimiento)
{
    $consecutivo = 0;
    $ci = get_instance();
    $ci->load->model("general/baseDatosGral","baseGeneral");
    //$where['eliminado'] = 0;
    $where['movimiento'] = $movimiento;
    $remisiones   =   $ci->baseGeneral->getConsecutivosInv($where);
    //verifico si ya hay remisiones de entrada creadas
    if(count($remisiones) > 0)//ya hay ordenes creadas
    {
        //si ya hay ordenes creadas debo buscar el consecutivo máximo para sumarle 1 y generar el siguiente
        $consecutivo = ($remisiones[0]['consecutivo'] + 1);
    }
    else//no hay ordenes creadas
    {
        //como no hay ordenes creadas debo inciar a crearlas desde el último consecutivo en papel, constante global _CONSECUTIVO_INICIO_REMISIONES.
        $consecutivo = _CONSECUTIVO_INICIO_ENTRADAS_INV;
    }
    return $consecutivo;
}

function cantidadComprasUsuario($idPersona)
{
    $ci = get_instance();
    $ci->load->model("general/baseDatosGral","baseGeneral");
    $ci->load->model("pedidos/baseDatosPedidos","basePedidos");

    $where['p.idPersona'] =   $idPersona;
    $where['p.valor >'] =   0;
    $pedidos            =   $ci->basePedidos->getPedidos($where);
    
    return $pedidos;

}

function sendNotifi($idPersona,$mensaje,$titulo)
{
    
   /* $ci = get_instance();
    $ci->load->model("Base/DbBase","baseDb");


    $where['l.idPersona'] = $idPersona;

    $where['l.codCelular !=']     = "";
    $where['l.eliminado']         = 0;
    $where['l.estado']            = 1;
    $where['r.eliminado']         = 0;
    $where['r.estado']            = 1;

    $consultaGCMcodCelular  =   $ci->baseDb->getCodCelular($where);

    if(count($consultaGCMcodCelular) > 0){

        $registrationId         = array($consultaGCMcodCelular[0]['codCelular']);

        $msg = array
        (
            'message'   => $mensaje,
            'title'     => $titulo,
            'subtitle'  => '',
            'tickerText'    => '',
            'vibrate'   => 1,
            'sound'     => 1,
            'largeIcon' => 'large_icon',
            'smallIcon' => 'small_icon'
        );

        //$msg = "please note this..";

        $fields = array
        (
            'registration_ids'  => $registrationId,
            'data'          => $msg
        );
         
        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json',
                'delay_while_idle: true',
        );
         
        try{
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            curl_close( $ch );

        
        }
        catch(Exception $e){
         
        }
    }*/



}
function ventasRelizadas()
{
    $ci = get_instance();
    $ci->load->model("pedidos/baseDatosPedidos","pedidos");
    $where['p.pedidoPara'] = 0;
    $listado   =   $ci->pedidos->informeVentas($where);
    var_dump($listado);
    
}

function dataUsuario($usuario)
{
	global $db;
	$query  = sprintf("SELECT * FROM usuarios WHERE idusuario=%s",$usuario);
	$result = $db->GetAll($query);
	return $result[0];
}
//envia notificacion push al celular
function sendFCM($titulo,$mensaje,$tokenDevice='',$apiAccessKey="")
{
	//$tokenDevice = 'dmJdcJXcRqc:APA91bHiUHLazsHNQt6nhBThj_OY1UgOcV4Q-7bFhe-Zr1CTMRQYTu2zcX6Iy1lJOqYbkLNHmqR-1auD58her-6tJnD45VPGI73CKt-Ffx41GJa8If6P0D9KUrCvMVNKmsiHfRVrKa97';
    $url        = "https://fcm.googleapis.com/fcm/send";
    $token      = $tokenDevice;
    $serverKey  = $apiAccessKey;
    $title      = $titulo;
    $body       = $mensaje;
    $notification = array('title' =>$title , 'body' => $body, 'sound' => 'default', 'badge' => '1','icon'=>base_url().'res/img/favicon.png');
    $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high','icon'=>'ic_launcher');
    $json = json_encode($arrayToSend);
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: key='. $serverKey;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    $result = curl_exec($ch);
	if ($result === FALSE) {
		die('Oops! FCM Send Error: ' . curl_error($ch));
	}
}


//esta función me dice si la tienda esta activa o ya caducó
function estadoTiendaAdmin()
{
    $dataSalida = array();
    if($_SESSION['project']['info']['idPerfil'] == 6)//admin de la tienda
    {

        $ci = get_instance();
        $ci->load->model("home/baseDatosHome","baseHome");

        $infoTienda = $ci->baseHome->getInfoTienda(array("idTienda"=>$_SESSION['project']['info']['idTienda']));
        $fechaCaducidad = date("Y-m-d",strtotime($infoTienda[0]['fechaCaducidad']));
        $fechaActual = date("Y-m-d",strtotime(date("Y-m-d")));
        //realizo las validaciones para mostrar el admin de la tienda
        if($infoTienda[0]['estadoFunciona'] == 'demo')//la tienda está en modo prueba de 6 meses
        {
            $estadoTienda = "Demostración";
            //cuando está en etapa demo debo validar la fecha actual contra la fecha en que caduca
            if($fechaActual <= $fechaCaducidad)
            {
                $mostrarTienda = 1;//aún no ha pasado el tiempo de prueba, le muestro la tienda
                $dataSalida = array("licencia"=>$estadoTienda,
                                    "mostrar"=>1,
                                    "membresia"=>$infoTienda[0]['paquete'],
                                    "estado"=>"nohacaducado");
            }
            else
            {
                $dataSalida = array("licencia"=>$estadoTienda,
                                    "mostrar"=>0,
                                    "membresia"=>$infoTienda[0]['paquete'],
                                    "estado"=>"yahacaducado");
            }
        }
        else if($infoTienda[0]['estadoFunciona'] == 'normal')
        {
            $estadoTienda = "Licencia estandar";
            //cuando está en etapa demo debo validar la fecha actual contra la fecha en que caduca
            if($fechaActual <= $fechaCaducidad)
            {
                $mostrarTienda = 1;//aún no ha pasado el tiempo de prueba, le muestro la tienda
                $dataSalida = array("licencia"=>$estadoTienda,
                                    "mostrar"=>1,
                                    "membresia"=>$infoTienda[0]['paquete'],
                                    "estado"=>"nohacaducado");
            }
            else
            {
                $dataSalida = array("licencia"=>$estadoTienda,
                                    "mostrar"=>0,
                                    "membresia"=>$infoTienda[0]['paquete'],
                                    "estado"=>"yahacaducado");
            }
        }
        else if($infoTienda[0]['estadoFunciona'] == 'noCaduca')
        {
            $estadoTienda = "Licencia vitalicia";
            //Como es vitalicia nunca debe vencer
            $dataSalida = array("licencia"=>$estadoTienda,
                                "mostrar"=>1,
                                "membresia"=>$infoTienda[0]['paquete'],
                                "estado"=>"nohacaducado");
        }
    }
    else
    {
        $dataSalida = array("licencia"=>"Admin tienda",
                            "mostrar"=>1,
                            "membresia"=>'vitalicia admin',
                            "estado"=>"nohacaducado");
    }
    return $dataSalida;
}
?>