<?php
// session_start();
//require("application/config/constants.php");
$ruta = "http://localhost/wcart/";
extract($_GET);
var_dump($_GET);die();
echo "<script>document.location = '".$ruta."Pedidos/respuestaPago'</script>";
?>