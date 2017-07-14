 window.onload = function() {
     let id = window.localStorage.getItem("idEmpleadoModificacion");
     let funcionAjax = $.ajax({
     method : "GET",
     url : "../vendor/Empleado/TraerElEmpleado/"+id
    });
    funcionAjax.then(function(dato){
        console.log(dato);
        document.getElementById("nombre").value = dato.nombre;
        document.getElementById("mail").value = dato.mail;
        document.getElementById("clave").value = dato.clave;
        document.getElementById("legajo").value = dato.legajo;
        document.getElementById("turno").value = dato.turno;
    },
    function(dato){
    alert("ERROR al traer el empleado."+dato);
    });
 }



  function HacerModificacion()
  {
      let id = window.localStorage.getItem("idEmpleadoModificacion");
       let funcionAjax = $.ajax({
      url : '../vendor/Empleado/ModificarElEmpleado/'+id,
     data : {nombre:$("#nombre").val(),mail:$("#mail").val(),clave:$("#clave").val(),legajo:$("#legajo").val(),turno:$("#turno").val()},
     method : "PUT"
      });
      funcionAjax.then(function(dato)
  {
    console.log(dato);
    if(dato.status == 200)
    {
        swal("El empleado fue modificado").then(function(){
                window.location.replace("../enlaces/grillaEmpleados.html");
           },function(){
               swal("Sucedio algo inesperado!");
           });
    }
    else
    {
       swal("ERROR. El empleado no pudo ser modificado");
    }

  }, function(dato) {
     swal("ERROR en la API"+dato.status);
     });
}