<?php

include('conec.php');

$codigoProducto = $_POST['codigoProductoPHP'];
$nombreProducto = $_POST['nombreProductoPHP'];
$valorNetoVentaProducto = $_POST['valorNetoVentaProductoPHP'];
$stockCriticoProducto = $_POST['stockCriticoProductoPHP'];

$sql1 = "INSERT INTO `productos` (`codProducto`,
	`nombreProducto`,
	`valorVentaNetoProducto`,
	`stockCriticoProducto`)
VALUES ('$codigoProducto',
	'$nombreProducto',
	'$valorNetoVentaProducto',
	'$stockCriticoProducto');";

$resultado1 = mysql_query($sql1);

if(!$resultado1){
	echo "\n SE HA DETECTADO EL SIGUIENTE ERROR AL INGRESAR EL PRODUCTO EN LA BASE DE DATOS: \n" . mysql_error();
}else{
	echo "\n SE HA AGREGADO EL PRODUCTO $nombreProducto";
}

//Cierro conexion
mysql_close($conexion);

?>