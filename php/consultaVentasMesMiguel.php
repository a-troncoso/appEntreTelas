<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$mes = $_POST["mesVentasPHP"];
$ano = $_POST["anoVentasPHP"];
// $mes = "03";

// TOTAL
$sql1 = "SELECT DATE_FORMAT(ventas.fechaVenta, '%d'),
ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM vendedores, productos, ventas
WHERE vendedores.rutVendedor = ventas.rutVendedor
AND productos.codProducto = ventas.codProducto
AND ventas.rutVendedor = '195553262'
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mes'
AND DATE_FORMAT(ventas.fechaVenta, '%Y') = '$ano'
GROUP BY DATE_FORMAT(ventas.fechaVenta, '%d')";

$resultado1 = mysql_query($sql1);
$arrDatos = array();

if(!$resultado1){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR EL LOS TOTALES DEL MES POR VENDEDOR: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado1)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>