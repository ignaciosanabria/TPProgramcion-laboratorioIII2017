<?php
include_once("cochera.php");
include_once("empleado.php");
include_once("auto.php");
include_once("operacion.php");
class operacionApi
{
public function IngresarOperacion($request, $response, $args) {
$datos = $request->getParsedBody();
$datos["idAuto"] = intval($datos["idAuto"]);
$datos["idCochera"] = intval($datos["idCochera"]);
$datos["idEmpleado"] = intval($datos["idEmpleado"]);
$resp["status"] = 200;
$resp["error"] = 200;
$cochera = Cochera::TraerLaCocheraPorIdYPrioridad($datos["idCochera"],$datos["prioridad"]);
if($cochera == false)
{
    $resp["error"] = 400;
}
else
{
$empleado = Empleado::TraerElEmpleado($datos["idEmpleado"]);
$empleado->SetCantidadOperaciones($empleado->GetCantidadOperaciones()+1);
if(!Empleado::ModificarElEmpleado($empleado))
{
    $resp["status"] = 400;
}
// //Cuando se ingresa una operacion se setea un el importe y fecha_salida con valores null
$operacion = new Operacion();
$operacion->idAuto = $datos["idAuto"];
$operacion->idCochera = $datos['idCochera'];
$operacion->idEmpleado = $datos["idEmpleado"];
$operacion->fecha_ingreso = $datos['fecha_ingreso'];
$operacion->importe = 0;
$operacion->fecha_salida = null;
if(!Operacion::InsertarLaOperacion($operacion))
{
    $resp["status"] = 400;
}
    $cochera->SetEstaLibre(chr(0));
    $cochera->SetVecesDeUso($cochera->GetVecesDeUso()+1);
     if(!Cochera::ModificarLaCochera($cochera))
     {
      $resp["status"] = 400;
     } 
}
return $response->withJson($resp);
}


public function SacarAuto($request, $response, $args) {
$dateTime = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
$fecha_salida = $dateTime->format("m/d/Y  h:i A");
$data = $request->getParsedBody();
$auto = Auto::TraerElAutoPorPatente($data["patente"]);
$operacion = Operacion::TraerLaOperacionPorIdAuto($auto->id);
$resp["status"] = 200;
// if($operacion->GetFechaSalida() != null && $operacion->GetImporte() != 0)
// {
//   $resp["status"] = 400;
// }
// else
// {
$cochera = Cochera::TraerLaCochera($operacion->idCochera);
$cochera->SetEstaLibre(chr(1));
Cochera::ModificarLaCochera($cochera);
// //PARA LA HORA - SACAR DIFERENCIA HORA E IMPORTE
$arrayFechaEntrada = preg_split("([ /:])",$operacion->fecha_ingreso);
$arrayFechaSalida = preg_split("([ /:])",$fecha_salida);
$importe = 0;
$diasDiferencias = intval($arrayFechaSalida[1]) - intval($arrayFechaEntrada[1]);
if($arrayFechaEntrada[5] == $arrayFechaSalida[6])
{
    if(($arrayFechaEntrada[5] == "PM" && $arrayFechaEntrada[3] != 12) || ($arrayFechaEntrada[5] == "AM" && $arrayFechaEntrada[3] != 12))
    {
    if(intval($arrayFechaSalida[4]) == intval($arrayFechaEntrada[3]))
    {
        $horasDiferencias = (intval($arrayFechaSalida[4]) - intval($arrayFechaEntrada[3])) + 24;
    }
    else if(intval($arrayFechaSalida[4]) < intval($arrayFechaEntrada[3]))
    {
        $horasDiferencias = (intval($arrayFechaSalida[4]) - intval($arrayFechaEntrada[3])) + 24;
    }
    else
    {
         $horasDiferencias = (intval($arrayFechaSalida[4]) - intval($arrayFechaEntrada[3]));
    }
    }
    else
    {
          $horasDiferencias = intval($arrayFechaSalida[4]);
    }
}
else if($arrayFechaEntrada[5] != $arrayFechaSalida[6])
{ 
    if(($arrayFechaEntrada[5] == "PM" && $arrayFechaEntrada[3] != 12) || ($arrayFechaEntrada[5] == "AM" && $arrayFechaEntrada[3] != 12))
    {
    if(intval($arrayFechaSalida[4]) == intval($arrayFechaEntrada[3]))
    {
    $horasDiferencias = (intval($arrayFechaSalida[4]) - intval($arrayFechaEntrada[3])) + 12;
    }
    else if(intval($arrayFechaSalida[4]) > intval($arrayFechaEntrada[3]))
    {
         $horasDiferencias = (intval($arrayFechaSalida[4]) - intval($arrayFechaEntrada[3])) + 12;
    }
    else
    {
         $horasDiferencias = (intval($arrayFechaSalida[4]) - intval($arrayFechaEntrada[3])) + 12;
    }
    }
    else
    {
        $horasDiferencias = (intval($arrayFechaSalida[4]) - intval($arrayFechaEntrada[3])) + 24;
    }
}


if($diasDiferencias == 0)
{
    if($horasDiferencias == 12)
    {
       $importe = 90;
    }
    else if($horasDiferencias == 24)
    {
        $importe = 170;
    }
    else
    {
        if($horasDiferencias < 12)
        {
            $importe = $horasDiferencias *10;
        }
        else if($horasDiferencias > 12)
        {
          $importe = 90+(($horasDiferencias-12)*10);
        }
    }
}
else if($diasDiferencias >= 1)
{
   if($horasDiferencias == 12)
    {
       $importe = ($diasDiferencias-1)*170+90;
    }
    else if($horasDiferencias == 24)
    {
        $importe = ($diasDiferencias-1)*170+170;
    }
    else
    {
        $importe = ($diasDiferencias-1)*170+($horasDiferencias*10);
    }
}

$operacion->SetImporte($importe);
$operacion->SetFechaSalida($fecha_salida);
Operacion::ModificarLaOperacionACerrar($operacion);
// }
return $response->withJson($resp);
}


public function TraerOperaciones($request,$response,$args)
{
$arrayOperaciones = Operacion::TraerTodasLasOperaciones();
$arrayCocheras = Cochera::TraerTodasLasCocheras();
$arrayEmpleados = Empleado::TraerTodosLosEmpleados();
$resp["operaciones"] = $arrayOperaciones;
$resp["Cocheras"] = $arrayCocheras;
$resp["empleados"] = $arrayEmpleados;
$response = $response->withJson($resp);
return $response;
}

}
?>