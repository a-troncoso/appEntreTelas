<?php
session_start();

include('conec.php');

$rutVendedor = $_SESSION['rutVendedorLogueado'];
$numTicket = $_SESSION['numTicket'];
$codProductoAAgregar = $_POST['codProductoAAgregarAlPedidoPHP'];
$cantidadAAgregarAlPedido = $_POST['cantidadAAgregarAlPedidoPHP'];
$descuentoAAplicarAlPedido = $_POST['descuentoAAplicarAlPedidoPHP'];

$sql1 = "INSERT INTO `ventas`(
	`idVenta`,
	`fechaVenta`,
	`idLocal`,
	`rutVendedor`,
	`numTicket`,
	`codDocPago`,
	`numDocPago`,
	`codMedioPago`,
	`codProducto`,
	`cantidadVendida`,
	`porcentajeDescuento`,
	`estadoPagado`,
	`estadoConfirmado`)
VALUES (
	NULL,
	CURRENT_TIMESTAMP,
	'1',
	'$rutVendedor',
	'$numTicket',
	'1',
	'0',
	'1',
	'$codProductoAAgregar',
	'$cantidadAAgregarAlPedido',
	'$descuentoAAplicarAlPedido',
	'0',
	'0');";

$resultado1 = mysql_query($sql1);

if(!$resultado1){
	echo "\n SE HA DETECTADO EL SIGUIENTE ERROR AL INGRESAR EL PEDIDO EN LA BASE DE DATOS: \n" . mysql_error();
}else{
	echo "\n SE HA AGREGADO EL PEDIDO";
}

//Cierro conexion
mysql_close($conexion);

?>