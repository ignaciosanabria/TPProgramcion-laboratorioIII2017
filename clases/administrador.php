<?php
include_once("../bd/AccesoDatos.php");
class Administrador
{
 public $id;
 public $mail;
 public $clave;
 public $nombre;

//METODOS GETTERS
 public function GetId()
 {
     return $this->id;
 }

 public function SetId($valor)
 {
     $this->id = $valor;
 }

 public function GetMail()
 {
     return $this->mail;
 }

 public function SetMail($valor)
 {
     $this->mail = $valor;
 }

 public function GetClave()
 {
     return $this->clave;
 }

 public function SetClave($valor)
 {
     $this->clave = $valor;
 }

 public function GetNombre()
 {
	 return $this->nombre;
 }

 public function SetNombre($valor)
 {
	 $this->nombre = $valor;
 }

 public function __construct()
 {
	 
 }


 //METODO ToString()

 public function ToString()
 {
     return "Id: ".$this->id." - Nombre: ".$this->nombre." - Mail: ".$this->mail." - Clave: ".$this->clave."<br>";
 }


 	public static function TraerTodosLosAdministradores()
	{
	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
	$consulta = $objetoAccesoDato->RetornarConsulta("SELECT id AS id, mail AS mail, clave AS clave, nombre as nombre FROM administrador");
	 //UNA VEZ PUESTA LA CONSULTA HAY QUE EJECUTARLA
	 $consulta->execute();
	 //$datos = $consulta->fetchAll();
	 
	 return $consulta->fetchAll(PDO::FETCH_CLASS,'Administrador');
	}

public static function InsertarElAdministradorParametros($user)
	{
$objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
$consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO administrador (mail, clave, nombre)"."VALUES('$user->mail','$user->clave','$user->nombre')");
return $consulta->execute();		
	}

public static function BorrarElAdministrador($id)
{
	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
	$consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM administrador where id = '$id'");
	$consulta->execute();
	//return $consulta->rowCount();
   return $consulta;
}

public static function TraerElAdministrador($id)
{
	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
	$consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM administrador where id = '$id'");
	$consulta->execute();
	$AdministradorRetorno = $consulta->fetchObject('administrador');
	return $AdministradorRetorno;
}

public static function ModificarElAdministrador($user)
{
	       $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			/*$consulta =$objetoAccesoDato->RetornarConsulta("
				update persona 
				set nombre=:nombre,
				apellido=:apellido,
				foto=:foto
				WHERE id=:id");
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();*/ 
			
			$consulta = $objetoAccesoDato->RetornarConsulta("UPDATE administrador SET mail = '$user->mail', clave = '$user->clave'
			WHERE id = '$user->id'");
			return $consulta->execute();
}


public static function VerificarAdministrador($mail,$clave)
{
	$retorno = "error";
	$ArrayAdministradores = Administrador::TraerTodosLosAdministradores();
	foreach($ArrayAdministradores as $user)
	{
		if($user->GetMail() == $mail && $user->GetClave() == $clave)
		{
			$retorno = "ok";
		}
	}
	return $retorno;
}

public static function TraerElAdministradorPorMailYClave($mail,$clave)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
	$consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM administrador where mail = '$mail' && clave='$clave'");
	$consulta->execute();
	$AdministradorRetorno = $consulta->fetchObject('administrador');
	return $AdministradorRetorno;
}


}
?>