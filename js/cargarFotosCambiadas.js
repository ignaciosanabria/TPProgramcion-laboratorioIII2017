window.onload = function(){
    var funcionAjax = $.ajax({
     method : 'GET',
     url : "../vendor/Empleado/MostrarFotosCambiadas"
    });
    funcionAjax.then(function(dato){
    var stringFotos = " ";
    console.log(dato);
    console.log(dato.fotosCambiadas[2]);
    for(i = 0; i < dato.fotosCambiadas.length; i++)
    {
        if(dato.fotosCambiadas[i] != "." && dato.fotosCambiadas[i] != "..")
        {
            stringFotos += "<tr>";
            stringFotos += "<td>"+"<a href= ../fotosEmpleados/FotosCambiadasDeTamanio/"+dato.fotosCambiadas[i]+" download ><img src=../fotosEmpleados/FotosCambiadas/"+dato.fotosCambiadas[i]+" width=150px height=150px></a>"+"</td>";
            stringFotos += "</tr>";
        }
    }
    document.getElementById("imagenes").innerHTML = stringFotos;
    }, function(dato){
        console.log("ERROR en la API"+dato);
    });
}