<?php
session_start();

include('conec.php');

$numTicket = $_SESSION['numTicket'];
$rutVendedorLogueado = $_SESSION['rutVendedorLogueado'];

$sql = "SELECT
ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM productos, ventas
WHERE productos.codProducto = ventas.codProducto
AND ventas.rutVendedor = '$rutVendedorLogueado'
AND ventas.numTicket = '$numTicket'
AND ventas.estadoConfirmado = '0';";

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR EL TOTAL DEL PEDIDO: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>