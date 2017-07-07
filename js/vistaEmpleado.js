window.onload = function(){
    var funcionAjax = $.ajax({
     url : "../vendor/Empleado/TraerLosEmpleadosCocherasAutos",
     method : "GET"
    });
    funcionAjax.then(function(dato){
        let stringCocheras = " ";
        let stringAutos = " ";
        let optionCero = "<option value=0>Seleccionar</option>";
        console.log(dato);
        var arrayCocheras = dato.cocheras.filter(function(elemento){
          return elemento.estaLibre == 1;
        });
        console.log(arrayCocheras);
        for(let i = 0;i<arrayCocheras.length;i++)
        {
            stringCocheras += "<option value="+arrayCocheras[i].id+">"+arrayCocheras[i].numero+"</option>";
        }
        for(let j = 0;j<dato.autos.length;j++)
        {
           stringAutos += "<option value="+dato.autos[j].id+">"+dato.autos[j].id+"</option>";
        }
        document.getElementById("idCochera").innerHTML = optionCero + stringCocheras;
        document.getElementById("idAuto").innerHTML = optionCero + stringAutos;
    },function(dato){
        alert("ERROR "+dato);
    })
}