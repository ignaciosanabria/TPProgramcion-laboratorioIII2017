window.onload = function(){
    var funcionAjax = $.ajax({
    url : "../vendor/Operacion_Salida/TraerTodasLasOperacionesNoFinalizadas",
    method : "GET"
    });
    funcionAjax.then(function(dato){
       console.log(dato);
       var tds = " ";
       for(i=0;i<dato.operacionesNoFinalizadas.length;i++)
       {
         tds += "<tr>";
            for(a = 0; a < dato.autos.length; a++)
            {
                if(dato.autos[a].id == dato.operacionesNoFinalizadas[i].idAuto)
                {
                    tds += "<td>"+dato.autos[a].patente+"</td>";
                }
            }
            for(y=0;y<dato.operacionesEntrada.length;y++)
            {
                if(dato.operacionesNoFinalizadas[i].idOperacionEntrada == dato.operacionesEntrada[y].id)
                {
                  tds += "<td>"+dato.operacionesEntrada[y].fecha_ingreso+"</td>";
                  for(z = 0; z < dato.cocheras.length; z++)
                  {
                      if(dato.operacionesEntrada[y].idCochera == dato.cocheras[z].id)
                      {
                          tds += "<td>"+dato.cocheras[z].numero+"</td>";
                      }
                  }
                  for(k = 0; k < dato.empleados.length; k++)
                  {
                      if(dato.operacionesEntrada[y].idEmpleado == dato.empleados[k].id)
                      {
                          tds += "<td>"+dato.empleados[k].nombre+"</td>";
                      }
                  }
                }
            }
            tds += "</tr>";
       }
       document.getElementById("operacionesEntrada").innerHTML = tds;
    },function(dato){
        alert("ERROR");
    });
}