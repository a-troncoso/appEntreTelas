<?php

include('conec.php');

$fechaVentas = $_GET['fecha'];
// $fechaVentas = "2015-03-16";

// $sql = "SELECT SUM(subtotal)
// 	FROM pedidos_consumos
// 	WHERE pedidos_consumos.fechapedido = '$fechaIngreso'
// 	AND pedidos_consumos.estadoconfirmado = '1'
// 	GROUP BY pedidos_consumos.fechapedido;";

// // $datos = $conexion->query($sql);
// $datos = mysql_query($sql);


// $arrDatos = array();
// if(!$datos){
// 	echo 'Ha ocurrido un error al cargar el ingreso total del día ' . mysql_error();
// }else{
// 	// while ($fila = $datos->fetch_array()) {
// 	while ($fila = mysql_fetch_array($datos)) {
// 		$arrDatos[] = array_map('utf8_encode', $fila);
// 	}
// }
// if (count($arrDatos) == 0) {
// 	$totalDia = 0;
// }else{
// 	$totalDia = $arrDatos[0][0];
// }

$sql1 = "SELECT documentosdepago.nombreDocPago AS 'Documento',
MIN(ventas.numDocPago) AS 'Rango menor',
MAX(ventas.numDocPago) AS 'Rango mayor',
ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))  AS 'Total',
documentosdepago.codDocPago
FROM documentosdepago, productos, ventas
WHERE documentosdepago.codDocPago = ventas.codDocPago
AND productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE(ventas.fechaVenta) = '$fechaVentas'
GROUP BY (documentosdepago.nombreDocPago);";

$sql2 = "SELECT ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida)) AS 'Total'
FROM documentosdepago, productos, ventas
WHERE documentosdepago.codDocPago = ventas.codDocPago
AND productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND (ventas.codDocPago = '2' OR ventas.codDocPago = '3' OR ventas.codDocPago = '4' OR ventas.codDocPago = '5' OR ventas.codDocPago = '6')
AND DATE(ventas.fechaVenta) = '$fechaVentas';";

$sql3 = "SELECT mediosdepago.nombreMedioPago AS 'Medio pago',
ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida)) AS 'Total'
FROM mediosdepago, productos, ventas
WHERE mediosdepago.codMedioPago = ventas.codMedioPago
AND productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE(ventas.fechaVenta) = '$fechaVentas'
GROUP BY (mediosdepago.nombreMedioPago);";

$sql4 = "SELECT ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida)) AS 'Total'
FROM mediosdepago, productos, ventas
WHERE mediosdepago.codMedioPago = ventas.codMedioPago
AND productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND (ventas.codMedioPago = '2' OR ventas.codMedioPago = '3' OR ventas.codMedioPago = '4' OR ventas.codMedioPago = '4' OR ventas.codMedioPago = '5' OR ventas.codMedioPago = '6' OR ventas.codMedioPago = '7')
AND DATE(ventas.fechaVenta) = '$fechaVentas';";

$sql5 = "SELECT vendedores.nombreVendedor  AS 'Nombre vendedor',
ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida)) AS 'Total'
FROM vendedores, productos, ventas
WHERE vendedores.rutVendedor = ventas.rutVendedor
AND productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE(ventas.fechaVenta) = '$fechaVentas'
GROUP BY (vendedores.rutVendedor);";

$sql6 = "SELECT ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida)) AS 'Total'
FROM vendedores, productos, ventas
WHERE vendedores.rutVendedor = ventas.rutVendedor
AND productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE(ventas.fechaVenta) = '$fechaVentas';";

$sql7 = "SELECT vendedores.nombreVendedor 'Nombre vendedor',
COUNT(DISTINCT ventas.numTicket) 'Clientes atendidos'
FROM vendedores, ventas
WHERE vendedores.rutVendedor = ventas.rutVendedor
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE(ventas.fechaVenta) = '$fechaVentas'
GROUP BY vendedores.nombreVendedor;";

$sql8 = "SELECT COUNT(DISTINCT ventas.numTicket) 'Total clientes atendidos'
FROM vendedores, ventas
WHERE ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE(ventas.fechaVenta) = '$fechaVentas';";

$datos1 = mysql_query($sql1);
$datos2 = mysql_query($sql2);
$datos3 = mysql_query($sql3);
$datos4 = mysql_query($sql4);
$datos5 = mysql_query($sql5);
$datos6 = mysql_query($sql6);
$datos7 = mysql_query($sql7);
$datos8 = mysql_query($sql8);

if(mysql_num_rows($datos1) > 0 AND mysql_num_rows($datos2) > 0 AND mysql_num_rows($datos3) > 0 AND mysql_num_rows($datos4) > 0 AND mysql_num_rows($datos5) > 0 AND mysql_num_rows($datos6) > 0 AND mysql_num_rows($datos7) > 0 AND mysql_num_rows($datos8) > 0){

	if (PHP_SAPI == 'cli') die('Este archivo solo se puede ver desde un navegador web');

	/** Se agrega la libreria PHPExcel */
	require_once 'lib/PHPExcel/PHPExcel.php';

	// $str_json = file_get_contents('php://input');

	// Se crea el objeto PHPExcel
	$objPHPExcel = new PHPExcel();

	// Se asignan las propiedades del libro
	$objPHPExcel->getProperties()->setCreator("Alvaro Troncoso") // Nombre del autor
	    ->setLastModifiedBy("Alvaro") //Ultimo usuario que lo modificó
	    ->setTitle("Detalle ventas del dia " . $fechaVentas) // Titulo
	    ->setSubject("Ventas diarias") //Asunto
	    ->setDescription("Esta hoja almacena las ventas del dia seleccionado.") //Descripción
	    ->setKeywords("detalles ventas dia") //Etiquetas
	    ->setCategory("Reporte excel"); //Categorias

	// Para los títulos del reporte voy a crear dos variables, 
	// de esta forma es un poco más fácil realizar algunos cambios si es que el reporte fuera muy extenso.
	$tituloReporte = "Cierre de caja día " . $fechaVentas;
	$titulosColumnasTablaPorDoc = array('Documento', 'Rango de boletas', 'Total');
	$titulosColumnasTablaPorMedioPago = array('Medio de pago', 'Total');
	$titulosColumnasTablaPorVendedor = array('Nombre vendedor', 'Total');
	$titulosColumnasTablaClientesAtendidosPorVendedor = array('Nombre vendedor', 'Clientes atendidos');
	

	// El reporte como ya se habrán dado cuenta va a tener solo 4 columnas:
	// Nombre, Fecha de nacimiento, sexo y carrera. Por lo tanto solo vamos a ocupar hasta la columna D.

	// Agrego datos del local en la cabecera
	$objPHPExcel->setActiveSheetIndex(0)
	    ->setCellValue('A1', 'Comercializadora Entre-Telas Ltda.') // Titulo del reporte
	    ->setCellValue('A2', 'Rut: 76.337.718-0')  //Titulo de las columnas
	    ->setCellValue('A3', 'Telefono: 632-213981')
	    ->setCellValue('A4', 'Chacabuco #569');

	// Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
	$objPHPExcel->setActiveSheetIndex(0)
	    ->mergeCells('A6:C6');
	
	// Se agregan los titulos del reporte
	$objPHPExcel->setActiveSheetIndex(0)
	    ->setCellValue('A6', $tituloReporte) // Titulo del reporte
	    ->setCellValue('A8', $titulosColumnasTablaPorDoc[0])  //Titulo de las columnas
	    ->setCellValue('B8', $titulosColumnasTablaPorDoc[1])
	    ->setCellValue('C8', $titulosColumnasTablaPorDoc[2]);

	// Hasta este punto ya se tiene el archivo con los datos ahora procedemos a aplicar el formato a las celdas.
	// Para ello vamos a crear 3 variables, la primera va a contener el estilo del título del reporte,
	// la segunda el estilo del título de las columnas y la tercera el estilo de la información de los alumnos.
	$estiloTituloReporte = array(
	    'font' => array(
	        'name'      => 'Verdana',
	        'bold'      => true,
	        'italic'    => false,
	        'strike'    => false,
	        'size'		=> 11,
	        'color'     => array('rgb' => '000000')
	    ),
	    'fill' => array(
	        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
	        'color' => array('argb' => 'ffffff')
	    ),
	    'borders' => array(
	        'allborders' => array(
	            'style' => PHPExcel_Style_Border::BORDER_NONE
	        )
	    ),
	    'alignment' => array(
	        'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        'vertical'		=> PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        'rotation'		=> 0,
	        'wrap'			=> TRUE
	    )
	);
	
	$estiloTituloColumnas = new PHPExcel_Style();
	$estiloTituloColumnas->applyFromArray(array(
	    'font' => array(
	        'name'  => 'Verdana',
	        'bold'  => true,
	        'color' => array('rgb' => '000000')
	    ),
	    'fill' => array(
	        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
	        'color' => array('argb' => 'D4D4D4')
	    ),
	    'borders' => array(
	        'top' => array(
	            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
	            'color' => array('rgb' => '143860')
	        ),
	        'bottom' => array(
	            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
	            'color' => array('rgb' => '143860')
	        ),
	        'left' => array(
	            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
	            'color' => array('rgb' => '143860')
	        ),
	        'right' => array(
	            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
	            'color' => array('rgb' => '143860')
	        )
	    ),
	    'alignment' =>  array(
	        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        'wrap'      => FALSE
	    )
	));
	 
	$estiloInformacion = new PHPExcel_Style();
	$estiloInformacion->applyFromArray( array(
	    'font' => array(
	        'name'  => 'Arial',
	        'color' => array('rgb' => '000000')
	    ),
	    'fill' => array(
	    'type'  => PHPExcel_Style_Fill::FILL_SOLID,
	    'color' => array('argb' => 'FFFFFF')
	    ),
	    'borders' => array(
	        'left' => array(
	            'style' => PHPExcel_Style_Border::BORDER_DOTTED ,
		        'color' => array('rgb' => '3a2a47')
	        ),
	        'right' => array(
	            'style' => PHPExcel_Style_Border::BORDER_DOTTED ,
		        'color' => array('rgb' => '3a2a47')
	        ),
	        'bottom' => array(
	            'style' => PHPExcel_Style_Border::BORDER_THIN ,
		        'color' => array('rgb' => '3a2a47')
	        )
	    ),
	    'alignment' =>  array(
	        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
	        'wrap'      => FALSE
	    )
	));

	$estiloTotal = array(
	    'font' => array(
	        'name'  => 'Arial',
	        'bold'  => true,
	        'color' => array('rgb' => '000000')
	    ),
	    'fill' => array(
	        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
	        'color' => array('argb' => 'FFFFFF')
	    ),
	    'borders' => array(
	        'top' => array(
	            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
	            'color' => array('rgb' => '143860')
	        ),
	        'bottom' => array(
	            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
	            'color' => array('rgb' => '143860')
	        ),
	        'left' => array(
	            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
	            'color' => array('rgb' => '143860')
	        ),
	        'right' => array(
	            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
	            'color' => array('rgb' => '143860')
	        )
	    ),
	    'alignment' =>  array(
	        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
	        'wrap'      => FALSE
	    )
	);

	// La forma más rápida de dar formato a las celdas es a través de arreglos
	// en los cuales se define todo el conjunto de formato que deseamos aplicar a las celdas. Veamos cómo se aplican.

	// Se aplica estilo del titulo general de la hoja
	$objPHPExcel->getActiveSheet()->getStyle('A6:C6')->applyFromArray($estiloTituloReporte);

	// Como pueden apreciar para asignar contenido a una celda se selecciona primero la hoja
	// con setActiveSheetIndex(Indice de hoja) y después con setCellValue(celda, valor) asignamos el contenido a la celda deseada.

	//Se agregan los datos de los alumnos
	 
	$i = 9; //Numero de fila donde se va a comenzar a rellenar
	while ($fila = mysql_fetch_array($datos1)) {
		$objPHPExcel->setActiveSheetIndex(0)
	        ->setCellValue('A'.$i, $fila['Documento'])
	        ->setCellValue('B'.$i, $fila['Rango menor'] . ' - ' . $fila['Rango mayor'])
	        ->setCellValue('C'.$i, '$ ' . number_format($fila['Total'], 0, '.', '.'));
	    $i++;
	}

	// Se aplica estilo al encabezado de la tabla por documento
	// $objPHPExcel->getActiveSheet()->getStyle('A8:C8')->applyFromArray($estiloTituloColumnas);
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloTituloColumnas, "A8:C8");
	// Se aplica estilo del contenido de la tabla por documento
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A9:C" . ($i-1));

	// Se agrega la informacion contenida en datos2 (total por documento)
	while ($fila = mysql_fetch_array($datos2)) {
		$objPHPExcel->setActiveSheetIndex(0)
	        ->setCellValue('A'.$i, 'TOTAL')
	        ->setCellValue('C'.$i, '$ ' . number_format($fila['Total'], 0, '.', '.'));
	    $i++;
	}

	// Se aplica estilo al total por documento
	$objPHPExcel->getActiveSheet()->getStyle("A".($i-1).":C".($i-1))->applyFromArray($estiloTotal);

	// Se salta una fila, esto lo hago sumandole uno a $i
	$i = $i + 1;

	// Se agregan los titulos de la tabla por medio de pago
	$objPHPExcel->setActiveSheetIndex(0)
	    ->setCellValue('A' . $i, $titulosColumnasTablaPorMedioPago[0])
	    ->setCellValue('B' . $i, $titulosColumnasTablaPorMedioPago[1]);

	// Se aplica estilo al encabezado tabla por medio de pago
	// $objPHPExcel->getActiveSheet()->getStyle("A".$i.":B".$i)->applyFromArray($estiloTituloColumnas);
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloTituloColumnas, "A".$i.":B".$i);

	// Se suma uno a $i para que se empiece a rellenar desde la sigte fila
	$i = $i + 1;
	$j = $i;

	// Se agregan los datos de la consulta contenida de datos3 (ventas por medio de pago)
	while ($fila = mysql_fetch_array($datos3)) {
		$objPHPExcel->setActiveSheetIndex(0)
	        ->setCellValue('A'.$i, $fila['Medio pago'])
	        ->setCellValue('B'.$i, '$ ' . number_format($fila['Total'], 0, '.', '.'));
	    $i++;
	}

	// Se aplica estilo del contenido de la tabla por medio de pago
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A".$j.":B".($i-1));

	// Se agrega la informacion contenida en datos4 (total por medio de pago)
	while ($fila = mysql_fetch_array($datos4)) {
		$objPHPExcel->setActiveSheetIndex(0)
	        ->setCellValue('A'.$i, 'TOTAL')
	        ->setCellValue('B'.$i, '$ ' . number_format($fila['Total'], 0, '.', '.'));
	    $i++;
	}

	// Se aplica estilo al total por medio de pago
	$objPHPExcel->getActiveSheet()->getStyle("A".($i-1).":B".($i-1))->applyFromArray($estiloTotal);

	// Se salta una fila, esto lo hago sumandole uno a $i
	$i = $i + 1;

	// Se agregan los titulos de la tabla por vendedor
	$objPHPExcel->setActiveSheetIndex(0)
	    ->setCellValue('A' . $i, $titulosColumnasTablaPorVendedor[0])
	    ->setCellValue('B' . $i, $titulosColumnasTablaPorVendedor[1]);

	// Se aplica estilo al encabezado de la tabla por medio de pago
	// $objPHPExcel->getActiveSheet()->getStyle("A".$i.":B".$i)->applyFromArray($estiloTituloColumnas);
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloTituloColumnas, "A".$i.":B".$i);

	// Se suma uno a $i para que se empiece a rellenar desde la sigte fila
	$i = $i + 1;
	$j = $i;

	// Se agregan los datos de la consulta contenida de datos5 (ventas por vendedor)
	while ($fila = mysql_fetch_array($datos5)) {
		$objPHPExcel->setActiveSheetIndex(0)
	        ->setCellValue('A'.$i, $fila['Nombre vendedor'])
	        ->setCellValue('B'.$i, '$ ' . number_format($fila['Total'], 0, '.', '.'));
	    $i++;
	}

	// Se aplica estilo del contenido de la tabla por medio de pago
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A".$j.":B".($i-1));

	// Se agrega la informacion contenida en datos6 (total por vendedor)
	while ($fila = mysql_fetch_array($datos6)) {
		$objPHPExcel->setActiveSheetIndex(0)
	        ->setCellValue('A'.$i, 'TOTAL')
	        ->setCellValue('B'.$i, '$ ' . number_format($fila['Total'], 0, '.', '.'));
	    $i++;
	}

	// Se aplica estilo al total por vendedor
	$objPHPExcel->getActiveSheet()->getStyle("A".($i-1).":B".($i-1))->applyFromArray($estiloTotal);

	// Se salta una fila, esto lo hago sumandole uno a $i
	$i = $i + 1;

	// Se agregan los titulos de la tabla por vendedor
	$objPHPExcel->setActiveSheetIndex(0)
	    ->setCellValue('A' . $i, $titulosColumnasTablaClientesAtendidosPorVendedor[0])
	    ->setCellValue('B' . $i, $titulosColumnasTablaClientesAtendidosPorVendedor[1]);

	// Se aplica estilo al encabezado de la tabla por medio de pago
	// $objPHPExcel->getActiveSheet()->getStyle("A".$i.":B".$i)->applyFromArray($estiloTituloColumnas);
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloTituloColumnas, "A".$i.":B".$i);

	// Se suma uno a $i para que se empiece a rellenar desde la sigte fila
	$i = $i + 1;
	$j = $i;

	// Se agregan los datos de la consulta contenida de datos5 (ventas por vendedor)
	while ($fila = mysql_fetch_array($datos7)) {
		$objPHPExcel->setActiveSheetIndex(0)
	        ->setCellValue('A'.$i, $fila['Nombre vendedor'])
	        ->setCellValue('B'.$i, $fila['Clientes atendidos']);
	    $i++;
	}

	// Se aplica estilo del contenido de la tabla clientes atendidos por vendedor
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A".$j.":B".($i-1));

	// Se agrega la informacion contenida en datos8 (total clientes atendidos en el dia)
	while ($fila = mysql_fetch_array($datos8)) {
		$objPHPExcel->setActiveSheetIndex(0)
	        ->setCellValue('A'.$i, 'TOTAL')
	        ->setCellValue('B'.$i, $fila['Total clientes atendidos']);
	    $i++;
	}

	// Se aplica estilo al total clientes atendidos
	$objPHPExcel->getActiveSheet()->getStyle("A".($i-1).":B".($i-1))->applyFromArray($estiloTotal);

	// Ahora procedemos a asignar el ancho de las columnas de forma automática
	// en base al contenido de cada una de ellas y lo hacemos con un ciclo de la siguiente forma.
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(23);

	for($i = 'B'; $i <= 'C'; $i++){
	    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setWidth(23);
	}

	// Bien, ahora solo agregamos algunos detalles mas

	// Se asigna el nombre a la hoja
	$objPHPExcel->getActiveSheet()->setTitle($fechaVentas);
	 
	// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
	$objPHPExcel->setActiveSheetIndex(0);

	// Ya para terminar vamos a enviar el archivo para que el usuario lo descargue.

	// Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment; filename="Ventas día ' . $fechaVentas .'.xlsx"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');

	exit;
}else{
	print_r('No se han realizado ventas al dia ' . $fechaVentas);
}

//Cierro
mysql_close($conexion);

?>