/*
* Controlador que maneja todas las funcionalidades de la zona de registro
* @author Farez Prieto @orugal
* @date 28 de Junio de 2016
*/
project.controller('registroEmpresas', function($scope,$http,$q,constantes)
{
	$scope.departamento 	= 	$("#departamento").val();
	$scope.ciudadesSelect	= 	[];
	$scope.nombre			=	$("#nombre").val();
	$scope.direccion		=	$("#direccion").val();
	$scope.telefono			=	$("#telefono").val();
	$scope.email			=	$("#email").val();
	$scope.ciudad			=	$("#ciudad").val();
	$scope.clave			=	$("#clave").val();
	$scope.rclave			=	$("#rclave").val();
	$scope.terminos			=	$("#terminos").val();
	$scope.conjuntos 		= 	[];
	$scope.registroInit = function()
	{
		$scope.config = configLogin;//configuración global
		$('#formRegEmpresas').validator()
		//setTimeout(function(){
			$scope.consultaConjuntos();
		//},500);

	}
	$scope.getCiudad = function(){
		$scope.departamento = $("#departamento").val();
		var controlador = 	$scope.config.apiUrl+"registro/getCiudades";
		var parametros  = "idDepto="+$scope.departamento;
		constantes.consultaApi(controlador,parametros,function(json){
			$scope.ciudadesSelect	= json;
			$scope.$digest();
		});
	}

	  $scope.registraUsuario = function()
	  {
	      var codVende  = $("#codVende").val();
	      var nombre    = $("#nombre").val();
	      var apellido  = $("#apellido").val();
	      var correo    = $("#correo").val();
	      var celular   = $("#celular").val();
	      // var direccion   = $("#direccion").val();
	      var torre   = $("#torre").val();
	      var apto   = $("#apto").val();
	      var conjunto  = $("#conjunto").val();
	      var clave     = $("#clave").val();
	      var rclave    = $("#rclave").val();
	      var terminos  = $("#terminos").val();
	      var codigoVendedorC  = $("#codigoVendedorC").val();

	      if(codVende == "")
	      {
	         constantes.alerta("Atención","Debe escribir un código de vendedor",'info',function(){});
	      }
	      else if(nombre == "")
	      {
	         constantes.alerta("Atención","Debe escribir su nombre",'info',function(){});
	      }
	      else if(apellido == "")
	      {
	        constantes.alerta("Atención","Debe escribir su apellido",'info',function(){});
	      }
	      // else if(correo == "")
	      // {
	      //   constantes.alerta("Atención","Debe escribir un correo electrónico",'info',function(){});
	      // }
	      else if(correo != "" && !constantes.validaMail(correo))
	      {
	        constantes.alerta("Atención","El correo electrónico no es válido, por favor verifique",'info',function(){});
	      }
	      else if(celular == "")
	      {
	        constantes.alerta("Atención","Su número de celular es importante, por favor escribalo",'info',function(){});
	      }
	      else if(conjunto == "")
	      {
	        constantes.alerta("Atención","Seleccione el conjunto residencial donde está ubicado",'info',function(){});
	      }
	      else if(torre == "")
	      {
	        constantes.alerta("Atención","Por favor indique la torre donde vive",'info',function(){});
	      }
	      else if(apto == "")
	      {
	        constantes.alerta("Atención","Por favor el apartamento donde vive",'info',function(){});
	      }
	      else if(clave == "")
	      {
	        constantes.alerta("Atención","Escriba una contraseña para su usuario",'info',function(){});
	      }
	      else if(rclave == "")
	      {
	        constantes.alerta("Atención","Repita la contraseña para su usuario",'info',function(){});
	      }
	      else if(rclave != clave)
	      {
	        constantes.alerta("Atención","Las contraseñas no coinciden, por favor verifique",'info',function(){});
	      }
	      else if(!$('#terminos').prop('checked'))
	      {
	        constantes.alerta("Atención","Recuerde que debe aceptar los términos y condiciones del servicio",'info',function(){});
	      }
	      else if(codigoVendedorC == "")
	      {
	        constantes.alerta("Atención","No ha escrito un código de vendedor o el código no es de un vendedor autorizado",'info',function(){});
	      }
	      else
	      {
	              //identificador:localStorage['identidad'],
	          var url = $scope.config.urlAPi+'registroUsuarios';
	          var parametros = { 
	              movil:'movil',
	              codVende:codVende,
	              nombre:nombre,
	              apellido:apellido,
	              email:correo,
	              celular:celular,
	              torre:torre,
	              apto:apto,
	              conjunto:conjunto,
	              rclave:rclave,
	              terminos:terminos
	          }
	          constantes.consultaApi(url,parametros,function(json)
	          {
	            //acá el usuario ya se registró
	            if(json.continuar == 1)//todo ok
	            {
	                //ahora debo loguear al usuario con sus datos
	                constantes.alerta("Registro exitoso",json.mensaje,'success',function(){
	                   location.reload();
	                });
	            }
	            else
	            {
	                constantes.alerta("Error del registro",json.mensaje,'info',function(){});
	            }
	          });
	      }
	  }

	$scope.consultaConjuntos = function()
	{
		var url = $scope.config.urlAPi+'getConjuntos';
	    var parametros = {movil:'movil',idCiudad:1}
	    constantes.consultaApi(url,parametros,function(json){
	      $scope.conjuntos = json.datos;
	      //alert(json.datos);
	      $scope.$digest();
	    });
	}

	$scope.verificaVendedor =function()
   	{
      var codVende  = $("#codVende").val();
      var url = $scope.config.urlAPi+'verificaVendedor';
      var parametros = {
          movil:'movil',
          codVende:codVende,
      }

      constantes.consultaApi(url,parametros,function(json)
      {
        //acá el usuario ya se registró
        if(json.continuar == 1)//todo ok
        {
            $('.cajasRegistro').removeAttr('readonly');
            $("#codigoVendedorC").val(json.datos[0].idPersona);
            $('#dataVendedorConsultado').html('<strong>Vendedor: </strong>'+json.datos[0].nombre+' '+json.datos[0].apellido);
        }
        else
        {
            constantes.alerta("Atención",json.mensaje,'info',function(){});
            $("#codigoVendedorC").val('');
            $('#dataVendedorConsultado').html('');
            $("#codVende").val('');
        }

      });
   	}

	$scope.verificaEmpresa = function()
	{

		var controlador = 	$scope.config.apiUrl+"registro/verificaEmpresaN";
		var parametros  = "palabra="+$scope.nombre;
		constantes.consultaApi(controlador,parametros,function(json){
			if(json.continuar)
			{

			}
		});
	}
	//registra empresas
	$scope.registraEmpresa = function()
	{
		$scope.departamento = $("#departamento").val();
		$scope.ciudad 		= $("#ciudad").val();

		if($scope.nombre == "" || $scope.nombre == undefined)
		{
			constantes.alerta("Atención","El campo nombre de la empresa es requerido","warning",function(){
				setTimeout(function(){$("#nombre").focus()});
			})
		}
		else if($scope.direccion == "" || $scope.direccion == undefined)
		{
			constantes.alerta("Atención","El campo dirección de la empresa es requerido","warning",function(){
				setTimeout(function(){$("#direccion").focus()});
			})
		}
		else if($scope.telefono == "" || $scope.telefono == undefined)
		{
			constantes.alerta("Atención","El campo teléfono de la empresa es requerido y no debe contener letras","warning",function(){
				setTimeout(function(){$("#telefono").focus()});
			})
		}
		else if($scope.telefono != "" && isNaN($scope.telefono))
		{
			constantes.alerta("Atención","El campo teléfono sólo puede contener números","warning",function(){
				setTimeout(function(){$("#telefono").focus()});
			})
		}
		else if($scope.email == "" || $scope.email == undefined)
		{
			constantes.alerta("Atención","El campo correo electrónico de la empresa es requerido y debe ser un correo válido","warning",function(){
				setTimeout(function(){$("#email").focus()});
			})
		}
		else if($scope.email != "" && !constantes.validaMail($scope.email))
		{
			constantes.alerta("Atención","Debe escribir un correo electrónico válido","warning",function(){
				setTimeout(function(){$("#email").focus()});
			})
		}
		else if($scope.departamento == "" || $scope.departamento == undefined)
		{
			constantes.alerta("Atención","Seleccione el departamento donde está ubicada su empresa","warning",function(){
				setTimeout(function(){$("#departamento").focus()});
			})
		}
		else if($scope.ciudad == "" || $scope.ciudad == undefined)
		{
			constantes.alerta("Atención","Seleccione la ciudad donde está ubicada su empresa","warning",function(){
				setTimeout(function(){$("#ciudad").focus()});
			})
		}
		else if($scope.clave == "" || $scope.clave == undefined)
		{
			constantes.alerta("Atención","Escriba una clave para su cuenta","warning",function(){
				setTimeout(function(){$("#clave").focus()});
			})
		}
		else if($scope.rclave == "" || $scope.rclave == undefined)
		{
			constantes.alerta("Atención","Debe volver a escribir la clave de ingresó anteriormente","warning",function(){
				setTimeout(function(){$("#rclave").focus()});
			})
		}
		else if($scope.clave != "" && $scope.rclave != "" && $scope.rclave != $scope.clave)
		{
			constantes.alerta("Atención","Las contraseñas no coinciden, por favor verifique.","warning",function(){
				setTimeout(function(){$("#rclave").focus()});
			})
		}
		else if(!$("#terminos").prop('checked'))
		{
			constantes.alerta("Atención","Debe leer y aceptar los términos y condiciones","warning",function(){
				setTimeout(function(){$("#terminos").focus()});
			})
		}
		else
		{
			constantes.confirmacion("Confirmación!","Los datos que acaba de ingresar son correctos, desea continuar?","info",function(){
				var controlador = $scope.config.apiUrl+"registro/insertaEmpresas";
				var parametros  = $("#formRegEmpresas").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						constantes.alerta("Atención",json.mensaje,"success",function(){
							document.location = $scope.config.apiUrl;
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
	//registra personas
	$scope.registraPersona = function()
	{
		$scope.departamento = $("#departamento").val();
		$scope.ciudad 		= $("#ciudad").val();

		if($scope.nombre == "" || $scope.nombre == undefined)
		{
			constantes.alerta("Atención","El campo nombre es requerido","warning",function(){
				setTimeout(function(){$("#nombre").focus()});
			})
		}
		else if($scope.email == "" || $scope.email == undefined)
		{
			constantes.alerta("Atención","El campo correo electrónico es requerido y debe ser un correo válido","warning",function(){
				setTimeout(function(){$("#email").focus()});
			})
		}
		else if($scope.email != "" && !constantes.validaMail($scope.email))
		{
			constantes.alerta("Atención","Debe escribir un correo electrónico válido","warning",function(){
				setTimeout(function(){$("#email").focus()});
			})
		}
		else if($scope.departamento == "" || $scope.departamento == undefined)
		{
			constantes.alerta("Atención","Seleccione el departamento donde actualmente reside","warning",function(){
				setTimeout(function(){$("#departamento").focus()});
			})
		}
		else if($scope.ciudad == "" || $scope.ciudad == undefined)
		{
			constantes.alerta("Atención","Seleccione la ciudad donde actualmente reside","warning",function(){
				setTimeout(function(){$("#ciudad").focus()});
			})
		}
		else if($scope.clave == "" || $scope.clave == undefined)
		{
			constantes.alerta("Atención","Escriba una clave para su cuenta","warning",function(){
				setTimeout(function(){$("#clave").focus()});
			})
		}
		else if($scope.rclave == "" || $scope.rclave == undefined)
		{
			constantes.alerta("Atención","Debe volver a escribir la clave de ingresó anteriormente","warning",function(){
				setTimeout(function(){$("#rclave").focus()});
			})
		}
		else if($scope.clave != "" && $scope.rclave != "" && $scope.rclave != $scope.clave)
		{
			constantes.alerta("Atención","Las contraseñas no coinciden, por favor verifique.","warning",function(){
				setTimeout(function(){$("#rclave").focus()});
			})
		}
		else if(!$("#terminos").prop('checked'))
		{
			constantes.alerta("Atención","Debe leer y aceptar los términos y condiciones","warning",function(){
				setTimeout(function(){$("#terminos").focus()});
			})
		}
		else
		{
			constantes.confirmacion("Confirmación!","Los datos que acaba de ingresar son correctos, desea continuar?","info",function(){
				var controlador = $scope.config.apiUrl+"registro/insertaPersonas";
				var parametros  = $("#formRegEmpresas").serialize();
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						constantes.alerta("Atención",json.mensaje,"success",function(){
							document.location = $scope.config.apiUrl;
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


	$scope.plantillaActualizaDatos = function(id)
	{
		$('#modal').modal("show");
		var controlador = 	$scope.config.apiUrl+"Registro/plantillaActualizaDatos";
		var parametros  = 	"&id="+id;//quiere decir que va a crear uno nuevo
		constantes.consultaApi(controlador,parametros,function(json){
				
			$("#modalData").html(json);
			//actualiza el DOM
			$scope.compileAngularElement("#formAgregaModulo");
			//$scope.$apply();

			/*$('#modalNModulo').modal("show");
			setTimeout(function(){
				$("#modalCreaModulo").html(json)
			},1000);*/
		},'');
	}


	$scope.plantillaPedidoExterno = function(id)
	{
		$('#modal').modal("show");
		var controlador = 	$scope.config.apiUrl+"Registro/plantillaPedidoExterno";
		var parametros  = 	"id="+id;//quiere decir que va a crear uno nuevo
		constantes.consultaApi(controlador,parametros,function(json){
				
			$("#modalData").html(json);
			//actualiza el DOM
			$scope.compileAngularElement("#formPedidoExterno");
			//$scope.$apply();

			/*$('#modalNModulo').modal("show");
			setTimeout(function(){
				$("#modalCreaModulo").html(json)
			},1000);*/
		},'');
	}

	$scope.realizaPedidoExterno = function()
	{
		var cantidad = $("#cantidad").val();
		var idPersona = $("#idPersona").val();
		if(cantidad == "")
	    {
	        constantes.alerta("Atención","Debe escribir la cantidad de producto a solicitar.",'info',function(){});
	    }
	    else if(cantidad != "" && cantidad == 0)
	    {
	        constantes.alerta("Atención","La cantidad a solicitar debe ser mayor a cero.",'info',function(){});
	    }
	    else
	    {
	    	constantes.confirmacion("Confirmación!","Está a punto de realizar un pedido para el usuario, desea continuar?","info",function(){
				var controlador = $scope.config.apiUrl+"registro/procesaPedidoCallCenter";
				var parametros  = {
						idPersona:idPersona,
						identificador:Math.floor(Math.random() * (1000 - 1)) + 1,
						idProducto:1,
						idPresentacion:7,
						cantidad:cantidad,
						valor:parseInt(6000) * parseInt(cantidad),
						totalCompra:parseInt(6000) * parseInt(cantidad),
						formaPago:0
					}

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


	$scope.compileAngularElement = function(elSelector) {

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

    $scope.plantillaLlamada = function(id)
    {
		$('#modal').modal("show");
		var controlador = 	$scope.config.apiUrl+"Registro/plantillaLlamada";
		var parametros  = 	"&id="+id;//quiere decir que va a crear uno nuevo
		constantes.consultaApi(controlador,parametros,function(json){
				
			$("#modalData").html(json);
			//actualiza el DOM
			$scope.compileAngularElement("#formAgregaModulo");
			$('#fechaLlamada').datetimepicker({
		        format: 'YYYY-MM-DD HH:mm'
		    });
			//$scope.$apply();

			/*$('#modalNModulo').modal("show");
			setTimeout(function(){
				$("#modalCreaModulo").html(json)
			},1000);*/
		},'');
	}

	$scope.guardaLlamadas = function(idPersona)
	{
		var observaciones = $("#observaciones").val();
		var fechaLlamada = $("#fechaLlamada").val();
		if(observaciones == "")
	    {
	        constantes.alerta("Atención","Debe dejar registro de lo que dijo el usuario.",'info',function(){});
	    }
	    else
	    {
	    	constantes.confirmacion("Confirmación!","Está a punto de guardar este seguimiento, desea continuar?","info",function(){
				var controlador = $scope.config.apiUrl+"registro/guardaSeguimiento";
				var parametros  = $("#formAgregaModulo").serialize();
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

        $scope.procesoEditaData = function()
        {
        	var nombre = $("#nombre").val();
			var apellido = $("#apellido").val();
			var email = $("#email").val();
			var celular = $("#celular").val();
			var conjunto = $("#conjunto").val();
			var torre = $("#torre").val();
			var apto = $("#apto").val();

		  if(nombre == "")
	      {
	         constantes.alerta("Atención","Debe escribir su nombre",'info',function(){});
	      }
	      else if(apellido == "")
	      {
	        constantes.alerta("Atención","Debe escribir su apellido",'info',function(){});
	      }
	      // else if(correo == "")
	      // {
	      //   constantes.alerta("Atención","Debe escribir un correo electrónico",'info',function(){});
	      // }
	      else if(email != "" && !constantes.validaMail(email))
	      {
	        constantes.alerta("Atención","El correo electrónico no es válido, por favor verifique",'info',function(){});
	      }
	      else if(celular == "")
	      {
	        constantes.alerta("Atención","Su número de celular es importante, por favor escribalo",'info',function(){});
	      }
	      else if(conjunto == "")
	      {
	        constantes.alerta("Atención","Seleccione el conjunto residencial donde está ubicado",'info',function(){});
	      }
	      else if(torre == "")
	      {
	        constantes.alerta("Atención","Por favor indique la torre donde vive",'info',function(){});
	      }
	      else if(apto == "")
	      {
	        constantes.alerta("Atención","Por favor el apartamento donde vive",'info',function(){});
	      }
			else
			{
				constantes.confirmacion("Confirmación!","Los datos que acaba de ingresar son correctos, desea continuar?","info",function(){
					var controlador = $scope.config.apiUrl+"registro/editaPersonas";
					var parametros  = $("#formAgregaModulo").serialize();
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

});
