<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Compras</title>
</head>
<body>
	<div class="row" >
		<div class="col-md-12 col-lg-offset-1" >
			<form enctype="multipart/form-data" class="form-horizontal" role="form" >
				<div class="form-group">
					<div class="col-xs-2">
						<label for="" class="control-label">PROVEEDOR</label>
					</div>
					<div class="col-xs-3">
						<select id="selectProveedor" class="form-control"></select>
					</div>
					<div class="col-xs-2">
						<button id="btnNuevoProveedor" class="btn btn-primary">Nuevo</button>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-2">
						<label for="" class="control-label">RUT</label>
					</div>
					<div class="col-xs-3">
						<div class="input-group">
							<input type="number" id="inpRutProveedor" class="form-control" min="0" style="width: 176px;">
							<span class="input-group-addon">-</span>
							<input type="number" id="inpCodVerificadorProveedor" class="form-control" min="0">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-2">
						<label for="" class="control-label">GIRO</label>
					</div>
					<div class="col-xs-3">
						<input type="text" id="inpGiroProveedor" class="form-control" disabled="disabled">
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-2">
						<label for="" class="control-label">DIRECCIÓN</label>
					</div>
					<div class="col-xs-3">
						<input type="text" id="inpDireccionProveedor" class="form-control" disabled="disabled">
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-2">
						<label for="" class="control-label">REGIÓN</label>
					</div>
					<div class="col-xs-3">
						<input type="text" id="inpComuna" class="form-control" disabled="disabled">
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-2">
						<label for="" class="control-label">CIUDAD</label>
					</div>
					<div class="col-xs-3">
						<input type="text" id="inpCiudad" class="form-control" disabled="disabled">
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-2">
						<label for="" class="control-label">TELEFONO</label>
					</div>
					<div class="col-xs-3">
						<input type="text" id="inpTelefonoProveedor" class="form-control" disabled="disabled">
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-2">
						<label for="" class="control-label">MAIL</label>
					</div>
					<div class="col-xs-3">
						<input type="text" id="inpMailProveedor" class="form-control" disabled="disabled">
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-2">
						<label for="" class="control-label">PERÍODO</label>
					</div>
					<div class="col-xs-3">
						<input type="month" id="inpMesPeriodo" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-2">
						<label for="" class="control-label">DOCUMENTO</label>
					</div>
					<div class="col-xs-3">
						<select id="selectDocumento" class="form-control"></select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-2">
						<label for="" class="control-label">N° DOCUMENTO</label>
					</div>
					<div class="col-xs-3">
						<input type="number" id="inpNumeroFactura" class="form-control" min="0">
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-2">
						<label for="" class="control-label">FECHA EMISIÓN</label>
					</div>
					<div class="col-xs-3">
						<input type="date" id="inpFechaEmisionFactura" class="form-control">
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
						<th>CANTIDAD</th>
						<th>PRODUCTO</th>
						<th>CÓDIGO</th>
						<th>NUEVO</th>
						<th>VALOR UNITARIO</th>
						<th>TOTAL</th>
						<th>AGREGAR OTRO</th>
					</tr>
				</thead>
				<tbody id="cuerpoTabla" class="cuerpoTabla">
					<tr id="tr1">
						<td width="100px"><input id="inpCantidad-1" class="cantidades form-control" type="number" min="0"></td>
						<td width="600px"><select id="selProducto-1" class="selGenerado form-control"></select></td>
						<td width="170px"><input id="inpCodProducto-1" class="form-control" type="number" min="0"></td>
						<td width="100px"><button id="btnNuevoProducto-1" class="btnNuevoProducto btn btn-primary">Nuevo</button></td>
						<td width="150px"><input id="inpValorUnitario-1" class="valoresUnitarios form-control" type="number"></td>
						<td width="150px"><input id="inpValorTotal-1" class="valoresTotales form-control" type="number" step="0.01" disabled="disabled"></td>
						<td><input type="checkbox" id="check-1" class="checkGenerado form-control" style="width: 104px; height: 20px; margin-top: 7px;"></td>
					</tr>
				</tbody>
			</table>
			<table id="tablaTotales" class="table table-hover">
				<tbody>
					<tr>
						<td><label for="" class="control-label">Total neto</label></td>
						<td><input id="inpValorTotalNeto" class="form-control" type="number" style="text-align:right"></td>
					</tr>
					<tr>
						<td><label for="" class="control-label">IVA</label></td>
						<td><input id="inpValorIVA" class="form-control" type="number" style="text-align:right"></td></tr>
					<tr>
						<td><label for="" class="control-label">Total</label></td>
						<td><input id="inpValorTotal" class="form-control" type="number" style="text-align:right"></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row" >
		<div class="col-md-12">
			<button id="btnIngresarCompra" class="btn btn-success center-block" style="padding-left: 60px; padding-right: 60px; padding-top: 10px; padding-bottom: 10px;">INGRESAR</button>
		</div>
	</div>

	<!-- VENTANA MODAL INGRESAR PRODUCTO -->
	<div class="modal fade" id="modalIngresarProducto" tabindex="-1" role="dialog" aria-labelleby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4>INGRESAR PRODUCTO</h4>
				</div>
				<div class="modal-body">
					<div id="alertFaltaRellenar" class="alert alert-danger" role="alert">
						<p><strong>Error: </strong>Faltan campos por rellenar.</p>
					</div>

					<div class="row">
	                    <div class="col-md-12">
		                    <form class="form-horizontal">
		                    	<div class="form-group">
		                    		<label class="col-md-4 control-label" for="inpCodigoProducto">Código</label>
		                    		<div class="col-md-7">
		                    			<input id="inpCodigoProducto" name="inpCodigoProducto" type="text" class="form-control input-md">
		                    		</div>
		                    	</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpNombreProducto">Nombre</label>
									<div class="col-md-7">
										<input id="inpNombreProducto" name="inpNombreProducto" type="text" placeholder="Nombre del producto" class="form-control input-md">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpValorNetoVentaProducto">Valor neto venta</label>
									<div class="col-md-7">
										<input id="inpValorNetoVentaProducto" name="inpValorNetoVentaProducto" type="number" class="form-control input-md">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpValorBrutoVenta">Valor bruto venta</label>
									<div class="col-md-7">
										<input id="inpValorBrutoVenta" class="form-control input-md" name="inpValorBrutoVenta" type="number" >
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="btnIngresarProducto" class="btn btn-success">Ingresar</button>
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
	<script src="js/funcionesCompras.js"></script>
	<script>
	$(document).ready(cargarNombresProveedores);
	$(document).ready(cargarDatosProveedorSeleccionado);
	$(document).ready(cargarDocumentos);
	$(document).ready(verificarSiFacturaEstaEnPeriodoActual);
	$(document).ready(cargarNombresProductos('#selProducto-1', '#inpValorUnitario-1'));

	$(document).ready(rellenarCodigoProducto("#selProducto-1"));
	$(document).ready(cargarNombreProductoAPartirDelCodigo("#inpCodProducto-1"));

	$(document).ready(abrirModalIngresarProducto("#btnNuevoProducto-1"));
	$(document).ready(calcularValorBrutoProducto("#inpValorNetoVentaProducto", "#inpValorBrutoVenta"));
	$(document).ready(calcularValorNetoProducto("#inpValorBrutoVenta", "#inpValorNetoVentaProducto"));
	$(document).ready(ingresarNuevoProducto);

	$(document).ready(cargarValorNetoYCalcularTotalProductoSeleccionadoAlCambiarProducto('#selProducto-1'));

	$(document).ready(calculaTotalAlCambiarCantidad('#inpCantidad-1', '#inpValorUnitario-1', '#inpValorTotal-1'));
	$(document).ready(calculaTotalAlCambiarValorUnitario('#inpCantidad-1', '#inpValorUnitario-1', '#inpValorTotal-1'));
	$(document).ready(generaTds);
	$(document).ready(calcularTotalFactura("#inpValorTotalNeto"));
	$(document).ready(calcularTotalFactura("#inpValorIVA"));
	$(document).ready(ingresarCompra);

	</script>
</body>
</html>