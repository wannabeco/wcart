project.factory("constantes", function()
{
    var interfaz = {
        tamanoImagenAnuncio:1024,
        lblImgAnuncio:"1 Mb",
        tamanoArchivosExcel:10240,
        lblArchivoExcel:"10 Mb",
        tiposArchivoExcel:['xls',"xlsx"],
        tiposArchivoAnuncio:["jpg","png","gif"],
        urlBase:"",
        validaMail:function(mail)
		{
			var salida  = false;
			var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		    // Se utiliza la funcion test() nativa de JavaScript
		    if (regex.test(mail.trim())) 
		    {
		        salida  = true;
		    }
		    else 
		    {
		        salida  = false;
		    }
		    return salida;
		},
		consultaApi:function(url,parametros,callback,tipo)
		{
			var tipoSalida = (tipo == undefined)?"json":tipo;
			//la variable callback es una funcion que esta creada, esto es para que el ajax responda a esta función y ud haga lo que quiera dentro de ella y no tener que hacer nada dentro del succes del ajax y que esta función quede como standar
			 $.ajax({
		        url: url,
		        data: parametros,
		        type: "POST",
		        dataType: tipoSalida,
		        success:function(data)
		        {
		        	callback(data);
		        },
		        error:function(e) {
		            
		        }
		    });
		},
		crearNotificacion:function(autor,mensaje,icono,callback)
		{
			var icon = (icono == "")?'https://apps.wannabe.com.co/ardomicilios/res/img/favicon.png':icono;
			//Todo en código que se encuentra aquí se auto explica 
			Push.create(autor, { //Titulo de la notificación
				body: mensaje, //Texto del cuerpo de la notificación
				icon: icon, //Icono de la notificación
				timeout: 15000, //Tiempo de duración de la notificación
				onClick: function () {//Función que se cumple al realizar clic cobre la notificación
					callback();
					//window.location = configLogin.apiUrl+"/Pedidos/detalleMiPedido/40/16"; //Redirige a la siguiente web
					this.close(); //Cierra la notificación
				}
			});
		},
		alerta:function(titulo,mensaje,tipo,callback){
			swal({   
					title: titulo,   
					text: mensaje, 
					type: tipo,  
					html: true,
				  	confirmButtonColor: "#009688",
  					animation: "slide-from-top",
					confirmButtonText: "Ok",
				},
				function(isConfirm)
				{
					if(isConfirm)
					{
						callback()
					}
				}
			);
		},
		confirmacion:function(titulo,mensaje,tipo,callback,close){
			swal({
				  title: titulo,
				  text: mensaje,
				  type: tipo,
				  showCancelButton: true,
				  confirmButtonColor: "#009688",
				  confirmButtonText: "Continuar",
				  closeOnConfirm: (close == undefined)?false:true,
  				  showLoaderOnConfirm: true,
  				  animation: "slide-from-top",
				  confirmButtonText: "Ok",
				},
				function(isConfirm){
					if(isConfirm)
					{
						callback()
					}
				}
			);
		},
		recortador:function(tipo,idtienda,urlImg,nombreImagen,vistaPrevia){
			$("#panelRecorte").show();
			//pongo la imagen en el lienzo para recortar
			$("#imagenRecortar").attr("src",urlImg);

			if(tipo == 1){//imagenes cuadradas
				$("#imagenRecortar").attr("width","100%");
				$("#imagenRecortar").removeAttr("height");
			}
			else if(tipo == 2){//banners
				$("#imagenRecortar").attr("width","100%");
				$("#imagenRecortar").removeAttr("height");
			}

			//pongo el id de la tienda
			$("#idTiendarecorte").val(idtienda);
			//inicializo el plugin de recorte de imagen
			setTimeout(function(){
				if(tipo == 1){//imagenes cuadradas
					$("#imagenRecortar").rcrop({
						minSize : [200,200],
						//maxSize : [1000,1000],
						preserveAspectRatio : true,
						full : true
					});
				}
				else if(tipo == 2){//banners
					$("#imagenRecortar").rcrop({
						minSize : [1000,300],
						//maxSize : [1000,1000],
						preserveAspectRatio : true,
						full : true
					});
				}

				$("#recortarBtn").click(function(){
					var srcOriginal = $("#imagenRecortar").rcrop('getDataURL');
					//actualizo la url de la nueva tienda para guardarla
					$("#imagenRecortada").val(srcOriginal);
					//proceso a enviar por Ajax la nueva imagen recortada
					var formData 	=   new FormData();
					formData.append("idtienda", idtienda);
					formData.append("nombreImagen", nombreImagen);
					formData.append("nuevaImagen", srcOriginal);
					var controlador = 	configLogin.apiUrl+"GestionTienda/recortaFoto"; 
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
							// $("#"+preloader).show();
							// $("#botonProcesar").attr("disabled","disabled");
									
						},
						//una vez finalizado correctamente
						success: function(json){
							$("#panelRecorte").hide();
							$("#imagenRecortar").attr("src","");
							$("#idTiendarecorte").val("");
							$("#imagenRecortada").val("");
						},
						//si ha ocurrido un error
						error: function(){
							
						}
					});
					//actualizo la vista previa
					$('#'+vistaPrevia).attr('src',srcOriginal);
				});


			},500);
		}
	   
    }
    return interfaz;
})