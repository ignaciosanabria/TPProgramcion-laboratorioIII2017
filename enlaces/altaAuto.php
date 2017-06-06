<?php
require("../clases/cochera.php");
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link href="../bower_components/bootstrapValidator/dist/css/bootstrapValidator.css" rel="stylesheet">
    <script type="text/javascript" src="../bower_components/moment/min/moment.min.js"></script>
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../bower_components/bootstrapvalidator/dist/js/bootstrapValidator.min.js"></script>
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../estilos/estilos.css">
      <script type="text/javascript" src="../bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="../bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
    <script type="text/javascript" src="../js/funcionesAuto.js">
    </script>
    <script type="text/javascript" src="../js/validadorAutoOperacion.js">
    </script>
        <title>Ingresar Auto</title>
    </head>
    <body>
        <div class="container">
         <div class="page-header">
         <h1>Ingreso de vehículos al Estacionamiento</h1>
         </div><!--Cierre Page Header -->
         
         <div class="CajaInicio animated bounceInRight">
			<h1>Ingrese datos del vehículo con la fecha de ingreso y el numero de cochera</h1>

			<form id="FormIngreso" method="post" enctype="multipart/form-data" action="" >
				<label class="control-label">Patente</label><input type="text" name="patente" id="patente" placeholder="Ingrese patente" />
                <br>
                <label class="control-label">Marca</label><input type="text" name="marca" id="marca" placeholder="Ingrese marca"  />
                <br>
                <label class="control-label">Color</label><input type="text" name="color" id="color" placeholder="Ingrese color" />
                <!-- FALTA HACER SELECT OPTIONS CON COCHERAS PRECARGADAS DESDE DATABASE -->
                <br>
                <label class"control-label">Fecha de Ingreso</label>
                <div class="dateContainer">
              <div class="input-group date" id="datetimePicker">
                <input type="text" class="form-control" name="fecha_ingreso" id="fecha_ingreso" placeholder="YYYY/DD/MM h:m" />
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
               </div>
             </div>

                <br>
                <label class="control-label">Numero de cochera</label>
                <select id="idCochera">
                <option value="0">Seleccionar</option>
                <?php
                 $arrayCocheras = Cochera::TraerTodasLasCocherasLibres();
                 //var_dump($arrayCocheras);
                 foreach($arrayCocheras as $cocheras)
                 {
                   echo '<option value="'.$cocheras->GetId().'">'.$cocheras->GetId().'</option>';								
                 }
                ?>
                <select>
                <br>
                <input type="button" class="btn btn-danger" name="volverAtras" onclick="VolverAtras()" value="Cancelar"/>
                <br>
				<input type="button" class="btn btn-primary" name="guardar" onclick="IngresarAutoOperacion()" value="Ingresar"/>
            </form>
		
		</div>
        </div><!-- Cierre Container-->
    </body>
</html>