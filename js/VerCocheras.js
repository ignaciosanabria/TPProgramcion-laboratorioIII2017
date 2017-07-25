function BuscarMasUtilizada()
{
     var tokenUsuario = localStorage.getItem("token");
    var funcionAjax = $.ajax({
     method : 'POST',
     headers : {token : tokenUsuario},
     url : '../vendor/Cochera/TraerCocheraMasUtilizada',
     data : {fecha_desde : $("#de").val(), fecha_hasta : $("#hasta").val() }
    });
    funcionAjax.then(function(dato){
      var stringCochera = " ";
      if(cocheraMasUtilizada.length != 0)
      {
      for(i = 0; i < dato.cocheras.length; i++)
      {
          stringCochera += "<tr>";
          if(dato.cocheras[i].id == dato.cocheraMasUtilizada)
          {
              stringCochera += "<td>"+dato.cocheras[i].id+"</td>";
              stringCochera += "<td>"+dato.cocheras[i].piso+"</td>";
              stringCochera += "<td>"+dato.cocheras[i].prioridad+"</td>";
              if(dato.cocheras[i].idAuto == null)
              {
               stringCocheras += "<td>"+"ESTA LIBRE"+"</td>";
               }
             else if(dato.cocheras[i].idAuto != null)
           {
             stringCocheras += "<td>"+"ESTA OCUPADO"+"</td>";
           }
          }
      }
      document.getElementById("cocheras").innerHTML = stringCochera;
      }
      else{
       swal("ERROR NO SE ENCONTRO NINGUNA COCHERA!");
      }
    },function(dato){
        console.log("ERROR en la API "+dato);
    });
}

function BuscarMenosUtilizada()
{
var tokenUsuario = localStorage.getItem("token");
    var funcionAjax = $.ajax({
     method : 'POST',
     headers : {token : tokenUsuario},
     url : '../vendor/Cochera/TraerCocheraMenosUtilizada',
     data : {fecha_desde : $("#de").val(), fecha_hasta : $("#hasta").val() }
    });
    funcionAjax.then(function(dato){
      var stringCochera = " ";
      if(cocheraMasUtilizada.length != 0)
      {
      for(i = 0; i < dato.cocheras.length; i++)
      {
          stringCochera += "<tr>";
          if(dato.cocheras[i].id == dato.cocheraMasUtilizada)
          {
              stringCochera += "<td>"+dato.cocheras[i].id+"</td>";
              stringCochera += "<td>"+dato.cocheras[i].piso+"</td>";
              stringCochera += "<td>"+dato.cocheras[i].prioridad+"</td>";
              if(dato.cocheras[i].idAuto == null)
              {
               stringCocheras += "<td>"+"ESTA LIBRE"+"</td>";
               }
             else if(dato.cocheras[i].idAuto != null)
           {
             stringCocheras += "<td>"+"ESTA OCUPADO"+"</td>";
           }
          }
      }
      document.getElementById("cocheras").innerHTML = stringCochera;
      }
      else{
       swal("ERROR NO SE ENCONTRO NINGUNA COCHERA!");
      }
    },function(dato){
        console.log("ERROR en la API "+dato);
    });
}