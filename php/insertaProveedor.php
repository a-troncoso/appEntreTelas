<?php

include('conec.php');

$rutNuevoProveedor = $_POST['rutNuevoProveedorPHP'];
$nombreNuevoProveedor = $_POST['nombreNuevoProveedorPHP'];
$giroNuevoProveedor = $_POST['giroNuevoProveedorPHP'];
$direccionNuevoProveedor = $_POST['direccionNuevoProveedorPHP'];
$regionNuevoProveedor = $_POST['regionNuevoProveedorPHP'];
$comunaNuevoProveedor = $_POST['comunaNuevoProveedorPHP'];
$telefonoNuevoProveedor = $_POST['telefonoNuevoProveedorPHP'];
$emailNuevoProveedor = $_POST['emailNuevoProveedorPHP'];

$sql1 = "INSERT INTO proveedores (`rutProveedor`,
	`nombreProveedor`,
	`giroProveedor`,
	`direccionProveedor`,
	`idRegion`,
	`idComuna`,
	`telefonoProveedor`,
	`mailProveedor`)
VALUES ('$rutNuevoProveedor',
	'$nombreNuevoProveedor',
	'$giroNuevoProveedor',
	'$direccionNuevoProveedor',
	'$regionNuevoProveedor',
	'$comunaNuevoProveedor',
	'$telefonoNuevoProveedor',
	'$emailNuevoProveedor');";

$resultado1 = mysql_query($sql1);

if(!$resultado1){
	echo "\n SE HA DETECTADO EL SIGUIENTE ERROR AL INGRESAR EL PROVEEDOR EN LA BASE DE DATOS: \n" . mysql_error();
}else{
	echo "\n SE HA AGREGADO EL PROVEEDOR $nombreNuevoProveedor";
}

//Cierro conexion
mysql_close($conexion);

?>