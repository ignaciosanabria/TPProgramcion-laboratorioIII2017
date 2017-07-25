window.onload = function(){
    let funcionAjax = $.ajax({
    url : "../vendor/Cochera/TraerTodasLasCocheras",
    method : "GET"
});
funcionAjax.then(function(dato){
    console.log(dato);
    let stringCocheras = " ";
    for(let i = 0;i<dato.cocheras.length;i++)
    { 
       stringCocheras += "<tr>";
       stringCocheras += "<td>"+dato.cocheras[i].numero+"</td>";
       stringCocheras += "<td>"+dato.cocheras[i].piso+"</td>";
       for(let j = 0; j < dato.autos.length;j++)
       {
           if(dato.cocheras[i].idAuto == null)
       {
            stringCocheras += "<td>"+"ESTA LIBRE"+"</td>";
            break;
       }
       else if(dato.cocheras[i].idAuto == dato.autos[j].id)
      {
           stringCocheras += "<td>"+"Ocupado por "+dato.autos[j].patente+"</td>";
           break;
      }
       }
      if(dato.cocheras[i].prioridad == "1")
      {
        stringCocheras += "<td>"+"DISCAPACITADO"+"</td>";
      }
      else
      {
           stringCocheras += "<td>"+"SIN PRIORIDAD"+"</td>";
      }
       stringCocheras += "</tr>";  
    }
    document.getElementById("cocheras").innerHTML = stringCocheras;
},function(dato){
    alert("ERROR. "+dato);
})
}