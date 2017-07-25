<?php
include_once("../bd/AccesoDatos.php");
include_once("../clases/auto.php");
include_once("../phpExcel/Classes/PHPExcel.php");
 
$arrayAutos = Auto::TraerTodosLosAutos();

 
 if (count($arrayAutos) > 0) {
   $objPHPExcel = new PHPExcel();
   
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("Ignacio")
        ->setLastModifiedBy("Ignacio")
        ->setTitle("ListaAutos")
        ->setSubject("Ejemplo 1")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("Ignacio hizo un Excel")
        ->setCategory("Autos");   
//ESTILOS        

$styleArray = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '000000'),
        'size'  => 12,
        'name'  => 'Verdana'
    ));

$styleColor = array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF0000')
        )
);

   $styleTextCenter = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );


// First, disable autosize:

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
// Now, you can set:
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("20");
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("20");
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue('PATENTE');
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleTextCenter);
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue('MARCA');
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleTextCenter);
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue('COLOR');
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleTextCenter);


$bordes = array(
    'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
    ),
);

$objPHPExcel->getActiveSheet()
            ->getStyle('A1:B1')
            ->applyFromArray($bordes);
$objPHPExcel->getActiveSheet()
            ->getStyle('C1')
            ->applyFromArray($bordes);
 
    for($i=0;$i<count($arrayAutos);$i++)
    {
      
      $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('A'.($i+2).':B'.($i+2))
      ->applyFromArray($bordes);
      $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('C'.($i+2))
      ->applyFromArray($bordes);
       
       $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('A'.($i+2).':B'.($i+2))
      ->applyFromArray($styleTextCenter);
      $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('C'.($i+2))
      ->applyFromArray($styleTextCenter);

      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.($i+2), $arrayAutos[$i]->patente)
            ->setCellValue('B'.($i+2), $arrayAutos[$i]->marca)
            ->setCellValue('C'.($i+2),$arrayAutos[$i]->color);
}
$styleArrayFecha = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '008000'),
        'size'  => 10,
        'name'  => 'Verdana'
    ));

  $dateTime = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
  $fecha_creacion = $dateTime->format("Y/m/d h:i A");
 $objPHPExcel->getActiveSheet()->getCell('E1')->setValue("Fecha de creación:");
 $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleArrayFecha);
$objPHPExcel->getActiveSheet()->getCell('E2')->setValue($fecha_creacion);
$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($styleArrayFecha);
 }
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="listadoAutos.xlsx"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
?>