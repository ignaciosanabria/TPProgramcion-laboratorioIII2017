<?php
include_once("../bd/AccesoDatos.php");
include_once("../clases/cargo_empleado.php");
include_once("../clases/empleado.php");
include_once("../phpExcel/Classes/PHPExcel.php");

$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
$consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, cargo as cargo from cargo_empleado");
$consulta->execute();
$arrayCargos = $consulta->fetchAll(PDO::FETCH_CLASS,'cargo_empleado');
 
$objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
$consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, legajo as legajo, nombre as nombre, apellido as apellido , mail as mail, clave as clave, turno as turno, cargo as cargo from empleado");
$consulta->execute();
$arrayEmpleados = $consulta->fetchAll(PDO::FETCH_CLASS,'empleado');




 
 if (count($arrayEmpleados) > 0) {
   $objPHPExcel = new PHPExcel();
   
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("Ignacio")
        ->setLastModifiedBy("Ignacio")
        ->setTitle("ListaEmpleados")
        ->setSubject("Ejemplo 1")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("Ignacio hizo un Excel")
        ->setCategory("Empleados");

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

    $bordes = array(
    'borders' => array(
        'allborders' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => 'FF000000'),
        )
    ),
);

//AUMENTO DEL LARGO DE LAS CELDAS

// First, disable autosize:

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
// Now, you can set:
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("15");
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("35");   
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("15");            

//APLICACION DE LOS ESTILOS A LAS CELDAS CABECERAS

$objPHPExcel->getActiveSheet()->getCell('A1')->setValue('LEGAJO');
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleTextCenter);
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($bordes);

$objPHPExcel->getActiveSheet()->getCell('B1')->setValue('NOMBRE');
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleTextCenter);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($bordes);

$objPHPExcel->getActiveSheet()->getCell('C1')->setValue('APELLIDO');
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleTextCenter);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($bordes);

$objPHPExcel->getActiveSheet()->getCell('D1')->setValue('MAIL');
$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleTextCenter);
$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($bordes);

$objPHPExcel->getActiveSheet()->getCell('E1')->setValue('CLAVE');
$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleTextCenter);
$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($bordes);

$objPHPExcel->getActiveSheet()->getCell('F1')->setValue('TURNO');
$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleTextCenter);
$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($bordes);

$objPHPExcel->getActiveSheet()->getCell('G1')->setValue('CARGO');
$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleTextCenter);
$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($bordes);

    for($i=0;$i<count($arrayEmpleados);$i++)
    {
      $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('A'.($i+2).':B'.($i+2))
      ->applyFromArray($bordes);
      $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('C'.($i+2))
      ->applyFromArray($bordes);
       $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('D'.($i+2))
      ->applyFromArray($bordes);
       $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('E'.($i+2))
      ->applyFromArray($bordes);
       $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('F'.($i+2))
      ->applyFromArray($bordes);
      $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('G'.($i+2))
      ->applyFromArray($bordes);



       $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('A'.($i+2).':B'.($i+2))
      ->applyFromArray($styleTextCenter);
      $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('C'.($i+2))
      ->applyFromArray($styleTextCenter);
      $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('D'.($i+2))
      ->applyFromArray($styleTextCenter);
      $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('E'.($i+2))
      ->applyFromArray($styleTextCenter);
      $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('F'.($i+2))
      ->applyFromArray($styleTextCenter);
      $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('G'.($i+2))
      ->applyFromArray($styleTextCenter);


      
      $password = str_repeat("*", strlen($arrayEmpleados[$i]->clave)); 
      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.($i+2), $arrayEmpleados[$i]->legajo)
            ->setCellValue('B'.($i+2), $arrayEmpleados[$i]->nombre)
            ->setCellValue('C'.($i+2),$arrayEmpleados[$i]->apellido)
            ->setCellValue('D'.($i+2),$arrayEmpleados[$i]->mail)
            ->setCellValue('E'.($i+2),$password)
            ->setCellValue('F'.($i+2),$arrayEmpleados[$i]->turno);
    for($y = 0; $y < count($arrayCargos); $y++)
    {
        if($arrayCargos[$y]->id == $arrayEmpleados[$i]->cargo)
        {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($i+2),$arrayCargos[$y]->cargo);
        }
    }
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
 $objPHPExcel->getActiveSheet()->getCell('I1')->setValue("Fecha de creación:");
 $objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($styleArrayFecha);
$objPHPExcel->getActiveSheet()->getCell('I2')->setValue($fecha_creacion);
$objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($styleArrayFecha);
 }
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="listadoEmpleados.xlsx"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit;
?>