<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'autoload.php';
include_once('../clases/usuario.php');
include_once('../clases/auto.php');
include_once('../clases/operacion.php');
include_once('../clases/empleado.php');
include_once('../clases/cochera.php');

$app = new \Slim\App;

//LLEVAR HORA DE INICIO AL LOGIN

$app->get('/TraerHoraInicio', function (Request $request, Response $response) {
$dateTime = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
$fecha_salida = $dateTime->format("m/d/Y  H:i A");
$resp["hora"] = $fecha_salida;
return $response->withJson($resp);
});


//API DE USUARIO ADMINISTRADOR

//PUEDE INGRESAR EMPLEADO O ADMINISTRADOR-usuario

$app->post('/ValidarUsuario', function (Request $request, Response $response) {
   $datos = $request->getParsedBody();
   $resp["status"] = 400;
   $resp["tipo"] = $datos["tipo"];
   $resp["hora"] = $datos["horaLogin"];
   if($datos["tipo"] == "administrador")
   {
       if(Usuario::VerificarUsuario($datos['mail'],$datos['clave']) == "ok")
         {
      $resp["status"] = 200;
        }
        else{
            $resp["status"] = 400;
        } 
   }
   else
   {
     if(Empleado::VerificarEmpleado($datos['mail'],$datos['clave']) == "ok")
      {
       $resp["status"] = 200;
       $empleado = Empleado::TraerElEmpleadoPorMailYClave($datos['mail'],$datos['clave']);
   if(!$empleado)
   {
       $resp["id"] = false;
   }
   else
   {
       $resp["id"] = $empleado->GetId();
   }
      }
      else
      {
          $resp["status"] = 400;
      }
   }
   return $response->withJson($resp);
});

//EN LOS VALORES BIT SETEARLOS CON chr(0o1)

$app->post('/IngresarAutoOperacion', function (Request $request, Response $response) {
$datos = $request->getParsedBody();
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

$auto = new Auto();
$auto->patente = $datos['patente'];
$auto->color = $datos['color'];
$auto->marca = $datos['marca'];
// //Cuando se ingresa una operacion se setea un el importe y fecha_salida con valores null
$operacion = new Operacion();
$operacion->patente = $datos['patente'];
$operacion->idCochera = $datos['idCochera'];
$operacion->idEmpleado = $datos["idEmpleado"];
$operacion->fecha_ingreso = $datos['fecha_ingreso'];
$operacion->importe = 0;
$operacion->fecha_salida = null;
if(!Operacion::InsertarLaOperacion($operacion))
{
    $resp["status"] = 400;
}
if(!Auto::InsertarElAuto($auto))
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
});


$app->post('/SacarAuto', function (Request $request, Response $response) {
$dateTime = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
$fecha_salida = $dateTime->format("m/d/Y  h:i A");
$data = $request->getParsedBody();
$operacion = Operacion::TraerLaOperacionPorPatente($data["patente"]);
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
        $importe = $horasDiferencias*10;
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
});

//API DE COCHERAS Y OPERACIONES

$app->get('/TraerTodasLasOperaciones', function (Request $request, Response $response) {
$arrayOperaciones = Operacion::TraerTodasLasOperaciones();
$arrayCocheras = Cochera::TraerTodasLasCocheras();
$arrayEmpleados = Empleado::TraerTodosLosEmpleados();
$resp["operaciones"] = $arrayOperaciones;
$resp["Cocheras"] = $arrayCocheras;
$resp["empleados"] = $arrayEmpleados;
$response = $response->withJson($resp);
return $response;
});

//API DE COCHERAS Y EMPLEADOS

$app->get('/TraerLosEmpleadosCocheras', function (Request $request, Response $response) {
$arrayCocheras = Cochera::TraerTodasLasCocheras();
$arrayEmpleados = Empleado::TraerTodosLosEmpleados();
$resp["cocheras"] = $arrayCocheras;
$resp["empleados"] = $arrayEmpleados;
return $response->withJson($resp);
});


//API DE EMPLEADOS


$app->post('/IngresarEmpleado', function (Request $request, Response $response) {
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
$empleado->SetMail($data["mail"]);
$empleado->SetClave($data["clave"]);
// Cuando se ingresa el empleado, este no tiene operaciones
$empleado->SetCantidadOperaciones(0);
// La fecha de ingreso del empleado queda establecida cuando el se loguea
$empleado->SetFechaIngreso(null);
$empleado->SetTurno($data["turno"]);
if(!Empleado::InsertarElEmpleado($empleado))
{
    $resp["status"] = 400;
}
return $response->withJson($resp);
});

$app->get('/TraerTodosLosEmpleados', function (Request $request, Response $response) {
$arrayEmpleados = Empleado::TraerTodosLosEmpleados();
$resp["empleados"] = $arrayEmpleados;
$response = $response->withJson($resp);
return $response;
});

$app->get('/TraerElEmpleado/{id}', function(Request $request, Response $response) {
$id = $request->getAttribute('id');
$empleado = Empleado::TraerElEmpleado($id);
$response = $response->withJson($empleado);
return $response;
});

$app->delete('/BorrarElEmpleado/{id}', function(Request $request, Response $response) {
$id = $request->getAttribute('id');
$resp["status"] = 200;
if(!Empleado::BorrarElEmpleado($id))
{
    $resp["status"] = 400;
}
return $response->withJson($resp);
});

$app->put('/ModificarElEmpleado/{id}', function(Request $request, Response $response) {
$id = $request->getAttribute('id');
$data = $request->getParsedBody();
$empleado = Empleado::TraerElEmpleado($id);
$empleado->SetLegajo($data["legajo"]);
$empleado->SetNombre($data["nombre"]);
$empleado->SetMail($data["mail"]);
$empleado->SetClave($data["clave"]);
$resp["status"] = 200;
if(!Empleado::ModificarElEmpleado($empleado))
{
    $resp["status"] = 400;
}
return $response->withJson($resp);
});


$app->post('/ModificarEmpleadoHora/{id}', function(Request $request, Response $response) {
$id = $request->getAttribute('id');
$data = $request->getParsedBody();
$empleado = Empleado::TraerElEmpleado($id);
$empleado->SetFechaIngreso($data["fecha_inicio"]);
$resp["status"] = 200;
if(!Empleado::ModificarElEmpleado($empleado))
{
    $resp["status"] = 400;
}
return $response->withJson($resp);
});


//API COCHERAS

$app->get('/TraerTodasLasCocheras', function (Request $request, Response $response) {
$arrayTodasLasCocheras = Cochera::TraerTodasLasCocheras();
$resp["cocheras"] = $arrayTodasLasCocheras;
return $response->withJson($resp);
});

$app->get('/TraerTodasLasCocherasLibres', function (Request $request, Response $response) {
$arrayLibres = Cochera::TraerTodasLasCocherasLibres();
$resp["cocherasLibres"] = $arrayLibres;
return $response->withJson($resp);
});


$app->get('/TraerTodasLasCocherasConPrioridad', function (Request $request, Response $response) {
$arrayPrioridad = Cochera::TraerTodasLasCocherasConPrioridad();
$resp["cocherasConPrioridad"] = $arrayPrioridad;
return $response->withJson($resp);
});

$app->get('/TraerLaCochera/{id}', function (Request $request, Response $response) {
$id = $request->getAttribute('id');
$cochera = Cochera::TraerLaCochera($id);
return $response->withJson($cochera);
});


$app->post('/InsertarNuevaCochera', function (Request $request, Response $response) {
$data = $request->getParsedBody();
$resp["status"] = 200;
$data["numero"] = intval($data["numero"]);
$data["piso"] = intval($data["piso"]);
if($data["prioridad"] == "0")
{
    $data["prioridad"] = chr(0);
}
else
{
    $data["prioridad"] = chr(1);
}
$cochera = new Cochera();
$cochera->SetNumero($data["numero"]);
$cochera->SetPiso($data["piso"]);
$cochera->SetPrioridad($data["prioridad"]);
$cochera->SetVecesDeUso(0);
$cochera->SetEstaLibre(chr(1));
if(!Cochera::InsertarLaCochera($cochera))
{
    $resp["status"] = 400;
}
return $response->withJson($resp);
});


$app->delete('/BorrarCochera/{id}', function (Request $request, Response $response) {
$id = $request->getAttribute('id');
$cochera = Cochera::TraerLaCochera($id);
$resp["status"] = 200;
if(!Cochera::BorrarLaCochera($id))
{
    $resp["status"] = 400;
}
return $response->withJson($resp);
});


$app->put('/ModificarLaCochera/{id}',function (Request $request, Response $response) {
$id = $request->getAttribute('id');
$data = $request->getParsedBody();
$resp["status"] = 200;
$cochera = Cochera::TraerLaCochera($id);
$cochera->SetNumero($data["numero"]);
$cochera->SetPiso($data["piso"]);
if($data["prioridad"] == 0)
{
    $cochera->SetPrioridad(chr(0));
}
else if($data["prioridad"] == 1)
{
    $cochera->SetPrioridad(chr(1));
}
if(!Cochera::ModificarLaCochera($cochera))
{
    $resp["status"] = 400;
}
return $response->withJson($resp);
});

$app->run();
?>