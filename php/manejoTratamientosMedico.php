<?php 

    require_once 'config_bd.php';
    
    if(isset($_POST['llave'])){

        // si se quiere cargar de nuevo la tabla
        if($_POST['llave'] == "cargarTabla"){

            // obtener todos los tratamientos
            $datos = oci_parse($conn, "SELECT * FROM tratamientos");
            oci_execute($datos);
            
            // obtener cantidad de tratamientos
            $sql = oci_parse($conn, "SELECT COUNT(*) AS COUNT FROM tratamientos");
            oci_execute($sql);
            
            // convertir a un arreglo asociativo
            $res = oci_fetch_assoc($sql);

            // obtener el valor guardado con la llave COUNT
            $num_rows = $res["COUNT"];

            // si hay 1 o mas tratamientos imprimirlos, sino devolver json vacio
            if($num_rows > 0){
                while($data = oci_fetch_assoc ($datos)){
                    $sub_array['DT_RowId'] = $data['ID_TRATAMIENTO'];
                    $sub_array["codigo"] = $data['ID_TRATAMIENTO'];
                    $sub_array['descripcion'] = $data['TRATAMIENTO'];
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
?>