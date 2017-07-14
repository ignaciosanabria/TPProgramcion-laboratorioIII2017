function RegistrarAdministrador()
{
    if($("#clave").val() == $("#repetirClave").val())
    {
    var funcionAjax = $.ajax({
    method : "POST",
    url : "../vendor/Login/RegistrarAdministrador",
    data: {nombre:$("#nombre").val(),mail:$("#mail").val(),clave:$("#clave").val()}
});
     funcionAjax.then(function(dato){
           if(dato.status == 200)
           {
               swal(
                  'USUARIO REGISTRADO',
                  'Su usuario fue registrado correctamente en la base de datos!',
                  'success'
               ).then(function(){
                   window.location.replace("../enlaces/login.html");
               },function(){
                   swal("Ocurrio algo inesperado!");
               });
           }
           else
           {
               swal("No se pudo registrar el usuario "+dato.status);
           }
     },function(dato){
         swal("ERROR. Hubo un problema con registrar el administrador "+dato);
     });
    }
    else
    {
        swal('ERROR EN LAS CLAVES!',
        'Las claves no coinciden!',
        'error'
        ).then(function(){
           location.reload();
        },function(){
            swal('sucedio algo inesperado!')
        });
    }
}