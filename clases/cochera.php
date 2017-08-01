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
    //$consulta = $objetoAccesoDato->RetornarConsulta("SELECT operacion_entrada.idCochera as cochera, count(t.id) as cantidad from (SELECT id from operacion_entrada where fecha_ingreso BETWEEN '07/23/2017 12:00 PM' and '07/25/2017 2:00 PM')t inner join operacion_entrada on t.id = operacion_entrada.id GROUP BY idCochera HAVING COUNT(idCochera) ORDER BY COUNT(idCochera)");
    //SELECT operacion_entrada.idCochera as cochera, COUNT(*) AS cantidad FROM operacion_entrada WHERE fecha_ingreso BETWEEN '07/21/2017 8:00 AM' AND '07/25/2017 1:34 PM' GROUP BY idCochera ORDER BY `cantidad` DESC
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT operacion_entrada.idCochera as cochera, COUNT(*) AS cantidad FROM operacion_entrada WHERE fecha_ingreso BETWEEN '$fecha_desde' AND '$fecha_hasta' GROUP BY idCochera ORDER BY `cantidad` DESC");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

public static function TraerCocherasSinUso($fecha_desde,$fecha_hasta)
{
   $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
   $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from cochera where not exists (select * from operacion_entrada where idCochera = cochera.id && fecha_ingreso BETWEEN '$fecha_desde' and '$fecha_hasta')");
   $consulta->execute();
   return $consulta->fetchAll(PDO::FETCH_CLASS,'cochera');
}

//CANTIDAD DE VECES QUE VINO EL MISMO AUTO
//SELECT operacion_entrada.idAuto as auto, COUNT(*) AS cantidad FROM operacion_entrada WHERE fecha_ingreso BETWEEN '07/21/2017 9:00 AM' AND '07/26/2017 8:00 PM' GROUP BY idAuto ORDER BY cantidad DESC
//AUTOS DISTINTOS QUE VINIERON AL ESTACIONAMIENTO
//SELECT patente as auto from auto where exists (select * from operacion_entrada where idAuto = auto.id && fecha_ingreso BETWEEN '07/21/2017 9:00 AM' and '07/26/2017 8:00 PM')
//FACTURACION - CANTIDAD DE VEHICULOS 
// SELECT sum(operacion_salida.importe), COUNT(idAuto) from operacion_salida where fecha_salida BETWEEN '07/23/2017 05:00 PM' and '07/26/2017 10:00 PM'
//CANTIDAD DE OPERACIONES DE EMPLEADO
//SELECT operacion_entrada.idEmpleado as empleado, COUNT(*) AS cantidad FROM operacion_entrada WHERE fecha_ingreso BETWEEN '07/21/2017 9:00 AM' AND '07/26/2017 8:00 PM' GROUP BY idEmpleado ORDER BY cantidad DESC
//PROMEDIO DE COCHERA Y USUARIO - EMPLEADO
//SELECT operacion_entrada.idCochera as cochera, CONCAT(empleado.nombre," ",empleado.apellido) as empleado, COUNT(*) AS cantidad FROM operacion_entrada INNER JOIN empleado ON empleado.id = operacion_entrada.idEmpleado WHERE fecha_ingreso BETWEEN '07/15/2017 8:00 AM' AND '07/28/2017 8:00 AM' GROUP BY idCochera, idEmpleado ORDER BY operacion_entrada.idEmpleado ASC
//PROMEDIO DE COCHERA Y USUARIO - PATENTE
//SELECT operacion_entrada.idCochera AS cochera, auto.patente AS auto, COUNT( * ) AS cantidad FROM operacion_entrada INNER JOIN auto ON auto.id = operacion_entrada.idAuto WHERE fecha_ingreso BETWEEN  '07/15/2017 8:00 AM' AND  '07/28/2017 8:00 AM' GROUP BY idCochera, idAuto ORDER BY operacion_entrada.idAuto ASC 
//PROMEDIO DE PATENES - VECES QUE VINO ESA PATENTE
//SELECT auto.patente as auto, COUNT(*) AS vecesQueVino FROM operacion_entrada INNER JOIN auto ON operacion_entrada.idAuto = auto.id WHERE fecha_ingreso BETWEEN '07/15/2017 8:00 AM' AND '07/28/2017 9:00 AM' GROUP BY operacion_entrada.idAuto ORDER BY `vecesQueVino` DESC

public static function TraerPisoPorId($id)
{
    	$objetoAcceso = AccesoDatos::DameUnObjetoAcceso();
	    $consulta = $objetoAcceso->RetornarConsulta("Select piso from cochera where id = '$id'");
	    $consulta->execute();
	    $piso = $consulta->fetchColumn(0);  
	    return $piso;
}

    //Select * from cochera where not exists (select * from operacion_entrada where idCochera = cochera.id)
    //SELECT * from cochera where not exists (select * from operacion_entrada where idCochera = cochera.id && fecha BETWEEN 07/21/2017 6:00 AM and 07/25/2017 4:00 PM


public static function VerUsoDeCocherasSinPrioridad($fecha_desde, $fecha_hasta)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT cochera.id as cochera, COUNT(*) AS cantidad , cochera.prioridad as prioridad FROM operacion_entrada INNER JOIN cochera ON operacion_entrada.idCochera = cochera.id && cochera.prioridad = 0 WHERE fecha_ingreso BETWEEN '$fecha_desde' AND '$fecha_hasta' GROUP BY idCochera ORDER BY `cantidad` DESC");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}

public static function VerUsoDeCocherasParaDiscapacitados($fecha_desde, $fecha_hasta)
{
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("SELECT cochera.id as cochera, COUNT(*) AS cantidad , cochera.prioridad as prioridad FROM operacion_entrada INNER JOIN cochera ON operacion_entrada.idCochera = cochera.id && cochera.prioridad = 1 WHERE fecha_ingreso BETWEEN '$fecha_desde' AND '$fecha_hasta' GROUP BY idCochera ORDER BY `cantidad` DESC");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
}



}
?>