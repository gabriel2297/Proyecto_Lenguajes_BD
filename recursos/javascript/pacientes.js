$(document).ready( function () {
    cargarTabla();
    modalEliminarPaciente();
    modalEditarPaciente();
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
            url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoPacientes.php',
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
        {"data":"fecha_nacimiento"},
        {"data":"correo"},
        {"data":"telefono_sos"},
        {"data":"tipo_sangre"},
        {"data":"genero"},
        {"data":"peso"},
        {"data":"altura"},
        {"data":"editar"},
        {"data":"eliminar"},
        ],
        createdRow: function (row, data, index) {
            $(row).find("td:eq(1)").attr('data-target', "nombre");
            $(row).find("td:eq(2)").attr('data-target', "apellido1");
            $(row).find("td:eq(3)").attr('data-target', "apellido2");
            $(row).find("td:eq(4)").attr('data-target', "telefono");
            $(row).find("td:eq(5)").attr('data-target', "fecha_nacimiento");
            $(row).find("td:eq(6)").attr('data-target', "correo");
            $(row).find("td:eq(7)").attr('data-target', "telefono_sos");
            $(row).find("td:eq(8)").attr('data-target', "tipo_sangre");
            $(row).find("td:eq(9)").attr('data-target', "genero");
            $(row).find("td:eq(10)").attr('data-target', "peso");
            $(row).find("td:eq(11)").attr('data-target', "altura");
        }
    });
}

function guardarPaciente(llave){
    var cedula = $("#cedula");
    var nombre = $("#nombre");
    var apellido1 = $("#apellido1");
    var apellido2 = $("#apellido2");
    var telefono = $("#telefono");
    var fecha_nacimiento = $("#fecha_nacimiento");
    var correo = $("#correo");
    var telefono_sos = $("#telefono_sos");
    var tipo_sangre = $("#tipo_sangre");
    var genero = $("#genero");
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
            tipo_sangre: tipo_sangre.val(),
            genero: genero.val(),
            peso: peso.val(),
            altura: altura.val()
        }, success: function(respuesta){
            if(respuesta != "Error"){
                cargarTabla();
                $("#resultados").addClass("alert alert-success");
                $("#resultados").html(respuesta);
                $("#resultados").delay(5000).fadeOut(function(){
                    $(this).removeClass("alert alert-success");
                    $(this).html("");
                    $(this).css("display", "");
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

function modalEliminarPaciente(){
    $(document).on("click", "button[data-role=eliminar]", function(){
        var cedula_paciente = $(this).data('id');
        $("#cedula_pacienteEliminar").val(cedula_paciente);
        $("#eliminarPacienteModal").modal("toggle");
    })
}

function eliminarPaciente(llave){
    var cedula_paciente = $("#cecula_pacienteEliminar");
    $.ajax({
        url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoPacientes.php',
        method: 'POST',
        dataType: 'text',
        data: {
            llave: llave,
            cedula_paciente: cedula_paciente.val()
        },success: function(respuesta){
            if(respuesta == "Eliminado"){
                cargarTabla();
                $("#cecula_pacienteEliminar").val("");
                $("#resultados").addClass("alert alert-success");
                $("#resultados").html("La información fue eliminada con éxito <i class='fa fa-check-circle'></i>");
                $("#resultados").delay(5000).fadeOut(function(){
                    $(this).removeClass("alert alert-success");
                    $(this).html("");
                    $(this).css("display", "");
                });
            }
            else{
                $("#cecula_pacienteEliminar").val("");
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

function modalEditarPaciente(){
    $(document).on("click", "button[data-role=editar]", function(){
        var cedula_paciente = $(this).data('id');
        var nombre = $("#" + cedula_paciente).children('td[data-target=nombre]').text();
        var apellido1 = $("#" + cedula_paciente).children('td[data-target=apellido1]').text();
        var apellido2 = $("#" + cedula_paciente).children('td[data-target=apellido2]').text();
        var telefono = $("#" + cedula_paciente).children('td[data-target=telefono]').text();
        var correo = $("#" + cedula_paciente).children('td[data-target=correo]').text();
        var telefono_sos = $("#" + cedula_paciente).children('td[data-target=telefono_sos]').text();
        var peso = $("#" + cedula_paciente).children('td[data-target=peso]').text();
        var altura = $("#" + cedula_paciente).children('td[data-target=altura]').text();

        $("#cedula_editar").val(cedula_paciente);
        $("#nombre_editar").val(nombre);
        $("#apellido1_editar").val(apellido1);
        $("#apellido2_editar").val(apellido2);
        $("#telefono_editar").val(telefono);
        $("#correo_editar").val(correo);
        $("#telefono_sos_editar").val(telefono_sos);
        $("#peso_editar").val(peso);
        $("#altura_editar").val(altura);

        $("#editarPacienteModal").modal("toggle");
    })
}
