<?php 

    require_once 'config_bd.php';
    
    if(isset($_POST['llave'])){

        // si se quiere cargar de nuevo la tabla
        if($_POST['llave'] == "cargarTabla"){

            // obtener todas las salas
            $datos = oci_parse($conn, "SELECT * FROM salas");
            oci_execute ($datos);  

            // obtener cantidad de salas
            $sql = oci_parse($conn, "SELECT COUNT(*) AS COUNT FROM salas");
            oci_execute($sql);

            // convertir a arreglo asociativo
            $res = oci_fetch_assoc($sql);

            // obtener el valor guardado con la llave COUNT
            $num_rows = $res["COUNT"];

            if($num_rows > 0){
                while($data = oci_fetch_assoc ($datos)){
                    $sub_array['DT_RowId'] = $data['NUM_SALAS'];
                    $sub_array["numero_sala"] = $data['NUM_SALAS'];
                    // buscar el tipo de sala en base del id de la sala
                    $datos_tipo_sala = oci_parse($conn, "SELECT * FROM tipo_sala");
                    oci_execute ($datos_tipo_sala);
                    while($fila = oci_fetch_assoc ($datos_tipo_sala)){
                        if($data['ID_TIPO'] == $fila["ID_TIPO"]){
                            $sub_array['tipo_sala'] = $fila['TIPO'];
                            break;
                        }
                    }
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

        // si es guardar una sala
        if($_POST['llave'] == "guardarSala"){
            $tipo_sala = $_POST['tipo_sala'];

            // buscar el tipo de sala que fue seleccionado
            $id_tipo_sala = "";
            $datos = oci_parse($conn, "SELECT * FROM tipo_sala");
            oci_execute ($datos);
            while($fila = oci_fetch_assoc ($datos)){
                if($tipo_sala == $fila["TIPO"]){
                    $id_tipo_sala = $fila["ID_TIPO"];
                    break;
                }
            }

            // crear llamada al procedimiento almacenado 
            $sql = "BEGIN agregar_SALA(:id_tipo_sala); END;";
            
            // crear un query que junte la conexion a la BD con lo que se va a ejecutar, 
            //$conn viene de config_bd.php
            $query = oci_parse($conn, $sql);

            // juntar cada dato al query
            oci_bind_by_name($query, ":id_tipo_sala", $id_tipo_sala);

            // ejecutar el procedimiento almacenado 
            if(oci_execute($query)){
                echo "La información fue guardada con éxito <i class='far fa-check-circle'></i>";
            }
            else{
                echo "Error";
            }
        }

        // cerrar conexion
        oci_close($conn);

    }

?>