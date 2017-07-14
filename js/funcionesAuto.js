
function IngresarAuto()
{
    var funcionAjax = $.ajax({
    //url : "../vendor/index.php/"
    url : '../vendor/Auto/InsertarAuto',
    method : 'POST',
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
    else
    {
      swal("ERROR. el auto no pudo ser ingresado "+dato.status);
    }
}, function (dato)
{
        alert("ERROR. Hubo un error en el ingreso del auto al estacionamiento"+dato);
});
}

function BorrarAuto(id)
{
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
    },function(dato){
       swal("ERROR en la Api "+dato);   
    }); 
});
}

function ModificarAuto(id)
  {
    localStorage.setItem("idAuto",id);
    window.location.replace("../enlaces/modificarAuto.html");
  }

