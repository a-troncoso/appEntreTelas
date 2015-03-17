function cargarNombresProveedores(){
	$.ajax({
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaProveedores.php',
		error: function(jqXHR,text_status,strError){
			alert("No se han cargado los nombres de los proveedores: " + strError);
		},
		success: function(data){
			$('#selectProveedor').append("<option disabled='disabled' selected='selected'>Selecciona proveedor</option>");
			for(var i in data){
				$('#selectProveedor').append("<option value='" + data[i][0] + "'>" + data[i][1] + "</option>");
			}
		}
	});
}

function cargarDatosProveedorSeleccionado(){
	$('#selectProveedor').change(function(){
		var rutProveedor = $(this).val();
		$('#inpRutProveedor').val(rutProveedor.substring(0, (rutProveedor.length)-1));
		$('#inpCodVerificadorProveedor').val(rutProveedor.substring((rutProveedor.length)-1, (rutProveedor.length)));

		$.ajax({
			data:({rutProveedorPHP: rutProveedor}),
			dataType: 'json',
			type: 'POST',
			timeout: 60000,
			url: 'php/consultaDatosProveedor.php',
			error: function(jqXHR,text_status,strError){
				$('#inpGiroProveedor').val('');
				$('#inpDireccionProveedor').val('');
				$('#inpComuna').val('');
				$('#inpComuna').val('');
				$('#inpTelefonoProveedor').val('');
				$('#inpMailProveedor').val('');
				alert("No se han cargado los datos del proveedor: " + strError);
			},
			success: function(data){
				for(var i in data){
					$('#inpGiroProveedor').val(data[i][2]);
					$('#inpDireccionProveedor').val(data[i][3]);
					$('#inpComuna').val(data[i][4]);
					$('#inpCiudad').val(data[i][5]);
					$('#inpTelefonoProveedor').val(data[i][6]);
					$('#inpMailProveedor').val(data[i][7]);
				}
			}
		});
	});
}

function cargarDocumentos(){
	$.ajax({
		url: 'php/consultaDocumentosDeCompra.php',
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		error: function(jqXHR,text_status,strError){
			$("#selectDocumento").val("");
			alert("Ha habido un error al cargar los documentos y/o medios de pago: " + strError);
		},
		success: function(data){
			$("#selectDocumento").val("");
			// Sólo muestro desde el registro 4 (que solo muestre factura afecta o excenta)
			for(var i in data){
				$("#selectDocumento").append("<option id='" + data[i][0] + "' value='" + data[i][0] + "'>" + data[i][1] + "</option>");
			}
		}
	});
}

function verificarSiFacturaEstaEnPeriodoActual(){
	var fechaActual = new Date();
	var ano = fechaActual.getFullYear();
	var mes = fechaActual.getMonth() + 1;
	if (mes < 10) {mes = '0' + mes;}
	var periodoActual = ano + "-" + mes;

	$("#inpMesPeriodo").change(function(){
		var periodoSeleccionado = $("#inpMesPeriodo").val();
		var aPeriodoActual = periodoActual.split("-");
		var aPeriodoSeleccionado = periodoSeleccionado.split("-");

		var fFechaActual = Date.UTC(aPeriodoActual[0],aPeriodoActual[1]-1);
		var fPeriodoSeleccionado = Date.UTC(aPeriodoSeleccionado[0],aPeriodoSeleccionado[1]-1);
		var dif = fFechaActual - fPeriodoSeleccionado;
		var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
		// alert(dias);
		if (dias > 60)  {
			// alert("Esta fuera de periodo");
			$("#selectDocumento option[value='2']").attr("selected", true);
			$("#selectDocumento option[value='1']").attr("disabled", true);
		}else{
			$("#selectDocumento option[value='1']").attr("selected", true);
			$("#selectDocumento option[value='1']").attr("disabled", false);
		}
	});
}

function cargarNombresProductos(idSelectProducto, idInpValorUnitario){
	$.ajax({
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaDatosProductos.php',
		error: function(jqXHR,text_status,strError){
			$(idSelectProducto).html("");
			alert("No se han cargado los datos de los productos: " + strError);
		},
		success: function(data){
			$(idSelectProducto).html("");
			$(idSelectProducto).append("<option value='selecciona' disabled='disabled' selected='selected'>Selecciona producto</option>");
			for(var i in data){
				$(idSelectProducto).append("<option value='" + data[i][0] + "'>" + data[i][1] + "</option>");
			}
		}
	});
}

function rellenarCodigoProducto(idSelectProducto){
	$(idSelectProducto).change(function(){
		var posicionGuion = $(this).attr('id').search("-");
		var numeroIdSelect = parseInt($(this).attr('id').substring(posicionGuion+1, ($(this).attr('id').length)));
		$("#inpCodProducto-" + numeroIdSelect).val($(this).val());
	});
}

function cargarNombreProductoAPartirDelCodigo(idInputCodProducto){
	$(idInputCodProducto).on('input', function(){
		var posicionGuion = $(this).attr('id').search("-");
		var numeroIdInputCodProducto = parseInt($(this).attr('id').substring(posicionGuion+1, ($(this).attr('id').length)));
		var codProducto = $(this).val();
		// console.log(codProducto);
		if (codProducto == null || codProducto == "") {
			codProducto = "selecciona";
		}else{
			$("#selProducto-" + numeroIdInputCodProducto + " option[value="+ codProducto +"]").attr("selected",true);
		}
		// Al cambiar el codigo de producto se obtiene el valor unitario y se calcula el valor total
		cargarValorNetoYCalcularTotalProductoSeleccionado("#selProducto-" + numeroIdInputCodProducto);
	});
}

var numeroIdBtnIngresarProducto;

function abrirModalIngresarProducto(idBtnIngresarProducto){
	$(idBtnIngresarProducto).click(function(){
		var posicionGuion = $(this).attr('id').search("-");
		numeroIdBtnIngresarProducto = parseInt($(this).attr('id').substring(posicionGuion+1, ($(this).attr('id').length)));

		$("#modalIngresarProducto").modal("show");
		$("#alertFaltaRellenar").css("display", "none");
	});
	// Este evento fuerza a que el input "inpNombreProducto" tenga el foco despues de abrir el modal
	$('#modalIngresarProducto').on('shown.bs.modal', function () {
		$('#inpCodigoProducto').focus();
	});
}

function calcularValorBrutoProducto(contenedorModificado, contenedorCalculado){
	$(contenedorModificado).on('input', function(){
		$(contenedorCalculado).val(Math.round(parseInt($(contenedorModificado).val()) + (parseInt($(contenedorModificado).val()) * 0.19)));
	});
}
function calcularValorNetoProducto(contenedorModificado, contenedorCalculado){
	$(contenedorModificado).on('input', function(){
		$(contenedorCalculado).val(Math.round(parseInt($(contenedorModificado).val()) / (1.19)));
	});
}

function ingresarNuevoProducto(){
	$("#btnIngresarProducto").click(function(){
		var codigoProducto = $("#inpCodigoProducto").val();
		var nombreProducto = $("#inpNombreProducto").val();
		var valorNetoVentaProducto = $("#inpValorNetoVentaProducto").val();
		if (nombreProducto != "" && valorNetoVentaProducto != "" && codigoProducto != ""){
			$.ajax({
				data:({nombreProductoPHP: nombreProducto,
					valorNetoVentaProductoPHP: valorNetoVentaProducto,
					codigoProductoPHP: codigoProducto}),
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
					$('#modalIngresarProducto').modal('hide');
					alert(data);
					cargarNombresProductos("#selProducto-" + numeroIdBtnIngresarProducto,"#selProducto-" + numeroIdBtnIngresarProducto);
					// NO ME RESULTA!! (REVISAR)
					//$("#selProducto-" + numeroIdBtnIngresarProducto + " option[value="+ codigoProducto +"]").attr("selected",true);
					//$("#inpCodProducto-" + numeroIdBtnIngresarProducto).val(codigoProducto);
				}
			});
		}else{
			$("#alertFaltaRellenar").css('display', 'block');
		}
	});
}

function cargarValorNetoYCalcularTotalProductoSeleccionado(idSelectProducto){
	var rutProveedor = $("#inpRutProveedor").val() + $("#inpCodVerificadorProveedor").val();
	var posicionGuion = $(idSelectProducto).attr('id').search("-");
	var numeroIdSelect = parseInt($(idSelectProducto).attr('id').substring(posicionGuion+1, ($(idSelectProducto).attr('id').length)));
	var codProducto = $(idSelectProducto).val();
	$.ajax({
		data:({codProductoPHP: codProducto, rutProveedorPHP: rutProveedor}),
		dataType: 'json',
		type: 'POST',
		timeout: 60000,
		url: 'php/consultaValorNetoProducto.php',
		error: function(jqXHR,text_status,strError){
			alert("No se ha cargado el valor del producto: " + strError);
		},
		success: function(data){
			$("#inpValorUnitario-" + numeroIdSelect).val(data[0][0]);
			$("#inpValorTotal-" + numeroIdSelect).val(parseFloat($("#inpCantidad-" + numeroIdSelect).val()) * parseInt(data[0][0]));
			calulaTotalesFactura();
		}
	});
}
// Al cambiar el producto se obtiene el valor unitario y se calcula el valor total
function cargarValorNetoYCalcularTotalProductoSeleccionadoAlCambiarProducto(idSelectProducto){
	$(idSelectProducto).change(function(){
		cargarValorNetoYCalcularTotalProductoSeleccionado(idSelectProducto);
	});
}

function generaTds(){
	$("#cuerpoTabla").on("click", ".checkGenerado", function(){
		var posicionGuion = $(this).attr('id').search("-");
		var numeroIdCheck = parseInt($(this).attr('id').substring(posicionGuion+1, ($(this).attr('id').length)));
		if ($("#inpCantidad-" + numeroIdCheck).val() != "" && $("#selProducto-" + numeroIdCheck).val() != null) {
			if($(this).is(":checked")) {
				$('#cuerpoTabla').append(
				'<tr>' +
					'<td width="100px"><input id="inpCantidad-'+(numeroIdCheck+1)+'" class="cantidades form-control" type="number"></td>' +
					'<td width="600px"><select id="selProducto-'+(numeroIdCheck+1)+'" class="selGenerado form-control"></select></td>' +
					'<td width="170px"><input id="inpCodProducto-'+(numeroIdCheck+1)+'" class="form-control" type="number" min="0"></td>' +
					'<td width="100px"><button id="btnNuevoProducto-'+(numeroIdCheck+1)+'" class="btn btn-primary">Nuevo</button></td>' +
					'<td width="150px"><input id="inpValorUnitario-'+(numeroIdCheck+1)+'" class="valoresUnitarios form-control" type="number"></td>' +
					'<td width="150px"><input id="inpValorTotal-'+(numeroIdCheck+1)+'" class="valoresTotales form-control" type="number" disabled="disabled"></td>' +
					'<td><input type="checkbox" id="check-'+(numeroIdCheck+1)+'" class="checkGenerado form-control" style="width: 104px; height: 20px; margin-top: 7px;"></td>' +
				'</tr>');
				$(this).attr("checked", true);
				$(this).attr("disabled", true);
				cargarNombresProductos('#selProducto-'+(numeroIdCheck+1), '#inpValorUnitario-'+(numeroIdCheck+1));
				rellenarCodigoProducto('#selProducto-'+(numeroIdCheck+1));
				cargarNombreProductoAPartirDelCodigo('#inpCodProducto-'+(numeroIdCheck+1));
				cargarValorNetoYCalcularTotalProductoSeleccionadoAlCambiarProducto('#selProducto-'+(numeroIdCheck+1));
				calculaTotalAlCambiarCantidad('#inpCantidad-'+(numeroIdCheck+1), '#inpValorUnitario-'+(numeroIdCheck+1), '#inpValorTotal-'+(numeroIdCheck+1));
				calculaTotalAlCambiarValorUnitario('#inpCantidad-'+(numeroIdCheck+1), '#inpValorUnitario-'+(numeroIdCheck+1), '#inpValorTotal-'+(numeroIdCheck+1));

				// Se establece el foco el el proximo input cantidad
				$('#inpCantidad-'+(numeroIdCheck+1)).focus();
			}
		}else{
			if ($("#inpCantidad-" + numeroIdCheck).val() == "") {alert("ERROR: Debe indicar la cantidad.");}
			if ($("#selProducto-" + numeroIdCheck).val() == null) {alert("ERROR: Debe indicar la el producto.");}

			$("#check-" + numeroIdCheck).attr("checked", false);
		}
	});
}
function calculaTotal(contenedorCantidad, contenedorValorUnitario, contenedorValorTotal){
		$(contenedorValorTotal).val(parseFloat($(contenedorCantidad).val()) * parseInt($(contenedorValorUnitario).val()));
		calulaTotalesFactura();
}

function calculaTotalAlCambiarCantidad(contenedorCantidad, contenedorValorUnitario, contenedorValorTotal){
	$(contenedorCantidad).on('input', function(){
		calculaTotal(contenedorCantidad, contenedorValorUnitario, contenedorValorTotal);
	});
}

function calculaTotalAlCambiarValorUnitario(contenedorCantidad, contenedorValorUnitario, contenedorValorTotal){
	$(contenedorValorUnitario).on('input', function(){
		calculaTotal(contenedorCantidad, contenedorValorUnitario, contenedorValorTotal);
	});
}

function calulaTotalesFactura(){
	var arrayValoresTotales = new Array();
	var valorTotalNetoFactura = 0;
	var valorIVAFactura = 0;
	var valorTotalFactura = 0;
	$(".valoresTotales").each(function() {
		if ($(this).val() == ""){
			arrayValoresTotales.push("0");
		}else{
			arrayValoresTotales.push($(this).val());
		}
	});

	for (var i = 0; i <= arrayValoresTotales.length-1; i++) {
		valorTotalNetoFactura += parseInt(arrayValoresTotales[i]);
	}
	valorIVAFactura = valorTotalNetoFactura * 0.19;
	valorTotalFactura = parseInt((valorTotalNetoFactura) + (valorTotalNetoFactura * 0.19));

	// console.log("Valor Total Neto: " + valorTotalNetoFactura);
	// console.log("I.V.A.: " + valorIVAFactura);
	// console.log("Total: " + valorTotalFactura);

	$("#inpValorTotalNeto").val(valorTotalNetoFactura);
	$("#inpValorIVA").val(valorIVAFactura);
	$("#inpValorTotal").val(valorTotalFactura);
};

function calcularTotalFactura(contenedorModificado){
	$(contenedorModificado).on('input', function(){
		$("#inpValorTotal").val(parseInt($("#inpValorTotalNeto").val()) + parseInt($("#inpValorIVA").val()));
	});
};

function ingresarCompra(){
	$("#btnIngresarCompra").click(function(){
		// Solo si se ingreso la cantidad del primer produto, el primer producto,
		// el numero factura distintoo de vacio, y se ingresó una fecha -> se ingresa la compra
		if ( $("#selectProveedor").val() != null
			&& $("#inpCantidad-1").val() != ""
			&& $("#selProducto-1").val() != null
			&& $("#inpNumeroFactura").val() != ""
			&& $("#inpMesPeriodo").val() != ""
			&& $("#inpFechaEmisionFactura").val() != "") {
			agregarCompra();
		}
		else{
			var arrayErrores = new Array();
			if ($("#selectProveedor").val() == null) {arrayErrores.push("- Proveedor.")};
			if ($("#inpCantidad-1").val() == "") {arrayErrores.push("- Cantidad.")};
			if ($("#selProducto-1").val() == null ) {arrayErrores.push("- Producto.")};
			if ($("#inpNumeroFactura").val() == "") {arrayErrores.push("- Número de documento.")};
			if ($("#inpMesPeriodo").val() == "") {arrayErrores.push("- Período.")};
			if ($("#inpFechaEmisionFactura").val() == "") {arrayErrores.push("- Fecha de emisión documento.")};
			alert("ERROR: Faltan los siguientes datos:\n" + arrayErrores.toString().replace(/,/gi,"\n").toUpperCase());
		};
	});
};

function generaJSON() {
    jSONcantidades = [];
    jSONproductos = [];
    var arrayCantidades = new Array();
    $(".cantidades").each(function() {

		var cantidad = $(this).val();
		if (cantidad == "") {cantidad = "0";};

		arrayCantidades.push(cantidad);
	});
	$(".selGenerado").each(function() {

		var producto = $(this).val();

		item = {}
		item ["producto"] = producto;

        jSONproductos.push(item);
    });

    // for (var i = 0; i <= jSONcantidades.length - 1; i++) {
    // 	console.log(jSONcantidades[i]);
    // 	console.log(jSONproductos[i]);
    // };
};

function agregarCompra(){
	var rutProveedor = $("#inpRutProveedor").val();
	var digitoVerificadorProveedor = $("#inpCodVerificadorProveedor").val();
	//console.log(rutProveedor +digitoVerificadorProveedor);
	var numDocumento = $("#inpNumeroFactura").val();
	var fechaEmisionDocumento = $("#inpFechaEmisionFactura").val();
	var arrayProductos = new Array();
	var arrayCantidades = new Array();
	var arrayValoresUnitarios = new Array();

   	$(".selGenerado").each(function() {
        var producto = $(this).val();

        arrayProductos.push(producto);
    });
   	$(".cantidades").each(function() {
       var cantidad = $(this).val();
       if (cantidad == "") {cantidad = "0";};

       arrayCantidades.push(cantidad);
   	});
   	$(".valoresUnitarios").each(function() {
       var valorUnitario = $(this).val();
       if (valorUnitario == "") {valorUnitario = "0";};

       arrayValoresUnitarios.push(valorUnitario);
   	});

   	var valorTotalNeto = $("#inpValorTotalNeto").val();
   	var valorIvaDoc = $("#inpValorIVA").val();
   	var valorTotalDoc = $("#inpValorTotal").val();

	$.ajax({
		data: ({rutProveedorPHP: rutProveedor,
			digitoVerificadorProveedorPHP: digitoVerificadorProveedor,
			numDocumentoPHP: numDocumento,
			fechaEmisionDocumentoPHP: fechaEmisionDocumento,
			arrayCantidadesPHP: arrayCantidades,
			arrayProductosPHP: arrayProductos,
			arrayValoresUnitariosPHP: arrayValoresUnitarios,
			valorTotalNetoPHP: valorTotalNeto,
			valorIvaDocPHP: valorIvaDoc,
			valorTotalDocPHP: valorTotalDoc}),
		timeout: 60000,
		type: "POST",
		url: "php/insertaCompra.php",
		error: function(jqXHR,text_status,strError){
			alert("ERROR: No es posible agregar la compra\n\n" + strError);
		},
		success: function(data){
			alert(data);
			cargarPaginaCompras();
		}
	});
};

function cargarPaginaCompras(){
	$.ajax({
		url: 'compras.php',
		success: function(data){
			$('#container').html(data);
		}
	});
}
