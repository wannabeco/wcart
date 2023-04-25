<!--                                                    
     ("`-''-/").___....''"`-._
      `6_ 6  )   `-.  (     ).`-.__.`) 
      (_Y_.)'  ._   )  `._ `. ``-..-'
    _..`..'_..-_/  /..'_.' ,'
   (il),-''  (li),'  ((!.-'

   Desarrollado por  @orugal
-->
<!DOCTYPE html>
<html lang="en" ng-app="projectRegistro">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $titulo ?></title>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url() ?>res/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>res/css/bootstrap-suggest.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url() ?>res/css/sb-admin.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url() ?>res/css/plugins/morris.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>res/css/fileinput.min.css" rel="stylesheet" media="">
    <!-- Custom Fonts -->
    
    
    
        <link rel="stylesheet" href='<?php echo base_url()?>res/css/angular-cps.css' rel='stylesheet' />
        <link rel="stylesheet" href='<?php echo base_url()?>res/css/fullcalendar.css' rel='stylesheet' />
        <link rel="stylesheet" href='<?php echo base_url()?>res/css/fullcalendar.print.css' rel='stylesheet' media='print' />
        <link rel="stylesheet" href="<?php echo base_url()?>res/css/sweetalert.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>res/css/bootstrap-material-design.min.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>res/css/ripples.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>res/css/css_bootstrap-datetimepicker.css" media="">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()?>res/img/favicon.png" />
    <link href="<?php echo base_url()?>res/css/select2.min.css" rel="stylesheet" />
    <link href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php if(isset($output)){?>
            <?php foreach($output->css_files as $file): ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
            <?php endforeach; ?>
    <?php }?>
</head>
<body class="ng-cloak " ng-cloak>

    <div style='padding:2%;display:none;position:fixed;top:0;left:0;z-index:100000000;background:url(<?php echo base_url()?>res/img/trans.png);width:100%;height:100%' id='panelRecorte'>
        <div class="container text-center" style="background:#fff;padding:2% 8%;">
            <h2>Recorta la imagen al tamaño ideal</h2>
            <p>Usamos este recortador para garantizar la mejor organización de las fotos en tu tienda y/o app móvil</p><br>
            <img src="<?php echo base_url()?>res/img/cargaFoto.png" id="imagenRecortar" alt="" height="500px" style="border:2px solid #ccc"><br><br>
            <input type="hidden" id="imagenRecortada">
            <input type="hidden" id="idTiendarecorte">
            <button class="btn btn-danger btn-raised" id="recortarBtn">RECORTAR</button>
        </div>
    </div>

    <div id="wrapper">
        <!-- Menú General Empresas-->
            <?php echo traerCabeza() ?>
        <!-- Fin menú general Empresas-->
        <!-- Div Central-->
        <div id="page-wrapper">
            <?php $this->load->view($centro) ?>
        </div>
        <!--Fin Div Central-->
    </div>
    <!-- /#wrapper -->
    <script type="text/javascript" src="<?php echo base_url()?>res/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>res/js/jquery-ui-1.10.3.custom.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>res/js/sweetalert.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url() ?>res/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>res/js/bootstrap-suggest.js"></script>
    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url()?>res/js/select2.min.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url()?>res/js/angular.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>res/js/material.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>res/js/ripples.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>res/js/validator.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>res/js/app.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>res/js/factory.js?<?php echo rand(0,10000)?>"></script>
    <script type="text/javascript" src="<?php echo base_url()?>res/js/moment.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>res/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>res/js/raphael-min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>res/js/fileinput.js"></script>
    <script src='<?php echo base_url()?>res/js/moment.min.js'></script>
    <!--<script src='<?php echo base_url()?>res/js/jquery.min.js'></script>-->
    <script src='<?php echo base_url()?>res/js/fullcalendar.min.js'></script>
    <script src='<?php echo base_url()?>res/js/lang-all.js'></script>
    <script type="text/javascript" src="https://www.wannabe.com.co/js/kon.min.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    
    
    <?php 
        //esta línea me permite insertar archivos de controladores angular js.
        // ver el archivo application/helpers/funciones_helper.php
        echo insertaArchivosControlesAngularJS(); 
    ?>



    <script type="text/javascript">
        var configLogin =  {
            apiUrl: '<?php echo base_url()?>',
            urlAPi: '<?php echo base_url()?>Api/'
        }
        $.material.init();
        setTimeout(function(){
            $('[data-toggle="tooltip"]').tooltip();
        },1000);
        

    </script>

    <?php if(isset($output)){?>
     <?php foreach($output->js_files as $file): ?>
                <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
<?php } ?>

<script src="https://kit.fontawesome.com/44485b0623.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url()?>res/js/crop/rcrop.min.js" ></script>
    <link href="<?php echo base_url()?>res/js/crop/rcrop.min.css" media="screen" rel="stylesheet" type="text/css">
</body>
</html>