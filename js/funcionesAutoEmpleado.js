function IngresarAutoOperacion()
{
    let id = localStorage.getItem("idEmpleado");
    var funcionAjax = $.ajax({
    //url : "../vendor/index.php/"
    url : '../vendor/IngresarAutoOperacion',
    method : 'POST',
    data : {patente:$("#patente").val(),marca:$("#marca").val(),color:$("#color").val(),idCochera:$("#idCochera").val(),fecha_ingreso:$("#fecha_ingreso").val(),
    idEmpleado : id ,prioridad:$('input[name=prioridad]:checked').val()},
});
  funcionAjax.then(function (dato)
{
    console.log(dato);
    if(dato.status == 200 && dato.error == 200)
    {
      console.log(dato);
      alert("El auto fue ingresado correctamente!");
      window.location.replace("../enlaces/estacionamientoEmpleado.html");  
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




function SacarAuto()
{
    var funcionAjax = $.ajax({
    url : "../vendor/SacarAuto",
    method: 'POST',
    data: {patente:$("#patente").val()},
    });
    funcionAjax.then(function (dato)
{
 if(dato.status == 200)
 {
     alert("El auto fue sacado del estacionamiento");
     window.location.replace("../enlaces/estacionamientoEmpleado.html");
 }
 else if(dato.status == 400)
 {
     alert("ERROR. El auto no se encuentra en el estacionamiento");
 }
},function (dato)
{ 
  alert("ERROR. Hubo un error en sacar al auto"+dato);  
});
}