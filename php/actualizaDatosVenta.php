<?php

include('conec.php');

$numTicket = $_POST["numTicketPHP"];
$numDocPago = $_POST["numDocPagoPHP"];
$codDocPago = $_POST["codDocPagoPHP"];
$codMedioPago = $_POST["codMedioPagoPHP"];

$estados = new stdClass();

$sql1 = "UPDATE ventas
	SET ventas.numDocPago = $numDocPago,
	ventas.codDocPago = $codDocPago,
	ventas.codMedioPago = $codMedioPago
	WHERE ventas.numTicket = $numTicket;";

$resultado1 = mysql_query($sql1);

$arrDatos = array();
if(!$resultado1){
	$estados->estado = 0;
	$estados->descripcion = "SE HA DETECTADO EL SIGUIENTE ERROR AL INGRESAR LA VENTA EN LA BASE DE DATOS: " . mysql_error();
}else{
	$estados->estado = 1;
	$estados->descripcion = "SE HA DEDITADO LA VENTA";
};

echo json_encode($estados);

//Cierro conexion
mysql_close($conexion);

?>