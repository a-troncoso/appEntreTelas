<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Ingresar venta</title>
</head>
<body>
	<!-- <div class="row" >
		<div class="col-md-12 col-lg-offset-1" >
			<form enctype="multipart/form-data" class="form-horizontal" role="form" >
				<div class="form-group">
					<div class="col-xs-1">
						<label for="" class="control-label">PRODUCTO</label>
					</div>
					<div class="col-xs-4">
						<select id="selProducto" class="form-control"></select>
					</div>
					<div class="col-xs-1">
						<button id="btnAgregarProductoALista" class="btn btn-success">Agregar</button>
					</div>
					<div class="col-xs-2">
						<button id="btnBuscarProducto" class="btn btn-primary">Buscar</button>
					</div>
				</div>
			</form>
		</div>
	</div> -->

	<div class="row" >
		<div class="col-md-12">
			<table id="tabla" class="table table-hover">
				<thead>
					<tr>
						<th>CANTIDAD</th>
						<th>PRODUCTO</th>
						<th></th>
						<th>VALOR UNITARIO</th>
						<th>DESCUENTO</th>
						<th>NETO</th>
						<th>IVA</th>
						<th>TOTAL</th>
						<th>AGREGAR OTRO</th>
					</tr>
				</thead>
				<tbody id="cuerpoTabla" class="cuerpoTabla">
					<tr id="tr1">
						<td width="100px"><input id="inpCantidad-1" class="cantidades form-control" type="number" min="0"></td>
						<td width="600px"><select id="selProducto-1" class="selGenerado form-control"></select></td>
						<td width="100px"><button id="btnBuscarProducto-1" class="buscadores btn btn-primary">Buscar</button></td>
						<td width="150px"><input id="inpValorUnitario-1" class="form-control" type="number" disabled="disabled"></td>
						<td width="150px"><input id="inpDescuento-1" class="form-control" type="number" min="0" value="0"></td>
						<td width="150px"><input id="inpValorNeto-1" class="valoresTotales form-control" type="number" step="0.01" disabled="disabled"></td>
						<td width="150px"><input id="inpValorIVA-1" class="valoresTotales form-control" type="number" step="0.01" disabled="disabled"></td>
						<td width="150px"><input id="inpValorTotal-1" class="valoresTotales form-control" type="number" step="0.01" disabled="disabled"></td>
						<td><input type="checkbox" id="check-1" class="checkGenerado form-control" style="width: 60px; height: 20px; margin-top: 7px;"></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row" >
		<div class="col-md-12">
			<button id="btnEnviarVenta" class="btn btn-success center-block" style="padding-left: 60px; padding-right: 60px; padding-top: 10px; padding-bottom: 10px;">ENVIAR</button>
		</div>
	</div>

	<!-- VENTANA MODAL BUSCAR PRODUCTO -->
	<div class="modal fade" id="modalBuscarProducto" tabindex="-1" role="dialog" aria-labelleby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button typ="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4>BUSCAR PRODUCTO</h4>
				</div>
				<div class="modal-body">
					<div class="row" >
						<div class="col-md-12">
							<form action="" class="form-horizontal" role="form">
								<div class="form-group">
									<div class="col-xs-2">
										<label class="control-label" for="">Nombre</label>
									</div>
									<div class="col-xs-7">
										<input id="inpNombreProducto" class="form-control" type="text" autofocus>
									</div>
									<div class="col-xs-1">
										<button id="btnBuscarProducto" class="btn btn-info">Buscar</button>
									</div>
								</div>
							</form>
						</div>
					</div>

					<table id="tabla" class="table table-hover">
						<thead>
							<tr>
								<th>Producto</th>
								<th>Valor unitario</th>
								<th>IVA</th>
								<th>Valor venta</th>
							</tr>
						</thd>
						<tbody id="cuerpoTablaProductosEncontrados" class="cuerpoTablaDetalleVenta">
							<!-- <tr>
								<td>Tapiz conforta cream chocolate</td>
								<td>550</td>
								<td>100</td>
								<td>600</td>
							</tr> -->
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	<!-- FIN VENTANA MODAL -->

	<!--/////////////////-->
		<!-- SCRIPTS -->
	<!--/////////////////-->
	<script src="jq/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="js/funcionesIngresarVenta.js"></script>
	<script>
	$(document).ready(abrirModalBuscarProducto);
	// $(document).ready(buscarProductosAlPresionarEnter);
	// $(document).ready(buscarProductosAlPresionarBotonBuscar);
	</script>
</body>
</html>