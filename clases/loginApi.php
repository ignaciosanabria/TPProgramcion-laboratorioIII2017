<?php
include_once("administrador.php");
include_once("empleado.php");
class loginApi
{

public function ValidarUsuario($request, $response, $args) {
  $dateTime = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
  $fecha_inicio = $dateTime->format("m/d/Y  H:i A");
  $resp["hora"] = $fecha_inicio;
   $datos = $request->getParsedBody();
   $resp["status"] = 400;
   $resp["hora"] = $fecha_inicio;
       if(Administrador::VerificarAdministrador($datos['mail'],$datos['clave']) == "ok")
         {
        $resp["status"] = 200;
        $resp["tipo"] = "administrador";
        $administrador = Administrador::TraerElAdministradorPorMailYClave($datos["mail"],$datos["clave"]);
        $resp["id"] = $administrador->GetId();
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

   public function TraerAdministrador($request, $response, $args){
       $id = $args['id'];
       $administrador = Administrador::TraerElAdministrador($id);   
       return $response->withJson($administrador,200);
   }

   public function TraerEmpleado($request,$response,$args)
   {
       $id = $args['id'];
       $empleado = Empleado::TraerElEmpleado($id);
       return $response->withJson($empleado,200);
   }


  public function RegistrarAdministrador($request,$response,$args)
  {
      $data = $request->getParsedBody();
      $administrador = new Administrador();
      $administrador->SetMail($data["mail"]);
      $administrador->SetClave($data["clave"]);
      $administrador->SetNombre($data["nombre"]);
      $resp["status"] = 200;
      if(!Administrador::InsertarElAdministradorParametros($administrador))
      {
          $resp["status"] = 400;
      }
      return $response->withJson($resp,200);
  }

}
?>