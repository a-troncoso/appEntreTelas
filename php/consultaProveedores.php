<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$sql ="SELECT proveedores.rutProveedor,
proveedores.nombreProveedor,
proveedores.direccionProveedor,
comunaschile.nombreComuna,
proveedores.telefonoProveedor,
proveedores.mailProveedor
FROM proveedores, comunaschile
WHERE proveedores.idComuna = comunaschile.idComuna;";

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR LOS NOMBRES DE LOS PROVEEDORES: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro
mysql_close($conexion);

?>