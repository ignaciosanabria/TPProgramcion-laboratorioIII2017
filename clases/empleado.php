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

//Constructor

public function __construct()
{

}

public static function TraerTodosLosEmpleados()
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, legajo as legajo, nombre as nombre, apellido as apellido , mail as mail, clave as clave, turno as turno, cargo as cargo from empleado");
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
    $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO empleado (legajo, nombre, apellido, mail, clave, turno, cargo)"."VALUES('$empleado->legajo','$empleado->nombre','$empleado->apellido','$empleado->mail','$empleado->clave','$empleado->turno','$empleado->cargo')");
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
    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE empleado set legajo = '$empleado->legajo', nombre = '$empleado->nombre', apellido = '$empleado->apellido', mail = '$empleado->mail' , clave = '$empleado->clave', turno =  '$empleado->turno', cargo = '$empleado->cargo' where id = '$empleado->id'");
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