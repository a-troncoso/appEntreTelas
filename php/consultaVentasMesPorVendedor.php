<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$mes = $_POST["mesVentasPHP"];
$rutVendedor = $_POST["rutVendedorPHP"];

// Verifica si existe la vista vistaVentasMesPorVendedor
$res = mysql_query("SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = 'appentretelas' AND table_name = 'vistaVentasMesPorVendedor';");
// Si existe la borra
if (mysql_result($res, 0) ) {
	$sql = mysql_query("DROP VIEW vistaVentasMesPorVendedor;");
}

$sql1 = "CREATE VIEW vistaVentasMesPorVendedor AS ";

// TOTAL
$sql1 .= "SELECT DATE_FORMAT(ventas.fechaVenta, '%d'),
'total dia',
ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM productos, ventas
WHERE productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mes'
GROUP BY DATE_FORMAT(ventas.fechaVenta, '%d')";

$sql1 .= " UNION ALL ";

// VENDEDOR
$sql1 .= "SELECT DATE_FORMAT(ventas.fechaVenta, '%d'),
'$rutVendedor',
ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM vendedores, productos, ventas
WHERE vendedores.rutVendedor = ventas.rutVendedor
AND productos.codProducto = ventas.codProducto
AND ventas.rutVendedor = $rutVendedor
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mes'
GROUP BY DATE_FORMAT(ventas.fechaVenta, '%d')";

$resultado1 = mysql_query($sql1);

if(!$resultado1){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR EL LOS TOTALES DEL MES POR VENDEDOR: \n" . mysql_error();
}else{

	$sql2 = "SELECT `DATE_FORMAT(ventas.fechaVenta, '%d')` AS 'Dia',
	GROUP_CONCAT(if(`total dia` = 'total dia', `Name_exp_3`, NULL)) AS 'Total dia',
	GROUP_CONCAT(if(`total dia` = '$rutVendedor', `Name_exp_3`, NULL)) AS 'Total vendedor'

	FROM vistaVentasMesPorVendedor
	GROUP BY `DATE_FORMAT(ventas.fechaVenta, '%d')`
	ORDER BY `DATE_FORMAT(ventas.fechaVenta, '%d')`;";

	$resultado2 = mysql_query($sql2);
	$arrDatos = array();

	if(!$resultado2){
		echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR EL LOS TOTALES DEL MES POR VENDEDOR: \n" . mysql_error();
	}else{
		while ($rs = mysql_fetch_array($resultado2)) {
			$arrDatos[] = array_map('utf8_encode', $rs);
		}
		echo json_encode($arrDatos);
	}
}

//Cierro conexion
mysql_close($conexion);

?>