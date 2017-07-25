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
      $arrayTodasLasCocheras = Cochera::TraerTodasLasCocheras();
      $resp["cocheras"] = $arrayTodasLasCocheras;
      $resp["cocheraUsadas"] = $cocherasUsadas;
      $mayor = $cocherasUsadas[0]["cantidad"];
      for($i = 0; $i < count($cocherasUsadas); $i++)
      {
          if($cocherasUsadas[$i]["cantidad"] > $mayor)
             {
                 $mayor = $cocherasUsadas[$i][$cantidad];
                 $resp["cocheraMasUtilizada"] = $cocherasUsadas[$i]["cochera"];
                 $resp["vecesDeUso"] = $cocherasUsadas[$i]["cantidad"];
             }
      }
      return $response->withJson($resp);
    }

    public function TraerMenosUtilizada($request, $response, $args)
    {
      $datos = $request->getParsedBody();
      $cocherasUsadas = Cochera::TraerCocherasUtilizadas($datos["fecha_desde"],$datos["fecha_hasta"]);
      $arrayTodasLasCocheras = Cochera::TraerTodasLasCocheras();
      $resp["cocheras"] = $arrayTodasLasCocheras;
      $resp["cocheraUsadas"] = $cocherasUsadas;
      $menor = $cocherasUsadas[0]["cantidad"];
      for($i = 0; $i < count($cocherasUsadas); $i++)
      {
          if($cocherasUsadas[$i]["cantidad"] <= $menor)
             {
                 $menor = $cocherasUsadas[$i][$cantidad];
                 $cocheraMenor = $cocherasUsadas[$i]["cochera"];
                 $vecesDeUso = $cocherasUsadas[$i]["cantidad"];
             }
      }
      $resp["cocheraMenosUtilizada"] = $cocheraMenor;
      $resp["vecesDeUso"] = $vecesDeUso;
      return $response->withJson($resp);
    }

    public function TraerSinUso($request, $response, $args)
    {
         $datos = $request->getParsedBody();
         $cocherasUsadas = Cochera::TraerCocherasUtilizadas($datos["fecha_desde"],$datos["fecha_hasta"]);
         $arrayTodasLasCocheras = Cochera::TraerTodasLasCocheras();

         for($i=0; $i < count($arrayTodasLasCocheras);$i++)
         {
             for($y = 0; $y<count($cocherasUsadas);$y++)
             {
                if($arrayTodasLasCocheras[$i]->id == $cocherasUsadas[$y]["cochera"])
                {
                    unset($arrayTodasLasCocheras[$i]);
                }
             }
         }
         $resp["cocherasSinUso"] = $arrayTodasLasCocheras;
         return $response->withJson($resp);
    }



}
?>