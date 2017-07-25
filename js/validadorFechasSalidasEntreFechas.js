$(document).ready(function () {
$('#datetimePicker3').datetimepicker();
$('#datetimePicker4').datetimepicker();
    $("#BuscadorFechasSalidas").bootstrapValidator({
        message: 'Este valor no es valido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-zoom-in'
        },
         fields: {
           deFechaSalida : {
               validators: {
                  notEmpty: {
                      message : 'La fecha de ingreso es requerida'
                  },
                    date: {
                        format: 'MM/DD/YYYY h:m A',
                        message: 'La fecha no es válida'
                    }
              }
            },
           hastaFechaSalida : {
               validators: {
                  notEmpty: {
                      message : 'La fecha de ingreso es requerida'
                  },
                    date: {
                        format: 'MM/DD/YYYY h:m A',
                        message: 'La fecha no es válida'
                    }
              }
            }
         }
         });
});