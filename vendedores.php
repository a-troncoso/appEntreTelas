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
	<title>Vendedores</title>
</head>
<body>
<div class="continer">
	<button type='button' id='btnNuevoVendedor' class='btnNuevoVendedor btn btn-primary' data-toggle='modal'><i class="fa fa-plus"></i> Nuevo</button>
	<div class="row" >
		<div class="col-md-12">
			<table id="tabla" class="table table-hover">
				<thead>
					<tr>
						<th>RUT</th>
						<th>NOMBRE</th>
						<th>APELLIDO PATERNO</th>
						<th>APELLIDO MATERNO</th>
						<th>EMAIL</th>
					</tr>
				</thead>
				<tbody id="cuerpoTablaVendedores" class="cuerpoTablaVendedores"></tbody>
			</table>
		</div>
	</div>
</div>

<!-- VENTANA MODAL INGRESAR VENDEDOR -->
<div class="modal fade" id="modalIngresarVendedor" tabindex="-1" role="dialog" aria-labelleby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>INGRESAR VENDEDOR</h4>
			</div>
			<div class="modal-body">
				<div id="alertFaltaRellenar" class="alert alert-danger" role="alert">
					<p><strong>Error: </strong>Faltan campos por rellenar.</p>
				</div>

				<div class="row">
                    <div class="col-md-12">
	                    <form class="form-horizontal">
							<div class="form-group">
								<label class="col-md-4 control-label" for="inpRutNuevoVendedor">Rut</label>
								<div class="col-xs-3">
									<div class="input-group">
										<input type="number" id="inpRutNuevoVendedor" class="form-control" min="0" style="width: 217px;">
										<span class="input-group-addon">-</span>
										<input type="number" id="inpCodVerificadorNuevoVendedor" class="form-control" min="0" style="width: 70px;">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="inpNombreNuevoVendedor">Nombre</label>
								<div class="col-md-7">
									<input id="inpNombreNuevoVendedor" class="form-control input-md" name="inpNombreNuevoVendedor" placeholder="Nombre nuevo Vendedor" type="text" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="inpApellidoPaternoNuevoVendedor">Apellido Paterno</label>
								<div class="col-md-7">
									<input id="inpApellidoPaternoNuevoVendedor" class="form-control input-md" name="inpApellidoPaternoNuevoVendedor" placeholder="Apellido Paterno nuevo Vendedor" type="text" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="inpApellidoMaternoNuevoVendedor">Apellido Materno</label>
								<div class="col-md-7">
									<input id="inpApellidoMaternoNuevoVendedor" class="form-control input-md" name="inpApellidoMaternoNuevoVendedor" placeholder="Apellido Materno nuevo Vendedor" type="text" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="inpEmailNuevoVendedor">Email</label>
								<div class="col-md-7">
									<input id="inpEmailNuevoVendedor" class="form-control input-md" name="inpEmailNuevoVendedor" type="email" >
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="btnIngresarVendedor" class="btn btn-success">Ingresar</button>
				<button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!-- FIN VENTANA MODAL -->

<!-- VENTANA MODAL EDITAR Vendedor -->
<!-- <div class="modal fade" id="modalEditarPoveedor" tabindex="-1" role="dialog" aria-labelleby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>EDITAR Vendedor</h4>
			</div>
			<div class="modal-body">
				<div id="alertFaltaRellenarModalEditarVendedor" class="alert alert-danger" role="alert">
					<p><strong>Error: </strong>Faltan campos por rellenar.</p>
				</div>

				<div id="alertConfirmaEliminarVendedor" class="alert alert-danger" role="alert">
					<p>¿Realmente desea eliminar este Vendedor?</p>
					<p>
						<button id="btnSiEliminarVendedor" type="button" class="btn btn-danger">Si</button>
						<button id="btnNoEliminarVendedor" type="button" class="btn btn-default">No</button>
					</p>
				</div>

				<div class="row">
                    <div class="col-md-12">
	                    <form class="form-horizontal">
							<div class="form-group">
								<label class="col-md-4 control-label" for="inpRutVendedorAEditar">Rut</label>
								<div class="col-xs-3">
									<div class="input-group">
										<input type="number" id="inpRutVendedorAEditar" class="form-control" min="0" style="width: 217px;">
										<span class="input-group-addon">-</span>
										<input type="number" id="inpCodVerificadorVendedorAEditar" class="form-control" min="0" style="width: 70px;">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="inpNombreVendedorAEditar">Nombre</label>
								<div class="col-md-7">
									<input id="inpNombreVendedorAEditar" class="form-control input-md" name="inpNombreVendedorAEditar" type="text" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="inpApellidoPaternoVendedorAEditar">Apellido Paterno</label>
								<div class="col-md-7">
									<input id="inpApellidoPaternoVendedorAEditar" class="form-control input-md" name="inpApellidoPaternoVendedorAEditar" type="text" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="inpApellidoMaternoVendedorAEditar">Apellido Materno</label>
								<div class="col-md-7">
									<input id="inpApellidoMaternoVendedorAEditar" class="form-control input-md" name="inpApellidoMaternoVendedorAEditar" placeholder="Apellido Materno nuevo Vendedor" type="text" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-4 control-label" for="inpEmailVendedorAEditar">Email</label>
								<div class="col-md-7">
									<input id="inpEmailVendedorAEditar" class="form-control input-md" name="inpEmailVendedorAEditar" type="email" >
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="btnEliminarVendedor" class="btn btn-danger">Eliminar</button>
				<button id="btnActualizarVendedor" class="btn btn-success">Actualizar</button>
				<button class="btn btn-primary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div> -->
<!-- FIN VENTANA MODAL -->
	

	<!--/////////////////-->
		<!-- SCRIPTS -->
	<!--/////////////////-->
	<script src="jq/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="js/funcionesVendedores.js"></script>
	<script>
	$(document).ready(cargarTodosVendedores);

	$(document).ready(abrirModalNuevoVendedor);
	$(document).ready(ingresarNuevoVendedor);
	// $(document).ready(abrirModalEditarVendedor);
	</script>
</body>
</html>