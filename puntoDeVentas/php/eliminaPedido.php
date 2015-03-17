<?php
session_start();

include('conec.php');

$idVentaSeleccionada = $_POST['idVentaSeleccionadaPHP'];

$sql1 = "DELETE FROM `ventas`
WHERE ventas.idVenta = $idVentaSeleccionada";

$resultado1 = mysql_query($sql1);

if(!$resultado1){
	echo "\n SE HA DETECTADO EL SIGUIENTE ERROR AL ELIMINAR EL PEDIDO EN LA BASE DE DATOS: \n" . mysql_error();
}else{
	echo "\n SE HA ELIMINADO EL PEDIDO";
}

//Cierro conexion
mysql_close($conexion);

?>