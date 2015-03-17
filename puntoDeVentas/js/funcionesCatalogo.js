$(document).ready(abrirModalIngresarProductoAlPedido());
$(document).ready(cargarTodosProductos());
$(document).ready(buscarProductoALPresionarEnter());
$(document).ready(buscarProductoALPresionarBotonBuscar());
$(document).ready(agregarProductoAlPedido());
$(document).ready(calculaTotalAlCambiarCantidad());
$(document).ready(calculaTotalAlCambiarDescuento());

var valorProducto;

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

function abrirModalIngresarProductoAlPedido(){
	$("#contenedorCuadrosProductos").on("click", ".cuadrosProductos", function(){
		$("#modalAgregarProductoAlPedido").modal("show");
		$("#alertFaltaRellenar").css('display', 'none');
		$("#inpCodProducto").val($(this).attr("id"));
		$("#inpDescuento").val("0");
		// Captura los datos del producto seleccionado
		var valorProducto = $(this).children(':eq(0)').children(':eq(0)').text();
		var nombreProducto = $(this).children(':eq(0)').children(':eq(0)').siblings(':eq(0)').text();
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
		calculaTotal();

	});
	// Este evento fuerza a que el input "inpNombreProducto" tenga el foco despues de abrir el modal
	$('#modalAgregarProductoAlPedido').on('shown.bs.modal', function () {
	    $('#inpCantidad').focus();
	});
}

function cargarTodosProductos(){
	$.ajax({
		data:({nombreProductoPHP: '', codProductoPHP: '%%'}),
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaProductos.php',
		error: function(jqXHR,text_status,strError){
			$("#contenedorCuadrosProductos").html("");
			alert("Ha habido un error al cargar los productos: \n" + strError);
		},
		success: function(data){
			$("#contenedorCuadrosProductos").html("");
			for(var i in data){
				$("#contenedorCuadrosProductos").append(
					'<div class="col-md-3 col-sm-6 col-xs-6">' +
						'<a href="#" id="' + data[i][0] + '" class="cuadrosProductos" style="text-decoration: none" >' +
							'<div class="panel panel-primary text-center no-boder bg-color-red">' +
								// '<div><span style="color:#BF2072">En existencia: 3</span></div>' +
								'<div class="panel-body">' +
									'<img src="img/telasCatalogo/prueba1.jpg" class="img-responsive">' +
									' <h3>$ ' + separarMiles(data[i][4]) + '</h3>' +
								'</div>' +
								'<div class="panel-footer back-footer-blue-oil" style="color: white"><strong>' + data[i][1] + '</strong></div>' +
							'</div>' +
						'</a>' +
					'</div>');
			}
		}
	});
}

function buscarProducto(){
	var nombreProducto = $("#inpBuscarProducto").val();
	$.ajax({
		data:({nombreProductoPHP: nombreProducto, codProductoPHP: '%%'}),
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaProductos.php',
		error: function(jqXHR,text_status,strError){
			$("#contenedorCuadrosProductos").html("");
			alert("Ha habido un error al cargar los productos: \n" + strError);
		},
		success: function(data){
			$("#contenedorCuadrosProductos").html("");
			for(var i in data){
				$("#contenedorCuadrosProductos").append(
					'<div class="col-md-3 col-sm-6 col-xs-6">' +
						'<a href="#" id="' + data[i][0] + '" class="cuadrosProductos" style="text-decoration: none" >' +
							'<div class="panel panel-primary text-center no-boder bg-color-red">' +
								'<div class="panel-body">' +
									'<img src="img/telasCatalogo/no_photo.jpg" class="img-responsive">' +
									' <h3>$ ' + separarMiles(data[i][4]) + '</h3>' +
								'</div>' +
								'<div class="panel-footer back-footer-blue-oil" style="color: white"><strong>' + data[i][1] + '</strong></div>' +
							'</div>' +
						'</a>' +
					'</div>');
			}
		}
	});
}

function buscarProductoALPresionarEnter(){
	$("#inpBuscarProducto").keypress(function(tecla){
		if (tecla.keyCode == 13) {
			buscarProducto();
		}
	});
}
function buscarProductoALPresionarBotonBuscar(){
	$("#btnBuscarProducto").click(function(){
		buscarProducto();
	});
}

function agregarProductoAlPedido(){
	$("#btnAgregarProductoAlPedido").click(function(){

		var codProductoAAgregarAlPedido = $("#inpCodProducto").val();
		var cantidadAAgregarAlPedido = $("#inpCantidad").val();
		var descuentoAAplicarAlPedido = $("#inpDescuento").val();
		// alert(codProductoAAgregar);
		if (codProductoAAgregarAlPedido != "" && cantidadAAgregarAlPedido != "" && descuentoAAplicarAlPedido != "") {
			$.ajax({
				data:({codProductoAAgregarAlPedidoPHP: codProductoAAgregarAlPedido,
					cantidadAAgregarAlPedidoPHP: cantidadAAgregarAlPedido,
					descuentoAAplicarAlPedidoPHP: descuentoAAplicarAlPedido}),
				dataType: 'text',
				timeout: 60000,
				type: 'POST',
				url: 'php/insertaProductoAlPedido.php',
				error: function(jqXHR,text_status,strError){
					$("#cuerpoTablaProductos").val("");
					alert("Ha habido un error al ingresar el producto al pedido: " + strError);
				},
				success: function(data){
					$("#inpCantidad").val("");
					$("#inpDescuento").val("");
					$("#inpTotal").val("");
					$('#modalAgregarProductoAlPedido').modal('hide');
					// alert(data);
					cargarTodosProductos();
				}
			});
		}else{
			$("#alertFaltaRellenar").css('display', 'block');
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