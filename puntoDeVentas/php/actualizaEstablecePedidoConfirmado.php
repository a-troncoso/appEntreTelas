<?php
session_start();

include('conec.php');

$numTicket = $_SESSION['numTicket'];
$rutVendedorLogueado = $_SESSION['rutVendedorLogueado'];

$sql1 = "UPDATE `ventas`
SET `estadoConfirmado` = '1'
WHERE `ventas`.`numTicket` = '$numTicket'
AND ventas.rutVendedor = '$rutVendedorLogueado'
AND ventas.estadoConfirmado = '0';";

$resultado1 = mysql_query($sql1);

if(!$resultado1){
	echo "\n SE HA DETECTADO EL SIGUIENTE ERROR EN LA BASE DE DATOS AL ENVIAR EL PEDIDO : \n" . mysql_error();
}else{
	echo "\n SE HA ENVIADO EL PEDIDO";
}

//Cierro conexion
mysql_close($conexion);

?>