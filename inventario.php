<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Inventario</title>
	<style type="text/css">
	.numeros{
		text-align: right;
	}
	.letras{
		text-align: left;
	}
	</style>
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
						<th class="numeros">CÓDIGO</th>
						<th class="letras">PRODUCTO</th>
						<th class="numeros">SALDO</th>
						<th class="numeros">STOCK CRÍTICO</th>
						<th class="numeros">ALERTA SALDO</th>
						<th class="numeros">VALOR BRUTO</th>
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
	$(document).ready(cargarTotalInventarioValorizado);
	</script>
</body>
</html>