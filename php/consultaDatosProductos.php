<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

// $rutProveedor = $_POST['rutProveedorPHP'];

$sql = "SELECT productos.codProducto,
productos.nombreProducto
FROM productos;";

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR LOS DATOS DEL LOS PRODUCTOS: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro
mysql_close($conexion);

?>