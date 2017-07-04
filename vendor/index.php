<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'autoload.php';
include_once('../clases/usuario.php');
include_once('../clases/auto.php');
include_once('../clases/operacion.php');
include_once('../clases/empleado.php');
include_once('../clases/cochera.php');
include_once('../clases/usuarioApi.php');
include_once('../clases/operacionApi.php');
include_once('../clases/empleadoApi.php');
include_once('../clases/cocheraApi.php');

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

//API DE USUARIO ADMINISTRADOR

//PUEDE INGRESAR EMPLEADO O ADMINISTRADOR-usuario

$app->group('/Usuario', function(){
   $this->post('/ValidarUsuario', \usuarioApi::class . ':ValidarUsuario');
   $this->get('/TraerHoraInicio',\usuarioApi::class .':TraerHoraInicio');
});

//API DE OPERACIONES

//EN LOS VALORES BIT SETEARLOS CON chr(0o1)

// $app->post('/IngresarAutoOperacion', function (Request $request, Response $response) {
// $datos = $request->getParsedBody();
// $datos["idCochera"] = intval($datos["idCochera"]);
// $datos["idEmpleado"] = intval($datos["idEmpleado"]);
// $resp["status"] = 200;
// $resp["error"] = 200;
// $cochera = Cochera::TraerLaCocheraPorIdYPrioridad($datos["idCochera"],$datos["prioridad"]);
// if($cochera == false)
// {
//     $resp["error"] = 400;
// }
// else
// {
// $empleado = Empleado::TraerElEmpleado($datos["idEmpleado"]);
// $empleado->SetCantidadOperaciones($empleado->GetCantidadOperaciones()+1);
// if(!Empleado::ModificarElEmpleado($empleado))
// {
//     $resp["status"] = 400;
// }

// $auto = new Auto();
// $auto->patente = $datos['patente'];
// $auto->color = $datos['color'];
// $auto->marca = $datos['marca'];
// // //Cuando se ingresa una operacion se setea un el importe y fecha_salida con valores null
// $operacion = new Operacion();
// $operacion->patente = $datos['patente'];
// $operacion->idCochera = $datos['idCochera'];
// $operacion->idEmpleado = $datos["idEmpleado"];
// $operacion->fecha_ingreso = $datos['fecha_ingreso'];
// $operacion->importe = 0;
// $operacion->fecha_salida = null;
// if(!Operacion::InsertarLaOperacion($operacion))
// {
//     $resp["status"] = 400;
// }
// if(!Auto::InsertarElAuto($auto))
// {
//     $resp["status"] = 400;
// }
//     $cochera->SetEstaLibre(chr(0));
//     $cochera->SetVecesDeUso($cochera->GetVecesDeUso()+1);
//      if(!Cochera::ModificarLaCochera($cochera))
//      {
//       $resp["status"] = 400;
//      } 
// }
// return $response->withJson($resp);
// });

$app->group('/Operacion', function(){
  $this->post('/IngresarAutoOperacion',\operacionApi::class .':IngresarAutoOperacion');
  $this->post('/SacarAuto',\operacionApi::class .':SacarAuto');
  $this->get('/TraerTodasLasOperaciones',\operacionApi::class .':TraerOperaciones');
});


// $app->post('/SacarAuto', function (Request $request, Response $response) {
// $dateTime = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
// $fecha_salida = $dateTime->format("m/d/Y  h:i A");
// $data = $request->getParsedBody();
// $operacion = Operacion::TraerLaOperacionPorPatente($data["patente"]);
// $resp["status"] = 200;
// // if($operacion->GetFechaSalida() != null && $operacion->GetImporte() != 0)
// // {
// //   $resp["status"] = 400;
// // }
// // else
// // {
// $cochera = Cochera::TraerLaCochera($operacion->idCochera);
// $cochera->SetEstaLibre(chr(1));
// Cochera::ModificarLaCochera($cochera);
// // //PARA LA HORA - SACAR DIFERENCIA HORA E IMPORTE
// $arrayFechaEntrada = preg_split("([ /:])",$operacion->fecha_ingreso);
// $arrayFechaSalida = preg_split("([ /:])",$fecha_salida);
// $importe = 0;
// $diasDiferencias = intval($arrayFechaSalida[1]) - intval($arrayFechaEntrada[1]);
// if($arrayFechaEntrada[5] == $arrayFechaSalida[6])
// {
//     if(($arrayFechaEntrada[5] == "PM" && $arrayFechaEntrada[3] != 12) || ($arrayFechaEntrada[5] == "AM" && $arrayFechaEntrada[3] != 12))
//     {
//     if(intval($arrayFechaSalida[4]) == intval($arrayFechaEntrada[3]))
//     {
//         $horasDiferencias = (intval($arrayFechaSalida[4]) - intval($arrayFechaEntrada[3])) + 24;
//     }
//     else if(intval($arrayFechaSalida[4]) < intval($arrayFechaEntrada[3]))
//     {
//         $horasDiferencias = (intval($arrayFechaSalida[4]) - intval($arrayFechaEntrada[3])) + 24;
//     }
//     else
//     {
//          $horasDiferencias = (intval($arrayFechaSalida[4]) - intval($arrayFechaEntrada[3]));
//     }
//     }
//     else
//     {
//           $horasDiferencias = intval($arrayFechaSalida[4]);
//     }
// }
// else if($arrayFechaEntrada[5] != $arrayFechaSalida[6])
// { 
//     if(($arrayFechaEntrada[5] == "PM" && $arrayFechaEntrada[3] != 12) || ($arrayFechaEntrada[5] == "AM" && $arrayFechaEntrada[3] != 12))
//     {
//     if(intval($arrayFechaSalida[4]) == intval($arrayFechaEntrada[3]))
//     {
//     $horasDiferencias = (intval($arrayFechaSalida[4]) - intval($arrayFechaEntrada[3])) + 12;
//     }
//     else if(intval($arrayFechaSalida[4]) > intval($arrayFechaEntrada[3]))
//     {
//          $horasDiferencias = (intval($arrayFechaSalida[4]) - intval($arrayFechaEntrada[3])) + 12;
//     }
//     else
//     {
//          $horasDiferencias = (intval($arrayFechaSalida[4]) - intval($arrayFechaEntrada[3])) + 12;
//     }
//     }
//     else
//     {
//         $horasDiferencias = (intval($arrayFechaSalida[4]) - intval($arrayFechaEntrada[3])) + 24;
//     }
// }


// if($diasDiferencias == 0)
// {
//     if($horasDiferencias == 12)
//     {
//        $importe = 90;
//     }
//     else if($horasDiferencias == 24)
//     {
//         $importe = 170;
//     }
//     else
//     {
//         $importe = $horasDiferencias*10;
//     }
// }
// else if($diasDiferencias >= 1)
// {
//    if($horasDiferencias == 12)
//     {
//        $importe = ($diasDiferencias-1)*170+90;
//     }
//     else if($horasDiferencias == 24)
//     {
//         $importe = ($diasDiferencias-1)*170+170;
//     }
//     else
//     {
//         $importe = ($diasDiferencias-1)*170+($horasDiferencias*10);
//     }
// }

// $operacion->SetImporte($importe);
// $operacion->SetFechaSalida($fecha_salida);
// Operacion::ModificarLaOperacionACerrar($operacion);
// // }
// return $response->withJson($resp);
// });

//API DE EMPLEADOS

$app->group('/Empleado', function(){
   $this->post('/IngresarEmpleado', \empleadoApi::class .':IngresarEmpleado');
   $this->get('/TraerTodosLosEmpleados',\empleadoApi::class .':TraerEmpleados');
   $this->get('/TraerElEmpleado/{id}',\empleadoApi::class .':TraerElEmpleado');
   $this->delete('/BorrarElEmpleado/{id}',\empleadoApi::class .':BorrarEmpleado');
   $this->put('/ModificarElEmpleado/{id}',\empleadoApi::class .':ModificarEmpleado');
   $this->post('/ModificarEmpleadoHora/{id}',\empleadoApi::class .':ModificarEmpleadoHora');
   $this->get('/TraerLosEmpleadosCocheras',\empleadoApi::class .':TraerEmpleadosCocheras');
});

//API COCHERAS

$app->group('/Cochera', function(){
  $this->get('/TraerTodasLasCocheras', \cocheraApi::class .':TraerTodas');
  $this->get('/TraerTodasLasCocherasLibres', \cocheraApi::class .':TraerLibres');
  $this->get('/TraerTodasLasCocherasConPrioridad', \cocheraApi::class .':TraerDiscapacitadas');
  $this->get('/TraerLaCochera/{id}',\cocheraApi::class .':TraerCochera');
  $this->post('/InsertarNuevaCochera',\cocheraApi::class .':InsertarCochera');
  $this->delete('/BorrarLaCochera/{id}',\cocheraApi::class .':BorrarCochera');
  $this->put('/ModificarLaCochera/{id}',\cocheraApi::class .':ModificarCochera');
});


$app->run();
?>