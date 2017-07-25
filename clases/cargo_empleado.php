<?php
include_once('../bd/AccesoDatos.php');
class Cargo_Empleado
{
  public $id;
  public $cargo;

  public static function TraerTodosLosCargos()
  {
      $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
      $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id as id, cargo as cargo from cargo_empleado");
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_CLASS,'cargo_empleado');
  }
}
?>