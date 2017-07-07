window.onload = function(){
    let id = localStorage.getItem("idEmpleado");
    let fecha = localStorage.getItem("hora");
    var funcionAjax = $.ajax({
    url : "../vendor/Empleado/ModificarEmpleadoHora/"+id,
    method : "POST",
    data : {fecha_inicio : fecha}
    });
    funcionAjax.then(function(dato){
      if(dato.status == 200)
      {
          console.log("El empleado se modifico correctamente!");
      }
      else
      {
          console.log("ERROR. No se pudo modificar el empleado");
      }
    },function(dato){
        alert("ERROR "+dato);
    });
}