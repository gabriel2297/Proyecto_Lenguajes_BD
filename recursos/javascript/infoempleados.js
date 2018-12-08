function eliminarEmpleado(llave){
    var cedula_empleado = $("#cedula");
    $.ajax({
        url: 'http://localhost/Proyecto_Lenguajes_BD/php/manejoEmpleados.php',
        method: 'POST',
        dataType: 'text',
        data: {
            llave: llave,
            cedula_empleado: cedula_empleado.val()
        },success: function(respuesta){
            if(respuesta == "Eliminado"){
                $("#resultados").addClass("alert alert-success");
                $("#resultados").html("Empleado eliminado satisfactoriamente <i class='fa fa-check-circle'></i>");
                $("#resultados").delay(3000).fadeOut(function(){
                    $(this).removeClass("alert alert-success");
                    $(this).html("");
                    $(this).css("display", "");
                    window.location.replace("http://localhost/Proyecto_Lenguajes_BD/View/admin/personal.php");
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

function editarEmpleado(llave){
    var cedula =$("#cedula");
    var nombre = $("#nombre");
    var apellido1 = $("#apellido1");
    var apellido2 = $("#apellido2");
    var telefono = $("#telefono");
    var correo = $("#correo");

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
            correo: correo.val()
        }, success: function(respuesta){
            if(respuesta == "Editado"){
                $("#resultados").addClass("alert alert-success");
                $("#resultados").html("Empleado editado satisfactoriamente <i class='fa fa-check-circle'></i>");
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