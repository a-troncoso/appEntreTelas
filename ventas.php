<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<!-- FontAwesome Styles-->
    <link href="css/font-awesome.css" rel="stylesheet">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Ventas</title>
	<style>
	.lblModalDetalleVenta{
		margin-left: 9px;
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
					<div class="col-xs-2">
						<i><input type="date" id="inpFecha" class="form-control"></i>
					</div>
					<!-- <div class="col-xs-2"> -->
						<button id="btnDetallesVentasDia" class="btn btn-info" data-toggle="modal" type="button">Detalles día</button>
					<!-- </div> -->
					<!-- <div class="col-xs-2"> -->
						<button id="btnDetallesVentasMes" class="btn btn-primary" data-toggle="modal" type="button">Detalles mes</button>
					<!-- </div> -->
				</div>
				<div class="form-group">
					<div class="col-xs-2">
						<label class="control-label" for="">TOTAL DÍA:</label>
					</div>
					<div class="col-xs-2">
						<i><label class="control-label" for=""><span>$ </span><span id="totalDia" >0</span><span> .-</span></label></i>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- LINEA SEPARADORA -->
	<div style="height: 1px; width:100%; background-color:#D3D3D3; margin-top:5px; margin:30px 0 30px 0"></div>

	<div class="row" >
		<div class="col-md-12">
			<table id="tabla" class="table table-hover">
				<thead>
					<tr>
						<th>TICKET</th>
						<th>VENDEDOR</th>
						<th>TOTAL</th>
						<th>DETALLES</th>
					</tr>
				</thead>
				<tbody id="cuerpoTabla" class="cuerpoTabla">
				</tbody>
			</table>
		</div>
	</div>

	<!-- VENTANA MODAL DETALLES DE LA VENTA -->
	<div class="modal fade" id="modalDetallesVenta" tabindex="-1" role="dialog" aria-labelleby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button typ="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4>DETALLE DE LA VENTA</h4>
				</div>
				<div class="modal-body">
					<p><span><b>Número ticket:</b></span><span id="numTicket"></span></p>
					<table id="tabla" class="table table-hover">
						<thead>
							<tr>
								<th>Producto</th>
								<th>Cantidad</th>
								<th>Valor unitario</th>
								<th>Descuento</th>
								<th>Neto</th>
								<th>IVA</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody id="cuerpoTablaDetalleVenta" class="cuerpoTablaDetalleVenta">
							<!-- <tr>
								<td>Tapiz conforta cream chocolate</td>
								<td>2</td>
								<td>550</td>
								<td>-10 %</td>
								<td>1100</td>
								<td>187</td>
								<td>1287</td>
							</tr> -->
						</tbody>
					</table>
				</div>

				<hr>

				<div class="row" >
					<div class="col-md-12">
						<form action="" class="form-horizontal" role="form">
							<div class="form-group">
								<div class="col-xs-3">
									<label class="lblModalDetalleVenta control-label" for="">Documento pago</label>
								</div>
								<div class="col-xs-3">
									<select id="selDocPago" class="form-control"></select>
								</div>
								<div class="col-xs-2">
									<label class="control-label" for="">Número</label>
								</div>
								<div class="col-xs-3">
									<input type="number" id="inpNumeroDocPago" class="form-control" min="0">
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label class="lblModalDetalleVenta control-label" for="">Medio de pago</label>
								</div>
								<div class="col-xs-3">
									<select id="selMedioPago" class="form-control"></select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label class="lblModalDetalleVenta control-label" for="">Monto total</label>
								</div>
								<div class="col-xs-3">
									<input type="number" id="inpMontoTotal" class="form-control" disabled="disabled">
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-3">
									<label class="lblModalDetalleVenta control-label" for="">Paga con</label>
								</div>
								<div class="col-xs-3">
									<input type="number" id="inpPagaCon" class="form-control" min="0">
								</div>
								<div class="col-xs-2">
									<label class="lblModalDetalleVenta control-label" for="">Vuelto</label>
								</div>
								<div class="col-xs-3">
									<input type="number" id="inpVuelto" class="form-control">
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="modal-footer">
					<button id="btnAnularVenta" class="btn btn-danger" data-dismiss="modal">Anular</button>
					<button id="btnPagarVenta" class="btn btn-success" data-dismiss="modal">Pagar</button>
					<button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	<!-- FIN VENTANA MODAL -->

	<!-- VENTANA MODAL DETALLES DE LAS VENTAS DEL DIA -->
	<div class="modal fade" id="modalDetallesVentasDelDia" tabindex="-1" role="dialog" aria-labelleby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button typ="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4>DETALLES DE LA VENTAS DEL DÍA <strong><span class="spnFechaDetallesVentaDelDia"></span></strong></h4>
				</div>
				<div id="zonaImprimibleDetallesVentasDelDia" >
					<h4 id="tituloImprimibleDetallesVentasDia" style="display: none">RESUMEN CIERRE DE CAJA DEL DIA <strong><span class="spnFechaDetallesVentaDelDia"></span></strong></h4>
					<div class="modal-body">
						<h4>Por documento de venta</h4>
						<table id="tablaVentasDiaPorDocumento" class="table table-hover">
							<thead>
								<tr style="color:#136E6A">
									<th>Documento</th>
									<th>Rango boletas</th>
									<th>Total (+ IVA)</th>
								</tr>
							</thead>
							<tbody id="cuerpoTablaVentasDiaPorDocumento" class="cuerpoTablaVentasDiaPorDocumento">
								<!--<tr>
									<td>Boletas</td>
									<td>$ 112.300</td>
								</tr>-->
							</tbody>
						</table>

						<hr>

						<h4>Por medio de pago</h4>

						<table id="tablaVentasDiaPorMedioDePago" class="table table-hover">
							<thead>
								<tr style="color:#136E6A">
									<th>Medio de pago</th>
									<th>Total (+ IVA)</th>
								</tr>
							</thead>
							<tbody id="cuerpoTablaVentasDiaPorMedioDePago" class="cuerpoTablaVentasDiaPorMedioDePago">
								<!-- <tr>
									<td>Efectivo</td>
									<td>$ 112.300</td>
								</tr>-->
							</tbody>
						</table>

						<hr>

						<h4>Por vendedor</h4>

						<table id="tablaVentasDiaPorVendedor" class="table table-hover">
							<thead>
								<tr style="color:#136E6A">
									<th>Vendedor</th>
									<th>Total (+ IVA)</th>
								</tr>
							</thead>
							<tbody id="cuerpoTablaVentasDiaPorVendedor" class="cuerpoTablaVentasDiaPorVendedor">
								<!-- <tr>
									<td>Antonio</td>
									<td>$ 112.300</td>
								</tr>-->
							</tbody>
						</table>

						<hr>

						<h4>Clientes atendidos por vendedor</h4>

						<table id="tablaClientesAtendidosPorVendedor" class="table table-hover">
							<thead>
								<tr style="color:#136E6A">
									<th>Vendedor</th>
									<th>Clientes atendidos</th>
								</tr>
							</thead>
							<tbody id="cuerpoTablaClientesAtendidosPorVendedor" class="cuerpoTablaClientesAtendidosPorVendedor">
								<!-- <tr>
									<td>Antonio</td>
									<td>5</td>
								</tr>-->
							</tbody>
						</table>
					</div>
				</div>

				<div class="modal-footer">
					<button id="btnImprimirDetallesVentasDelDia" class="btn btn-default"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
					<button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	<!-- FIN VENTANA MODAL -->

	<!-- VENTANA MODAL DETALLES DE LAS VENTAS DEL DIA -->
	<div class="modal fade" id="modalDetallesVentasDelMes" tabindex="-1" role="dialog" aria-labelleby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button typ="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4>DETALLES DE LA VENTAS DEL MES <strong><span class="spnFechaDetallesVentaDelMes"></span></strong></h4>
				</div>
				<div id="zonaImprimibleDetallesVentasDelMes" >
					<h4 id="tituloImprimibleDetallesVentasMes" style="display: none">RESUMEN DEL MES <strong><span class="spnMesDetallesVentaDelMes"></span></strong></h4>
					<div class="modal-body">
						<h4>Por documento de venta</h4>
						<table id="tablaVentasMes" class="table table-hover">
							<thead>
								<tr style="color:#136E6A">
									<th>Día</th>
									<th>Total venta diaria</th>
									<th>Total boleta</th>
									<th>Rango boletas</th>
									<th>Total factura</th>
									<th>Alvaro</th>
									<th>Marysol</th>
								</tr>
							</thead>
							<tbody id="cuerpoTablaVentasMes" class="cuerpoTablaVentasMes">
								<!--<tr>
									<td>Boletas</td>
									<td>$ 112.300</td>
								</tr>-->
							</tbody>
						</table>

				<div class="modal-footer">
					<button id="btnImprimirDetallesVentasDelMes" class="btn btn-default"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>
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
	<script src="js/funcionesVentas.js"></script>
	<!-- PRINT AREA PLUGIN DE JQUERY -->
    <script src="jq/jquery.PrintArea.js"></script>
	<script>
	$(document).ready(obtenerFechaActual("#inpFecha"));
	$(document).ready(cargarTotalVentasDelDia);

	$(document).ready(abrirModalDetallesVentasDelDia);
	
	$(document).ready(abrirModalDetallesVentasDelMes);
	$(document).ready(cargarDetallesVentasDelMes);

	$(document).ready(cargarVentas);
	$(document).ready(mostrarVentasAlCambiarFecha);
	$(document).ready(cargarDetallesVenta);
	$(document).ready(cargarDocumentosYMediosDePago);
	$(document).ready(calcularVuelto);
	$(document).ready(establecerVentaPagada);
	$(document).ready(anularVenta);
	$(document).ready(imprimirDetallesVentasDelDia);
	</script>
</body>
</html>