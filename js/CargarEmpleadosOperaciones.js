window.onload = function(){
    let idEmpleado = localStorage.getItem("idEmpleado");
    console.log(idEmpleado);
    var funcionAjax = $.ajax({
    url : "../vendor/Operacion/TraerTodasLasOperaciones",
    method : "GET"
    });
    funcionAjax.then( function(dato){
      console.log(dato);
      let arrayOperaciones = dato.operaciones.filter(function(elemento){
           return elemento.idEmpleado == idEmpleado;
      });
      console.log(arrayOperaciones);
      let StringOperaciones = " ";
      if(arrayOperaciones.length != 0)
      {
      for(i=0;i<arrayOperaciones.length;i++)
      {
          StringOperaciones += "<tr>";
          StringOperaciones += "<td>"+arrayOperaciones[i].patente+"</td>";
          StringOperaciones += "<td>"+arrayOperaciones[i].fecha_ingreso+"</td>";
          if(arrayOperaciones[i].fecha_salida == null && arrayOperaciones[i].fecha_salida == "")
          {
              StringOperaciones += "<td>"+"NO SALIÓ TODAVÍA"+"</td>";
          }
          else
         {
             StringOperaciones += "<td>"+arrayOperaciones[i].fecha_salida+"</td>";
         }
          if(arrayOperaciones[i].importe != 0)
          {
              StringOperaciones += "<td>"+arrayOperaciones[i].importe+"</td>";
          }
          else
          {
              StringOperaciones += "<td>"+"NO SALIÓ TODAVÍA"+"</td>";
          }
          for(j=0;j<dato.Cocheras.length;j++)
          {
              if(arrayOperaciones[i].idCochera == dato.Cocheras[j].id)
              {
                  StringOperaciones += "<td>"+dato.Cocheras[j].numero+"</td>";
              }
          }
      }
      }
      else
      {
          alert("EL EMPLEADO NO HA REALIZADO OPERACIONES AÚN");
          window.location.replace("../enlaces/grillaEmpleados.html");
      }
      document.getElementById("operacionesEmpleado").innerHTML = StringOperaciones;
    },function(dato){
       alert("ERROR"+dato);
    });        
}