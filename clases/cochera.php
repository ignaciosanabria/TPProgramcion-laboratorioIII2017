<?php
require("../bd/AccesoDatos.php");
class Cochera
{
public $id;
public $piso;
public $estaLibre;
public $prioridad;

//Metodos Getters and Setters
public function GetId()
{
    return $this->id;
}

public function SetId($valor)
{
    $this->id = $valor;
}

public function GetPiso()
{
 return $this->piso;
}

public function SetPiso($valor)
{
    $this->piso = $valor;
}

public function GetEstaLibre()
{
    return $this->estaLibre;
}

public function SetEstaLibre($valor)
{
    $this->estaLibre = $valor;
}

public function GetPrioridad()
{
    return $this->prioridad;
}

public function SetPrioridad($valor)
{
    $this->prioridad = $valor;
}

//Constructor

public function construct__()
{

}
//Metodo toString()

public function ToString()
{ 
  return "Id: ".$this->id." - Piso: ".$this->piso." - Esta Libre: ".$this->estaLibre." - Prioridad: ".$this->prioridad."<br>";
}

public static function TraerLaCochera($idCochera)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from cochera where id= '$idCochera'");
    $consulta->execute();
    return $consulta->fetchObject('cochera');
}

public static function TraerTodasLasCocheras()
{
  $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
$consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, piso as piso, estaLibre as estaLibre, prioridad as prioridad from cochera");
$consulta->execute();
 return $consulta->fetchAll(PDO::FETCH_CLASS,'cochera');
}

public static function TraerTodasLasCocherasLibres()
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, piso as piso, estaLibre as estaLibre, prioridad as prioridad from cochera where estaLibre = 1 ");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_CLASS,'cochera');
}

}
?>