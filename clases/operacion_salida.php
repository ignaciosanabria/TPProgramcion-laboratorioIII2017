<?php
include_once('../bd/AccesoDatos.php');
class Operacion_Salida
{
    public $id;
    public $idOperacionEntrada;
    public $importe;
    public $fecha_salida;
    public $idEmpleado;
    public $idAuto;
  
   public function GetId()
    {
        return $this->id;
    }

    public function SetId($valor)
    {
        $this->id = $valor;
    }
    
    public function GetIdOperacionEntrada()
    {
        return $this->idOperacionEntrada;
    }

    public function SetIdOperacionEntrada($valor)
    {
        $this->idOperacionEntrada = $valor;
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

     public function GetIdEmpleado()
    {
        return $this->idEmpleado;
    }

    public function SetIdEmpleado($valor)
    {
        $this->idEmpleado = $valor;
    }

    public function GetIdAuto()
    {
        return $this->idAuto;
    }

    public function SetIdAuto($valor)
    {
        $this->idAuto = $valor;
    }

    //Constructor
    public function __construct()
    {

    }

    public static function TraerTodasLasOperacionesSalida()
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, idOperacionEntrada as idOperacionEntrada, importe as importe, fecha_salida as fecha_salida, idEmpleado as idEmpleado from operacion_salida");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS,'operacion_salida');
    }

    public static function TraerOperacionesFinalizadas()
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from operacion_salida where fecha_salida IS NOT NULL && importe != 0 ");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS,'operacion_salida');
    }

    public static function TraerOperacionesNoFinalizadas()
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from operacion_salida where fecha_salida IS NULL && importe = 0 ");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS,'operacion_salida');
    }

    public static function TraerOperacionSalidaNoFinalizada($idAuto)
    {
       $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
       $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * from operacion_salida where idAuto = '$idAuto' && fecha_salida IS NULL");
       $consulta->execute();
       return $consulta->fetchObject("operacion_salida");
    }
    
    //CUANDO INGRESO EL AUTO AL ESTACIONAMIENTO - ESTE TIENE UNA SALIDA PERO QUE SIN IMPORTE NI FECHA DE SALIDA - El empleado puede ser cualquiera
    public static function InsertarOperacionSalida($operacion_salida)
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
       $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO operacion_salida (fecha_salida,idOperacionEntrada,importe,idEmpleado,idAuto)"."VALUES(NULL,'$operacion_salida->idOperacionEntrada','$operacion_salida->importe',NULL,'$operacion_salida->idAuto')");
       return $consulta->execute();
    }

    //CUANDO EL AUTO SALE MODIFICO - SU FECHA DE SALIDA, IMPORTE - El empleado puede ser cualquiera

    public static function ModificarOperacionSalida($operacion_salida)
    {
       $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
       $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE operacion_salida SET fecha_salida = '$operacion_salida->fecha_salida', idOperacionEntrada = '$operacion_salida->idOperacionEntrada', importe = '$operacion_salida->importe' , idEmpleado = '$operacion_salida->idEmpleado' where id = '$operacion_salida->id'");
       return $consulta->execute();
    }


    
    public static function BuscarEntreFechas($fecha_desde,$fecha_hasta)
    {
        $objetoAcceso = AccesoDatos::DameUnObjetoAcceso(); 
	    $consulta = $objetoAcceso->RetornarConsulta("SELECT * FROM operacion_salida WHERE fecha_salida BETWEEN '$fecha_desde' and '$fecha_hasta' ");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS,'operacion_salida');
    }

    public static function CalcularImporteEntreFechas($fecha_desde,$fecha_hasta)
    {
        $objetoAcceso = AccesoDatos::DameUnObjetoAcceso(); 
	    $consulta = $objetoAcceso->RetornarConsulta("SELECT SUM(importe) FROM `operacion_salida` WHERE fecha_salida BETWEEN '$fecha_desde' and '$fecha_hasta'");
        $consulta->execute();
        $facturacion = $consulta->fetchColumn(0);
	    return $facturacion;
    }

   //CALCULAR FACTURACION DE CADA VEHICULO Y CANTIDAD DE VEHICULOS - SACAR FACTURACION CON COUNT PHP
   //SELECT SUM(importe), operacion_salida.idAuto FROM operacion_salida WHERE fecha_salida BETWEEN '07/23/2017 4:PM' AND '07/28/2017 7:00 PM' GROUP BY operacion_salida.idAuto

  public static function CalcularFacturacionEntreFechas($fecha_desde,$fecha_hasta)
  {
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
	$consulta = $objetoAccesoDato->RetornarConsulta("SELECT SUM(importe) as importesAcumulados , auto.patente as auto FROM operacion_salida INNER JOIN auto ON operacion_salida.idAuto = auto.id WHERE fecha_salida BETWEEN '$fecha_desde' AND '$fecha_hasta' GROUP BY operacion_salida.idAuto");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
  }


  //CALCUCLAR FACTURACION DE CADA VEHICULO Y CANTIDAD DE VEHICULOS (TRAIDOS POR SUS PATENTES) - SACAR FACTURACION CON COUNT PHP
  //SELECT SUM(importe) as importe , auto.patente as auto FROM operacion_salida INNER JOIN auto ON operacion_salida.idAuto = auto.id WHERE fecha_salida BETWEEN '07/23/2017 4:00 PM' AND '07/28/2017 7:00 PM' GROUP BY operacion_salida.idAuto


  public static function VerPromedioDeImportes($fecha_desde, $fecha_hasta)
  {
      //SELECT importe AS importe, auto.patente AS auto, fecha_salida AS fecha_salida FROM operacion_salida INNER JOIN auto ON operacion_salida.idAuto = auto.id WHERE fecha_salida BETWEEN  '07/15/2017 4:00 PM' AND  '07/28/2017 5:00 PM' GROUP BY operacion_salida.id ORDER BY idAuto
    $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
	$consulta = $objetoAccesoDato->RetornarConsulta("SELECT importe AS importe, auto.patente AS auto, fecha_salida AS fecha_salida FROM operacion_salida INNER JOIN auto ON operacion_salida.idAuto = auto.id WHERE fecha_salida BETWEEN  '$fecha_desde' AND  '$fecha_hasta' GROUP BY operacion_salida.id ORDER BY idAuto");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function ExportarAutosQueSalieron($fecha_desde, $fecha_hasta)
  {
      //SELECT fecha_salida as fecha_salida, auto.patente as auto, CONCAT(empleado.nombre, ' ' , empleado.apellido) as empleado, importe as importe FROM operacion_salida INNER JOIN auto ON auto.id = operacion_salida.idAuto INNER JOIN empleado ON operacion_salida.idEmpleado = empleado.id WHERE fecha_salida BETWEEN '07/15/2017 4:00 PM' AND '07/28/2017 5:00 PM' ORDER BY fecha_salida
      $objetoAcceso = AccesoDatos::DameUnObjetoAcceso(); 
	  $consulta = $objetoAcceso->RetornarConsulta("SELECT fecha_salida as fecha_salida, auto.patente as auto, CONCAT(empleado.nombre, ' ' , empleado.apellido) as empleado, importe as importe FROM operacion_salida INNER JOIN auto ON auto.id = operacion_salida.idAuto INNER JOIN empleado ON operacion_salida.idEmpleado = empleado.id WHERE fecha_salida BETWEEN '$fecha_desde' AND '$fecha_hasta' ORDER BY fecha_salida");
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
  }

}
?>