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
            url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoTratamientosMedico.php',
            method: 'POST',
            data: {
                llave: 'cargarTabla'
            }
        },
        "columns": [
        {"data":"codigo", "data-order":"codigo"},
        {"data":"descripcion"},
        ]
    });
}