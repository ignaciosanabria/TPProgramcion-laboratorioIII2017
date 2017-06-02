<?php
require("../bd/AccesoDatos.php");
//PREGUNTAR SI HACE CREAR ESTA CLASE
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