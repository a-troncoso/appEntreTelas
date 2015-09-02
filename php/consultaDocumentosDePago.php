<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$numTicket = $_POST["numTicketPHP"];
// $numTicket = 0;

// Si el ticket es 0 quiere decir que es una venta q no se ha ingresado
if ($numTicket == 0) {
	$sql = "SELECT documentosdepago.codDocPago,
	documentosdepago.nombreDocPago
	FROM documentosdepago;";
// Si el ticket es distinto de cero quiere decir q es una venta ingresada, por lo tanto se obtiene el codigo de doc pago del ese ticket
}else{
	$sql = "SELECT DISTINCT documentosdepago.codDocPago,
	documentosdepago.nombreDocPago
	FROM documentosdepago, ventas
	WHERE documentosdepago.codDocPago = ventas.codDocPago
	AND ventas.numTicket = $numTicket;";
}

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