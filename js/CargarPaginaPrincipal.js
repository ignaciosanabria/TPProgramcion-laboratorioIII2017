window.onload = function(){
    let id = localStorage.getItem("idAdministrador");
    let funcionAjax = $.ajax({
    method : 'GET',
    url : '../vendor/Login/TraerAdministrador/'+id
});
    funcionAjax.then(function(dato){
     document.getElementById("usuario").innerHTML = "<p id='usuario'><span class='glyphicon glyphicon-user'>"+dato.mail+"</span></p>";
    },function(dato){
        console.log("No se pudo cargar el administrador!");
    });

}


function CerrarSesion()
{
    swal({
  title: 'Desea cerrar Sesión?',
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Si, quiero cerrar sesión!',
  cancelButtonClass: 'btn btn-danger',
  cancelButtonText: 'No, no deseo cerrar sesión!'
}).then(function () {
  swal('Usted ha cerrado su sesión!').then(function(){
      localStorage.clear();
      window.location.replace("../enlaces/login.html");
  });
});

}