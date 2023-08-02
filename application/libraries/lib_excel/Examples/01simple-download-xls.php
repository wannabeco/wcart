<?php 
	include "conexion.php";
	session_start();
	date_default_timezone_set('UTC');
	mysql_query("SET NAMES 'UTF8'");
	$hoy = date("Y-m-d");
	error_reporting('0');	$consulta = "SELECT concat(paterno,' ', materno, ' ' , nombre) AS alumno, fechanac, sexo, carrera FROM alumno ";
	$consulta .= " INNER JOIN carrera ON alumno.idcarrera = carrera.idcarrera ORDER BY carrera, nombre";
	$resultado = $conexion->query($consulta);

	if($resultado->num_rows > 0 ){
    	date_default_timezone_set('America/Mexico_City');  

    	if (PHP_SAPI == 'cli')
        die('Este archivo solo se puede ver desde un navegador web');  

	  	/** Se agrega la libreria PHPExcel */
	  	 require_once 'lib/PHPExcel/PHPExcel.php';
	  	 
	  	// Se crea el objeto PHPExcel
	  	 $objPHPExcel = new PHPExcel();

	  	 // Se asignan las propiedades del libro
	$objPHPExcel->getProperties()->setCreator("Codedrinks") // Nombre del autor
    ->setLastModifiedBy("Codedrinks") //Ultimo usuario que lo modificó
    ->setTitle("Reporte Excel con PHP y MySQL") // Titulo
    ->setSubject("Reporte Excel con PHP y MySQL") //Asunto
    ->setDescription("Reporte de alumnos") //Descripción
    ->setKeywords("reporte alumnos carreras") //Etiquetas
    ->setCategory("Reporte excel"); //Categorias

    $tituloReporte = "Relación de alumnos por carrera";
	$titulosColumnas = array('NOMBRE', 'FECHA DE NACIMIENTO', 'SEXO', 'CARRERA');

	// Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
	$objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:D1');
 
	// Se agregan los titulos del reporte
	$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1',$tituloReporte) // Titulo del reporte
    ->setCellValue('A3',  $titulosColumnas[0])  //Titulo de las columnas
    ->setCellValue('B3',  $titulosColumnas[1])
    ->setCellValue('C3',  $titulosColumnas[2])
    ->setCellValue('D3',  $titulosColumnas[3]);

    //Se agregan los datos de los alumnos
 
	 $i = 4; //Numero de fila donde se va a comenzar a rellenar
	 while ($fila = $resultado->fetch_array()) {
	     $objPHPExcel->setActiveSheetIndex(0)
	         ->setCellValue('A'.$i, $fila['alumno'])
	         ->setCellValue('B'.$i, $fila['fechanac'])
	         ->setCellValue('C'.$i, $fila['sexo'])
	         ->setCellValue('D'.$i, $fila['carrera']);
	     $i++;
	 }

		 $estiloTituloReporte = array(
	    'font' => array(
	        'name'      => 'Verdana',
	        'bold'      => true,
	        'italic'    => false,
	        'strike'    => false,
	        'size' =>16,
	        'color'     => array(
	            'rgb' => 'FFFFFF'
	        )
	    ),
	    'fill' => array(
	        'type'  => PHPExcel_Style_Fill::FILL_SOLID,
	        'color' => array(
	            'argb' => 'FF220835')
	    ),
	    'borders' => array(
	        'allborders' => array(
	            'style' => PHPExcel_Style_Border::BORDER_NONE
	        )
	    ),
	    'alignment' => array(
	        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        'rotation' => 0,
	        'wrap' => TRUE
	    )
	);
	 
	$estiloTituloColumnas = array(
	    'font' => array(
	        'name'  => 'Arial',
	        'bold'  => true,
	        'color' => array(
	            'rgb' => 'FFFFFF'
	        )
	    ),
	    'fill' => array(
	        'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
	    'rotation'   => 90,
	        'startcolor' => array(
	            'rgb' => 'c47cf2'
	        ),
	        'endcolor' => array(
	            'argb' => 'FF431a5d'
	        )
	    ),
	    'borders' => array(
	        'top' => array(
	            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
	            'color' => array(
	                'rgb' => '143860'
	            )
	        ),
	        'bottom' => array(
	            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
	            'color' => array(
	                'rgb' => '143860'
	            )
	        )
	    ),
	    'alignment' =>  array(
	        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
	        'wrap'      => TRUE
	    )
	);
	 
	$estiloInformacion = new PHPExcel_Style();
	$estiloInformacion->applyFromArray( array(
	    'font' => array(
	        'name'  => 'Arial',
	        'color' => array(
	            'rgb' => '000000'
	        )
	    ),
	    'fill' => array(
	    'type'  => PHPExcel_Style_Fill::FILL_SOLID,
	    'color' => array(
	            'argb' => 'FFd9b7f4')
	    ),
	    'borders' => array(
	        'left' => array(
	            'style' => PHPExcel_Style_Border::BORDER_THIN ,
	        'color' => array(
	                'rgb' => '3a2a47'
	            )
	        )
	    )
	));

	$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($estiloTituloColumnas);
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:D".($i-1));

	for($i = 'A'; $i <= 'D'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
	}

	// Se asigna el nombre a la hoja
	$objPHPExcel->getActiveSheet()->setTitle('Alumnos');
 
	// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
	$objPHPExcel->setActiveSheetIndex(0);
 
	// Inmovilizar paneles
	//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
	$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

	// Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Reportedealumnos.xlsx"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;
	}
	else{
	    print_r('No hay resultados para mostrar');
	}
?>