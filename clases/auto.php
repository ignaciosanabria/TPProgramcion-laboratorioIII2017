<?php
include_once("../bd/AccesoDatos.php");
class Auto
{
 //Preguntar si hace poner el valor id o si es auto_increment no hace falta
public $id;
public $patente;
public $color;
public $marca;

//METODOS GETTERS & SETTERS
public function GetId()
{
    return $this->id;
}

public function SetId($valor)
{
 $this->id = $valor;
}


public function GetPatente()
{
    return $this->patente;
}

public function SetPatente($valor)
{
    $this->patente = $valor;
}

public function GetColor()
{
    return $this->color;
}

public function SetColor($valor)
{
    $this->color = $valor;
}

public function GetMarca()
{
    return $this->marca;
}

public function SetMarca($valor)
{
    $this->marca = $valor;
}

public function construct__()
{

}


//Insertamos un auto en la base de datos
public static function InsertarElAuto($auto)
{
$objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
$consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO auto (patente, color, marca)"."VALUES('$auto->patente', '$auto->color','$auto->marca')");		
return $consulta->execute();
}

public static function TraerTodosLosAutos()
{
   $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
   $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, patente as patente, color as color , marca as marca from auto");
   $consulta->execute();
   return $consulta->fetchAll(PDO::FETCH_CLASS,"auto");
}


public static function TraerElAuto($idAuto)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from auto WHERE id = '$idAuto'");
    $consulta->execute();
    return $consulta->fetchObject("auto");
}

public static function TraerElAutoPorPatente($patente)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from auto WHERE patente = '$patente'");
    $consulta->execute();
    return $consulta->fetchObject("auto");
}

public static function BorrarElAuto($idAuto)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("DELETE from auto WHERE id = '$idAuto'");
    return $consulta->execute();
}

public static function ModificarElAuto($auto)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE auto set patente = '$auto->patente' , color = '$auto->color' , marca = '$auto->marca' where id = '$auto->id' ");
    return $consulta->execute();
}

//CUANDO INGRESO UN AUTO VERIFICO SI LA PATENTE ESTA REGISTRADA EN LA BASE DE DATOS
public static function VerificarPatente($patente)
{
    $retorno = true;
    $arrayAutos = Auto::TraerTodosLosAutos();
    foreach($arrayAutos as $auto)
    {
      if($patente == $auto->patente)
      {
          $retorno = false;
      }
    }
    return $retorno;
}



}
?>