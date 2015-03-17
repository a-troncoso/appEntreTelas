$(document).ready(cargarTodosProductosPedidos());
$(document).ready(cargarTodosProductosPedidosParaImprimir());
$(document).ready(abrirModalEditarProductoDelPedido());
$(document).ready(verificaSiHayPedidos());
$(document).ready(generarTicket());
$(document).ready(eliminarPedido());
$(document).ready(modificaPedido());


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

function cargarTodosProductosPedidos(){
	$.ajax({
		data: ({filtraPHP: "0", idVentaSeleccionadaPHP: ""}),
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaProductosPedidos.php',
		error: function(jqXHR,text_status,strError){
			$("#contenedorCuadrosProductosPedidos").html("");
			alert("Ha habido un error al cargar los productos del pedido: \n" + strError);
		},
		success: function(data){
			$("#contenedorCuadrosProductosPedidos").html("");
			for(var i in data){
				$("#contenedorCuadrosProductosPedidos").append(
					'<div class="col-md-3 col-sm-6 col-xs-6">' +
						'<a href="#" id="' + data[i][0] + '" class="cuadrosProductos" style="text-decoration: none">' +
							'<div id="' + data[i][1] + '" class="panel panel-primary text-center no-boder bg-color-red">' +
								'<div class="panel-body">' +
									'<img src="img/telasCatalogo/no_photo.jpg" class="img-responsive">' +
									'<h3>$ ' + separarMiles(data[i][5]) + '</h3>' +
								'</div>' +
								'<div class="panel-footer back-footer-blue-oil" style="color: white"><strong>' + data[i][2] + '</strong></div>' +
							'</div>' +
						'</a>' +
					'</div>');
			}
		}
	});
}
function obtenerFechaActual(contenedor){
	var fechaActual = new Date();
	var ano = fechaActual.getFullYear();
	var mes = fechaActual.getMonth() + 1;
	if (mes < 10) {mes = '0' + mes};
	var dia = fechaActual.getDate();
	if (dia < 10) {dia = '0' + dia};
	$(contenedor).html(dia + '-' + mes + '-' + ano);
}
function obtenerHoraActual(contenedor){
	var fechaActual = new Date();
	var hora = fechaActual.getHours();
	var minutos = fechaActual.getMinutes();
	$(contenedor).html(hora + ':' + minutos);
}

function estableceFechaEmisionTicket(){
	obtenerFechaActual("#fechaEmisionTicket");
}
function estableceHoraEmisionTicket(){
	obtenerHoraActual("#horaEmisionTicket");
}

function establecePedidoConfirmado(){
	$.ajax({
		dataType: 'text',
		timeout: 60000,
		type: 'POST',
		url: 'php/actualizaEstablecePedidoConfirmado.php',
		error: function(jqXHR,text_status,strError){
			alert("Ha habido un error al enviar el pedido: \n" + strError);
		},
		success: function(data){
			// alert(data);
		}
	});
}

function imprimirTicket(){
	// $("#btnImprimirPedido").click(function(){
		var options = { mode : "iframe", popClose : "true", extraCss : "", retainAttr : "", extraHead : '<meta charset="utf-8" />,<meta http-equiv="X-UA-Compatible" content="IE=edge"/>' };
		// var options = { mode : "iframe", popHt : "500", popWd: "400", popX: "500", popY: "600",  popTitle:"hola", popClose: "false", strict: "undefined"};
		$("#contenidoImprimir").printArea(options);
	// });

}

// mode:"iframe","popup"  //printable window is either iframe or browser popup
// popHt: 500   // popup window height
// popWd: 400  // popup window width
// popX: 500   // popup window screen X position
// popY: 600  //popup window screen Y position
// popTitle: // popup window title element
// popClose: false,true  // popup window close after printing
// strict: undefined,true,false // strict or looseTransitional html 4.01 document standard or undefined to not include at all only for popup option

function generarTicket(){
	$("#btnImprimirPedido").click(function(){
		estableceFechaEmisionTicket();
		estableceHoraEmisionTicket();
		establecePedidoConfirmado();
		imprimirTicket();
		redireccionaAlIndex();
	});
}

function cargarTodosProductosPedidosParaImprimir(){
	$.ajax({
		data: ({filtraPHP: "0", idVentaSeleccionadaPHP: ""}),
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaProductosPedidos.php',
		error: function(jqXHR,text_status,strError){
			$("#cuerpoTablaPedido").html("");
			alert("Ha habido un error al cargar los productos del pedido para imprimir: \n" + strError);
		},
		success: function(data){
			$("#cuerpoTablaPedido").html("");
			for(var i in data){
				$("#cuerpoTablaPedido").append(
					'<tr>' +
						'<td>' + data[i][2] + '</td>' +
						// '<td>' + data[i][5] + '</td>' +
						'<td>' + data[i][7] + ' %</td>' +
						'<td>$ ' + separarMiles(data[i][8]) + '</td>' +
						// '<td>' + data[i][7] + '</td>' +
					'</tr>');
			}
		}
	});
	cargarValorTotalDelPedido();
}
function cargarValorTotalDelPedido(){
	$.ajax({
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaValorTotalDelPedido.php',
		error: function(jqXHR,text_status,strError){
			$("#cuerpoTablaPedido").html("");
			alert("Ha habido un error al cargar el valor total del pedido: \n" + strError);
		},
		success: function(data){
			$("#cuerpoTablaPedido").append(
				'<tr>' +
					'<td><strong>Total</strong></td>' +
					// '<td>' + data[i][5] + '</td>' +
					'<td></td>' +
					'<td>$ ' + separarMiles(data[0][0]) + '</td>' +
					// '<td>' + data[i][7] + '</td>' +
				'</tr>');
		}
	});
}
function redireccionaAlIndex(){
	window.location.href = "index.php";
}

function verificaSiHayPedidos(){
	$.ajax({
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaCuantosProductosEnPedido.php',
		error: function(jqXHR,text_status,strError){
			alert("Ha habido un error al verificar los pedidos: \n" + strError);
		},
		success: function(data){
			if (parseInt(data[0][0]) > 0) {
				$("#alertNoHayProductosEnPedido").css("display", "none");
				$("#btnImprimirPedido").attr("disabled", false);
				$("#btnImprimirPedido").css("display", "block");
			};
		}
	});
}

function calculaTotal(){
	var codProductoAAgregarAlPedido = $("#inpCodProducto").val();
	$.ajax({
		data:({nombreProductoPHP: '', codProductoPHP: codProductoAAgregarAlPedido}),
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaProductos.php',
		error: function(jqXHR,text_status,strError){
			$("#inpTotal").val("");
			alert("Ha habido un error al cargar el valor del producto: \n" + strError);
		},
		success: function(data){
			valorProducto = data[0][4];
		}
	});
}

function calculaTotalAlCambiarCantidad(){
	$("#inpCantidad").on("input", function(){
		// Calcula el total menos el descuento, lo redondea y los separa en miles
		$("#inpTotal").val(separarMiles(Math.round($("#inpCantidad").val() * (valorProducto - (valorProducto * ($("#inpDescuento").val()*0.01)))) ));
	});
}

function calculaTotalAlCambiarDescuento(){
	$("#inpDescuento").on("input", function(){
		// Calcula el total menos el descuento, lo redondea y los separa en miles
		$("#inpTotal").val(separarMiles(Math.round($("#inpCantidad").val() * (valorProducto - (valorProducto * ($("#inpDescuento").val()*0.01)))) ));
	});
}

var idVentaSeleccionada;

function abrirModalEditarProductoDelPedido(){
	$("#contenedorCuadrosProductosPedidos").on("click", ".cuadrosProductos", function(){
		$("#modalEditarProductoDelPedido").modal("show");
		$("#alertFaltaRellenar").css('display', 'none');
		$("#inpDescuento").val("0");
		// Captura los datos del producto seleccionado
		// var codProducto = $(this).children(':eq(0)').children(':eq(0)').text();
		var valorProducto = $(this).children(':eq(0)').children(':eq(0)').text();
		var nombreProducto = $(this).children(':eq(0)').children(':eq(0)').siblings(':eq(0)').text();
		idVentaSeleccionada = $(this).attr("id");
		// Limpia el cuadro que contiene la informacion del producto
		$("#cuadroProductoEnDialog").html("");
		// Agrega la informacion del producto al cuadro que contiende la informacion del producto
		$("#cuadroProductoEnDialog").append(
			'<div class="panel panel-primary text-center no-boder bg-color-red">' +
                '<div class="panel-body">' +
                    '<img src="img/telasCatalogo/no_photo.jpg" class="img-responsive">' +
                    '<h3>' + valorProducto + '</h3>' +
                '</div>' +
                '<div class="panel-footer back-footer-blue-oil" style="color: white"><strong>' + nombreProducto + '</strong></div>' +
            '</div>');
		// Se le asigna el codigo del producto pedido contenido en el id del elemento hijo
		$("#inpCodProducto").val($(this).children(':eq(0)').attr("id"));

		calculaTotalAlCambiarCantidad();
		calculaTotalAlCambiarDescuento();
		calculaTotal();

		$.ajax({
			data: ({filtraPHP: "1", idVentaSeleccionadaPHP: idVentaSeleccionada}),
			dataType: 'json',
			timeout: 60000,
			type: 'POST',
			url: 'php/consultaProductosPedidos.php',
			error: function(jqXHR,text_status,strError){
				$("#inpCantidad").val("");
				$("#inpDescuento").val("");
				$("#inpTotal").val("");
				alert("Ha habido un error al cargar los datos del producto pedido: \n" + strError);
			},
			success: function(data){
				$("#inpCantidad").val(data[0][3]);
				$("#inpDescuento").val(data[0][8]);
				$("#inpTotal").val(separarMiles(data[0][9]));
			}
		});

	});
	// Este evento fuerza a que el input "inpNombreProducto" tenga el foco despues de abrir el modal
	$('#modalEditarProductoDelPedido').on('shown.bs.modal', function () {
	    $('#inpCantidad').focus();
	});
}

function eliminarPedido(){
	$("#btnEliminarProductoDelPedido").click(function(){
		$.ajax({
			data: ({idVentaSeleccionadaPHP: idVentaSeleccionada}),
			dataType: 'text',
			timeout: 60000,
			type: 'POST',
			url: 'php/eliminaPedido.php',
			error: function(jqXHR,text_status,strError){
				alert("Ha habido un error al eliminar pedido: \n" + strError);
			},
			success: function(data){
				alert(data);
				$("#modalEditarProductoDelPedido").modal("hide");
				cargarTodosProductosPedidos();
			}
		});
	});
}
function modificaPedido(){
	$("#btnModificarProductoDelPedido").click(function(){
		var cantidadAEditar = $("#inpCantidad").val();
		var descuentoAEditar = $("#inpDescuento").val();
		$.ajax({
			data: ({idVentaSeleccionadaPHP: idVentaSeleccionada,
				cantidadAEditarPHP: cantidadAEditar,
				descuentoAEditarPHP: descuentoAEditar}),
			dataType: 'text',
			timeout: 60000,
			type: 'POST',
			url: 'php/actualizaPedido.php',
			error: function(jqXHR,text_status,strError){
				alert("Ha habido un error al eliminar pedido: \n" + strError);
			},
			success: function(data){
				alert(data);
				$("#modalEditarProductoDelPedido").modal("hide");
				cargarTodosProductosPedidosParaImprimir();
			}
		});
	});
}