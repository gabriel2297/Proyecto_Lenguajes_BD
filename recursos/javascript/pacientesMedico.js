$(document).ready( function () {
    cargarTabla();
} );

var cargarTabla = function(){
    $("#tabla_pacientes").DataTable({
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
        "destroy": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }, 
        "ajax":{
            url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoPacientesMedico.php',
            method: 'POST',
            data: {
                llave: 'cargarTabla'
            }
        },
        "columns": [
        {"data":"cedula", "data-order":"cedula"},
        {"data":"nombre"},
        {"data":"apellido1"},
        {"data":"apellido2"},
        {"data":"telefono"},
        {"data":"correo"},
        ],
        createdRow: function (row, data, index) {
            $(row).find("td:eq(1)").attr('data-target', "nombre");
            $(row).find("td:eq(2)").attr('data-target', "apellido1");
            $(row).find("td:eq(3)").attr('data-target', "apellido2");
            $(row).find("td:eq(4)").attr('data-target', "telefono");            
            $(row).find("td:eq(5)").attr('data-target', "correo");
        }
    });
}

function terminarCita(llave){
    var num_cita = $("#numero_cita");
    var observaciones = $("#observaciones");

    $.ajax({
        url: "http://localhost/Proyecto_Lenguajes_BD/php/manejoPacientesMedico.php",
        method: "POST",
        dataType: "text",
        data: {
            llave: llave,
            num_cita: num_cita.val(),
            observaciones: observaciones.val()
        }, success: function(respuesta){
            if(respuesta != "Error"){
                $("#resultados").addClass("alert alert-success");
                $("#resultados").html("Cita concluida satisfactoriamente <i class='fa fa-check-circle'></i>");
                $("#resultados").delay(3000).fadeOut(function(){
                    $(this).removeClass("alert alert-success");
                    $(this).html("");
                    $(this).css("display", "");
                    window.location.replace("http://localhost/Proyecto_Lenguajes_BD/View/medico/pacientes.php");
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

function asignarTratamiento(llave){
    var cedula = $("#cedula");
    var tratamientoAsignar = $("#tratamientoAsignar");

    $.ajax({
        url: "http://localhost/Proyecto_Lenguajes_BD/php/manejoPacientesMedico.php",
        method: "POST",
        dataType: "text",
        data: {
            llave: llave,
            cedula: cedula.val(),
            tratamientoAsignar: tratamientoAsignar.val()
        }, success: function(respuesta){
            if(respuesta != "Error"){
                $("#resultados").addClass("alert alert-success");
                $("#resultados").html("Tratamiento agregado <i class='fa fa-check-circle'></i>");
                $("#resultados").delay(2000).fadeOut(function(){
                    $(this).removeClass("alert alert-success");
                    $(this).html("");
                    $(this).css("display", "");
                    location.reload(true);
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