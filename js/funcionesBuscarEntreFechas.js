function BuscarFechasEntradas()
{
    var tokenUsuario = localStorage.getItem("token");
    var funcionAjax = $.ajax({
     method : 'POST',
     headers : {token : tokenUsuario},
     url : '../vendor/Operacion_Entrada/BuscarOperacionesFechas',
     data : {fecha_desde : $("#de").val(), fecha_hasta : $("#hasta").val() }
    });
    funcionAjax.then(function(dato){
       var stringFechas = " ";
      if(dato.arrayOperacionesFechas.length != 0)
      {
        for(i=0; i < dato.arrayOperacionesFechas.length;i++)
        {
            stringFechas += "<tr>";   
            for(y = 0; y < dato.autos.length; y++)
            {
                if(dato.arrayOperacionesFechas[i].idAuto == dato.autos[y].id)
                {
                 stringFechas += "<td>"+dato.autos[y].patente+"</td>";
                }
            }
            stringFechas += "<td>"+dato.arrayOperacionesFechas[i].fecha_ingreso+"</td>";
            for(a = 0; a < dato.cocheras.length; a++)
            {
                if(dato.arrayOperacionesFechas[i].idCochera == dato.cocheras[a].id)
                {
                    stringFechas += "<td>"+dato.cocheras[a].numero+"</td>";
                }
            }
            for(b = 0; b < dato.empleados.length; b++)
            {
               if(dato.arrayOperacionesFechas[i].idEmpleado == dato.empleados[b].id)
               {
                   stringFechas += "<td>"+dato.empleados[b].nombre+" "+dato.empleados[b].apellido+"</td>";
               }
            }
            stringFechas += "</tr>";
        }
        document.getElementById("operacionesEntrada").innerHTML = stringFechas;
      }
      else
      {
          swal("NO SE ENCONTRO NINGUNA OPERACION ENTRE LAS FECHAS ESTABLECIDAS!");
      }
    },function(dato){
        console.log("ERROR en la API "+dato);
    });
}

function BuscarFechasSalidas()
{
    console.log($("#deFechaSalida").val());
    console.log($("#hastaFechaSalida").val());
    var tokenUsuario = localStorage.getItem("token");
    var funcionAjax = $.ajax({
    method : 'POST',
     headers : {token : tokenUsuario},
     url : '../vendor/Operacion_Salida/BuscarOperacionesFechas',
     data : {fecha_desde : $("#deFechaSalida").val(), fecha_hasta : $("#hastaFechaSalida").val()}
});
    funcionAjax.then(function(dato){
      var stringFechas = " ";
      if(dato.arrayOperacionesFechas.length != 0)
      {
      for(i = 0; i < dato.arrayOperacionesFechas.length; i++)
      {
          stringFechas += "<tr>";
          for(y = 0; y < dato.autos.length; y++)
          {
              if(dato.arrayOperacionesFechas[i].idAuto == dato.autos[y].id)
              {
                  stringFechas += "<td>"+dato.autos[y].patente+"</td>";
              }
          }
          for(z = 0; z < dato.operacionesEntrada.length; z++)
          {
              if(dato.arrayOperacionesFechas[i].idOperacionEntrada == dato.operacionesEntrada[z].id)
              {
                  for(a = 0; a < dato.cocheras.length; a++)
                  {
                      if(dato.cocheras[a].id == dato.operacionesEntrada[z].idCochera)
                      {
                          stringFechas += "<td>"+dato.cocheras[a].numero+"</td>";
                      }
                  }
                  stringFechas += "<td>"+dato.operacionesEntrada[z].fecha_ingreso+"</td>";
              }
          }
          stringFechas += "<td>"+dato.arrayOperacionesFechas[i].fecha_salida+"</td>";
          stringFechas += "<td>"+dato.arrayOperacionesFechas[i].importe+"</td>";
          for(j = 0; j < dato.empleados.length; j++)
          {
              if(dato.arrayOperacionesFechas[i].idEmpleado == dato.empleados[j].id)
              {
                  stringFechas += "<td>"+dato.empleados[j].nombre+" "+dato.empleados[j].apellido+"</td>";
              }
          }
          stringFechas += "</tr>";
      }
      document.getElementById("operacionesSalida").innerHTML = stringFechas;
      }
      else
      {
          swal("NO SE ENCONTRO NINGUNA OPERACIÓN ENTRE LAS FECHAS ESTABLECIDAS!");
      }
    },function(dato){
      console.log("ERROR en la API "+dato);
    });
}


function CalcularImporte()
{
    console.log($("#deFechaSalida").val());
    console.log($("#hastaFechaSalida").val());
    var tokenUsuario = localStorage.getItem("token");
    var funcionAjax = $.ajax({
    method : 'POST',
     headers : {token : tokenUsuario},
     url : '../vendor/Operacion_Salida/CalcularImporte',
     data : {fecha_desde : $("#deFechaSalida").val(), fecha_hasta : $("#hastaFechaSalida").val()}
});
    funcionAjax.then(function(dato){
      var stringFechas = " ";
      if(dato.arrayOperacionesFechas.length != 0)
      {
      for(i = 0; i < dato.arrayOperacionesFechas.length; i++)
      {
          stringFechas += "<tr>";
          for(y = 0; y < dato.autos.length; y++)
          {
              if(dato.arrayOperacionesFechas[i].idAuto == dato.autos[y].id)
              {
                  stringFechas += "<td>"+dato.autos[y].patente+"</td>";
              }
          }
          for(z = 0; z < dato.operacionesEntrada.length; z++)
          {
              if(dato.arrayOperacionesFechas[i].idOperacionEntrada == dato.operacionesEntrada[z].id)
              {
                  for(a = 0; a < dato.cocheras.length; a++)
                  {
                      if(dato.cocheras[a].id == dato.operacionesEntrada[z].idCochera)
                      {
                          stringFechas += "<td>"+dato.cocheras[a].numero+"</td>";
                      }
                  }
                  stringFechas += "<td>"+dato.operacionesEntrada[z].fecha_ingreso+"</td>";
              }
          }
          stringFechas += "<td>"+dato.arrayOperacionesFechas[i].fecha_salida+"</td>";
          stringFechas += "<td>"+dato.arrayOperacionesFechas[i].importe+"</td>";
          for(j = 0; j < dato.empleados.length; j++)
          {
              if(dato.arrayOperacionesFechas[i].idEmpleado == dato.empleados[j].id)
              {
                  stringFechas += "<td>"+dato.empleados[j].nombre+" "+dato.empleados[j].apellido+"</td>";
              }
          }
          stringFechas += "</tr>";
      }
      document.getElementById("operacionesSalida").innerHTML = stringFechas;
      document.getElementById("importeCalculado").innerHTML = "<label>Importe</label><input class='form-control' type=text value="+dato.importe+">";
      }
      else
      {
          swal("NO SE ENCONTRO NINGUNA OPERACIÓN ENTRE LAS FECHAS ESTABLECIDAS!");
      }
    },function(dato){
      console.log("ERROR en la API "+dato);
    });
}