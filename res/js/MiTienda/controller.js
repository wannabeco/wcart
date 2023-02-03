/*
* Controlador que maneja todas las funcionalidades de la creación de usuarios
* @author Farez Prieto @orugal
* @date 15 de Noviembre de 2016
*/

project.controller('MiTienda', function($scope,$http,$q,constantes)
{
	
	$scope.idTienda				= "";
	$scope.fondocabecera 		= "";
	$scope.colortext 			= "";
	$scope.fondoTabs 			= "";
	$scope.colortextTabs 		= "";
	$scope.fondointerno 		= "";
	$scope.colortextinterno		= "";
	$scope.fondoTabsinterno		= "";
	$scope.colortextTabsinterno ="";
	$scope.fondoBotoninterno	= "";
	$scope.ColorTextoBoton		= "";
	$scope.idPais 				= "";
	$scope.disenoTienda			= "";

	$scope.tiendas 	= [];
	$scope.padreModulo	=	"";
	$scope.infotienda = [];
	$scope.initMiTienda = function()
	{
		$scope.infotienda = $('#MiTienda').data('infotienda');
		setTimeout(function(){
			
			//$acope.idTienda			= $scope.infotienda.idTienda;
			$scope.idPais			=$scope.infotienda.idPais;
			$scope.getDepartamentos();
			$scope.idDepartamento	=$scope.infotienda.idDepartamento;
			$scope.getCiudades();
			$scope.idciudad			=$scope.infotienda.idCiudad;
			$scope.disenoTienda		=$scope.infotienda.disenoTienda;
			$scope.fondocabecera	=$scope.infotienda.backgroundCabezaHome;
			$scope.colortext		=$scope.infotienda.colorTextoCabezaHome;		
			$scope.fondoTabs		=$scope.infotienda.backgroundTabs;
			$scope.colortextTabs	=$scope.infotienda.colorTextoTabs
			$scope.fondointerno		=$scope.infotienda.backgroundCabezaInterna;
			$scope.colortextinterno	=$scope.infotienda.colorTextoCabezaInterna;
			$scope.fondoBotoninterno=$scope.infotienda.backgroundBotones;
			$scope.ColorTextoBoton	=$scope.infotienda.colorTextoBotones;
			$scope.$digest();
		},500)
		
		$scope.config 			=  configLogin;//configuración global
		$.material.init();
		//$scope.getMiTienda();
		
		
		$("#logo").fileinput({'showUpload':false, 'previewFileType':'any'});
		$("#fabicon").fileinput({'showUpload':false, 'previewFileType':'any'});
		$('#pagoPayu').change(function(){
		
			if(!$(this).prop('checked')){
			  $('#payu_apikey').hide();
			  $('#payu_id_cuenta').hide();
			  $('#payu_id_mercado').hide();
			  $('#pPayu').hide();
		  }
		  else{
			  $('#payu_apikey').show();
			  $('#payu_id_cuenta').show();
			  $('#payu_id_mercado').show();
			  $('#pPayu').show();
		  }
		});
		$('#pagoWompi').change(function(){
			if(!$(this).prop('checked')){
			  $('#wompi_public_key').hide();
			  $('#pWompi').hide();  
		  }
		  else{
			  $('#wompi_public_key').show();
			  $('#pWompi').show();
		  }
		});
		$('#pagoStripe').change(function(){
			if(!$(this).prop('checked')){
			  $('#stripe_key').hide();
			  $('#pStripe').hide();
		  }
		  else{
			  $('#stripe_key').show();
			  $('#pStripe').show();
		  }
		});
		$(document).ready( function () {
			$('#tablaPagos').DataTable().order(5, 'desc').order(0, 'desc').draw();
		} );
	}


	$scope.getMiTienda = function(idTienda,edita)
	{
		var controlador = 	$scope.config.apiUrl+"MiTienda/getMiTienda";
		var parametros  = 	"";
		constantes.consultaApi(controlador,parametros,function(json){
			$scope.MiTienda  = json.datos;
			$scope.$digest();
		});
	}

	$scope.colorTabs=function(){
		$('#backgroundTabs').click(function(){
			$('#FondoTabs').css("background-color", "#backgroundTabs");
		});
	}
	$scope.departamentos = [];
	$scope.getDepartamentos=function(){

		var controlador = 	$scope.config.apiUrl+"MiTienda/getDepartamentos";
		var idPais		=   $scope.idPais;	
		var parametros  = 	"idPais="+idPais;
		constantes.consultaApi(controlador,parametros,function(json){
			$scope.departamentos  = json;
			$scope.$digest();
		});
	}
	$scope.ciudades = [];
	$scope.getCiudades=function(){

		var controlador 		= 	$scope.config.apiUrl+"MiTienda/getCiudades";
		var idPais				=   $scope.idPais;
		var idDepartamentos		=	$scope.idDepartamento;
		var parametros  		= 	"idPais="+idPais+"&"+"idDepartamentos="+idDepartamentos;
		constantes.consultaApi(controlador,parametros,function(json){
			$scope.ciudades  = json;
			$scope.$digest();
		});
	}
	$scope.getdatos= function()
	{
		var controlador 		= 	$scope.config.apiUrl+"MiTienda/getdatos";
		var tipoTienda			=	$("#tipoTienda").val();
		var nombreTienda		=	$("#nombreTienda").val();
		var direccionTienda		=	$("#direccionTienda").val();
		var telefonoTienda		=	$("#telefonoTienda").val();
		var celularTienda		=	$("#celularTienda").val();
		var idPais				=	$("#idPais").val();
		var departamentos		=	$("#departamentos").val();
		var ciudades			=	$("#ciudades").val();
		var email				=	$("#correoTienda").val();
		var urlTwitter			=	$("#urlTwitter").val();
		var urlLinkedin			=	$("#urlLinkedin").val();
		var urlFacebook			=	$("#urlFacebook").val();
		//empiezo la validación de campos que será la misma si es editar que si es crear
		if(tipoTienda == "")
		{
			constantes.alerta("Atención","Debe seleccionar un tipo de tienda.","info",function(){})
		}
		else if(nombreTienda == "")
		{
			constantes.alerta("Atención","Debe escribir el nombre de la tienda.","info",function(){})
		}
		else if(direccionTienda == "")
		{
			constantes.alerta("Atención","Debe escribir la direcci&oacute;n.","info",function(){})
		}
		else if(telefonoTienda != "" && isNaN(telefonoTienda))
		{
			constantes.alerta("Atención","El teléfono debe contener sólo números.","info",function(){})
		}
		else if(celularTienda == "")
		{
			constantes.alerta("Atención","Debe escribir el n&uacute;mero de celular.","info",function(){})
		}
		else if(celularTienda != "" && isNaN(celularTienda))
		{
			constantes.alerta("Atención","El celular debe contener s&oacute;lo n&uacute;meros.","info",function(){})
		}
		else if(idPais == "")
		{
			constantes.alerta("Atención","Se debe selecionar el pais","info",function(){})
		}
		else if(departamentos == "")
		{
			constantes.alerta("Atención","Debe seleccionar el departamento","info",function(){})
		}
		else if(ciudades == "")
		{
			constantes.alerta("Atención","Debe seleccionar la ciudad.","info",function(){})
		}
		else if(email == "")
		{
			constantes.alerta("Atención","Es importante escribir un correo electrónico valido ya que este será medio de comunicacion con el proveedor.","info",function(){})
		}
		else if(email != "" && !constantes.validaMail(email))
		{
			constantes.alerta("Atención","El correo electrónico ingresado no es correcto, por favor verifique.","info",function(){})
		}
		else
		{

			constantes.confirmacion("Confirmación!","¿Los datos que acaba de ingresar son correctos?, ¿desea continuar?","info",function(){
				var controlador = $scope.config.apiUrl+"MiTienda/procesaDataTienda";
				var parametros  = $("#dataTienda").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						constantes.alerta("Atención",json.mensaje,"success",function(){
							location.reload();
						})
					}
					else
					{
						constantes.alerta("Atención",json.mensaje,"error",function(){})
					}
				});
			});


			
		}
	}
	//datos graficos
	$scope.getGraficos =function(){
		var controlador 		= 	$scope.config.apiUrl+"MiTienda/getGraficos";

		var disenoTienda			=	$("#disenoTienda").val();

		if(disenoTienda == ''){
		 	constantes.alerta("Atención","Debe de seleccionar un dise&ntilde;o para la tienda","info",function(){});
		 }
		
		 else{
			constantes.confirmacion("Confirmación!","¿Los colores que acaba de ingresar son correctos?, ¿desea continuar?","info",function(){
				
				var controlador = $scope.config.apiUrl+"MiTienda/procesaDataGrafico";
				var parametros  = $("#dataGraficos").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						constantes.alerta("Atención",json.mensaje,"success",function(){
							location.reload();
						})
					}
					else
					{
						constantes.alerta("Atención",json.mensaje,"error",function(){})
					}
				});
			});			
		}
	}
	//vistar logo visorLogo
	$(function(){
		function filePreview(logoTienda){
			if(logoTienda.files && logoTienda.files[0]){
				var reader = new FileReader();

				reader.onload = function(e){
					$('#visorLogo').html("<img src='"+e.target.result+"'width='150' height= '50' />");
				}
				reader.readAsDataURL(logoTienda.files[0]);
			}
		}
		$('#logoTienda').change(function(){
			filePreview(this);
		});
	});
	//cargar logo
	$scope.cargaLogo = function(){

		
		var logoTienda			= $("#logoTienda").val();

		if(logoTienda == ''){
			constantes.alerta("Atención","Debe de seleccionar una imagen para poder guardar	","info",function(){});
		}
		else{
			constantes.confirmacion("Confirmación!","¿Los datos que acaba de ingresar son correctos?, ¿desea continuar?","info",function(){
			var idTienda	=   $('#idTienda').val();
			
            var formData 	=   new FormData($("#datalogos")[0]);
            var controlador = 	$scope.config.apiUrl+"MiTienda/procesaDatalogos"; 
            //hacemos la petición ajax  
            parametros	=	formData;
				$.ajax({
					url: controlador,  
					type: 'POST',
					data: parametros,
					dataType:"json",
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function(){
								
					},
                //una vez finalizado correctamente
					success: function(json)
					{
						//var_dum(idTienda);
						if(json.continuar == 1)
						{
							constantes.alerta("Atención",json.mensaje,"success",function(){
								location.reload();
							})
						}
						else
						{
							constantes.alerta("Atención",json.mensaje,"error",function(){})
						}    
					},
					//si ha ocurrido un error
					error: function(){
						
					}
            	});
			});
		}
	}
	//visor favicon visorFavicon
	$(function(){
		function filePreview(faviconTienda){
			if(faviconTienda.files && faviconTienda.files[0]){
				var reader = new FileReader();

				reader.onload = function(e){
					$('#visorFavicon').html("<img src='"+e.target.result+"'width='50' height= '50' />");
				}
				reader.readAsDataURL(faviconTienda.files[0]);
			}
		}
		$('#faviconTienda').change(function(){
			filePreview(this);
		});
	});
	//cargar favicon
	$scope.cargafavicon = function(){

		
		var faviconTienda			= $("#faviconTienda").val();

		if(faviconTienda == ''){
			constantes.alerta("Atención","Debe de seleccionar una imagen para poder guardar	","info",function(){});
		}
		else{
			constantes.confirmacion("Confirmación!","¿Los datos que acaba de ingresar son correctos?, ¿desea continuar?","info",function(){
			var idTienda	=   $('#idTienda').val();
			
            var formData 	=   new FormData($("#dataFavicon")[0]);
            var controlador = 	$scope.config.apiUrl+"MiTienda/procesaDatafavicon"; 
            //hacemos la petición ajax  
            parametros	=	formData;
				$.ajax({
					url: controlador,  
					type: 'POST',
					data: parametros,
					dataType:"json",
					cache: false,
					contentType: false,
					processData: false,
					beforeSend: function(){
								
					},
                //una vez finalizado correctamente
					success: function(json)
					{
						//var_dum(idTienda);
						if(json.continuar == 1)
						{
							constantes.alerta("Atención",json.mensaje,"success",function(){
								location.reload();
							})
						}
						else
						{
							constantes.alerta("Atención",json.mensaje,"error",function(){})
						}    
					},
					//si ha ocurrido un error
					error: function(){
						
					}
            	});
			});
		}
	}
	
	//actualiza pagos
	$scope.getActualizaPago =function(){

		var idTienda			= $('#idTienda').val();
		var pagoEfectivo	 	= ($('#pagoEfectivo').is(':checked'))?'si':'no';
		var pagoDatafono 	 	= ($('#pagoDatafono').is(':checked'))?'si':'no';
		var pagoRecoger 	 	= ($('#pagoRecoger').is(':checked'))?'si':'no';
		var pagoPayu 		 	= ($('#pagoPayu').is(':checked'))?'si':'no';
		var payu_apikey			= $('#payu_apikey').val();
		var payu_id_cuenta		= $('#payu_id_cuenta').val();
		var payu_id_mercado		= $('#payu_id_mercado').val();
		var pagoWompi 		 	= ($('#pagoWompi').is(':checked'))?'si':'no';
		var wompi_public_key	= $('#wompi_public_key').val();
		var pagoStripe 		 	= ($('#pagoStripe').is(':checked'))?'si':'no';
		var stripe_key			= $('#stripe_key').val();
		var nombreTransaccion	= $('#nombreTransaccion').val();

		if (pagoPayu=='si' && payu_apikey == ''){
			constantes.alerta("Atención","Debe de ingresar el Payu key","info",function(){});
		}
		else if (pagoPayu=='si' && payu_apikey != '' && payu_id_cuenta ==''){
			constantes.alerta("Atención","Debe de ingresar el id de la cuenta de payu","info",function(){});
		}
		else if (pagoPayu=='si' && payu_apikey != '' && payu_id_cuenta !='' && payu_id_mercado == ''){
			constantes.alerta("Atención","Debe de ingresar el id de mercado de la cuenta de payu","info",function(){});
		}
		else if(pagoWompi == 'si' && wompi_public_key == ''){
			constantes.alerta("Atención","Debe de ingresar el Wompi key","info",function(){});
		}
		else if(pagoStripe == 'si' && stripe_key == ''){
			constantes.alerta("Atención","Debe de ingresar el Stripe key","info",function(){});
		}
		else{
			constantes.confirmacion("Confirmación!","Las formas de pago que acaba de seleccionar son correctos?, ¿desea continuar?","info",function(){
				var variables = {idTienda:idTienda, pagoEfectivo:pagoEfectivo, pagoDatafono:pagoDatafono, pagoRecoger:pagoRecoger, pagoPayu:pagoPayu, payu_apikey:payu_apikey, payu_id_cuenta:payu_id_cuenta, payu_id_mercado:payu_id_mercado,pagoWompi:pagoWompi, wompi_public_key:wompi_public_key, pagoStripe:pagoStripe, stripe_key:stripe_key,nombreTransaccion:nombreTransaccion};
				var controlador = $scope.config.apiUrl+"MiTienda/procesaDataPagos";
				var parametros  = variables;
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						constantes.alerta("Atención",json.mensaje,"success",function(){
							location.reload();
						})
					}
					else
					{
						constantes.alerta("Atención",json.mensaje,"error",function(){})
					}
				});
			});
		}
	}
	//actualiza mantenimiento
	$scope.getmantenimiento =function(){

		var idTienda				= $('#idTienda').val();
		var manteminiento	 		= ($('#manteminiento').is(':checked'))?1:0;
		var mensajeMantenimiento	= $('#mensajeMantenimiento').val();

		if (manteminiento=='1' && mensajeMantenimiento == ''){
			
			constantes.alerta("Atención","Debe de ingresar motivo de por el cual la aplicación estará en mantenimiento","info",function(){});
		
		}
		else{
			if(manteminiento == '1'){
				constantes.confirmacion("Confirmación!","¿Desea poner la aplicacion en modo off line?","info",function(){
					var variables = {idTienda:idTienda, manteminiento:manteminiento, mensajeMantenimiento:mensajeMantenimiento};
					var controlador = $scope.config.apiUrl+"MiTienda/procesaDataMantenimiento";
					var parametros  = variables;
					constantes.consultaApi(controlador,parametros,function(json){
						if(json.continuar == 1)
						{
							constantes.alerta("Atención",json.mensaje,"success",function(){
								location.reload();
							})
						}
						else
						{
							constantes.alerta("Atención",json.mensaje,"error",function(){})
						}
					});
				});
			}
			else{
				constantes.confirmacion("Confirmación!","¿Desea poner la aplicacion en modo on line?","info",function(){
					var variables = {idTienda:idTienda, manteminiento:manteminiento, mensajeMantenimiento:mensajeMantenimiento};
					var controlador = $scope.config.apiUrl+"MiTienda/procesaDataMantenimiento";
					var parametros  = variables;
					constantes.consultaApi(controlador,parametros,function(json){
						if(json.continuar == 1)
						{
							constantes.alerta("Atención",json.mensaje,"success",function(){
								location.reload();
							})
						}
						else
						{
							constantes.alerta("Atención",json.mensaje,"error",function(){})
						}
					});
				});
			}
			
		}
	}
	$scope.click =function(){
		window.location.assign($scope.config.apiUrl+"PagoMembresia/PagoMembresia"); 
	}

});

