<?php

include('conec.php');

$rutNuevoVendedor = $_POST['rutNuevoVendedorPHP'];
$nombreNuevoVendedor = $_POST['nombreNuevoVendedorPHP'];
$apellidoPatNuevoVendedor = $_POST['apellidoPatNuevoVendedorPHP'];
$apellidoMatNuevoVendedor = $_POST['apellidoMatNuevoVendedorPHP'];
$emailNuevoVendedor = $_POST['emailNuevoVendedorPHP'];

$sql1 = "INSERT INTO `vendedores`(
	`rutVendedor`,
	`nombreVendedor`,
	`apellidoPatVendedor`,
	`apellidoMatVendedor`,
	`emailVendedor`)
VALUES (
	'$rutNuevoVendedor',
	'$nombreNuevoVendedor',
	'$apellidoPatNuevoVendedor',
	'$apellidoMatNuevoVendedor',
	'$emailNuevoVendedor');";

$resultado1 = mysql_query($sql1);

if(!$resultado1){
	echo "\n SE HA DETECTADO EL SIGUIENTE ERROR AL INGRESAR EL VENDEDOR EN LA BASE DE DATOS: \n" . mysql_error();
}else{
	echo "\n SE HA AGREGADO EL VENDEDOR $nombreNuevoVendedor";
}

//Cierro conexion
mysql_close($conexion);

?>