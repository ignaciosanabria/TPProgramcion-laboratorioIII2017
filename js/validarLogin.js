
function EnviarDatos()
{
    var funcionAjax = $.ajax({
    url : "../vendor/index.php/ValidarUsuario",
    method: "POST",
    data: {mail: $("#mail").val(), clave: $("#clave").val(),tipo:$('input[name=tipo]:checked').val(),horaLogin:$("#horaLogin").val()}
    });
    funcionAjax.then(function(dato){
        //PREGUNTAR A LOS PROFES POR QUE SE ENVIA DOS VECES EL RESPONSE
      if(dato.status == "200" && dato.tipo == "administrador")
      {
      //console.log(dato);
      alert("El mail y la clave estan en la base de datos");
      window.location.replace("../enlaces/estacionamiento.html");
      }
      else if(dato.status == "200" && dato.tipo == "empleado")
     {
       localStorage.setItem("hora",dato.hora);
       if(dato.id == false)
       {
         console.log("ERROR en ingresar");
       }
       else
       {
           localStorage.setItem("idEmpleado",dato.id);
       }
       alert("El mail y la clave estan en la base de datos");
       window.location.replace("../enlaces/estacionamientoEmpleado.html");
    }
  else
  {
      alert("ERROR. Revise su tipo de usuario, su mail y su contraseña!");
  }
    },function(dato){
    if(dato.status == 400)
     alert("ERROR"+dato);
    });
}