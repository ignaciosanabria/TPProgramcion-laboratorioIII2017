<?php
include_once('../clases/auto.php');
include_once('../clases/operacion.php');

//Vienen del Ajax

// $patente = $_POST["patente"];
// $marca = $_POST['marca'];
// $color = $_POST['color'];
// $fecha_ingreso = $_POST['fecha_ingreso'];
// $idCochera = $_POST['idCochera'];

//P
$resp["status"] = 200;

// $auto = new Auto();
$operacion = new Operacion();

// $auto->SetPatente($patente);
// $auto->SetMarca($marca);
// $auto->SetColor($color);
var_dump($operacion);



$patente = "BJX 220";
$dateTime = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
$fecha_ingreso = $dateTime->format("m/d/y  H:i A");
$idCochera = 3;

$operacion->SetPatente($patente);
$operacion->SetFechaIngreso($fecha_ingreso);
$operacion->SetIdCochera($idCochera);
$operacion->SetFechaSalida(null);
$operacion->SetImporte(null);
Operacion::InsertarLaOperacion($operacion);
$operacion_dump = Operacion::TraerLaOperacionPorPatente($patente);
var_dump($operacion_dump);
//Cuando se ingresa una operacionse setea un operacion con valores 0
//var_dump(Operacion::InsertarLaOperacion($operacion));

//HACER UN MODIFICAR DE COCHERA QUE SE PONGA EN ESTAOCUPADO

// if(!(Auto::InsertarElAuto($auto)))
// {
//     $resp["status"] = 400;
// }
// if(!Operacion::InsertarLaOperacion($operacion)
// {
//     $resp["status"] = 400;
// }
echo $resp["status"];
?>