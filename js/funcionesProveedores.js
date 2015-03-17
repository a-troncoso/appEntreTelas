var codProductoAEditar;

function separarMiles(valor) {
	var nums = new Array();
	var simb = "."; //Éste es el separador
	valor = valor.toString();
	valor = valor.replace(/\D/g, "");   //Ésta expresión regular solo permitira ingresar números
	nums = valor.split(""); //Se vacia el valor en un arreglo
	var long = nums.length - 1; // Se saca la longitud del arreglo
	var patron = 3; //Indica cada cuanto se ponen las comas
	var prox = 2; // Indica en que lugar se debe insertar la siguiente coma
	var res = "";

	while (long > prox) {
		nums.splice((long - prox),0,simb); //Se agrega la coma
		prox += patron; //Se incrementa la posición próxima para colocar la coma
	}

	for (var i = 0; i <= nums.length-1; i++) {
		res += nums[i]; //Se crea la nueva cadena para devolver el valor formateado
	}

	return res;
}

function cargarTodosProveedores(){
	$.ajax({
		data:({nombreProductoPHP: '', codProductoPHP: '%%'}),
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaProveedores.php',
		error: function(jqXHR,text_status,strError){
			$("#cuerpoTablaProveedores").html("");
			alert("Ha habido un error al cargar los proveedores: " + strError);
		},
		success: function(data){
			$("#cuerpoTablaProveedores").html("");
			for(var i in data){
				$('#cuerpoTablaProveedores').append(
					"<tr>" +
						"<td>" + separarMiles(data[i][0].substring(0, data[i][0].length-1)) + "-" + data[i][0].substring(data[i][0].length-1, data[i][0].length) +"</td>" +
						"<td>" + data[i][1] + "</td>" +
						"<td>" + data[i][2] + "</td>" +
						"<td>" + data[i][3] + "</td>" +
						"<td>" + data[i][4] + "</td>" +
						"<td>" + data[i][5] + "</td>" +
						"<td><button type='button' id='" + data[i][0] + "' class='editarProveedor btn btn-warning' data-toggle='modal'>Editar</button></td>" +
					"</tr>");
			}
			$('#cuerpoTablaProveedores').append(
				"<tr>" +
					"<td><button type='button' id='' class='btnNuevoProveedor btn btn-primary' data-toggle='modal'>Nuevo</button></td>" +
					"<td></td>" +
					"<td></td>" +
					"<td></td>" +
					"<td></td>" +
					"<td></td>" +
					"<td></td>" +
				"</tr>"
			);
		}
	});
}

function abrirModalNuevoProveedor(){
	$("#cuerpoTablaProveedores").on('click', '.btnNuevoProveedor', function(){
		$("#modalIngresarProveedor").modal("show");
		$("#alertFaltaRellenar").css('display', 'none');
		verificaDigitoVerificador("#inpCodVerificadorNuevoProveedor");
		verificaDigitoVerificador("#inpRutNuevoProveedor");
		cargarRegiones();
		cargarComunas();
	});

	// Este evento fuerza a que el input "inpNombreProducto" tenga el foco despues de abrir el modal
	$('#modalIngresarProveedor').on('shown.bs.modal', function () {
		$('#inpRutProveedor').focus();
	});
}

function cargarRegiones(){
	$.ajax({
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaRegionesChile.php',
		error: function(jqXHR,text_status,strError){
			$("#selRegionNuevoProveedor").html("");
			alert("Ha habido un error al cargar las regiones: " + strError);
		},
		success: function(data){
			$("#selRegionNuevoProveedor").html("");
			$("#selRegionNuevoProveedor").append("<option value='seleccione' disabled='disabled' selected='selected'>Seleccione una región</option>");
			for(var i in data){
				$("#selRegionNuevoProveedor").append("<option value='" + data[i][0] + "'>" + data[i][1] + "</option>");
			}
		}
	});
}

function cargarComunas(){
	$("#selRegionNuevoProveedor").change(function(){
		var regionSeleccionada = $("#selRegionNuevoProveedor").val();
		$.ajax({
			data:({regionSeleccionadaPHP: regionSeleccionada}),
			dataType: 'json',
			timeout: 60000,
			type: 'POST',
			url: 'php/consultaComunasChile.php',
			error: function(jqXHR,text_status,strError){
				$("#selComunaNuevoProveedor").html("");
				alert("Ha habido un error al cargar las comunas: " + strError);
			},
			success: function(data){
				$("#selComunaNuevoProveedor").html("");
				$("#selComunaNuevoProveedor").append("<option value='seleccione' disabled='disabled' selected='selected'>Seleccione una comuna</option>");
				for(var i in data){
					$("#selComunaNuevoProveedor").append("<option value='" + data[i][0] + "'>" + data[i][1] + "</option>");
				}
			}
		});
	});
}

function verificaDigitoVerificador(contenedorModificado){
	$(contenedorModificado).on("input", function(){
		var digitoVerificador = calculaDigitoVerificador($("#inpRutNuevoProveedor").val());
		if (digitoVerificador != $("#inpCodVerificadorNuevoProveedor").val()) {
			$("#inpCodVerificadorNuevoProveedor").css("background-color", "#F2DEDE");
		}else{
			$("#inpCodVerificadorNuevoProveedor").css("background-color", "#fff");
		}
	});
}

function calculaDigitoVerificador(rut){

	if (!rut || !rut.length || typeof rut !== 'string') {
		return -1;
	}
	// serie numerica
	var secuencia = [2,3,4,5,6,7,2,3];
	var sum = 0;
	//
	for (var i=rut.length - 1; i >=0; i--) {
		var d = rut.charAt(i);
		sum += new Number(d)*secuencia[rut.length - (i + 1)];
	}
	// sum mod 11
	var rest = 11 - (sum % 11);
	// si es 11, retorna 0, sino si es 10 retorna K,
	// en caso contrario retorna el numero
	return rest === 11 ? 0 : rest === 10 ? "K" : rest;
}

function ingresarNuevoProveedor(){
	$("#btnIngresarProveedor").click(function(){
		var rutNuevoProveedor = $("#inpRutNuevoProveedor").val() + $("#inpCodVerificadorNuevoProveedor").val();
		var nombreNuevoProveedor = $("#inpNombreNuevoProveedor").val();
		var giroNuevoProveedor = $("#inpGiroNuevoProveedor").val();
		var direccionNuevoProveedor = $("#inpDireccionNuevoProveedor").val();
		var regionNuevoProveedor = $("#selRegionNuevoProveedor").val();
		var comunaNuevoProveedor = $("#selComunaNuevoProveedor").val();
		var telefonoNuevoProveedor = $("#inpTelefonoNuevoProveedor").val();
		var emailNuevoProveedor = $("#inpEmailNuevoProveedor").val();
		if (rutNuevoProveedor != ""
			&& nombreNuevoProveedor != ""
			&& giroNuevoProveedor != ""
			&& direccionNuevoProveedor != ""
			&& regionNuevoProveedor != ""
			&& comunaNuevoProveedor != ""
			&& telefonoNuevoProveedor != ""
			&& emailNuevoProveedor != "" )
		{
			$.ajax({
				data:({rutNuevoProveedorPHP: rutNuevoProveedor,
					nombreNuevoProveedorPHP: nombreNuevoProveedor,
					giroNuevoProveedorPHP: giroNuevoProveedor,
					direccionNuevoProveedorPHP: direccionNuevoProveedor,
					regionNuevoProveedorPHP: regionNuevoProveedor,
					comunaNuevoProveedorPHP: comunaNuevoProveedor,
					telefonoNuevoProveedorPHP: telefonoNuevoProveedor,
					emailNuevoProveedorPHP: emailNuevoProveedor}),
				dataType: 'text',
				timeout: 60000,
				type: 'POST',
				url: 'php/insertaProveedor.php',
				error: function(jqXHR,text_status,strError){
					$("#cuerpoTablaProductos").val("");
					alert("Ha habido un error al ingresar el proveedor: " + strError);
				},
				success: function(data){
					$("#inpRutNuevoProveedor").val("");
					$("#inpCodVerificadorNuevoProveedor").val("");
					$("#inpNombreNuevoProveedor").val("");
					$("#inpGiroNuevoProveedor").val("");
					$("#inpDireccionNuevoProveedor").val("");
					$("#selRegionNuevoProveedor").val("");
					$("#selComunaNuevoProveedor").val("");
					$("#inpTelefonoNuevoProveedor").val("");
					$("#inpEmailNuevoProveedor").val("");
					$('#modalIngresarProveedor').modal('hide');
					alert(data);
					cargarTodosProveedores();
				}
			});
		}else{
			$("#alertFaltaRellenar").css('display', 'block');
		}
	});
}

// function calcularValorBrutoProducto(contenedorModificado, contenedorCalculado){
// 	$(contenedorModificado).on('input', function(){
// 		$(contenedorCalculado).val(Math.round(parseInt($(contenedorModificado).val()) + (parseInt($(contenedorModificado).val()) * 0.19)));
// 	});
// }
// function calcularValorNetoProducto(contenedorModificado, contenedorCalculado){
// 	$(contenedorModificado).on('input', function(){
// 		$(contenedorCalculado).val(Math.round(parseInt($(contenedorModificado).val()) / (1.19)));
// 	});
// }

// function abrirModalEditarProducto(){
// 	$("#cuerpoTablaProductos").on("click", ".editarProducto", function(){
// 		$("#modalEditarProducto").modal("show");
// 		$("#alertFaltaRellenarModalEditarProducto").css("display", "none");
// 		$("#alertConfirmaEliminarProducto").css("display", "none");

// 		codProductoAEditar = $(this).attr('id');
// 		// console.log(codProducto);

// 		$.ajax({
// 			data:({nombreProductoPHP: '', codProductoPHP: codProductoAEditar}),
// 			dataType: 'json',
// 			timeout: 60000,
// 			type: 'POST',
// 			url: 'php/consultaProductos.php',
// 			error: function(jqXHR,text_status,strError){
// 				$("#inpNombreProductoAEditar").val("");
// 				$("#inpValorNetoVentaProductoAEditar").val("");
// 				$("#inpValorBrutoVentaAEditar").val("");
// 				alert("Ha habido un error al cargar los datos del producto: " + strError);
// 			},
// 			success: function(data){
// 				$("#inpNombreProductoAEditar").val("");
// 				$("#inpValorNetoVentaProductoAEditar").val("");
// 				$("#inpValorBrutoVentaAEditar").val("");

// 				$("#inpNombreProductoAEditar").val(data[0][1]);
// 				$("#inpValorNetoVentaProductoAEditar").val(data[0][2]);
// 				$("#inpValorBrutoVentaAEditar").val(data[0][4]);
// 			}
// 		});
// 	});
// }

// function editarProducto(){
// 	$("#btnActualizarProducto").click(function(){
// 		var nuevoNombreProducto = $("#inpNombreProductoAEditar").val();
// 		var nuevoValorNetoVentaProducto = $("#inpValorNetoVentaProductoAEditar").val();

// 		// console.log(codProductoAEditar);

// 		if (nuevoNombreProducto != "" && nuevoValorNetoVentaProducto != ""){
// 			$.ajax({
// 				data:({codProductoAEditarPHP: codProductoAEditar,
// 					nuevoNombreProductoPHP: nuevoNombreProducto,
// 					nuevoValorNetoVentaProductoPHP: nuevoValorNetoVentaProducto}),
// 				dataType: 'text',
// 				timeout: 60000,
// 				type: 'POST',
// 				url: 'php/actualizaProducto.php',
// 				error: function(jqXHR,text_status,strError){
// 					$("#inpNombreProductoAEditar").val("");
// 					$("#inpValorNetoVentaProductoAEditar").val("");
// 					$("#inpValorBrutoVentaAEditar").val("");
// 					alert("Ha habido un error al editar el producto: " + strError);
// 				},
// 				success: function(data){
// 					$("#inpNombreProductoAEditar").val("");
// 					$("#inpValorNetoVentaProductoAEditar").val("");
// 					$("#inpValorBrutoVentaAEditar").val("");
// 					$('#modalEditarProducto').modal('hide');
// 					alert(data);
// 					cargarTodosProductos();
// 				}
// 			});
// 		}else{
// 			$("#alertFaltaRellenarModalEditarProducto").css('display', 'block');
// 		}
// 	});
// }

// function mostrarAlertEliminarProducto(){
// 	$("#btnEliminarProducto").click(function(){
// 		$("#alertConfirmaEliminarProducto").css("display", "block");
// 	});
// }
// function eliminarProducto(){
// 	$("#btnSiEliminarProducto").click(function(){
// 		$.ajax({
// 			data:({codProductoAEliminarPHP: codProductoAEditar}),
// 			dataType: 'text',
// 			timeout: 60000,
// 			type: 'POST',
// 			url: 'php/eliminaProducto.php',
// 			error: function(jqXHR,text_status,strError){
// 				$("#inpNombreProductoAEditar").val("");
// 				$("#inpValorNetoVentaProductoAEditar").val("");
// 				$("#inpValorBrutoVentaAEditar").val("");
// 				alert("Ha habido un error al eliminar el producto: " + strError);
// 			},
// 			success: function(data){
// 				$("#inpNombreProductoAEditar").val("");
// 				$("#inpValorNetoVentaProductoAEditar").val("");
// 				$("#inpValorBrutoVentaAEditar").val("");
// 				$('#modalEditarProducto').modal('hide');
// 				alert(data);
// 				cargarTodosProductos();
// 			}
// 		});
// 	});
// }