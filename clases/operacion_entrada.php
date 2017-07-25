<?php
include_once('../bd/AccesoDatos.php');
include_once('auto.php');
class Operacion_Entrada
{
    public $id;
    public $fecha_ingreso;
    public $idAuto;
    public $idCochera;
    public $idEmpleado;
    
       
    //METODOS GETTERS AND SETTERS
    public function GetId()
    {
        return $this->id;
    }

    public function SetId($valor)
    {
        $this->id = $valor;
    }

    public function GetIdAuto()
    {
        return $this->idAuto;
    }

    public function SetIdAuto($valor)
    {
        $this->idAuto = $valor;
    }

    public function GetFechaIngreso()
    {
        return $this->fecha_ingreso;
    }

    public function SetFechaIngreso($valor)
    {
        $this->fecha_ingreso = $valor;
    }

    public function GetIdCochera()
    {
        return $this->idCochera;
    }

    public function SetIdCochera($valor)
    {
        $this->idCochera = $valor;
    }

    public function GetIdEmpleado()
    {
        return $this->idEmpleado;
    }

    public function SetIdEmpleado($valor)
    {
        $this->idEmpleado = $valor;
    }

    //Constructor
    public function __construct()
    {

    }

    public static function TraerTodasLasOperacionesEntrada()
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, fecha_ingreso as fecha_ingreso, idCochera as idCochera, idEmpleado as idEmpleado, idAuto as idAuto from operacion_entrada");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS,'operacion_entrada');
    }

    public static function TraerLaOperacionEntrada($idOperacionEntrada)
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from operacion_entrada where id = '$idOperacionEntrada'");
        $consulta->execute();
        return $consulta->fetchObject('operacion_entrada');
    }

    public static function InsertarLaOperacionEntrada($operacion_entrada)
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO operacion_entrada (fecha_ingreso, idAuto, idCochera, idEmpleado)"."VALUES('$operacion_entrada->fecha_ingreso','$operacion_entrada->idAuto','$operacion_entrada->idCochera','$operacion_entrada->idEmpleado')");
        return $consulta->execute();
    }

    public static function TraerLasOperacionesEntradaPorIdAuto($idAuto)
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from operacion_entrada where idAuto = '$idAuto' ");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS,'operacion_entrada');
    }

    public static function TraerUltimoIdAgregado()
	{
	    $objetoAcceso = AccesoDatos::DameUnObjetoAcceso(); 
	    
	    $consulta = $objetoAcceso->RetornarConsulta("SELECT id from operacion_entrada order by id DESC limit 1");
	    $consulta->execute();
	    $idOperacionEntrada = $consulta->fetchColumn(0);
	    return $idOperacionEntrada;
	}

    public static function BuscarEntreFechas($fecha_de,$fecha_hasta)
    {
        $objetoAcceso = AccesoDatos::DameUnObjetoAcceso(); 
	    $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM operacion_entrada WHERE fecha_ingreso BETWEEN '$fecha_de' and '$fecha_hasta'");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS,'operacion_entrada');
    }
    

}
?>