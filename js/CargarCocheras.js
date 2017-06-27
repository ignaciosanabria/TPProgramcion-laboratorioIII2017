window.onload = function(){
    let funcionAjax = $.ajax({
    url : "../vendor/TraerTodasLasCocheras",
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
       stringCocheras += "<td>"+dato.cocheras[i].estaLibre+"</td>";
       stringCocheras += "<td>"+dato.cocheras[i].prioridad+"</td>";
       stringCocheras += "<td>"+dato.cocheras[i].vecesDeUso+"</td>";
       stringCocheras += "<td>"+"<button class='btn btn-danger' onclick=BorrarCochera("+dato.cocheras[i].id+")>"+
       "<span class='glyphicon glyphicon-remove'></span>Borrar</td>";
       stringCocheras += "<td>"+"<button class='btn btn-warning' onclick=ModificarCochera("+dato.cocheras[i].id+")>"+
       "<span class='glyphicon glyphicon-edit'></span>Modificar</td>";
       stringCocheras += "</tr>";  
    }
    document.getElementById("cocheras").innerHTML = stringCocheras;
},function(dato){
    alert("ERROR. "+dato);
})
}