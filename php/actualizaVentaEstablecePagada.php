<?php

include('conec.php');

$numTicket = $_POST["numTicketPHP"];
$numDocPago = $_POST["numDocPagoPHP"];

$codDocPago = $_POST["codDocPagoPHP"];
$codMedioPago = $_POST["codMedioPagoPHP"];

$estados = new stdClass();
$arrDatos = array();

$sql = "SELECT * 
FROM ventas 
WHERE codDocPago = $codDocPago 
AND numDocPago = $numDocPago 
LIMIT 1;";

$resultado = mysql_query($sql);
$numero_filas = mysql_num_rows($resultado);
if ($numero_filas == 1) {

	while ($rs = mysql_fetch_array($resultado)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}

	$fecha = date_create($arrDatos[0][1]);
	$fechaFormateada = date_format($fecha, 'd/m/y');

	$estados->estado = 0;
	$estados->descripcion = "NO SE HA INGRESADO LA VENTA, EL NÚMERO DE DOCUMENTO (" . $arrDatos[0][6] . ") YA ESTÁ INGRESADO\n\nEL DÍA: " . $fechaFormateada . "\nCON NÚMERO DE TICKET: " . $arrDatos[0][4];

}
else{
	$sql1 = "SELECT ventas.estadoPagado
	FROM ventas
	WHERE ventas.numTicket = $numTicket;";

	$resultado1 = mysql_query($sql1);

	if(!$resultado1){
		$estados->estado = 0;
		$estados->descripcion = "SE HA DETECTADO EL SIGUIENTE ERROR AL INGRESAR LA VENTA EN LA BASE DE DATOS: " . mysql_error();
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

	// Solo se pueden actualizar pedidos no pagados (estadoPagado = 0)
	if ($estadoPagado == 0) {

		$sql2 = "UPDATE ventas
		SET ventas.numDocPago = '$numDocPago',
		ventas.codDocPago = $codDocPago,
		ventas.codMedioPago = $codMedioPago,
		ventas.estadoPagado = '1'
		WHERE ventas.numTicket = $numTicket;";

		$resultado2 = mysql_query($sql2);

		if(!$resultado2){
			$estados->estado = 0;
			$estados->descripcion = "NO SE HA INGRESADO LA VENTA, SE HA DETECTADO EL SIGUIENTE ERROR AL INGRESAR LA VENTA EN LA BASE DE DATOS: " . mysql_error();
		}else{
			$estados->estado= 1;
			$estados->descripcion = "SE HA INGRESADO LA VENTA.";
		}
	}else{
		$estados->estado = 0;
		$estados->descripcion = "NO SE HA INGRESADO LA VENTA, LA VENTA ESTÁ PAGADA CON ANTERIORIDAD.";
	};
};

echo json_encode($estados);

//Cierro conexion
mysql_close($conexion);

?>