
function EnviarDatos()
{
    var funcionAjax = $.ajax({
    url : "../vendor/Login/ValidarUsuario",
    method: "POST",
    data: {mail: $("#mail").val(), clave: $("#clave").val()}
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
          localStorage.setItem("hora",dato.hora);
          localStorage.setItem("idAdministrador",dato.id);
          window.location.replace("../enlaces/estacionamiento.html");
        },function(){
          swal('Algo inesperado ocurrio');
        });
      }
      else if(dato.status == "200" && dato.tipo == "empleado")
     {
       localStorage.setItem("hora",dato.hora);
       localStorage.setItem("idEmpleado",dato.id);
       swal(
         'USUARIO VÁLIDO!',
         'Usted esta registrado en la base de datos!',
         'success'
       ).then(function(){
         window.location.replace("../enlaces/estacionamientoEmpleado.html");
       },function(){
         swal('Ocurrio algo inesperado!');
       });
     }
  else
  {
     swal('USUARIO INCORRECTO!',
     'Revise su correo electrónico y/o su contraseña',
     'warning').then(function(){
      location.reload();
     });
  }
    },function(dato){
     alert("ERROR"+dato);
    });
}

function Registrarme()
{
  location.reload();
  window.location.replace("../enlaces/registrar.html");
}