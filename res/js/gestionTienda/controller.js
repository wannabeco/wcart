/*
* Controlador que maneja todas las funcionalidades de la creación de usuarios
* @author Farez Prieto @orugal
* @date 15 de Noviembre de 2016
*/
project.controller('gestionTienda', function($scope,$http,$q,constantes,$compile)
{
	$scope.categorias	=	[];
	$scope.categoria 	= "";
	$scope.init = function()
	{
		$scope.config 			=  configLogin;//configuración global
		$.material.init();
		$scope.consultarCategorias();
		$('#botonfoto3').click(function(){
			$('#fotoFile3').click();
		});

		
		setTimeout(function(){
			$("#tableCat").sortable({
				handle:'.seleccionador',
				revert:true,  
				axis: "y",
				tolerance: "pointer",
				dropOnEmpty:true,
				icon:'move',
				stop:function(){
					let orden = 1;
					$.each($(".ordenador"),function(){
						var el = $(this);
						$scope.ordenaCategorias(el.data('idcont'),orden)
						orden++;
					})
				}
			});
		},1000);
		setTimeout(()=>{
			$(document).ready(function() {
				$('#tableCategorias').DataTable({
					"language": {
						"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
					  },
					  "bDestroy": true,
				});
			});
		},500);

	}

	$scope.ordenaCategorias = function(id,orden)
	{
		var controlador = 	$scope.config.apiUrl+"GestionTienda/ordenaCategorias";
		var parametros  = 	{id:id,orden:orden};
		console.log(parametros);
		constantes.consultaApi(controlador,parametros,function(json){},'json');
	}


	/*function ordenarContenidos(id,orden)
	{
		let parametros = "id="+id+"&orden="+orden+"&accion=6";
		$.ajax({
				type: "POST",
				url: "externos/ajax.php",
				data: parametros,
				dataType:"json",
				beforeSend: function(objeto){
					
				},
				success: function(respuesta)
				{
					
				  },
				  error: function (var1,var2,var3){
					  
				  }
			});
	}*/

	$scope.consultarCategorias = function()
	{
		var controlador = 	$scope.config.apiUrl+"GestionTienda/getCategoriasAdmin";
		var parametros  = 	{};
		constantes.consultaApi(controlador,parametros,function(json){
			$scope.categorias = json.datos;
			$scope.$apply();
		},'json');
	}

	$scope.procesaCategoria = function(edita,confirm)
	{
		var nombreCategoria = $("#nombreProducto").val();
		var foto = $("#foto").val();
		if(nombreCategoria == "")
		{
			constantes.alerta("Atención",$("#nombreProducto").data("validation"),"info",function(){});
		}
		else if(foto == "")
		{
			constantes.alerta("Atención",$("#foto").data("validation"),"info",function(){});
		}
		else
		{
			var mensajeConfirma = confirm;
			constantes.confirmacion(confirm,"Esta a punto de crear una categoría, ¿Desea continuar?","info",function()
			{
				var parametros  = $("#formulario").serialize();
				var controlador = 	$scope.config.apiUrl+"GestionTienda/procesaCategoria";
				var parametros  = 	parametros+"&edita="+edita;
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						constantes.alerta("Atención",json.mensaje,"success",function(){
							location.reload();
						});
					}	
					else
					{
						constantes.alerta("Atención",json.mensaje,"danger",function(){
							//location.reload();
						});
					}

				},'json');
			});
			
		}
	}
	$scope.eliminaCategoria = function(idCategoria,confirm)
	{
		constantes.confirmacion(confirm,"Esta apunto de eliminar una categoría, ¿Desea continuar?","info",function()
		{
			var parametros  = $("#formulario").serialize();
			var controlador = 	$scope.config.apiUrl+"GestionTienda/eliminaCategoria";
			var parametros  = 	{idProducto:idCategoria};
			constantes.consultaApi(controlador,parametros,function(json){
				if(json.continuar == 1)
				{
					constantes.alerta("Atención",json.mensaje,"success",function(){
						location.reload();
					});
				}	
				else
				{
					constantes.alerta("Atención",json.mensaje,"danger",function(){
						//location.reload();
					});
				}

			},'json');
		});
	}
	
	/*
	* Me abre una plantilla que me permitira editar o crear los módulos
	*/
	$scope.cargaPlantillaControl = function(idProducto,edita)
	{
		$('#modalUsuarios').modal("show");
		var controlador = 	$scope.config.apiUrl+"GestionTienda/plantillaCreaCategoria";
		var parametros  = 	"edita="+edita+"&idProducto="+idProducto;
		constantes.consultaApi(controlador,parametros,function(json){
			$("#modalCrea").html(json);
			//actualiza el DOM
			$scope.compileAngularElement("#formulario");
		},'');
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
    //Funciones para la creación y edición de las subcategorías.

	$scope.subCategorias	=	[];
    $scope.initSubcategorias = function()
	{
		$scope.config 			=  configLogin;//configuración global
		$.material.init();
		$scope.consultarSubCategorias();
		setTimeout(()=>{
			$(document).ready( function () {
				$('#tableSubcategorias').DataTable({
					"language": {
						"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
					  },
					  "bDestroy": true,
				});
			} );
		},1000);
	}
    $scope.consultarSubCategorias = function()
	{
		var controlador = 	$scope.config.apiUrl+"GestionTienda/getSubCategoriasAdmin";
		var parametros  = 	{};
		constantes.consultaApi(controlador,parametros,function(json){
			$scope.subCategorias = json.datos;
			$scope.$apply();
		},'json');
	}

	$scope.cargaPlantillaControlSubcat = function(idSubcategoria,edita)
	{
		$('#modalUsuarios').modal("show");
		var controlador = 	$scope.config.apiUrl+"GestionTienda/plantillaCreaSubCategoria";
		var parametros  = 	"edita="+edita+"&idSubcategoria="+idSubcategoria;
		constantes.consultaApi(controlador,parametros,function(json){
			$("#modalCrea").html(json);
			//actualiza el DOM
			$scope.compileAngularElement("#formulario");
		},'');
	}
	$scope.procesaSubCategoria = function(edita)
	{
		var idProducto = $("#idProducto").val();
		var nombreSubcategoria = $("#nombreSubcategoria").val();
		
		if(idProducto == "")
		{
			constantes.alerta("Atención","Debe seleccionar una categoría para enlazar la nueva subcategoría","info",function(){});
		}
		else if(nombreSubcategoria == "")
		{
			constantes.alerta("Atención","Debe escribir un nombre para la subcategoría","info",function(){});
		}
		else
		{
			var mensajeConfirma = (edita==1)?"Esta a punto de editar la información de la subcategoría, ¿Desea continuar?":"Esta a punto de crear una subcategoría, ¿Desea continuar?";
			constantes.confirmacion("Atención",mensajeConfirma,"info",function()
			{
				var parametros  = $("#formulario").serialize();
				var controlador = 	$scope.config.apiUrl+"GestionTienda/procesaSubCategoria";
				var parametros  = 	parametros+"&edita="+edita;
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						constantes.alerta("Atención",json.mensaje,"success",function(){
							location.reload();
						});
					}	
					else
					{
						constantes.alerta("Atención",json.mensaje,"danger",function(){
							//location.reload();
						});
					}

				},'json');
			});
			
		}
	}
	$scope.eliminaSubCategoria = function(idSubCategoria)
	{
		constantes.confirmacion("Atención","Está a punto de eliminar la subcategoría seleccionada,¿Desea continuar?","info",function()
		{
			var parametros  = $("#formulario").serialize();
			var controlador = 	$scope.config.apiUrl+"GestionTienda/eliminaSubCategoria";
			var parametros  = 	{idSubcategoria:idSubCategoria};
			constantes.consultaApi(controlador,parametros,function(json){
				if(json.continuar == 1)
				{
					constantes.alerta("Atención",json.mensaje,"success",function(){
						location.reload();
					});
				}	
				else
				{
					constantes.alerta("Atención",json.mensaje,"danger",function(){
						//location.reload();
					});
				}

			},'json');
		});
	}

	
	$scope.productosLista	=	[];
    $scope.initProductos = function()
	{
		$scope.config 			=  configLogin;//configuración global
		$.material.init();
		$scope.consultarProductos();
		$("#imagenes").fileinput({'showUpload':false, 'maxFileCount':10, 'maxFileSize':2500,'previewFileType':'any'});
		//inicializo los botones de las fotos
		$('#botonfoto1').click(function(){
			$('#fotoFile1').click();
		});

		
		$('#botonfoto2').click(function(){
			$('#fotoFile2').click();
		});

		
		$('#botonfoto3').click(function(){
			$('#fotoFile3').click();
		});

		
		$('#botonfoto4').click(function(){
			$('#fotoFile4').click();
		});

		
		$('#botonfoto5').click(function(){
			$('#fotoFile5').click();
		});
		setTimeout(()=>{
			$(document).ready( function () {
				$('#tableProductos').DataTable({
					"language": {
						"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
					  },
					  "bDestroy": true,
				});
			} );
		},1000);
	}
	$scope.consultarProductos = function()
	{
		$scope.productosLista = [];
		var controlador = 	$scope.config.apiUrl+"GestionTienda/getProductosAdmin";
		var parametros  = 	{};
		constantes.consultaApi(controlador,parametros,function(json){
			$scope.productosLista = json.datos;
			$scope.$apply();
		},'json');
	}
	//editar
	$scope.cargaPlantillaControlProductos = function(idPresentacion,edita)
	{
		$('#modalUsuarios').modal("show");
		var controlador = 	$scope.config.apiUrl+"GestionTienda/plantillaCreaSubProductos";
		var parametros  = 	"edita="+edita+"&idPresentacion="+idPresentacion;
		constantes.consultaApi(controlador,parametros,function(json){
			$("#modalCrea").html(json.html);
			$scope.compileAngularElement("#formulario");
			
		//$compile("#formulario")($scope);
			//$("#fotoPresentacion").fileinput({allowedFileTypes: ['image']});
		},'json');
	}
	$scope.activaVariacion = function()
	{
		var tieneVariacion = $('input:radio[name=variacion]:checked').val();
		if(tieneVariacion == 1)
		{
			$(".ocultaPorVariacion").show();
			$(".ocultaPorNoVariacion").hide();
		}
		else//si no tiene
		{

			$(".ocultaPorVariacion").hide();
			$(".ocultaPorNoVariacion").show();
		}
	}
	
	$scope.uploadPic = function(archivo,caja,imagen,preloader)
	{

		var file = document.getElementById(archivo).files[0];
		var formData 	=   new FormData();
		formData.append(caja, file);
		formData.append("caja", caja);

		var controlador = 	$scope.config.apiUrl+"GestionTienda/cargaFoto"; 
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
				$("#"+preloader).show();
				$("#botonProcesar").attr("disabled","disabled");
						
			},
			//una vez finalizado correctamente
			success: function(json)
			{
				if(json.continuar == 1)
				{
					$("#"+imagen).prop("src",json.urlCompleta);
					$("#"+caja).val(json.foto);
					$("#"+preloader).hide();
					$("#botonProcesar").removeAttr("disabled");
					//activo el recortador de imagen.
					constantes.recortador(1,json.idTienda,json.urlCompleta,json.foto,imagen);
				}
				else
				{
					$("#"+preloader).hide();
					constantes.alerta("Atención",json.mensaje,"info",function(){});
				}
			},
			//si ha ocurrido un error
			error: function(){
				
			}
		});
	}

	

    $scope.buscarSubCategorias = function(persist)
    {
        var categoria = $("#idProducto").val();
        var controlador = $scope.config.apiUrl+"GestionTienda/getSubcategoriasSel";
		var parametros  = {categoria:categoria,persistencia:persist};
		constantes.consultaApi(controlador,parametros,function(json){
			$("#subcaSel").html(json)

		},'');
    }
    $scope.llenaIdProducto = function(id)
    {
    	$scope.idProducto = id;
    	$scope.$apply();
    }

    $scope.procesaProducto = function(edita)
    {
    	var idProducto 			= $("#idProducto").val();
		var idSubcategoria 		= $("#idSubcategoria").val();
    	var nombrePresentacion 	= $("#nombrePresentacion").val(); 
		var codigoProducto 		= $("#codigoProducto").val(); 
		var marca 				= $("#marca").val(); 
		var nuevo 				= $("#nuevo").val(); 
		var descripcionCorta 	= $("#descripcionPres").val(); 
		var fotoPresentacion 	= $("#fotoPresentacion").val(); 
		var variacion 			= $('input:radio[name=variacion]:checked').val(); 
		var valorPresentacion 	= $("#valorPresentacion").val(); 
		var valorAntes 			= $("#valorAntes").val(); 
		var descuento 			= $("#descuento").val();
		//vallidacion de campos
		if(idProducto == "")
		{
			constantes.alerta("Atención","Debe seleccionar una categoría para enlazar el producto","info",function(){});
		}
		else if(idSubcategoria == "")
		{
			constantes.alerta("Atención","Debe seleccionar una subcategoría para enlazar el producto","info",function(){});
		}
		else if(nombrePresentacion == "")
		{
			constantes.alerta("Atención","Por favor escriba el nombre del producto","info",function(){});
		}
		else if(marca == "")
		{
			constantes.alerta("Atención","Por favor la marca del producto","info",function(){});
		}
		else if(nuevo == "")
		{
			constantes.alerta("Atención","Por favor indique si es un nuevo producto","info",function(){});
		}
		else if(descripcionCorta == "")
		{
			constantes.alerta("Atención","Escriba una descripción para el producto","info",function(){});
		}
		/*else if(variacion == undefined || variacion == "")
		{
			constantes.alerta("Atención","Indique si el producto tiene variación o no","info",function(){});
		}
		else if(variacion == 0 && valorPresentacion == "")
		{
			constantes.alerta("Atención","Escriba el precio de venta del producto","info",function(){});
		}*/
		else
		{
			var mensajeConfirma = (edita == 1)?"Está a punto de modificar la información del producto, ¿Desea continuar?":"Está a punto de crear un nuevo producto, ¿Desea continuar?";
			constantes.confirmacion("Atención",mensajeConfirma,"info",function(){
				var formData 	=   new FormData($("#formulario")[0]);
					formData.append("edita", edita);
		        var controlador = 	$scope.config.apiUrl+"GestionTienda/procesaProductoNuevo"; 
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
		            	if(json.continuar == 1)
						{
							constantes.alerta("Atención",json.mensaje,"success",function(){
								location.reload();
							})
						}
						else
						{
							constantes.alerta("Atención",json.mensaje,"warning",function(){})
						}
		            },
		            //si ha ocurrido un error
		            error: function(){
		              
		            }
		        });
			});
		}

		
    }
    //variaciones
    //$scope.productosLista	=	[];
    $scope.initVariaciones = function()
	{
		$scope.config 			=  configLogin;//configuración global
		$.material.init();
		//$scope.consultarProductos();
	}
	$scope.variacionesProducto = function(idPresentacion)
	{
		$('#modalUsuarios').modal("show");
		var controlador = 	$scope.config.apiUrl+"GestionTienda/plantillaVariaciones";
		var parametros  = 	"idPresentacion="+idPresentacion;
		constantes.consultaApi(controlador,parametros,function(json){
			$("#modalCrea").html(json);
			$scope.compileAngularElement("#formulario");
			//$("#fotoPresentacion").fileinput({allowedFileTypes: ['image']});
		},'');
	}
	$scope.agregarVariacion = function()
	{
		var random = Math.round(Math.random() * (1000 - 1) + 1);
		var dataInfovar = {nueva:1,idVariacion:random};
		var form = '';
		form += '<div class="row variacionesList" data-idvariacion="'+random+'" data-nueva="1" id="panelVariacion'+random+'">';
		 form += '  <div class="col col-lg-12 col-md-12">';
		form += '	<br><button type="button" class="close" title="Eliminar esta variación" ng-click="eliminaVariacion('+random+')">';
        form += '     	<span aria-hidden="true">&times;</span>';
        form += ' 	</button>';
        form += '  </div>';
        form += '  <div class="col col-lg-6 col-md-6">';
        form += '      <div class="form-group  label-floating">';
        form += '          <label class="control-label" for="nombreVariacion">Feature</label>';
        form += '            <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="nombreVariacion'+random+'" name="nombreVariacion"  class="form-control" type="text">';
        form += '      </div>';
        form += '   </div>';
        form += '   <div class="col col-lg-6 col-md-6">';
        form += '      <div class="form-group  label-floating">';
        form += '          <label class="control-label" for="valorPresentacion">Value *</label>';
        form += '            <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="valorPresentacion'+random+'" name="valorPresentacion"  class="form-control"  type="text">';
        form += '      </div>';
        form += '   </div>';
        // form += '   <div class="col col-lg-4 col-md-4">';
        // form += '      <div class="form-group  label-floating">';
        // form += '          <label class="control-label" for="valorAntes">Valor anterior</label>';
        // form += '            <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="valorAntes'+random+'" name="valorAntes"  class="form-control"  type="text">';
        // form += '        <p class="help-block">Sin puntos, sin $. Sólo si aplica</p>';
        // form += '      </div>';
        // form += '   </div>';
        // form += '   <div class="col col-lg-4 col-md-4">';
        // form += '      <div class="form-group  label-floating">';
        // form += '          <label class="control-label" for="variacion">Descuento</label>';
        // form += '            <input style="text-transform: uppercase" tabindex="2" autocomplete="off" id="descuento'+random+'" name="descuento"  class="form-control" type="text">';
        // form += '        <p class="help-block">Sin puntos, sin %. Sólo si aplica</p>';
        // form += '      </div>';
        // form += '   </div>';
        form += '</div>';
        //form += '<div style="height:1px;background:#ccc;width:100%"></div>';
        $("#contVariaciones").append(form);
        //$scope.compileAngularElement("#formulario");
		$compile("#formulario")($scope);
	}

	$scope.eliminaVariacion = function(idVariacion)
	{
		var element = $("#panelVariacion"+idVariacion);
		var nueva 	= $(element).data("nueva");
		constantes.confirmacion("Atención","Está seguro que desea eliminar esta variación del producto","info",function(){
			if(nueva == 1)//si es nueva solo elimino el panel
			{
				element.remove();
				swal.close();
			}
			else
			{

				var controlador = 	$scope.config.apiUrl+"GestionTienda/eliminaVariacion";
				var parametros  = 	{idVariacion:idVariacion}
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						//si no es nueva debo borrarla de la base de datos
						element.remove();
						swal.close();
					}
					else
					{
						constantes.alerta("Atención!",json.mensaje,"danger",function(){});
					}

				},'json');
			}
		});
		
	}

	$scope.eliminarProducto = function(idPresentacion)
	{
		constantes.confirmacion("Atención","Está a punto de eliminar el producto seleccionado, recuerde que esto también eliminará las variaciones que tenga,¿Desea continuar?","info",function(){
			var controlador = 	$scope.config.apiUrl+"GestionTienda/eliminaProducto";
			var parametros  = 	{idPresentacion:idPresentacion}
			constantes.consultaApi(controlador,parametros,function(json){
				if(json.continuar == 1)
				{
					constantes.alerta("Atención!",json.mensaje,"success",function(){
						$scope.consultarProductos();
						swal.close();
					});
				}
				else
				{
					constantes.alerta("Atención!",json.mensaje,"danger",function(){
						$scope.consultarProductos();
						swal.close();
					});
				}

			},'json');
		});
	}

	$scope.procesaVariaciones = function()
	{
		var element = $(".variacionesList");
		var error = 0;
		$.each(element,function(e2,ele2){
			var idVariacion2 = $(ele2).data("idvariacion");
			var nombreVar2 	= $("#nombreVariacion"+idVariacion2).val();
			var valor2 		= $("#valorPresentacion"+idVariacion2).val();
			if(nombreVar2 == "")
			{
				error++;
			}
			else if(valor2 == "")
			{
				error++;
			}
		});

		

		if(error == 0)
		{
			var operados = 0;
			constantes.confirmacion("Atención","Está a punto de guardar la información de las variaciones, ¿Desea continuar?","info",function(){
				$.each(element,function(e,ele){
					var idVariacion 	= $(ele).data("idvariacion");
					var nueva 			= $(ele).data("nueva");
					var nombreVar 		= $("#nombreVariacion"+idVariacion).val();
					var valor 			= $("#valorPresentacion"+idVariacion).val();
					var descuento 		= $("#descuento"+idVariacion).val();
					var valorAntes 		= $("#valorAntes"+idVariacion).val();
					var idPresentacion 	= $("#idPresentacion").val();
					//valido
					//realizo el guardado de una en una, si es nueva la creo y si es antigua la actualizo.
					var controlador = 	$scope.config.apiUrl+"GestionTienda/procesaVariaciones";
					var parametros  = 	{nueva:nueva,idVariacion:idVariacion,nombreVar:nombreVar,valor:valor,idPresentacion:idPresentacion,descuento:descuento,valorAntes:valorAntes}
					constantes.consultaApi(controlador,parametros,function(json){
						if(json.continuar == 1)
						{
							
							operados++;
						}

						if(operados == element.length)
						{
							constantes.alerta("Atención!","Product features have been processed correctly","success",function(){
								$scope.variacionesProducto(idPresentacion);
							});
						}

					},'json');
				});
			});
			
			
		}
		else
		{
			constantes.alerta("Atención!","Debe marcar el campo nombre de la característica o valor de la característica ya que son obligatorios","info",function(){

			});
		}
		
	}
	//plantilla comentarios
	$scope.cargaPlantillaComentarios = function(idPresentacion,ver)
	{
		$('#modalUsuarios').modal("show");
		var controlador = 	$scope.config.apiUrl+"GestionTienda/cargaPlantillaComentarios";
		var parametros  = 	"ver="+ver+"&idPresentacion="+idPresentacion;
		constantes.consultaApi(controlador,parametros,function(json){
			$("#modalCrea").html(json.html);
			$scope.compileAngularElement("#formulario");
		},'json');
	}
	//estrellas
	$scope.pintastrellas =function(puntos, votantes, idPresentacion){
		var resultado = Math.round(puntos/votantes, 0);
		var estrellas = "";
		if (puntos == '0' && votantes == '0'){
			estrellas += '<i title="Sin calificación" class="far fa-star text-primary"></i>';
			estrellas += '<i title="Sin calificación" class="far fa-star text-primary"></i>';
			estrellas += '<i title="Sin calificación" class="far fa-star text-primary"></i>';
			estrellas += '<i title="Sin calificación" class="far fa-star text-primary"></i>';
			estrellas += '<i title="Sin calificación" class="far fa-star text-primary"></i>';
		}else{
			for(i = 1;i<=resultado; i++){
				estrellas += '<i title="Calificación: '+resultado+'" class="fas fa-star text-primary"></i>';
			}
			var estrellaBlancas = 5 - resultado;
			for(a = 1;a <= estrellaBlancas; a++){
				estrellas += '<i title="Calificación: '+resultado+'" class="far fa-star text-primary"></i>';
			}
		}
		$('#estrella'+idPresentacion).html(estrellas);
	}
	//eliminar comentarios
	$scope.eliminarComentario = function(idComentario,idPresentacion,votantes,puntos,calificacion)
	{
		constantes.confirmacion("Atención","Está a punto de eliminar el comentario,¿Desea continuar?","info",function(){
			var controlador = 	$scope.config.apiUrl+"GestionTienda/eliminarComentario";
			var parametros  = 	{idComentario:idComentario, idPresentacion:idPresentacion, votantes:votantes, puntos:puntos, calificacion:calificacion}
			constantes.consultaApi(controlador,parametros,function(json){
				if(json.continuar == 1)
				{
					constantes.alerta("Atención!",json.mensaje,"success",function(){
						location.reload();
					});
				}
				else
				{
					constantes.alerta("Atención!",json.mensaje,"danger",function(){
					});
				}
			},'json');
		});
	}
	//plantilla actualiza producto
	$scope.cargaPlantillaActualizaProductos = function(idPresentacion,ver)
	{
		$('#modalUsuarios').modal("show");
		var controlador = 	$scope.config.apiUrl+"GestionTienda/cargaPlantillaActualizaProductos";
		var parametros  = 	"ver="+ver+"&idPresentacion="+idPresentacion;
		constantes.consultaApi(controlador,parametros,function(json){
			$("#modalCrea").html(json.html);
			$scope.compileAngularElement("#formulario");
		},'json');
	}
	//carga archivo CSV
	$scope.cargaCSV = function(){
		var csv_file			= $("#csv_file").val();
		//console.log(csv_file);
		if(csv_file == ''){
			constantes.alerta("Atención","Debe de seleccionar un archivo con extencion CSV para poder guardar","info",function(){});
		}
		else{
			constantes.confirmacion("Confirmación!","Los datos que acaba de ingresar son correctos?, desea continuar?","info",function(){
			var idTienda	=   $('#idTienda').val();
            var formData 	=   new FormData($("#formulario")[0]);
            var controlador = 	$scope.config.apiUrl+"GestionTienda/procesaDatacsv"; 
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

						if(json.continuar == 1)
						{
							constantes.alerta("Atención",json.mensaje,"success",function(){
								setTimeout(function(){
									if(json.datos.length > 0){
										constantes.alerta("Atención","Al presionar OK se descargará los productos no actualizados","success",function(){ 
											var excelProductos = $scope.config.apiUrl+"GestionTienda/datosexcel";
											document.location  = excelProductos;
										})
									}
								},500);
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
	//carga de plantilla para productos masivos
	$scope.cargaPlantillaProductosMasivos = function(idPresentacion,ver)
	{
		$('#modalUsuarios').modal("show");
		var idTienda	=   $('#idTienda').val();
		var controlador = 	$scope.config.apiUrl+"GestionTienda/cargaPlantillaProductosMasivos";
		var parametros  = 	"ver="+ver+"&idPresentacion="+idPresentacion;
		constantes.consultaApi(controlador,parametros,function(json){
			$("#modalCrea").html(json.html);
			$scope.compileAngularElement("#formulario");
		},'json');
	}
	//carga de productos masivos
	$scope.cargaProductosMasivos 	= function(){
		var csv_file				= $("#csv_file").val();
		var idProducto				= $('#idProducto').val();
		var idSubcategoria			= $('#idSubcategoria').val();
		//console.log(csv_file);
		if(idProducto == ''){
			constantes.alerta("Atención!","Debe de seleccionar una categoria para el carge de los productos","info",function(){});
		}
		else if(idSubcategoria == ''){
			constantes.alerta("Atención!","Debe de seleccionar una subcategoria para el carge de los productos","info",function(){});
		}
		else if(csv_file == ''){
			constantes.alerta("Atención","Debe de seleccionar un archivo con extencion CSV para poder guardar","info",function(){});
		}
		else{
			constantes.confirmacion("Confirmación!","Los datos que acaba de ingresar son correctos?, ¿Desea continuar?","info",function(){
			var idTienda				= $('#idTienda').val();
			var idProducto				= $('#idProducto').val();
			var idSubcategoria			= $('#idSubcategoria').val();
            var formData 	=   new FormData($("#formulario")[0]);
            var controlador = 	$scope.config.apiUrl+"GestionTienda/procesaProductosMasivoscsv"; 
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
						if(json.continuar == 1)
						{
							constantes.alerta("Atención",json.mensaje,"success",function(){
								setTimeout(function(){
									if(json.datos.length > 0){
										constantes.alerta("Atención","Al presionar OK se descargará los productos no Registrados","success",function(){ 
											var excelProductos = $scope.config.apiUrl+"GestionTienda/datosexcelmasivo";
											document.location  = excelProductos;
										})
									}
								},500);
								location.reload();
							})
							
						}
						
						else
						{
							constantes.alerta("Atención",json.mensaje,"error",function(){
							})
						}    
					},
					//si ha ocurrido un error
					error: function(){
					}
            	});
			});
		}
	}
	//carga de plantilla de imagenes masivas
    $scope.cargaPlantillaCargaFotos = function(idPresentacion,ver)
    {
        $('#modalUsuarios').modal("show");
        var idTienda    =   $('#idTienda').val();
        var controlador =   $scope.config.apiUrl+"GestionTienda/cargaPlantillaCargaFotos";
        var parametros  =   "ver="+ver+"&idPresentacion="+idPresentacion;
        constantes.consultaApi(controlador,parametros,function(json){
            $("#modalCrea").html(json.html);
            $scope.compileAngularElement("#formulario");
        },'json');
    }
    //cargue de imagenes masivas
    $scope.cargarImagenes = function(){
		var imagenes			= $("#imagenes").val();
		if(imagenes == ''){
			constantes.alerta("Atención","Debe de seleccionar una imagen para poder guardar	","info",function(){});
		}
		else{
			constantes.confirmacion("Confirmación!","Los datos que acaba de ingresar son correctos?, ¿Desea continuar?","info",function(){
			var idTienda	=   $('#idTienda').val();
            var formData 	=   new FormData($("#formulario")[0]);
            var controlador = 	$scope.config.apiUrl+"GestionTienda/procesaDataimagenes"; 
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

	//
	$scope.Banners	=	[];
	$scope.Banner 	= "";
	$scope.initBanner = function()
	{
		$scope.config 			=  configLogin;//configuración global
		$(document).ready( function () {
			$('#tablaPedido').DataTable({
				"language": {
					"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
				  },
				  "bDestroy": true,
			});
		} );
		$.material.init();
		$scope.getbanner();
		$('#botonfoto3').click(function(){
			$('#fotoFile3').click();
		});

		setTimeout(function(){
			$("#tableBanner").sortable({
				handle:'.seleccionador',
				revert:true,  
				axis: "y",
				tolerance: "pointer",
				dropOnEmpty:true,
				icon:'move',
				stop:function(){
					let orden = 1;
					$.each($(".ordenador"),function(){
						var el = $(this);
						$scope.ordenaBanner(el.data('id'),orden)
						orden++;
					})
				}
			});
		},1000);
		setTimeout(()=>{
			$(document).ready( function () {
				$('#tableBanner').DataTable({
					"language": {
						"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
					  },
					  "bDestroy": true,
				});
			} );
		},500);
	}

	//odenar banner
	$scope.ordenaBanner = function(id,orden)
	{
		var controlador = 	$scope.config.apiUrl+"GestionTienda/ordenaBanner";
		var parametros  = 	{id:id,orden:orden};
		//console.log(parametros);
		constantes.consultaApi(controlador,parametros,function(json){},'json');
	}

	// se obtinen lo banners
	$scope.getbanner = function()
	{
		var controlador = 	$scope.config.apiUrl+"GestionTienda/getbanner";
		var parametros  = 	{};
		constantes.consultaApi(controlador,parametros,function(json){
			$scope.Banners = json.datos;
			$scope.$apply();
		},'json');
	}

	$scope.cambiaElemento =function()
	{
		var tipolink = $('#tipoLink').val();

		if(tipolink == 'url'){
			$('.elementos').hide();
			$('.link').show();
		}
		else{
			$('.elementos').hide();
			$('.productos').show();
		}
	} 

	//procesa banner
	$scope.tipoLink = "";
	$scope.procesaBanner = function(edita,confirm)
	{	
		var tituloBanner 	= $("#tituloBanner").val();
		var fotoBanner 		= $("#fotoBanner").val();
		var tipoLink		= $('#tipoLink').val();
		var linkBanner		= $("#linkBanner").val();
		var idPresentacion	= $("idPresentacion").val();

		if(tituloBanner == "")
		{
			constantes.alerta("Atención","El nombre del banner es requerido","info",function(){});
		}
		// else if(fotoBanner == "" && fotoBanner2 == "")
		// {
		// 	constantes.alerta("Atención","por favor seleccione una foto para el banner","info",function(){});
		// }
		else if(tipoLink === "")
		{
			constantes.alerta("Atención","Seleccione tipo de Banner","info",function(){});
		}
		else if(tipoLink === 'url' & linkBanner == ''){
			constantes.alerta("Atención","La url a la cual pertenece el banner es requerido","info",function(){});
		}
		else if(tipoLink === 'producto' & idPresentacion == ''){
			constantes.alerta("Atención","Seleccione un producto","info",function(){});
		}
		
		{
			var mensajeConfirma = confirm;

			constantes.confirmacion(confirm,"Esta apunto de crar un banner, ¿Desea continuar?","info",function()
			{
				var controlador = configLogin.apiUrl+"GestionTienda/procesaBanner";
				var parametros  = $("#formulario").serialize();
				var parametros  = parametros+"&edita="+edita;
				constantes.consultaApi(controlador,parametros,function(json){
					if(json.continuar == 1)
					{
						constantes.alerta("Atención",json.mensaje,"success",function(){
							location.reload();
						});
					}	
					else
					{
						constantes.alerta("Atención",json.mensaje,"danger",function(){
							location.reload();
						});
					}

				},'json');
			});
			
		}
	}
	//carga foto de banner
	$scope.uploadFoto = function(archivo,caja,imagen,preloader)
	{

		var file = document.getElementById(archivo).files[0];
		var formData 	=   new FormData();
		formData.append(caja, file);
		formData.append("caja", caja);

		var controlador = 	$scope.config.apiUrl+"GestionTienda/cargaFotoBanner"; 
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
				$("#"+preloader).show();
				$("#botonProcesar").attr("disabled","disabled");
						
			},
			//una vez finalizado correctamente
			success: function(json)
			{
				if(json.continuar == 1)
				{
					$("#"+imagen).prop("src",json.urlCompleta);
					$("#"+caja).val(json.foto);
					$("#"+preloader).hide();
					$("#botonProcesar").removeAttr("disabled");
					
					//activo el recortador de imagen.
					constantes.recortador(2,json.idTienda,json.urlCompleta,json.foto,imagen);
				}
				else
				{
					$("#"+preloader).hide();
					constantes.alerta("Atención",json.mensaje,"info",function(){});
				}
			},
			//si ha ocurrido un error
			error: function(){
				
			}
		});
	}

	$scope.buscarSubCategorias = function(persist)
    {
        var categoria = $("#idProducto").val();
        var controlador = configLogin.apiUrl+"GestionTienda/getSubcategoriasba";
		var parametros  = {categoria:categoria,persistencia:persist};
		constantes.consultaApi(controlador,parametros,function(json){
			$("#subcaSel").html(json)

		},'');
    }

	$scope.getProductos =function(subca){
		var categoria 	= $("#idProducto").val();
		var subcategoria = $("#idSubcategoria").val();
        var controlador = configLogin.apiUrl+"GestionTienda/getProductosTotal";
		var parametros  = {categoria:categoria,subcategoria:subcategoria,subcategorias:subca,persistencia:subca};
		constantes.consultaApi(controlador,parametros,function(json){
			$("#productosSel").html(json)

		},'');

	}

	//funcion para cargar modal crear y ediatar
	$scope.cargaPlantillaControlBanner = function(idBanner,edita)
	{
		$('#modalUsuarios').modal("show");
		var controlador = 	$scope.config.apiUrl+"GestionTienda/plantillaCreaBanner";
		var parametros  = 	"edita="+edita+"&idBanner="+idBanner;
		constantes.consultaApi(controlador,parametros,function(json){
			$("#modalCrea").html(json);
			//actualiza el DOM
			$scope.compileAngularElement("#formulario");
		},'');
	}

	//eliminar banner
	$scope.eliminaBanner = function(idBanner,confirm)
	{
		constantes.confirmacion(confirm,"","info",function()
		{
			var parametros  = $("#formulario").serialize();
			var controlador = 	$scope.config.apiUrl+"GestionTienda/eliminaBanner";
			var parametros  = 	{idBanner:idBanner};
			constantes.consultaApi(controlador,parametros,function(json){
				if(json.continuar == 1)
				{
					constantes.alerta("Atención",json.mensaje,"success",function(){
						location.reload();
					});
				}	
				else
				{
					constantes.alerta("Atención",json.mensaje,"danger",function(){
						//location.reload();
					});
				}

			},'json');
		});
	}
	//init caduca
	//$scope.initCaduca = function()
	//{
		//$scope.config 			=  configLogin;//configuración global
		//$.material.init();
		//$scope.cargaPlantillainfoModal();

	//}
	//funcion para cargar modal de informacion compra
	$scope.cargaPlantillainfoModal = function()
	{	
		$('#infoModal').modal("show");
		var controlador = 	$scope.config.apiUrl+"GestionTienda/plantillaModalInfo";
		//var parametros  = 	"edita="+edita+"&idBanner="+idBanner;
		constantes.consultaApi(controlador,function(json){
			$("#modalCrea").html(json);
			//actualiza el DOM
			$scope.compileAngularElement("#infoModal");
		},'');
	}

});