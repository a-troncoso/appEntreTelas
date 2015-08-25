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

function cargarTodosVendedores(){
	$.ajax({
		data:({rutVendedorPHP: '%%'}),
		dataType: 'json',
		timeout: 6000,
		type: 'POST',
		url: 'php/consultaVendedores.php',
		error: function(jqXHR,text_status,strError){
			$("#cuerpoTablaVendedores").html("");
			alert("Ha habido un error al cargar los Vendedores: " + strError);
		},
		success: function(data){
			$("#cuerpoTablaVendedores").html("");
			for(var i in data){
				$('#cuerpoTablaVendedores').append(
					"<tr>" +
						"<td>" + separarMiles(data[i][0].substring(0, data[i][0].length-1)) + "-" + data[i][0].substring(data[i][0].length-1, data[i][0].length) +"</td>" +
						"<td>" + data[i][1] + "</td>" +
						"<td>" + data[i][2] + "</td>" +
						"<td>" + data[i][3] + "</td>" +
						"<td>" + data[i][4] + "</td>" +
						// "<td><button type='button' id='" + data[i][0] + "' class='editarVendedor btn btn-warning' data-toggle='modal'>Editar</button></td>" +
					"</tr>");
			}
		}
	});
}

function abrirModalNuevoVendedor(){
	$("#btnNuevoVendedor").click(function(){
		$("#modalIngresarVendedor").modal("show");
		$("#alertFaltaRellenar").css('display', 'none');
		verificaDigitoVerificador("#inpCodVerificadorNuevoVendedor");
		verificaDigitoVerificador("#inpRutNuevoVendedor");
	});

	

	// Este evento fuerza a que el input "inpNombreProducto" tenga el foco despues de abrir el modal
	$('#modalIngresarVendedor').on('shown.bs.modal', function () {
		$('#inpRutNuevoVendedor').focus();
	});
}

function verificaDigitoVerificador(contenedorModificado){
	$(contenedorModificado).on("input", function(){
		var digitoVerificador = calculaDigitoVerificador($("#inpRutNuevoVendedor").val());
		if (digitoVerificador != $("#inpCodVerificadorNuevoVendedor").val()) {
			$("#inpCodVerificadorNuevoVendedor").css("background-color", "#F2DEDE");
		}else{
			$("#inpCodVerificadorNuevoVendedor").css("background-color", "#fff");
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

function ingresarNuevoVendedor(){
	$("#btnIngresarVendedor").click(function(){
		var rutNuevoVendedor = $("#inpRutNuevoVendedor").val() + $("#inpCodVerificadorNuevoVendedor").val();
		var nombreNuevoVendedor = $("#inpNombreNuevoVendedor").val();
		var apellidoPatNuevoVendedor = $("#inpApellidoPaternoNuevoVendedor").val();
		var apellidoMatNuevoVendedor = $("#inpApellidoMaternoNuevoVendedor").val();
		var emailNuevoVendedor = $("#inpEmailNuevoVendedor").val();

		if (rutNuevoVendedor != ""
			&& nombreNuevoVendedor != ""
			&& apellidoPatNuevoVendedor != ""
			&& apellidoMatNuevoVendedor != ""
			&& emailNuevoVendedor != "")
		{
			$.ajax({
				data:({rutNuevoVendedorPHP: rutNuevoVendedor,
					nombreNuevoVendedorPHP: nombreNuevoVendedor,
					apellidoPatNuevoVendedorPHP: apellidoPatNuevoVendedor,
					apellidoMatNuevoVendedorPHP: apellidoMatNuevoVendedor,
					emailNuevoVendedorPHP: emailNuevoVendedor}),
				dataType: 'text',
				timeout: 60000,
				type: 'POST',
				url: 'php/insertaVendedor.php',
				error: function(jqXHR,text_status,strError){
					$("#cuerpoTablaProductos").val("");
					alert("Ha habido un error al ingresar el Vendedor: " + strError);
				},
				success: function(data){
					$("#inpRutNuevoVendedor").val("");
					$("#inpCodVerificadorNuevoVendedor").val("");
					$("#inpNombreNuevoVendedor").val("");
					$("#inpApellidoPaternoNuevoVendedor").val("");
					$("#inpApellidoMaternoNuevoVendedor").val("");
					$("#inpEmailNuevoVendedor").val("");
					$('#modalIngresarVendedor').modal('hide');
					alert(data);
					cargarTodosVendedores();
				}
			});
		}else{
			$("#alertFaltaRellenar").css('display', 'block');
		}
	});
}
// function abrirModalEditarVendedor(){
// 	$("#cuerpoTablaVendedores").on("click", ".editarVendedor", function(){
// 		$("#modalEditarPoveedor").modal("show");
// 		$("#alertFaltaRellenarModalEditarVendedor").css("display", "none");
// 		$("#alertConfirmaEliminarVendedor").css("display", "none");

// 		rutVendedorAEditar = $(this).attr('id');

// 		$.ajax({
// 			data:({rutVendedorPHP: rutVendedorAEditar}),
// 			dataType: 'json',
// 			timeout: 60000,
// 			type: 'POST',
// 			url: 'php/consultaVendedores.php',
// 			error: function(jqXHR,text_status,strError){
// 				$("#inpNombreVendedorAEditar").val("");
// 				$("#inpGiroVendedorAEditar").val("");
// 				$("#inpDireccionVendedorAEditar").val("");
// 				$("#selRegionVendedorAEditar").html("");
// 				$("#selComunaVendedorAEditar").html("");
// 				$("#inpTelefonoVendedorAEditar").val("");
// 				$("#inpEmailVendedorAEditar").val("");
// 				alert("Ha habido un error al cargar los datos del proeveedor: " + strError);
// 			},
// 			success: function(data){
				
// 				$("#inpNombreVendedorAEditar").val("");
// 				$("#inpGiroVendedorAEditar").val("");
// 				$("#inpDireccionVendedorAEditar").val("");
// 				$("#selRegionVendedorAEditar").html("");
// 				$("#selComunaVendedorAEditar").html("");
// 				$("#inpTelefonoVendedorAEditar").val("");
// 				$("#inpEmailVendedorAEditar").val("");

// 				$("#inpNombreVendedorAEditar").val(data[0][1]);
// 				$("#inpGiroVendedorAEditar").val(data[0][2]);
// 				$("#inpDireccionVendedorAEditar").val(data[0][3]);

// 				$("#selRegionVendedorAEditar").html("<option>" + data[0][4] + "</option>");
// 				$("#selComunaVendedorAEditar").html("<option>" + data[0][5] + "</option>");

// 				$("#inpTelefonoVendedorAEditar").val(data[0][6]);
// 				$("#inpEmailVendedorAEditar").val(data[0][7]);
// 			}
// 		});
// 	});
// }

// function editarProducto(){
// 	$("#btnActualizarVendedor").click(function(){
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