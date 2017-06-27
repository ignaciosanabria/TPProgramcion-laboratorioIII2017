$(document).ready(function () {

    $("#FormSacar").bootstrapValidator({
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
            }
        }
    });


});