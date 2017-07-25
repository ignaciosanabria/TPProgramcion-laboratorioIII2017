<?php
include_once("cochera.php");
include_once("empleado.php");
include_once("auto.php");
include_once("operacion_entrada.php");
include_once("operacion_salida.php");
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
$arrayAutos = Auto::TraerTodosLosAutos();
$resp["cocheras"] = $arrayCocheras;
$resp["empleados"] = $arrayEmpleados;
$resp["autos"] = $arrayAutos;
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
$arrayAutos = Auto::TraerTodosLosAutos();
$resp["cocheras"] = $arrayCocheras;
$resp["empleados"] = $arrayEmpleados;
$resp["autos"] = $arrayAutos;
$resp["arrayOperacionesFechas"] = $arrayOperacionesFechas;
return $response->withJson($resp,200);
}

}
?>