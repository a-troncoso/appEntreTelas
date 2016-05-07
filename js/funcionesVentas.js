var permisoEditar = false;
var fechaActual;
var ano;
var mes;
var dia;

function separarMiles(valor) {
	var nums = new Array();
	var simb = "."; //Éste es el separador
	valor = valor.toString();
	//Ésta expresión regular solo permitira ingresar números (la quité ya que no acepta negrativos)
	// valor = valor.replace(/\D/g, "");
	nums = valor.split(""); //Se vacia el valor en un arreglo
	var long = nums.length - 1; // Se saca la longitud del arreglo
	var patron = 3; //Indica cada cuanto se ponen las comas
	var prox = 2; // Indica en que lugar se debe insertar la siguiente coma
	var res = "";

	while (long > prox) {
		nums.splice((long - prox), 0, simb); //Se agrega la coma
		prox += patron; //Se incrementa la posición próxima para colocar la coma
	}

	for (var i = 0; i <= nums.length - 1; i++) {
		res += nums[i]; //Se crea la nueva cadena para devolver el valor formateado
	}

	return res;
}

function obtenerFechaActual(inpDate) {
	fechaActual = new Date();
	ano = fechaActual.getFullYear();
	mes = fechaActual.getMonth() + 1;
	if (mes < 10) {
		mes = '0' + mes
	}
	dia = fechaActual.getDate();
	if (dia < 10) {
		dia = '0' + dia
	}
	$(inpDate).val(ano + '-' + mes + '-' + dia);
}

function mostrarVentasAlCambiarFecha() {
	$("#inpFecha").change(function() {
		cargarVentas();
		cargarTotalVentasDelDia();
	});
}

function cargarTotalVentasDelDia() {
	var fechaVentas = $("#inpFecha").val();
	$.ajax({
		data: ({
			fechaVentasPHP: fechaVentas
		}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaTotalVentasDelDia.php',
		error: function(jqXHR, text_status, strError) {
			$("#totalDia").html("");
			alert("Ha habido un error al consultar el total del dia: \n" + strError);
		},
		success: function(data) {
			if (data.length > 0) {
				$("#totalDia").html(separarMiles(data[0][0]));
			} else {
				$("#totalDia").html("0");
			}
		}
	});
}

function abrirModalDetallesVentasDelDia() {
	$("#btnDetallesVentasDia").click(function() {
		$("#modalDetallesVentasDelDia").modal("show");
		// Obtengo el valor del input date
		var fechaSeleccionada = $("#inpFecha").val();
		// Transformo el valor de del input a array
		var arregloFecha = fechaSeleccionada.split("-");
		// Muestro primero el año-mes-dia
		$(".spnFechaDetallesVentaDelDia").html(arregloFecha[2] + "-" + arregloFecha[1] + "-" + arregloFecha[0]);
		cargarDetallesVentasDelDia();
		// REVISAAARR!!
		$("#selDocPago option[value='2']").attr("selected", true);
		$("#selMedioPago option[value='2']").attr("selected", true);
	});
}

function cargarDetallesVentasDelDia() {
	var fechaVentas = $("#inpFecha").val();
	// VENTAS DIARIAS POR DOCUMENTO
	$.ajax({
		async: false,
		data: ({
			fechaVentasPHP: fechaVentas
		}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaVentasDiaPorDocumento.php',
		error: function(jqXHR, text_status, strError) {
			$("#cuerpoTablaVentasDiaPorDocumento").html("");
			alert("Ha habido un error al consultar las ventas por documento de pago: \n" + strError);
		},
		success: function(data) {
			$("#cuerpoTablaVentasDiaPorDocumento").html("");
			for (var i in data) {
				$('#cuerpoTablaVentasDiaPorDocumento').append(
					"<tr id='" + data[i][4] + "' class='filasTablaVentasDiaPorDocumento'>" +
					"<td>" + data[i][0] + "</td>" +
					"<td>" + data[i][1] + " - " + data[i][2] + "</td>" +
					"<td class='numeros'>$ " + separarMiles(data[i][3]) + "</td>" +
					"</tr>"
				);
			}
		}
	});
	// TOTAL VENTAS DIARIAS POR DOCUMENTO
	$.ajax({
		async: false,
		data: ({
			fechaVentasPHP: fechaVentas
		}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaTotalVentasDiaPorDocumento.php',
		error: function(jqXHR, text_status, strError) {
			alert("Ha habido un error al consultar el total de las ventas por documento de pago: \n" + strError);
		},
		success: function(data) {
			if (data[0][0] == "") {
				data[0][0] = 0;
			}
			$('#cuerpoTablaVentasDiaPorDocumento').append(
				"<tr>" +
				"<td><strong>Total</strong></td>" +
				"<td></td>" +
				"<td class='numeros'><strong>$ " + separarMiles(data[0][0]) + "</strong></td>" +
				"</tr>"
			);
		}
	});
	// VENTAS DIARIAS POR MEDIO DE PAGO
	$.ajax({
		async: false,
		data: ({
			fechaVentasPHP: fechaVentas
		}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaVentasDiaPorMedioPago.php',
		error: function(jqXHR, text_status, strError) {
			$("#cuerpoTablaVentasDiaPorMedioDePago").html("");
			alert("Ha habido un error al consultar las ventas por medio de pago: \n" + strError);
		},
		success: function(data) {
			$("#cuerpoTablaVentasDiaPorMedioDePago").html("");
			for (var i in data) {
				$('#cuerpoTablaVentasDiaPorMedioDePago').append(
					"<tr>" +
					"<td>" + data[i][0] + "</td>" +
					"<td class='numeros'>$ " + separarMiles(data[i][1]) + "</td>" +
					"</tr>"
				);
			}
		}
	});
	// TOTAL VENTAS DIARIAS POR MEDIO DE PAGO
	$.ajax({
		async: false,
		data: ({
			fechaVentasPHP: fechaVentas
		}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaTotalVentasDiaPorMedioPago.php',
		error: function(jqXHR, text_status, strError) {
			alert("Ha habido un error al consultar el total de ventas por medio de pago: \n" + strError);
		},
		success: function(data) {
			if (data[0][0] == "") {
				data[0][0] = 0;
			}
			$('#cuerpoTablaVentasDiaPorMedioDePago').append(
				"<tr>" +
				"<td><strong>Total</strong></td>" +
				"<td class='numeros'><strong>$ " + separarMiles(data[0][0]) + "</strong></td>" +
				"</tr>"
			);
		}
	});
	// VENTAS DIARIAS POR VENDEDOR
	$.ajax({
		async: false,
		data: ({
			fechaVentasPHP: fechaVentas
		}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaVentasDiaPorVendedor.php',
		error: function(jqXHR, text_status, strError) {
			$("#cuerpoTablaVentasDiaPorVendedor").html("");
			alert("Ha habido un error al consultar las ventas por vendedor: \n" + strError);
		},
		success: function(data) {
			$("#cuerpoTablaVentasDiaPorVendedor").html("");
			for (var i in data) {
				$('#cuerpoTablaVentasDiaPorVendedor').append(
					"<tr>" +
					"<td>" + data[i][0] + "</td>" +
					"<td class='numeros'>$ " + separarMiles(data[i][1]) + "</td>" +
					"</tr>"
				);
			}
		}
	});
	// TOTAL VENTAS DIARIAS POR VENDEDOR
	$.ajax({
		async: false,
		data: ({
			fechaVentasPHP: fechaVentas
		}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaTotalVentasDiaPorVendedor.php',
		error: function(jqXHR, text_status, strError) {
			alert("Ha habido un error al consultar el total de ventas por vendedor: \n" + strError);
		},
		success: function(data) {
			if (data[0][0] == "") {
				data[0][0] = 0;
			}
			$('#cuerpoTablaVentasDiaPorVendedor').append(
				"<tr>" +
				"<td><strong>Total</strong></td>" +
				"<td class='numeros'><strong>$ " + separarMiles(data[0][0]) + "</strong></td>" +
				"</tr>"
			);
		}
	});
	// CLIENTES ATENDIDOS POR CADA VENDEDOR (CUANTOS TICKETS GENERÓ)
	$.ajax({
		async: false,
		data: ({
			fechaVentasPHP: fechaVentas
		}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaClientesAtendidosPorVendedor.php',
		error: function(jqXHR, text_status, strError) {
			$("#cuerpoTablaClientesAtendidosPorVendedor").html("");
			alert("Ha habido un error al consultar la cantidad de clientes atendidos por vendedor: \n" + strError);
		},
		success: function(data) {
			$("#cuerpoTablaClientesAtendidosPorVendedor").html("");
			for (var i in data) {
				$('#cuerpoTablaClientesAtendidosPorVendedor').append(
					"<tr>" +
					"<td>" + data[i][0] + "</td>" +
					"<td>" + data[i][1] + "</td>" +
					"</tr>"
				);
			}
		}
	});
	// TOTAL DE CLIENTES ATENDIDOS EN EL DIA (TICKETS GENERADOS EN EL DÍA)
	$.ajax({
		async: false,
		data: ({
			fechaVentasPHP: fechaVentas
		}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaTotalClientesAtendidos.php',
		error: function(jqXHR, text_status, strError) {
			alert("Ha habido un error al consultar al total de clientes atendidos: \n" + strError);
		},
		success: function(data) {
			if (data[0][0] == "") {
				data[0][0] = 0;
			}
			$('#cuerpoTablaClientesAtendidosPorVendedor').append(
				"<tr>" +
				"<td><strong>Total</strong></td>" +
				"<td><strong>" + data[0][0] + "</strong></td>" +
				"</tr>"
			);
		}
	});
}

function abrirModalDetallesVentasPorDoc() {
	$("#cuerpoTablaVentasDiaPorDocumento").on("click", ".filasTablaVentasDiaPorDocumento", function() {
		var codDoc = $(this).attr("id");
		$("#modalDetallesVentasPorDoc").modal("show");
		switch (codDoc) {
			case "2":
				$("#spnDetallesVentaPorDoc").html("<strong>boleta</strong>");
				break;
			case "3":
				$("#spnDetallesVentaPorDoc").html("<strong>factura</strong>");
				break;
			case "4":
				$("#spnDetallesVentaPorDoc").html("<strong>voucher transbank</strong>");
				break;
			default:
				$("#spnDetallesVentaPorDoc").html("");
		}
		// AL CARGAR EL MODAL SE CARGAN EL LISTADO DE NUMERACION DE DOCUMENTOS DE PAGO CON SU MONTO
		cargarDetallesVentasPorDoc(codDoc);
	});
}

// FUNCION QUE CARGA Y MUESTRA LA NUMERACION DE LOS DOCUMENTOS DE PAGO Y EL MONTO DE CADA UNO (BOLETA/FACTURA/VOUCHER N° | MONTO)
function cargarDetallesVentasPorDoc(codDoc) {
	var fechaVentas = $("#inpFecha").val();
	$.ajax({
		data: ({
			codDocPHP: codDoc,
			fechaVentasPHP: fechaVentas
		}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaDetallesVentasPorDocumento.php',
		error: function(jqXHR, text_status, strError) {
			$("#cuerpoTablaDetallesVentasPorDoc").html("");
			alert("Ha habido un error al consultar el detalle de las ventas del mes por documento de pago: \n" + strError);
		},
		success: function(data) {
			$('#cuerpoTablaDetallesVentasPorDoc').html("");
			for (var i in data) {
				$('#cuerpoTablaDetallesVentasPorDoc').append(
					"<tr>" +
					"<td>" + data[i][0] + "</td>" +
					"<td>$ " + separarMiles(data[i][1]) + "</td>" +
					"</tr>"
				)
			}
		}
	});
}

function abrirModalDetallesVentasDelMes() {
	$("#btnDetallesVentasMes").click(function() {
		$("#modalDetallesVentasDelMes").modal("show");
		// EL SUBTITULO DEL MODAL MUESTRA EL NOMBRE DEL MES (PARA ELLO CAPTURA EL MES DEL INPUT FECHA Y SEGUN EL NUMERO MUESTRA EL NOMBRE DEL MES CORRESPONDIENTE)
		var mesVentas = $("#inpFecha").val();
		var arrayFecha = mesVentas.split("-");
		var mes = arrayFecha[1];
		// console.log(mes);
		switch (mes) {
			case "01":
				$(".spnMesDetallesVentaDelMes").html("<strong>ENERO</strong>");
				break;
			case "02":
				$(".spnMesDetallesVentaDelMes").html("<strong>FEBRERO</strong>");
				break;
			case "03":
				$(".spnMesDetallesVentaDelMes").html("<strong>MARZO</strong>");
				break;
			case "04":
				$(".spnMesDetallesVentaDelMes").html("<strong>ABRIL</strong>");
				break;
			case "05":
				$(".spnMesDetallesVentaDelMes").html("<strong>MAYO</strong>");
				break;
			case "06":
				$(".spnMesDetallesVentaDelMes").html("<strong>JUNIO</strong>");
				break;
			case "07":
				$(".spnMesDetallesVentaDelMes").html("<strong>JULIO</strong>");
				break;
			case "08":
				$(".spnMesDetallesVentaDelMes").html("<strong>AGOSTO</strong>");
				break;
			case "09":
				$(".spnMesDetallesVentaDelMes").html("<strong>SEPTIEMBRE</strong>");
				break;
			case "10":
				$(".spnMesDetallesVentaDelMes").html("<strong>OCTUBRE</strong>");
				break;
			case "11":
				$(".spnMesDetallesVentaDelMes").html("<strong>NOVIEMBRE</strong>");
				break;
			case "12":
				$(".spnMesDetallesVentaDelMes").html("<strong>DICIEMBRE</strong>");
				break;
			default:
				$(".spnMesDetallesVentaDelMes").html("");
		}
		// AL ABRIR EL MODAL, POR DEFECTO, SE CARGAN LAS VENTAS POR CADA DIA POR DOCUMENTO
		cargarDetallesVentasPorDocDelMes();
		// SE CARGAN LOS NOMBRES Y RUT'S DE LOS VENDEDORES EN EL BOTON DESPLEGABLE
		cargarNombresVendedoresAlDropDown();
	});
}

// FUNCION QUE MUESTRA EL TOTAL DE VENTAS POR DOCUMENTO EN CADA DIA DEL MES SELECCIONADO
function cargarDetallesVentasPorDocDelMes() {
	var mesVentas = $("#inpFecha").val();
	var arrayFecha = mesVentas.split("-");
	var mes = arrayFecha[1];
	// console.log(mes);
	$.ajax({
		async: false,
		data: ({
			mesVentasPHP: mes,
			anoVentasPHP: ano
		}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaVentasMesPorDocumento.php',
		error: function(jqXHR, text_status, strError) {
			$("#cuerpoTablaVentasMes").html("");
			alert("Ha habido un error al consultar las ventas del mes por documento de pago: \n" + strError);
		},
		success: function(data) {
			$("#cuerpoTablaVentasMes").html("");
			$("#subtituloDetallesVentaMes").html("Por documento de venta");
			$("#cabeceraTablaVentasMes").html("");
			$("#cabeceraTablaVentasMes").append('<tr style="color:#136E6A">' +
				'<th>Día</th>' +
				'<th class="numeros">T. ventas</th>' +
				'<th class="numeros">T. boletas</th>' +
				'<th>Rango boletas</th>' +
				'<th class="numeros">T. facturas</th>' +
				'<th>Rango facturas</th>' +
				'<th class="numeros">T. voucher</th>' +
				'<th>Rango voucher</th>' +
				'</tr>');
			for (var i in data) {
				if (data[i][1] == "") {
					data[i][1] = 0;
				}
				if (data[i][2] == "") {
					data[i][2] = 0;
				}
				if (data[i][5] == "") {
					data[i][5] = 0;
				}
				if (data[i][8] == "") {
					data[i][8] = 0;
				}
				$('#cuerpoTablaVentasMes').append(
					"<tr>" +
					"<td>" + data[i][0] + "</td>" +
					"<td class='numeros'>$ " + separarMiles(data[i][1]) + "</td>" +
					"<td class='numeros'>$ " + separarMiles(data[i][2]) + "</td>" +
					"<td>" + data[i][3] + " - " + data[i][4] + "</td>" +
					"<td class='numeros'>$ " + separarMiles(data[i][5]) + "</td>" +
					"<td>" + data[i][6] + " - " + data[i][7] + "</td>" +
					"<td class='numeros'>$ " + separarMiles(data[i][8]) + "</td>" +
					"<td>" + data[i][9] + " - " + data[i][10] + "</td>" +
					"</tr>"
				);
			}
		}
	});

	// TOTALES DEL MES (TOTAL POR BOLETA, FACTURA, VOUCHER)
	$.ajax({
		async: false,
		data: ({
			mesVentasPHP: mes,
			anoVentasPHP: ano
		}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaTotalesVentasMesPorDocumento.php',
		error: function(jqXHR, text_status, strError) {
			alert("Ha habido un error al consultar los totales de ventas del mes por documento de pago: \n" + strError);
		},
		success: function(data) {
			if (data[0][0] == "") {
				data[1][0] = 0;
			}
			if (data[2][0] == "") {
				data[2][0] = 0;
			}
			if (data[3][0] == "") {
				data[3][0] = 0;
			}
			if (data[4][0] == "") {
				data[4][0] = 0;
			}
			if (data[5][0] == "") {
				data[5][0] = 0;
			}
			if (data[6][0] == "") {
				data[6][0] = 0;
			}
			$('#cuerpoTablaVentasMes').append(
				"<tr>" +
				"<td><strong>TOTAL</strong></td>" +
				"<td class='numeros'><strong>$ " + separarMiles(data[0][0]) + "</strong></td>" +
				"<td class='numeros'><strong>$ " + separarMiles(data[1][0]) + "</strong></td>" +
				"<td><strong>" + separarMiles(data[2][0]) + " boletas</strong></td>" +
				"<td class='numeros'><strong>$ " + separarMiles(data[3][0]) + "</strong></td>" +
				"<td><strong>" + separarMiles(data[4][0]) + " facturas</strong></td>" +
				"<td class='numeros'><strong>$ " + separarMiles(data[5][0]) + "</strong></td>" +
				"<td><strong>" + separarMiles(data[6][0]) + " v. transbank</strong></td>" +
				"</tr>"
			);
		}
	});
}

// FUNCION TAL QUE AL APRETAR EL BOTON CARGAR POR DOCUMENTO CARGA LOS TOTALES DEL MES POR DIA Y POR DOCUMENTO
function cargarDetallesVentasPorDocDelMesAlApretarBoton() {
	$("#btnVentasMesPorDocumento").click(function() {
		cargarDetallesVentasPorDocDelMes();
	});
}

// FUNCION QUE MUESTRA LOS NOMBRES Y RUT'S EN EL BOTON CON MENU DESPLEGABLE
function cargarNombresVendedoresAlDropDown() {
	$.ajax({
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaDatosVendedores.php',
		error: function(jqXHR, text_status, strError) {
			$('#listaVendedores').html("");
			alert("Ha habido un error al cargar nombres de los vendedores: " + strError);
		},
		success: function(data) {
			$('#listaVendedores').html("");
			for (i in data) {
				$('#listaVendedores').append(
					'<li class="nombreVendedores"><a href="#">' + data[i][1] + ': ' + separarMiles(data[i][0].substring(0, data[i][0].length - 1)) + '-' + data[i][0].substring(data[i][0].length - 1, data[i][0].length) + '</a></li>');
			}
		}
	});
}
// FUNCION QUE MUESTRA EL TOTAL DE VENTAS POR VENDEDOR EN CADA DIA DEL MES SELECCIONADO
function cargarDetallesVentasPorVendedorDelMes(rutVendedor, nombreVendedor) {
	var mesVentas = $("#inpFecha").val();
	var arrayFecha = mesVentas.split("-");
	var mes = arrayFecha[1];
	// console.log(mes);
	$.ajax({
		async: false,
		data: ({
			mesVentasPHP: mes,
			anoVentasPHP: ano,
			rutVendedorPHP: rutVendedor
		}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaVentasMesPorVendedor.php',
		error: function(jqXHR, text_status, strError) {
			$("#cuerpoTablaVentasMes").html("");
			alert("Ha habido un error al consultar las ventas del mes por vendedor de pago: \n" + strError);
		},
		success: function(data) {
			$("#cuerpoTablaVentasMes").html("");
			$("#subtituloDetallesVentaMes").html("De " + nombreVendedor);
			$("#cabeceraTablaVentasMes").html("");
			$("#cabeceraTablaVentasMes").append('<tr style="color:#136E6A">' +
				'<th>Día</th>' +
				'<th class="numeros">Total ventas diaria</th>' +
				'<th class="numeros">Total vendedor</th>' +
				'</tr>');
			for (var i in data) {
				if (data[i][1] == "") {
					data[i][1] = 0;
				}
				if (data[i][2] == "") {
					data[i][2] = 0;
				}
				$('#cuerpoTablaVentasMes').append(
					"<tr>" +
					"<td>" + data[i][0] + "</td>" +
					"<td class='numeros'>$ " + separarMiles(data[i][1]) + "</td>" +
					"<td class='numeros'>$ " + separarMiles(data[i][2]) + "</td>" +
					"</tr>"
				);
			}
		}
	});
	// ESTE AJAX TRAE EL TOTAL DEL MES POR VENDEDOR
	$.ajax({
		async: false,
		data: ({
			mesVentasPHP: mes,
			anoVentasPHP: ano,
			rutVendedorPHP: rutVendedor
		}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaTotalVentasMesPorVendedor.php',
		error: function(jqXHR, text_status, strError) {
			$("#cuerpoTablaVentasMes").html("");
			alert("Ha habido un error al consultar las ventas del mes por vendedor de pago: \n" + strError);
		},
		success: function(data) {
			if (data[0][0] == "") {
				data[1][0] = 0;
			}
			$('#cuerpoTablaVentasMes').append(
				"<tr>" +
				"<td><strong>TOTAL</strong></td>" +
				"<td class='numeros'><strong>$ " + separarMiles(data[0][0]) + "</strong></td>" +
				"<td class='numeros'><strong>$ " + separarMiles(data[1][0]) + "</strong></td>" +
				"</tr>"
			);
		}
	});
}

// FUNCION TAL QUE AL APRETAR EL BOTON QUE REPRESENTA AL VENDEDOR MUESTRA EL TOTAL DE VENTAS DEL MES
// POR DIA QUE HA REALIZADO
function cargarDetallesVentasDelMesPorVendedorAlApretarBoton() {
	$("#listaVendedores").on("click", ".nombreVendedores", function() {
		var nombreVendedor = $(this).children(':eq(0)').text();
		var rutVendedor = $(this).children(':eq(0)').text();
		var posicionDosPuntos = rutVendedor.search(":");
		nombreVendedor = nombreVendedor.substring(0, posicionDosPuntos)
		rutVendedor = rutVendedor.substring(posicionDosPuntos + 2, rutVendedor.length);
		rutVendedor = rutVendedor.replace(/\./g, "");
		rutVendedor = rutVendedor.replace("-", "");
		// console.log(rutVendedor);
		cargarDetallesVentasPorVendedorDelMes(rutVendedor, nombreVendedor);
	});
}

var totalesPorDiaGeraldine = [];
var totalesPorDiaJessica = [];
var totalesPorDiaJavier = [];
var totalesPorDiaMiguel = [];

function cargarDetallesVentasMesPorVendedores() {
	$("#btnVentasMesPorVendedores").click(function() {
		var mesVentas = $("#inpFecha").val();
		var arrayFecha = mesVentas.split("-");
		var mes = arrayFecha[1];

		totalesPorDiaGeraldine = [];
		totalesPorDiaJessica = [];
		totalesPorDiaJavier = [];
		totalesPorDiaMiguel = [];

		$('#cabeceraTablaVentasMes').html("");
		$("#cuerpoTablaVentasMes").html("");
		$('#cabeceraTablaVentasMes').append('<tr style="color:#136E6A">' +
			'<th class="numeros">Día</th>' +
			'<th class="numeros">Geraldine</th>' +
			'<th class="numeros">Jessica</th>' +
			'<th class="numeros">Javier</th>' +
			'<th class="numeros">Miguel</th>');

		$.ajax({
			async: false,
			data: ({
				mesVentasPHP: mes,
				anoVentasPHP: ano
			}),
			dataType: 'json',
			type: 'POST',
			timeout: 60000,
			url: 'php/consultaVentasMesGeraldine.php',
			error: function(jqXHR, text_status, strError) {
				$("#cuerpoTablaVentasMes").html("");
				alert("Ha habido un error al consultar las ventas del mes por vendedores: \n" + strError);
			},
			success: function(data) {
				// Si el arreglo traido (ventas del mes de geraldine) tiene informacion, se hace la operacion
				if (data.length != 0) {
					var j = 0;
					for (var i = 1; i <= 31; i++) {
						j++;
						if (j < 10 && String(j).length == 1) {
							j = "0" + j
						}
						while (j != data[i - 1][0]) {
							totalesPorDiaGeraldine.push("0");
							j++;
						}
						totalesPorDiaGeraldine.push(data[i - 1][1]);
					}
				};

			}
		});
		console.log("Geraldine: " + totalesPorDiaGeraldine);
		$.ajax({
			async: false,
			data: ({
				mesVentasPHP: mes,
				anoVentasPHP: ano
			}),
			dataType: 'json',
			type: 'POST',
			timeout: 60000,
			url: 'php/consultaVentasMesJessica.php',
			error: function(jqXHR, text_status, strError) {
				$("#cuerpoTablaVentasMes").html("");
				alert("Ha habido un error al consultar las ventas del mes por vendedores: \n" + strError);
			},
			success: function(data) {
				// Si el arreglo traido (ventas del mes de jessica) tiene informacion, se hace la operacion
				if (data.length != 0) {
					var j = 0;
					for (var i = 1; i <= 31; i++) {
						j++;
						if (j < 10 && String(j).length == 1) {
							j = "0" + j
						}
						while (j != data[i - 1][0]) {
							totalesPorDiaJessica.push("0");
							j++;
						}
						totalesPorDiaJessica.push(data[i - 1][1]);
					}
				};
			}
		});
		console.log("Jessica: " + totalesPorDiaJessica);

		$.ajax({
			async: false,
			data: ({
				mesVentasPHP: mes,
				anoVentasPHP: ano
			}),
			dataType: 'json',
			type: 'POST',
			timeout: 60000,
			url: 'php/consultaVentasMesJavier.php',
			error: function(jqXHR, text_status, strError) {
				$("#cuerpoTablaVentasMes").html("");
				alert("Ha habido un error al consultar las ventas del mes por vendedores: \n" + strError);
			},
			success: function(data) {

				// Si el arreglo traido (ventas del mes de javier) tiene informacion, se hace la operacion
				if (data.length != 0) {
					var j = 0;
					for (var i = 1; i <= 31; i++) {
						j++;
						if (j < 10 && String(j).length == 1) {
							j = "0" + j
						}
						while (j != data[i - 1][0]) {
							totalesPorDiaJavier.push("0");
							j++;
						}
						totalesPorDiaJavier.push(data[i - 1][1]);
					}
				};
			}
		});
		console.log("Javier: " + totalesPorDiaJavier);
		$.ajax({
			async: false,
			data: ({
				mesVentasPHP: mes,
				anoVentasPHP: ano
			}),
			dataType: 'json',
			type: 'POST',
			timeout: 60000,
			url: 'php/consultaVentasMesMiguel.php',
			error: function(jqXHR, text_status, strError) {
				$("#cuerpoTablaVentasMes").html("");
				alert("Ha habido un error al consultar las ventas del mes por vendedores: \n" + strError);
			},
			success: function(data) {
				// Si el arreglo traido (ventas del mes de miguel) tiene informacion, se hace la operacion
				if (data.length != 0) {
					var j = 0;
					for (var i = 1; i <= 31; i++) {
						j++;
						if (j < 10 && String(j).length == 1) {
							j = "0" + j
						}
						while (j != data[i - 1][0]) {
							totalesPorDiaMiguel.push("0");
							j++;
						}
						totalesPorDiaMiguel.push(data[i - 1][1]);
					}
				};
			}
		});
		console.log("Miguel: " + totalesPorDiaMiguel);

		// console.log("NUEVO Cristofer: " + rellenaArrayConCeros(totalesPorDiaCristofer));
		console.log(rellenaArrayConCeros(totalesPorDiaGeraldine));
		console.log(rellenaArrayConCeros(totalesPorDiaJessica));
		console.log(rellenaArrayConCeros(totalesPorDiaJavier));
		console.log(rellenaArrayConCeros(totalesPorDiaMiguel));

		for (var i = 1; i <= 32; i++) {
			$('#cuerpoTablaVentasMes').append(
				"<tr>" +
				"<td class='numeros'><strong>" + i + "</strong></td>" +
				"<td class='numeros'>$ " + separarMiles(totalesPorDiaGeraldine[i - 1]) + "</td>" +
				"<td class='numeros'>$ " + separarMiles(totalesPorDiaJessica[i - 1]) + "</td>" +
				"<td class='numeros'>$ " + separarMiles(totalesPorDiaJavier[i - 1]) + "</td>" +
				"<td class='numeros'>$ " + separarMiles(totalesPorDiaMiguel[i - 1]) + "</td>" +
				"</tr>"
			);
		};
	});
}

function rellenaArrayConCeros(array) {
	var largoArray = array.length;
	if (array.length < 31) {
		for (var i = 0; i < 31 - largoArray; i++) {
			array.push("0");
		};
	}
	return array;
}

function imprimirDetallesVentasDelDia() {
	$("#btnImprimirDetallesVentasDelDia").click(function() {
		var options = {
			mode: "iframe",
			popClose: "true",
			extraCss: "",
			retainAttr: "",
			extraHead: '<meta charset="utf-8" />,<meta http-equiv="X-UA-Compatible" content="IE=edge"/>'
		};
		$("#tituloImprimibleDetallesVentasDia").css("display", "block");
		$("#zonaImprimibleDetallesVentasDelDia").printArea(options);
		$("#tituloImprimibleDetallesVentasDia").css("display", "none");
	});
}

function imprimirDetallesVentasDelMes() {
	$("#btnImprimirDetallesVentasDelMes").click(function() {
		var options = {
			mode: "iframe",
			popClose: "true",
			extraCss: "",
			retainAttr: "",
			extraHead: '<meta charset="utf-8" />,<meta http-equiv="X-UA-Compatible" content="IE=edge"/>'
		};
		$("#tituloImprimibleDetallesVentasMes").css("display", "block");
		$("#zonaImprimibleDetallesVentasDelMes").printArea(options);
		$("#tituloImprimibleDetallesVentasMes").css("display", "none");
	});
}

function cargarVentas() {
	var fechaVentas = $("#inpFecha").val();
	$.ajax({
		data: ({
			fechaVentasPHP: fechaVentas
		}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaVentas.php',
		error: function(jqXHR, text_status, strError) {
			$("#cuerpoTabla").html("");
			alert("No se han cargado las ventas: " + strError);
		},
		success: function(data) {
			$("#cuerpoTabla").html("");
			for (var i in data) {
				// Los pedidos pagados (estadoPagado = 1) se muestra el boton verde (con clase btn-success)
				if (data[i][4] == "1") {
					$('#cuerpoTabla').append(
						"<tr>" +
						"<td>" + data[i][0] + "</td>" +
						"<td>" + separarMiles(data[i][1]) + "</td>" +
						"<td>" + data[i][2] + "</td>" +
						"<td>$ " + separarMiles(data[i][3]) + "</td>" +
						"<td><button type='button' class='detallesVenta btn btn-success' data-toggle='modal' data-target='#modalDetallesVenta'>Detalles</button></td>" +
						"</tr>"
					);
				} else {
					// Los pedidos no pagados (estadoPagado = 0) se muestra la linea color mas oscura y con boton amarillo (con clase btn-warning)
					$('#cuerpoTabla').append(
						"<tr style='background-color: #CBF3F2'>" +
						"<td>" + data[i][0] + "</td>" +
						"<td>" + separarMiles(data[i][1]) + "</td>" +
						"<td>" + data[i][2] + "</td>" +
						"<td>$ " + separarMiles(data[i][3]) + "</td>" +
						"<td><button type='button' class='detallesVenta btn btn-warning' data-toggle='modal' data-target='#modalDetallesVenta'>Detalles</button></td>" +
						"</tr>"
					);
				}
			}
		}
	});
}

// MUESTRA LOS DETALLES DE LA VENTA EN EL MODAL DETALLES
function cargarDetallesVenta() {
	$('#cuerpoTabla').on('click', '.detallesVenta', function() {
		// Cada vez q se abre el modal detalle venta -> se establece el permiso de editar venta como falso y se blquea boton editar
		permisoEditar = false;
		$("#btnEditarVenta").prop("disabled", true);

		// Este evento fuerza a que el select "selDocPago" tenga el foco despues de abrir el modal
		$('#modalDetallesVenta').on('shown.bs.modal', function() {
			$('#inpPagaCon').focus();
		});

		var numTicket = $(this).parents('tr').children(':eq(0)').html();
		// este ajax trae la cantidad, valor unitario, desc, valor neto, iva y total de cada producto vendido
		$.ajax({
			async: false,
			data: ({
				numTicketPHP: numTicket
			}),
			dataType: 'json',
			timeout: 60000,
			type: 'POST',
			url: 'php/consultaDetallesVenta.php',
			error: function(jqXHR, text_status, strError) {
				$('#cuerpoTablaDetalleVenta').html("");
				$("#numTicket").html("");
				alert("Ha habido un error al cargar los detalles de la venta: " + strError);
			},
			success: function(data) {
				$('#cuerpoTablaDetalleVenta').html("");
				$("#numTicket").html("");
				// Arriba del modal, se indica el numero de ticket
				$("#numTicket").html(" " + numTicket);
				for (var i in data) {
					// Si el valor descuento es mayor a cero se muestra en valor negativo
					if (data[i][3] > 0) {
						data[i][3] = data[i][3] * (-1);
					}
					$('#cuerpoTablaDetalleVenta').append(
						"<tr>" +
						"<td>" + data[i][0] + "</td>" +
						"<td>" + data[i][1] + "</td>" +
						"<td>$ " + separarMiles(Math.round(data[i][2])) + "</td>" +
						"<td>" + data[i][3] + " %</td>" +
						"<td>$ " + separarMiles(Math.round(data[i][4])) + "</td>" +
						"<td>$ " + separarMiles(Math.round(data[i][5])) + "</td>" +
						"<td>$ " + separarMiles(Math.round(data[i][6])) + "</td>" +
						"</tr>");
				}
			}
		});
		// este ajax trae los totales del valor neto, iva y total de cada producto vendido
		$.ajax({
			async: false,
			data: ({
				numTicketPHP: numTicket
			}),
			dataType: 'json',
			timeout: 60000,
			type: 'POST',
			url: 'php/consultaTotalesDetallesVenta.php',
			error: function(jqXHR, text_status, strError) {
				alert("Ha habido un error al cargar los totales del detalle de la venta: " + strError);
			},
			success: function(data) {
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
				$("#inpMontoTotal").val(data[0][2]); // Al traer lo totales, tambien se rellena el campo monto total
				// Al traer lo totales, tambien se rellena el campo monto numero documento pago
				// Si el numero de doc (data[0][3]) es 0, quiere decir que la venta no ha sido ingresada
				if (data[0][3] == 0) {
					// Se cargan todos los docs y medios de pagos
					cargarDocumentosYMediosDePago(0);

					$("#inpNumeroDocPago").prop("disabled", false);
					$("#selDocPago").prop("disabled", false);
					$("#selMedioPago").prop("disabled", false);
					$("#inpNumeroDocPago").val("");
				} else {
					// Se cargan los docs y medios de pagos correspondientes al numero de ticket de esa venta
					cargarDocumentosYMediosDePago(numTicket);
					// Si la venta ha sido ingresada, se desactivan los controles
					$("#inpNumeroDocPago").prop("disabled", true);
					$("#selDocPago").prop("disabled", true);
					$("#selMedioPago").prop("disabled", true);
					$("#inpNumeroDocPago").val(data[0][3]);
				}
				$("#inpPagaCon").val(""); // Al traer lo totales, tambien se blanquea el campo paga con
				$("#inpVuelto").val(""); // Al traer lo totales, tambien se blanquea el campo vuelto
			}
		});

	});
}

function cargarDocumentosYMediosDePago(numTicket) {
	$.ajax({
		url: 'php/consultaDocumentosDePago.php',
		data: ({
			numTicketPHP: numTicket
		}),
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		error: function(jqXHR, text_status, strError) {
			$("#selDocPago").html("");
			alert("Ha habido un error al cargar los documentos y/o medios de pago: " + strError);
		},
		success: function(data) {
			$("#selDocPago").html("");
			// Sólo muestro desde el registro 1 (el registro 0 dice 'sin definir') hasta el registro 3 (omite factura afecta y exenta)
			for (var i = 0; i < data.length; ++i) {
				if (data[i][0] !== '1') {
					$("#selDocPago").append("<option id='" + data[i][0] + "' value='" + data[i][0] + "'>" + data[i][1] + "</option>");
				}
			}
		}
	});
	$.ajax({
		dataType: 'json',
		data: ({
			numTicketPHP: numTicket
		}),
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaMediosDePago.php',
		error: function(jqXHR, text_status, strError) {
			$("#selMedioPago").html("");
			alert("Ha habido un error al cargar los documentos y/o medios de pago: " + strError);
		},
		success: function(data) {
			$("#selMedioPago").html("");
			// Sólo muestro desde el registro 1 (el registro 0 dice 'sin definir')
			for (var i = 0; i < data.length; ++i) {
				if (data[i][0] !== '1') {
					$("#selMedioPago").append("<option id='" + data[i][0] + "' value='" + data[i][0] + "'>" + data[i][1] + "</option>");
				}
			}
		}
	});
}

function seleccionarOpcionTransbankAlSeleccionarVoucher() {
	$("#selDocPago").change(function() {
		if ($(this).val() == "4") {
			$("#selMedioPago option[value='4']").attr("selected", true);
		}
		if ($(this).val() == "2") {
			$("#selMedioPago option[value='2']").attr("selected", true);
		}
	});
}

// FUNCION QUE CALCULA EL VUELTO
function calcularVuelto() {
	$("#inpPagaCon").on("input", function() {
		$("#inpVuelto").val(separarMiles(parseInt($(this).val()) - parseInt($("#inpMontoTotal").val())));
	});
}

function establecerVentaPagada() {
	$("#btnPagarVenta").click(function() {
		if ($("#inpNumeroDocPago").val() > 0 && $("#inpNumeroDocPago").val() != "" && $("#selDocPago").val() !== '1') {
			// El numero ticket lo obtengo de lo q dice en la etiqueta con id numTicket
			var numTicket = $("#numTicket").html();
			var codDocPago = $("#selDocPago").val();
			var numDocPago = $("#inpNumeroDocPago").val();
			var codMedioPago = $("#selMedioPago").val();
			$.ajax({
				data: ({
					numTicketPHP: numTicket,
					codDocPagoPHP: codDocPago,
					numDocPagoPHP: numDocPago,
					codMedioPagoPHP: codMedioPago
				}),
				dataType: 'json',
				timeout: 60000,
				type: 'POST',
				url: 'php/actualizaVentaEstablecePagada.php',
				error: function(jqXHR, text_status, strError) {
					alert("Ha habido un error al pagar la venta: \n" + strError);
				},
				success: function(data) {
					$("#inpNumeroDocPago").val("");
					if (data["estado"] == 1) {
						cargarTotalVentasDelDia();
						cargarVentas();
						alert(data["descripcion"]);
					}
					if (data["estado"] == 0) {
						alert(data["descripcion"]);
					}
				}
			});
		} else {
			if ($("#inpNumeroDocPago").val() < 0) {
				alert("CORRIJA EL NÚMERO DE DOCUMENTO DE PAGO.");
			}
			if ($("#inpNumeroDocPago").val() == "") {
				alert("DEBE INGRESAR EL NÚMERO DE DOCUMENTO DE PAGO.");
			}
			if ($("#selDocPago").val() == '1') {
				alert("DEBE INGRESAR EL DOCUMENTO DE PAGO.");
			}
		}
	});
}

function anularVenta() {
	$("#btnAnularVenta").click(function() {
		var numTicket = $("#numTicket").html();
		$.ajax({
			data: ({
				numTicketPHP: numTicket
			}),
			dataType: 'text',
			timeout: 60000,
			type: 'POST',
			url: 'php/eliminarAnularVenta.php',
			error: function(jqXHR, text_status, strError) {
				alert("Ha habido un error al anular la venta: \n" + strError);
			},
			success: function(data) {
				alert(data);
				cargarVentas();
			}
		});
	});
}


function desbloquearControlesVenta() {
	$("#btnDesbloquearVenta").click(function() {
		$("#inpNumeroDocPago").prop("disabled", false);
		$("#selDocPago").prop("disabled", false);
		$("#selMedioPago").prop("disabled", false);

		$("#btnEditarVenta").prop("disabled", false);

		permisoEditar = true;
	});
}

function editarVenta() {
	$("#btnEditarVenta").click(function() {

		if ($("#inpNumeroDocPago").val() > 0 && $("#inpNumeroDocPago").val() != "") {
			// El numero ticket lo obtengo de lo q dice en la etiqueta con id numTicket
			var numTicket = $("#numTicket").html();
			var codDocPago = $("#selDocPago").val();
			var numDocPago = $("#inpNumeroDocPago").val();
			var codMedioPago = $("#selMedioPago").val();
			$.ajax({
				data: ({
					numTicketPHP: numTicket,
					codDocPagoPHP: codDocPago,
					numDocPagoPHP: numDocPago,
					codMedioPagoPHP: codMedioPago
				}),
				dataType: 'json',
				timeout: 60000,
				type: 'POST',
				url: 'php/actualizaDatosVenta.php',
				error: function(jqXHR, text_status, strError) {
					alert("Ha habido un error al pagar la venta: \n" + strError);
				},
				success: function(data) {
					cargarTotalVentasDelDia();
					cargarVentas();
					$("#inpNumeroDocPago").val("");
					alert(data["descripcion"]);
				}
			});
		} else {
			if ($("#inpNumeroDocPago").val() < 0) {
				alert("CORRIJA EL NÚMERO DE BOLETA.");
			}
			if ($("#inpNumeroDocPago").val() == "") {
				alert("DEBE INGRESAR EL NÚMERO DE BOLETA.");
			}
			$("#inpNumeroDocPago").val("");
		}
	});
}

function refrescarVentasDiaAlPresionaBotonRefresh() {
	$("#btnRefrescarVentasDia").click(function() {
		cargarVentas();
	});
}