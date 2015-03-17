<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$fechaVentas = $_POST["fechaVentasPHP"];

$sql = "SELECT documentosdepago.nombreDocPago,
MIN(ventas.numDocPago),
MAX(ventas.numDocPago),
ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM documentosdepago, productos, ventas
WHERE documentosdepago.codDocPago = ventas.codDocPago
AND productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE(ventas.fechaVenta) = '$fechaVentas'
GROUP BY (documentosdepago.nombreDocPago);";

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR EL LOS TOTALES POR DOCUMENTO: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>