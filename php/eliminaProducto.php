<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$codProductoAEliminar = $_POST["codProductoAEliminarPHP"];

$sql = "DELETE FROM productos
WHERE productos.codProducto = $codProductoAEliminar;";

$resultado = mysql_query($sql);

if(!$resultado){
	echo "\nSE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL ELIMINAR EL PRODUCTO: \n" . mysql_error();
}else{
	echo "\nSE HA ELIMINADO EL PRODUCTO.";
}

//Cierro conexion
mysql_close($conexion);

?>