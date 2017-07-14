<?php
include_once("cochera.php");
include_once("auto.php");
class cocheraApi
{

public function TraerTodas($request,$response,$args)
{
$arrayTodasLasCocheras = Cochera::TraerTodasLasCocheras();
$arrayAutos = Auto::TraerTodosLosAutos();
$resp["cocheras"] = $arrayTodasLasCocheras;
$resp["autos"] = $arrayAutos;
return $response->withJson($resp);
}

public function TraerLibres($request,$response,$args)
{
$arrayLibres = Cochera::TraerTodasLasCocherasLibres();
$resp["cocherasLibres"] = $arrayLibres;
return $response->withJson($resp);
}

public function TraerDiscapacitadas($request,$response,$args)
{
$arrayPrioridad = Cochera::TraerTodasLasCocherasConPrioridad();
$resp["cocherasConPrioridad"] = $arrayPrioridad;
return $response->withJson($resp);
}

public function TraerCochera($request, $response, $args)
{
$id = $args['id'];
$id = intval($id);
$cochera = Cochera::TraerLaCochera($id);
return $response->withJson($cochera);
}


public function InsertarCochera($request,$response,$args)
{
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
if(!Cochera::InsertarLaCochera($cochera))
{
    $resp["status"] = 400;
}
return $response->withJson($resp);
}


public function BorrarCochera($request,$response,$args)
{
$resp["status"] = 200;
$id = $args['id'];
$id = intval($id);
if(!Cochera::BorrarLaCochera($id))
{
    $resp["status"] = 400;
}
return $response->withJson($resp);
}

public function ModificarCochera($request,$response,$args)
{
$data = $request->getParsedBody();
$id = $args['id'];
$id = intval($id);
$resp["status"] = 200;
$cochera = Cochera::TraerLaCochera($id);
if($cochera->idAuto == NULL)
{
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
}
else
{
    $resp["status"] = 401;
}
return $response->withJson($resp);
}

}
?>