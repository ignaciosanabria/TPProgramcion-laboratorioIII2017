window.onload = function(){
var funcionAjax = $.ajax({
    url : "../vendor/Operacion_Salida/TraerTodasLasOperaciones",
    method : "GET"
});
funcionAjax.then(function(dato){
  console.log(dato);
  var stringOperacionesEntrada = " ";
  var stringOperacionesSalida = " ";
  // FOR CON OPERACIONES ENTRADA
  for(i = 0; i < dato.operacionesEntrada.length; i++)
  {
    stringOperacionesEntrada += "<tr>";
    for(a = 0; a < dato.autos.length; a++)
    {
        if(dato.operacionesEntrada[i].idAuto == dato.autos[a].id)
        {
            stringOperacionesEntrada += "<td>"+dato.autos[a].patente+"</td>";
        }
    }
    stringOperacionesEntrada += "<td>"+dato.operacionesEntrada[i].fecha_ingreso+"</td>";
    for(q = 0; q < dato.cocheras.length; q++)
    {
        if(dato.operacionesEntrada[i].idCochera == dato.cocheras[q].id)
        {
            stringOperacionesEntrada += "<td>"+dato.cocheras[q].numero+"</td>";
        }
    }
     for(w = 0; w < dato.empleados.length; w++)
     {
        if(dato.operacionesEntrada[i].idEmpleado == dato.empleados[w].id)
        {
            stringOperacionesEntrada += "<td>"+dato.empleados[w].nombre+" "+dato.empleados[w].apellido+"</td>";
        }
     }
     stringOperacionesEntrada += "</tr>";
   }
   // FOR CON OPERACIONES SALIDA

   for(y = 0; y < dato.operacionesSalida.length ; y++)
   {
       stringOperacionesSalida += "<tr>";
       for(s = 0; s < dato.autos.length; s++)
       {
           if(dato.operacionesSalida[y].idAuto == dato.autos[s].id)
           {
             stringOperacionesSalida += "<td>"+dato.autos[s].patente+"</td>";
           }
       }
       for(b = 0; b < dato.operacionesEntrada.length; b++)
       {
           if(dato.operacionesEntrada[b].id == dato.operacionesSalida[y].idOperacionEntrada)
           {
               for(r = 0; r < dato.cocheras.length; r++)
               {
                   if(dato.operacionesEntrada[b].idCochera == dato.cocheras[r].id)
                   {
                       stringOperacionesSalida += "<td>"+dato.cocheras[r].numero+"</td>";
                   }
               }
               stringOperacionesSalida += "<td>"+dato.operacionesEntrada[b].fecha_ingreso+"</td>";
           }
       }
       stringOperacionesSalida += "<td>"+dato.operacionesSalida[y].fecha_salida+"</td>";
       stringOperacionesSalida += "<td>"+"$"+dato.operacionesSalida[y].importe+"</td>";
       for(p = 0; p < dato.empleados.length; p++)
       {
           if(dato.operacionesSalida[y].idEmpleado == dato.empleados[p].id)
           {
               stringOperacionesSalida += "<td>"+dato.empleados[p].nombre+" "+dato.empleados[p].apellido+"</td>";
           }
       }
       stringOperacionesSalida += "</tr>";
   }
   document.getElementById("operacionesEntrada").innerHTML = stringOperacionesEntrada;
   document.getElementById("operacionesSalida").innerHTML = stringOperacionesSalida;
},function(dato){
  alert("ERROR al cargar las operaciones "+dato);
});

}