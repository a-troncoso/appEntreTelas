$(document).ready(cargarTodosVendedores());
    $(document).ready(redireccionarPaginaCatalogo());

function cargarTodosVendedores(){
	$.ajax({
		dataType: 'json',
		timeout: 60000,
		type: 'POST',
		url: 'php/consultaVendedores.php',
		error: function(jqXHR,text_status,strError){
			$("#contenedorCuadrosVendedores").html("");
			alert("Ha habido un error al cargar los vendedores: \n" + strError);
		},
		success: function(data){
			$("#contenedorCuadrosVendedores").html("");
			for(var i in data){
				$("#contenedorCuadrosVendedores").append(
					'<div class="col-md-2 col-sm-4 col-xs-4">' +
						'<a href="#" id=' + data[i][0] + ' class="cuadrosVendedores" style="text-decoration: none" >' +
							'<div class="panel panel-primary text-center no-boder bg-color-red">' +
								'<div class="panel-body">' +
									'<img src="img/vendedores/no_photo.jpg" class="img-responsive">' +
								'</div>' +
								'<div class="panel-footer back-footer-blue" style="color: white"><strong>' + data[i][1] + '</strong></div>' +
							'</div>' +
						'</a>' +
					'</div>');
			}
		}
	});
}

function redireccionarPaginaCatalogo(){
    $("#contenedorCuadrosVendedores").on("click", ".cuadrosVendedores", function(){
        var rutVendedorLogueado = $(this).attr("id");
        var nombreVendedorLogueado = $(this).children("div:eq(0)").children("div:eq(1)").children("strong:eq(0)").html();
        $.ajax({
			data: ({rutVendedorLogueadoPHP: rutVendedorLogueado,
				nombreVendedorLogueadoPHP: nombreVendedorLogueado}),
			timeout: 60000,
			type: 'POST',
			url: 'php/capturaDatosVendedor.php',
			error: function(jqXHR,text_status,strError){
				alert("Ha habido un error al redireccionar al catálogo: \n" + strError);
			},
			success: function(){
				window.location.href = "catalogo.php";
			}
		});
    });
}