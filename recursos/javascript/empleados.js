$(document).ready( function () {
    cargarTabla();
} );

var cargarTabla = function(){
    $("#tabla_empleados").DataTable({
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
        "destroy": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }, 
        "ajax":{
            url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoEmpleados.php',
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
        {"data":"ver_mas"},
        ],
        createdRow: function (row, data, index) {
            $(row).find("td:eq(1)").attr('data-target', "nombre");
            $(row).find("td:eq(2)").attr('data-target', "apellido1");
            $(row).find("td:eq(3)").attr('data-target', "apellido2");
            $(row).find("td:eq(4)").attr('data-target', "telefono");            
            $(row).find("td:eq(5)").attr('data-target', "correo");
            $(row).find("td:eq(6)").attr('data-target', "ver_mas");
        }
    });
}

function guardarEmpleado(llave){
    var cedula = $("#cedula");
    var nombre = $("#nombre");
    var apellido1 = $("#apellido1");
    var apellido2 = $("#apellido2");
    var telefono = $("#telefono");
    var correo = $("#correo");
    var fecha_nacimiento = $("#fecha_nacimiento");
    var departamento = $("#departamento");
    var puesto = $("#puesto");
    var contrasenha = $("#contrasenha");

    $.ajax({
        url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoEmpleados.php',
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
            fecha_nacimiento: fecha_nacimiento.val(),
            departamento: departamento.val(),
            puesto: puesto.val(),
            contrasenha: contrasenha.val()
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
