
function IngresarOperacion()
{
    var funcionAjax = $.ajax({
    //url : "../vendor/index.php/"
    url : '../vendor/Operacion/IngresarOperacion',
    method : 'POST',
    data : {idAuto:$("#idAuto").val(),idCochera:$("#idCochera").val(),fecha_ingreso:$("#fecha_ingreso").val(),
    idEmpleado : $("#idEmpleado").val(),prioridad:$('input[name=prioridad]:checked').val()},
});
  funcionAjax.then(function (dato)
{
    console.log(dato);
    if(dato.status == 200 && dato.error == 200)
    {
      console.log(dato);
      alert("La operacion fue ingresada correctamente!");
      window.location.replace("../enlaces/estacionamiento.html");  
    }
    else if(dato.status == 400 && dato.error == 200)
    {
      alert("ERROR interno en el Slim"+400);
    }   
  else 
  {
  if(dato.error == 400 && dato.status == 200);
  {
     alert("ERROR. La opcion de discapacidad no coincide con el tipo de la cochera. Por favor seleccione otra");
  }
  }
}, function (dato)
{
        alert("ERROR. Hubo un error en el ingreso del auto al estacionamiento"+dato);
});
}

//Funcion del enlace sacarAuto.php
function SacarAuto()
{
    var funcionAjax = $.ajax({
    url : "../vendor/Operacion/SacarAuto",
    method: 'POST',
    data: {patente:$("#patente").val()},
    });
    funcionAjax.then(function (dato)
{
 if(dato.status == 200)
 {
     alert("El auto fue sacado del estacionamiento");
     window.location.replace("../enlaces/estacionamiento.html");
 }
 else if(dato.status == 400)
 {
     alert("ERROR. El auto no se encuentra estacionado en el estacionamiento");
 }
},function (dato)
{ 
  alert("ERROR. Hubo un error en sacar al auto"+dato);  
});
}