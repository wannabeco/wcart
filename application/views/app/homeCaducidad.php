<div class="container-fluid" ng-controller="membresia"  ng-init="initCaduca()" data-infoTienda ='<?php echo $infoTienda;?>'>
    <div class="row">
      <?php $referencia				= substr(md5(time()), 0, 16);?>
        <div class="col-lg-12">
          <?php  if($infoTienda['datos'][0]['mesGratis'] == 0){ ?>
              <h2>Para poder seguir utlizando los beneficios de nuestra aplicación debes activar un plan</h2>
              <p></p><br><br>
           <?php } if($infoTienda['datos'][0]['mesGratis'] == 1){ ?> 
              <h2>Tu licencia ha caducado</h2>
              <p>Para poder seguir utlizando los beneficios de nuestra aplicación debes activar nuevamente un plan</p><br><br>
            <?php }?>
            <!-- APP MOVIL  -->
            <div class="row text-center">
                <div class="col col-lg-4 col-md-4">
                    <div class="card box-shadow">
                      <div class="card-header">
                        <h2 class="my-0 font-weight-normal">Basic</h2>
                        <div class="col-md-8" style="margin-left:18%;">
                          <select class="form-control p-4" ng-model="membresiaApp">
                            <option value="mes">Mes</option>
                            <option value="ano">Año</option>
                          </select>
                        </div>
                      </div>
                      <div class="card-body" ng-if="membresiaApp=='mes'">
                        <h1 class="card-title pricing-card-title"><?php echo"$".number_format(_PRECIO_PLAN_BASIC);?><small class="text-muted">/ Mensual</small></h1>
                        <ul class="list-unstyled mt-3 lg-4">
                          <li><span style="position:relative; float:left; left:50px;">App movil, Android y apple</span><i class='fa fa-check iconCheck' style="position:relative; float:right; right: 50px; color:green;"></i>	</li><br>
                          <li><span style="position:relative; float:left; left:50px;"> Unlimited products </span><i class='fa fa-check iconCheck' style="position:relative; float:right; right: 50px; color:green;"></i>	</li><br>
                          <li><span style="position:relative; float:left; left:50px;"> Responsive web site </span><i class='fa fa-close iconClose' style="position:relative; float:right; right: 50px; color:red;"></i></li><br>
                          <li><span style="position:relative; float:left; left:50px;"> Ssl </span><i class='fa fa-close iconClose' style="position:relative; float:right; right: 50px; color:red;"></i></li><br>
                          <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">SEE MORE</button>
                        </ul>
                        <?php if($infoTienda['datos'][0]['Plan'] == 'movil'){ ?>
                          <form action="" name="dataPago" id="dataPago" ng-submit="dataPago()">
                              <input type="hidden" id="codigoPago" name="codigoPago" value="<?php echo $referencia;?>" />  
                              <button type="button" class="btn btn-lg btn-block btn-primary" ng-click="AppMes()">
                                  <i class="fa fa-shopping-cart" aria-hidden="true" style="margin-right:5px;"></i> Pagar Ahora
                              </button>
                          </form>
                          <?php  } else if($infoTienda['datos'][0]['Plan'] == 'movil y web'){?>
                            <form action="" name="dataPago" id="dataPago" ng-submit="dataPago()">
                              <input type="hidden" id="codigoPago" name="codigoPago" value="<?php  echo $referencia; ?>" >  
                              <button type="button" class="btn btn-lg btn-block btn-primary" ng-click="cambio()">
                                  <i class="fa fa-shopping-cart" aria-hidden="true" style="margin-right:5px;"></i> Pagar Ahora
                              </button>
                          </form>
                          <?php } ?>
                      </div>
                      <div class="card-body" ng-if="membresiaApp=='ano'">
                        <h1 class="card-title pricing-card-title"><?php $precio=_PRECIO_PLAN_BASIC; $mes=_MESES_DE_COBRO_ANO_PLAN_BASIC; $calcula=$precio*$mes;echo"$".number_format($calcula);?> <small class="text-muted">/ Anual</small></h1>
                        <ul class="list-unstyled mt-3 lg-4">
                          <li><span style="position:relative; float:left; left:50px;"> App movil, Android y apple </span><i class='fa fa-check iconCheck' style="position:relative; float:right; right: 50px; color:green;"></i>	</li><br>
                          <li><span style="position:relative; float:left; left:50px;"> Unlimited products </span><i class='fa fa-check iconCheck' style="position:relative; float:right; right: 50px; color:green;"></i>	</li><br>
                          <li><span style="position:relative; float:left; left:50px;"> Responsive web site </span><i class='fa fa-close iconClose' style="position:relative; float:right; right: 50px; color:red;"></i></li><br>
                          <li><span style="position:relative; float:left; left:50px;"> Ssl </span><i class='fa fa-close iconClose' style="position:relative; float:right; right: 50px; color:red;"></i></li><br>
                          <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">SEE MORE</button>
                          <li>
                            <div class="alert alert-primary" role="alert" style="height:45px;">
                               <h3 style="margin-top: -5px; margin-bottom: 15px;">
                               Save  <a class="alert-link" style="cursor:pointer;"><?php $totalesApp=_PRECIO_PLAN_BASIC; $mostrar=($totalesApp*12)-$calcula; echo "$".number_format($mostrar);?></a>
                               </h3> 
                            </div> 
                          </li>
                        </ul>
                          <?php if($infoTienda['datos'][0]['Plan'] == 'movil'){ ?>
                            <form action="" name="dataPago" id="dataPago" ng-submit="dataPago()">
                                <input type="hidden" id="codigoPago" name="codigoPago" value="<?php $referencia; ?>" >  
                                <button type="button" class="btn btn-lg btn-block btn-primary" ng-click="AppAno()">
                                    <i class="fa fa-shopping-cart" aria-hidden="true" style="margin-right:5px;"></i> Pagar Ahora
                                </button>
                            </form>
                          <?php  } else if($infoTienda['datos'][0]['Plan'] == 'movil y web'){ ?>
                            <form action="" name="dataPago" id="dataPago" ng-submit="dataPago()">
                                <input type="hidden" id="codigoPago" name="codigoPago" value="<?php $referencia; ?>" >  
                                <button type="button" class="btn btn-lg btn-block btn-primary" ng-click="cambio2()">
                                    <i class="fa fa-shopping-cart" aria-hidden="true" style="margin-right:5px;"></i> Pagar Ahora
                                </button>
                            </form>
                          <?php } ?>
                      </div>
                    </div>
                </div>
                <!-- APP MOVIL MAS APGINA WEB  -->
                <div class="col col-lg-4 col-md-4">
                    <div class="card box-shadow">
                      <div class="card-header">
                        <h2 class="my-0 font-weight-normal">Pro</h2>
                        <div class="col-md-8" style="margin-left:18%;">
                          <select class="form-control p-4" ng-model="membresiaWeb">
                            <option value="mes">Mes</option>
                            <option value="ano">Año</option>
                          </select>
                        </div>
                      </div>
                      <div class="card-body" ng-if="membresiaWeb=='mes'">
                        <h1 class="card-title pricing-card-title"><?php echo"$".number_format(_PRECIO_PLAN_PRO);?><small class="text-muted">/ Mensual</small></h1>
                        <ul class="list-unstyled mt-3 lg-4">
                          <li><span style="position:relative; float:left; left:50px;"> App movil, Android y apple </span><i class='fa fa-check iconCheck' style="position:relative; float:right; right: 50px; color:green;"></i>	</li><br>
                          <li><span style="position:relative; float:left; left:50px;"> Unlimited products </span><i class='fa fa-check iconCheck' style="position:relative; float:right; right: 50px; color:green;"></i>	</li><br>
                          <li><span style="position:relative; float:left; left:50px;"> Responsive web site </span><i class='fa fa-check iconCheck' style="position:relative; float:right; right: 50px; color:green;"></i></li><br>
                          <li><span style="position:relative; float:left; left:50px;"> Ssl </span><i class='fa fa-check iconCheck' style="position:relative; float:right; right: 50px; color:green;"></i></li><br>
                          <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">SEE MORE</button>
                        </ul>
                        <?php if($infoTienda['datos'][0]['Plan'] == 'movil y web'){ ?>
                          <form action="" name="dataPago" id="dataPago" ng-submit="dataPago()">
                                <input type="hidden" id="codigoPago" name="codigoPago" value="<?php $referencia; ?>" >  
                                <button type="button" class="btn btn-lg btn-block btn-primary" ng-click="WebMes()">
                                    <i class="fa fa-shopping-cart" aria-hidden="true" style="margin-right:5px;"></i> Pagar Ahora
                                </button>
                            </form>
                          <?php } else if($infoTienda['datos'][0]['Plan'] == 'movil') {?>
                            <form action="" name="dataPago" id="dataPago" ng-submit="dataPago()">
                                <input type="hidden" id="codigoPago" name="codigoPago" value="<?php $referencia; ?>" >  
                                <button type="button" class="btn btn-lg btn-block btn-primary" ng-click="bajar()">
                                    <i class="fa fa-shopping-cart" aria-hidden="true" style="margin-right:5px;"></i> Pagar Ahora
                                </button>
                            </form>
                          <?php } ?>
                      </div>
                      <div class="card-body" ng-if="membresiaWeb=='ano'">
                        <h1 class="card-title pricing-card-title"><?php $pro=_PRECIO_PLAN_PRO; $meses=_MESES_DE_COBRO_ANO_PLAN_PRO; $total=$pro*$meses; echo"$".number_format($total);?><small class="text-muted">/ Anual</small></h1>
                        <ul class="list-unstyled mt-3 lg-4">
                          <li><span style="position:relative; float:left; left:50px;"> App movil, Android y apple </span><i class='fa fa-check iconCheck' style="position:relative; float:right; right: 50px; color:green;"></i>	</li><br>
                          <li><span style="position:relative; float:left; left:50px;"> Unlimited products </span><i class='fa fa-check iconCheck' style="position:relative; float:right; right: 50px; color:green;"></i>	</li><br>
                          <li><span style="position:relative; float:left; left:50px;"> Responsive web site </span><i class='fa fa-check iconCheck' style="position:relative; float:right; right: 50px; color:green;"></i></li><br>
                          <li><span style="position:relative; float:left; left:50px;"> Ssl </span><i class='fa fa-check iconCheck' style="position:relative; float:right; right: 50px; color:green;"></i></li><br>
                          <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">SEE MORE</button>
                          <li>
                            <div class="alert alert-primary" role="alert" style="height:45px;">
                               <h3 style="margin-top: -5px; margin-bottom: 15px;">
                               Save  <a class="alert-link" style="cursor:pointer;"><?php $totalesWeb=_PRECIO_PLAN_PRO; $mostrara=($totalesWeb*12)-$total; echo "$".number_format($mostrara);?></a>
                               </h3> 
                            </div> 
                          </li>
                        </ul>
                        <?php if($infoTienda['datos'][0]['Plan'] == 'movil y web'){ ?>
                            <form action="" name="dataPago" id="dataPago" ng-submit="dataPago()">
                                <input type="hidden" id="codigoPago" name="codigoPago" value="<?php $referencia; ?>" >  
                                <button type="button" class="btn btn-lg btn-block btn-primary" ng-click="WebAno()">
                                    <i class="fa fa-shopping-cart" aria-hidden="true" style="margin-right:5px;"></i> Pagar Ahora
                                </button>
                            </form>
                          <?php } else if($infoTienda['datos'][0]['Plan'] == 'movil') {?>
                            <form action="" name="dataPago" id="dataPago" ng-submit="dataPago()">
                                <input type="hidden" id="codigoPago" name="codigoPago" value="<?php $referencia; ?>" >  
                                <button type="button" class="btn btn-lg btn-block btn-primary" ng-click="bajar2()">
                                    <i class="fa fa-shopping-cart" aria-hidden="true" style="margin-right:5px;"></i> Pagar Ahora
                                </button>
                            </form>
                          <?php } ?>
                      </div>
                    </div>
                </div>
                            
                <div class="col col-lg-2 col-md-2"></div>
            </div>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
            <h2 class="modal-title" id="myModalLabel" style="font-family: 'Roboto'; text-transform: uppercase;  color: #333;">KNOW OUR PRICES</h2>
          </div>
          <div class="modal-body">
          <div class="panelPopUp" id="popPricing">
                <div class="panelInternoPop" >
                    <div class="row p-2">
                      <div class="col col-lg-8 col-sm-8 col-xs-8 tituloPopPlan" style="background:#316994; padding:8px; font-size:24px; font-family:inherit; height: 43px; padding-left: 0px; padding-right: 0px;">
                        <h3 style="margin-top:0px; margin-left:20px; color:white;">Feature</h3>
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center tituloPopPlan" style="background:#316994; padding:8px; font-size:24px; font-family:inherit; height: 43px; padding-left: 0px; padding-right: 0px;">
                        <h3 style="margin-top:0px; margin-left:10px; color:white;">Basic</h3>
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center tituloPopPlan" style="background:#316994; padding:8px; font-size:24px; font-family:inherit; height: 43px; padding-left: 0px; padding-right: 0px;">
                        <h3 style="margin-top:0px; margin-left:10px; color:white;">Pro</h3>
                      </div>
                    </div>
                  <!--caracteristicas-->

                  <div class="row filaCar p-2" style="margin-top: 20px;">
                      <div class="col col-lg-8 col-sm-8 col-xs-8 p-2" style="bottom: 10px;">
                        <strong>APP ANDROID</strong>
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck' style="color:green;"></i>					
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck' style="color:green;"></i>					
                      </div>
                      <hr>
                    </div>
                    <div class="row filaCar">
                      <div class="col col-lg-8 col-sm-8 col-xs-8 p-2" style="bottom: 10px;">
                        <strong>APP APPLE</strong>
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck'></i>					
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck'></i>					
                      </div>
                      <hr>
                    </div>
                    <div class="row filaCar">
                      <div class="col col-lg-8 col-sm-8 col-xs-8" style="bottom: 10px;">
                        <strong>UNLIMITED CATEGORIES</strong>
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck'></i>					
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center">
                        <i class='fa fa-check iconCheck'></i>					
                      </div>
                      <hr>
                    </div>
                    <div class="row filaCar">
                      <div class="col col-lg-8 col-sm-8 col-xs-8" style="bottom: 10px;">
                        <strong>UNLIMITED SUBCATEGORIES</strong>
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck'></i>					
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck'></i>					
                      </div>
                      <hr>
                    </div>
                    <div class="row filaCar">
                      <div class="col col-lg-8 col-sm-8 col-xs-8" style="bottom: 10px;">
                        <strong>UNLIMITED PRODUCTS</strong>
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck'></i>					
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck'></i>					
                      </div>
                      <hr>
                    </div>
                    <div class="row filaCar">
                      <div class="col col-lg-8 col-sm-8 col-xs-8" style="bottom: 10px;">
                        <strong>USER REGISTRATION</strong>
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck'></i>					
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck'></i>					
                      </div>
                      <hr>
                    </div>
                    <div class="row filaCar">
                      <div class="col col-lg-8 col-sm-8 col-xs-8" style="bottom: 10px;">
                        <strong>SHOPPING CART</strong>
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck' ></i>					
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck' ></i>					
                      </div>
                      <hr>
                    </div>
                    <div class="row filaCar">
                      <div class="col col-lg-8 col-sm-8 col-xs-8" style="bottom: 10px;">
                        <strong style="float:left;">PAYMENT METHODS </strong><strong> <small style='color:#999; float:left; margin-left: 10px;' class='visible-lg'> (STRIPE, ON DELIVERY, PICK UP)</small></strong>
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck' ></i>					
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck' ></i>					
                      </div>
                      <hr>
                    </div>
                    <div class="row filaCar">
                      <div class="col col-lg-8 col-sm-8 col-xs-8" style="bottom: 10px;">
                        <strong>HOSTING</strong>
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck' ></i>					
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck' ></i>					
                      </div>
                      <hr>
                    </div>
                    <div class="row filaCar">
                      <div class="col col-lg-8 col-sm-8 col-xs-8" style="bottom: 10px;">
                        <strong>RESPONSIVE WEB SITE</strong>
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:red; bottom: 10px;">
                        <i class='fa fa-close iconClose'></i>					
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck'></i>					
                      </div>
                      <hr>
                    </div>
                    <div class="row filaCar">
                      <div class="col col-lg-8 col-sm-8 col-xs-8" style="bottom: 10px;">
                        <strong>CUSTOM DOMAIN</strong>
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:red; bottom: 10px;">
                        <i class='fa fa-close iconClose'></i>					
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck'></i>					
                      </div>
                      <hr>
                    </div>
                    <div class="row filaCar">
                      <div class="col col-lg-8 col-sm-8 col-xs-8" style="bottom: 10px;">
                        <strong>SSL</strong>
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:red; bottom: 10px;">
                        <i class='fa fa-close iconClose'></i>					
                      </div>
                      <div class="col col-lg-2 col-sm-2 col-xs-2 text-center" style="color:green; bottom: 10px;">
                        <i class='fa fa-check iconCheck'></i>					
                      </div>
                      <hr>
                    </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color:#ed540e; color:#fff; bottom: 20px;right: 20px;">CLOSE WINDOW</button>
          </div>
        </div>
    </div>
</div>