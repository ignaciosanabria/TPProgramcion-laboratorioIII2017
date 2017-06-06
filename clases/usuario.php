<?php
include_once("../bd/AccesoDatos.php");
class Usuario
{
 public $id;
 public $mail;
 public $clave;
 //FALTA AGREGAR ATRIBUTO esAdministrador -> bool

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


 //METODO ToString()

 public function ToString()
 {
     return "Id: ".$this->id." - Mail: ".$this->mail." - Clave: ".$this->clave."<br>";
 }


 	public static function TraerTodosLosUsuarios()
	{
	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
	$consulta = $objetoAccesoDato->RetornarConsulta("SELECT id AS id, mail AS mail, clave AS clave FROM usuario");
	 //UNA VEZ PUESTA LA CONSULTA HAY QUE EJECUTARLA
	 $consulta->execute();
	 //$datos = $consulta->fetchAll();
	 
	 return $consulta->fetchAll(PDO::FETCH_CLASS,'usuario');
	}

public static function InsertarElUsuarioParametros($user)
	{
$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

$consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuario (mail, clave)" . "VALUES($user->mail','$user->clave', '$user->estado')");
$consulta->execute();		
//return $objetoAccesoDato->RetornarUltimoIdInsertado();
return $consulta;
	}

public static function BorrarElUsuario($id)
{
	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
	$consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM usuario where id = '$id'");
	$consulta->execute();
	//return $consulta->rowCount();
   return $consulta;
}

public static function TraerElUsuario($id)
{
	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
	$consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuario where id = '$id'");
	$consulta->execute();
	$usuarioRetorno = $consulta->fetchObject('usuario');
	return $usuarioRetorno;
}

public static function ModificarElUsuario($user)
{
	       $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			/*$consulta =$objetoAccesoDato->RetornarConsulta("
				update persona 
				set nombre=:nombre,
				apellido=:apellido,
				foto=:foto
				WHERE id=:id");
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();*/ 
			
			$consulta = $objetoAccesoDato->RetornarConsulta("UPDATE usuario SET mail = '$user->mail', clave = '$user->clave'
			WHERE id = '$user->id'");
			return $consulta->execute();
}


public static function VerificarUsuario($mail,$clave)
{
	$retorno = "error";
	$ArrayUsuarios = Usuario::TraerTodosLosUsuarios();
	foreach($ArrayUsuarios as $user)
	{
		if($user->GetMail() == $mail && $user->GetClave() == $clave)
		{
			$retorno = "ok";
		}
	}
	return $retorno;
}


}
?>