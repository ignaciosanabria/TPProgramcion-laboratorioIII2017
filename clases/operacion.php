<?php
require('../bd/AccesoDatos.php');
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
        $this->valor = $valor;
    }

    //Constructor
    public function __construct()
    {

    }

    public static function InsertarOperacion($operacion)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO operacion ()");
        return $consulta->execute();
    }


}
?>