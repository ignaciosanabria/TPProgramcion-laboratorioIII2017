 window.onload = function() {
     let id = window.localStorage.getItem("id");
     let funcionAjax = $.ajax({
     method : "GET",
     url : "../vendor/TraerLaCochera/"+id
    });
    funcionAjax.then(function(dato){
        console.log(dato);
        document.getElementById("numero").value = dato.numero;
        document.getElementById("piso").selectedIndex = dato.piso;
        if(dato.prioridad == 0)
        {
            document.getElementById("sinPrioridad").checked = true;
        }
        else if(dato.prioridad == 1)
        {
            document.getElementById("conPrioridad").checked = true;
        }
    },
    function(dato){
    alert("ERROR al traer el empleado."+dato);
    });
 }


 function HacerModificacion()
 {
     let id = window.localStorage.getItem("id");
     let funcionAjax = $.ajax({
     url : "../vendor/ModificarLaCochera/"+id,
     method : "PUT",
     contentType : "application/x-www-form-urlencoded",
     data : {numero:$("#numero").val(),piso:$("#piso").val(),prioridad : $('input[name=prioridad]:checked').val()}
     });
     funcionAjax.then(function(dato){
        if(dato.status == 200)
        {
            alert("La cochera fue modificada correctamente!");
            window.location.replace("../enlaces/grillaCocheras.html");
        }
        else if(dato.status == 400)
        {
            alert("ERROR. El auto no pudo ser modificado");
        }
     },function(dato){
        alert("ERROR"+dato);
     });
 }