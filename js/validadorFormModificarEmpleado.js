$(document).ready(function () {

    $("#FormModificarEmpleado").bootstrapValidator({
        message: 'Este valor no es valido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-zoom-in'
        },

        fields: {
           legajo : {
                   validators: {
                      integer : {
                          message : 'El número que selecciono no es válido'
                      },
                      notEmpty : {
                          message : 'El numero de legajo es requerido'
                      }
                   }
           },
           nombre: {
                   validators: {
                       notEmpty : {
                           message : 'El nombre es requerido'
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
           turno: {
               validators: {
                   notEmpty: {
                       message: 'El turno es requerido'
                   }
               }
           }
        }
    });


});