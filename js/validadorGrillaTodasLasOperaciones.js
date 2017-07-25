$(document).ready(function () {
$('#datetimePicker').datetimepicker();
$('#datetimePicker2').datetimepicker();
    $("#BuscadorFechas").bootstrapValidator({
        message: 'Este valor no es valido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-zoom-in'
        },
         fields: {
           de : {
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
           hasta : {
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