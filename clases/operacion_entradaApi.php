<?php
include_once("cochera.php");
include_once("empleado.php");
include_once("auto.php");
include_once("operacion_entrada.php");
include_once("operacion_salida.php");
include_once("../bd/AccesoDatos.php");
include_once("../phpExcel/Classes/PHPExcel.php");
include_once('../fpdf/fpdf.php');
class Operacion_EntradaApi
{
    
public function IngresarOperacionEntrada($request, $response, $args)
{
$datos = $request->getParsedBody();
$resp["status"] = 200;
if(Cochera::VerificarSiCocheraEstaDisponible($datos["idCochera"],$datos["idAuto"]))
{
// Ingreso un auto - Se ingresa a las operaciones de Entrada
$operacion_entrada = new Operacion_Entrada();
$operacion_entrada->SetIdAuto($datos['idAuto']);
$operacion_entrada->SetIdCochera($datos['idCochera']);
$operacion_entrada->SetIdEmpleado($datos['idEmpleado']);
$operacion_entrada->SetFechaIngreso($datos['fecha_ingreso']);
if(!Operacion_Entrada::InsertarLaOperacionEntrada($operacion_entrada))
{
    $resp["status"] = 400;
}
//La cochera pasa a estar ocupada por un auto - idAuto
$cochera = Cochera::TraerLaCochera($datos["idCochera"]);
$cochera->SetIdAuto($datos["idAuto"]);
if(!Cochera::ModificarLaCocheraOcupada($cochera))
{
    $resp["status"] = 400;
}
$idOperacionEntrada = Operacion_Entrada::TraerUltimoIdAgregado(); 
// Cuando se ingresa un auto - Este va a tener una salida pero con fecha salida en Null e importe en 0
$operacion_salida = new Operacion_Salida();
$operacion_salida->SetIdOperacionEntrada($idOperacionEntrada);
$operacion_salida->SetImporte(0);
$operacion_salida->SetIdAuto($datos["idAuto"]);
if(!Operacion_Salida::InsertarOperacionSalida($operacion_salida))
{
    $resp["status"] = 400;
}
}
else
{
    $resp["status"] = 400;
}
return $response->withJson($resp);
}



public function TraerOperacionesEntrada($request,$response,$args)
{
$arrayOperacionesEntrada = Operacion_Entrada::TraerTodasLasOperacionesEntrada();
$arrayCocheras = Cochera::TraerTodasLasCocheras();
$arrayEmpleados = Empleado::TraerTodosLosEmpleados();
$arrayOperaciones = Auto::TraerTodosLosOperaciones();
$resp["cocheras"] = $arrayCocheras;
$resp["empleados"] = $arrayEmpleados;
$resp["Operaciones"] = $arrayOperaciones;
$resp["operacionesEntrada"] = $arrayOperacionesEntrada;
$response = $response->withJson($resp);
return $response;
}

public function BuscarOperacionesFechas($request, $response, $args)
{
$datos = $request->getParsedBody();
$arrayOperacionesFechas = Operacion_Entrada::BuscarEntreFechas($datos["fecha_desde"],$datos["fecha_hasta"]);
$arrayCocheras = Cochera::TraerTodasLasCocheras();
$arrayEmpleados = Empleado::TraerTodosLosEmpleados();
$arrayOperaciones = Auto::TraerTodosLosOperaciones();
$resp["cocheras"] = $arrayCocheras;
$resp["empleados"] = $arrayEmpleados;
$resp["Operaciones"] = $arrayOperaciones;
$resp["arrayOperacionesFechas"] = $arrayOperacionesFechas;
return $response->withJson($resp,200);
}

public function DescargarPDFEntreFechas($request, $response, $args)
{
    $datos = $request->getParsedBody();
    $arrayOperaciones = Operacion_Entrada::ExportarAutosQueEntraron($datos["fecha_desde"], $datos["fecha_hasta"]);
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
$pdf->Cell(100, 8, 'LISTADO DE OPERACIONES DE ENTRADA', 0);
$pdf->Ln(23);
$pdf->SetFont('Arial','B', 14);
$pdf->SetTextColor(0,0,255);
$pdf->setFillColor('BLACK'); 
$pdf->Cell(60, 8, 'FECHA DE INGRESO',1,0,C,true);
$pdf->Cell(30, 8, 'AUTO', 1,0,C,true);
$pdf->Cell(30, 8, 'COCHERA', 1,0,C,true);
$pdf->Cell(78, 8, 'EMPLEADO QUE ESTACIONO', 1,0,C,true);
$pdf->Ln(8);
$pdf->SetFont('Courier', 'I', 12);
$pdf->SetTextColor(0,0,0);
for($i=0;$i<count($arrayOperaciones);$i++)
{
    $pdf->Cell(60,8,$arrayOperaciones[$i]["fecha_ingreso"],1,0,C);
    $pdf->Cell(30,8,$arrayOperaciones[$i]["auto"],1,0,C);
    $pdf->Cell(30,8,$arrayOperaciones[$i]["cochera"],1,0,C);
    $pdf->Cell(78,8,$arrayOperaciones[$i]["empleado"],1,0,C);
    $pdf->Ln(8);
}
// header('Content-Type: application/pdf');
// header('Content-Disposition: attachment;filename="listadoOperaciones.pdf"');
// header('Cache-Control: max-age=0');
ob_end_clean();
$pdf->Output();

$response = $response->withHeader( 'Content-type', 'application/pdf' );
$response = $response->withHeader('Content-Disposition: attachment;filename="listadoOperaciones.pdf');
$response = $reponse->withHeader("Cache-Control: max-age=0");
$content = $pdf->toString();
$response->write($content);
return $response;
}

public function DescargarExcelEntreFechas($request, $response, $args)
{
$datos = $request->getParsedBody();
$arrayOperaciones = Operacion_Entrada::ExportarAutosQueEntraron($datos["fecha_desde"], $datos["fecha_hasta"]);

 
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
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("10");
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("5");
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("35");
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue('FECHA DE INGRESO');
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleTextCenter);
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue('AUTO');
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleTextCenter);
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue('COCHERA');
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleColor);
$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleTextCenter);
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue('EMPLEADO');
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
            ->setCellValue('A'.($i+2), $arrayOperaciones[$i]["fecha_ingreso"])
            ->setCellValue('B'.($i+2), $arrayOperaciones[$i]["auto"])
            ->setCellValue('C'.($i+2), $arrayOperaciones[$i]["cochera"])
            ->setCellValue('D'.($i+2), $arrayOperaciones[$i]["empleado"]);
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
header('Content-Disposition: attachment;filename="listadoAutos.xlsx"');
header('Cache-Control: max-age=0');

$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
$content = $objWriter->toString();
$response->write($content);
return $response;
}


public function TraerVecesQueVinieronLosMismosAutos($request, $response, $args)
{
    $datos = $request->getParsedBody();
    $vehiculosIngresados = Operacion_Entrada::TraerVecesQueVinieronLosAutos($datos["fecha_desde"], $datos["fecha_hasta"]);
    $cantidadAutos = count($vehiculosIngresados);
    if($cantidadAutos == 0)
    {
        $resp["status"] = 400;
    }
    else
    {
        $resp["vecesQueVinoElMismoAuto"] = $vehiculosIngresados;
     }
     return $response->withJson($resp);
}

public function TraerVecesQueVinoElMismoAuto($request, $response, $args)
{
    $id = $args['id'];
    $id = intval($id);
    $datos = $request->getParsedBody();
    $auto = Auto::TraerElAuto($id);
    if($auto == false)
    {
        $resp["status"] = 400;
    }
    else
    {
        $vecesQueVinoElAuto = Operacion_Entrada::TraerVecesQueVinoElAutoPorIdAuto($datos["fecha_desde"], $datos["fecha_hasta"], $auto->id);
        $cantidadArrayVeces = count($vecesQueVinoElAuto);
        if($cantidadArrayVeces == 0)
        {
            $resp["status"] = 400;
        }
        else
        {
        $resp["vecesQueVinoElAuto"] = $vecesQueVinoElAuto;
        }
    }
    return $response->withJson($resp);
}

public function TraerVehiculosEstacionadosSinRepetir($request, $response, $args)
{
    $datos = $request->getParsedBody();
    $vehiculosDistintos = Operacion_Entrada::TraerAutosDistintosQueVinieron($datos["fecha_desde"], $datos["fecha_hasta"]);
    $cantidadAutos = count($vehiculosDistintos);
    if($cantidadAutos == 0)
    {
        $resp["status"] = 400;
    }
    else
    {
        $resp["vehiculosDistintos"] = $vehiculosDistintos;
        $resp["cantidadVehiculosDistintos"] = $cantidadAutos;
    }
    return $response->withJson($resp);
}


public function VerPromedioDeCocheraYEmpleado($request, $response, $args)
{
    $datos = $request->getParsedBody();
    $promedio = Operacion_Entrada::VerPromedioDeCocheraYEmpleado($datos["fecha_desde"], $datos["fecha_hasta"]);
    $cantidadPromedio = count($promedio);
    if($cantidadPromedio == 0)
    {
        $resp["status"] = 400;
    }
    else
    {
        $resp["UsoDeCocheraPorEmpleado"] = $promedio;
        $resp["promedioDeUsos"] = $cantidadPromedio;
    }
    return $response->withJson($resp);
}

public function VerPromedioDeCocheraYAuto($request, $response, $args)
{
    $datos = $request->getParsedBody();
    $promedio = Operacion_Entrada::VerPromedioDeCocheraYAuto($datos["fecha_desde"], $datos["fecha_hasta"]);
    $cantidadPromedio = count($promedio);
    if($cantidadPromedio == 0)
    {
        $resp["status"] = 400;
    }
    else
    {
        $resp["UsoDeCocheraPorAuto"] = $promedio;
        $resp["promedioDeUsos"] = $cantidadPromedio;
    }
    return $response->withJson($resp);
}


public function VerPromedioDePatentes($request, $response, $args)
{
    $datos = $request->getParsedBody();
    $promedio = Operacion_Entrada::VerPromedioDePatentes($datos["fecha_desde"], $datos["fecha_hasta"]);
    $cantidadPromedio = count($promedio);
    if($cantidadPromedio == 0)
    {
        $resp["status"] = 400;
    }
    else
    {
        $resp["patentesYVecesQueVino"] = $promedio;
        $resp["promedioPatentes"] = $cantidadPromedio;
    }
    return $response->withJson($resp);
}

}
?>