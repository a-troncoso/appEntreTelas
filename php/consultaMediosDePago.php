<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$sql = "SELECT mediosdepago.codMedioPAgo, mediosdepago.nombreMedioPago
FROM mediosdepago;"; 

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR LOS MEDIOS DE PAGO: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro conexion
mysql_close($conexion);

?>