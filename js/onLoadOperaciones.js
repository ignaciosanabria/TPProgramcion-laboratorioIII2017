window.onload = function(){
    var funcionAjax = $.ajax({
    url : "../vendor/Operacion/TraerTodasLasOperaciones",
    method : "GET"
    });
    funcionAjax.then(function(dato){
       console.log(dato);
       var tds = " ";
       var lala =  " ";
       for(i=0;i<dato.operaciones.length;i++)
       {
         tds += "<tr>";
         for(let x = 0;x<dato.autos.length;x++)
         {
             if(dato.operaciones[i].idAuto == dato.autos[x].id)
             {
                tds += "<td>"+dato.autos[x].patente+"</td>"+"\n";
             }
         }
         tds += "<td>"+dato.operaciones[i].fecha_ingreso+"</td>"+"\n";
         if(dato.operaciones[i].fecha_salida == "")
         {
             tds += "<td>"+"NO SALIO TODAVÍA"+"</td>"+"\n";
         }
         else
         {
             tds += "<td>"+dato.operaciones[i].fecha_salida+"</td>"+"\n";
         }
         if(dato.operaciones[i].importe == 0)
         {
             tds += "<td>"+"NO SALIO TODAVÍA"+"</td>"+"\n";
         }
         else
         {
            tds += "<td>"+dato.operaciones[i].importe+"</td>";
         }
         for(j=0;j<dato.cocheras.length;j++)
         {
            if(dato.cocheras[j].id == dato.operaciones[i].idCochera)
            {
                tds += "<td>"+dato.cocheras[j].numero+"</td>"+"\n";
            }
         }
         for(k = 0;k<dato.empleados.length;k++)
         {
             if(dato.empleados[k].id == dato.operaciones[i].idEmpleado)
             {
                tds += "<td>"+dato.empleados[k].nombre+"<td>";
             }
         }
         tds += "</tr>";
       }
       document.getElementById("operaciones").innerHTML = tds;
    },function(dato){
        alert("ERROR");
    });
}