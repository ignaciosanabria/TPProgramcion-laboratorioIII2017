 window.onload = function() {
     let id = window.localStorage.getItem("id");
     let funcionAjax = $.ajax({
     method : "GET",
     url : "../vendor/TraerElEmpleado/"+id
    });
    funcionAjax.then(function(dato){
        console.log(dato);
        document.getElementById("nombre").value = dato.nombre;
        document.getElementById("mail").value = dato.mail;
        document.getElementById("clave").value = dato.clave;
        document.getElementById("legajo").value = dato.legajo;
    },
    function(dato){
    alert("ERROR al traer el empleado."+dato);
    });
 }



  function HacerModificacion()
  {
    let id = window.localStorage.getItem("id");
       let funcionAjax = $.ajax({
      url : '../vendor/ModificarElEmpleado/'+id,
     data : {nombre:$("#nombre").val(),mail:$("#mail").val(),clave:$("#clave").val(),legajo:$("#legajo").val()},
     contentType : "application/x-www-form-urlencoded",
     method : "PUT"
      });
      funcionAjax.then(function(dato)
  {
    if(dato.status == 200)
    {
        alert("El empleado fue correctamente modificado");
        window.location.replace("grillaEmpleados.html");
    }
    else
    {
        alert("ERROR. El empleado no pudo ser modificado");
    }

  }, function(dato) {
     alert("ERROR "+dato.status);
     });
  }