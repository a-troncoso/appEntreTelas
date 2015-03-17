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

function obtenerFechaActual(inpDate){
	var fechaActual = new Date();
	var ano = fechaActual.getFullYear();
	var mes = fechaActual.getMonth() + 1;
	if (mes < 10) {mes = '0' + mes};
	var dia = fechaActual.getDate();
	if (dia < 10) {dia = '0' + dia};
	$(inpDate).val(ano + '-' + mes + '-' + dia);
}

function mostrarVentasAlCambiarFecha(){
	$("#inpFecha").change(function(){
		cargarVentas();
		cargarTotalVentasDelDia();
	});
}

function cargarTotalVentasDelDia(){
	var fechaVentas = $("#inpFecha").val();
	$.ajax({
		data: ({fechaVentasPHP: fechaVentas}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaTotalVentasDelDia.php',
		error: function(jqXHR,text_status,strError){
			$("#totalDia").html("");
			alert("Ha habido un error al consultar el total del dia: \n" + strError);
		},
		success: function(data){
			if (data.length > 0) {
				$("#totalDia").html(separarMiles(data[0][0]));
			}else{
				$("#totalDia").html("0");
			}
		}
	});
}

function abrirModalDetallesVentasDelDia(){
	$("#btnDetallesVentasDia").click(function(){
		$("#modalDetallesVentasDelDia").modal("show");
		// Obtengo el valor del input date
		var fechaSeleccionada = $("#inpFecha").val();
		// Transformo el valor de del input a array
		var arregloFecha = fechaSeleccionada.split("-");
		// Muestro primero el año-mes-dia
		$(".spnFechaDetallesVentaDelDia").html(arregloFecha[2]+"-"+arregloFecha[1]+"-"+arregloFecha[0]);
		cargarDetallesVentasDelDia();
	});
}

function cargarDetallesVentasDelDia(){
	var fechaVentas = $("#inpFecha").val();
	$.ajax({
		data: ({fechaVentasPHP: fechaVentas}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaVentasDiaPorDocumento.php',
		error: function(jqXHR,text_status,strError){
			$("#cuerpoTablaVentasDiaPorDocumento").html("");
			alert("Ha habido un error al consultar las ventas por documento de pago: \n" + strError);
		},
		success: function(data){
			$("#cuerpoTablaVentasDiaPorDocumento").html("");
			for(var i in data){
				$('#cuerpoTablaVentasDiaPorDocumento').append(
					"<tr>" +
						"<td>" + data[i][0] + "</td>" +
						"<td>" + data[i][1] + " - " + data[i][2] + "</td>" +
						"<td>$ " + separarMiles(data[i][3]) + "</td>" +
					"</tr>"
				);
			}
		}
	});
	$.ajax({
		data: ({fechaVentasPHP: fechaVentas}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaVentasDiaPorMedioPago.php',
		error: function(jqXHR,text_status,strError){
			$("#cuerpoTablaVentasDiaPorMedioDePago").html("");
			alert("Ha habido un error al consultar las ventas por medio de pago: \n" + strError);
		},
		success: function(data){
			$("#cuerpoTablaVentasDiaPorMedioDePago").html("");
			for(var i in data){
				$('#cuerpoTablaVentasDiaPorMedioDePago').append(
					"<tr>" +
						"<td>" + data[i][0] + "</td>" +
						"<td>$ " + separarMiles(data[i][1]) + "</td>" +
					"</tr>"
				);
			}
		}
	});
	$.ajax({
		data: ({fechaVentasPHP: fechaVentas}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaVentasDiaPorVendedor.php',
		error: function(jqXHR,text_status,strError){
			$("#cuerpoTablaVentasDiaPorVendedor").html("");
			alert("Ha habido un error al consultar las ventas por vendedor: \n" + strError);
		},
		success: function(data){
			$("#cuerpoTablaVentasDiaPorVendedor").html("");
			for(var i in data){
				$('#cuerpoTablaVentasDiaPorVendedor').append(
					"<tr>" +
						"<td>" + data[i][0] + "</td>" +
						"<td>$ " + separarMiles(data[i][1]) + "</td>" +
					"</tr>"
				);
			}
		}
	});
	$.ajax({
		data: ({fechaVentasPHP: fechaVentas}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaClientesAtendidosPorVendedor.php',
		error: function(jqXHR,text_status,strError){
			$("#cuerpoTablaClientesAtendidosPorVendedor").html("");
			alert("Ha habido un error al consultar la cantidad de clientes atendidos por vendedor: \n" + strError);
		},
		success: function(data){
			$("#cuerpoTablaClientesAtendidosPorVendedor").html("");
			for(var i in data){
				$('#cuerpoTablaClientesAtendidosPorVendedor').append(
					"<tr>" +
						"<td>" + data[i][0] + "</td>" +
						"<td>" + data[i][1] + "</td>" +
					"</tr>"
				);
			}
		}
	});
}

function abrirModalDetallesVentasDelMes(){
	$("#btnDetallesVentasMes").click(function(){
		$("#modalDetallesVentasDelMes").modal("show");
	});
}

function cargarDetallesVentasDelMes(){
	var mesVentas = $("#inpFecha").val();
	var arrayFecha = mesVentas.split("-");
	var mes = arrayFecha[1];
	console.log(mes);
	// $.ajax({
	// 	data: ({fechaVentasPHP: fechaVentas}),
	// 	dataType: 'json',
	// 	type: 'POST',
	// 	timeout: 60000,
	// 	url: 'php/consultaVentasDiaPorDocumento.php',
	// 	error: function(jqXHR,text_status,strError){
	// 		$("#cuerpoTablaVentasDiaPorDocumento").html("");
	// 		alert("Ha habido un error al consultar las ventas por documento de pago: \n" + strError);
	// 	},
	// 	success: function(data){
	// 		$("#cuerpoTablaVentasDiaPorDocumento").html("");
	// 		for(var i in data){
	// 			$('#cuerpoTablaVentasDiaPorDocumento').append(
	// 				"<tr>" +
	// 					"<td>" + data[i][0] + "</td>" +
	// 					"<td>" + data[i][1] + " - " + data[i][2] + "</td>" +
	// 					"<td>$ " + separarMiles(data[i][3]) + "</td>" +
	// 				"</tr>"
	// 			);
	// 		}
	// 	}
	// });
}
function imprimirDetallesVentasDelDia(){
	$("#btnImprimirDetallesVentasDelDia").click(function(){
		var options = { mode : "iframe", popClose : "true", extraCss : "", retainAttr : "", extraHead : '<meta charset="utf-8" />,<meta http-equiv="X-UA-Compatible" content="IE=edge"/>' };
		$("#tituloImprimibleDetallesVentasDia").css("display", "block");
		$("#zonaImprimibleDetallesVentasDelDia").printArea(options);
		$("#tituloImprimibleDetallesVentasDia").css("display", "none");
	});
}

function cargarVentas(){
	var fechaVentas = $("#inpFecha").val();
	$.ajax({
		data: ({fechaVentasPHP: fechaVentas}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaVentas.php',
		error: function(jqXHR,text_status,strError){
			$("#cuerpoTabla").html("");
			alert("No se han cargado las ventas: " + strError);
		},
		success: function(data){
			$("#cuerpoTabla").html("");
			for(var i in data){
				// Los pedidos pagados (estadoPagado = 1) se muestra el boton verde (con clase btn-success)
				if (data[i][3] == "1") {
					$('#cuerpoTabla').append(
						"<tr>" +
							"<td>" + data[i][0] + "</td>" +
							"<td>" + data[i][1] + "</td>" +
							"<td>$ " + separarMiles(data[i][2]) + "</td>" +
							"<td><button type='button' class='detallesVenta btn btn-success' data-toggle='modal' data-target='#modalDetallesVenta'>Detalles</button></td>" +
						"</tr>"
					);
				}else{
					// Los pedidos no pagados (estadoPagado = 0) se muestra la linea color mas oscura y con boton amarillo (con clase btn-warning)
					$('#cuerpoTabla').append(
						"<tr style='background-color: #CBF3F2'>" +
							"<td>" + data[i][0] + "</td>" +
							"<td>" + data[i][1] + "</td>" +
							"<td>$ " + separarMiles(data[i][2]) + "</td>" +
							"<td><button type='button' class='detallesVenta btn btn-warning' data-toggle='modal' data-target='#modalDetallesVenta'>Detalles</button></td>" +
						"</tr>"
					);
				}
			};
		}
	});
};

// MUESTRA LOS DETALLES DE LA VENTA EN EL MODAL DETALLES
function cargarDetallesVenta(){
	$('#cuerpoTabla').on('click', '.detallesVenta', function(){

		// Este evento fuerza a que el select "selDocPago" tenga el foco despues de abrir el modal
		$('#modalDetallesVenta').on('shown.bs.modal', function () {
		    $('#selDocPago').focus();
		});

		var numTicket = $(this).parents('tr').children(':eq(0)').html();
		// este ajax trae la cantidad, valor unitario, desc, valor neto, iva y total de cada producto vendido
		$.ajax({
			data:({numTicketPHP: numTicket}),
			dataType: 'json',
			timeout: 60000,
			type: 'POST',
			url: 'php/consultaDetallesVenta.php',
			error: function(jqXHR,text_status,strError){
				$('#cuerpoTablaDetalleVenta').html("");
				$("#numTicket").html("");
				alert("Ha habido un error al cargar los detalles de la venta: " + strError);
			},
			success: function(data){
				$('#cuerpoTablaDetalleVenta').html("");
				$("#numTicket").html("");
				// Arriba del modal, se indica el numero de ticket
				$("#numTicket").html(" " + numTicket);
				for(var i in data){
					// Si el valor descuento es mayor a cero se muestra en valor negativo
					if (data[i][3] > 0) {data[i][3] = data[i][3] * (-1)};
					$('#cuerpoTablaDetalleVenta').append(
						"<tr>" +
							"<td>" + data[i][0] + "</td>" +
							"<td>" + data[i][1] + "</td>" +
							"<td>$ " + separarMiles(data[i][2]) + "</td>" +
							"<td>" + data[i][3] + " %</td>" +
							"<td>$ " + separarMiles(data[i][4]) + "</td>" +
							"<td>$ " + separarMiles(data[i][5]) + "</td>" +
							"<td>$ " + separarMiles(data[i][6]) + "</td>" +
						"</tr>");
				}
			}
		});
		// este ajax trae los totales del valor neto, iva y total de cada producto vendido
		$.ajax({
			data:({numTicketPHP: numTicket}),
			dataType: 'json',
			timeout: 60000,
			type: 'POST',
			url: 'php/consultaTotalesDetallesVenta.php',
			error: function(jqXHR,text_status,strError){
				alert("Ha habido un error al cargar los totales del detalle de la venta: " + strError);
			},
			success: function(data){
					$('#cuerpoTablaDetalleVenta').append(
						"<tr>" +
							"<td><b>Totales</b></td>" +
							"<td></td>" +
							"<td></td>" +
							"<td></td>" +
							"<td>$ " + separarMiles(data[0][0]) + "</td>" +
							"<td>$ " + separarMiles(data[0][1]) + "</td>" +
							"<td>$ " + separarMiles(data[0][2]) + "</td>" +
						"</tr>");
				$("#inpMontoTotal").val((data[0][2])); // Al traer lo totales, tambien se rellena el campo monto total
				// Al traer lo totales, tambien se rellena el campo monto numero documento pago
				if (data[0][3] == 0) {
					$("#inpNumeroDocPago").val("");
				}else{
					$("#inpNumeroDocPago").val(data[0][3]);
				}
				$("#inpPagaCon").val(""); // Al traer lo totales, tambien se blanquea el campo paga con
				$("#inpVuelto").val(""); // Al traer lo totales, tambien se blanquea el campo vuelto
			}
		});
	});
}

function cargarDocumentosYMediosDePago(){
	$.ajax({
		url: 'php/consultaDocumentosDePago.php',
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		error: function(jqXHR,text_status,strError){
			$("#selDocPago").val("");
			alert("Ha habido un error al cargar los documentos y/o medios de pago: " + strError);
		},
		success: function(data){
			$("#selDocPago").val("");
			// Sólo muestro desde el registro 1 (el registro 0 dice 'sin definir') hasta el registro 3 (omite factura afecta y exenta)
			for (var i = 1; i <= data.length-3; i++) {
				$("#selDocPago").append("<option id='" + data[i][0] + "' value='" + data[i][0] + "'>" + data[i][1] + "</option>");
			}
		}
	});
	$.ajax({
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaMediosDePago.php',
		error: function(jqXHR,text_status,strError){
			$("#selMedioPago").val("");
			alert("Ha habido un error al cargar los documentos y/o medios de pago: " + strError);
		},
		success: function(data){
			$("#selMedioPago").val("");
			// Sólo muestro desde el registro 1 (el registro 0 dice 'sin definir')
			for (var i = 1; i <= data.length-1; i++) {
				$("#selMedioPago").append("<option id='" + data[i][0] + "' value='" + data[i][0] + "'>" + data[i][1] + "</option>");
			}
		}
	});
}

function calcularVuelto(){
	$("#inpPagaCon").on("input", function(){
		$("#inpVuelto").val(parseInt($(this).val()) - parseInt($("#inpMontoTotal").val()));
	});
};

function establecerVentaPagada(){
	$("#btnPagarVenta").click(function(){
		if ($("#inpNumeroDocPago").val() > 0 && $("#inpNumeroDocPago").val() != "") {
			// El numero ticket lo obtengo de lo q dice en la etiqueta con id numTicket
			var numTicket = $("#numTicket").html();
			var codDocPago = $("#selDocPago").val();
			var numDocPago = $("#inpNumeroDocPago").val();
			var codMedioPago = $("#selMedioPago").val();
			$.ajax({
				data: ({numTicketPHP: numTicket,
					codDocPagoPHP: codDocPago,
					numDocPagoPHP: numDocPago,
					codMedioPagoPHP: codMedioPago}),
				dataType: 'json',
				timeout: 60000,
				type: 'POST',
				url: 'php/actualizaVentaEstablecePagada.php',
				error: function(jqXHR,text_status,strError){
					alert("Ha habido un error al pagar la venta: \n" + strError);
				},
				success: function(data){
					$("#inpNumeroDocPago").val("");
					if (data["estado"] == 1) {alert(data["descripcion"]);}
					if (data["estado"] == 0) {alert(data["descripcion"]);}
					cargarTotalVentasDelDia();
					cargarVentas();
				}
			});
		}else{
			if ($("#inpNumeroDocPago").val() < 0) {alert("CORRIJA EL NÚMERO DE BOLETA.");}
			if ($("#inpNumeroDocPago").val() == "") {alert("DEBE INGRESAR EL NÚMERO DE BOLETA.");}
			$("#inpNumeroDocPago").val("");
		}
	});
}
function anularVenta(){
	$("#btnAnularVenta").click(function(){
		var numTicket = $("#numTicket").html();
		$.ajax({
			data: ({numTicketPHP: numTicket}),
			dataType: 'text',
			timeout: 60000,
			type: 'POST',
			url: 'php/eliminarAnularVenta.php',
			error: function(jqXHR,text_status,strError){
				alert("Ha habido un error al anular la venta: \n" + strError);
			},
			success: function(data){
				alert(data);
				cargarVentas();
			}
		});
	});
}