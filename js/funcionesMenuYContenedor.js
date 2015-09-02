///////////////////////////////////////////////////////////////////////////
///																		///
///																		///
///					INTERFAZ CAJA   									///
///																		///
///																		///
///////////////////////////////////////////////////////////////////////////

function llamarPaginasSegunTabSeleccionado(){
	$('#btnCompras').click(function() {
		$.ajax({
			url: 'compras.php',
			success: function(data){
				$('#container').html(data);
			}
		});
	});
	$('#btnVentas').click(function() {
		$.ajax({
			url: 'ventas.php',
			success: function(data){
				$('#container').html(data);
			}
		});
	});
	$('#btnIngresarVenta').click(function() {
		$.ajax({
			url: 'ingresarVenta.php',
			success: function(data){
				$('#container').html(data);
			}
		});
	});
	$('#btnProductos').click(function() {
		$.ajax({
			url: 'productos.php',
			success: function(data){
				$('#container').html(data);
			}
		});
	});
	$('#btnVendedores').click(function() {
		$.ajax({
			url: 'vendedores.php',
			success: function(data){
				$('#container').html(data);
			}
		});
	});
	$('#btnProveedores').click(function() {
		$.ajax({
			url: 'proveedores.php',
			success: function(data){
				$('#container').html(data);
			}
		});
	});
	$('#btnInventario').click(function() {
		$.ajax({
			url: 'inventario.php',
			success: function(data){
				$('#container').html(data);
			}
		});
	});
}