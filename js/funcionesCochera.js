function IngresarCochera()
{
    var numero = $("#numero").val();
    var piso = $("#piso").val();
    var prioridad = $('input[name=prioridad]:checked').val();
   var dataEnvio = new FormData("FormIngresoCochera");
   dataEnvio.append("numero",numero);
   dataEnvio.append("piso",piso);
   dataEnvio.append("prioridad",prioridad);
    var funcionAjax = $.ajax({
        url : "../vendor/Cochera/InsertarNuevaCochera",
        data :  dataEnvio,
        method : "POST",
        cache: false,
   contentType: false,
   processData: false
    });
    funcionAjax.then(function(dato){
        if(dato.status == 200)
        {
              swal(
         'INGRESO CORRECTO!',
         'Usted acaba de registrar una cochera!',
         'success'
       ).then(function(){
         window.location.replace("../enlaces/grillaCocheras.html");
       },function(){
         swal('Ocurrio algo inesperado!');
       });
        }
        else
        {
            swal("ERROR. La cochera no pudo ser ingresada!");
        }
    }
    , function(dato){
        alert("ERROR. "+dato);
    });
}

function BorrarCochera(id)
{
     swal({
  title: 'Desea borrar la cochera seleccionada?',
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si, borrar cochera!',
  cancelButtonClass: 'btn btn-danger',
  cancelButtonText: 'No, no borrar cochera!'
}).then(function () {
    var funcionAjax = $.ajax({
         url : "../vendor/Cochera/BorrarLaCochera/"+id,
        method : "DELETE"
        });
    funcionAjax.then(function(dato){
     if(dato.status == 200)
     {
         swal("La cochera fue borrada correctamente!").then(function(){
         location.reload(); });
     }
     else
     {
         swal("ERROR. La cochera no pudo ser borrada");
     }
    },function(dato){
       swal("ERROR "+dato);   
    }); 
});
}

function ModificarCochera(id)
{
    localStorage.setItem("idCocheraModificacion",id);
    window.location.replace("../enlaces/modificarCochera.html");
}
