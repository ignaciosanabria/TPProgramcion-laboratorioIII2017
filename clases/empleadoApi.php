<?php
require_once("empleado.php");
include_once("cochera.php");
include_once("auto.php");
include_once("cargo_empleado.php");
include_once("../bd/AccesoDatos.php");
include_once("../phpExcel/Classes/PHPExcel.php");
include_once('../fpdf/fpdf.php');
// include composer autoload
require 'autoload.php';

// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;

class empleadoApi
{
public function IngresarEmpleado($request,$response,$args)
{
$data = $request->getParsedBody();
$data["legajo"] = intval($data["legajo"]);
if($data["turno"] == "null")
{
  $data["turno"] = "mañana";
}
$resp["status"] = 200;
$resp["nombre"] = $data["nombre"];
$empleado = new Empleado();
$empleado->SetLegajo($data["legajo"]);
$empleado->SetNombre($data["nombre"]);
$empleado->SetApellido($data["apellido"]);
$empleado->SetMail($data["mail"]);
$empleado->SetClave($data["clave"]);
$empleado->SetTurno($data["turno"]);
$empleado->SetHabilitado($data["habilitado"]);
$empleado->SetCargo(2);
$idEmpleado = Empleado::TraerUltimoIdAgregado();
$idEmpleado = intval($idEmpleado);
$idEmpleadoFoto = $idEmpleado+3;
$destino = "../fotosEmpleados/";
$files = $request->getUploadedFiles();
$nombreAnterior = $files['foto']->getClientFilename();
$extension= explode(".", $nombreAnterior) ;
$extension=array_reverse($extension);
$files['foto']->moveTo($destino.$idEmpleadoFoto.$data["nombre"].$data["apellido"].".".$extension[0]);
$empleado->SetFoto($idEmpleadoFoto.$data["nombre"].$data["apellido"].".".$extension[0]);
if(!Empleado::InsertarElEmpleado($empleado))
{
    $resp["status"] = 400;
}
return $response->withJson($resp);
}

public function TraerEmpleados($request, $response, $args)
{
$arrayEmpleados = Empleado::TraerTodosLosEmpleados();
for($i = 0; $i < count($arrayEmpleados); $i++)
{
    $password = str_repeat("*", strlen($arrayEmpleados[$i]->clave));
    $arrayEmpleados[$i]->clave = $password;
}
$resp["empleados"] = $arrayEmpleados;
$response = $response->withJson($resp);
return $response;
}


public function TraerElEmpleado($request, $response, $args)
{
$id = $args['id'];
$empleado = Empleado::TraerElEmpleado($id);
if($empleado == false)
{
    $resp["status"] = 400;
    $response = $response->withJson($resp);
}
else
{
$password = str_repeat("*", strlen($empleado->clave));
$empleado->clave = $password;
$response = $response->withJson($empleado);
}
return $response;
}

public function BorrarEmpleado($request, $response, $args)
{
$id = $args['id'];
$id = intval($id);
$resp["status"] = 200;
if(!Empleado::BorrarElEmpleado($id))
{
    $resp["status"] = 400;
}
return $response->withJson($resp);
}

public function ModificarEmpleado($request,$response,$args)
{
$id = $args['id'];
$id = intval($id);
$resp["status"] = 200;
$data = $request->getParsedBody();
$empleado = Empleado::TraerElEmpleado($id);
$empleado->SetLegajo($data["legajo"]);
$empleado->SetNombre($data["nombre"]);
$empleado->SetApellido($data["apellido"]);
$empleado->SetMail($data["mail"]);
$empleado->SetClave($data["clave"]);
$empleado->SetTurno($data["turno"]);
$empleado->SetCargo(2);
$empleado->SetHabilitado("si");
$fotosEmpleados = '../fotosEmpleados/';
$fotosBackup = '../fotosEmpleados/Backup/';
$arrayFotosBackup = scandir($fotosBackup);
$arrayFotosEmpleado = scandir($fotosEmpleados);
$pathFoto = explode('/',$empleado->GetFoto());
if(file_exists($fotosEmpleados.$empleado->GetFoto()))
{
    if($pathFoto[0] == "Backup")
{
     for($i = 0; $i < count($arrayFotosBackup); $i++)
   {
   $archivo = pathinfo($arrayFotosBackup[$i]);     
   if("Backup/".$archivo["basename"] == $empleado->foto)
      {
        if(rename("../fotosEmpleados/Backup/".$archivo["basename"],"../fotosEmpleados/Backup/".$id.$data["nombre"].$data["apellido"].".".$archivo["extension"]));
            {
                $empleado->SetFoto("Backup/".$id.$data["nombre"].$data["apellido"].".".$archivo["extension"]);
            }
      }
   }
}
else
{
 for($i = 0; $i < count($arrayFotosEmpleado); $i++)
{
   $archivo = pathinfo($arrayFotosEmpleado[$i]);     
   if($archivo["basename"] == $empleado->foto)
      {
        if(rename("../fotosEmpleados/".$archivo["basename"],"../fotosEmpleados/Backup/".$id.$data["nombre"].$data["apellido"].".".$archivo["extension"]));
            {
                $empleado->SetFoto("Backup/".$id.$data["nombre"].$data["apellido"].".".$archivo["extension"]);
            }
      }
    }
}
}

if(!Empleado::ModificarElEmpleado($empleado))
{
    $resp["status"] = 400;
}
return $response->withJson($resp);
}

public function SuspenderEmpleado($request,$response,$args)
{
    $data = $request->getParsedBody();
    $resp["status"] = 200;
    $id = $args['id'];
    $id = intval($id);
    $empleado = Empleado::TraerElEmpleado($id);
    if($empleado == false)
    {
        $resp["status"] = 400;
    }
    else
    {
    $empleado->SetHabilitado("no");
    if(!Empleado::SuspenderEmpleado($empleado))
    {
        $resp["status"] = 400;
    }
    }
    return $response->withJson($resp);
}


public function TraerEmpleadosCocherasAutos($request,$response,$args)
{
$arrayCocheras = Cochera::TraerTodasLasCocheras();
$arrayEmpleados = Empleado::TraerTodosLosEmpleados();
$arrayAutos = Auto::TraerTodosLosAutos();
$resp["cocheras"] = $arrayCocheras;
$resp["empleados"] = $arrayEmpleados;
$resp["autos"] = $arrayAutos;
return $response->withJson($resp);
}

public function HabilitarEmpleado($request,$response,$args)
{
    $data = $request->getParsedBody();
    $resp["status"] = 200;
    $id = $args['id'];
    $id = intval($id);
    $empleado = Empleado::TraerElEmpleado($id);
    if($empleado == false)
    {
        $resp["status"] = 400;
    }
    else
    {
    $empleado->SetHabilitado("si");
    if(!Empleado::SuspenderEmpleado($empleado))
    {
        $resp["status"] = 400;
    }
    }
    return $response->withJson($resp);
}

public function PonerMarcaDeAgua($request, $response, $args)
{
$id = $args['id'];
$id = intval($id);
$empleado = Empleado::TraerElEmpleado($id);
if($empleado == false)
{
$resp["status"] = 400;
}
else
{
$fotosEmpleados = '../fotosEmpleados/';
if(file_exists($fotosEmpleados.$empleado->GetFoto()))
{
   $infoFoto = pathinfo("../fotosEmpleados/".$empleado->GetFoto());
   // open an image file
   $img = Image::make($fotosEmpleados.$empleado->GetFoto());
   // and insert a watermark for example
   $img->insert($fotosEmpleados.'estampa.jpg','bottom-right', 10, 10);

   //finally we save the image as a new file
   $img->save($fotosEmpleados.'FotosMarcadas/'.$infoFoto["basename"]);
   $resp["status"] = 200;
}
   else
   {
     $resp["status"] = 400;
   }
}
return $response->withJson($resp);
}

public function VerSesionesEmpleado($request, $response, $args)
{
$id = $args['id'];
$id = intval($id);
$empleado = Empleado::TraerElEmpleado($id);
if($empleado == false)
{
    $resp["status "] = 400;
}
else
{
    $sesiones = Empleado::TraerFechasDeSesionesPorIdEmpleado($empleado->id);
    $password = str_repeat("*", strlen($empleado->clave));
    $empleado->clave = $password;
    $resp["empleado"] = $empleado;
    $resp["sesiones"] = $sesiones;
}
return $response->withJson($resp);
}


public function VerCantidadOperacionesEmpleado($request, $response, $args)
{
$id = $args['id'];
$id = intval($id);
$empleado = Empleado::TraerElEmpleado($id);
if($empleado == false)
{
    $resp["status "] = 400;
}
else
{
    $password = str_repeat("*", strlen($empleado->clave));
    $empleado->clave = $password;
    $operacionesEntrada = Empleado::TraerOperacionesEntradaPorIdEmpleado($empleado->id);
    $operacionesSalida = Empleado::TraerOperacionesSalidaPorIdEmpleado($empleado->id);
    $cantidadOperacionesEntrada = count($operacionesEntrada);
    $cantidadOperacionesSalida = count($operacionesSalida);
    $resp["empleado"] = $empleado;
    if($cantidadOperacionesEntrada == 0)
    {
        $operacionesEntrada = "EL EMPLEADO NO TIENE OPERACIONES DE ENTRADA";
    }
    else if($cantidadOperacionesSalida == 0)
    {
        $operacionesSalida = "EL EMPLEADO NO TIENE OPERACIONES DE SALIDA";
    }
    $resp["empleado"] = $empleado;
    $resp["operacionesEntrada"] = $operacionesEntrada;
    $resp["operacionesSalida"] = $operacionesSalida;
    $resp["cantidadOperacionesEntrada"] = $cantidadOperacionesEntrada;
    $resp["cantidadOperacionesSalida"] = $cantidadOperacionesSalida;
    $resp["cantidadDeOperacionesTotales"] = $cantidadOperacionesEntrada + $cantidadOperacionesSalida;

}
return $response->withJson($resp);
}

public function MostrarFotosMarcadas($request, $response, $args)
{
    $pathFotosMarcadas = "../fotosEmpleados/FotosMarcadas/";
    $arrayFotosMarcadas = scandir($pathFotosMarcadas);
    $resp["fotosMarcadas"] = $arrayFotosMarcadas;
    return $response->withJson($resp);
}


public function MostrarFotosCambiadas($request, $response, $args)
{
 $pathFotosCambiadas = "../fotosEmpleados/FotosCambiadasDeTamanio/";
    $arrayFotosCambiadas = scandir($pathFotosCambiadas);
    $resp["fotosCambiadas"] = $arrayFotosCambiadas;
    return $response->withJson($resp);   
}

public function CambiarTamanio($request, $response, $args)
{
$id = $args['id'];
$id = intval($id);
$empleado = Empleado::TraerElEmpleado($id);
if($empleado == false)
{
$resp["status"] = 400;
}
else
{
$fotosEmpleados = '../fotosEmpleados/';
if(file_exists($fotosEmpleados.$empleado->GetFoto()))
{
   $infoFoto = pathinfo("../fotosEmpleados/".$empleado->GetFoto());
   // open an image file
   $img = Image::make($fotosEmpleados.$empleado->GetFoto());

   // now you are able to resize the instance
   $img->resize(3000 , 2000);

   //finally we save the image as a new file
   $img->save($fotosEmpleados.'FotosCambiadasDeTamanio/'.$infoFoto["basename"]);
   $resp["status"] = 200;
}
   else
   {
     $resp["status"] = 400;
   }
}
return $response->withJson($resp);
}

public function DescargarListaEmpleadosExcel($request, $response, $args)
{
    $arrayEmpleados = Empleado::TraerTodosLosEmpleados();
    $arrayCargos = Cargo_Empleado::TraerTodosLosCargos();
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
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("15");
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
$content = $objWriter->toString();
$response->write($content);
return $response;

}


public function DescargarListaEmpleadosPDF($request, $response, $args)
{
$arrayEmpleados = Empleado::TraerTodosLosEmpleados();
$arrayCargos = Cargo_Empleado::TraerTodosLosCargos();
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
$pdf->Cell(100, 8, 'LISTADO DE EMPLEADOS', 0);
$pdf->Ln(23);
$pdf->SetFont('Arial','B', 12);
$pdf->SetTextColor(0,0,255);
$pdf->setFillColor('BLACK'); 
$pdf->Cell(15, 8, 'LEG.',1,0,C,true);
$pdf->Cell(30, 8, 'NOMBRE', 1,0,C,true);
$pdf->Cell(30,8,'APELLIDO',1,0,C,true);
$pdf->Cell(60, 8, 'MAIL', 1,0,C,true);
$pdf->Cell(20, 8, 'CLAVE', 1,0,C,true);
$pdf->Cell(17, 8, 'TURNO', 1,0,C,true);
$pdf->Cell(24, 8, 'CARGO', 1,0,C,true);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0,0,0);
for($i=0;$i<count($arrayEmpleados);$i++)
{
    $password = str_repeat("*", strlen($arrayEmpleados[$i]->clave)); 
    $pdf->Cell(15,8,$arrayEmpleados[$i]->legajo,1,0,C);
    $pdf->Cell(30,8,$arrayEmpleados[$i]->nombre,1,0,C);
    $pdf->Cell(30,8,$arrayEmpleados[$i]->apellido,1,0,C);
    $pdf->Cell(60,8,$arrayEmpleados[$i]->mail,1,0,C);
    $pdf->Cell(20,8,$password,1,0,C);
    $arrayEmpleados[$i]->turno = utf8_decode($arrayEmpleados[$i]->turno);
    $pdf->Cell(17,8,$arrayEmpleados[$i]->turno,1,0,C);
    for($y = 0; $y < count($arrayCargos); $y++)
    {
        if($arrayCargos[$y]->id == $arrayEmpleados[$i]->cargo)
        {
            $pdf->Cell(24,8,$arrayCargos[$y]->cargo,1);
        }
    }
    $pdf->Ln(8);
}
ob_end_clean();
$pdf->Output();
$response = $response->withHeader( 'Content-type', 'application/pdf' );
$response = $response->withHeader('Content-Disposition: attachment;filename="listadoEmpleados.pdf');
$response = $reponse->withHeader("Cache-Control: max-age=0");
$content = $pdf->toString();
$response->write($content);
return $response;
}

}
?>