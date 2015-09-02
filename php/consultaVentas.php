<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$fechaVentas = $_POST["fechaVentasPHP"];

// El total se calcula: el valor neto de venta de un produto MENNOS su descuento MÁS el IVA POR la cantidad vendida
$sql = "SELECT ventas.numTicket,
ventas.numDocPago,
vendedores.nombreVendedor,
ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida)), 
ventas.estadoPagado
FROM ventas, vendedores, productos
WHERE vendedores.rutVendedor = ventas.rutVendedor
AND productos.codProducto = ventas.codProducto
AND ventas.estadoConfirmado = 1
AND DATE(ventas.fechaVenta) = '$fechaVentas'
GROUP BY ventas.numTicket, vendedores.nombreVendedor, DATE(ventas.fechaVenta)
ORDER BY ventas.estadoPagado, ventas.numTicket;";

// La funcion DATE obtiene sólo la fecha de un campo DATETIME
// Solo se traen los pedidos confirmados

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR LAS VENTAS: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>