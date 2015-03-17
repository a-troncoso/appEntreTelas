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

function abrirModalBuscarProducto(){
	// Al abrir el modal se cargan todas las funciones correspondientes al modal
	$(".buscadores").click(function(){
		$("#modalBuscarProducto").modal("show");
		buscarProductos();
		buscarProductosAlPresionarEnter();
		buscarProductosAlPresionarBotonBuscar();
	});

	// Este evento fuerza a que el input "inpNombreProducto" tenga el foco despues de abrir el modal
	$('#modalBuscarProducto').on('shown.bs.modal', function () {
	    $('#inpNombreProducto').focus();
	});
};
function buscarProductosAlPresionarEnter(){
	// Con este evento se ejecuta una funcion al presionar enter (13) estando el foco en "inpNombreProducto"
	$('#inpNombreProducto').keypress(function(e){
		if(e.which == 13){
			buscarProductos();
		}
	});
};

function buscarProductosAlPresionarBotonBuscar(){
	$("#btnBuscarProducto").click(function(){
		buscarProductos();
	});
};

function buscarProductos(){
	var nombreProducto = $("#inpNombreProducto").val();
	$.ajax({
		data: ({nombreProductoPHP: nombreProducto, codProductoPHP: ''}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaProductos.php',
		error: function(jqXHR,text_status,strError){
			$("#cuerpoTablaProductosEncontrados").html("");
			alert("Ha habido un error al consultar lo/s producto/s: \n" + strError);
		},
		success: function(data){
			$("#cuerpoTablaProductosEncontrados").html("");
			for(var i in data){
				$("#cuerpoTablaProductosEncontrados").append("<tr>" +
					"<td>" + data[i][0] + "</td>" +
					"<td>$ " + separarMiles(data[i][1]) + "</td>" +
					"<td>$ " + separarMiles(data[i][2]) + "</td>" +
					"<td>$ " + separarMiles(data[i][3]) + "</td>" +
				"</tr>");
			};
		}
	});
};