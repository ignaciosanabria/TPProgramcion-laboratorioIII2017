window.onload = function(){
    var funcionAjax = $.ajax({
    url : '../vendor/Usuario/TraerHoraInicio',
    method : "GET"
      });
      funcionAjax.then(funcionOk,funcionError);

  function funcionOk(dato)
  {
      console.log(dato.hora);
      $("#horaLogin").val(dato.hora); 
  }

  function funcionError(dato)
  {
      console.log("HUBO UN ERROR"+dato);
  }
}