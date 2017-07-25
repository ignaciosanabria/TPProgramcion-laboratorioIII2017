<?php
include_once("cochera.php");
include_once("empleado.php");
include_once("auto.php");
include_once("operacion_salida.php");
include_once("operacion_entrada.php");
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
$data["patente"] = intval($data["patente"]);
// $auto = Auto::TraerElAutoPorPatente($data["patente"]);
// if($auto == false)
// {
//     $resp["status"] = 400;
// }
$operacion_salida = Operacion_Salida::TraerOperacionSalidaNoFinalizada($data["patente"]);
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
$dateTime = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
$dateTime = $dateTime->format("m/d/y h:i A");
//Despues creo una instancia de DateTime para la fecha de salida, asi se puede usar un dateDiff
$fecha_salida = new DateTime($dateTime);
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
$fecha_salida = $fecha_salida->format("m/d/Y h:i A");
$operacion_salida->SetImporte($importe);
$operacion_salida->SetFechaSalida($fecha_salida);
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


public function CalcularImporte($request, $response, $args)
{
    $datos = $request->getParsedBody();
    $fecha_desde = new DateTime($datos["fecha_desde"]);
    $fecha_desde = $fecha_desde->format("m/d/Y h:i A");
    $fecha_hasta = new DateTime($datos["fecha_hasta"]);
    $fecha_hasta = $fecha_hasta->format("m/d/Y h:i A");
    $arrayOperacionesFechas = Operacion_Salida::BuscarEntreFechas($fecha_desde,$fecha_hasta);
    $arrayOperacionesEntrada = Operacion_Entrada::TraerTodasLasOperacionesEntrada();
    $importe = Operacion_Salida::CalcularImporteEntreFechas($fecha_desde,$fecha_hasta);
    $resp["importe"] = $importe;
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

}
?>