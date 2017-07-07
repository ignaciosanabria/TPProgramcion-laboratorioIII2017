<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'autoload.php';
include_once('../clases/usuarioApi.php');
include_once('../clases/operacionApi.php');
include_once('../clases/empleadoApi.php');
include_once('../clases/cocheraApi.php');
include_once('../clases/autoApi.php');

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

$app->group('/Operacion', function(){
  $this->post('/IngresarOperacion',\operacionApi::class .':IngresarOperacion');
  $this->post('/SacarAuto',\operacionApi::class .':SacarAuto');
  $this->get('/TraerTodasLasOperaciones',\operacionApi::class .':TraerOperaciones');
});

//API DE EMPLEADOS

$app->group('/Empleado', function(){
   $this->post('/IngresarEmpleado', \empleadoApi::class .':IngresarEmpleado');
   $this->get('/TraerTodosLosEmpleados',\empleadoApi::class .':TraerEmpleados');
   $this->get('/TraerElEmpleado/{id}',\empleadoApi::class .':TraerElEmpleado');
   $this->delete('/BorrarElEmpleado/{id}',\empleadoApi::class .':BorrarEmpleado');
   $this->put('/ModificarElEmpleado/{id}',\empleadoApi::class .':ModificarEmpleado');
   $this->post('/ModificarEmpleadoHora/{id}',\empleadoApi::class .':ModificarEmpleadoHora');
   $this->get('/TraerLosEmpleadosCocherasAutos',\empleadoApi::class .':TraerEmpleadosCocherasAutos');
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

//API AUTOS

$app->group('/Auto', function(){
   $this->get('/TraerTodosLosAutos',\autoApi::class .':TraerTodos');
   $this->post('/InsertarAuto',\autoApi::class .':InsertarAuto');
   $this->delete('/BorrarAuto/{id}',\autoApi::class .':BorrarAuto');
   $this->get('/TraerElAuto/{id}',\autoApi::class .':TraerUnAuto');
   $this->put('/ModificarElAuto/{id}',\autoApi::class .':ModificarAuto');
});


$app->run();
?>