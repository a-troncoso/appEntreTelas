<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$codDoc = $_POST["codDocPHP"];
$fechaVentas = $_POST["fechaVentasPHP"];

$sql = "SELECT ventas.numDocPago,
ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM ventas, productos, documentosdepago
WHERE documentosdepago.codDocPago = ventas.codDocPago
AND productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND ventas.codDocPago = '$codDoc'
AND DATE(ventas.fechaVenta) = '$fechaVentas'
GROUP BY ventas.numDocPago
ORDER BY ventas.numDocPago;";

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR LOS DOCUMENTOS DE COMPRA: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>