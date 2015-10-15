<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$fechaInventario = $_POST["fechaInventarioPHP"];

// Verifica si existe la vista vistaTemporal
$res = mysql_query("SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = 'appentretelas' AND table_name = 'vistaVentasTemporal';");
// Si existe la borra
if (mysql_result($res, 0) ) {
	$sql = mysql_query("DROP VIEW vistaVentasTemporal;");
}

// Crea la vista vistaVentas
$sql1 = mysql_query("CREATE VIEW vistaVentasTemporal AS
	SELECT productos.codProducto,
	productos.nombreProducto,
	SUM(ventas.cantidadVendida),
	productos.stockCriticoProducto
	FROM productos, ventas
	WHERE productos.codProducto = ventas.codProducto
	AND DATE(ventas.fechaVenta) <= '$fechaInventario'
	GROUP BY productos.codProducto, productos.nombreProducto, productos.stockCriticoProducto
	UNION
	SELECT productos.codProducto,
	productos.nombreProducto,
	0,
	productos.stockCriticoProducto
	FROM productos
	GROUP BY productos.codProducto, productos.nombreProducto, productos.stockCriticoProducto;");

// Verifica si existe la vista vistaVentas
$res = mysql_query("SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = 'appentretelas' AND table_name = 'vistaVentas';");
// Si existe la borra
if (mysql_result($res, 0) ) {
	$sql = mysql_query("DROP VIEW vistaVentas;");
}

// Crea la vistaVentas que contiene las ventas agrupadas por producto
$sql2 = mysql_query("CREATE VIEW vistaVentas AS
	SELECT vistaVentasTemporal.codProducto,
	vistaVentasTemporal.nombreProducto,
	SUM(`SUM(ventas.cantidadVendida)`),
	vistaVentasTemporal.stockCriticoProducto
	FROM `vistaVentasTemporal`
	GROUP BY vistaVentasTemporal.codProducto, vistaVentasTemporal.nombreProducto, vistaVentasTemporal.stockCriticoProducto;");


// Verifica si existe la vista vistaTemporal
$res = mysql_query("SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = 'appentretelas' AND table_name = 'vistaComprasTemporal';");
// Si existe la borra
if (mysql_result($res, 0) ) {
	$sql = mysql_query("DROP VIEW vistaComprasTemporal;");
}

// Crea la vista vistaTemporal
$sql3 = mysql_query("CREATE VIEW vistaComprasTemporal AS
	SELECT productos.codProducto,
	productos.nombreProducto,
	SUM(compras.cantidadComprada),
	productos.stockCriticoProducto
	FROM productos, compras
	WHERE productos.codProducto = compras.codProducto
	AND DATE(compras.fechaCompra) <= '$fechaInventario'
	GROUP BY productos.codProducto, productos.nombreProducto, productos.stockCriticoProducto
	UNION
	SELECT productos.codProducto,
	productos.nombreProducto,
	0,
	productos.stockCriticoProducto
	FROM productos
	GROUP BY productos.codProducto, productos.nombreProducto, productos.stockCriticoProducto;");

// Verifica si existe la vista vistaCompras
$res2 = mysql_query("SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = 'appentretelas' AND table_name = 'vistaCompras';");
// Si existe la borra
if (mysql_result($res, 0) ) {
	$sql = mysql_query("DROP VIEW vistaCompras;");
}

// Agrupa la vista mostrando solo las compras que se han realizado agrupado por producto
$sql4 = mysql_query("CREATE VIEW vistaCompras AS
	SELECT vistaComprasTemporal.codProducto,
	vistaComprasTemporal.nombreProducto,
	SUM(`SUM(compras.cantidadComprada)`),
	vistaComprasTemporal.stockCriticoProducto
	FROM `vistaComprasTemporal`
	GROUP BY vistaComprasTemporal.codProducto, vistaComprasTemporal.nombreProducto, vistaComprasTemporal.stockCriticoProducto;");

// Resta las compras menos las ventas, obteniendo el inventario
$sql5 = mysql_query("SELECT vistaCompras.codProducto,
	vistaCompras.nombreProducto,
	`SUM(``SUM(compras.cantidadComprada)``)`-`SUM(``SUM(ventas.cantidadVendida)``)`,
	vistaCompras.stockCriticoProducto,
	((productos.valorVentaNetoProducto)+(productos.valorVentaNetoProducto * 0.19))*(`SUM(``SUM(compras.cantidadComprada)``)`-`SUM(``SUM(ventas.cantidadVendida)``)`)
	FROM `vistaCompras`, `vistaVentas`, `productos`
	WHERE vistaCompras.codProducto = vistaVentas.codProducto
	AND productos.codProducto = vistaCompras.codProducto
	AND productos.codProducto = vistaVentas.codProducto
	GROUP BY vistaCompras.codProducto, vistaCompras.nombreProducto, vistaCompras.stockCriticoProducto
	ORDER BY vistaCompras.nombreProducto ASC;");


$arrDatos = array();

if(!$res || !$sql1  || !$res2 || !$sql3 || !$sql5){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR EL INVENTARIO: \n\n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($sql5)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
}
echo json_encode($arrDatos);

//Cierro
mysql_close($conexion);

?>