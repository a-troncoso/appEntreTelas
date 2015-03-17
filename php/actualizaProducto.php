<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$codProductoAEditar = $_POST["codProductoAEditarPHP"];
$nuevoCodigoProducto = $_POST["nuevoCodigoProductoPHP"];
$nuevoNombreProducto = $_POST["nuevoNombreProductoPHP"];
$nuevoValorNetoVentaProducto = $_POST["nuevoValorNetoVentaProductoPHP"];
$nuevoStockCriticoProducto = $_POST["nuevoStockCriticoProductoPHP"];

$sql = "UPDATE productos
SET codProducto = '$nuevoCodigoProducto',
nombreProducto = '$nuevoNombreProducto',
valorVentaNetoProducto = '$nuevoValorNetoVentaProducto',
stockCriticoProducto = '$nuevoStockCriticoProducto'
WHERE productos.codProducto = '$codProductoAEditar';";

$resultado = mysql_query($sql);

if(!$resultado){
	echo "\nSE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL ACTUALIZAR LOS DATOS DEL PRODUCTO: \n" . mysql_error();
}else{
	echo "\nSE HAN ACTUALIZADO LOS DATOS DEL PRODUCTO.";
}

//Cierro conexion
mysql_close($conexion);

?>