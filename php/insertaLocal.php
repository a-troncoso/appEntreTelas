<?php

// ESTE PHP HACE EL INGRESO DE PRODUCTO
include('conec.php');

$inpEmailLocal = $_POST['inpEmailLocalPHP'];
$inpNombreLocal = $_POST['inpNombreLocalPHP'];
$estadoActivo = 0;
$inpDireLocal = $_POST['inpDireLocalPHP'];
$inpPassLocal = $_POST['inpPassLocalPHP'];
$inpFonoLocal = $_POST['inpFonoLocalPHP'];
$fechaRegistroLocal = date('Y-m-d');


$sql = "INSERT INTO `appbares`.`locales` (`idLocal`,
	`passLocal`,
	`estadoActivo`,
	`nombreLocal`,
	`correoLocal`,
	`direccionLocal`,
	`telefonoLocal`,
	`fechaRegistroLocal`)
VALUES (NULL,
	'$inpPassLocal',
	'$estadoActivo',
	'$inpNombreLocal',
	'$inpEmailLocal',
	'$inpDireLocal',
	'$inpFonoLocal',
	'$fechaRegistroLocal');";

$datos = mysql_query(utf8_decode($sql));

if (!$datos) {
	echo "Ha ocurrido un error con la base de datos al ingresar el local ". mysql_error();
}

//Cierro
mysql_close($conexion);

?>
