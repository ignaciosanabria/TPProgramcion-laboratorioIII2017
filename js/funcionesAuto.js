//Funcion de volverAtras, esta en altaAuto.php y sacarAuto.php
function VolverAtras()
{
    window.location.replace("../enlaces/estacionamiento.html");
}

function IngresarAutoOperacion()
{
    var funcionAjax = $.ajax({
    method : 'POST',
    data : {patente:$("#patente").val(),marca:$("#marca").val(),color:$("#color"),idCochera:$("#idCochera").val(),fecha_ingreso:$("#fecha_ingreso").val()},
    url : "../vendor/index.php/IngresarAutoOperacion"
});
  funcionAjax.then(funcionOkIngreso, funcionErrorIngreso);
}

function funcionOkIngreso()
{
    if(dato.status == 200)
    {
        alert("El auto fue ingresado correctamente");
        window.location.replace("../enlaces/estacionamiento.html");
    }
}

function funcionErrorIngreso()
{
    if(dato.status == 400)
    {
        alert("ERROR. Hubo un error en el ingreso del auto al estacionamiento");
    }
}

//Funcion del enlace sacarAuto.php
function SacarAuto()
{
    var funcionAjax = $.ajax({
    method: 'POST',
    data: {patente:$("#patente").val(),fecha_salida:$("#fecha_salida")},
    url : "../vendor/index.php/"
    });
    funcionAjax.then(funcionSacarOk,funcionSacarError);
}