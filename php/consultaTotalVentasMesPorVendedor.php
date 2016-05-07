<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$mes = $_POST["mesVentasPHP"];
$ano = $_POST["anoVentasPHP"];
$rutVendedor = $_POST["rutVendedorPHP"];
// $mes = "03";

// TOTAL DEL MES
$sql1 = "SELECT ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM productos, ventas
WHERE productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mes'
AND DATE_FORMAT(ventas.fechaVenta, '%Y') = '$ano';";

// TOTAL MES POR VENDEDOR
$sql2 = "SELECT ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM productos, ventas
WHERE productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND ventas.rutVendedor = '$rutVendedor'
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mes'
AND DATE_FORMAT(ventas.fechaVenta, '%Y') = '$ano';";


// SI NO HAY ERROR EN NINGUNA CONSULTA SE AGREGAN LOS RESULTADOS AL ARREGLO
$resultado = mysql_query($sql1) and mysql_query($sql2);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR EL LOS TOTALES DEL MES POR VENDEDOR: \n" . mysql_error();
}else{
	$resultado1 = mysql_query($sql1);
	while ($rs = mysql_fetch_array($resultado1)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	$resultado2 = mysql_query($sql2);
	while ($rs = mysql_fetch_array($resultado2)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>