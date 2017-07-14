<?php
include_once('../bd/AccesoDatos.php');
class Operacion
{
    public $id;
    public $idAuto;
    public $fecha_ingreso;
    public $fecha_salida;
    public $importe;
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

    public function GetFechaSalida()
    {
        return $this->fecha_salida;
    }

    public function SetFechaSalida($valor)
    {
        $this->fecha_salida = $valor;
    }

    public function GetImporte()
    {
        return $this->importe;
    }

    public function SetImporte($valor)
    {
        $this->importe = $valor;
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

    public static function TraerTodasLasOperaciones()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, fecha_ingreso as fecha_ingreso, fecha_salida as fecha_salida, importe as importe, idCochera as idCochera, idEmpleado as idEmpleado, idAuto as idAuto from operacion");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS,'operacion');
    }

    public static function TraerLaOperacion($idOperacion)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from operacion where'$idOperacion'");
        $consulta->execute();
        return $consulta->fetchObject(PDO::FETCH_CLASS,'operacion');
    }

    public static function InsertarLaOperacion($operacion)
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO operacion (fecha_ingreso, fecha_salida, importe, idCochera, idEmpleado, idAuto)"."VALUES('$operacion->fecha_ingreso','$operacion->fecha_salida','$operacion->importe','$operacion->idCochera','$operacion->idEmpleado','$operacion->idAuto')");
        return $consulta->execute();
    }

    // public static function VerificarIdAutoOperacion($IdAuto)
    // {
    //     $retorno = "error";
    //     $ArrayOperaciones = Operacion::TraerTodasLasOperaciones();
    //     foreach($ArrayOperaciones as $operacion)
    //     {
    //         if($operacion->GetIdAuto() == $IdAuto)
    //         {
    //             $retorno = "ok";
    //         }
    //     }
    //     return $retorno;
    // }

    public static function TraerLaOperacionNoCerrada($idAuto)
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, fecha_ingreso as fecha_ingreso, fecha_salida as fecha_salida, importe as importe, idCochera as idCochera, idEmpleado as idEmpleado, idAuto as idAuto from operacion where idAuto = '$idAuto' && fecha_salida = ' ' ");
        $consulta->execute();
        return $consulta->fetchObject('operacion');
    }

    public static function ModificarLaOperacionACerrar($operacion)
    {
      $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
      $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE operacion set fecha_salida = '$operacion->fecha_salida', importe = '$operacion->importe' where id = '$operacion->id'");
      return $consulta->execute();
    }


    


}
?>