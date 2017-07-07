window.onload = function(){
    var idAuto = localStorage.getItem("idAuto");
    var funcionAjax = $.ajax({
    method : "GET",
    url : "../vendor/Auto/TraerElAuto/"+idAuto
});
    funcionAjax.then(function(dato){
        console.log(dato);
        document.getElementById("patente").value = dato.patente;
        document.getElementById("marca").value = dato.marca;
        document.getElementById("color").value = dato.color;
    },function(dato){
        alert("ERROR hubo un error en traer al auto "+dato);
    })
}


function HacerModificacion()
{
    var idAuto = localStorage.getItem("idAuto");
    var funcionAjax = $.ajax({
    url : "../vendor/Auto/ModificarElAuto/"+idAuto,
    method : "PUT"
});
   funcionAjax.then(function(dato){
       if(dato.status == 200)
       {
           console.log(dato);
           alert("El auto fue modificado");
           window.location.replace("../enlaces/grillaAutos.html");
       }
       else
       {
           alert("ERROR el auto no pudo ser modificado "+dato.status);
       }
   }, function(dato){
       alert("ERROR. "+dato);
   });
}