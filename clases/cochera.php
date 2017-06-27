<?php
include_once("../bd/AccesoDatos.php");
class Cochera
{
public $id;
public $piso;
public $estaLibre;
public $prioridad;
public $numero;
public $vecesDeUso;

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


public function GetNumero()
{
    return $this->numero;
}

public function SetNumero($valor)
{
    $this->numero = $valor;
}

public function GetVecesDeUso()
{
    return $this->vecesDeUso;
}

public function SetVecesDeUso($valor)
{
    $this->vecesDeUso = $valor;
}

//Constructor

public function construct__()
{

}
//Metodo toString()

public function ToString()
{ 
  return "Id: ".$this->id." - Piso: ".$this->piso." - Esta Libre: ".$this->estaLibre." - Prioridad: ".$this->prioridad." - Numero: ".$this->numero." - Veces De Uso: ".$this->vecesDeUso."<br>";
}

//INSERTAR


//METODOS GETTERS DE COCHERA DESDE BASE DE DATOS

public static function TraerLaCochera($idCochera)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from cochera where id= '$idCochera'");
    $consulta->execute();
    return $consulta->fetchObject('cochera');
}

public static function TraerLaCocheraPorNumero($numero)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from cochera where numero = '$numero'");
    $consulta->execute();
    return $consulta->fetchObject('cochera');
}


public static function TraerLaCocheraPorIdYPrioridad($idCochera,$prioridad)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from cochera where id = '$idCochera' && prioridad = '$prioridad'");
    $consulta->execute();
    return $consulta->fetchObject('cochera');
}

public static function TraerTodasLasCocheras()
{
  $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
$consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, piso as piso, estaLibre as estaLibre, prioridad as prioridad, numero as numero, vecesDeUso as vecesDeUso from cochera");
$consulta->execute();
 return $consulta->fetchAll(PDO::FETCH_CLASS,'cochera');
}

public static function TraerTodasLasCocherasLibres()
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, piso as piso, estaLibre as estaLibre, prioridad as prioridad, numero as numero, vecesDeUso as vecesDeUso from cochera where estaLibre = 1 ");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_CLASS,'cochera');
}


public static function TraerTodasLasCocherasConPrioridad()
{
  $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, piso as piso, estaLibre as estaLibre, prioridad as prioridad, numero as numero, vecesDeUso as vecesDeUso from cochera where prioridad = 1 ");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_CLASS,'cochera');
}


public static function InsertarLaCochera($cochera)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO cochera (numero ,piso , estaLibre, prioridad, vecesDeUso)"."VALUES('$cochera->numero','$cochera->piso','$cochera->estaLibre','$cochera->prioridad','$cochera->vecesDeUso')");
    return $consulta->execute();
}

//BORRAR Y MODIFICAR DE BASE DE DATOS

public static function BorrarLaCochera($idCochera)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("DELETE from cochera where id = '$idCochera'");
    return $consulta->execute();
}

public static function ModificarLaCochera($cochera)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE cochera set numero = '$cochera->numero', piso = '$cochera->piso', estaLibre = '$cochera->estaLibre', prioridad =  '$cochera->prioridad', vecesDeUso = '$cochera->vecesDeUso' where id = '$cochera->id'");
    return $consulta->execute();
}




}
?>