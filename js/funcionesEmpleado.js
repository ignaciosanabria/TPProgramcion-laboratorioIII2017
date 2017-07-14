window.onload = function(){
    var funcionAjax = $.ajax({
    url : "../vendor/Empleado/TraerTodosLosEmpleados",
    method : "GET"
});
 funcionAjax.then(function(dato){
     console.log(dato);
     let StringEmpleados = " ";
     for(let i = 0;i<dato.empleados.length;i++)
     {
         StringEmpleados += "<tr>";
         StringEmpleados += "<td>"+dato.empleados[i].legajo+"</td>";
         StringEmpleados += "<td>"+dato.empleados[i].nombre+"</td>";
         StringEmpleados += "<td>"+dato.empleados[i].mail+"</td>";
         let clave = dato.empleados[i].clave.replace(dato.empleados[i].clave,"****");
         StringEmpleados += "<td>"+clave+"</td>";
         StringEmpleados += "<td>"+dato.empleados[i].turno+"</td>";
         StringEmpleados += "<td>"+ "<button class='btn btn-danger' onclick=VerEmpleadoOperaciones("+dato.empleados[i].id+")><span class='glyphicon glyphicon-th-list'></span>Ver Operaciones</button>"+"</td>";
         StringEmpleados += "<td>"+"<button class='btn btn-danger' onclick=BorrarEmpleado("+dato.empleados[i].id+")><span class='glyphicon glyphicon-remove'></span>Borrar</button>"+"</td>";
         StringEmpleados += "<td>"+"<button class='btn btn-warning' onclick=ModificarEmpleado("+dato.empleados[i].id+")><span class='glyphicon glyphicon-edit'></span>Modificar</button>"+"</td>";
         StringEmpleados += "</tr>";
     }
     document.getElementById("empleados").innerHTML = StringEmpleados;
 },function(dato){
     alert("ERROR"+dato);
 })
}


function BorrarEmpleado(id)
{
    swal({
  title: 'Desea borrar el empleado seleccionado?',
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si, borrar empleado!',
  cancelButtonClass: 'btn btn-danger',
  cancelButtonText: 'No, no borrar empleado!'
}).then(function () {
    var funcionAjax = $.ajax({
         url : "../vendor/Empleado/BorrarElEmpleado/"+id,
        method : "DELETE"
        });
    funcionAjax.then(function(dato){
     if(dato.status == 200)
     {
         swal("El empleado fue borrado correctamente!").then(function(){
         location.reload(); });
     }
     else
     {
         swal("ERROR. El empleado no pudo ser borrada");
     }
    },function(dato){
       swal("ERROR en la Api "+dato);   
    }); 
});
}

function IngresarEmpleado()
{
   var legajo = $("#legajo").val();
   var nombre = $("#nombre").val();
   var mail = $("#mail").val();
   var clave = $("#clave").val();
   var turno = $("#turno").val();
   var dataEnvio = new FormData("FormIngresoEmpleado");
   dataEnvio.append("legajo",legajo);
   dataEnvio.append("nombre",nombre);
   dataEnvio.append("mail",mail);
   dataEnvio.append("clave",clave);
   dataEnvio.append("turno",turno);
   var funcionAjax = $.ajax({
   url : "../vendor/Empleado/IngresarEmpleado",
   data : dataEnvio,
   method : "POST",
   cache: false,
   contentType: false,
   processData: false
});
funcionAjax.then(function (dato)
{
    
    if(dato.status == 200)
    {
        swal("El empleado "+dato.nombre+" fue ingresado correctamente").then(function(){
        window.location.replace("../enlaces/grillaEmpleados.html");},
        function(){
        swal("ocurrio algo inesperado");});
    }
    else if(dato.status == 400)
    {
        swal("ERROR. El empleado no pudo ser ingresado");
    }
}, function (dato)
{
   swal("ERROR "+dato);
});
}

function ModificarEmpleado(id)
  {
    localStorage.setItem("idEmpleadoModificacion",id);
    window.location.replace("../enlaces/modificarEmpleado.html");
  }

  function VerEmpleadoOperaciones(id)
  {
      localStorage.setItem("idEmpleado",id);
      window.location.replace("../enlaces/verOperacionesEmpleado.html");
  }

