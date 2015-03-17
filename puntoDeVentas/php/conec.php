<?php

header('Content-Type: text/html; charset=UTF-8');

//ESTE ESTABLECE LA ZONA HORARIA PARA EL HORARIO DE VERANO
date_default_timezone_set('America/La_Paz');

$servidor = "localhost";
$usuario = "root";
$clave = "";
$bd = "appentretelas";

$conexion = mysql_connect("$servidor", "$usuario", "$clave");

mysql_select_db("$bd");
?>