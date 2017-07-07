<?php
include_once("empleado.php");
include_once("cochera.php");
include_once("auto.php");
class empleadoApi
{
public function IngresarEmpleado($request,$response,$args)
{
$data = $request->getParsedBody();
$data["legajo"] = intval($data["legajo"]);
if($data["turno"] == "null")
{
  $data["turno"] = "mañana";
}
$resp["datos"] = $data;
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
}

public function TraerEmpleados($request, $response, $args)
{
$arrayEmpleados = Empleado::TraerTodosLosEmpleados();
$resp["empleados"] = $arrayEmpleados;
$response = $response->withJson($resp);
return $response;
}


public function TraerElEmpleado($request, $response, $args)
{
$id = $args['id'];
$empleado = Empleado::TraerElEmpleado($id);
$response = $response->withJson($empleado);
return $response;
}

public function BorrarEmpleado($request, $response, $args)
{
$id = $args['id'];
$id = intval($id);
$resp["status"] = 200;
if(!Empleado::BorrarElEmpleado($id))
{
    $resp["status"] = 400;
}
return $response->withJson($resp);
}

public function ModificarEmpleado($request,$response,$args)
{
$id = $args['id'];
$id = intval($id);
$empleado = Empleado::TraerElEmpleado($id);
$resp["empleadoModificacion"] = $empleado;
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
}

public function ModificarEmpleadoHora($request,$response,$args)
{
$id = $args['id'];
$id = intval($id);
$data = $request->getParsedBody();
$empleado = Empleado::TraerElEmpleado($id);
$empleado->SetFechaIngreso($data["fecha_inicio"]);
$resp["status"] = 200;
if(!Empleado::ModificarElEmpleado($empleado))
{
    $resp["status"] = 400;
}
return $response->withJson($resp);
}


public function TraerEmpleadosCocherasAutos($request,$response,$args)
{
$arrayCocheras = Cochera::TraerTodasLasCocheras();
$arrayEmpleados = Empleado::TraerTodosLosEmpleados();
$arrayAutos = Auto::TraerTodosLosAutos();
$resp["cocheras"] = $arrayCocheras;
$resp["empleados"] = $arrayEmpleados;
$resp["autos"] = $arrayAutos;
return $response->withJson($resp);
}

}
?>