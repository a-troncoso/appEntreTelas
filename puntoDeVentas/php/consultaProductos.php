<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$nombreProducto = $_POST["nombreProductoPHP"];
$codProducto = $_POST["codProductoPHP"];

$sql = "SELECT productos.codProducto,
productos.nombreProducto,
productos.valorVentaNetoProducto,
ROUND(productos.valorVentaNetoProducto * 0.19),
ROUND(productos.valorVentaNetoProducto + (productos.valorVentaNetoProducto * 0.19))
FROM productos
WHERE productos.nombreProducto like '%$nombreProducto%'
AND productos.codProducto like '$codProducto'
ORDER BY productos.nombreProducto;";

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