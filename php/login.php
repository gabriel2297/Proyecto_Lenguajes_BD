<?php 

    require_once 'config_bd.php';

    $correo = $_POST['correo-login'];
    $pwd = $_POST['pwd-login'];

    // verificar si correo existe en la base de datos
    $sql = oci_parse($conn, "SELECT COUNT(*) AS COUNT FROM empleado WHERE ecorreo_electronico = :correo");
    
    // juntar cada dato al query
    oci_bind_by_name($sql, ":correo", $correo);

    if(oci_execute($sql)){
        // convertir a arreglo asociativo
        $res = oci_fetch_assoc($sql);

        // obtener el valor guardado con la llave COUNT
        $num_rows = $res["COUNT"];

        // ahora si, ver si el usuario tiene la misma contrasenha
        if($num_rows > 0 ){
            $datos = oci_parse($conn, "SELECT ecedula, econtrasenha, id_trabajo FROM empleado WHERE ecorreo_electronico = :correo");
            // juntar cada dato al query
            oci_bind_by_name($datos, ":correo", $correo);
            if(oci_execute($datos)){
                while($fila = oci_fetch_assoc ($datos)){
                    // si existe el correo, verificar clave
                    if($pwd == $fila['ECONTRASENHA']){
                        // contraseña correcta, iniciar sesion
                        session_start();
                        // salvarlos en la sesion
                        $_SESSION['id_trabajo'] = $fila['ID_TRABAJO'];
                        $_SESSION['cedula_empleado'] = $fila['ECEDULA'];
                        if($_SESSION['id_trabajo'] == 1){
                            header("Location: http://localhost/Proyecto_Lenguajes_BD/View/medico/medico.php");
                        }
                        else if($_SESSION['id_trabajo'] == 2){
                            header("Location: http://localhost/Proyecto_Lenguajes_BD/View/admin/admin.php");
                        }
                        else{
                            http_response_code(500);
                        }
                    }
                    else{
                        // contraseña incorrecta
                        echo "Correo o contraseña inválidos.";
                        return;
                    }
                }
            }
            else{
                http_response_code(500);
            }
        }
        else{
            echo "Usuario no encontrado";
        }
    }
?>