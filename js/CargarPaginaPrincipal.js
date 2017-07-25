window.onload = function(){
    let id = localStorage.getItem("idEmpleado");
    let funcionAjax = $.ajax({
    method : 'GET',
    url : '../vendor/Login/TraerEmpleado/'+id
});
    funcionAjax.then(function(dato){
     document.getElementById("usuario").innerHTML = "<p id='usuario'><span class='glyphicon glyphicon-user'>"+dato.nombre+" "+dato.apellido+"</span></p>";
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
      //FALTA AJAX CON SESION - REGISTRAR SU SALIDA
      let id = localStorage.getItem("idEmpleado");
      var funcionAjax = $.ajax({
      method : 'POST',
      url : '../vendor/Login/CerrarSesion',
      data : {idEmpleado : id}
    });
      funcionAjax.then(function(dato){
         if(dato.status == 200)
         {
              swal('Usted ha cerrado su sesión!').then(function(){
                  localStorage.clear();
                  window.location.replace("../enlaces/login.html");
              },function(){
                 swal("OCURRIO ALGO INESPERADO!");
              });
         }
         else if(dato.status == 400)
         {
          swal("Hubo un error al cerrar sesión del usuario!");
         }
      },function(dato){
       console.log("ERROR en la API "+dato);
      });
  });
}