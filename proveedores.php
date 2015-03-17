<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Proveedores</title>
</head>
<body>
	<div class="row" >
		<div class="col-md-12">
			<table id="tabla" class="table table-hover">
				<thead>
					<tr>
						<th>RUT</th>
						<th>NOMBRE</th>
						<th>DIRECCION</th>
						<th>COMUNA</th>
						<th>TELEFONO</th>
						<th>EMAIL</th>
						<th>EDITAR</th>
					</tr>
				</thead>
				<tbody id="cuerpoTablaProveedores" class="cuerpoTablaProveedores"></tbody>
			</table>
		</div>
	</div>

	<!-- VENTANA MODAL INGRESAR PROVEEDOR -->
	<div class="modal fade" id="modalIngresarProveedor" tabindex="-1" role="dialog" aria-labelleby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4>INGRESAR PROVEEDOR</h4>
				</div>
				<div class="modal-body">
					<div id="alertFaltaRellenar" class="alert alert-danger" role="alert">
						<p><strong>Error: </strong>Faltan campos por rellenar.</p>
					</div>

					<div class="row">
	                    <div class="col-md-12">
		                    <form class="form-horizontal">
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpRutNuevoProveedor">Rut</label>
									<div class="col-xs-3">
										<div class="input-group">
											<input type="number" id="inpRutNuevoProveedor" class="form-control" min="0" style="width: 217px;">
											<span class="input-group-addon">-</span>
											<input type="number" id="inpCodVerificadorNuevoProveedor" class="form-control" min="0" style="width: 70px;">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpNombreNuevoProveedor">Nombre</label>
									<div class="col-md-7">
										<input id="inpNombreNuevoProveedor" class="form-control input-md" name="inpNombreNuevoProveedor" placeholder="Nombre nuevo proveedor" type="text" >
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpGiroNuevoProveedor">Giro</label>
									<div class="col-md-7">
										<input id="inpGiroNuevoProveedor" name="inpGiroNuevoProveedor" type="text" placeholder="Giro nuevo proveedor" class="form-control input-md">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpDireccionNuevoProveedor">Dirección</label>
									<div class="col-md-7">
										<input id="inpDireccionNuevoProveedor" class="form-control input-md" name="inpDireccionNuevoProveedor" placeholder="Dirección nuevo proveedor" type="text" >
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="selRegionNuevoProveedor">Región</label>
									<div class="col-md-7">
										<select id="selRegionNuevoProveedor" class="form-control"></select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="selComunaNuevoProveedor">Comuna</label>
									<div class="col-md-7">
										<select id="selComunaNuevoProveedor" class="form-control"></select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpTelefonoNuevoProveedor">Teléfono</label>
									<div class="col-md-7">
										<input id="inpTelefonoNuevoProveedor" class="form-control input-md" name="inpTelefonoNuevoProveedor" type="number">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpEmailNuevoProveedor">Email</label>
									<div class="col-md-7">
										<input id="inpEmailNuevoProveedor" class="form-control input-md" name="inpEmailNuevoProveedor" type="email" >
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="btnIngresarProveedor" class="btn btn-success">Ingresar</button>
					<button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	<!-- FIN VENTANA MODAL -->

	<!-- VENTANA MODAL EDITAR PROVEEDOR -->
	<div class="modal fade" id="modalEditarPoveedor" tabindex="-1" role="dialog" aria-labelleby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4>EDITAR PROVEEDOR</h4>
				</div>
				<div class="modal-body">
					<div id="alertFaltaRellenarModalEditarProveedor" class="alert alert-danger" role="alert">
						<p><strong>Error: </strong>Faltan campos por rellenar.</p>
					</div>

					<div id="alertConfirmaEliminarProveedor" class="alert alert-danger" role="alert">
						<p>¿Realmente desea eliminar este proveedor?</p>
						<p>
							<button id="btnSiEliminarProveedor" type="button" class="btn btn-danger">Si</button>
							<button id="btnNoEliminarProveedor" type="button" class="btn btn-default">No</button>
						</p>
					</div>

					<div class="row">
	                    <div class="col-md-12">
		                    <form class="form-horizontal">
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpNombreProveedorAEditar">Nombre</label>
									<div class="col-md-7">
										<input id="inpNombreProveedorAEditar" class="form-control input-md" name="inpNombreProveedorAEditar" type="text" >
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpGiroProveedorAEditar">Giro</label>
									<div class="col-md-7">
										<input id="inpGiroProveedorAEditar" name="inpGiroProveedorAEditar" type="text" class="form-control input-md">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpDireccionProveedorAEditar">Dirección</label>
									<div class="col-md-7">
										<input id="inpDireccionProveedorAEditar" class="form-control input-md" name="inpDireccionProveedorAEditar" type="number" >
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="selRegionProveedorAEditar">Región</label>
									<div class="col-md-7">
										<select id="selRegionProveedorAEditar" class="form-control"></select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="selComunaProveedorAEditar">Ciudad</label>
									<div class="col-md-7">
										<select id="selComunaProveedorAEditar" class="form-control"></select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpTelefonoProveedorAEditar">Teléfono</label>
									<div class="col-md-7">
										<input id="inpTelefonoProveedorAEditar" class="form-control input-md" name="inpTelefonoProveedorAEditar" type="number">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="inpEmailProveedorAEditar">Email</label>
									<div class="col-md-7">
										<input id="inpEmailProveedorAEditar" class="form-control input-md" name="inpEmailProveedorAEditar" type="email">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="btnEliminarProveedor" class="btn btn-danger">Eliminar</button>
					<button id="btnActualizarProveedor" class="btn btn-success">Actualizar</button>
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
	<script src="js/funcionesProveedores.js"></script>
	<script>
	$(document).ready(cargarTodosProveedores);

	$(document).ready(abrirModalNuevoProveedor);
	$(document).ready(ingresarNuevoProveedor);
	</script>
</body>
</html>