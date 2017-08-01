window.onload = function(){
    var funcionAjax = $.ajax({
    url : "../vendor/Empleado/TraerTodosLosEmpleados",
    method : "GET"
});
 funcionAjax.then(function(dato){
     console.log(dato);
     let StringEmpleados = " ";
     let arrayCajeros = dato.empleados.filter(function(elemento){
         return elemento.cargo == 2;
     });
     for(let i = 0;i<arrayCajeros.length;i++)
     {
         StringEmpleados += "<tr>";
         StringEmpleados += "<td>"+arrayCajeros[i].legajo+"</td>";
         StringEmpleados += "<td>"+arrayCajeros[i].nombre+" "+arrayCajeros[i].apellido+"</td>";
         StringEmpleados += "<td>"+arrayCajeros[i].mail+"</td>";
         StringEmpleados += "<td>"+arrayCajeros[i].clave+"</td>";
         StringEmpleados += "<td>"+arrayCajeros[i].turno+"</td>";
         StringEmpleados += "<td>"+arrayCajeros[i].habilitado+"</td>";
         StringEmpleados += "<td>"+"<img src=../fotosEmpleados/"+arrayCajeros[i].foto+" width=100px height=100px></td>";
         StringEmpleados += "<td>"+ "<button class='btn btn-danger' onclick=VerEmpleadoOperaciones("+arrayCajeros[i].id+")><span class='glyphicon glyphicon-th-list'></span>Ver Operaciones</button>"+"</td>";
         StringEmpleados += "<td>"+ "<button class='btn btn-danger' onclick=VerEmpleadoSesiones("+arrayCajeros[i].id+")><span class='glyphicon glyphicon-th-list'></span>Ver Fechas de Logueo</button>"+"</td>";
         StringEmpleados += "<td>"+"<button class='btn btn-danger' onclick=BorrarEmpleado("+arrayCajeros[i].id+")><span class='glyphicon glyphicon-remove'></span>Borrar</button>"+"</td>";
         StringEmpleados += "<td>"+"<button class='btn btn-warning' onclick=ModificarEmpleado("+arrayCajeros[i].id+")><span class='glyphicon glyphicon-edit'></span>Modificar</button>"+"</td>";
         StringEmpleados += "</tr>";
     }
     document.getElementById("empleados").innerHTML = StringEmpleados;
 },function(dato){
     alert("ERROR"+dato);
 })
}


function BorrarEmpleado(id)
{
  var tokenUsuario = localStorage.getItem("token");
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
        method : "DELETE",
    headers : {token : tokenUsuario}
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
});
}

function IngresarEmpleado()
{
   var legajo = $("#legajo").val();
   var nombre = $("#nombre").val();
   var mail = $("#mail").val();
   var clave = $("#clave").val();
   var turno = $("#turno").val();
   var tokenUsuario = localStorage.getItem("token");
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
   processData: false,
    headers : {token : tokenUsuario}
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

function ModificarEmpleado(id)
  {
    localStorage.setItem("idEmpleadoModificacion",id);
    window.location.replace("../enlaces/modificarEmpleado.html");
  }

  function VerEmpleadoOperaciones(id)
  {
      localStorage.setItem("idEmpleadoOperacion",id);
      window.location.replace("../enlaces/verOperacionesEmpleado.html");
  }

  function VerEmpleadoSesiones(id)
  {
      localStorage.setItem("idEmpleadoSesion",id);
      window.location.replace("../enlaces/grillaSesiones.html");
  }

