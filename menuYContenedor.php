<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<script src="jq/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="js/funcionesMenuYContenedor.js"></script>
	<script>
	$(document).ready(llamarPaginasSegunTabSeleccionado);
	</script>
	<title>Interfaz Caja</title>
</head>
<body  style="background-color: #F1F5F9">
	<div class="row" >
		<div class="col-md-12" >
			<div class="navbar navbar-default">
			<div class="navbar-inner">
				<div class="container">
					<div class="nav-collapse">
						<ul class="nav navbar-nav">
							<li><a href="#" id="btnCompras" style="color: #219A96;">COMPRAS</a></li>
							<li><a href="#" id="btnVentas" style="color: #219A96;">VENTAS</a></li>
							<li><a href="#" id="btnProductos" style="color: #219A96;">PRODUCTOS</a></li>
							<li><a href="#" id="btnVendedores" style="color: #219A96;">VENDEDORES</a></li>
							<li><a href="#" id="btnProveedores" style="color: #219A96;">PROVEEDORES</a></li>
							<li><a href="#" id="btnInventario" style="color: #219A96;">INVENTARIO</a></li>
							<li><a href="php/cerrarSesion.php" id="btnSalir" style="color: #219A96;">SALIR</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		</div>
	</div>
	<div class="container" id="container"></div>
</body>
</html>