$(document).ready( function () {
    cargarTabla();
} );

var cargarTabla = function(){
    $("#tabla_tratamientos").DataTable({
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
        "destroy": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }, 
        "ajax":{
            url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoTratamientos.php',
            method: 'POST',
            data: {
                llave: 'cargarTabla'
            }
        },
        "columns": [
        {"data":"codigo", "data-order":"codigo"},
        {"data":"descripcion"},
        {"data":"acciones"},
        ]
    });
}

function guardarTratamiento(llave){
    var codigo = $("#codigo");
    var descripcion = $("#descripcion");

    $.ajax({
        url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoTratamientos.php',
        method: 'POST',
        dataType: 'text', 
        data: {
            llave: llave,
            codigo: codigo.val(),
            descripcion: descripcion.val(),
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
