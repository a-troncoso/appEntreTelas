<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$codProducto = $_POST['codProductoPHP'];
$rutProveedor = $_POST['rutProveedorPHP'];

$sql = "SELECT MAX(compras.valorCompraNetoProducto)
FROM compras
WHERE compras.rutProveedor = '$rutProveedor'
AND compras.codProducto = '$codProducto';";

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