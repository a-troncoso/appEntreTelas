<?php

include('conec.php');

$numTicket = $_POST["numTicketPHP"];

$sql1 = "SELECT ventas.estadoPagado
FROM ventas
WHERE ventas.numTicket = $numTicket;";

$resultado1 = mysql_query($sql1);

$arrDatos = array();
if(!$resultado1){
	echo "\n SE HA DETECTADO EL SIGUIENTE ERROR EN LA BASE DE DATOS AL ANULAR LA VENTA: " . mysql_error();
}else{
	while ($rs = mysql_fetch_array($resultado1)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
};

// Se verica los estado pagado de cada venta
$estadoPagado = 1;
for ($i=0; $i <= count($arrDatos)-1; $i++) { 
	$estadoPagado = $estadoPagado * $arrDatos[$i][0];
};

// Solo se pueden eliminar pedidos no pagados (estadoPagado = 0)
if ($estadoPagado == 0) {

	$sql2 = "DELETE FROM ventas
	WHERE ventas.numTicket = $numTicket;";

	$resultado2 = mysql_query($sql2);

	if(!$resultado2){
		echo "\n SE HA DETECTADO EL SIGUIENTE ERROR EN LA BASE DE DATOS AL ANULAR LA VENTA: " . mysql_error();
	}else{
		echo "\n SE HA ANULADO LA VENTA.";
	}
}else{
	echo "NO SE PUEDE ELIMINAR UNA VENTA PAGADA.";
}

//Cierro conexion
mysql_close($conexion);

?>