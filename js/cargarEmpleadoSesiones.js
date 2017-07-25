window.onload = function(){
    var idEmpleadoSesion = localStorage.getItem("idEmpleadoSesion");
    var funcionAjax = $.ajax({
    url : "../vendor/Sesion/TraerTodasLasSesiones",
    method : "GET"
    });
    funcionAjax.then(function(dato){
        var tds = " ";
        console.log(dato);
        var arraySesiones = dato.sesiones.filter(function(elemento){
            return elemento.idEmpleado == idEmpleadoSesion;
        })
        console.log(arraySesiones);
        if(arraySesiones.length != 0)
        {
        for(i = 0; i < arraySesiones.length; i++)
        {
          tds += "<tr>";
          tds += "<td>"+arraySesiones[i].fecha_ingreso+"</td>";
          tds += "<td>"+arraySesiones[i].fecha_salida+"</td>";
          tds += "</tr>";
        }
        document.getElementById("sesionesEmpleados").innerHTML = tds;
        }
        else
        {
            swal("EL EMPLEADO NO SE HA LOGUEADO TODAVÍA!");
        }
    }, function(dato){
       alert("ERROR en la API "+dato);
    });
}