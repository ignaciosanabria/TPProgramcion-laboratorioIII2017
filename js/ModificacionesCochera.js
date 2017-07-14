 window.onload = function() {
     let id = window.localStorage.getItem("idCocheraModificacion");
     let funcionAjax = $.ajax({
     method : "GET",
     url : "../vendor/Cochera/TraerLaCochera/"+id
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
     let id = window.localStorage.getItem("idCocheraModificacion");
     let funcionAjax = $.ajax({
     url : "../vendor/Cochera/ModificarLaCochera/"+id,
     method : "PUT",
     data : {numero:$("#numero").val(),piso:$("#piso").val(),prioridad : $('input[name=prioridad]:checked').val()}
     });
     funcionAjax.then(function(dato){
        if(dato.status == 200)
        {
           swal("La cochera fue modificada correctamente!").then(function(){
            window.location.replace("../enlaces/grillaCocheras.html")},);
        }
        else if(dato.status == 400)
        {
            swal("ERROR. El auto no pudo ser modificado");
        }
        else if(dato.status == 401)
        {
            swal("ERROR. La cochera no se puede modificar porque tiene un auto estacionado");
        }
     },function(dato){
        alert("ERROR"+dato);
     });
 }