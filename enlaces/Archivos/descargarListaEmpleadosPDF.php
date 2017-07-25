<?php
include_once('../../bd/AccesoDatos.php');
include_once("../../clases/cargo_empleado.php");
include_once('../../clases/empleado.php');
include_once('../../fpdf/fpdf.php');

$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
$consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, cargo as cargo from cargo_empleado");
$consulta->execute();
$arrayCargos = $consulta->fetchAll(PDO::FETCH_CLASS,'cargo_empleado');
 
$objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
$consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, legajo as legajo, nombre as nombre, apellido as apellido , mail as mail, clave as clave, turno as turno, cargo as cargo from empleado");
$consulta->execute();
$arrayEmpleados = $consulta->fetchAll(PDO::FETCH_CLASS,'empleado');

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
?>