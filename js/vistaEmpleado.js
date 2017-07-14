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
        var arrayCocherasLibres = dato.cocheras.filter(function(elemento){
          return elemento.idAuto == null;
        });
        var arrayCocherasOcupadas = dato.cocheras.filter(function(elemento){
          return elemento.idAuto != null;
        });
        var arrayAutos = dato.autos;
        console.log(arrayCocherasOcupadas);
        console.log(arrayCocherasLibres);
        console.log(arrayAutos);
             for(let i = 0; i < arrayCocherasOcupadas.length; i++)
             {
                 for(let j = 0; j < arrayAutos.length;j++)
                 {
                     if(arrayCocherasOcupadas[i].idAuto == arrayAutos[j].id)
                     {
                         arrayAutos.splice(j,1);
                     }
                 }
             }
        console.log(arrayAutos);
        console.log(arrayCocherasOcupadas);
        console.log(arrayCocherasLibres);
        for(let i = 0;i<arrayCocherasLibres.length;i++)
        {
            stringCocheras += "<option value="+arrayCocherasLibres[i].id+">"+arrayCocherasLibres[i].numero+"</option>";
        }
        for(let j = 0;j<arrayAutos.length;j++)
        {
           stringAutos += "<option value="+arrayAutos[j].id+">"+arrayAutos[j].patente+"</option>";
        }
        document.getElementById("idCochera").innerHTML = optionCero + stringCocheras;
        document.getElementById("idAuto").innerHTML = optionCero + stringAutos;
    },function(dato){
        swal("ERROR "+dato);
    })
}