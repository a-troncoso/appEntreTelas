<?php
session_start();

include('conec.php');

$numTicket = $_SESSION['numTicket'];
$rutVendedorLogueado = $_SESSION['rutVendedorLogueado'];
$filtra = $_POST['filtraPHP'];
$idVentaSeleccionada = $_POST['idVentaSeleccionadaPHP'];

if ($filtra == "0") {
	$sql = "SELECT ventas.idVenta,
	productos.codProducto,
	productos.nombreProducto,
	productos.valorVentaNetoProducto,
	ROUND(productos.valorVentaNetoProducto * 0.19),
	ROUND(productos.valorVentaNetoProducto + (productos.valorVentaNetoProducto * 0.19)),
	ventas.cantidadVendida,
	ventas.porcentajeDescuento,
	ROUND((((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
	FROM productos, ventas
	WHERE productos.codProducto = ventas.codProducto
	AND ventas.numTicket = '$numTicket'
	AND ventas.rutVendedor = '$rutVendedorLogueado'
	AND ventas.estadoConfirmado = '0'
	ORDER BY productos.nombreProducto;";
}
if ($filtra == "1"){
	$sql = "SELECT ventas.idVenta,
	productos.codProducto,
	productos.nombreProducto,
	ventas.cantidadVendida,
	productos.valorVentaNetoProducto,
	ROUND(productos.valorVentaNetoProducto * 0.19),
	ROUND(productos.valorVentaNetoProducto + (productos.valorVentaNetoProducto * 0.19)),
	ventas.cantidadVendida,
	ventas.porcentajeDescuento,
	ROUND((((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
	FROM productos, ventas
	WHERE productos.codProducto = ventas.codProducto
	AND ventas.numTicket = '$numTicket'
	AND ventas.rutVendedor = '$rutVendedorLogueado'
	AND ventas.estadoConfirmado = '0'
	AND ventas.idVenta = $idVentaSeleccionada
	ORDER BY productos.nombreProducto;";
}

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR LOS DATOS DEL PRODUCTO/S: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>