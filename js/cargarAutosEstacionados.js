window.onload = function(){
     var funcionAjax = $.ajax({
     url : "../vendor/Empleado/TraerLosEmpleadosCocherasAutos",
     method : "GET"
    });
    funcionAjax.then(function(dato){
    var OptionCero = "<option value=0>Seleccionar</option>";
    var Patentes = " ";
    var arrayCocherasOcupadas = dato.cocheras.filter(function(elemento){
          return elemento.idAuto != null;
        });
        var arrayAutos = new Array();
     console.log(dato);
     console.log(arrayCocherasOcupadas);
             for(let i = 0; i < arrayCocherasOcupadas.length; i++)
             {
                 for(let j = 0; j < dato.autos.length;j++)
                 {
                     if(arrayCocherasOcupadas[i].idAuto == dato.autos[j].id)
                     {
                         arrayAutos.push(dato.autos[j]);
                     }
                 }
             }
        console.log(arrayAutos);
        for(z = 0; z < arrayAutos.length; z++)
        {
         Patentes += "<option value="+arrayAutos[z].id+">"+arrayAutos[z].patente+"</option>";   
        }
        document.getElementById("patente").innerHTML = OptionCero + Patentes;
    },function(dato){
      alert("ERROR en la API "+dato);
    });
}