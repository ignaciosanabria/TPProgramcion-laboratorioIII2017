<?php
include_once("auto.php");
class autoApi
{
public function TraerTodos($request,$response,$args)
{
  $arrayAutos = Auto::TraerTodosLosAutos();
  $resp["autos"] = $arrayAutos;
  return $response->withJson($resp);
}

public function InsertarAuto($request, $response, $args)
{
$datos = $request->getParsedBody();
$resp["status"] = 200;
$auto = new Auto();
$auto->patente = $datos['patente'];
$auto->color = $datos['color'];
$auto->marca = $datos['marca'];
if(!Auto::InsertarElAuto($auto))
{
 $resp["status"] = 400;
}
return $response->withJson($resp);
}

public function BorrarAuto($request, $response, $args)
{
  $id = $args["id"];
  $resp["status"] = 200;
  if(!Auto::BorrarElAuto($id))
  {
    $resp["status"] = 400;
  }
  return $response->withJson($resp);
}

public function TraerUnAuto($request,$response,$args)
{
  $id = $args["id"];
  $auto = Auto::TraerElAuto($id);
  return $response->withJson($auto);
}

public function ModificarAuto($request,$response,$args)
{
  $id = $args["id"];
  $datos = $request->getParsedBody();
  $auto = Auto::TraerElAuto($id);
  $auto->SetMarca($datos["marca"]);
  $auto->SetPatente($datos["patente"]);
  $auto->SetColor($datos["color"]);
  $resp["status"] = 200;
  if(!Auto::ModificarElAuto($auto))
  {
    $resp["status"] = 400;
  }
  return $response->withJson($resp);
}

}
?>