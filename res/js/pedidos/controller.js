/*
* Controlador que maneja todas las funcionalidades de la zona de registro
* @author Farez Prieto @orugal
* @date 28 de Junio de 2016
*/
project.controller('pedidos', function($scope,$http,$q,constantes,$compile)
{
	$scope.pedidosInit = function()
	{
		$scope.config = configLogin;
	}
	$scope.misPedidosInit = function()
	{
		$scope.config = configLogin;
	}
	$scope.nuevoPedidoInit = function()
	{
		$scope.config = configLogin;
		$scope.refrescaPedido();
	}
	$scope.cargaPlantillaAgregaProducto = function(idUnico,edita)
	{
		$('#modalUsuarios').modal("show");
		var controlador = 	$scope.config.apiUrl+"pedidos/cargaPlantillaAgregaProducto";
		var parametros  = 	"edita="+edita;
		constantes.consultaApi(controlador,parametros,function(json){
				
			$("#modalCrea").html(json);
			//actualiza el DOM
			//$scope.compileAngularElement("#formAgregaProductos");
			$compile("#formAgregaProductos")($scope);
		},'');
	}
	$scope.getPresentacionesProd = function()
	{
		$("#listadoPresentaciones").html('Espere por favor...')
		var idProducto  = $("#idProducto").val();
		var controlador = 	$scope.config.apiUrl+"Pedidos/getPresentacionesProducto";
		var parametros  = "idProducto="+idProducto;
		constantes.consultaApi(controlador,parametros,function(json){
			$("#listadoPresentaciones").html(json);
			$compile("#listadoPresentaciones")($scope);
			$scope.$digest();
		},'');
	}
	$scope.procesaPedido = function()
	{
		var idProducto    = $("#idProducto").val();
		var filas         = $(".filasProducto");
		if(idProducto == '')
		{
			constantes.confirmacion("Atención","Debe seleccionar un producto de la lista",'info',function(){});
		}
		else
		{
			var productosFinal = [];
			$.each(filas,function(){
				var idPres 		= $(this).data("idpres");
				var cantidad 	= $("#caja"+idPres).val();
				if(cantidad > 0)
				{
					var opt = {
						idProducto:idProducto,
						idPresentacion:idPres,
						cantidad:cantidad
					}
					productosFinal.push(opt);
				}
			});

			if(productosFinal.length == 0)
			{
				constantes.confirmacion("Atención","Debe seleccionar la cantidad de alguna de las presentaciones",'info',function(){});
			}
			else
			{
				constantes.confirmacion("Confirmación","¿Desea agregar los productos seleccionados al pedido?",'info',function()
				{
					var controlador = 	$scope.config.apiUrl+"pedidos/agregaPedidoTmp";
					var parametros  = {
						idProducto:idProducto,
						productos:productosFinal
					}
					constantes.consultaApi(controlador,parametros,function(json){
						if(json.continuar == 1)
						{
							constantes.alerta("Atención","Los productos se han agregado al pedido",'success',function(){
								$scope.refrescaPedido();
							});
						}
						
					});
				});
			}
		}
	}
	$scope.refrescaPedido = function()
	{
		var controlador = 	$scope.config.apiUrl+"pedidos/refrescaPedido";
		var parametros  = {}
		constantes.consultaApi(controlador,parametros,function(respuesta){
			$("#tableResultadoPedido").html(respuesta)
			setTimeout(function(){
				$compile("#tableResultadoPedido")($scope);
				//$scope.compileAngularElement("#tableResultadoPedido");
			},1000);
		},'');
	}
	$scope.enviarFormPago = function()
	{
		var formaPago = $("#formaPago").val();
		var valor 	  = $("#amount").val();
		if(formaPago == "")
		{
			constantes.alerta("Atención","Debe seleccionar la forma de pago",'info',function(){});
		}
		else
		{
			if(formaPago == 1)//contra entrega, debo guardar el pedido nada mas
			{
				constantes.confirmacion("Confirmación","Está a punto de realizar un pedido con los productos seleccionados, luego de esto será enviado a la psarela de pagos, ¿desea continuar?",'info',function()
				{
					var controlador = 	$scope.config.apiUrl+"pedidos/guardaPedido";
					var parametros  = {
						formaPago:formaPago,
						valor:valor
					}
					constantes.consultaApi(controlador,parametros,function(json){
						if(json.continuar == 1)
						{
							constantes.alerta("Respuesta",json.mensaje,'success',function()
							{
								document.location = $scope.config.apiUrl+'Pedidos/misPedidos/37';
							});
						}
					},'json');
				});
			}
			else//forma dos, guardo el pedido y voy a payu
			{
				//envio la data para procesar
				constantes.confirmacion("Confirmación","Está a punto de realizar un pedido con los productos seleccionados, luego de esto será enviado a la psarela de pagos, ¿desea continuar?",'info',function()
				{
					var controlador = 	$scope.config.apiUrl+"pedidos/guardaPedido";
					var parametros  = {
						formaPago:formaPago,
						valor:valor
					}
					constantes.consultaApi(controlador,parametros,function(json){
						if(json.continuar == 1)
						{
							$("#formPago").submit();
						}
					},'json');
				});
			}
		}
	}
	$scope.compileAngularElement = function(elSelector) 
	{
	    var elSelector = (typeof elSelector == 'string') ? elSelector : null ;  
	        // The new element to be added
	    if (elSelector != null ) {
	        var $div = $( elSelector );

	            // The parent of the new element
	            var $target = $("[ng-app]");

	          angular.element($target).injector().invoke(['$compile', function ($compile) {
	                    var $scope = angular.element($target).scope();
	                    $compile($div)($scope);
	                    // Finally, refresh the watch expressions in the new element
	                    $scope.$apply();
	                }]);
	    }
    }
	$scope.gestionaPedido = function()
	{
		
		
		var estadoPago 		= $("#estadoPago").val();
		var estadoPedido 	= $("#estadoPedido").val();
		var idPedido 		= $("#idPedido").val();
		if(estadoPago == "")
		{
			constantes.alerta("Atención","Debe seleccionar el estado del pago",'info',function(){});
		}
		else if(estadoPedido == "")
		{
			constantes.alerta("Atención","Debe seleccionar el estado del pedido",'info',function(){});
		}
		else
		{
			constantes.confirmacion("Confirmación","Está a punto de cambiar el estado del pedido, ¿desea continuar?",'info',function()
			{
				var controlador = $scope.config.apiUrl+"Pedidos/gestionPedidoAdmin";
				var parametros  = {
					estadoPago:estadoPago,
					estadoPedido:estadoPedido,
					idPedido:idPedido
				};
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						constantes.alerta("Atención",json.mensaje,'success',function(){location.reload()});
					}
					else
					{
						constantes.alerta("Atención","json.mensaje",'warning',function(){});
					}
				});
			});
		}
	}
});

project.controller('ingresoProducto', function($scope,$http,$q,constantes,$compile)
{
	$scope.initIngresoProduco = function()
	{
		$scope.config = configLogin;
		//$scope.compileAngularElement("#formAgregaInventario");
	}

	$scope.cargaPlantillaProducto = function(idUnico,edita)
	{
		$('#modalUsuarios').modal("show");
		var controlador = 	$scope.config.apiUrl+"pedidos/cargaPlantillaProducto";
		var parametros  = 	"edita="+edita+"&id="+idUnico;
		constantes.consultaApi(controlador,parametros,function(json){
				
			$("#modalCrea").html(json);
			//actualiza el DOM
			//$scope.compileAngularElement("#formAgregaProductos");
			$compile("#formAgregaInventario")($scope);
		},'');
	}

	$scope.buscaPersonaEntrega = function()
	{
		var caja = $("#cedulaPersona").val();
		var controlador = 	$scope.config.apiUrl+"pedidos/getInfoRemitentes";
		var parametros  = 	"documento="+caja;
		constantes.consultaApi(controlador,parametros,function(json){
			
			if(json.datos.length > 0)
			{
				$("#nombrePersona").val(json.datos[0].nombrePersona);
				$("#apellidoPersona").val(json.datos[0].apellidoPersona);
				$("#celularPersona").val(json.datos[0].celularPersona);
				$("#idPersonaEntrega").val(json.datos[0].idRemitente);
				$('.cajasOcultas').removeAttr('disabled');
			}
			else
			{

				$("#nombrePersona").val("");
				$("#apellidoPersona").val("");
				$("#celularPersona").val("");
				$("#idPersonaEntrega").val("");
				$('.cajasOcultas').removeAttr('disabled');
			}

		},'json');
	}

	$scope.procesaStockProducto = function(edita)
	{
		var idProducto 			= $("#idProducto").val();
		var idRemision 			= $("#idRemision").val();
		var cantidadKilos 		= $("#cantidadKilos").val();
		var cantidadCajas 		= $("#cantidadCajas").val();
		var observaciones 		= $("#observaciones").val();
		var cedulaPersona 		= $("#cedulaPersona").val();
		var nombrePersona 		= $("#nombrePersona").val();
		var apellidoPersona 	= $("#apellidoPersona").val();
		var celularPersona 		= $("#celularPersona").val();
		var idPersonaEntrega 	= $("#idPersonaEntrega").val();
		var edita 				= $("#edita").val();
		var idInventario 		= $("#idInventario").val();
		
		if(idProducto == '')
		{
			constantes.alerta("Atención","Debe seleccionar el tipo de producto a ingresar",'info',function(){});
		}
		else if(idRemision == '')
		{
			constantes.alerta("Atención","Debe escribir el documento de remisión de este producto",'info',function(){});
		}
		else if(cantidadKilos == '')
		{
			constantes.alerta("Atención","Escriba la cantidad de producto en Kilos",'info',function(){});
		}
		else if(cantidadCajas == '')
		{
			constantes.alerta("Atención","Escriba la cantidad de cajas que ingresan",'info',function(){});
		}
		else if(cedulaPersona == '')
		{
			constantes.alerta("Atención","Escriba el número de documento de la persona que está entregando el producto",'info',function(){});
		}
		else if(nombrePersona == '')
		{
			constantes.alerta("Atención","Escriba el nombre de la persona que entrega el producto",'info',function(){});
		}
		else if(apellidoPersona == '')
		{
			constantes.alerta("Atención","Escriba el apellido de la persona que entrega el producto",'info',function(){});
		}
		else if(celularPersona == '')
		{
			constantes.alerta("Atención","Escriba el número de celular de la persona que entrega el producto",'info',function(){});
		}
		else
		{
			constantes.confirmacion("Confirmación","Está a punto de realizar un ingreso de producto, ¿desea continuar?",'info',function()
			{
				var controlador = 	$scope.config.apiUrl+"pedidos/registraIngresoStock";
				var parametros = {
					idProducto:idProducto,
					idRemision:idRemision,
					cantidadKilos:cantidadKilos,
					cantidadCajas:cantidadCajas,
					cedulaPersona:cedulaPersona,
					nombrePersona:nombrePersona,
					apellidoPersona:apellidoPersona,
					celularPersona:celularPersona,
					idRemitente:idPersonaEntrega,
					observaciones:observaciones,
					idInventario:idInventario,
					edita:edita
				}
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						constantes.alerta("Atención",json.mensaje,'success',function(){location.reload();});
					}
					else
					{
						constantes.alerta("Atención",json.mensaje,'warning',function(){});
					}

				},'json');
			});
		}
	}


});
