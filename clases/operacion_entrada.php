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

    public static function TraerVecesQueVinieronLosAutos($fecha_desde, $fecha_hasta)
    {
        $objetoAcceso = AccesoDatos::DameUnObjetoAcceso(); 
	    $consulta = $objetoAcceso->RetornarConsulta("SELECT auto.patente as auto, COUNT(*) as vecesQueVino FROM operacion_entrada INNER JOIN auto ON auto.id = operacion_entrada.idAuto WHERE fecha_ingreso BETWEEN '$fecha_desde' AND '$fecha_hasta' GROUP BY idAuto ORDER BY vecesQueVino DESC");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function TraerVecesQueVinoElAutoPorIdAuto($fecha_desde, $fecha_hasta, $idAuto)
    {
       $objetoAcceso = AccesoDatos::DameUnObjetoAcceso(); 
	    $consulta = $objetoAcceso->RetornarConsulta("SELECT auto.patente as auto, COUNT(*) as vecesQueVino FROM operacion_entrada INNER JOIN auto ON auto.id = operacion_entrada.idAuto WHERE operacion_entrada.idAuto = '$idAuto' && fecha_ingreso BETWEEN '$fecha_desde' AND '$fecha_hasta' GROUP BY idAuto ORDER BY vecesQueVino DESC");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function TraerAutosDistintosQueVinieron($fecha_desde, $fecha_hasta)
    {
        //SELECT auto.patente as auto FROM operacion_entrada INNER JOIN auto ON auto.id = operacion_entrada.idAuto WHERE fecha_ingreso BETWEEN '07/21/2017 9:00 AM' AND '07/22/2017 11:00 PM' GROUP BY idAuto
        $objetoAcceso = AccesoDatos::DameUnObjetoAcceso(); 
	    $consulta = $objetoAcceso->RetornarConsulta("SELECT auto.patente as auto FROM operacion_entrada INNER JOIN auto ON auto.id = operacion_entrada.idAuto WHERE fecha_ingreso BETWEEN '$fecha_desde' AND '$fecha_hasta' GROUP BY idAuto");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function ExportarAutosQueEntraron($fecha_desde, $fecha_hasta)
    {
        $objetoAcceso = AccesoDatos::DameUnObjetoAcceso(); 
	    $consulta = $objetoAcceso->RetornarConsulta("SELECT fecha_ingreso as fecha_ingreso, auto.patente as auto, cochera.id as cochera, CONCAT(empleado.nombre, ' ' , empleado.apellido) as empleado FROM operacion_entrada INNER JOIN auto ON auto.id = operacion_entrada.idAuto INNER JOIN empleado ON operacion_entrada.idEmpleado = empleado.id INNER JOIN cochera ON cochera.id = operacion_entrada.idCochera WHERE fecha_ingreso BETWEEN '$fecha_desde' AND '$fecha_hasta' ORDER BY fecha_ingreso");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function VerPromedioDeCocheraYEmpleado($fecha_desde, $fecha_hasta)
    {
        $objetoAcceso = AccesoDatos::DameUnObjetoAcceso(); 
	    $consulta = $objetoAcceso->RetornarConsulta("SELECT operacion_entrada.idCochera as cochera, CONCAT(empleado.nombre,' ',empleado.apellido) as empleado, COUNT(*) AS cantidad FROM operacion_entrada INNER JOIN empleado ON empleado.id = operacion_entrada.idEmpleado WHERE fecha_ingreso BETWEEN '$fecha_desde' AND '$fecha_hasta' GROUP BY idCochera, idEmpleado ORDER BY operacion_entrada.idEmpleado ASC");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function VerPromedioDeCocheraYAuto($fecha_desde, $fecha_hasta)
    {
        $objetoAcceso = AccesoDatos::DameUnObjetoAcceso(); 
	    $consulta = $objetoAcceso->RetornarConsulta("SELECT operacion_entrada.idCochera AS cochera, auto.patente AS auto, COUNT( * ) AS cantidad FROM operacion_entrada INNER JOIN auto ON auto.id = operacion_entrada.idAuto WHERE fecha_ingreso BETWEEN  '$fecha_desde' AND  '$fecha_hasta' GROUP BY idCochera, idAuto ORDER BY operacion_entrada.idAuto ASC ");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function VerPromedioDePatentes($fecha_desde, $fecha_hasta)
    {
        $objetoAcceso = AccesoDatos::DameUnObjetoAcceso(); 
	    $consulta = $objetoAcceso->RetornarConsulta("SELECT auto.patente as auto, COUNT(*) AS vecesQueVino FROM operacion_entrada INNER JOIN auto ON operacion_entrada.idAuto = auto.id WHERE fecha_ingreso BETWEEN '$fecha_desde' AND  '$fecha_hasta' GROUP BY operacion_entrada.idAuto ORDER BY `vecesQueVino` DESC");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }



    
}
?>