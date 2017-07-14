$(document).ready(function () {

    $("#loginInicioForm").bootstrapValidator({
        message: 'Este valor no es valido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-zoom-in'
        },

        fields: {
            mail: {
                validators: {
                    notEmpty: {
                        message: 'El mail del usuario es requerido'
                    },
                   emailAddress: {
                        message: 'El mail ingresado no es válido'
                    }
                }
            },
            clave: {
                validators: {
                    notEmpty: {
                        message: 'La contraseña es requerida'
                    }
                }
            }
        }
    });


});