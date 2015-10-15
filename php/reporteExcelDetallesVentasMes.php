<?php

include('conec.php');

$mesVentas = $_GET['mes'];
$mesEnPalabra = "";

switch ($mesVentas) {
    case "01":
        $mesEnPalabra = "ENERO";
        break;
    case "02":
        $mesEnPalabra = "FEBRERO";
        break;
    case "03":
        $mesEnPalabra = "MARZO";
        break;
    case "04":
        $mesEnPalabra = "Abril";
        break;
    case "05":
        $mesEnPalabra = "Mayo";
        break;
    case "06":
        $mesEnPalabra = "Junio";
        break;
    case "07":
        $mesEnPalabra = "Julio";
        break;
    case "08":
        $mesEnPalabra = "Agosto";
        break;
    case "09":
        $mesEnPalabra = "Septiembre";
        break;
    case "10":
        $mesEnPalabra = "Octubre";
        break;
    case "11":
        $mesEnPalabra = "Noviembre";
        break;
    case "12":
        $mesEnPalabra = "Diciembre";
        break;
    default:
       $mesEnPalabra = "Mes no definido";
}

$sql1 = "SELECT `DATE_FORMAT(ventas.fechaVenta, '%d')` AS 'Dia',
	GROUP_CONCAT(if(`total dia` = 'total dia', `Name_exp_3`, NULL)) AS 'Total dia',
	GROUP_CONCAT(if(`total dia` = 'total por boleta', `Name_exp_3`, NULL)) AS 'Total boletas',

	GROUP_CONCAT(if(`total dia` = 'total por boleta', `0`, NULL)) AS 'Primera boleta',
	GROUP_CONCAT(if(`total dia` = 'total por boleta', `My_exp_0`, NULL)) AS 'Ultima boleta',

	GROUP_CONCAT(if(`total dia` = 'total por factura', `Name_exp_3`, NULL)) AS 'Total facturas',

	GROUP_CONCAT(if(`total dia` = 'total por factura', `0`, NULL)) AS 'Primera factura',
	GROUP_CONCAT(if(`total dia` = 'total por factura', `My_exp_0`, NULL)) AS 'Ultima factura',

	GROUP_CONCAT(if(`total dia` = 'total por voucher transbank', `Name_exp_3`, NULL)) AS 'Total voucher transbank',

	GROUP_CONCAT(if(`total dia` = 'total por voucher transbank', `0`, NULL)) AS 'Primer voucher transbank',
	GROUP_CONCAT(if(`total dia` = 'total por voucher transbank', `My_exp_0`, NULL)) AS 'Ultimo voucher transbank'

	FROM vistaVentasMesPorDoc
	GROUP BY `DATE_FORMAT(ventas.fechaVenta, '%d')`
	ORDER BY `DATE_FORMAT(ventas.fechaVenta, '%d')`;";

// TOTAL DEL MES
$sql2 = "SELECT ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM productos, ventas
WHERE productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mesVentas';";

// TOTAL MES POR BOLETA
$sql3 = "SELECT ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM productos, ventas
WHERE productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND ventas.codDocPago = '2'
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mesVentas';";

// CANTIDAD DE BOLETAS EMITIDAS EN EL MES
$sql4 = "SELECT MAX(ventas.numDocPago) - MIN(ventas.numDocPago) + 1
FROM ventas
WHERE ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND ventas.codDocPago = '2'
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mesVentas';";

// TOTAL MES POR FACTURA
$sql5 = "SELECT ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM productos, ventas
WHERE productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND ventas.codDocPago = '3'
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mesVentas';";

// CANTIDAD DE FACTURAS EMITIDAS EN EL MES
$sql6 = "SELECT MAX(ventas.numDocPago) - MIN(ventas.numDocPago) + 1
FROM ventas
WHERE ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND ventas.codDocPago = '3'
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mesVentas';";

// TOTAL MES POR VOUCHER TRANSBANK
$sql7 = "SELECT ROUND(SUM(((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))+((productos.valorVentaNetoProducto-(productos.valorVentaNetoProducto*ventas.porcentajeDescuento*0.01))*0.19))*ventas.cantidadVendida))
FROM productos, ventas
WHERE productos.codProducto = ventas.codProducto
AND ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND ventas.codDocPago = '4'
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mesVentas';";

// CANTIDAD DE VOUCHER TRANSBANK EMITIDOS EN EL MES
$sql8 = "SELECT MAX(ventas.numDocPago) - MIN(ventas.numDocPago) + 1
FROM ventas
WHERE ventas.estadoPagado = 1
AND ventas.estadoConfirmado = 1
AND ventas.codDocPago = '4'
AND DATE_FORMAT(ventas.fechaVenta, '%m') = '$mesVentas';";

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
	    ->setTitle("Resumen del mes " . $mesVentas) // Titulo
	    ->setSubject("Ventas diarias") //Asunto
	    ->setDescription("Esta hoja almacena las ventas del dia seleccionado.") //Descripción
	    ->setKeywords("detalles ventas mes " . $mesVentas) //Etiquetas
	    ->setCategory("Reporte excel"); //Categorias

	// Para los títulos del reporte voy a crear dos variables, 
	// de esta forma es un poco más fácil realizar algunos cambios si es que el reporte fuera muy extenso.
	$tituloReporte = "RESUMEN DE VENTAS MES " . $mesEnPalabra;
	$titulosColumnasTablaPorDoc = array('DÍA', 'T. VENTAS', 'T. BOLETAS', 'RANGO BOLETAS', 'T. FACTURAS', 'RANGO FACTURAS', 'T. VOUCHER', 'RANGO VOUCHER');
	

	// El reporte como ya se habrán dado cuenta va a tener solo 4 columnas:
	// Nombre, Fecha de nacimiento, sexo y carrera. Por lo tanto solo vamos a ocupar hasta la columna D.

	// Agrego datos del local en la cabecera
	$objPHPExcel->setActiveSheetIndex(0)
	    ->setCellValue('A1', 'Comercializadora Entre-Telas Ltda.') // Titulo del reporte
	    ->setCellValue('A2', 'Rut: 76.337.718-0')  //Titulo de las columnas
	    ->setCellValue('A3', 'Teléfono: 632-213981')
	    ->setCellValue('A4', 'Chacabuco #569');

	// Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
	$objPHPExcel->setActiveSheetIndex(0)
	    ->mergeCells('A6:H6');
	
	// Se agregan los titulos del reporte
	$objPHPExcel->setActiveSheetIndex(0)
	    ->setCellValue('A6', $tituloReporte) // Titulo del reporte
	    ->setCellValue('A8', $titulosColumnasTablaPorDoc[0])  //Titulo de las columnas
	    ->setCellValue('B8', $titulosColumnasTablaPorDoc[1])
	    ->setCellValue('C8', $titulosColumnasTablaPorDoc[2])
	    ->setCellValue('D8', $titulosColumnasTablaPorDoc[3])
	    ->setCellValue('E8', $titulosColumnasTablaPorDoc[4])
	    ->setCellValue('F8', $titulosColumnasTablaPorDoc[5])
	    ->setCellValue('G8', $titulosColumnasTablaPorDoc[6])
	    ->setCellValue('H8', $titulosColumnasTablaPorDoc[7]);

	// Hasta este punto ya se tiene el archivo con los datos ahora procedemos a aplicar el formato a las celdas.
	// Para ello vamos a crear 3 variables, la primera va a contener el estilo del título del reporte,
	// la segunda el estilo del título de las columnas y la tercera el estilo de la información de los alumnos.
	$estiloTituloReporte = array(
	    'font' => array(
	        'name'      => 'Verdana',
	        'bold'      => true,
	        'italic'    => false,
	        'strike'    => false,
	        'size'		=> 9,
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
	        'color' => array('rgb' => '000000'),
	        'size'		=> 9
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
	        'color' => array('rgb' => '000000'),
	        'size'	=> 9
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

	$estiloTotal = new PHPExcel_Style();
	$estiloTotal -> applyFromArray(array(
	    'font' => array(
	        'name'  => 'Arial',
	        'bold'  => true,
	        'color' => array('rgb' => '000000'),
	        'size'	=> 9
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
	            'style' => PHPExcel_Style_Border::BORDER_DOTTED ,
	            'color' => array('rgb' => '143860')
	        ),
	        'right' => array(
	            'style' => PHPExcel_Style_Border::BORDER_DOTTED ,
	            'color' => array('rgb' => '143860')
	        )
	    ),
	    'alignment' =>  array(
	        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
	        'wrap'      => FALSE
	    )
	));

	// La forma más rápida de dar formato a las celdas es a través de arreglos
	// en los cuales se define todo el conjunto de formato que deseamos aplicar a las celdas. Veamos cómo se aplican.

	// Se aplica estilo del titulo general de la hoja
	$objPHPExcel->getActiveSheet()->getStyle('A6:H6')->applyFromArray($estiloTituloReporte);

	// Como pueden apreciar para asignar contenido a una celda se selecciona primero la hoja
	// con setActiveSheetIndex(Indice de hoja) y después con setCellValue(celda, valor) asignamos el contenido a la celda deseada.

	//Se agregan los datos de los alumnos

	$i = 9; //Numero de fila donde se va a comenzar a rellenar
	while ($fila = mysql_fetch_array($datos1)) {
		$objPHPExcel->setActiveSheetIndex(0)
	        ->setCellValue('A'.$i, $fila['Dia'])
	        ->setCellValue('B'.$i, number_format($fila['Total dia'], 0, '.', '.'))
	        ->setCellValue('C'.$i, number_format($fila['Total boletas'], 0, '.', '.'))
	        ->setCellValue('D'.$i, $fila['Primera boleta'] . ' - ' . $fila['Ultima boleta'])
	        ->setCellValue('E'.$i, number_format($fila['Total facturas'], 0, '.', '.'))
	        ->setCellValue('F'.$i, $fila['Primera factura'] . ' - ' . $fila['Ultima factura'])
	        ->setCellValue('G'.$i, number_format($fila['Total voucher transbank'], 0, '.', '.'))
	        ->setCellValue('H'.$i, $fila['Primer voucher transbank'] . ' - ' . $fila['Ultimo voucher transbank']);
	    $i++;
	}

	// Se aplica estilo al encabezado de la tabla ventas del mes
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloTituloColumnas, "A8:H8");
	// Se aplica estilo del contenido de la tabla por documento
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A9:H" . ($i-1));

	$arrDatos = array();

	while ($rs = mysql_fetch_array($datos2)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	while ($rs = mysql_fetch_array($datos3)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	while ($rs = mysql_fetch_array($datos4)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	while ($rs = mysql_fetch_array($datos5)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	while ($rs = mysql_fetch_array($datos6)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	while ($rs = mysql_fetch_array($datos7)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}
	while ($rs = mysql_fetch_array($datos8)) {
		$arrDatos[] = array_map('utf8_encode', $rs);
	}

	$objPHPExcel->setActiveSheetIndex(0)
	        ->setCellValue("A".$i, "TOTAL");

	$letra = "B";
	for ($j=0; $j <= 6; $j++) {
	    $objPHPExcel->setActiveSheetIndex(0)
	        ->setCellValue($letra.$i, number_format($arrDatos[$j][0], 0, '.', '.'));
	    $letra++;
	}

	// Se aplica estilo al total por documento
	// $objPHPExcel->getActiveSheet()->getStyle("A".($i).":H".($i))->applyFromArray($estiloTotal);
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloTotal, "A".($i).":H".($i));

	// Ahora procedemos a asignar el ancho de las columnas de forma automática
	// en base al contenido de cada una de ellas y lo hacemos con un ciclo de la siguiente forma.
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(7);

	for($i = 'B'; $i <= 'C'; $i++){
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setWidth(11.8);
	}

	for($i = 'D'; $i <= 'H'; $i++){
		// $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
	    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setWidth(18.5);
	}

	// Bien, ahora solo agregamos algunos detalles mas

	// Se asigna el nombre a la hoja
	$objPHPExcel->getActiveSheet()->setTitle($mesEnPalabra);
	 
	// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
	$objPHPExcel->setActiveSheetIndex(0);

	// Ya para terminar vamos a enviar el archivo para que el usuario lo descargue.

	// Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment; filename="Resumen ventas mes ' . $mesEnPalabra .'.xlsx"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');

	exit;
}else{
	print_r('No se han realizado ventas en el mes ' . $mesEnPalabra);
}

//Cierro
mysql_close($conexion);

?>