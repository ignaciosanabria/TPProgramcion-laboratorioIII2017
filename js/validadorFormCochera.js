$(document).ready(function () {

    $("#FormIngresoCochera").bootstrapValidator({
        message: 'Este valor no es valido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-zoom-in'
        },

        fields: {
           prioridad :{
               validators : {
                   choice : {
                       min : 0,
                       max : 1,
                       message : 'Por favor ingrese un casillero'
                   }
               }
           },

           piso : {
              validators : {
                  between : {
                      min : 1,
                      max : 3,
                      message : 'Por favor ingrese un piso entre el 1 y el 3'
                  }
              }
           },
         numero : {
             validators : {
                 notEmpty : {
                     message : 'El numero de cochera es requerido'
                 },
                 integer : {
                     message : 'No es un numero válido'
                 }
             }
         }
        }
    });


});