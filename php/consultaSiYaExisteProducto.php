<?php

include('conec.php');

$codProducto = $_POST['codProductoPHP'];
$nombreProducto = $_POST['nombreProductoPHP'];

$sql = "SELECT productos.codProducto
	FROM productos
	WHERE productos.codProducto = '$codProducto' OR productos.nombreProducto = '$nombreProducto'";

$resultado = mysql_query($sql);

if(mysql_num_rows($resultado) >= 1){
 	echo 1;
}else{
	echo 0;
}

//Cierro
mysql_close($conexion);

?>