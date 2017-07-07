window.onload = function() {
    let funcionAjax = $.ajax({
    url : "../vendor/Empleado/TraerLosEmpleadosCocherasAutos",
    method : "GET"
});
 funcionAjax.then(function (dato){
 console.log(dato);
 let cocherasLibres = dato.cocheras.filter(function(elementos){
     return elementos.estaLibre == 1;
 });
 let OptionSeleccionar = "<option value= 0>Seleccionar</option>";
 let stringEmpleados = " ";
 let stringCocheras = " ";
 let stringAutos = " ";
 for(let i = 0;i<cocherasLibres.length;i++)
 {
     stringCocheras += "<option value="+cocherasLibres[i].id+">"+cocherasLibres[i].numero+"</option>";
 }
 for(let j=0;j<dato.empleados.length;j++)
 {
     stringEmpleados += "<option value="+dato.empleados[j].id+">"+dato.empleados[j].nombre+"</option>";
 }
 for(let x = 0; x<dato.autos.length;x++)
 {
     stringAutos += "<option value="+dato.autos[x].id+">"+dato.autos[x].id+"</option>";
 }
 document.getElementById("idCochera").innerHTML = OptionSeleccionar + stringCocheras;
 document.getElementById("idEmpleado").innerHTML = OptionSeleccionar + stringEmpleados;
 document.getElementById("idAuto").innerHTML = OptionSeleccionar + stringAutos;
},function(dato){
    alert("ERROR. "+dato);
})
}