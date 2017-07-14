window.onload = function(){
    var funcionAjax = $.ajax({
    method : "GET",
    url : "../vendor/Auto/TraerTodosLosAutos"
});
  funcionAjax.then(function(dato){
     console.log(dato);
     var stringAutos = " ";
     for(var i = 0; i < dato.autos.length; i++)
     {
         stringAutos += "<tr>";
         stringAutos += "<td>"+dato.autos[i].patente+"</td>";
         stringAutos += "<td>"+dato.autos[i].marca+"</td>";
         stringAutos += "<td>"+dato.autos[i].color+"</td>";
         stringAutos += "<td><button class='btn btn-danger' onclick='BorrarAuto("+dato.autos[i].id+")'>"+
         "<span class='glyphicon glyphicon-remove'></span>Borrar</button>";
         stringAutos += "<td><button class='btn btn-warning' onclick='ModificarAuto("+dato.autos[i].id+")'>"+
         "<span class='glyphicon glyphicon-edit'></span>Modificar</button>";
         stringAutos += "</tr>";
     }
     document.getElementById("autos").innerHTML = stringAutos;
  },function(dato){
    alert("ERROR no se pudieron cargar los autos"+dato);   
  });
}