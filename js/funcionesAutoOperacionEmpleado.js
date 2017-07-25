//CARGO LA GRILLA DE AUTOS PARA EL EMPLEADO
window.onload = function(){
    var funcionAjax = $.ajax({
    method : "GET",
    url : "../vendor/Auto/TraerTodosLosAutos"
});
  funcionAjax.then(function(dato){
     console.log(dato);
     var stringAutos = " ";
     for(var i = 0; i < dato.autos.length; i++)
     {
         stringAutos += "<tr>";
         stringAutos += "<td>"+dato.autos[i].patente+"</td>";
         stringAutos += "<td>"+dato.autos[i].marca+"</td>";
         stringAutos += "<td>"+dato.autos[i].color+"</td>";
         stringAutos += "</tr>";
     }
     document.getElementById("autos").innerHTML = stringAutos;
  },function(dato){
    alert("ERROR no se pudieron cargar los autos"+dato);   
  });
}


// EL EMPLEADO PUEDE INGRESAR OPERACIONES

function IngresarOperacion()
{
    var tokenUsuario = localStorage.getItem("token");
    let idEmpleadoEntrada = localStorage.getItem("idEmpleado");
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
         window.location.replace("../enlaces/estacionamientoEmpleado.html");
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


//EL EMPLEADO PUEDE SACAR AUTOS

function SacarAuto()
{
    var idEmpleadoSalida = localStorage.getItem("idEmpleado");
    var tokenUsuario = localStorage.getItem("token");
    var funcionAjax = $.ajax({
    url : "../vendor/Operacion_Salida/SacarAuto",
    method: 'POST',
    headers : {token : tokenUsuario},
    data: {patente:$("#patente").val(),idEmpleado : idEmpleadoSalida},
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
         window.location.replace("../enlaces/estacionamientoEmpleado.html");
       },function(){
         swal('Ocurrio algo inesperado!');
       });
 }
 else if(dato.status == 400)
 {
      swal("ERROR. no se pudo sacar el auto"+dato.status);
 }
},function (dato)
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

//EL EMPLEADO SOLO PUEDE INGRESAR AUTOS - no puede borrarlo o modificarlos

function IngresarAuto()
{
  var tokenUsuario = localStorage.getItem("token");
    var funcionAjax = $.ajax({
    //url : "../vendor/index.php/"
    url : '../vendor/Auto/InsertarAuto',
    method : 'POST',
    headers : {token : tokenUsuario},
    data : {patente:$("#patente").val(),marca:$("#marca").val(),color:$("#color").val()}
});
  funcionAjax.then(function (dato)
{
    console.log(dato);
    if(dato.status == 200)
    {
      swal(
         'INGRESO CORRECTO!',
         'Usted acaba de registrar un auto!',
         'success'
       ).then(function(){
         window.location.replace("../enlaces/grillaAutosEmpleado.html");
       },function(){
         swal('Ocurrio algo inesperado!');
       });
    }
    else if(dato.status == 400)
    {
      swal("ERROR. el auto no pudo ser ingresado "+dato.status);
    }
    else if(dato.status == 401)
    {
      swal("ERROR. La patente del auto que quiere ingresar ya se encuentra registrada!");
    }
}, function (dato)
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