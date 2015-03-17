<?php
session_start();

include('conec.php');

$idVentaSeleccionada = $_POST['idVentaSeleccionadaPHP'];
$cantidadAEditar = $_POST['cantidadAEditarPHP'];
$descuentoAEditar = $_POST['descuentoAEditarPHP'];

$sql1 = "UPDATE ventas
SET cantidadVendida = '$cantidadAEditar',
porcentajeDescuento = '$descuentoAEditar'
WHERE ventas.idVenta = $idVentaSeleccionada;";

$resultado1 = mysql_query($sql1);

if(!$resultado1){
	echo "\n SE HA DETECTADO EL SIGUIENTE ERROR AL MODIFICAR EL PEDIDO EN LA BASE DE DATOS: \n" . mysql_error();
}else{
	echo "\n SE HA MODIFICADO EL PEDIDO";
}

//Cierro conexion
mysql_close($conexion);

?>