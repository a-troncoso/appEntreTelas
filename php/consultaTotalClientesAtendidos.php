<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$fechaVentas = $_POST["fechaVentasPHP"];

$sql = "SELECT COUNT(DISTINCT ventas.numTicket)
FROM vendedores, ventas
WHERE ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE(ventas.fechaVenta) = '$fechaVentas';";

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR LA CANTIDAD DE CLIENTES ATENDIDOS: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>