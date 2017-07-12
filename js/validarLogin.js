
function EnviarDatos()
{
    var funcionAjax = $.ajax({
    url : "../vendor/Usuario/ValidarUsuario",
    method: "POST",
    data: {mail: $("#mail").val(), clave: $("#clave").val(),horaLogin:$("#horaLogin").val()}
    });
    funcionAjax.then(function(dato){
        //PREGUNTAR A LOS PROFES POR QUE SE ENVIA DOS VECES EL RESPONSE
      if(dato.status == "200" && dato.tipo == "administrador")
      {
      //console.log(dato);
      //alert("El mail y la clave estan en la base de datos");
        swal(
          'USUARIO VÁLIDO!',
          'Usted esta registrado en la base de datos!',
          'success'
        ).then(function(){
          window.location.replace("../enlaces/estacionamiento.html");
        },function(){
          swal('Algo inesperado ocurrio');
        });
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
       swal(
         'USUARIO VÁLIDO!',
         'Usted esta registrado en la base de datos!',
         'success'
       );
       window.location.replace("../enlaces/estacionamientoEmpleado.html");
    }
  else
  {
      alert("ERROR. Revise su mail y/o su contraseña!");
  }
    },function(dato){
     alert("ERROR"+dato);
    });
}