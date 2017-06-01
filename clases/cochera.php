<?php
require("BaseDeDatos/AccesoDatos.php");
//PREGUNTAR SI HACE CREAR ESTA CLASE
class Cochera
{
public $piso;
public const $cocherasReservadas = 3;
public $autos;

//Metodos Getters and Setters
public function GetPiso()
{
 return $this->piso;
}

public function SetPiso($valor)
{
    $this->piso = $valor;
}

public function GetCocherasReservadas()
{
 return $this->cocherasReservadas;
}

//Constructor

public function construct__($piso)
{
    $this->piso = $piso;
    $this->autos = array();
}

//Metodo toString()

public function ToString()
{

  $mensaje = "Piso: ".$this->piso." - Cocheras Reservadas - ".$this->cocherasReservadas."<br>";
  for($i=0;$i<count($this->autos);$i++)
  {
      $mensaje = $mensaje.$this->autos->ToString();
  }
  return $mensaje;
}

public static function InsertarLaCochera($cochera)
	{
$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

$consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO cochera (piso)" . "VALUES('$cochera->piso')");
$consulta->execute();		
//return $objetoAccesoDato->RetornarUltimoIdInsertado();
return $consulta;
	}

    public static function TraerElProducto($codBarra)
{
	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
	$consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM producto where codigo_barra = '$codBarra'");
	$consulta->execute();
	$productoRetorno = $consulta->fetchObject('producto');
	return $productoRetorno;
}


}
?>