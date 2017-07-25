
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
         window.location.replace("../enlaces/grillaAutos.html");
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

function BorrarAuto(id)
{
  var tokenUsuario = localStorage.getItem("token");
    swal({
  title: 'Desea borrar el auto seleccionado?',
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si, borrar auto!',
  cancelButtonClass: 'btn btn-danger',
  cancelButtonText: 'No, no borrar auto!'
}).then(function () {
    var funcionAjax = $.ajax({
         url : "../vendor/Auto/BorrarAuto/"+id,
         headers : {token : tokenUsuario},
        method : "DELETE"
        });
    funcionAjax.then(function(dato){
     if(dato.status == 200)
     {
         swal("El auto fue borrado correctamente!").then(function(){
         location.reload(); });
     }
     else
     {
         swal("ERROR. El auto no pudo ser borrada");
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
});
}

function ModificarAuto(id)
  {
    localStorage.setItem("idAuto",id);
    window.location.replace("../enlaces/modificarAuto.html");
  }

