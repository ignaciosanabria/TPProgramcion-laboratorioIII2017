<?php
include_once("../bd/AccesoDatos.php");
class Cochera
{
public $id;
public $piso;
public $idAuto;
public $prioridad;
public $numero;

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

public function GetIdAuto()
{
    return $this->idAuto;
}

public function SetIdAuto($valor)
{
    $this->idAuto = $valor;
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

//Constructor

public function construct__()
{

}
//Metodo toString()

public function ToString()
{ 
  return "Id: ".$this->id." - Piso: ".$this->piso." - idAuto : ".$this->idAuto." - Prioridad: ".$this->prioridad." - Numero: ".$this->numero." - Veces De Uso: ".$this->vecesDeUso."<br>";
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
$consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, piso as piso, idAuto as idAuto, prioridad as prioridad, numero as numero from cochera");
$consulta->execute();
 return $consulta->fetchAll(PDO::FETCH_CLASS,'cochera');
}

public static function TraerTodasLasCocherasLibres()
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, piso as piso, idAuto as idAuto, prioridad as prioridad, numero as numero from cochera where idAuto IS NULL");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_CLASS,'cochera');
}


public static function TraerTodasLasCocherasConPrioridad()
{
  $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, piso as piso, idAuto as idAuto, prioridad as prioridad, numero as numero from cochera where prioridad = 1 ");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_CLASS,'cochera');
}

//MODIFICO SI TIENE AUTO O NO LA COCHERA

public static function ModificarLaCocheraLibre($cochera)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE cochera set numero = '$cochera->numero', piso = '$cochera->piso', idAuto = NULL , prioridad =  '$cochera->prioridad' where id = '$cochera->id'");
    return $consulta->execute();
}


public static function ModificarLaCocheraOcupada($cochera)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE cochera set numero = '$cochera->numero', piso = '$cochera->piso', idAuto = '$cochera->idAuto' , prioridad =  '$cochera->prioridad' where id = '$cochera->id'");
    return $consulta->execute();
}


public static function VerificarSiCocheraEstaDisponible($idCochera,$idAuto)
{
    $retorno = false;
    $cochera = Cochera::TraerLaCochera($idCochera);
    if($cochera == false)
    {
        $retorno = false;
    }
    else
    {
      if($cochera->idAuto == $idAuto)
      {
          $retorno = false;
      }
      else
      {
          $retorno = true;
      }
    }
    return $retorno;
}

public static function TraerCocherasUtilizadas($fecha_desde, $fecha_hasta)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT operacion_entrada.idCochera as cochera, count(t.id) as cantidad from (SELECT id from operacion_entrada where fecha_ingreso BETWEEN '07/23/2017 12:00 PM' and '07/25/2017 2:00 PM')t inner join operacion_entrada on t.id = operacion_entrada.id GROUP BY idCochera HAVING COUNT(idCochera) ORDER BY COUNT(idCochera)");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

public static function TraerPisoPorId($id)
{
    	$objetoAcceso = AccesoDatos::DameUnObjetoAcceso();
	    $consulta = $objetoAcceso->RetornarConsulta("Select piso from cochera where id = '$id'");
	    $consulta->execute();
	    $piso = $consulta->fetchColumn(0);  
	    return $piso;
}




}
?>