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
	});
}

function cargarInventario(){
	var fechaInventario = $("#inpFechaInventario").val();
	$.ajax({
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
							"<td>" + data[i][0] + "</td>" +
							"<td>" + data[i][1] + "</td>" +
							"<td>" + Math.round(data[i][2] * 100) / 100 + "</td>" +
							"<td>" + data[i][3] + "</td>" +
							"<td><i class='fa fa-exclamation-triangle' style='color: #C50606'></i></td>" +
						"</tr>");
				// Si el saldo es mayor que el stock crítico y a la vez menor al stock mas del 30%
				}else if ((parseInt(data[i][2]) >= parseInt(data[i][3])) && (parseInt(data[i][2]) <= (parseInt(data[i][3]) + parseInt(data[i][3])*0.3))){
					$('#cuerpoTablaInventario').append(
						"<tr>" +
							"<td>" + data[i][0] + "</td>" +
							"<td>" + data[i][1] + "</td>" +
							"<td>" + Math.round(data[i][2] * 100) / 100 + "</td>" +
							"<td>" + data[i][3] + "</td>" +
							"<td><i class='fa fa-exclamation-triangle' style='color: #E0E331'></i></td>" +
						"</tr>");
				}else{
					$('#cuerpoTablaInventario').append(
						"<tr>" +
							"<td>" + data[i][0] + "</td>" +
							"<td>" + data[i][1] + "</td>" +
							"<td>" + Math.round(data[i][2] * 100) / 100 + "</td>" +
							"<td>" + data[i][3] + "</td>" +
							"<td><i class='fa fa-check-circle' style='color: #3AA725'></i></td>" +
						"</tr>");
				}
			}
		}
	});
}