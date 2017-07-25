window.onload = function(){
    var funcionAjax = $.ajax({
    url : "../vendor/Operacion_Salida/TraerTodasLasOperacionesFinalizadas",
    method : "GET"
});
    funcionAjax.then(function(dato){
    console.log(dato);
    var tds = " ";
    for(i = 0; i < dato.operacionesSalida.length;i++)
    {
      tds += "</tr>";
      for(k= 0; k < dato.autos.length; k++)
      {
       if(dato.operacionesSalida[i].idAuto == dato.autos[k].id)
              {
                  tds += "<td>"+dato.autos[k].patente+"</td>";
                  break;
              }
      }

      for(m = 0; m < dato.operacionesEntrada.length; m++)
      {
      if(dato.operacionesEntrada[m].id == dato.operacionesSalida[i].idOperacionEntrada)
          {
              tds += "<td>"+dato.operacionesEntrada[m].fecha_ingreso+"</td>";
              for(z = 0; z < dato.cocheras.length; z++)
          {
              if(dato.operacionesEntrada[m].idCochera == dato.cocheras[z].id)
              {
                  tds += "<td>"+dato.cocheras[z].numero+"</td>";
                  break;
              }
          }
          }
      }
      tds += "<td>"+dato.operacionesSalida[i].fecha_salida+"</td>";
      tds += "<td>"+dato.operacionesSalida[i].importe+"</td>";
      for(r = 0; r < dato.empleados.length; r++)
      {
          if(dato.empleados[r].id == dato.operacionesSalida[i].idEmpleado)
          {
              tds += "<td>"+dato.empleados[r].nombre+" "+dato.empleados[r].apellido+"</td>";
          }
      }
      tds += "</tr>";
   }
   document.getElementById("operacionesSalida").innerHTML = tds;
    },function(dato){
        console.log("ERROR. no se pudieron cargar las operaciones finalizadas "+dato);
    });
}