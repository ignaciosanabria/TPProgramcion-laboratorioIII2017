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

public function TraerMasUtilizada($request, $response, $args)
	{
      $datos = $request->getParsedBody();
      $cocherasUsadas = Cochera::TraerCocherasUtilizadas($datos["fecha_desde"],$datos["fecha_hasta"]);
      //$arrayTodasLasCocheras = Cochera::TraerTodasLasCocheras();
      //$resp["cocheras"] = $arrayTodasLasCocheras;
      $resp["cocheraUsadas"] = $cocherasUsadas;
      $mayor = $cocherasUsadas[0]["cantidad"];
      $arrayCocheras = array();
      for($i = 0; $i < count($cocherasUsadas); $i++)
      {
          if($cocherasUsadas[$i]["cantidad"] >= $mayor)
             {
                 $mayor = $cocherasUsadas[$i]["cantidad"];
                 //$resp["cocheraMasUtilizada"+"$i+1"] = json_encode($cocherasUsadas[$i]["cochera"]);
                 array_push($arrayCocheras,$cocherasUsadas[$i]["cochera"]);
             }
      }
    $resp["cocheraMasUsadas"] = json_encode($arrayCocheras);

      return $response->withJson($resp);
    }

    public function TraerMenosUtilizada($request, $response, $args)
    {
      $datos = $request->getParsedBody();
      $cocherasUsadas = Cochera::TraerCocherasUtilizadas($datos["fecha_desde"],$datos["fecha_hasta"]);
      //$arrayTodasLasCocheras = Cochera::TraerTodasLasCocheras();
      //$resp["cocheras"] = $arrayTodasLasCocheras;
      $resp["cocheraUsadas"] = $cocherasUsadas;
      $cocherasUsadas = array_reverse($cocherasUsadas);
      $menor = $cocherasUsadas[0]["cantidad"];
      $arrayCocheras = array();
      for($i = 0; $i < count($cocherasUsadas); $i++)
      {
          if($cocherasUsadas[$i]["cantidad"] <= $menor)
             {
                 $menor = $cocherasUsadas[$i]["cantidad"];
                 array_push($arrayCocheras,$cocherasUsadas[$i]["cochera"]);
             }
      }
      $resp["cocheraMenosUsadas"] = json_encode($arrayCocheras);
      return $response->withJson($resp);
    }

    public function TraerSinUso($request, $response, $args)
    {
         $datos = $request->getParsedBody();
         $cocherasUsadas = Cochera::TraerCocherasUtilizadas($datos["fecha_desde"],$datos["fecha_hasta"]);
         $resp["cocheraUsadas"] = $cocherasUsadas;
         $cocherasSinUso = Cochera::TraerCocherasSinUso($datos["fecha_desde"],$datos["fecha_hasta"]);
         $resp["cocherasSinUso"] = $cocherasSinUso;
         return $response->withJson($resp);
    }

    public function VerUsoDeCocherasSinPrioridad($request, $response, $args) 
    {
    $datos = $request->getParsedBody();
    $arrayCocheras = Cochera::VerUsoDeCocherasSinPrioridad($datos["fecha_desde"], $datos["fecha_hasta"]);
    for($i = 0; $i < count($arrayCocheras); $i++)
    {
        $arrayCocheras[$i]["prioridad"] = "sin prioridad";
    }
    $resp["cocherasSinPrioridad"] = $arrayCocheras;
    return $response->withJson($resp);
    }

    public function VerUsoDeCocherasParaDiscapacitados($request, $response, $args)
    {
    $datos = $request->getParsedBody();
    $arrayCocheras = Cochera::VerUsoDeCocherasParaDiscapacitados($datos["fecha_desde"], $datos["fecha_hasta"]);
    for($i = 0; $i < count($arrayCocheras); $i++)
    {
        $arrayCocheras[$i]["prioridad"] = "discapacitado";
    }
    $resp["cocherasSinPrioridad"] = $arrayCocheras;
    return $response->withJson($resp);
    }


}
?>