<?php
include_once("../bd/AccesoDatos.php");
class Empleado
{
public $id;
public $nombre;
public $legajo;
public $mail;
public $clave;
public $turno;

//METODO GETTERS AND SETTERS

public function GetId()
{
    return $this->id;
}

public function SetId($valor)
{
    $this->id = $valor;
}

public function GetNombre()
{
    return $this->nombre;
}

public function SetNombre($valor)
{
    $this->nombre = $valor;
}

public function GetLegajo()
{
    return $this->legajo;
}

public function SetLegajo($valor)
{
    $this->legajo = $valor;
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


//Constructor

public function __construct()
{

}

public static function TraerTodosLosEmpleados()
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, nombre as nombre, legajo as legajo, mail as mail, clave as clave, turno as turno from empleado");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_CLASS,'empleado');
}

public static function TraerElEmpleado($idEmpleado)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from empleado where id = '$idEmpleado' ");
    $consulta->execute();
    return $consulta->fetchObject('empleado');
}

public static function TraerElEmpleadoPorMailYClave($mail,$clave)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta(" SELECT * FROM empleado WHERE mail = '$mail' && clave = '$clave' ");
    $consulta->execute();
    return $consulta->fetchObject('empleado');
}

public static function InsertarElEmpleado($empleado)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO empleado (nombre, legajo, mail, clave, turno)"."VALUES('$empleado->nombre','$empleado->legajo','$empleado->mail','$empleado->clave','$empleado->turno')");
    return $consulta->execute();
}

public static function BorrarElEmpleado($idEmpleado)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("DELETE from empleado where id = '$idEmpleado' ");
    return $consulta->execute();
}

public static function ModificarElEmpleado($empleado)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE empleado set nombre = '$empleado->nombre', legajo = '$empleado->legajo', mail = '$empleado->mail' , clave = '$empleado->clave', turno =  '$empleado->turno' where id = '$empleado->id'");
    return $consulta->execute();
}

public static function VerificarEmpleado($mail,$clave)
{
	$retorno = "error";
	$ArrayEmpleados = Empleado::TraerTodosLosEmpleados();
	foreach($ArrayEmpleados as $employee)
	{
		if($employee->GetMail() == $mail && $employee->GetClave() == $clave)
		{
			$retorno = "ok";
		}
	}
	return $retorno;
}

}
?>