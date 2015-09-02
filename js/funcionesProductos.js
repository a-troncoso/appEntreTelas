var codProductoAEditar, existeProducto;

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

function redondearDosDecimales(num) {
    return +(Math.round(num + "e+2")  + "e-2");
}

function cargarTodosProductos(){
	$.ajax({
		data:({nombreProductoPHP: '', codProductoPHP: '%%'}),
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaProductos.php',
		error: function(jqXHR,text_status,strError){
			$("#cuerpoTablaProductos").html("");
			alert("Ha habido un error al cargar los productos: " + strError);
		},
		success: function(data){
			$("#cuerpoTablaProductos").html("");
			for(var i in data){
				$('#cuerpoTablaProductos').append(
					"<tr>" +
						"<td class='numeros'>" + data[i][0] + "</td>" +
						"<td>" + data[i][1] + "</td>" +
						"<td class='numeros'>$ " + separarMiles(Math.round(data[i][2])) + "</td>" +
						"<td class='numeros'>$ " + separarMiles(data[i][4]) + "</td>" +
						"<td class='numeros'><button type='button' id='" + data[i][0] + "' class='editarProducto btn btn-warning' data-toggle='modal'>Editar</button></td>" +
					"</tr>");
			}
		}
	});
}

function abrirModalNuevoProducto(){
	$("#cuerpoTablaProductos").on('click', '.btnNuevoProducto', function(){

	});

	$("#btnNuevoProducto").click(function(){
		$("#modalIngresarProducto").modal("show");
		$("#alertaModalIngresarProducto").html("");
		$("#alertaModalIngresarProducto").css('display', 'none');
	})

	// Este evento fuerza a que el input "inpNombreProducto" tenga el foco despues de abrir el modal
	$('#modalIngresarProducto').on('shown.bs.modal', function () {
		$('#inpCodigoProducto').focus();
	});
}


function verificaSiYaExisteProducto(codProducto, nombreProducto){
	$.ajax({
		// Para que retorne valor debe no ser asyncrono
		async: false,
		data:({codProductoPHP: codProducto, nombreProductoPHP: nombreProducto}),
		dataType: 'text',
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaSiYaExisteProducto.php',
		error: function(jqXHR,text_status,strError){
			alert("Ha habido un error al verificar si el producto existe: " + strError);
		},
		success: function(data){
			existeProducto = data;
		}
	});
	return existeProducto;
}

function ingresarNuevoProducto(){
	$("#btnIngresarProducto").click(function(){
		var codigoProducto = $("#inpCodigoProducto").val();
		var nombreProducto = $("#inpNombreProducto").val();
		var valorNetoVentaProducto = $("#inpValorNetoVentaProducto").val();
		var stockCriticoProducto = $("#inpStockCriticoProducto").val();
		if (nombreProducto != "" && valorNetoVentaProducto != "" && codigoProducto != "" && stockCriticoProducto != ""){
			// Verifica si el producto ya existe (llamando a la funcion verificaSiYaExisteProducto), si no existe se agrega
			if (verificaSiYaExisteProducto(codigoProducto, nombreProducto) == "0") {
				$.ajax({
					data:({nombreProductoPHP: nombreProducto,
						valorNetoVentaProductoPHP: valorNetoVentaProducto,
						codigoProductoPHP: codigoProducto,
						stockCriticoProductoPHP: stockCriticoProducto}),
					dataType: 'text',
					timeout: 60000,
					type: 'POST',
					url: 'php/insertaProducto.php',
					error: function(jqXHR,text_status,strError){
						$("#cuerpoTablaProductos").val("");
						alert("Ha habido un error al ingresar el producto: " + strError);
					},
					success: function(data){
						$("#inpCodigoProducto").val("");
						$("#inpNombreProducto").val("");
						$("#inpValorNetoVentaProducto").val("");
						$("#inpValorBrutoVenta").val("");
						$("#inpStockCriticoProducto").val("");
						$('#modalIngresarProducto').modal('hide');
						alert(data);
						cargarTodosProductos();
					}
				});
			}else{
				$("#alertaModalIngresarProducto").html("<p><strong>Error: </strong>El producto ya existe.</p>");
				$("#alertaModalIngresarProducto").css('display', 'block');
			}
		}else{
			$("#alertaModalIngresarProducto").html("<p><strong>Error: </strong>Faltan campos por rellenar.</p>");
			$("#alertaModalIngresarProducto").css('display', 'block');
		}
	});
}

function calcularValorBrutoProducto(contenedorModificado, contenedorCalculado){
	$(contenedorModificado).on('input', function(){
		$(contenedorCalculado).val(redondearDosDecimales(parseInt($(contenedorModificado).val()) + (parseInt($(contenedorModificado).val()) * 0.19)));
	});
}

function calcularValorNetoProducto(contenedorModificado, contenedorCalculado){
	$(contenedorModificado).on('input', function(){
		$(contenedorCalculado).val(redondearDosDecimales(parseInt($(contenedorModificado).val()) / (1.19)));
	});
}

function abrirModalEditarProducto(){
	$("#cuerpoTablaProductos").on("click", ".editarProducto", function(){
		$("#modalEditarProducto").modal("show");
		$("#alertaModalEditar").html("");
		$("#alertaModalEditar").css('display', 'none');
		$("#alertConfirmaEliminarProducto").css("display", "none");

		codProductoAEditar = $(this).attr('id');
		// console.log(codProducto);

		$.ajax({
			data:({nombreProductoPHP: '', codProductoPHP: codProductoAEditar}),
			dataType: 'json',
			timeout: 60000,
			type: 'POST',
			url: 'php/consultaProductos.php',
			error: function(jqXHR,text_status,strError){
				$("#inpNombreProductoAEditar").val("");
				$("#inpValorNetoVentaProductoAEditar").val("");
				$("#inpValorBrutoVentaAEditar").val("");
				alert("Ha habido un error al cargar los datos del producto: " + strError);
			},
			success: function(data){
				$("#inpNombreProductoAEditar").val("");
				$("#inpValorNetoVentaProductoAEditar").val("");
				$("#inpValorBrutoVentaAEditar").val("");

				$("#inpCodigoProductoAEditar").val(data[0][0]);
				$("#inpNombreProductoAEditar").val(data[0][1]);
				$("#inpValorNetoVentaProductoAEditar").val(data[0][2]);
				$("#inpValorBrutoVentaAEditar").val(data[0][4]);
				$("#inpStockCriticoProductoAEditar").val(data[0][5]);
			}
		});
	});
}

function editarProducto(){
	$("#btnActualizarProducto").click(function(){
		var nuevoCodigoProducto = $("#inpCodigoProductoAEditar").val();
		var nuevoNombreProducto = $("#inpNombreProductoAEditar").val();
		var nuevoValorNetoVentaProducto = $("#inpValorNetoVentaProductoAEditar").val();
		var nuevoStockCriticoProducto = $("#inpStockCriticoProductoAEditar").val();

		if (nuevoNombreProducto != "" && nuevoValorNetoVentaProducto != "" && nuevoCodigoProducto != "" && nuevoStockCriticoProducto != ""){
			$.ajax({
				data:({codProductoAEditarPHP: codProductoAEditar,
					nuevoCodigoProductoPHP: nuevoCodigoProducto,
					nuevoNombreProductoPHP: nuevoNombreProducto,
					nuevoValorNetoVentaProductoPHP: nuevoValorNetoVentaProducto,
					nuevoStockCriticoProductoPHP: nuevoStockCriticoProducto}),
				dataType: 'text',
				timeout: 60000,
				type: 'POST',
				url: 'php/actualizaProducto.php',
				error: function(jqXHR,text_status,strError){
					$("#inpNombreProductoAEditar").val("");
					$("#inpValorNetoVentaProductoAEditar").val("");
					$("#inpValorBrutoVentaAEditar").val("");
					alert("Ha habido un error al editar el producto: " + strError);
				},
				success: function(data){
					$("#inpNombreProductoAEditar").val("");
					$("#inpValorNetoVentaProductoAEditar").val("");
					$("#inpValorBrutoVentaAEditar").val("");
					$('#modalEditarProducto').modal('hide');
					alert(data);
					cargarTodosProductos();
				}
			});
		}else{
			$("#alertaModalEditar").html("<p><strong>Error: </strong>Faltan campos por rellenar.</p>");
			$("#alertaModalEditar").css('display', 'block');
		}
	});
}

function mostrarAlertEliminarProducto(){
	$("#btnEliminarProducto").click(function(){
		$("#alertConfirmaEliminarProducto").css("display", "block");
	});
}

function ocultarAlertEliminarProducto(){
	$("#btnNoEliminarProducto").click(function(){
		$("#alertConfirmaEliminarProducto").css("display", "none");
	});
}
function eliminarProducto(){
	$("#btnSiEliminarProducto").click(function(){
		$.ajax({
			data:({codProductoAEliminarPHP: codProductoAEditar}),
			dataType: 'text',
			timeout: 60000,
			type: 'POST',
			url: 'php/eliminaProducto.php',
			error: function(jqXHR,text_status,strError){
				$("#inpNombreProductoAEditar").val("");
				$("#inpValorNetoVentaProductoAEditar").val("");
				$("#inpValorBrutoVentaAEditar").val("");
				alert("Ha habido un error al eliminar el producto: " + strError);
			},
			success: function(data){
				$("#inpNombreProductoAEditar").val("");
				$("#inpValorNetoVentaProductoAEditar").val("");
				$("#inpValorBrutoVentaAEditar").val("");
				$('#modalEditarProducto').modal('hide');
				alert(data);
				cargarTodosProductos();
			}
		});
	});
}
