function guardarPaciente(llave){
    var cedula = $("#cedula");
    var nombre = $("#nombre");
    var apellido1 = $("#apellido1");
    var apellido2 = $("#apellido2");
    var telefono = $("#telefono");
    var fecha_nacimiento = $("#fecha_nacimiento");
    var correo = $("#correo");
    var telefono_sos = $("#telefono_sos");
    var peso = $("#peso");
    var altura = $("#altura");

    $.ajax({
        url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoPacientes.php',
        method: 'POST',
        dataType: 'text', 
        data: {
            llave: llave,
            cedula: cedula.val(),
            nombre: nombre.val(),
            apellido1: apellido1.val(),
            apellido2: apellido2.val(),
            telefono: telefono.val(),
            fecha_nacimiento: fecha_nacimiento.val(),
            correo: correo.val(),
            telefono_sos: telefono_sos.val(),
            peso: peso.val(),
            altura: altura.val()
        }, success: function(respuesta){
            $("#resultados").addClass("alert alert-success");
            $("#resultados").html(respuesta);
            $("#resultados").delay(3000).fadeOut(function(){
                $(this).remove();
            });
        }
    });
}