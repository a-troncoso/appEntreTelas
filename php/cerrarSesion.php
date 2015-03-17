<?php
	//iniciar sesion antes que todo
	session_start();
	//libera la sesión actual, elimina cualquier dato de la sesión.
	//Se liberan todas las variables de sesion
	session_destroy();
	$_SESSION = array();
	/* liberarán las variables de sesión registradas, (majadero porq con lo anterior se supone q lo hice)
	quitandoles el valor contenido en ellas si no se hace esto aunque la pagina sea cerrada siempre
	conservaran su valor y cualquier persona podra ingresar a la sesion*/
	$_SESSION['idLocal'];
	$_SESSION['correoLocal'];
	//libera la sesion
	session_unset();
	// Eliminar la cookie que contiene el Id de la sesión, esto lo hacemos así:
	$parametros_cookies = session_get_cookie_params();
	setcookie(session_name(), 0, 1, $parametros_cookies["path"]);
	//dirigirse a la pagina que se desea ver
	header("Location: ../index.php");
?>