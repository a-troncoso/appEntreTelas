<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link href="css/font-awesome.css" rel="stylesheet">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Inventario</title>
</head>
<body>
	<div class="row" >
		<div class="col-md-12">
			<form action="" class="form-horizontal" role="form">
				<div class="form-group">
					<div class="col-xs-2">
						<label class="control-label" for="">FECHA:</label>
					</div>
					<div class="col-xs-3">
						<i><input type="date" id="inpFechaInventario" class="form-control"></i>
					</div>
					<div class="col-xs-3">
					<!-- <button class="btn btn-default"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button> -->
					<button class="btn btn-default"><i class="fa fa-print"></i> Imprimir</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="row" >
		<div class="col-md-12">
			<table id="tabla" class="table table-hover">
				<thead>
					<tr>
						<th>CÓDIGO</th>
						<th>PRODUCTO</th>
						<th>SALDO</th>
						<th>STOCK CRÍTICO</th>
						<th>ALERTA SALDO</th>
					</tr>
				</thead>
				<tbody id="cuerpoTablaInventario" class="cuerpoTablaInventario"></tbody>
			</table>
		</div>
	</div>

	<!--/////////////////-->
		<!-- SCRIPTS -->
	<!--/////////////////-->
	<script src="jq/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="js/funcionesInventario.js"></script>
	<script>
	$(document).ready(obtenerFechaActual("#inpFechaInventario"));
	$(document).ready(cargarInventario);
	$(document).ready(mostrarInventarioAlCambiarFecha);
	</script>
</body>
</html>