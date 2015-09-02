<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$numTicket = $_POST["numTicketPHP"];

// Si el ticket es 0 quiere decir que es una venta q no se ha ingresado
if ($numTicket == 0) {
	$sql = "SELECT mediosdepago.codMedioPAgo, mediosdepago.nombreMedioPago
	FROM mediosdepago;";
// Si el ticket es distinto de cero quiere decir q es una venta ingresada, por lo tanto se obtiene el codigo de medio pago del ese ticket
}else{
	$sql = "SELECT DISTINCT mediosdepago.codMedioPago,
	mediosdepago.nombreMedioPago
	FROM mediosdepago, ventas
	WHERE mediosdepago.codMedioPago = ventas.codMedioPago
	AND ventas.numTicket = $numTicket";
}

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