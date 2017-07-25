<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'autoload.php';
include_once('../clases/operacion_entradaApi.php');
include_once('../clases/empleadoApi.php');
include_once('../clases/cocheraApi.php');
include_once('../clases/autoApi.php');
include_once('../clases/loginApi.php');
include_once('../clases/operacion_salidaApi.php');
include_once('../clases/AutentificadorJWT.php');
include_once('../clases/MWparaCORS.php');
include_once('../clases/MWparaAutentificar.php');

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

//PUEDE INGRESAR EMPLEADO O ADMINISTRADOR-Administrador

$app->group('/Login', function(){
   $this->post('/ValidarUsuario', \loginApi::class . ':ValidarUsuario');
   $this->get('/TraerEmpleado/{id}',\loginApi::class .':TraerEmpleado')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
   $this->post('/CerrarSesion',\loginApi::class .':CerrarSesion');
   //$this->post('/RegistrarAdministrador',\loginApi::class .':RegistrarAdministrador');
})->add(\MWparaCORS::class . ':HabilitarCORS8080');

$app->group('/Sesion',function(){
  $this->get('/TraerTodasLasSesiones',\loginApi::class .':TraerSesiones')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
})->add(\MWparaCORS::class . ':HabilitarCORS8080');

//API DE OPERACIONES DE ENTRADA

$app->group('/Operacion_Entrada', function(){
  $this->post('/IngresarOperacion',\Operacion_EntradaApi::class .':IngresarOperacionEntrada');
  $this->get('/TraerTodasLasOperacionesEntrada',\Operacion_EntradaApi::class .':TraerOperacionesEntrada')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
  $this->post('/BuscarOperacionesFechas',\Operacion_EntradaApi::class .':BuscarOperacionesFechas');//->add(\MWparaCORS::class . ':HabilitarCORSTodos');
})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');

//API DE OPERACIONES DE SALIDA

$app->group('/Operacion_Salida', function(){
   $this->post('/SacarAuto',\Operacion_SalidaApi::class .':SacarAuto');
   $this->post('/BuscarOperacionesFechas',\Operacion_SalidaApi::class .':BuscarEntreFechas');
   $this->post('/CalcularImporte',\Operacion_SalidaApi::class .':CalcularImporte');
   //PARA LA VISTA EMPLEADO
   $this->get('/TraerTodasLasOperaciones',\Operacion_SalidaApi::class .':TraerTodasLasOperaciones')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
   //PARA LAS VISTA DE PESTAÑAS OPERACIONES
   $this->get('/TraerTodasLasOperacionesFinalizadas',\Operacion_SalidaApi::class .':TraerOperacionesFinalizadas')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
   $this->get("/TraerTodasLasOperacionesNoFinalizadas",\Operacion_SalidaApi::class .':TraerOperacionesNoFinalizadas')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');



//API DE EMPLEADOS - ABM DE EMPLEADOS

$app->group('/Empleado', function(){
   $this->post('/IngresarEmpleado', \empleadoApi::class .':IngresarEmpleado');
   $this->get('/TraerTodosLosEmpleados',\empleadoApi::class .':TraerEmpleados')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
   $this->get('/TraerElEmpleado/{id}',\empleadoApi::class .':TraerElEmpleado')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
   $this->delete('/BorrarElEmpleado/{id}',\empleadoApi::class .':BorrarEmpleado');
   $this->put('/ModificarElEmpleado/{id}',\empleadoApi::class .':ModificarEmpleado');
   // GET PARA LA VISTA ESTACIONAR DE EMPLEADOS
   $this->get('/TraerLosEmpleadosCocherasAutos',\empleadoApi::class .':TraerEmpleadosCocherasAutos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');

//API COCHERAS - SOLO SE PUEDE VER O TRAER COCHERAS

$app->group('/Cochera', function(){
  $this->get('/TraerTodasLasCocheras', \cocheraApi::class .':TraerTodas')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
  $this->get('/TraerTodasLasCocherasLibres', \cocheraApi::class .':TraerLibres')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
  $this->get('/TraerTodasLasCocherasConPrioridad', \cocheraApi::class .':TraerDiscapacitadas')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
  $this->get('/TraerLaCochera/{id}',\cocheraApi::class .':TraerCochera')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
  $this->post('/TraerCocheraMasUtilizada',\cocheraApi::class .':TraerMasUtilizada');
  $this->post('/TraerCocheraMenosUtilizada',\cocheraApi::class .':TraerMenosUtilizada');
  $this->post('/TraerCocheraSinUso',\cocheraApi::class .':TraerSinUso');
})->add(\MWparaCORS::class . ':HabilitarCORS8080');

//API AUTOS - ABM DE AUTOS

$app->group('/Auto', function(){
   $this->get('/TraerTodosLosAutos',\autoApi::class .':TraerTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
   $this->post('/InsertarAuto',\autoApi::class .':InsertarAuto');
   $this->delete('/BorrarAuto/{id}',\autoApi::class .':BorrarAuto');
   $this->get('/TraerElAuto/{id}',\autoApi::class .':TraerUnAuto')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
   $this->put('/ModificarElAuto/{id}',\autoApi::class .':ModificarAuto');
  })->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');


$app->run();
?>