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
            alert("La cochera fue ingresada correctamente!");
            window.location.replace("../enlaces/grillaCocheras.html");
        }
        else
        {
            alert("ERROR. La cochera no pudo ser ingresada!");
        }
    }
    , function(dato){
        alert("ERROR. "+dato);
    });
}

function BorrarCochera(id)
{
     let confirmar = confirm("Desea borrar la cochera seleccionada?");
     if(confirmar == true)
     {
         var funcionAjax = $.ajax({
         url : "../vendor/Cochera/BorrarCochera/"+id,
        method : "DELETE"
        });
    funcionAjax.then(function(dato){
     if(dato.status == 200)
     {
         alert("La cochera fue borrada correctamente!");
         location.reload();
     }
     else
     {
         alert("ERROR. La cochera no pudo ser borrada");
     }
    },function(dato){
       alert("ERROR "+dato);   
    });
     }
}

function ModificarCochera(id)
{
    localStorage.setItem("id",id);
    window.location.replace("modificarCochera.html");
}
