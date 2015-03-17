<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$fechaVentas = $_POST["fechaVentasPHP"];

$sql = "SELECT vendedores.nombreVendedor,
COUNT(DISTINCT ventas.numTicket)
FROM vendedores, ventas
WHERE vendedores.rutVendedor = ventas.rutVendedor
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE(ventas.fechaVenta) = '$fechaVentas'
GROUP BY vendedores.nombreVendedor;";

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR LA CANTIDAD DE CLIENTES ATENDIDOS POR VENDEDOR: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>