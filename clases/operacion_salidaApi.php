<?php
include_once("cochera.php");
include_once("empleado.php");
include_once("auto.php");
include_once("operacion_salida.php");
include_once("operacion_entrada.php");
include_once("../bd/AccesoDatos.php");
include_once("../phpExcel/Classes/PHPExcel.php");
include_once('../fpdf/fpdf.php');
class Operacion_SalidaApi
{

public function SacarAuto($request, $response, $args)
{
    //     $fecha_ingreso = new DateTime($datos["fecha_ingreso"]);
// $fecha_salida = new DateTime($datos["fecha_salida"]);
// //echo $diff = $fecha_salida->diff($fecha_ingreso)->format("%a");
// //echo $diff = $fecha_salida->diff($fecha_ingreso)->format('%a Day and %h hours');
// $diffDia = $fecha_salida->diff($fecha_ingreso)->format("%a");
// $diffHora = $fecha_salida->diff($fecha_ingreso)->format('%h');
// $diffDia = intval($diffDia);
// $diffHora = intval($diffHora);
// var_dump($diffDia);
// var_dump($diffHora);
// //$diff = $fecha_salida->diff($fecha_ingreso);
// // $hours = $diff->h;
// // $hours = $hours + ($diff->days*24);
// // echo $hours
$resp["status"] = 200;
$data = $request->getParsedBody();
$data["idEmpleado"] = intval($data["idEmpleado"]);
//$data["patente"] = intval($data["patente"]);
$data["idAuto"] = intval($data["idAuto"]);
// $auto = Auto::TraerElAutoPorPatente($data["patente"]);
// if($auto == false)
// {
//     $resp["status"] = 400;
// }
$operacion_salida = Operacion_Salida::TraerOperacionSalidaNoFinalizada($data["idAuto"]);
if($operacion_salida == false)
{
    $resp["status"] = 400;
}
$operacion_entrada = Operacion_Entrada::TraerLaOperacionEntrada($operacion_salida->idOperacionEntrada);
if($operacion_entrada == false)
{
    $resp["status"] = 400;
}
$cochera = Cochera::TraerLaCochera($operacion_entrada->idCochera);
if($cochera == false)
{
    $resp["status"] = 400;
}
if(!Cochera::ModificarLaCocheraLibre($cochera))
{
    $resp["status"] = 400;
}



// --------------------- IMPORTE -----------------------
//Primero creo la fecha de salida que seria el momento exacto donde el Usuario pone sacarAuto
// $dateTime = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
// $dateTime = $dateTime->format("m/d/y h:i A");
//Despues creo una instancia de DateTime para la fecha de salida, asi se puede usar un dateDiff
// $fecha_salida = new DateTime($dateTime);
$fecha_salida = new DateTime($data["fecha_salida"]);
$fecha_ingreso = new DateTime($operacion_entrada->fecha_ingreso);
$diffHora = $fecha_salida->diff($fecha_ingreso)->format('%h');
$diffDia = $fecha_salida->diff($fecha_ingreso)->format('%a');
// $resp["difHora"] = $diffHora;
$diffDia = intval($diffDia);
$diffHora = intval($diffHora);
if($diffDia == 0)
{
    if($diffHora == 12)
    {
       $importe = 90;
    }
    else
    {
        if($diffHora < 12)
        {
            $importe = $diffHora *10;
        }
        else if($diffHora > 12 && $diffHora < 24)
        {
          $importe = 90+($diffHora-12*10);
        }
    }
}
else if($diffDia >= 1)
{
   if($diffHora == 12)
    {
       $importe = ($diffDia*170)+90;
    }
    else
    {
        if($diffHora < 12)
        {
            $importe = ($diffDia*170)+$diffHora *10;
        }
        else if($diffHora > 12 && $diffHora < 24)
        {
          $importe = ($diffDia*170)+90+($diffHora-12*10);
        }
    }
}
// --------------------- IMPORTE -----------------------
//$fecha_salida = $fecha_salida->format("m/d/Y h:i A");
$operacion_salida->SetImporte($importe);
$operacion_salida->SetFechaSalida($data["fecha_salida"]);
$operacion_salida->SetIdEmpleado($data["idEmpleado"]);
if(!Operacion_Salida::ModificarOperacionSalida($operacion_salida))
{
    $resp["status"] = 400;
}
return $response->withJson($resp);
}

//GET DE TODAS LAS OPERACIONES SALIDAS - USADAS PARA VER OPERACIONES SEGÚN EL EMPLEADO
public function TraerTodasLasOperaciones($request, $response, $args)
{
$arrayOperacionesSalida = Operacion_Salida::TraerOperacionesFinalizadas();
$arrayOperacionesEntrada = Operacion_Entrada::TraerTodasLasOperacionesEntrada();
$arrayCocheras = Cochera::TraerTodasLasCocheras();
$arrayEmpleados = Empleado::TraerTodosLosEmpleados();
$arrayAutos = Auto::TraerTodosLosAutos();
$resp["operacionesSalida"] = $arrayOperacionesSalida;
$resp["cocheras"] = $arrayCocheras;
$resp["empleados"] = $arrayEmpleados;
$resp["autos"] = $arrayAutos;
$resp["operacionesEntrada"] = $arrayOperacionesEntrada;
return $response->withJson($resp);
}

//GET DE OPERACIONES FINALIZADAS Y NO FINALIZADAS

public function TraerOperacionesFinalizadas($request,$response,$args)
{
$arrayOperacionesSalida = Operacion_Salida::TraerOperacionesFinalizadas();
$arrayOperacionesEntrada = Operacion_Entrada::TraerTodasLasOperacionesEntrada();
$arrayCocheras = Cochera::TraerTodasLasCocheras();
$arrayEmpleados = Empleado::TraerTodosLosEmpleados();
$arrayAutos = Auto::TraerTodosLosAutos();
$resp["operacionesSalida"] = $arrayOperacionesSalida;
$resp["cocheras"] = $arrayCocheras;
$resp["empleados"] = $arrayEmpleados;
$resp["autos"] = $arrayAutos;
$resp["operacionesEntrada"] = $arrayOperacionesEntrada;
return $response->withJson($resp);
}

public function TraerOperacionesNoFinalizadas($request, $response, $args)
{
 $arrayOperacionesEntrada = Operacion_Entrada::TraerTodasLasOperacionesEntrada();
 $arrayOperacionesSalidaNoFinalizadas = Operacion_Salida::TraerOperacionesNoFinalizadas();
 $arrayAutos = Auto::TraerTodosLosAutos();
 $arrayCocheras = Cochera::TraerTodasLasCocheras();
 $arrayEmpleados = Empleado::TraerTodosLosEmpleados();
 $resp["cocheras"] = $arrayCocheras;
 $resp["empleados"] = $arrayEmpleados;
 $resp["autos"] = $arrayAutos;
 $resp["operacionesEntrada"] = $arrayOperacionesEntrada;
 $resp["operacionesNoFinalizadas"] = $arrayOperacionesSalidaNoFinalizadas;
 return $response->withJson($resp);
}

public function BuscarEntreFechas($request, $response, $args)
{
    $datos = $request->getParsedBody();
    $fecha_desde = new DateTime($datos["fecha_desde"]);
    $fecha_desde = $fecha_desde->format("m/d/Y h:i A");
    $fecha_hasta = new DateTime($datos["fecha_hasta"]);
    $fecha_hasta = $fecha_hasta->format("m/d/Y h:i A");
    $arrayOperacionesFechas = Operacion_Salida::BuscarEntreFechas($fecha_desde,$fecha_hasta);
    $arrayOperacionesEntrada = Operacion_Entrada::TraerTodasLasOperacionesEntrada();
    $arrayCocheras = Cochera::TraerTodasLasCocheras();
    $arrayEmpleados = Empleado::TraerTodosLosEmpleados();
    $arrayAutos = Auto::TraerTodosLosAutos();
    $resp["cocheras"] = $arrayCocheras;
    $resp["empleados"] = $arrayEmpleados;
    $resp["autos"] = $arrayAutos;
    $resp["operacionesEntrada"] = $arrayOperacionesEntrada;
    $resp["arrayOperacionesFechas"] = $arrayOperacionesFechas;
    return $response->withJson($resp);
}


public function CalcularFacturacion($request, $response, $args)
{
    $datos = $request->getParsedBody();
    $promedios = Operacion_Salida::CalcularFacturacionEntreFechas($datos["fecha_desde"],$datos["fecha_hasta"]);
    $cantidadPromedio = count($promedios);
    if($cantidadPromedio == 0)
    {
        $resp["status"] = 400;
    }
    else{
        $resp["facturacionEntreVehiculos"] = $promedios;
    $resp["totalAutos"] = count($promedios);
    $totalFacturacion = 0;
    for($i = 0; $i < count($promedios); $i++)
    {
       $totalFacturacion += $promedios[$i]["importesAcumulados"];
    }
    $resp["totalFacturacion"] = $totalFacturacion;
    }
    return $response->withJson($resp);
}


public function VerPromedioDeImportes($request,$response, $args)
{
    $datos = $request->getParsedBody();
    $promedios = Operacion_Salida::VerPromedioDeImportes($datos["fecha_desde"], $datos["fecha_hasta"]);
    $cantidadPromedio = count($promedios);
    $totalFacturacion = 0;
    if($cantidadPromedio == 0)
    {
        $resp["status"] = 400;
    }
    else
    {
        for($i = 0; $i < count($promedios); $i++)
       {
        $totalFacturacion += $promedios[$i]["importe"];
       }
       $resp["importesConPatentesYFechasSalidas"] = $promedios;
       $resp["promedioDeImportes"] = $cantidadPromedio;
       $resp["totalFacturado"] = $totalFacturacion;
    }
    return $response->withJson($resp);
}


public function DescargarExcelEntreFechas($request, $response, $args)
{
$datos = $request->getParsedBody();
$arrayOperaciones = Operacion_Salida::ExportarAutosQueSalieron($datos["fecha_desde"], $datos["fecha_hasta"]);
if (count($arrayOperaciones) > 0) {
   $objPHPExcel = new PHPExcel();
   
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("Ignacio")
        ->setLastModifiedBy("Ignacio")
        ->setTitle("ListaOperaciones")
        ->setSubject("Ejemplo 1")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("Ignacio hizo un Excel")
        ->setCategory("Operaciones");   
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
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("12");
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("10");
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue('FECHA DE SALIDA');
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleTextCenter);
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue('AUTO');
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleTextCenter);
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue('EMPLEADO');
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleTextCenter);
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue('IMPORTE');
$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleTextCenter);


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
 
    for($i=0;$i<count($arrayOperaciones);$i++)
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
      ->getStyle('A'.($i+2).':B'.($i+2))
      ->applyFromArray($styleTextCenter);
      $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('C'.($i+2))
      ->applyFromArray($styleTextCenter);
      $objPHPExcel->setActiveSheetIndex(0)
      ->getStyle('D'.($i+2))
      ->applyFromArray($styleTextCenter);

      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.($i+2), $arrayOperaciones[$i]["fecha_salida"])
            ->setCellValue('B'.($i+2), $arrayOperaciones[$i]["auto"])
            ->setCellValue('C'.($i+2), $arrayOperaciones[$i]["empleado"])
            ->setCellValue('D'.($i+2), "$".$arrayOperaciones[$i]["importe"]);
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
 $objPHPExcel->getActiveSheet()->getCell('F1')->setValue("Fecha de creación:");
 $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleArrayFecha);
$objPHPExcel->getActiveSheet()->getCell('F2')->setValue($fecha_creacion);
$objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($styleArrayFecha);
 }
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="listadoOperacionesSalida.xlsx"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
$content = $objWriter->toString();
$response->write($content);
return $response;
}

public function DescargarPDFEntreFechas($request, $response, $args)
{
   $datos = $request->getParsedBody();
$arrayOperaciones = Operacion_Salida::ExportarAutosQueSalieron($datos["fecha_desde"], $datos["fecha_hasta"]);
    // $resp["operacionesEntrada"] = $arrayOperaciones;
    // return $response->withJson($resp);
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 18);
$pdf->Cell(130, 10, 'Estacionamiento "Apart Car"', 0);
$pdf->SetFont('Arial', '', 9);
$dateTime = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
$fecha_creacion = $dateTime->format("Y/m/d h:i A");
$textoFecha = utf8_decode('Fecha de creación: ');
$pdf->Cell(40, 10, $textoFecha.$fecha_creacion.'', 0);
$pdf->Ln(15);
$pdf->SetFont('Times','BIU', 15);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'LISTADO DE OPERACIONES DE SALIDA', 0);
$pdf->Ln(23);
$pdf->SetFont('Arial','B', 14);
$pdf->SetTextColor(0,0,255);
$pdf->setFillColor('BLACK'); 
$pdf->Cell(60, 8, 'FECHA DE SALIDA',1,0,C,true);
$pdf->Cell(30, 8, 'AUTO', 1,0,C,true);
$pdf->Cell(78, 8, 'EMPLEADO QUE LO SACO', 1,0,C,true);
$pdf->Cell(30, 8, 'IMPORTE', 1,0,C,true);
$pdf->Ln(8);
$pdf->SetFont('Courier', 'I', 12);
$pdf->SetTextColor(0,0,0);
for($i=0;$i<count($arrayOperaciones);$i++)
{
    $pdf->Cell(60,8,$arrayOperaciones[$i]["fecha_salida"],1,0,C);
    $pdf->Cell(30,8,$arrayOperaciones[$i]["auto"],1,0,C);
    $pdf->Cell(78,8,$arrayOperaciones[$i]["empleado"],1,0,C);
    $pdf->Cell(30,8,"$".$arrayOperaciones[$i]["importe"],1,0,C);
    $pdf->Ln(8);
}
// header('Content-Type: application/pdf');
// header('Content-Disposition: attachment;filename="listadoOperaciones.pdf"');
// header('Cache-Control: max-age=0');
ob_end_clean();
$pdf->Output();

$response = $response->withHeader( 'Content-type', 'application/pdf' );
$response = $response->withHeader('Content-Disposition: attachment;filename="listadoOperacionesSalida.pdf');
$response = $reponse->withHeader("Cache-Control: max-age=0");
$content = $pdf->toString();
$response->write($content);
return $response;
}

}
?>