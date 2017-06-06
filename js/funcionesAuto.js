//Funcion de volverAtras, esta en altaAuto.php y sacarAuto.php
function VolverAtras()
{
    window.location.replace("../enlaces/estacionamiento.html");
}

function IngresarAutoOperacion()
{
    var funcionAjax = $.ajax({
    url : '../enlaces/IngresoAutoOperacion.php',
    method : 'post',
    data : {patente:$("#patente").val(),marca:$("#marca").val(),color:$("#color").val(),idCochera:$("#idCochera").val(),fecha_ingreso:$("#fecha_ingreso").val()},
});
  funcionAjax.then(funcionOkIngreso, funcionErrorIngreso);
}

function funcionOkIngreso(dato)
{
    if(dato == 200)
    {
        alert("El auto fue ingresado correctamente");
        window.location.replace("../enlaces/estacionamiento.html");
    }
}

function funcionErrorIngreso(dato)
{
    if(dato == 400)
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

function funcionSacarOk(dato)
{

}

function funcionSacarError(dato)
{
    
}

function Algo()
{
    alert("patente:"+$("#patente").val()+",marca:"+$("#marca").val()+",color:"+$("#color").val()+",idCochera:"+$("#idCochera").val()+",fecha_ingreso:"+$("#fecha_ingreso").val());
}