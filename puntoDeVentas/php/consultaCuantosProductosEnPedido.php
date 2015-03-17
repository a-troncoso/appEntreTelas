<?php
session_start();

include('conec.php');

$numTicket = $_SESSION['numTicket'];
$rutVendedorLogueado = $_SESSION['rutVendedorLogueado'];

$sql = "SELECT COUNT(productos.codProducto)
FROM productos, ventas
WHERE productos.codProducto = ventas.codProducto
AND ventas.numTicket = '$numTicket'
AND ventas.rutVendedor = '$rutVendedorLogueado'
AND ventas.estadoConfirmado = '0';";

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR LA CANTIDAD DE PRODUCTOS PEDIDOS: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>