<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'autoload.php';
include_once('../clases/usuario.php');
include_once('../clases/auto.php');
include_once('../clases/operacion.php');

$app = new \Slim\App;

$app->post('/ValidarUsuario', function (Request $request, Response $response) {
   $datos = $request->getParsedBody();
   $resp["status"] = 200;
   if(Usuario::VerificarUsuario($datos['mail'],$datos['clave']) == "error")
   {
      $resp["status"] = 400;
   }
   return $response->withJson($resp);
});


// $app->post('/IngresarAutoOperacion', function (Request $request, Response $response) {
// $datos = $request->getParsedBody();
// $resp["status"] = 200;
// $auto = new Auto();
// $auto->SetPatente($datos['patente']);
// $auto->SetColor($datos['color']);
// $auto->SetMarca($datos['marca']);
// //Cuando se ingresa una operacionse setea un operacion con valores 0
// $operacion = new Operacion();
// $operacion->SetPatente($datos['patente']);
// $operacion->SetIdCochera($datos['idCochera']);
// $operacion->SetFechaIngreso($datos['fecha_ingreso']);
// // $operacion->SetImporte(0);
// // $operacion->SetFechaSalida(0);
// //FALLA EN AGREGAR A OPERACION

// var_dump(Operacion::InsertarLaOperacion($operacion));
// if(!(Auto::InsertarElAuto($auto)))
// {
//     $resp["status"] = 400;
// }
// // if(!Operacion::InsertarLaOperacion($operacion)
// // {
// //     $resp["status"] = 400;
// // }
// return $response->withJson($resp);
// });


$app->run();
?>