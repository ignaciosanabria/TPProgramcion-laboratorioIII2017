<?php
include_once('../clases/operacion.php');
//Vienen del ajax
//$patente = $_POST['patente'];
$patente = "MMM 215";
$fecha_salida = $_POST['fecha_salida'];
$resp["status"] = 200;
//El importe se calcula en esta vista
$importe = 0;
//Traigo la operacion donde se encuentra la patente
$operacion = Operacion::TraerLaOperacionPorPatente($patente);
var_dump($operacion);
$operacion->SetFechaSalida($fecha_salida);


//AQUI Va el Codigo de calcular el importe

$operacion->SetImporte($importe);


//Operacion::ModificarLaOperacionACerrar($operacion);s

?>