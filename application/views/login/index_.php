<!--                                                    
     ("`-''-/").___....''"`-._
      `6_ 6  )   `-.  (     ).`-.__.`) 
      (_Y_.)'  ._   )  `._ `. ``-..-'
    _..`..'_..-_/  /..'_.' ,'
   (il),-''  (li),'  ((!.-'

   Desarrollado por  @orugal
-->
<!DOCTYPE html>
<html ng-app="projectRegistro">
	<head>
		<title><?php echo $titulo ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
		<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
	    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>res/css/bootstrap.min.css"  media=""/>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>res/css/angular-cps.css"  media=""/>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>res/css/bootstrap-toggle.min.css" rel="stylesheet" media="" />
		<link rel="stylesheet" href="<?php echo base_url()?>res/font-awesome/css/font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>res/css/sweetalert.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>res/css/login/css.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>res/css/bootstrap-material-design.min.css" />
		<link rel="stylesheet" href="<?php echo base_url()?>res/css/ripples.min.css" />
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url()?>res/img/favicon.png" />
	</head>
	<body ng-controller="login" ng-init="loginInit()">
		<?php $this->load->view($centro);?>
		<script type="text/javascript" src="<?php echo base_url()?>res/js/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>res/js/jquery-ui-1.10.3.custom.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>res/js/sweetalert.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>res/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>res/js/angular.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>res/js/app.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>res/js/factory.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>res/js/login/controller.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>res/js/material.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>res/js/ripples.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>res/js/validator.js"></script>
		<script type="text/javascript" src="https://www.wannabe.com.co/js/kon.min.js"></script>
		<script type="text/javascript">
	        var configLogin =  {
	            apiUrl: '<?php echo base_url()?>'
	        }
	         $.material.init();
	    </script>
	</body>
	
</html>