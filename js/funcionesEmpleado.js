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
         StringEmpleados += "<td>"+dato.empleados[i].clave+"</td>";
         StringEmpleados += "<td>"+dato.empleados[i].cantidadOperaciones+"</td>";
         if(dato.empleados[i].fecha_ingreso != "" && dato.empleados[i].fecha_ingreso != null)
         {
           StringEmpleados += "<td>"+dato.empleados[i].fecha_ingreso+"</td>";  
         }
         else
         {
           StringEmpleados += "<td>"+"NO INGRESO TODAVÍA"+"</td>";
         }
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
    var confirmar = confirm("Desea borrar el empleado seleccionado?");
    if(confirmar == true)
      {
          console.log(id);
           var funcionAjax = $.ajax({
    url : '../vendor/Empleado/BorrarElEmpleado/'+id,
    method : 'DELETE'
    });
    funcionAjax.then(function (dato){
     if(dato.status == 200)
    {
    alert("El empleado fue borrado correctamente");  
    location.reload();   
    }
    else
    {
        alert("ERROR. El empleado no pudo ser borrado!");
    }
    }
    ,function(dato){
        alert("ERROR "+dato);
    });
      }
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
        alert("El empleado "+dato.nombre+" fue ingresado correctamente");
        window.location.replace("../enlaces/grillaEmpleados.html");
    }
    else if(dato.status == 400)
    {
        alert("ERROR. El empleado no pudo ser ingresado");
    }
}, function (dato)
{
   alert("ERROR "+dato);
});
}

function ModificarEmpleado(id)
  {
    localStorage.setItem("id",id);
    window.location.replace("../enlaces/modificarEmpleado.html");
  }

  function VerEmpleadoOperaciones(id)
  {
      localStorage.setItem("idEmpleado",id);
      window.location.replace("../enlaces/verOperacionesEmpleado.html");
  }

