<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$rutProveedor = $_POST["rutProveedorPHP"];

$sql ="SELECT proveedores.rutProveedor,
proveedores.nombreProveedor,
proveedores.giroProveedor,
proveedores.direccionProveedor,
regioneschile.nombreRegion,
comunaschile.nombreComuna,
proveedores.telefonoProveedor,
proveedores.mailProveedor
FROM proveedores, comunaschile, regioneschile
WHERE proveedores.idRegion = regioneschile.idRegion
AND proveedores.idComuna = comunaschile.idComuna
AND proveedores.rutProveedor like '$rutProveedor';";

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