<?php
session_start();

// 	CAPTURA EL RUT VENDEDOR Y SU NOMBRE Y LUEGO LO ESTABLECE COMO VARIABLE DE SESION
$rutVendedorLogueado = $_POST['rutVendedorLogueadoPHP'];
$nombreVendedorLogueado = $_POST['nombreVendedorLogueadoPHP'];

$_SESSION['rutVendedorLogueado'] = $rutVendedorLogueado;
$_SESSION['nombreVendedorLogueado'] = $nombreVendedorLogueado;

// INGRESA UN NUEVO TICKET Y CAPTURA ESE NUMERO DE TICKET INGRESADO PARA ESTABLECERLO COMO VARIABLE DE SESION
include('conec.php');

$rutVendedor = $_SESSION['rutVendedorLogueado'];

$sql1 = "INSERT INTO `correlativonumticket` (`numTicket`,
	`rutVendedor`)
VALUES (NULL,
	'$rutVendedor');";

$resultado1 = mysql_query($sql1);

$sql2 ="SELECT @@identity AS id";

$resultado2 = mysql_query($sql2);

if ($row = mysql_fetch_row($resultado2)) {
	$numTicket = trim($row[0]);
	$_SESSION['numTicket'] = $numTicket;
}

if(!$resultado1 || !$resultado2 ){
	echo "\n SE HA DETECTADO EL SIGUIENTE ERROR EN LA BASE DE DATOS AL GENERAR EL NUMERO DE TICKET : \n" . mysql_error();
}

//Cierro conexion
mysql_close($conexion);

?>