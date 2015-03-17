<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$sql = "SELECT vendedores.rutVendedor,
CONCAT(vendedores.nombreVendedor, ' ' ,  vendedores.apellidoPatVendedor, ' ' , SUBSTRING(vendedores.apellidoMatVendedor, 1, 1), '.')
FROM vendedores;";

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR LOS DATOS DE LOS VENDEDORES: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>