$(document).ready(function () {

    $("#RegistrarForm").bootstrapValidator({
        message: 'Este valor no es valido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-zoom-in'
        },

        fields: {
            nombre: {
                validators: {
                    notEmpty: {
                        message: 'El nombre del administrador es requerido'
                    }
                }
            },
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
            },

            repetirClave: {
                validators: {
                    notEmpty: {
                        message : 'Este campo no puede estar vacío'
                    }
                }
            }
        }
    });


});