<div class="container-fluid" ng-controller="MiTienda" ng-init="initMiTienda()" data-infoTienda ='<?php echo (json_encode($infoTienda));?>' id="MiTienda">
<!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Perfil de la tienda
                <?php  $_SESSION['project']['info']['nombre'] ?> <?php  $_SESSION['project']['info']['apellido'] ?> <!--<small>Estructura de las áreas de su empresa</small>-->
                
                <!--<?php if(getPrivilegios()[0]['crear'] == 1){ ?>
                    <div class="btn-group" >
                        <button type="button" class="btn dropdown-toggle"
                                data-toggle="dropdown">
                          <?php echo lang("lblAcciones") ?> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                          
                            <li role="separator" class="divider"></li><li class="dropdown-header"><?php echo lang("lblSeleccioneOpc") ?></li>
                            <li><a class="btn" ng-click="cargaPlantillaControl('',0)"><i class="fa fa-fw fa-plus"></i> AGREGAR NUEVO USUARIO</a></li>
                        </ul>
                    </div>
                <?php } ?>-->
            </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a>
            </li>
            <li class="active">
                 Perfil de tienda
            </li>
        </ol>
        </div>
    </div> 
    <!--barra tabs-->
   <ul class="nav nav-pills" style="background:#333333; color:#333333;};">
        <li class="active" style=" margin:0px; border-radius: 0px;">
            <a data-toggle="tab" href="#datos" style=" border-radius: 0px; color:#ffffff;">Datos  </a>
        </li>
        <li style=" margin:0px;">
            <a data-toggle="tab" href="#diseno" style="color:#ffffff; border-radius: 0px; margin:0px;"> Dise&ntilde;o </a>
        </li>
        <li style=" margin:0px;">
            <a data-toggle="tab" href="#logos" style="color:#ffffff; border-radius: 0px; margin:0px;"> Logos </a>
        </li>
        <li style=" margin:0px;">
            <a data-toggle="tab" href="#pagos" style="color:#ffffff; border-radius: 0px; margin:0px;"> Pagos</a>
        </li>
        <li style=" margin:0px;">
            <a data-toggle="tab" href="#mantenimiento" style="color:#ffffff; border-radius: 0px; margin:0px;"> Mantenimiento</a>
        </li>
    </ul>
    <div class="tab-content">
        <!--Actualizar datos de tienda-->
        <div id="datos" class="tab-pane fade in active">
            <div class="row">
                <div class="col col-lg-12 col-md-12">
                    <div class="row">
                        <div class="col col-lg-12" style="border-right:1px solid #E1E1E1; heigth:200px;">
                            <div class="row">
                            <form role="form" name="dataTienda" id="dataTienda" ng-submit="procesaDataTienda()">
                                <center><H2><strong>Datos basicos</strong></H2></center> 
                                <div class="col col-lg-3">
                                    <div class="form-group label-floating">
                                        <label class="control-label" for="tipoTienda">Tipo de tienda</label>
                                            <select name="idTipoTienda" id="tipoTienda" class="form-control">
                                                <option value=""></option>    
                                                    <?php foreach($infoTipoTienda as $tienda){ ?>
                                                        <option <?php if(isset($infoTienda['idTipoTienda']) && $infoTienda['idTipoTienda'] == $tienda['idTipoTienda']){ ?> selected<?php } ?> value="<?php echo $tienda['idTipoTienda'] ?>"><?php echo $tienda['nombreTipoTienda'] ?></option>
                                                    <?php } ?>
                                            </select>
                                        </div> 
                                    </div>
                                  <div class="col col-lg-3">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="nombreTienda">Nombre de tienda</label>
                                                <input  autocomplete="off" id="nombreTienda" name="nombreTienda"  class="form-control" value="<?php echo (isset($infoTienda['nombreTienda']))?$infoTienda['nombreTienda']:'';?>"  type="text">
                                                <p class="help-block"></p>
                                        </div> 
                                    </div>
                                    <div class="col col-lg-3">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="direccionTienda">Dirección de tienda</label>
                                            <input  autocomplete="off" id="direccionTienda" name="direccionTienda"  class="form-control" value="<?php echo (isset($infoTienda['direccionTienda']))?$infoTienda['direccionTienda']:''; ?>"  type="text">
                                            <p class="help-block"></p>
                                        </div> 
                                    </div>
                                    <div class="col col-lg-3">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="telefonoTienda">Telefono</label>
                                            <input tabindex="8" autocomplete="off" id="telefonoTienda" name="telefonoTienda"  class="form-control" value="<?php echo (isset($infoTienda['telefonoTienda']))?$infoTienda['telefonoTienda']:''; ?>"  type="text">
                                            <p class="help-block"></p>
                                        </div> 
                                    </div>
                                    <div class="col col-lg-3">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="celularTienda">Celular</label>
                                            <input tabindex="8" autocomplete="off" id="celularTienda" name="celularTienda"  class="form-control" value="<?php echo (isset($infoTienda['celularTienda']))?$infoTienda['celularTienda']:''; ?>"  type="text">
                                            <p class="help-block"></p>
                                        </div> 
                                    </div>
                                    <div class="col col-lg-3">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="idPais">Pais</label>

                                            <select name="idPais" id="idPais" class="form-control" ng-change="getPaises" ng-change="getDepartamentos()" ng-model="idPais">
                                                <option value=""></option>    
                                                    <?php foreach($infopaises as $paises){ ?>
                                                        <option <?php if(isset($infoTienda['idPais']) && $infoTienda['idPais'] == $paises['ID_PAIS']){ ?> selected<?php } ?> value="<?php echo $paises['ID_PAIS'] ?>"><?php echo $paises['NOMBRE'] ?></option>
                                                    <?php } ?>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col col-lg-3">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="idDepartamento">Departamento</label>
                                            <select name="idDepartamento" id="departamentos" class="form-control" ng-change="getCiudades()" ng-model="idDepartamento">
                                            <option value=""></option>
                                            <option value="{{deptos.ID_DPTO}}" ng-repeat="deptos in departamentos">{{deptos.NOMBRE}}</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col col-lg-3">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="idCiudad">Ciudad</label>
                                            <select name="idCiudad" id="ciudades" class="form-control" ng-model="idciudad">
                                                <option value=""></option>
                                                <option value="{{ciudades.ID_CIUDAD}}" ng-repeat="ciudades in ciudades">{{ciudades.NOMBRE}}</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div  class="col col-lg-3">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="correoTienda">Correo electrónico</label>
                                            <input autocomplete="off" id="correoTienda" name="correoTienda"  class="form-control" value="<?php echo (isset($infoTienda['correoTienda']))?$infoTienda['correoTienda']:''; ?>" type="text">
                                        </div>
                                    </div>
                                    <div  class="col col-lg-3">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="urlTwitter"><i class="fa fa-twitter"></i> Url twitter</label>
                                            <input autocomplete="off" id="urlTwitter" name="urlTwitter"  class="form-control" value="<?php echo (isset($infoTienda['urlTwitter']))?$infoTienda['urlTwitter']:''; ?>" type="text">
                                        </div>
                                    </div>
                                    <div  class="col col-lg-3">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="urlLinkedin"><i class="fa fa-linkedin"></i> Url linkedin</label>
                                            <input autocomplete="off" id="urlLinkedin" name="urlLinkedin"  class="form-control" value="<?php echo (isset($infoTienda['urlLinkedin']))?$infoTienda['urlLinkedin']:''; ?>" type="text">
                                        </div>
                                    </div>
                                    <div  class="col col-lg-3">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="urlFacebook"><i class="fa fa-facebook"></i> Url facebook</label>
                                            <input autocomplete="off" id="urlFacebook" name="urlFacebook"  class="form-control" value="<?php echo (isset($infoTienda['urlFacebook']))?$infoTienda['urlFacebook']:''; ?>" type="text">
                                        </div>
                                    </div>
                                    <div  class="col col-lg-12">
                                        <button type="submit" class="btn btn-raised btn-primary" style="position:relative; float:right; right:20px;" id="DatosBasicos" ng-click="getdatos()">ACTUALIZAR DATOS BASICOS</button>
                                        <p class="help-block"></p>
                                        <input type="hidden" name="idTienda" value="<?php echo (isset($infoTienda['idTienda']))?$infoTienda['idTienda']:''; ?>">
                                    </div>
                                </div>
                            </form>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--actualizar diseno-->
        <div id="diseno" class="tab-pane fade">
            <center><H2><strong>Editar datos graficos</strong></H2></center><br>
                <div class="col col-lg-2 col-md-3">
                    <div class="row">
                        <div class="col col-lg-12 col-md-12"  style="border-right:1px solid #E1E1E1">
                            <div class="row">
                                <form role="form" name="dataGraficos" id="dataGraficos" ng-submit="procesaDataGrafico()">
                                    <div class="col col-lg-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="disenoTienda">Dise&ntilde;o de tienda</label>
                                            <select name="disenoTienda" id="disenoTienda" ng-model="disenoTienda" class="form-control">
                                                <option value=""></option>    
                                                    
                                                    <option <?php if(isset($infoTienda['disenoTienda']) && $infoTienda['disenoTienda'] == 'cuadros'){ ?> selected<?php } ?> value="cuadros">Cuadros</option>
                                                    <option <?php if(isset($infoTienda['disenoTienda']) && $infoTienda['disenoTienda'] == 'lineas'){ ?> selected<?php } ?> value="lineas">Lista</option>
                                                    
                                            </select>
                                        </div> 
                                    </div>
                                    <br>
                                    <div class="col col-lg-12">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="backgroundCabezaHome">Fondo de cabecera</label>
                                            <input autocomplete="off" ng-model="fondocabecera" name="backgroundCabezaHome" id="backgroundCabezaHome" type="color" value="<?php echo (isset($infoTienda['backgroundCabezaHome']))?$infoTienda['backgroundCabezaHome']:''; ?>"/>
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col col-lg-12">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="colorTextoCabezaHome">Color texto cabecera</label>
                                            <input autocomplete="off" ng-model="colortext" name="colorTextoCabezaHome" id="colorTextoCabezaHome" type="color" value="<?php echo (isset($infoTienda['colorTextoCabezaHome']))?$infoTienda['colorTextoCabezaHome']:''; ?>"/>
                                            <p class="help-block"></p>
                                        </div> 
                                    </div>
                                    <br>
                                    <div class="col col-lg-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="backgroundTabs">Fondo de tabs</label>
                                            <input autocomplete="off" ng-model="fondoTabs" name="backgroundTabs" id="backgroundTabs" type="color" value="<?php echo (isset($infoTienda['backgroundTabs']))?$infoTienda['backgroundTabs']:''; ?>"/>
                                            <p class="help-block"></p>
                                        </div> 
                                    </div>
                                    <div  class="col col-lg-12">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="colorTextoTabs">Color texto tabs</label>
                                            <input autocomplete="off" ng-model="colortextTabs" name="colorTextoTabs" id="colorTextoTabs" type="color" value="<?php echo (isset($infoTienda['colorTextoTabs']))?$infoTienda['colorTextoTabs']:''; ?>"/>
                                            
                                        </div>
                                    </div>
                                    <div class="col col-lg-12">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="backgroundCabezaInterna">Fondo de interno</label>
                                            <input autocomplete="off" ng-model="fondointerno" name="backgroundCabezaInterna" id="backgroundCabezaInterna" type="color" value="<?php echo (isset($infoTienda['backgroundCabezaInterna']))?$infoTienda['backgroundCabezaInterna']:''; ?>"/>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col col-lg-12">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="colorTextoCabezaInterna">Color texto interno</label>
                                            <input autocomplete="off" ng-model="colortextinterno" name="colorTextoCabezaInterna" id="colorTextoCabezaInterna" type="color" value="<?php echo (isset($infoTienda['colorTextoCabezaInterna']))?$infoTienda['colorTextoCabezaInterna']:''; ?>"/>
                                        </div> 
                                    </div>
                                    <br>
                                    <div class="col col-lg-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="backgroundBotones">Fondo de boton</label>
                                            <input autocomplete="off" ng-model="fondoBotoninterno" name="backgroundBotones" id="backgroundBotones" type="color" value="<?php echo (isset($infoTienda['backgroundBotones']))?$infoTienda['backgroundBotones']:''; ?>"/>
                                        </div> 
                                    </div>
                                    <div  class="col col-lg-12">
                                        <div class="form-group  label-floating">
                                            <label class="control-label" for="colorTextoBotones">Color texto de boton</label>
                                            <input autocomplete="off" ng-model="ColorTextoBoton" name="colorTextoBotones" id="colorTextoBotones" type="color" value="<?php echo (isset($infoTienda['colorTextoBotones']))?$infoTienda['colorTextoBotones']:''; ?>" />
                                            <p class="help-block"></p>
                                        </div>
                                    </div>
                                    <input type="hidden" name="idTienda" value="<?php echo (isset($infoTienda['idTienda']))?$infoTienda['idTienda']:''; ?>">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--primer celular-->
                <div class="col col-lg-5 col-md-5">
                    <div class="col col-lg-12 col-md-12" style="border-right:1px solid #E1E1E1">
                       <div class="row"  style="padding: 5px;">
                            <div  class="col col-lg-12" style="">
                                <div class="col col-lg-12" id="fondoCabecera" name="fondoCabecera" style=" width: 350px; height:50px; background-color:{{fondocabecera}};">
                                        <div class="col col-lg-4">
                                            <img src="<?php echo (isset($infoTienda['logoTienda'])&& $infoTienda['logoTienda']!= '')?base_url().'assets/uploads/files/'.$infoTienda['idTienda'].'/'.$infoTienda['logoTienda']:'';?>" alt="" style="width: 100%; margin-top:10px;">   
                                        </div>
                                        <div class="col col-lg-2">
                                            <i class="fa fa-bars" id="colorText" name="colorText" style="color:{{colortext}}; position:relative; float:left; left:170px; margin-top:10px;"></i>
                                        </div>
                                </div>
                                <div class="col col-lg-12" style=" padding:5px; width: 350px; height:400px; background-color:whith; border:2px;  border:2px; overflow: scroll;">
                                    <div>
                                        <h3 style="position:relative; float:left; left:20px;">Categorias</h3>
                                        <div id="fondoBotoninterno" name="fondoBotoninterno" style="position:relative; float:left; left:60px; margin-top:10px; width: 80px; height:40px; border:2px {{fondoBotoninterno}}; border-radius:10px; background:{{fondoBotoninterno}};"><i class="fa fa-shopping-cart" style=" padding:10px; color:{{ColorTextoBoton}};"> ADD</i></div><br>
                                    </div>
                                    <div ng-if="disenoTienda=='lineas'">
                                    <?php foreach ($infocategorias as $categorias){?>
                                            <div style=" float:left; width: 100%; height:90px; margin:0 2% 20px 0; border-radius:10px;  background-image:url(../../res/img/trans.png), url(<?php echo (isset($categorias['foto'])&& $categorias['foto']!= '')?base_url().'assets/uploads/files/'.$categorias['idTienda'].'/'.$categorias['foto']:'';?>); background-size:cover; ">
                                               <h4> <center><strong style="position:relative; color:#ffffff; top:25px;"><?php echo $categorias['nombreProducto']?></strong></h4></center>
                                            </div>

                                    <?php } ?>   
                                    </div>
                                    <div ng-if="disenoTienda=='cuadros'">
                                        <div style="width: 100%; height: 150px; margin-top:50px;">    
                                            <?php foreach ($infocategorias as $categorias){?>
                                                <div style="position:relative; float:left; margin:10px; width: 140px; height:130px; border-radius:10px; background-image:url(../../res/img/trans.png), url(<?php echo (isset($categorias['foto'])&& $categorias['foto']!= '')?base_url().'assets/uploads/files/'.$categorias['idTienda'].'/'.$categorias['foto']:'';?>); background-size:cover; ">
                                                    <h5><strong style="position:relative; color:#ffffff; left:10px; top:90px;"><?php echo $categorias['nombreProducto']?></strong></h5>
                                                </div>    
                                            <?php } ?>
                                        </div> 
                                </div>
                            </div> 
                            <div class="col col-lg-12" id="fondoTabs" name="fondoTabs" style=" padding:5px; width: 350px; height:50px; background-color:{{fondoTabs}}; border:2px;">
                                <p  id="colortextTabs" name="colortextTabs" style="color:{{colortextTabs}};">
                                    <i class="fa fa-home col col-lg-4" style=" padding:15px; position:relative; float:left; left:30px;"></i>
                                </p>
                                <p id="colortextTabs" name="colortextTabs" style="color:{{colortextTabs}};">
                                    <i class="fa fa-shopping-cart col col-lg-4" style="padding:5px; position:relative; float:left; left:50px;"></i>
                                </p>
                                <p id="colortextTabs" name="colortextTabs" style="color:{{colortextTabs}};">
                                    <i class="fa fa-bell col col-lg-4" style="padding:5px; position:relative; float:left; left:50px;"></i>
                                </p>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            <!--segundo celular-->
            <div class="col col-lg-5 col-md-5">
                    <div class="col col-lg-12 col-md-12" style="border-right:1px solid #E1E1E1">
                       <div class="row"  style="padding: 5px;">
                            <div  class="col col-lg-12" style="">
                                <div class="col col-lg-12" id="fondointerno" name="fondointerno" style=" width: 350px; height:80px; background-color:{{fondointerno}}; border:2px;">
                                    <i class="fa fa-arrow-left" id="colortextinterno" name="colortextinterno" style="color:{{colortextinterno}}; padding:10px; float:left;"></i>
                                    <h5 id="colortextinterno" name="colortextinterno" style="color:{{colortextinterno}};"><strong>TECNOLOGY</strong></h5>
                                    <h6 id="colortextinterno" name="colortextinterno" style="color:{{colortextinterno}}; position:relative; margin-top:5px; padding:10px; float:left;">CAMARAS</h6>
                                    <h6 id="colortextinterno" name="colortextinterno" style="color:{{colortextinterno}}; position:relative; margin-top:5px; padding:10px; float:left;">DRON</h6>
                                    <h6 id="colortextinterno" name="colortextinterno" style="color:{{colortextinterno}}; position:relative; margin-top:5px; padding:10px; float:left;">LAPTOPS</h6>
                                    <h6 id="colortextinterno" name="colortextinterno" style="color:{{colortextinterno}}; position:relative; margin-top:5px; padding:10px; float:left;">PHONES</h6>
                                </div>
                                <div class="col col-lg-12" style=" padding:5px; width: 350px; height:370px; background-color:whith; border:2px;">
                                    <div>
                                        <div style=" float:left; left:5px; margin:10px; width: 300px; height:90px; border:1px;">
                                            <div style=" float:left; left:20px; margin:10px; width:100%; height:90px; border:2px solid; border-radius:10px;"></div>
                                        </div>
                                        <div style=" float:left; left:5px; margin:10px; width: 300px; height:90px; border:1px;">
                                            <div style=" float:left; left:20px; margin:10px; width: 100%; height:90px; border:2px solid; border-radius:10px;"></div>
                                        </div>
                                        <div style=" float:left; left:5px; margin:10px; width: 300px; height:90px; border:1px;">
                                            <div style=" float:left; left:20px; margin:10px; width: 100%; height:90px; border:2px solid; border-radius:10px;"></div>
                                        </div>
                                    </div>
                                    
                                </div> 
                                <div class="col col-lg-12" id="fondoTabs" name="fondoTabs" style=" padding:5px; width: 350px; height:50px; background-color:{{fondoTabs}}; border:2px;">
                                <p  id="colortextTabs" name="colortextTabs" style="color:{{colortextTabs}};">
                                    <i class="fa fa-home col col-lg-4" style=" padding:15px; position:relative; float:left; left:30px;"></i>
                                </p>
                                <p id="colortextTabs" name="colortextTabs" style="color:{{colortextTabs}};">
                                    <i class="fa fa-shopping-cart col col-lg-4" style="padding:5px; position:relative; float:left; left:50px;"></i>
                                </p>
                                <p id="colortextTabs" name="colortextTabs" style="color:{{colortextTabs}};">
                                    <i class="fa fa-bell col col-lg-4" style="padding:5px; position:relative; float:left; left:50px;"></i>
                                </p>
                            </div>  
                                <div  class="col col-lg-12 text-center">
                                        <button type="submit" class="btn btn-raised btn-primary" style="position:relative; float:right; right:20px;" ng-click="getGraficos()">Actulizar graficos</button>
                                        
                                    </div>    
                            </div>
                        </div>
                    </div>
                </div>
            <div>
        </div>
    </div>            
        <!--actualizar logos-->
        <div id="logos" class="tab-pane fade">
            <div class="row">
                <div class="col col-lg-12 col-md-12">
                    <div class="row">
                            <div class="row">
                                <div class="col col-lg-6 col-md-6">
                                <form role="form" name="logos" method="POST" id="datalogos" ng-submit="procesaDatalogos()">
                                    <h3 class="text-center">Logo de aplicaci&oacute;n</h3><br>
                                        <div class="row">
                                            <div class="col col-lg-12 col-md-12" style="border-right:1px solid #E1E1E1">
                                                <div class="row">
                                                    <img src="<?php echo (isset($infoTienda['logoTienda'])&& $infoTienda['logoTienda']!= '')?base_url().'assets/uploads/files/'.$infoTienda['idTienda'].'/'.$infoTienda['logoTienda']:'';?>" alt="" style="width: 150px; height: 50px; margin:20px;"><br> 
                                                    <button class="btn btn-primary">
                                                        <input type="file" id="logoTienda" name ="logoTienda"value="">
                                                    </button><br> <p style=" position:relative; float:left; left:20px;">El tamaño maximo de la imagen es de 500 px de ancho por 200 px de alto.</p><br> 
                                                    <!-- vista de logo -->
                                                    <div id="visorLogo" style="width: 150px; height: 50px; margin:20px;"> </div>
                                                    <button type="submit" class="btn btn-raised btn-primary" style="position:relative; float:right; right:20px;" id="cargaLogo" name="cargaLogo" ng-click="cargaLogo()">Actualizar Logo</button>   
                                                </div>
                                            </div>
                                            <input type="hidden" name="idTienda" value="<?php echo (isset($infoTienda['idTienda']))?$infoTienda['idTienda']:''; ?>">
                                        </div>
                                    </form>
                                </div>
                                <div class="col col-lg-6 col-md-6">
                                    <form role="form" name="dataFavicon" id="dataFavicon" ng-submit="procesaDatafavicon()">
                                        <h3 class="text-center">Favicon</h3><br>
                                        <div class="row">
                                            <div class="col col-lg-12 col-md-12" style="border-right:1px solid #E1E1E1">
                                                <div class="row">
                                                    <div class="col col-lg-12 col-md-12" style="border-right:1px solid #E1E1E1">
                                                        <div class="row">
                                                            <img src="<?php echo (isset($infoTienda['faviconTienda'])&& $infoTienda['faviconTienda']!= '')?base_url().'assets/uploads/files/'.$infoTienda['idTienda'].'/'.$infoTienda['faviconTienda']:'';?>" alt="" style="width: 50px; height: 50px; margin:20px;"><br>
                                                            <button class="btn btn-primary">
                                                                <input type="file" id="faviconTienda" name ="faviconTienda"value=""><br>
                                                                
                                                            </button>
                                                            
                                                            <p style=" position:relative; float:left; left:20px;">El tamaño maximo de la imagen es de 800 px de ancho por 800 px de alto.</p>
                                                            <br>    
                                                            <!-- vista de logo -->
                                                            <div id="visorFavicon" style="width: 150px; height: 50px; margin:20px;"> </div>
                                                        </div>
                                                        <div  class="col col-lg-12">
                                                            <button type="submit" class="btn btn-raised btn-primary" style="position:relative; float:right; right:20px;" ng-click="cargafavicon()">Actualizar favicon</button>   
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="idTienda" value="<?php echo (isset($infoTienda['idTienda']))?$infoTienda['idTienda']:''; ?>">
                                            </div>    
                                        </div>
                                    </form>    
                                </div>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!--actualizar formas de pago-->
        <div id="pagos" class="tab-pane fade">
            <div class="row">
                <div class="col col-lg-12 col-md-12">
                    <div class="row">
                        <center><H2><strong>Metodos de pago</strong></H2></center>
                        <br>
                        <form role="form" name="dataPagos" id="dataPagos" ng-submit="procesaDataPagos()">
                            <div class="col col-lg-3" style="border-right:1px solid #E1E1E1">
                                <center><H2>Pago en tienda</H2></center>
                                <div class="">
                                    <label style="color:#222222;" class="col col-lg-12"><i class="fa fa-money-bill-wave "></i>   Recojo y Pago en tienda
                                        <input type="checkbox" value="si" name="pagoEfectivo" id="pagoEfectivo" <?php if($infoTienda['pagoEfectivo'] == "si"){ echo "checked";} else {echo"checbox";} ?> style="float:right;width: 20px;height: 20px;">
                                    </label>   
                                </div>
                                <div class="">
                                    <label style="color:#222222;" class="col col-lg-12"> <i class="fa fa-calculator"></i>   Pago contra entrega datafono
                                        <input type="checkbox" value="si" name="pagoDatafono" id="pagoDatafono" <?php if($infoTienda['pagoDatafono'] == "si"){ echo "checked";} else {echo"checbox";} ?> style="float:right;width: 20px;height: 20px;">
                                    </label>  
                                </div>
                                <div class="">
                                    <label style="color:#222222;" class="col col-lg-12"> <i class="fa fa-car"></i>   Pago contra entrega Efectivo
                                        <input type="checkbox" value="si" name="pagoRecoger" id="pagoRecoger" <?php if($infoTienda['pagoRecoger'] == "si"){ echo "checked";} else {echo"checbox";} ?> style="float:right;width: 20px;height: 20px;">
                                    </label>
                                </div>
                            </div>
                            <div class="col col-lg-3" style="border-right:1px solid #E1E1E1">
                                <div>
                                    <label style="color:#222222;" class="col col-lg-12"><br>
                                        <i class="fa fa-wallet"></i><img src="../../res/fotos/wannabe/PAYU_LOGO_LIME.png" style="width: 90px; height: 40px;" alt="">
                                        <input type="checkbox" value="si" name="pagoPayu" id="pagoPayu" ng-click="payu()"<?php if($infoTienda['pagoPayu'] == "si"){ echo "checked";}?> style="float:right;width: 20px;height: 20px;"><br>
                                        <input type="text" class="input-group-addon" placeholder="Payu key" value="<?php echo (isset($infoTienda['payu_apikey']))?$infoTienda['payu_apikey']:''; ?>" id="payu_apikey" name="payu_apikey" style="width: 250px; <?php if($infoTienda['pagoPayu'] != "si"){ echo "display:none;";}?>" ><br>
                                        <input type="text" class="input-group-addon" placeholder="Payu id cuenta" value="<?php echo (isset($infoTienda['payu_id_cuenta']))?$infoTienda['payu_id_cuenta']:''; ?>" id="payu_id_cuenta" name="payu_id_cuenta" style="width: 250px; <?php if($infoTienda['pagoPayu'] != "si"){ echo "display:none;";}?>"><br>
                                        <input type="text" class="input-group-addon" placeholder="Payu id mercado" value="<?php echo (isset($infoTienda['payu_id_mercado']))?$infoTienda['payu_id_mercado']:''; ?>" id="payu_id_mercado" name="payu_id_mercado" style="width: 250px; <?php if($infoTienda['pagoPayu'] != "si"){ echo "display:none;";}?>;">
                                    </label>
                                </div>
                                <label style="padding:5px;color:#222222;">
                                    <a href="http://developers.payulatam.com/latam/es/payu-module-documentation/getting-started/understanding-the-payu-module/technical-configuration.html" target="_blank" style="<?php if($infoTienda['pagoPayu'] != "si"){ echo "display:none;";}?>" id="pPayu"><p>Para obtener tu Payu key</p></a>
                                </label>
                            </div>
                            <div class="col col-lg-3" style="border-right:1px solid #E1E1E1">
                                <div class=""><br>
                                    <label style="color:#222222;" class="col col-lg-12">
                                        <i class="fa fa-wallet"></i>
                                        <img src="../../res/fotos/wannabe/main-logo.bd9f2bf.png" style="width: 90px; " alt="">
                                        <input type="checkbox" value="si" name="pagoWompi" id="pagoWompi" ng-click="wompi()" <?php if($infoTienda['pagoWompi'] == "si"){ echo "checked";} else {echo"checbox";} ?> style="float:right;width: 20px; height: 20px;"><br><br>
                                        <input type="text" class="input-group-addon" placeholder="Wompi key" value="<?php echo (isset($infoTienda['wompi_public_key']))?$infoTienda['wompi_public_key']:''; ?>" id="wompi_public_key" name="wompi_public_key" style="width: 250px; <?php if($infoTienda['pagoWompi'] != "si"){ echo "display:none;";}?>;">
                                    </label>
                                </div>
                                <label style="padding:5px;color:#222222;">
                                     <a href="https://comercios.wompi.co/?_ga=2.211865168.576418428.1655397575-1339421596.1654726780&_gac=1.124448120.1655400604.CjwKCAjwqauVBhBGEiwAXOepke_M-QHyh-TCAoa9uVUfXho31tYrbv_KBg2xgC52cH0v94Ms0uMnFBoCWfoQAvD_BwE" target="_blank" id="pWompi" style="<?php if($infoTienda['pagoWompi'] != "si"){ echo "display:none;";}?>"><p>Para obtener tu Wompi key</p></a>
                                </label>
                            </div>
                            <div class="col col-lg-3" style="border-right:1px solid #E1E1E1">
                                <div class=""><br>
                                    <label style="color:#222222;" class="col col-lg-12">
                                        <i class="fa fa-wallet"></i>
                                        <img src="../../res/fotos/wannabe/Stripe-Logo-2009.png" style="width: 90px; height: 40px;" alt=""><input type="checkbox" value="si" name="pagoStripe" id="pagoStripe" ng-click="stripe()"
                                        <?php if($infoTienda['pagoStripe'] == "si"){ echo "checked";} else {echo"checbox";} ?> style="float:right;width: 20px;height: 20px;">
                                        <input type="text" class="input-group-addon" placeholder="Stripe key" value="<?php echo (isset($infoTienda['stripe_key']))?$infoTienda['stripe_key']:''; ?>" id="stripe_key" name="stripe_key" style="width: 250px; <?php if($infoTienda['pagoStripe'] != "si"){ echo "display:none;";}?>;" >
                                    </label>
                                </div>
                                <label style="padding:5px;color:#222222;">
                                    <a href="https://stripe.com/docs/keys#obtain-api-keys" target="_blank" style="<?php if($infoTienda['pagoStripe'] != "si"){ echo "display:none;";}?>" id="pStripe"><p>Para obtener tu Stripe key</p></a>
                                </label>
                            </div>
                            <div class="col col-lg-12" style="padding-left: 0px; padding-right: 0; margin-top: 0px; margin-bottom: 0px;">
                                <div class="form-group col col-lg-4">
                                    <label class="control-label" for=""> Nombre de la transacci&oacute;n</label>
                                    <input autocomplete="off" id="nombreTransaccion" name="nombreTransaccion"  class="form-control" value="<?php echo (isset($infoTienda['nombreTransaccion']))?$infoTienda['nombreTransaccion']:''; ?>" type="text">
                                    <label style="padding:5px;color:#222222;">
                                    <p>De esta forma el cliente verá identificada la transacción en su medio de pago</p>
                                </label> 
                                </div>  
                            </div>
                            <div  class="col col-lg-12">
                                <button type="submit" class="btn btn-raised btn-primary" style="position:relative; float:right; right:20px;" ng-click="getActualizaPago()">Actualizar Pagos</button>
                            </div>
                            <input type="hidden" id="idTienda" name="idTienda" value="<?php echo (isset($infoTienda['idTienda']))?$infoTienda['idTienda']:''; ?>">               
                        </form>    
                    </div>
                </div>
            </div>    
        </div>
        <!-- mantenimiento -->
        <div id="mantenimiento" class="tab-pane fade">
            <div class="row">
                <div class="col col-lg-12 col-md-12">
                    <div class="row">
                        <center><H2><strong>Estado de la app movil</strong></H2></center>
                        <br>
                        <form role="form" name="DataEstado" id="DataEstado" ng-submit="procesaDataEstado()">
                            <div class="col col-lg-12" style="border-right:1px solid #E1E1E1">
                                <p style="font-size:16px;">La aplicación entrará en un estado de off line, para que se puedan realizar los cambios pertinentes por el administrador.</p>
                            </div><br>
                            <div class="col col-lg-4" style="border-right:1px solid #E1E1E1">
                                <div class="">
                                    <label style="color:#222222;" class="col col-lg-12"><i class="fa fa-cogs" style="margin:30px;"></i>  Manteminiento
                                        <input type="checkbox" value="si" name="manteminiento" id="manteminiento" <?php if($infoTienda['manteminiento'] == 1){ echo "checked";} else {echo"checbox";} ?> style="float:right;width: 20px;height: 20px; margin:30px;">
                                    </label>   
                                </div>
                            </div>
                            <div class="col col-lg-8" style="border-right:1px solid #E1E1E1">
                                <textarea class="form-control col col-lg-8" placeholder="Motivo por el cual se va a realizar el mantenimiento"  name="mensajeMantenimiento" id="mensajeMantenimiento" style="width: 100%; <?php //if($infoTienda['manteminiento'] == 0){ echo "display:none;";}?>"><?php echo (isset($infoTienda['mensajeMantenimiento']))?$infoTienda['mensajeMantenimiento']:''; ?></textarea>
                            </div><br><br>
                            <div class="col col-lg-12" style="border-right:1px solid #E1E1E1">
                                <p style="font-size:16px;">Recuerde que la aplicación móvil al estar en estado mantenimiento, ninguno de los usuarios no podrán realizar compra o pedido.</p>
                            </div><br>
                            <div  class="col col-lg-12">
                                <button type="submit" class="btn btn-raised btn-primary" style="position:relative; float:right; right:20px;" ng-click="getmantenimiento()">Actualizar Estado</button>
                            </div>
                            <input type="hidden" id="idTienda" name="idTienda" value="<?php echo (isset($infoTienda['idTienda']))?$infoTienda['idTienda']:''; ?>">               
                        </form>    
                    </div>
                </div>
            </div>    
        </div>
    </div>
    <style>
        .nav-pills > li a:hover{
            background:#337AB7;
            color:#ffffff;
        }
    </style>