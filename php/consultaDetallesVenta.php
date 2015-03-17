<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$numTicket = $_POST["numTicketPHP"];
// $numTicket = 1;

$sql = "SELECT productos.nombreProducto,
ventas.cantidadVendida,
productos.valorVentaNetoProducto,
ventas.porcentajeDescuento,
ROUND((ventas.cantidadVendida * (productos.valorVentaNetoProducto - (productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01)))),
ROUND(((ventas.cantidadVendida * (productos.valorVentaNetoProducto - (productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01)))*0.19)),
ROUND((((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM productos, ventas
WHERE productos.codProducto = ventas.codProducto
AND ventas.estadoConfirmado = '1'
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