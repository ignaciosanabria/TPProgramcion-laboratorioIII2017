<?php
include_once('../bd/AccesoDatos.php');
class Operacion
{
    public $id;
    public $patente;
    public $fecha_ingreso;
    public $fecha_salida;
    public $importe;
    public $idCochera;
   
    //METODOS GETTERS AND SETTERS

    public function GetId()
    {
        return $this->id;
    }

    public function SetId($valor)
    {
        $this->id = $valor;
    }

    public function GetPatente()
    {
        return $this->patente;
    }

    public function SetPatente($valor)
    {
        $this->patente = $valor;
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

    //Constructor
    public function __construct()
    {

    }

    public static function TraerTodasLasOperaciones()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, patente as patente, fecha_ingreso as fecha_ingreso, fecha_salida as fecha_salida, importe as importe, idCochera as idCochera from operacion");
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
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO operacion (patente, fecha_ingreso, fecha_salida, importe, idCochera)"."VALUES('$operacion->patente','$operacion->fecha_ingreso','$operacion->fecha_salida','$operacion->importe','$operacion->idCochera')");
        return $consulta->execute();
    }

    public static function VerificarPatenteOperacion($patente)
    {
        $retorno = "error";
        $ArrayOperaciones = Operacion::TraerTodasLasOperaciones();
        foreach($ArrayOperaciones as $operacion)
        {
            if($operacion->GetPatente() == $patente)
            {
                $retorno = "ok";
            }
        }
        return $retorno;
    }

    public static function TraerLaOperacionPorPatente($patente)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from operacion where patente = '$patente' ");
        $consulta->execute();
        return $consulta->fetchObject(PDO::FETCH_CLASS,'operacion');
    }


}
?>