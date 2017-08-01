window.onload = function(){
    var funcionAjax = $.ajax({
     method : 'GET',
     url : "../vendor/Empleado/MostrarFotosMarcadas"
    });
    funcionAjax.then(function(dato){
    var stringFotos = " ";
    console.log(dato);
    console.log(dato.fotosMarcadas[2]);
    for(i = 0; i < dato.fotosMarcadas.length; i++)
    {
        if(dato.fotosMarcadas[i] != "." && dato.fotosMarcadas[i] != "..")
        {
            stringFotos += "<tr>";
            stringFotos += "<td>"+"<a href= ../fotosEmpleados/FotosMarcadas/"+dato.fotosMarcadas[i]+" download ><img src=../fotosEmpleados/FotosMarcadas/"+dato.fotosMarcadas[i]+" width=150px height=150px></a>"+"</td>";
            stringFotos += "</tr>";
        }
    }
    document.getElementById("imagenes").innerHTML = stringFotos;
    }, function(dato){
        console.log("ERROR en la API"+dato);
    });
}