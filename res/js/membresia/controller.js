/*
* Controlador que maneja todas las funcionalidades de la creación de usuarios
* @author Farez Prieto @orugal
* @date 15 de Noviembre de 2016
*/
project.controller('membresia', function($scope,$http,$q,constantes,$compile)
{	
	$scope.membresiaApp ="mes";
	$scope.membresiaWeb ="mes";
	$scope.AppMovil ="appMes";
	
	$scope.initCaduca = function()
	{
		$scope.config 			=  configLogin;//configuración global
		$.material.init();
	}
	//coresponde a sitio web
	$scope.AppMes= function()
	{	
		constantes.confirmacion("Atención","Esta apunto de realizar el pago de tu plan, ¿Desea continuar?. Recuerde activar las ventanas emergentes antes de continuar.",'info',function(){
			//se abre ventana pop
			var codigo = $("#codigoPago").val();
				var controlador = $scope.config.apiUrl+"pagoMembresia/insetCodigo";
				var parametros  = $("#dataPago").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{	
						var ventana ="";
						var ventana = window.open($scope.config.apiUrl+"Membresia"+'/procesoPagoOnline/'+"datos"+'/Appmes/'+json.datos, "pago_payu" , "width=600,height=880,left = 420");
						var tiempo= 0;
							var interval = setInterval(function(){
								//Comprobamos que la ventana no este cerrada
								if(ventana.closed !== false) {
									window.clearInterval(interval);
									window.location.assign($scope.config.apiUrl+"GestionTienda/categorias/45"); 
								} else {
									o +=1;
								}
							},1000)
					}
					else
					{
					constantes.alerta("Atención",json.mensaje,"error",function(){})
					}
				});
		});
	}
	//coresponde a sitio web
	$scope.AppAno= function()
	{	
		constantes.confirmacion("Atención","Esta apunto de realizar el pago de tu plan, ¿Desea continuar?. Recuerde activar las ventanas emergentes antes de continuar.",'info',function(){
			//se abre ventana pop
			var codigo = $("#codigoPago").val();
			var controlador = $scope.config.apiUrl+"pagoMembresia/insetCodigo";
				var parametros  = $("#dataPago").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{		
						var ventana ="";
						var ventana = window.open($scope.config.apiUrl+"Membresia"+'/procesoPagoOnline/'+"datos"+'/AppAno/'+json.datos, "pago_payu" , "width=600,height=880,left = 420");
						var tiempo= 0;
							var interval = setInterval(function(){
								//Comprobamos que la ventana no este cerrada
								if(ventana.closed !== false) {
									window.clearInterval(interval);
									window.location.assign($scope.config.apiUrl+"GestionTienda/categorias/45"); 
								} else {
									o +=1;
								}
							},1000)
					}
					else
					{
						constantes.alerta("Atención",json.mensaje,"error",function(){})
					}
				});
		});
	}
	//coresponde a sitio web y app movil
	$scope.WebMes= function()
	{	
		constantes.confirmacion("Atención","Esta apunto de realizar el pago de tu plan, ¿Desea continuar?. Recuerde activar las ventanas emergentes antes de continuar.",'info',function(){
			//se abre ventana pop
			var codigo = $("#codigoPago").val();
			var controlador = $scope.config.apiUrl+"pagoMembresia/insetCodigo";
				var parametros  = $("#dataPago").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						var ventana ="";
						var ventana = window.open($scope.config.apiUrl+"Membresia"+'/procesoPagoOnline/'+"datos"+'/WebMes/'+json.datos, "pago_payu" , "width=600,height=880,left = 420");
						var tiempo= 0;
							var interval = setInterval(function(){
								//Comprobamos que la ventana no este cerrada
								if(ventana.closed !== false) {
									window.clearInterval(interval);
									window.location.assign($scope.config.apiUrl+"GestionTienda/categorias/45"); 
								} else {
									o +=1;
								}
							},1000)
					}
					else
					{
						constantes.alerta("Atención",json.mensaje,"error",function(){})
					}
				});
		});
	}
	//coresponde a sitio web y app movil
	$scope.WebAno= function()
	{	
		
		constantes.confirmacion("Atención","Esta apunto de realizar el pago de tu plan, ¿Desea continuar?. Recuerde activar las ventanas emergentes antes de continuar.",'info',function(){
			//se abre ventana pop
			var codigo = $("#codigoPago").val();
			var controlador = $scope.config.apiUrl+"pagoMembresia/insetCodigo";
				var parametros  = $("#dataPago").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{	
						var ventana ="";
						var ventana = window.open($scope.config.apiUrl+"Membresia"+'/procesoPagoOnline/'+"datos"+'/WebAno/'+json.datos, "pago_payu" , "width=600,height=880,left = 420");
						var tiempo= 0;
							var interval = setInterval(function(){
								//Comprobamos que la ventana no este cerrada
								if(ventana.closed !== false) {
									window.clearInterval(interval);
									window.location.assign($scope.config.apiUrl+"GestionTienda/categorias/45"); 
								} else {
									o +=1;
								}
							},1000)
					}
					else
					{
						constantes.alerta("Atención",json.mensaje,"error",function(){})
					}
				});
		});
	}
	$scope.cambio = function (){
		constantes.confirmacion("Atención","Esta apunto de cambiar el plan que actualmente tiene adquirido, el cual corresponte solo a la tienda virtual, ¿Está deguro que desea continuar?. Recuerde activar las ventanas emergentes antes de continuar.",'info',function(){
			
			//se abre ventana pop
			var codigo = $("#codigoPago").val();
			var controlador = $scope.config.apiUrl+"pagoMembresia/insetCodigo";
			var parametros  = $("#dataPago").serialize();
			constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{	
						var ventana ="";
						var ventana = window.open($scope.config.apiUrl+"Membresia"+'/procesoPagoOnline/'+"datos"+'/WebMes/'+json.datos,"pago_payu" , "width=600,height=880,left = 420");
						var tiempo= 0;
							var interval = setInterval(function(){
								//Comprobamos que la ventana no este cerrada
								if(ventana.closed !== false) {
									window.clearInterval(interval);
									window.location.assign($scope.config.apiUrl+"GestionTienda/categorias/45"); 
								} else {
									o +=1;
								}
							},1000)
					}
					else
					{
						constantes.alerta("Atención",json.mensaje,"error",function(){})
					}
				});
		});
	}
	$scope.cambio2 = function (){
		constantes.confirmacion("Atención","Esta apunto de cambiar el plan que actualmente tiene adquirido, el cual corresponte solo a la tienda virtual, ¿Está deguro que desea continuar?. Recuerde activar las ventanas emergentes antes de continuar.",'info',function(){
			//se abre ventana pop
			var codigo = $("#codigoPago").val();
			var controlador = $scope.config.apiUrl+"pagoMembresia/insetCodigo";
				var parametros  = $("#dataPago").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						var ventana ="";
						var ventana = window.open($scope.config.apiUrl+"Membresia"+'/procesoPagoOnline/'+"datos"+'/WebAno/'+json.datos, "pago_payu" , "width=600,height=880,left = 420");
						var tiempo= 0;
							var interval = setInterval(function(){
								//Comprobamos que la ventana no este cerrada
								if(ventana.closed !== false) {
									window.clearInterval(interval);
									window.location.assign($scope.config.apiUrl+"GestionTienda/categorias/45"); 
								} else {
									o +=1;
								}
							},1000)
					}
					else
					{
						constantes.alerta("Atención",json.mensaje,"error",function(){})
					}
				});
		});
	}
	$scope.bajar = function(){
		constantes.confirmacion("Atención","Esta apunto de cambiar el plan que actualmente tiene adquirido, el cual corresponte a tienda virtual y app movil, ¿Está deguro que desea continuar?. Recuerde activar las ventanas emergentes antes de continuar.",'info',function(){
			var codigo = $("#codigoPago").val();
			var controlador = $scope.config.apiUrl+"pagoMembresia/insetCodigo";
				var parametros  = $("#dataPago").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						var ventana ="";
						var ventana = window.open($scope.config.apiUrl+"Membresia"+'/procesoPagoOnline/'+"datos"+'/WebMes/'+json.datos, "pago_payu" , "width=600,height=880,left = 420");
						var tiempo= 0;
							var interval = setInterval(function(){
								//Comprobamos que la ventana no este cerrada
								if(ventana.closed !== false) {
									window.clearInterval(interval);
									window.location.assign($scope.config.apiUrl+"GestionTienda/categorias/45"); 
								} else {
									o +=1;
								}
							},1000)
					}
					else
					{
						constantes.alerta("Atención",json.mensaje,"error",function(){})
					}
				});
		});
	}
	$scope.bajar2 = function(){
		constantes.confirmacion("Atención","Esta apunto de cambiar el plan que actual mentetiene, el cual corresponte a tienda virtual y app movil, ¿Está deguro que desea continuar?. Recuerde activar las ventanas emergentes antes de continuar.",'info',function(){
			var codigo = $("#codigoPago").val();
			var controlador = $scope.config.apiUrl+"pagoMembresia/insetCodigo";
				var parametros  = $("#dataPago").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						var ventana ="";
						var ventana = window.open($scope.config.apiUrl+"Membresia"+'/procesoPagoOnline/'+"datos"+'/WebAno/'+json.datos, "pago_payu" , "width=600,height=880,left = 420");
						var tiempo= 0;
							var interval = setInterval(function(){
								//Comprobamos que la ventana no este cerrada
								if(ventana.closed !== false) {
									window.clearInterval(interval);
									window.location.assign($scope.config.apiUrl+"GestionTienda/categorias/45"); 
								} else {
									o +=1;
								}
							},1000)
					}
					else
					{
						constantes.alerta("Atención",json.mensaje,"error",function(){})
					}
				});
		});
	}
	//movil mes
	$scope.movilMes =function(){
		constantes.confirmacion("Atención","Esta apunto de realizar el pago de tu plan, ¿Desea continuar?. Recuerde activar las ventanas emergentes antes de continuar.",'info',function(){
			//se abre ventana pop
			var codigo = $("#codigoPago").val();
			var controlador = $scope.config.apiUrl+"pagoMembresia/insetCodigo";
				var parametros  = $("#dataPago").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{		
						var ventana ="";
						var ventana = window.open($scope.config.apiUrl+"Membresia"+'/procesoPagoOnline/'+"datos"+'/movilMes/'+json.datos, "pago_payu" , "width=600,height=880,left = 420");
						var tiempo= 0;
							var interval = setInterval(function(){
								//Comprobamos que la ventana no este cerrada
								if(ventana.closed !== false) {
									window.clearInterval(interval);
									window.location.assign($scope.config.apiUrl+"GestionTienda/categorias/45"); 
								} else {
									o +=1;
								}
							},1000)
					}
					else
					{
						constantes.alerta("Atención",json.mensaje,"error",function(){})
					}
				});
		});
	}
	$scope.cambio3 = function (){
		constantes.confirmacion("Atención","Esta apunto de cambiar el plan que actualmente tiene adquirido, el cual corresponte solo a la app movil, ¿Está deguro que desea continuar?. Recuerde activar las ventanas emergentes antes de continuar.",'info',function(){
			//se abre ventana pop
			var codigo = $("#codigoPago").val();
			var controlador = $scope.config.apiUrl+"pagoMembresia/insetCodigo";
				var parametros  = $("#dataPago").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						var ventana ="";
						var ventana = window.open($scope.config.apiUrl+"Membresia"+'/procesoPagoOnline/'+"datos"+'/WebMes/'+json.datos, "pago_payu" , "width=600,height=880,left = 420");
						var tiempo= 0;
							var interval = setInterval(function(){
								//Comprobamos que la ventana no este cerrada
								if(ventana.closed !== false) {
									window.clearInterval(interval);
									window.location.assign($scope.config.apiUrl+"GestionTienda/categorias/45"); 
								} else {
									o +=1;
								}
							},1000)
					}
					else
					{
						constantes.alerta("Atención",json.mensaje,"error",function(){})
					}
				});
		});
	}
	$scope.cambio4 = function (){
		constantes.confirmacion("Atención","Esta apunto de cambiar el plan que actualmente tiene adquirido, el cual corresponte solo a la app movil, ¿Está deguro que desea continuar?. Recuerde activar las ventanas emergentes antes de continuar.",'info',function(){
			//se abre ventana pop
			var codigo = $("#codigoPago").val();
			var controlador = $scope.config.apiUrl+"pagoMembresia/insetCodigo";
				var parametros  = $("#dataPago").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						var ventana ="";
						var ventana = window.open($scope.config.apiUrl+"Membresia"+'/procesoPagoOnline/'+"datos"+'/WebAno/'+json.datos, "pago_payu" , "width=600,height=880,left = 420");
						var tiempo= 0;
							var interval = setInterval(function(){
								//Comprobamos que la ventana no este cerrada
								if(ventana.closed !== false) {
									window.clearInterval(interval);
									window.location.assign($scope.config.apiUrl+"GestionTienda/categorias/45"); 
								} else {
									o +=1;
								}
							},1000)
					}
					else
					{
						constantes.alerta("Atención",json.mensaje,"error",function(){})
					}
				});
		});
	}
	$scope.bajar3 = function(){
		constantes.confirmacion("Atención","Esta apunto de cambiar el plan que actual mentetiene, el cual corresponte a tienda virtual y app movil, ¿Está deguro que desea continuar?. Recuerde activar las ventanas emergentes antes de continuar.",'info',function(){
			var codigo = $("#codigoPago").val();
			var controlador = $scope.config.apiUrl+"pagoMembresia/insetCodigo";
				var parametros  = $("#dataPago").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						var ventana ="";
						var ventana = window.open($scope.config.apiUrl+"Membresia"+'/procesoPagoOnline/'+"datos"+'/movilMes/'+json.datos, "pago_payu" , "width=600,height=880,left = 420");
						var tiempo= 0;
							var interval = setInterval(function(){
								//Comprobamos que la ventana no este cerrada
								if(ventana.closed !== false) {
									window.clearInterval(interval);
									window.location.assign($scope.config.apiUrl+"GestionTienda/categorias/45"); 
								} else {
									o +=1;
								}
							},1000)
					}
					else
					{
						constantes.alerta("Atención",json.mensaje,"error",function(){})
					}
				});
		});
	}
	$scope.bajar4 = function(){
		constantes.confirmacion("Atención","Esta apunto de cambiar el plan que actual mentetiene, el cual corresponte a tienda virtual y app movil, ¿Está deguro que desea continuar?. Recuerde activar las ventanas emergentes antes de continuar.",'info',function(){
			var codigo = $("#codigoPago").val();
			var controlador = $scope.config.apiUrl+"pagoMembresia/insetCodigo";
				var parametros  = $("#dataPago").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						var ventana ="";
						var ventana = window.open($scope.config.apiUrl+"Membresia"+'/procesoPagoOnline/'+"datos"+'/movilAno/'+json.datos, "pago_payu" , "width=600,height=880,left = 420");
						var tiempo= 0;
							var interval = setInterval(function(){
								//Comprobamos que la ventana no este cerrada
								if(ventana.closed !== false) {
									window.clearInterval(interval);
									window.location.assign($scope.config.apiUrl+"GestionTienda/categorias/45"); 
								} else {
									o +=1;
								}
							},1000)
					}
					else
					{
						constantes.alerta("Atención",json.mensaje,"error",function(){})
					}
				});
		});
	}
});