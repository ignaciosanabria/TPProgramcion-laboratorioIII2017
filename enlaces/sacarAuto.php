<?php
require("../clases/operacion.php");
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link href="../bower_components/bootstrapValidator/dist/css/bootstrapValidator.css" rel="stylesheet">
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../bower_components/bootstrapvalidator/dist/js/bootstrapValidator.min.js"></script>
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../estilos/estilos.css">
    <script type="text/javascript" src="../js/funcionesAuto.js">
    </script>
    <script type="text/javascript" src="../js/validadorSacar.js">
    </script>
        <title>Ingresar Patente</title>
    </head>
    <body>
        <div class="container">
            <div class="page-header">
              <h1>Ingrese la patente del auto que desea sacar</h1>
            </div>
             <div class="row">
                  <div class="col-lg-12">
                        <div class="CajaInicio animated bounceInRight">
                         <form id="FormSacar" method="post" class="form-horizontal" action="" >
                          <div class="form-group">
                          <label for="" class="col-lg-4 control-label">Correo Electrónico</label>
                         <div class="col-lg-6">
                          <input type="text" class="form-control" name="patente" id="patente" placeholer="Ingrese patente">
                          <?php
                         $dateTime = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
                         $fecha_salida = $dateTime->format("m/d/y  H:i A");
                          ?>
                          <input type="hidden" name="fecha_salida" value="<?php echo $fecha_salida;?>"/>
                      </div>
                      </form>
                    </div>
                 </div>
            </div>
        </body>
</html>