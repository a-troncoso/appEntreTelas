<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$regionSeleccionada = $_POST['regionSeleccionadaPHP'];

$sql = "SELECT comunaschile.idComuna,
comunaschile.nombreComuna
FROM comunaschile
WHERE comunaschile.idRegion = '$regionSeleccionada'
ORDER BY comunaschile.nombreComuna;";

$resultado = mysql_query($sql);

$arrDatos = array();

if(!$resultado){
	echo "SE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL CONSULTAR LAS COMUNAS: \n" . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	echo json_encode($arrDatos);
}

//Cierro
mysql_close($conexion);

?>