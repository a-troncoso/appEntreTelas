<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$fechaVentas = $_POST["fechaVentasPHP"];
// $fechaVentas = "2015-03-30";

$sql = "SELECT ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM documentosdepago, productos, ventas
WHERE documentosdepago.codDocPago = ventas.codDocPago
AND productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND (ventas.codDocPago = '2' OR ventas.codDocPago = '3' OR ventas.codDocPago = '4' OR ventas.codDocPago = '5' OR ventas.codDocPago = '6')
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