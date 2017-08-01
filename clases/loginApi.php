<?php
include_once("empleado.php");
include_once("cargo_empleado.php");
include_once("sesion.php");
include_once("AutentificadorJWT.php");
class loginApi
{

public function ValidarUsuario($request, $response, $args) {
   $datos = $request->getParsedBody();
    if(Empleado::VerificarEmpleado($datos['mail'],$datos['clave']))
      {
       $empleado = Empleado::TraerElEmpleadoPorMailYClave($datos['mail'],$datos['clave']);
       if($empleado->habilitado == "si")
       {
       $resp["status"] = 200;
       $cargos = Cargo_Empleado::TraerTodosLosCargos();
       $resp["id"] = $empleado->GetId();
       foreach($cargos as $cargoEmpleado)
       {
           if($cargoEmpleado->id == $empleado->cargo)
           {
               $resp["tipo"] = $cargoEmpleado->cargo;
               break;
           }
       }
       $sesion = new Sesion();
       $sesion->SetIdEmpleado($empleado->id);
       $dateTime = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
       $fecha_ingreso = $dateTime->format("m/d/Y g:i A");
       $sesion->SetFechaIngreso($fecha_ingreso);
    //    $sesion->SetFechaIngreso($datos["fecha_ingreso"]);
       Sesion::InsertarSesionInicio($sesion);
       $datosToken = array('mail' => $datos['mail'],'perfil' => $resp["tipo"]);
       $token = AutentificadorJWT::CrearToken($datosToken);
       $resp["token"] = $token; 
       }
       else
       {
           $resp["status"] = 401;
       }
    }
    else
    {
        $resp["status"] = 400;
    }

   return $response->withJson($resp,200);
   }



  // TRAIGO EL EMPLEADO - Administrador o Cajero - Para que la página principal se cargue en el icono de usuario con su nombre
   public function TraerEmpleado($request,$response,$args)
   {
       $id = $args['id'];
       $id = intval($id);
       $empleado = Empleado::TraerElEmpleado($id);
       return $response->withJson($empleado,200);
   }

   public function CerrarSesion($request, $response, $args)
   {
       $datos = $request->getParsedBody();
       $resp["status"] = 200;
       $id = Sesion::TraerUltimoIdAgregado();
       $sesion = Sesion::TraerSesionPorId($id);
       if($sesion == false)
       {
           $resp["status"] = 400;
       }
        $dateTime = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
        $fecha_salida = $dateTime->format("m/d/Y g:i A");
        $sesion->SetFechaSalida($fecha_salida);
        // $sesion->SetFechaSalida($datos["fecha_salida"]);
        Sesion::ModificarSesionSalida($sesion);
        return $response->withJson($resp);
   }

 public function TraerSesiones($request, $response, $args)
 {
     $arraySesiones = Sesion::TraerTodasLasSesiones();
     $arrayEmpleados = Empleado::TraerTodosLosEmpleados();
     $resp["sesiones"] = $arraySesiones;
     $resp["empleados"] = $arrayEmpleados;
     return $response->withJson($resp);
 }


  public function DesencriptarToken($request,$response,$args)
  {
      $arrayConToken = $request->getHeader('token');
	  $token=$arrayConToken[0];
      if($token != null)
      {
      $payload=AutentificadorJWT::ObtenerPayload($token);
      $newResponse = $response->withJson($payload, 200);
      }
      else
      {
          $resp["status"] = 400;
          $newResponse = $response->withJson($resp);
      }
      return $newResponse;
  }

}
?>