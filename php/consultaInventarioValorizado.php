<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$fechaInventario = $_POST["fechaInventarioPHP"];

$sql = "SELECT SUM(((productos.valorVentaNetoProducto)+(productos.valorVentaNetoProducto * 0.19))*(`SUM(``SUM(compras.cantidadComprada)``)`-`SUM(``SUM(ventas.cantidadVendida)``)`))
	FROM `vistaCompras`, `vistaVentas`, `productos`
	WHERE vistaCompras.codProducto = vistaVentas.codProducto
	AND productos.codProducto = vistaCompras.codProducto
	AND productos.codProducto = vistaVentas.codProducto;"; 

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR EL IVENTARIO VALORIZADO: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>