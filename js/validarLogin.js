

function EnviarDatos()
{
    var funcionAjax = $.ajax({
    url : "../vendor/index.php/ValidarUsuario",
    method: "POST",
    data: {mail: $("#mail").val(), clave: $("#clave").val()},
});
funcionAjax.then(validarOk,validarError);
}

function validarOk(dato)
{
  if(dato.status == "200")
  {
      alert("El mail y la clave estan en la base de datos");
      window.location.replace("../enlaces/estacionamiento.html");
  }
}

function validarError(dato)
{
 if(dato.status == "400")
 {
     alert("ERROR");
 }
}