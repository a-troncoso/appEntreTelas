<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Productos</title>
	<style type="text/css">
	.numeros{
		text-align: right;
	}
	</style>
</head>
<body>
<div class="container">
	<button type='button' id='btnNuevoProducto' class='btnNuevoProducto btn btn-primary' data-toggle='modal'><i class="fa fa-plus"></i> Nuevo</button>
	<div class="row" >
		<div class="col-md-12">
			<table id="tabla" class="table table-hover">
				<thead>
					<tr>
						<th class="numeros">CÓDIGO</th>
						<th>NOMBRE</th>
						<th class="numeros">VALOR NETO VENTA</th>
						<th class="numeros">VALOR VENTA</th>
						<th class="numeros">EDITAR</th>
					</tr>
				</thead>
				<tbody id="cuerpoTablaProductos" class="cuerpoTablaProductos"></tbody>
			</table>
		</div>
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
					<div id="alertaModalIngresarProducto" class="alert alert-danger" role="alert"></div>

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
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpStockCriticoProducto">Stock crítico</label>
									<div class="col-md-7">
										<input id="inpStockCriticoProducto" class="form-control input-md" name="inpStockCriticoProducto" type="number" min="0" value="25">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpImagenProducto">Imagen</label>
	                    			<div class="col-xs-7">
	                    				<input type="file" id="inpImagenProducto" class="filestyle form-control" name="inpImagenProducto">
	                    				<span class="help-block">IMPORTANTE: La imagen debe ser cuadrada y en formato JPG.</span>
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

	<!-- VENTANA MODAL EDITAR PRODUCTO -->
	<div class="modal fade" id="modalEditarProducto" tabindex="-1" role="dialog" aria-labelleby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4>EDITAR PRODUCTO</h4>
				</div>
				<div class="modal-body">
					<div id="alertaModalEditar" class="alert alert-danger" role="alert"></div>

					<div id="alertConfirmaEliminarProducto" class="alert alert-danger" role="alert">
						<p>¿Realmente desea eliminar este producto?</p>
						<p>
							<button id="btnSiEliminarProducto" type="button" class="btn btn-danger">Si</button>
							<button id="btnNoEliminarProducto" type="button" class="btn btn-default">No</button>
						</p>
					</div>

					<div class="row">
	                    <div class="col-md-12">
		                    <form class="form-horizontal">
		                    	<div class="form-group">
		                    		<label class="col-md-4 control-label" for="inpCodigoProductoAEditar">Código</label>
		                    		<div class="col-md-7">
		                    			<input id="inpCodigoProductoAEditar" name="inpCodigoProductoAEditar" type="text" class="form-control input-md">
		                    		</div>
		                    	</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpNombreProductoAEditar">Nombre</label>
									<div class="col-md-7">
										<input id="inpNombreProductoAEditar" name="inpNombreProductoAEditar" type="text" class="form-control input-md">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpValorNetoVentaProductoAEditar">Valor neto venta</label>
									<div class="col-md-7">
										<input id="inpValorNetoVentaProductoAEditar" name="inpValorNetoVentaProductoAEditar" type="number" class="form-control input-md">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpValorBrutoVentaAEditar">Valor bruto venta</label>
									<div class="col-md-7">
										<input id="inpValorBrutoVentaAEditar" class="form-control input-md" name="inpValorBrutoVentaAEditar" type="number" >
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpStockCriticoProductoAEditar">Stock crítico</label>
									<div class="col-md-7">
										<input id="inpStockCriticoProductoAEditar" class="form-control input-md" name="inpStockCriticoProductoAEditar" type="number" min="0">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpImagenProductoAEditar">Imagen</label>
	                    			<div class="col-xs-7">
	                    				<input type="file" id="inpImagenProductoAEditar" class="filestyle form-control" name="inpImagenProductoAEditar">
	                    				<span class="help-block">IMPORTANTE: La imagen debe ser cuadrada y en formato JPG.</span>
	                    			</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="btnEliminarProducto" class="btn btn-danger">Eliminar</button>
					<button id="btnActualizarProducto" class="btn btn-success">Actualizar</button>
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
	<script src="js/funcionesProductos.js"></script>
	<script>
	$(document).ready(cargarTodosProductos);
	$(document).ready(abrirModalNuevoProducto);
	$(document).ready(calcularValorBrutoProducto("#inpValorNetoVentaProducto", "#inpValorBrutoVenta"));
	$(document).ready(calcularValorNetoProducto("#inpValorBrutoVenta", "#inpValorNetoVentaProducto"));
	$(document).ready(ingresarNuevoProducto);

	$(document).ready(mostrarAlertEliminarProducto);
	$(document).ready(ocultarAlertEliminarProducto);
	$(document).ready(eliminarProducto);

	$(document).ready(abrirModalEditarProducto);
	$(document).ready(calcularValorBrutoProducto("#inpValorNetoVentaProductoAEditar", "#inpValorBrutoVentaAEditar"));
	$(document).ready(calcularValorNetoProducto("#inpValorBrutoVentaAEditar", "#inpValorNetoVentaProductoAEditar"));
	$(document).ready(editarProducto);
	</script>
</body>
</html>