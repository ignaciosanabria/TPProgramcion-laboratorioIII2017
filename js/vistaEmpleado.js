window.onload = function(){
    var funcionAjax = $.ajax({
     url : "../vendor/TraerTodasLasCocheras",
     method : "GET"
    });
    funcionAjax.then(function(dato){
        let stringCocheras = " ";
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
        document.getElementById("idCochera").innerHTML = optionCero + stringCocheras;
    },function(dato){
        alert("ERROR "+dato);
    })
}