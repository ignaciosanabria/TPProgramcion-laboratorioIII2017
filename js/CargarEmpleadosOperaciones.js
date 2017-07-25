window.onload = function(){
    let idEmpleadoOperacion = localStorage.getItem("idEmpleadoOperacion");
    console.log(idEmpleadoOperacion);
    var funcionAjax = $.ajax({
    url : "../vendor/Operacion_Entrada/TraerTodasLasOperacionesEntrada",
    method : "GET"
    });
    funcionAjax.then( function(dato){
      console.log(dato);
      let arrayOperacionesEntrada = dato.operacionesEntrada.filter(function(elemento){
           return elemento.idEmpleado == idEmpleadoOperacion;
      });
      console.log(arrayOperacionesEntrada);
      let StringOperaciones = " ";
      if(arrayOperacionesEntrada.length != 0)
      {
      for(i=0;i<arrayOperacionesEntrada.length;i++)
      {
          StringOperaciones += "<tr>";
          for(x=0;x < dato.autos.length;x++)
          {
              if(arrayOperacionesEntrada[i].idAuto == dato.autos[x].id)
              {
                  StringOperaciones += "<td>"+dato.autos[x].patente+"</td>";
              }
          }
          StringOperaciones += "<td>"+arrayOperacionesEntrada[i].fecha_ingreso+"</td>";
          for(j=0;j<dato.cocheras.length;j++)
          {
              if(arrayOperacionesEntrada[i].idCochera == dato.cocheras[j].id)
              {
                  StringOperaciones += "<td>"+dato.cocheras[j].numero+"</td>";
              }
          }
          StringOperaciones += "</tr>";
      }
      document.getElementById("operacionesEntradaEmpleado").innerHTML = StringOperaciones;
      }
      else
      {
          swal("EL EMPLEADO NO HA REALIZADO OPERACIONES DE ENTRADA AÚN");
      }
    },function(dato){
       alert("ERROR en la api "+dato);
    });

    var funcionAjax2 = $.ajax({
    url : "../vendor/Operacion_Salida/TraerTodasLasOperaciones",
    method : "GET"
});
    funcionAjax2.then(function(dato){
    console.log(dato);
    console.log(dato.cocheras);
   //VISTA DE OPERACIONES SALIDA DEL EMPLEADO ID
    console.log(idEmpleadoOperacion);
     let stringOperacionesSalida = " ";
     let arrayOperacionesSalida = dato.operacionesSalida.filter(function(elemento){
           return elemento.idEmpleado == idEmpleadoOperacion;
      });
    if(arrayOperacionesSalida.length != 0)
    {
      stringOperacionesSalida += "<tr>";
      for(y = 0; y < arrayOperacionesSalida.length; y++)
      {
       for(x=0; x < dato.autos.length;x++)
          {
              if(arrayOperacionesSalida[y].idAuto == dato.autos[x].id)
              {
                  stringOperacionesSalida += "<td>"+dato.autos[x].patente+"</td>";
              }
          }

        for(d = 0; d < dato.operacionesEntrada.length; d++)
        {
          if(arrayOperacionesSalida[y].idOperacionEntrada == dato.operacionesEntrada[d].id)
          {
              for(e = 0; e < dato.cocheras.length; e++)
              {
                  if(dato.operacionesEntrada[d].idCochera == dato.cocheras[e].id)
                  {
                      stringOperacionesSalida += "<td>"+dato.cocheras[e].numero+"</td>";
                  }
              }
          }
        }

        for(f = 0; f < dato.operacionesEntrada.length; f++)
        {
            if(arrayOperacionesSalida[y].idOperacionEntrada == dato.operacionesEntrada[f].id)
            {
                stringOperacionesSalida += "<td>"+dato.operacionesEntrada[f].fecha_ingreso+"</td>";
            }
        }
        stringOperacionesSalida += "<td>"+arrayOperacionesSalida[y].fecha_salida+"</td>";
        stringOperacionesSalida += "<td>"+"$"+arrayOperacionesSalida[y].importe+"</td>";
        stringOperacionesSalida += "</tr>";
      }
    }
    else
    {
         swal("EL EMPLEADO NO HA REALIZADO OPERACIONES DE SALIDA AÚN");
    }
    document.getElementById("operacionesSalidaEmpleado").innerHTML = stringOperacionesSalida;
    },function(dato){
      alert("ERROR en la api"+dato);
    })

}