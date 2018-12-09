$(document).ready( function () {
    cargarTabla();
    modalEditarSala();
    modalEliminarSala();
} );

var cargarTabla = function(){
    $("#tabla_salas").DataTable({
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
        "destroy": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }, 
        "ajax":{
            url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoSalas.php',
            method: 'POST',
            data: {
                llave: 'cargarTabla'
            }
        },
        "columns": [
        {"data":"numero_sala", "data-order":"numero_sala"},
        {"data":"tipo_sala"},
        {"data": "acciones"},
        ]
    });
}

function guardarSala(llave){
    var tipo_sala = $("#tipo_sala");

    $.ajax({
        url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoSalas.php',
        method: 'POST',
        dataType: 'text', 
        data: {
            llave: llave,
            tipo_sala: tipo_sala.val()
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

function modalEditarSala(){
    $(document).on("click", "button[data-role=editar]", function(){
        var num_sala = $(this).data('id');
        $("#num_salaEditar").val(num_sala);
        $("#editarSalaModal").modal("toggle");
    })
}

function editarSala(llave){
    var tipo_sala = $("#tipo_salaEditar");
    var num_sala = $("#num_salaEditar");

    $.ajax({
        url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoSalas.php',
        method: 'POST',
        dataType: 'text', 
        data: {
            llave: llave,
            tipo_sala: tipo_sala.val(),
            num_sala: num_sala.val()
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

function modalEliminarSala(){
    $(document).on("click", "button[data-role=eliminar]", function(){
        var num_sala = $(this).data('id');
        $("#num_salaEliminar").val(num_sala);
        $("#eliminarSalaModal").modal("toggle");
    })
}

function eliminarSala(llave){
    var num_sala = $("#num_salaEliminar");
    $.ajax({
        url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoSalas.php',
        method: 'POST',
        dataType: 'text', 
        data: {
            llave: llave,
            num_sala: num_sala.val()
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
