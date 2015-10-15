<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$fechaVentas = $_POST["fechaVentasPHP"];
// $fechaVentas = "2015-03-30";

$sql = "SELECT ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM mediosdepago, productos, ventas
WHERE mediosdepago.codMedioPago = ventas.codMedioPago
AND productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND (ventas.codMedioPago = '2' OR ventas.codMedioPago = '3' OR ventas.codMedioPago = '4' OR ventas.codMedioPago = '4' OR ventas.codMedioPago = '5' OR ventas.codMedioPago = '6' OR ventas.codMedioPago = '7')
AND DATE(ventas.fechaVenta) = '$fechaVentas';";

$resultado = mysql_query($sql);

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR EL TOTAL DE VENTAS POR DOCUMENTO: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>