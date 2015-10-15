<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$mes = $_POST["mesVentasPHP"];
// $mes = "03";

// TOTAL DEL MES
$sql1 = "SELECT ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM productos, ventas
WHERE productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mes';";

// TOTAL MES POR BOLETA
$sql2 = "SELECT ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM productos, ventas
WHERE productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND ventas.codDocPago = '2'
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mes';";

// CANTIDAD DE BOLETAS EMITIDAS EN EL MES
$sql3 = "SELECT MAX(ventas.numDocPago) - MIN(ventas.numDocPago) + 1
FROM ventas
WHERE ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND ventas.codDocPago = '2'
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mes';";

// TOTAL MES POR FACTURA
$sql4 = "SELECT ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM productos, ventas
WHERE productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND ventas.codDocPago = '3'
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mes';";

// CANTIDAD DE FACTURAS EMITIDAS EN EL MES
$sql5 = "SELECT MAX(ventas.numDocPago) - MIN(ventas.numDocPago) + 1
FROM ventas
WHERE ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND ventas.codDocPago = '3'
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mes';";

// TOTAL MES POR VOUCHER TRANSBANK
$sql6 = "SELECT ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM productos, ventas
WHERE productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND ventas.codDocPago = '4'
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mes';";

// CANTIDAD DE VOUCHER TRANSBANK EMITIDOS EN EL MES
$sql7 = "SELECT MAX(ventas.numDocPago) - MIN(ventas.numDocPago) + 1
FROM ventas
WHERE ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND ventas.codDocPago = '4'
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mes';";

// SI NO HAY ERROR EN NINGUNA CONSULTA SE AGREGAN LOS RESULTADOS AL ARREGLO
$resultado = mysql_query($sql1) and mysql_query($sql2) and mysql_query($sql3) and mysql_query($sql4) and mysql_query($sql5) and mysql_query($sql6) and mysql_query($sql7);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR EL LOS TOTALES DEL MES POR DOCUMENTO: \n" . mysql_error();
}else{
	$resultado1 = mysql_query($sql1);
	while ($rs = mysql_fetch_array($resultado1)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	$resultado2 = mysql_query($sql2);
	while ($rs = mysql_fetch_array($resultado2)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	$resultado3 = mysql_query($sql3);
	while ($rs = mysql_fetch_array($resultado3)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	$resultado4 = mysql_query($sql4);
	while ($rs = mysql_fetch_array($resultado4)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	$resultado5 = mysql_query($sql5);
	while ($rs = mysql_fetch_array($resultado5)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	$resultado6 = mysql_query($sql6);
	while ($rs = mysql_fetch_array($resultado6)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	$resultado7 = mysql_query($sql7);
	while ($rs = mysql_fetch_array($resultado7)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>