function eliminarPaciente(llave){
    var cedula_paciente = $("#cedula");
    $.ajax({
        url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoPacientes.php',
        method: 'POST',
        dataType: 'text',
        data: {
            llave: llave,
            cedula_paciente: cedula_paciente.val()
        },success: function(respuesta){
            if(respuesta == "Eliminado"){
                $("#resultados").addClass("alert alert-success");
                $("#resultados").html("Paciente eliminado satisfactoriamente <i class='fa fa-check-circle'></i>");
                $("#resultados").delay(3000).fadeOut(function(){
                    $(this).removeClass("alert alert-success");
                    $(this).html("");
                    $(this).css("display", "");
                    window.location.replace("http://localhost/Proyecto_Lenguajes_BD/View/admin/pacientes.php");
                }); 
                
            }
            else{
                $("#resultados").addClass("alert alert-danger");
                $("#resultados").html("Ocurrió un error, por favor intentelo de nuevo. Si vuelve a pasar comuníquese a soporte@sah.com");
                $("#resultados").delay(5000).fadeOut(function(){
                    $(this).removeClass("alert alert-danger");
                    $(this).html("");
                    $(this).css("display", "");
                });
            }
        }
    });
}

function editarPaciente(llave){
    var cedula =$("#cedula");
    var nombre = $("#nombre");
    var apellido1 = $("#apellido1");
    var apellido2 = $("#apellido2");
    var telefono = $("#telefono");
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
            correo: correo.val(),
            telefono_sos: telefono_sos.val(),
            peso: peso.val(),
            altura: altura.val()
        }, success: function(respuesta){
            if(respuesta == "Editado"){
                $("#resultados").addClass("alert alert-success");
                $("#resultados").html("Paciente editado satisfactoriamente <i class='fa fa-check-circle'></i>");
                $("#resultados").delay(3000).fadeOut(function(){
                    $(this).removeClass("alert alert-success");
                    $(this).html("");
                    $(this).css("display", "");
                    location.reload(true);
                }); 
            }
            else{
                $("#resultados").addClass("alert alert-danger");
                $("#resultados").html("Ocurrió un error, por favor intentelo de nuevo. Si vuelve a pasar comuníquese a soporte@adminSAH.com");
                $("#resultados").delay(5000).fadeOut(function(){
                    $(this).removeClass("alert alert-danger");
                    $(this).html("");
                    $(this).css("display", "");
                });
            }
        }
    });
}

function guardarCita(llave){
    var cedula_paciente = $("#cedula");
    var cedula_empleado = $("#cedula_empleado");
    var sala = $("#sala");
    var observaciones = $("#observaciones");
    var tipo_cita = $("#tipo_cita");
    var fecha_hora = $("#fecha_hora");

    $.ajax({
        url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoPacientes.php',
        method: 'POST',
        dataType: 'text', 
        data: {
            llave: llave,
            cedula_paciente: cedula_paciente.val(),
            cedula_empleado: cedula_empleado.val(),
            sala: sala.val(),
            observaciones: observaciones.val(),
            tipo_cita: tipo_cita.val(),
            fecha_hora: fecha_hora.val()
        }, success: function(respuesta){
            if(respuesta == "Agregado"){
                $("#resultados").addClass("alert alert-success");
                $("#resultados").html("Cita agregada satisfactoriamente <i class='fa fa-check-circle'></i>");
                $("#resultados").delay(3000).fadeOut(function(){
                    $(this).removeClass("alert alert-success");
                    $(this).html("");
                    $(this).css("display", "");
                    location.reload(true);
                }); 
            }
            else{
                $("#resultados").addClass("alert alert-danger");
                $("#resultados").html("Ocurrió un error, por favor intentelo de nuevo. Si vuelve a pasar comuníquese a soporte@adminSAH.com");
                $("#resultados").delay(5000).fadeOut(function(){
                    $(this).removeClass("alert alert-danger");
                    $(this).html("");
                    $(this).css("display", "");
                });
            }
        }
    });
}