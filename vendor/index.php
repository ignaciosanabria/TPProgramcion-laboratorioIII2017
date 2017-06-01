<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'autoload.php';
require '../clases/usuario.php';

$app = new \Slim\App;
// $app->get('/hello/{name}',$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
//     $name = $request->getAttribute('name');
//     $response->getBody()->write("Hello, $name");

//     return $response;
// });
$app->post('/ValidarUsuario', function (Request $request, Response $response) {
   $datos = $request->getParsedBody();
   $resp["status"] = 200;
   if(Usuario::VerificarUsuario($datos['mail'],$datos['clave']) == "error")
   {
      $resp["status"] = 400;
   }
   return $response->withJson($resp);
});
$app->run();
?>