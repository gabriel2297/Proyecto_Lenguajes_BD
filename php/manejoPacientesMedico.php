<?php 

    require_once 'config_bd.php';
    
    if(isset($_POST['llave'])){

        // si se quiere finalizar una cita
        if($_POST['llave'] == "terminarCita"){
            $num_cita = $_POST['num_cita'];
            $observaciones = $_POST['observaciones'];

            // crear llamada al procedimiento almacenado 
            $sql = "BEGIN completar_cita(:numero_cita, :observaciones_cita); END;";
            
            // crear un query que junte la conexion a la BD con lo que se va a ejecutar, 
            //$conn viene de config_bd.php
            $query = oci_parse($conn, $sql);

            // juntar cada dato al query
            oci_bind_by_name($query, ":numero_cita", $num_cita);
            oci_bind_by_name($query, ":observaciones_cita", $observaciones);

            // ejecutar el procedimiento almacenado 
            if(oci_execute($query)){
                echo "Exito";
            }
            else{
                echo "Error";
            }

        }

        // si se quiere cargar de nuevo la tabla
        if($_POST['llave'] == "cargarTabla"){

            // obtener todos los pacientes
            $datos = oci_parse($conn, "SELECT * FROM paciente");
            oci_execute ($datos);  

            // obtener cantidad de pacientes
            $sql = oci_parse($conn, "SELECT COUNT(*) AS COUNT FROM paciente");
            oci_execute($sql);

            // convertir a arreglo asociativo
            $res = oci_fetch_assoc($sql);

            // obtener el valor guardado con la llave COUNT
            $num_rows = $res["COUNT"];

            if($num_rows > 0){
                while($data = oci_fetch_assoc ($datos)){
                    $sub_array['DT_RowId'] = $data['CEDULA'];
                    $sub_array["cedula"] = $data['CEDULA'];
                    $sub_array['nombre'] = $data['NOMBRE'];
                    $sub_array['apellido1'] = $data['APELLIDO1'];
                    $sub_array['apellido2'] = $data['APELLIDO2'];
                    $sub_array['telefono'] = $data['TELEFONO'];
                    $sub_array['correo'] = $data['CORREO_ELECTRONICO'];
                    $arreglo['data'][] = $sub_array;
                }
                echo json_encode($arreglo);
            }
            else{
                $arreglo['data'] = array();
                echo json_encode($arreglo);
                return;
            }
        }
    }

    // cerrar conexion
    oci_close($conn);

?>