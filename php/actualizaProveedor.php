<?php
header('Access-Control-Allow-Origin: *');

include('conec.php');

$rutProveedorAEditar = $_POST["rutProveedorAEditarPHP"];

$nuevoNombreProveedor = $_POST["nuevoNombreProveedorPHP"];
$nuevoGiroProveedor = $_POST["nuevoGiroProveedorPHP"];
$nuevaDireccionProveedor = $_POST["nuevaDireccionProveedorPHP"];
// $nuevaRegionProveedor = $_POST["nuevaRegionProveedorPHP"];
// $nuevaComunaProveedor = $_POST["nuevaComunaProveedorPHP"];
$nuevoTelefonoProveedor = $_POST["nuevoTelefonoProveedorPHP"];
$nuevoEmailProveedor = $_POST["nuevoEmailProveedorPHP"];

// $sql = "UPDATE `proveedores`
// SET `nombreProveedor` = '$nuevoNombreProveedor',
// `giroProveedor` = '$nuevoGiroProveedor',
// `direccionProveedor` = '$nuevaDireccionProveedor',
// `idRegion` = '$nuevaRegionProveedor',
// `idComuna` = '$nuevaComunaProveedor',
// `telefonoProveedor` = '$nuevoTelefonoProveedor',
// `mailProveedor` = '$nuevoEmailProveedor'
// WHERE `proveedores`.`rutProveedor` = $rutProveedorAEditar;";


$sql = "UPDATE `proveedores`
SET `nombreProveedor` = '$nuevoNombreProveedor',
`giroProveedor` = '$nuevoGiroProveedor',
`direccionProveedor` = '$nuevaDireccionProveedor',
`telefonoProveedor` = '$nuevoTelefonoProveedor',
`mailProveedor` = '$nuevoEmailProveedor'
WHERE `proveedores`.`rutProveedor` = $rutProveedorAEditar;";

$resultado = mysql_query($sql);

if(!$resultado){
	echo "\nSE HA DETECTADO EL SIGUIENTE ERROR EN LA BD AL ACTUALIZAR LOS DATOS DEL PROVEEDOR: \n" . mysql_error();
}else{
	echo "\nSE HAN ACTUALIZADO LOS DATOS DEL PROVEEDOR.";
}

//Cierro conexion
mysql_close($conexion);

?>