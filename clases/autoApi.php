<?php
include_once("auto.php");
include_once("../bd/AccesoDatos.php");
include_once("../phpExcel/Classes/PHPExcel.php");
include_once('../fpdf/fpdf.php');
class autoApi
{
public function TraerTodos($request,$response,$args)
{
  $arrayAutos = Auto::TraerTodosLosAutos();
  $resp["autos"] = $arrayAutos;
  return $response->withJson($resp);
}

public function InsertarAuto($request, $response, $args)
{
$datos = $request->getParsedBody();
$resp["status"] = 200;
if(Auto::VerificarPatente($datos['patente']))
{
$auto = new Auto();
$auto->patente = $datos['patente'];
$auto->color = $datos['color'];
$auto->marca = $datos['marca'];
if(!Auto::InsertarElAuto($auto))
{
 $resp["status"] = 400;
}
}
else
{
  $resp["status"] = 401;
}
return $response->withJson($resp);
}

public function BorrarAuto($request, $response, $args)
{
  $id = $args["id"];
  $resp["status"] = 200;
  $auto = Auto::TraerElAuto($id);
  if($auto == false)
  {
    $resp["status"] = 400;
  }
  else
  {
    if(!Auto::BorrarElAuto($auto->id))
  {
    $resp["status"] = 400;
  }
  }
  return $response->withJson($resp);
}

public function TraerUnAuto($request,$response,$args)
{
  $id = $args["id"];
  $auto = Auto::TraerElAuto($id);
  if($auto == false)
  {
    $resp["status"] = 400;
  }
  else
  {
    $resp["auto"] = $auto;
  }
  return $response->withJson($resp);
}

public function ModificarAuto($request,$response,$args)
{
  $id = $args["id"];
  $datos = $request->getParsedBody();
  $auto = Auto::TraerElAuto($id);
  if($auto == false)
  {
    $resp["status"] = 400;
  }
  else
  {
  $auto->SetMarca($datos["marca"]);
  $auto->SetPatente($datos["patente"]);
  $auto->SetColor($datos["color"]);
  $resp["status"] = 200;
  if(!Auto::ModificarElAuto($auto))
  {
    $resp["status"] = 400;
  }
  }
  return $response->withJson($resp);
}

public function DescargarListaAutosExcel($request, $response, $args)
{
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
$content = $objWriter->toString();
$response->write($content);
return $response;
// exit;



//       $file = 'hernan.jpg';

// if (file_exists($file)) {
//     header('Content-Description: File Transfer');
//     header('Content-Type: application/octet-stream');
//     header('Content-Disposition: attachment;filename="'.basename($file).'"');
//     header('Expires: 0');
//     header('Cache-Control: must-revalidate');
//     header('Pragma: public');
//     header('Content-Length: ' . filesize($file));
//     readfile($file);
//     return $response;
// }
}

public function DescargarListaAutosPDF($request, $response, $args)
{
// $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
// $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, patente as patente, color as color , marca as marca from auto");
// $consulta->execute();
// $arrayAutos = $consulta->fetchAll(PDO::FETCH_CLASS,"auto");

// $pdf = new FPDF();
// $pdf->AddPage();
// $pdf->SetFont('Arial', '', 18);
// $pdf->Cell(130, 10, 'Estacionamiento "Apart Car"', 0);
// $pdf->SetFont('Arial', '', 9);
// $dateTime = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
// $fecha_creacion = $dateTime->format("Y/m/d h:i A");
// $textoFecha = utf8_decode('Fecha de creación: ');
// $pdf->Cell(40, 10, $textoFecha.$fecha_creacion.'', 0);
// $pdf->Ln(15);
// $pdf->SetFont('Times','BIU', 15);
// $pdf->Cell(70, 8, '', 0);
// $pdf->Cell(100, 8, 'LISTADO DE AUTOS', 0);
// $pdf->Ln(23);
// $pdf->SetFont('Arial','B', 14);
// $pdf->SetTextColor(0,0,255);
// $pdf->setFillColor('BLACK'); 
// $pdf->Cell(50, 8, 'PATENTE',1,0,C,true);
// $pdf->Cell(50, 8, 'MARCA', 1,0,C,true);
// $pdf->Cell(50, 8, 'COLOR', 1,0,C,true);
// $pdf->Ln(8);
// $pdf->SetFont('Courier', 'I', 12);
// $pdf->SetTextColor(0,0,0);
// for($i=0;$i<count($arrayAutos);$i++)
// {
//     $pdf->Cell(50,8,$arrayAutos[$i]->patente,1,0,C);
//     $pdf->Cell(50,8,$arrayAutos[$i]->marca,1,0,C);
//     $pdf->Cell(50,8,$arrayAutos[$i]->color,1,0,C);
//     $pdf->Ln(8);
// }
// header('Content-Type: application/pdf');
// header('Content-Disposition: attachment;filename="listadoAutos.pdf"');
// header('Cache-Control: max-age=0');
// $pdf->Output();
$response = $response->withHeader( 'Content-type', 'application/pdf' );
include_once('../enlaces/Archivos/descargarListaAutosPDF.php');
$content = $pdf->toString();
$response->write($content);
return $response;
}

}
?>