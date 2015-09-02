<?php

include('conec.php');

$rutProveedor = $_POST['rutProveedorPHP'];
$digitoVerificadorProveedor = $_POST['digitoVerificadorProveedorPHP'];
$rutCompletoProveedor = ($rutProveedor) . ($digitoVerificadorProveedor);
$periodo = $_POST['periodoPHP'];
$codDocCompra = $_POST['codDocCompraPHP'];
$numDocumento = $_POST['numDocumentoPHP'];
$fechaEmisionDocumento = $_POST['fechaEmisionDocumentoPHP'];
$arrayProductos = $_POST['arrayProductosPHP'];
$arrayCantidades = $_POST['arrayCantidadesPHP'];
$arrayValoresUnitarios = $_POST['arrayValoresUnitariosPHP'];

$valorTotalNeto = $_POST['valorTotalNetoPHP'];
$valorIvaDoc = $_POST['valorIvaDocPHP'];
$valorTotalDoc = $_POST['valorTotalDocPHP'];

$resultado = true;

// Si anteriormente no se ha ingresado el numero de documento de aquel proveedor se hace la compra,
// si no es porq ya se ha ingresado el documento

$sql1 = "SELECT compras.rutProveedor
FROM compras
WHERE rutProveedor = '$rutCompletoProveedor'
AND numeroDocCompra = '$numDocumento';";

$resultado1 = mysql_query($sql1);

// Si la consulta no trae resultados se hacen los inserts
if (mysql_num_rows($resultado1) == 0) {
	// Si los arreglos que contienen las cantidades, productos y valores unitarios son tienen la misma cantidad de registros
	if ((count($arrayCantidades) == count($arrayProductos)) && (count($arrayCantidades) == count($arrayValoresUnitarios))) {
		for ($i=0; $i <= count($arrayCantidades) - 1; $i++) {
			// Solo si se seleccionó un producto y se indicó la cantidad se hace el insert
			if ($arrayProductos[$i] != null && $arrayCantidades[$i] != "0") {
				$sql = "INSERT INTO `compras` (`rutProveedor`,
					`periodo`,
					`codDocCompra`,
					`numeroDocCompra`,
					`codProducto`,
					`cantidadComprada`,
					`valorCompraNetoProducto`,
					`fechaCompra`)
				VALUES ('$rutCompletoProveedor',
					'$periodo',
					'$codDocCompra',
					'$numDocumento',
					'$arrayProductos[$i]',
					'$arrayCantidades[$i]',
					'$arrayValoresUnitarios[$i]',
					CURRENT_TIMESTAMP);";

				// Se ejecuta la primera query
				$resultado = $resultado && mysql_query($sql);
			}
		}
		$sql2 = "INSERT INTO `doccompra` (`numeroDocCompra`,
			`rutProveedor`,
			`fechaEmisionDoc`,
			`totalNeto`,
			`valorIvaDoc`,
			`valorTotalDoc`)
		VALUES ('$numDocumento',
			'$rutCompletoProveedor',
			'$fechaEmisionDocumento',
			'$valorTotalNeto',
			'$valorIvaDoc',
			'$valorTotalDoc');";

		// Si se ejecuta la primera query se ejecuta la 2da
		if ($resultado) {
			$resultado = $resultado && mysql_query($sql2);
		}
	}

	if(!$resultado){
		echo "\n SE HA DETECTADO EL SIGUIENTE ERROR AL INGRESAR LA COMPRA EN LA BASE DE DATOS: \n" . mysql_error();
	}else{
		echo "\n SE HA AGREGADO LA COMPRA.\n\nPROVEEDOR: $rutProveedor-$digitoVerificadorProveedor\nNUMERO FACTURA: $numDocumento";
	}
}else{
	echo "\n NO SE HA INGRESADO LA COMPRA, LA FACTURA ESTABA INGRESADA ANTERIORMENTE.";
}



//Cierro conexion
mysql_close($conexion);

?>