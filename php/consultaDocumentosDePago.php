<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$sql = "SELECT documentosdepago.codDocPago,
documentosdepago.nombreDocPago
FROM documentosdepago;";

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR LOS DOCUMENTOS DE PAGO: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>