$(document).ready(function () {

    $("#loginSacar").bootstrapValidator({
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
                        regexp: '/[A-Z]{3}[0-9]{3}$/',
                        message: 'La patente debe contener tres letras y tres numeros'
                    }
                    
                }
            }
        }
    });


});