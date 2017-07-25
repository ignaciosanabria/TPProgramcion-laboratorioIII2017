//EL ADMINISTRADOR PUEDE ESTACIONAR AUTOS - INGRESAR OPERACIONES
function IngresarOperacion()
{
    let idEmpleadoEntrada = localStorage.getItem("idEmpleado");
    var tokenUsuario = localStorage.getItem("token");
    var funcionAjax = $.ajax({
    //url : "../vendor/index.php/"
    url : '../vendor/Operacion_Entrada/IngresarOperacion',
    method : 'POST',
    headers : {token : tokenUsuario},
    data : {idAuto:$("#idAuto").val(),idCochera:$("#idCochera").val(),fecha_ingreso:$("#fecha_ingreso").val(),
    idEmpleado : idEmpleadoEntrada},
});
  funcionAjax.then(function(dato)
{
    console.log(dato);
    if(dato.status == 200)
    {
      console.log(dato);
       swal(
         'INGRESO CORRECTO!',
         'Usted acaba de registrar una operacion!',
         'success'
       ).then(function(){
         window.location.replace("../enlaces/estacionamiento.html");
       },function(){
         swal('Ocurrio algo inesperado!');
       });
    }
    else if(dato.status == 400 )
    {
      swal("ERROR. no se pudo ingresar la operacion"+dato.status);
    }   
},function(dato)
{
        
        swal("ERROR. Su tiempo de sesión se ha acabado!").then(function(){
        let id = localStorage.getItem("idEmpleado");
        var funcionAjax = $.ajax({
        method : 'POST',
        url : '../vendor/Login/CerrarSesion',
        data : {idEmpleado : id}
      });
       funcionAjax.then(function(dato){
         if(dato.status == 200)
         {
            localStorage.clear();
            window.location.replace("../enlaces/login.html");
         }
         else if(dato.status == 400)
         {
          swal("Hubo un error al cerrar sesión del usuario!");
         }
      },function(dato){
       console.log("ERROR en la API "+dato);
       });
        });
});
}


//EL ADMINISTRADOR PUEDE SACAR AUTOS

function SacarAuto()
{
    var idEmpleadoSalida = localStorage.getItem("idEmpleado");
    var tokenUsuario = localStorage.getItem("token");
    var funcionAjax = $.ajax({
    url : "../vendor/Operacion_Salida/SacarAuto",
    method: 'POST',
    data: {patente:$("#patente").val(),idEmpleado : idEmpleadoSalida},
   headers : {token : tokenUsuario}
    });
    funcionAjax.then(function (dato)
{
 if(dato.status == 200)
 {
     swal(
         'SACADO CORRECTO!',
         'Usted acaba de sacar un auto!',
         'success'
       ).then(function(){
         window.location.replace("../enlaces/estacionamiento.html");
       },function(){
         swal('Ocurrio algo inesperado!');
       });
 }
 else if(dato.status == 400)
 {
      swal("ERROR. no se pudo sacar el auto"+dato.status);
 }
},function(dato)
{
        
        swal("ERROR. Su tiempo de sesión se ha acabado!").then(function(){
        let id = localStorage.getItem("idEmpleado");
        var funcionAjax = $.ajax({
        method : 'POST',
        url : '../vendor/Login/CerrarSesion',
        data : {idEmpleado : id}
      });
       funcionAjax.then(function(dato){
         if(dato.status == 200)
         {
            localStorage.clear();
            window.location.replace("../enlaces/login.html");
         }
         else if(dato.status == 400)
         {
          swal("Hubo un error al cerrar sesión del usuario!");
         }
      },function(dato){
       console.log("ERROR en la API "+dato);
       });
        });
});
}