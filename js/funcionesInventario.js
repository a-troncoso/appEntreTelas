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

function mostrarInventarioAlCambiarFecha(){
	$("#inpFechaInventario").change(function(){
		cargarInventario();
		cargarTotalInventarioValorizado();
	});
}

function cargarInventario(){
	var fechaInventario = $("#inpFechaInventario").val();
	$.ajax({
		async: false,
		data: ({fechaInventarioPHP: fechaInventario}),
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaInventario.php',
		error: function(jqXHR,text_status,strError){
			$("#cuerpoTablaInventario").html("");
			alert("Ha habido un error al cargar el inventario: " + strError);
		},
		success: function(data){
			$("#cuerpoTablaInventario").html("");
			for(var i in data){
				if (parseInt(data[i][2]) <= parseInt(data[i][3])) {
					$('#cuerpoTablaInventario').append(
						"<tr>" +
							"<td class='numeros'>" + data[i][0] + "</td>" +
							"<td class='letras'>" + data[i][1] + "</td>" +
							"<td class='numeros'>" + Math.round(data[i][2] * 100) / 100 + "</td>" +
							"<td class='numeros'>" + data[i][3] + "</td>" +
							"<td class='numeros'><i class='fa fa-exclamation-triangle' style='color: #C50606'></i></td>" +
							"<td class='numeros'>$ " + separarMiles(Math.round(data[i][4])) + "</td>" +
						"</tr>");
				// Si el saldo es mayor que el stock crítico y a la vez menor al stock mas del 30%
				}else if ((parseInt(data[i][2]) >= parseInt(data[i][3])) && (parseInt(data[i][2]) <= (parseInt(data[i][3]) + parseInt(data[i][3])*0.3))){
					$('#cuerpoTablaInventario').append(
						"<tr>" +
							"<td class='numeros'>" + data[i][0] + "</td>" +
							"<td class='letras'>" + data[i][1] + "</td>" +
							"<td class='numeros'>" + Math.round(data[i][2] * 100) / 100 + "</td>" +
							"<td class='numeros'>" + data[i][3] + "</td>" +
							"<td class='numeros'><i class='fa fa-exclamation-triangle' style='color: #E0E331'></i></td>" +
							"<td class='numeros'>$ " + separarMiles(Math.round(data[i][4])) + "</td>" +
						"</tr>");
				}else{
					$('#cuerpoTablaInventario').append(
						"<tr>" +
							"<td class='numeros'>" + data[i][0] + "</td>" +
							"<td class='letras'>" + data[i][1] + "</td>" +
							"<td class='numeros'>" + Math.round(data[i][2] * 100) / 100 + "</td>" +
							"<td class='numeros'>" + data[i][3] + "</td>" +
							"<td class='numeros'><i class='fa fa-check-circle' style='color: #3AA725'></i></td>" +
							"<td class='numeros'>$ " + separarMiles(Math.round(data[i][4])) + "</td>" +
						"</tr>");
				}
			}
		}
	});
}

function cargarTotalInventarioValorizado(){
	var fechaInventario = $("#inpFechaInventario").val();
	$.ajax({
		async: false,
		data: ({fechaInventarioPHP: fechaInventario}),
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaInventarioValorizado.php',
		error: function(jqXHR,text_status,strError){
			alert("Ha habido un error al cargar el inventario: " + strError);
		},
		success: function(data){
			$('#cuerpoTablaInventario').append(
				"<tr>" +
					"<td class='numeros'><strong>TOTAL</strong></td>" +
					"<td class='letras'></td>" +
					"<td class='numeros'></td>" +
					"<td class='numeros'></td>" +
					"<td class='numeros'></td>" +
					"<td class='numeros'><strong>$" + separarMiles(Math.round(data[0][0])) + "</strong></td>" +
				"</tr>");
		}
	});
}