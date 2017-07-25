<?php
include_once('../../bd/AccesoDatos.php');
include_once('../../clases/auto.php');
include_once('../../fpdf/fpdf.php');
 
$objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
$consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, patente as patente, color as color , marca as marca from auto");
$consulta->execute();
$arrayAutos = $consulta->fetchAll(PDO::FETCH_CLASS,"auto");

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
$pdf->Cell(100, 8, 'LISTADO DE AUTOS', 0);
$pdf->Ln(23);
$pdf->SetFont('Arial','B', 14);
$pdf->SetTextColor(0,0,255);
$pdf->setFillColor('BLACK'); 
$pdf->Cell(50, 8, 'PATENTE',1,0,C,true);
$pdf->Cell(50, 8, 'MARCA', 1,0,C,true);
$pdf->Cell(50, 8, 'COLOR', 1,0,C,true);
$pdf->Ln(8);
$pdf->SetFont('Courier', 'I', 12);
$pdf->SetTextColor(0,0,0);
for($i=0;$i<count($arrayAutos);$i++)
{
    $pdf->Cell(50,8,$arrayAutos[$i]->patente,1,0,C);
    $pdf->Cell(50,8,$arrayAutos[$i]->marca,1,0,C);
    $pdf->Cell(50,8,$arrayAutos[$i]->color,1,0,C);
    $pdf->Ln(8);
}
ob_end_clean();
$pdf->Output();
?>