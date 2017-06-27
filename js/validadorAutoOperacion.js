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
            patente: {
                validators: {
                    notEmpty: {
                        message: 'La patente es requerida'
                    },
                    regexp: {
                        regexp: /([A-Z])\w{2}\s([0-9])\w{2}/g,
                        message: 'La patente debe contener tres letras y tres numeros'
                    }
                    
                }
            },
           marca: {
                validators: {
                    notEmpty: {
                        message: 'La marca es requerida'
                    }
                }
            },
            color: {
                validators: {
                    notEmpty: {
                        message : 'El color es requerido'
                    }
                }
            },
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