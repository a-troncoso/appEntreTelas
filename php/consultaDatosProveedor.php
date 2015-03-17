<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$rutProveedor = $_POST['rutProveedorPHP'];

$sql = "SELECT proveedores.rutProveedor,
proveedores.nombreProveedor,
proveedores.giroProveedor,
proveedores.direccionProveedor,
regioneschile.nombreRegion,
comunaschile.nombreComuna,
proveedores.telefonoProveedor,
proveedores.mailProveedor
FROM proveedores, comunaschile, regionesChile
WHERE proveedores.rutProveedor = '$rutProveedor'
AND proveedores.idComuna = comunaschile.idComuna
AND proveedores.idRegion = regionesChile.idRegion;";

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR LOS DATOS DEL PROVEEDOR: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro
mysql_close($conexion);

?>