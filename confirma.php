<?php
session_start();
//require("application/config/constants.php");
$_SESSION['confirma'] = $_GET;
//var_dump($_SESSION['confirma']);die();
echo "<script>document.location = '".$_SESSION['base_url']."Pedidos/respuestaPago'</script>";
?>