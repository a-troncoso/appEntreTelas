<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$sql = "SELECT documentosdecompra.codDocCompra,
documentosdecompra.nombreDocCompra
FROM documentosdecompra;";

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR LOS DOCUMENTOS DE COMPRA: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>