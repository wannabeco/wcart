/*
* Controlador que maneja todas las funcionalidades de la zona de registro
* @author Farez Prieto @orugal
* @date 28 de Junio de 2016
*/
project.controller('notificacionesApp', function($scope,$http,$q,constantes,$compile)
{
	$scope.initNotificaciones = function()
	{
		$scope.config = configLogin;
	}
	$scope.enviaNotificaciones = function(idUnico,edita)
	{
		var tituloNotificacion 		= $("#tituloNotificacion").val();
		var mensajeNotificacion 	= $("#mensajeNotificacion").val();
		if(tituloNotificacion == "")
		{
			constantes.alerta("Atención","Debe escribir un titulo para la notificación",'info',function(){});
		}
		else if(mensajeNotificacion == "")
		{
			constantes.alerta("Atención","Debe escribir un mensaje para la notificación",'info',function(){});
		}
		else
		{
			constantes.confirmacion("Confirmación","Está a punto de enviar una notificación a todos los usuarios registrados, ¿desea continuar?",'info',function()
			{
				var controlador = 	$scope.config.apiUrl+"Notificaciones/sendNotificacionPush";
				var parametros  = 	$("#formulario").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					constantes.alerta("Atención",json.mensaje,'success',function(){
						location.reload();
					});
				},'json');
			});
		}


		
	}


});
