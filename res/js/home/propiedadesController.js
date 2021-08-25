/*
* Controlador que maneja todas las funcionalidades de la aplicación
* @author Farez Prieto @orugal
*/
project.controller('home', function($scope,$http,$q,constantes)
{
    $scope.initHome = function()
    {
		$scope.config = configLogin;
		/*constantes.crearNotificacion('Sistema de pedidos','Notificacion de nuevo pedido','',function(){
			alert("Prueba de notificacion Callback")
		});*/
		$scope.getPedidosHome();
	}
	
	$scope.getPedidosHome = function()
	{
		//alert("sdfsdf");
		var controlador = $scope.config.apiUrl+"App/ajaxPedidos";
		var parametros  = {};
		constantes.consultaApi(controlador,parametros,function(json){
			//alert(json)
			$("#listaPedidos").html(json);
		},'html');


		setTimeout(function(){
			$scope.getPedidosHome()
		},30000);

	}

   

});
