<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$numTicket = $_POST["numTicketPHP"];

$sql = "SELECT
ROUND(SUM((ventas.cantidadVendida * (productos.valorVentaNetoProducto - (productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))))),
ROUND(SUM(((ventas.cantidadVendida * (productos.valorVentaNetoProducto - (productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01)))*0.19))),
ROUND(SUM((((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))),
ventas.numDocPago
FROM productos, ventas
WHERE productos.codProducto = ventas.codProducto
AND ventas.numTicket = $numTicket;"; 

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR EL DETALLE DE LA VENTA: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>