<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$mes = $_POST["mesVentasPHP"];
$ano = $_POST["anoVentasPHP"];

// Verifica si existe la vista vistaVentasMesPorDoc
$res = mysql_query("SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = 'appentretelas' AND table_name = 'vistaVentasMesPorDoc';");
// Si existe la borra
if (mysql_result($res, 0) ) {
	$sql = mysql_query("DROP VIEW vistaVentasMesPorDoc;");
}

$sql1 = "CREATE VIEW vistaVentasMesPorDoc AS ";

// TOTAL
$sql1 .= "SELECT DATE_FORMAT(ventas.fechaVenta, '%d'),
'total dia',
ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida)),
'0',
'0'
FROM productos, ventas
WHERE productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mes'
AND DATE_FORMAT(ventas.fechaVenta, '%Y') = '$ano'
GROUP BY DATE_FORMAT(ventas.fechaVenta, '%d')";

$sql1 .= " UNION ALL ";

// BOLETA
$sql1 .= "SELECT DATE_FORMAT(ventas.fechaVenta, '%d'),
'total por boleta',
ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida)),
MIN(ventas.numDocPago),
MAX(ventas.numDocPago)
FROM documentosdepago, productos, ventas
WHERE documentosdepago.codDocPago = ventas.codDocPago
AND productos.codProducto = ventas.codProducto
AND ventas.codDocPago = 2
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mes'
AND DATE_FORMAT(ventas.fechaVenta, '%Y') = '$ano'
GROUP BY DATE_FORMAT(ventas.fechaVenta, '%d')";

$sql1 .= " UNION ALL ";

// FACTURA
$sql1 .= "SELECT DATE_FORMAT(ventas.fechaVenta, '%d'),
'total por factura',
ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida)),
MIN(ventas.numDocPago),
MAX(ventas.numDocPago)
FROM documentosdepago, productos, ventas
WHERE documentosdepago.codDocPago = ventas.codDocPago
AND productos.codProducto = ventas.codProducto
AND ventas.codDocPago = 3
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mes'
AND DATE_FORMAT(ventas.fechaVenta, '%Y') = '$ano'
GROUP BY DATE_FORMAT(ventas.fechaVenta, '%d')";

$sql1 .= " UNION ALL ";

// VOUCHER TRANSBANK
$sql1 .= "SELECT DATE_FORMAT(ventas.fechaVenta, '%d'),
'total por voucher transbank',
ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida)),
MIN(ventas.numDocPago),
MAX(ventas.numDocPago)
FROM documentosdepago, productos, ventas
WHERE documentosdepago.codDocPago = ventas.codDocPago
AND productos.codProducto = ventas.codProducto
AND ventas.codDocPago = 4
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mes'
AND DATE_FORMAT(ventas.fechaVenta, '%Y') = '$ano'
GROUP BY DATE_FORMAT(ventas.fechaVenta, '%d');";

$resultado1 = mysql_query($sql1);

if(!$resultado1){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR EL LOS TOTALES DEL MES POR DOCUMENTO: \n" . mysql_error();
}
// SE CONSULTA POR LOS TOTALES POR DIA POR DOCUMENTOS Y EL PRIMER Y ULTIMO NUMERO DE DOCUMENTO
else{
	$sql2 = "SELECT `DATE_FORMAT(ventas.fechaVenta, '%d')` AS 'Dia',
	GROUP_CONCAT(if(`total dia` = 'total dia', `Name_exp_3`, NULL)) AS 'Total dia',
	GROUP_CONCAT(if(`total dia` = 'total por boleta', `Name_exp_3`, NULL)) AS 'Total boletas',

	GROUP_CONCAT(if(`total dia` = 'total por boleta', `0`, NULL)) AS 'Primera boleta',
	GROUP_CONCAT(if(`total dia` = 'total por boleta', `My_exp_0`, NULL)) AS 'Última boleta',

	GROUP_CONCAT(if(`total dia` = 'total por factura', `Name_exp_3`, NULL)) AS 'Total facturas',

	GROUP_CONCAT(if(`total dia` = 'total por factura', `0`, NULL)) AS 'Primera factura',
	GROUP_CONCAT(if(`total dia` = 'total por factura', `My_exp_0`, NULL)) AS 'Última factura',

	GROUP_CONCAT(if(`total dia` = 'total por voucher transbank', `Name_exp_3`, NULL)) AS 'Total voucher transbank',

	GROUP_CONCAT(if(`total dia` = 'total por voucher transbank', `0`, NULL)) AS 'Primer voucher transbank',
	GROUP_CONCAT(if(`total dia` = 'total por voucher transbank', `My_exp_0`, NULL)) AS 'Último voucher transbank'

	FROM vistaVentasMesPorDoc
	GROUP BY `DATE_FORMAT(ventas.fechaVenta, '%d')`
	ORDER BY `DATE_FORMAT(ventas.fechaVenta, '%d')`;";

	$resultado2 = mysql_query($sql2);

	$arrDatos = array();

	if(!$resultado2){
		echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR EL LOS TOTALES DEL MES POR DOCUMENTO: \n" . mysql_error();
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