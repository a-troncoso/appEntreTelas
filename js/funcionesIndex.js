///////////////////////////////////////////////////////////////////////////
///																		///
///																		///
///					FUNCIONES GLOBALES									///
///																		///
///																		///
///////////////////////////////////////////////////////////////////////////

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

///////////////////////////////////////////////////////////////////////////
///																		///
///																		///
///					LOGIN CAJA 											///
///																		///
///																		///
///////////////////////////////////////////////////////////////////////////

function showPassword() {
    
    var key_attr = $('#passLocal').attr('type');
    
    if(key_attr != 'text') {
        $('.checkbox').addClass('show');
        $('#passLocal').attr('type', 'text');
    } else {
        $('.checkbox').removeClass('show');
        $('#passLocal').attr('type', 'password');
    }
}

function insertarLocal(){
	$('#btn-signup').click(function(){
		var inpEmailLocal = $('#inpEmailLocal').val();
		var inpNombreLocal = $('#inpNombreLocal').val();
		var inpDireLocal = $('#inpDireLocal').val();
		var inpPassLocal = $('#inpPassLocal').val();
		var inpFonoLocal = $('#inpFonoLocal').val();
		if (inpEmailLocal != '' && inpNombreLocal != '' && inpDireLocal != '' && inpPassLocal != '' && inpFonoLocal != '')  {
			$.ajax({
				data:({inpEmailLocalPHP: inpEmailLocal,
					inpNombreLocalPHP: inpNombreLocal,
					inpDireLocalPHP: inpDireLocal,
					inpPassLocalPHP: inpPassLocal,
					inpFonoLocalPHP: inpFonoLocal}),
				dataType: 'text',
				timeout: 60000,
				type: 'POST',
				// url: 'http://localhost:8080/appBares/interfazCaja/php/insertarLocal.php',
				url: 'php/insertaLocal.php',
				error: function(jqXHR,text_status,strError){
					$('#signupalert').css('display', 'block');
					$('#msgError').html('Ha ocurrido un error al ingresar el local ' + strError);
					// alert("Ha ocurrido un error al ingresar el local " + strError);
				},
				success: function(data){
					if (data != '') {
						// alert(data);
						//  si hay error se muestra el mensaje
						$('#signupalert').css('display', 'block');
						$('#msgError').html('Ha ocurrido un error al ingresar el local ' + data);

						// y se esconde el mensaje de q se ha ingresado el local
						$('#signupsuccess').css('display', 'none');
						$('#msgSuccess').html();
					}
					else{
						//  si no hay error se esconde el mensaje de error
						$('#signupalert').css('display', 'none');
						$('#msgError').html();

						//  y se muestra el mensaje de q se ha ingresado el local
						$('#signupsuccess').css('display', 'block');
						$('#msgSuccess').html('Se ha ingresado correctamente el local.');
					};
				}
			});
		}else{
			//  si no se han completado todos los campos se muestra mensaje de error
			$('#signupalert').css('display', 'block');
			$('#msgError').html('Debe ingresar todos los datos.');

			// y se esconde el mensaje de todo OK
			$('#signupsuccess').css('display', 'none');
			$('#msgSuccess').html();
		}
	});
}
function blanquearMensajesErroryOK(){
	$('#btnRegistrateAqui').click(function(){
		$('#signupalert').css('display', 'none');
		$('#msgError').html();
		$('#signupsuccess').css('display', 'none');
		$('#msgSuccess').html();
	});
}

