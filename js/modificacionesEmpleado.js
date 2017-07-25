 window.onload = function() {
     let idEmpleado = window.localStorage.getItem("idEmpleadoModificacion");
     let funcionAjax = $.ajax({
     method : "GET",
     url : "../vendor/Empleado/TraerElEmpleado/"+idEmpleado
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
      var tokenUsuario = localStorage.getItem("token");
       let funcionAjax = $.ajax({
      url : '../vendor/Empleado/ModificarElEmpleado/'+id,
     data : {nombre:$("#nombre").val(),mail:$("#mail").val(),clave:$("#clave").val(),legajo:$("#legajo").val(),turno:$("#turno").val()},
     method : "PUT",
    headers : {token : tokenUsuario}
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