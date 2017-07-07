$(document).ready(function () {
$('#datetimePicker').datetimepicker();
    $("#FormIngreso").bootstrapValidator({
        message: 'Este valor no es valido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-zoom-in'
        },

        fields: {
            idAuto: {
                validators: {
                    notEmpty: {
                        message : "El auto es requerido"
                    }
                }
            }
            ,
            fecha_ingreso: {
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
           idEmpleado: {
                validators: {
                    notEmpty: {
                        message : 'La empleado es requerido'
                    }
                }
            },
           idCochera: {
                validators: {
                    notEmpty: {
                        message : 'La cochera es requerida'
                    }
                }
            }
        }
    });


});