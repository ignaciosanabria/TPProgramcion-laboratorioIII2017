<?php
include_once("../bd/AccesoDatos.php");
class Sesion
{
    public $id;
    public $idEmpleado;
    public $fecha_ingreso;
    public $fecha_salida;

    public function GetId()
    {
        return $this->id;
    }

    public function SetId($valor)
    {
        $this->id = $valor;
    }

     public function GetIdEmpleado()
    {
        return $this->idEmpleado;
    }

    public function SetIdEmpleado($valor)
    {
        $this->idEmpleado = $valor;
    }

    public function GetFechaIngreso()
    {
        return $this->fecha_ingreso;
    }

    public function SetFechaIngreso($valor)
    {
        $this->fecha_ingreso = $valor;
    }
    

      public function GetFechaSalida()
    {
        return $this->fecha_salida;
    }

    public function SetFechaSalida($valor)
    {
        $this->fecha_salida = $valor;
    }
    
 
   public function __construct()
   {

   } 


    public static function TraerTodasLasSesiones()
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, idEmpleado as idEmpleado, fecha_ingreso as fecha_ingreso, fecha_salida from sesion");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS,'sesion');
    }

    public static function InsertarSesionInicio($sesion)
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO sesion (idEmpleado,fecha_ingreso,fecha_salida)"."VALUES('$sesion->idEmpleado','$sesion->fecha_ingreso',NULL)");
        $consulta->execute();   
    }

    public static function TraerSesionSinSalida($idEmpleado)
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from sesion where idEmpleado = '$idEmpleado' && fecha_salida IS NULL ");
        $consulta->execute();
        return $consulta->fetchObject('sesion');
    }

    public static function ModificarSesionSalida($sesion)
    {
       $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
       $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE sesion set fecha_ingreso = '$sesion->fecha_ingreso', idEmpleado = '$sesion->idEmpleado', fecha_salida = '$sesion->fecha_salida' where id = '$sesion->id'");
       $consulta->execute();   
    }

    public static function TraerUltimoIdAgregado()
	{
	    $objetoAcceso = AccesoDatos::DameUnObjetoAcceso(); 
	    
	    $consulta = $objetoAcceso->RetornarConsulta("SELECT id from sesion order by id DESC limit 1");
	    $consulta->execute();
	    $idSesion = $consulta->fetchColumn(0);
	    return $idSesion;
	}

    public static function TraerSesionPorId($id)
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from sesion where id = '$id'");
        $consulta->execute();
        return $consulta->fetchObject('sesion');
    }
}
?>