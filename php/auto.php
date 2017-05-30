<?php
require("BaseDeDatos/AccesoDatos.php");
class Auto
{
 //Preguntar si hace poner el valor id o si es auto_increment no hace falta
public $id;
public $patente;
public $color;
public $marca;
//preguntar si hace falta poner el importe y la clase Cochera(En su defecto el piso)
public $fecha_ingreso;

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

public function GetFechaIngreso()
{
    return $this->fecha_ingreso;
}

public function SetFechaIngreso($valor)
{
 $this->fecha_ingreso = $valor;
}

public function construct__()
{

}

public function construct__($patente, $color, $marca,$fecha_ingreso)
{
    $this->patente = $patente;
    $this->color = $color;
    $this->marca = $marca;
    $this->fecha_ingreso = $fecha_ingreso;
}


//Insertamos un auto en la base de datos
public static function InsertarElAuto($auto)
{
$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
$consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO auto (patente, color, marca, fecha_ingreso)" . "VALUES('$auto->patente', '$auto->color','$auto->marca','$auto->fecha_ingreso)";
$consulta->execute();		
return $consulta;
}

public static function TraerTodosLosAutos()
{
   $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
   $consulta = $objetoAccesoDato->RetornarConsula("SELECT id as id, patente as patente, color as color , marca as marca , fecha_ingreso as fecha_ingreso from auto");
   $consulta->execute();
   return $consulta->fetchAll("auto");
}


public static function TraerElAuto($idAuto)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from auto WHERE id = '$idAuto'");
    $consulta->execute();
    return $consulta->fetchObject("auto");
}

//FALTA BORRAR Y MODIFICAR



}
?>