$(document).ready( function () {
    cargarTabla();
    modalEliminarPaciente();
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
        $("#cecula_pacienteEliminar").val(cedula_paciente);
        $("#eliminarPacienteModal").modal("toggle");
    })
}

function eliminarPaciente(llave){
    
}
