<?php
include_once("usuario.php");
include_once("empleado.php");
class usuarioApi
{
public function ValidarUsuario($request, $response, $args) {
   $datos = $request->getParsedBody();
   $resp["status"] = 400;
   $resp["hora"] = $datos["horaLogin"];
       if(Usuario::VerificarUsuario($datos['mail'],$datos['clave']) == "ok")
         {
        $resp["status"] = 200;
        $resp["tipo"] = "administrador";
        }
     else
     {
        
       if(Empleado::VerificarEmpleado($datos['mail'],$datos['clave']) == "ok")
      {
       $resp["status"] = 200;
       $empleado = Empleado::TraerElEmpleadoPorMailYClave($datos['mail'],$datos['clave']);
       $resp["tipo"] = "empleado";
   if(!$empleado)
   {
       $resp["id"] = false;
   }
   else
   {
       $resp["id"] = $empleado->GetId();
   }
      }

   }
   return $response->withJson($resp,200);
   
   }

   public function TraerHoraInicio($request, $response, $args)
   {
$dateTime = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
$fecha_inicio = $dateTime->format("m/d/Y  H:i A");
$resp["hora"] = $fecha_inicio;
return $response->withJson($resp);
   }


}
?>