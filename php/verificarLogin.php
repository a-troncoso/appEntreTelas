<?php session_start();

header('Access-Control-Allow-Origin: *');

include("conec.php");

$correoLocal = $_POST['correoLocal'];
$passLocal = $_POST['passLocal'];
// $nombreUsuario = 'admin';
// $claveUsuario = '123';

$sql = "SELECT locales.idLocal, locales.correoLocal, locales.passLocal, locales.estadoActivo FROM locales
WHERE locales.correoLocal = '$correoLocal'
AND locales.passLocal = '$passLocal'";

$resultado = mysql_query($sql);

$arrDatos = array();

// SI NO HAY ERROR SE EJECUTA
if(!$resultado) {
	//SE EJECUTA LA QUERY
	echo "\nSE HA DETECTADO EL SIGUIENTE ERROR SQL AL VALIDAR EL LOCAL: " . mysql_error();
}

while ($rs = mysql_fetch_array($resultado)) {
	$arrDatos[] = array_map('utf8_encode', $rs);
}

if (mysql_num_rows($resultado)) {
	//VERIFICA SI ESTA EN ESTADO ACTIVO '1'
	if ($arrDatos[0][3] == 1) {
		$_SESSION['idLocal'] = $arrDatos[0][0];
		$_SESSION['correoLocal'] = $arrDatos[0][1];

		echo 'Login verificado...cargando';
		echo "<script>
		<!--
		window.location='../menuYContenedor.php';
		//-->
		</script>";
	}else echo 'La cuenta aún no ha sido activada.';
}else{
	echo 'Usuario o contraseña incorrectos.';
}

//Cierro
mysql_close($conexion);

?>