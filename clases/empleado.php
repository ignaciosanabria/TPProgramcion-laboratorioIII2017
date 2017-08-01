<?php
include_once("../bd/AccesoDatos.php");
class Empleado
{
public $id;
public $legajo;
public $nombre;
public $apellido;
public $mail;
public $clave;
public $turno;
public $cargo;
public $habilitado;
public $foto;

//METODO GETTERS AND SETTERS

public function GetId()
{
    return $this->id;
}

public function SetId($valor)
{
    $this->id = $valor;
}

public function GetLegajo()
{
    return $this->legajo;
}

public function SetLegajo($valor)
{
    $this->legajo = $valor;
}

public function GetNombre()
{
    return $this->nombre;
}

public function SetNombre($valor)
{
    $this->nombre = $valor;
}

public function GetApellido()
{
    return $this->apellido;
}

public function SetApellido($valor)
{
    $this->apellido = $valor;
}


public function GetMail()
{
    return $this->mail;
}

public function SetMail($valor)
{
    $this->mail = $valor;
}

public function GetClave()
{
    return $this->clave;
}

public function SetClave($valor)
{
    $this->clave = $valor;
}

public function GetTurno()
{
    return $this->turno;
}

public function SetTurno($valor)
{
    $this->turno = $valor;
}

public function GetCargo()
{
    return $this->cargo;
}

public function SetCargo($valor)
{
    $this->cargo = $valor;
}


public function GetHabilitado()
{
    return $this->habilitado;
}

public function SetHabilitado($valor)
{
    $this->habilitado = $valor;
}

public function GetFoto()
{
    return $this->foto;
}

public function SetFoto($valor)
{
    $this->foto = $valor;
}



//Constructor

public function __construct()
{

}

public static function TraerTodosLosEmpleados()
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, legajo as legajo, nombre as nombre, apellido as apellido , mail as mail, clave as clave, turno as turno, cargo as cargo, habilitado as habilitado, foto as foto from empleado");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_CLASS,'empleado');
}

public static function TraerElEmpleado($idEmpleado)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from empleado where id = '$idEmpleado' ");
    $consulta->execute();
    return $consulta->fetchObject('empleado');
}

public static function TraerElEmpleadoPorMailYClave($mail,$clave)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta(" SELECT * FROM empleado WHERE mail = '$mail' && clave = '$clave' ");
    $consulta->execute();
    return $consulta->fetchObject('empleado');
}

public static function InsertarElEmpleado($empleado)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO empleado (legajo, nombre, apellido, mail, clave, turno, cargo, habilitado, foto)"."VALUES('$empleado->legajo','$empleado->nombre','$empleado->apellido','$empleado->mail','$empleado->clave','$empleado->turno','$empleado->cargo','$empleado->habilitado','$empleado->foto')");
    return $consulta->execute();
}

public static function BorrarElEmpleado($idEmpleado)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("DELETE from empleado where id = '$idEmpleado' ");
    return $consulta->execute();
}

public static function ModificarElEmpleado($empleado)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE empleado set legajo = '$empleado->legajo', nombre = '$empleado->nombre', apellido = '$empleado->apellido', mail = '$empleado->mail' , clave = '$empleado->clave', turno =  '$empleado->turno', cargo = '$empleado->cargo', habilitado = '$empleado->habilitado', foto = '$empleado->foto' where id = '$empleado->id'");
    return $consulta->execute();
}

public static function SuspenderEmpleado($empleado)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE empleado set habilitado = '$empleado->habilitado'  where id = '$empleado->id'");
    return $consulta->execute();
}


public static function VerificarEmpleado($mail,$clave)
{
	$retorno = false;
	$ArrayEmpleados = Empleado::TraerTodosLosEmpleados();
	foreach($ArrayEmpleados as $employee)
	{
		if($employee->GetMail() == $mail && $employee->GetClave() == $clave)
		{
			$retorno = true;
		}
	}
	return $retorno;
}

 public static function TraerUltimoIdAgregado()
	{
	    $objetoAcceso = AccesoDatos::DameUnObjetoAcceso();    
	    $consulta = $objetoAcceso->RetornarConsulta("SELECT id from empleado order by id DESC limit 1");
	    $consulta->execute();
	    $idEmpleado = $consulta->fetchColumn(0);
	    return $idEmpleado;
	}
    
   //FECHAS DE LOGUEO QUE REALIZO EL EMPLEADO

    public static function TraerFechasDeSesionesPorIdEmpleado($idEmpleado)
    {
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT sesion.fecha_ingreso AS fecha_ingreso, sesion.fecha_salida AS fecha_salida FROM sesion WHERE sesion.idEmpleado = '$idEmpleado'");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
     
    //OPERACIONES DE ENTRADA QUE REALIZO EL EMPLEADO

    public static function TraerOperacionesEntradaPorIdEmpleado($idEmpleado)
    {
        //SELECT operacion_entrada.fecha_ingreso as fecha_ingreso , auto.patente as autoQueIngreso , operacion_entrada.idCochera as cochera FROM operacion_entrada INNER JOIN auto ON auto.id = operacion_entrada.idAuto WHERE operacion_entrada.idEmpleado = 2
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT operacion_entrada.fecha_ingreso as fecha_ingreso , auto.patente as autoQueIngreso , operacion_entrada.idCochera as cochera FROM operacion_entrada INNER JOIN auto ON auto.id = operacion_entrada.idAuto WHERE operacion_entrada.idEmpleado = '$idEmpleado'");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
     
     //OPERACIONES DE SALIDA QUE REALIZO EL EMPLEADO

    public static function TraerOperacionesSalidaPorIdEmpleado($idEmpleado)
    {
        //SELECT operacion_salida.fecha_salida as fecha_salida, auto.patente as autoQueSaco, importe as importe FROM `operacion_salida` INNER JOIN auto ON auto.id = operacion_salida.idAuto WHERE operacion_salida.idEmpleado = 2
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT operacion_salida.fecha_salida as fecha_salida, auto.patente as autoQueSaco, importe as importe FROM operacion_salida INNER JOIN auto ON auto.id = operacion_salida.idAuto WHERE operacion_salida.idEmpleado = '$idEmpleado'");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }


}
?>