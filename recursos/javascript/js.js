// funcion que se encarga de cerrar la sesion
function cerrarSesion(llave){
    $.ajax({
        url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoEmpleados.php',
        method: 'POST',
        dataType: 'text', 
        data: {
            llave: llave
        }, success: function(respuesta){
            if(respuesta == "Correcto"){
                window.location.href = 'http://localhost/Proyecto_Lenguajes_BD/';
            }
            else{
                $("#resultados").addClass("alert alert-danger");
                $("#resultados").html(respuesta);
                $("#resultados").delay(5000).fadeOut(function(){
                    $(this).removeClass("alert alert-danger");
                    $(this).html("");
                    $(this).css("display", "");
                });
            }
        }
    });
}