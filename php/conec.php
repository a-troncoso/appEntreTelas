<?php

header('Access-Control-Allow-Origin: *');
// ESTABLECE EL JUEGO DE CARACTERES
mysql_set_charset('utf8');

$servidor = "localhost";
$usuario = "root";
$clave = "";
$bd = "appentretelas";

$conexion = mysql_connect("$servidor", "$usuario", "$clave") or die ("No hay conexión a la base de datos.");

mysql_select_db("$bd");

?>