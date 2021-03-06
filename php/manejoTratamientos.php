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
                    $sub_array['acciones'] = "<button class='btn btn-primary btn-sm' data-role='editar' data-id='$data[ID_TRATAMIENTO]'>Editar</button><button class='btn btn-primary btn-sm' data-role='eliminar' data-id='$data[ID_TRATAMIENTO]'>Eliminar</button>";
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

        // si es guardar un tratamiento
        if($_POST['llave'] == "guardarTratamiento"){
            $codigo = $_POST['codigo'];
            $descripcion = $_POST['descripcion'];

            // crear llamada al procedimiento almacenado 
            $sql = "BEGIN agregar_tratamiento(:codigo, :descripcion); END;";
            
            // crear un query que junte la conexion a la BD con lo que se va a ejecutar, 
            //$conn viene de config_bd.php
            $query = oci_parse($conn, $sql);

            // juntar cada dato al query
            oci_bind_by_name($query, ":codigo", $codigo);
            oci_bind_by_name($query, ":descripcion", $descripcion);

            // ejecutar el procedimiento almacenado 
            if(oci_execute($query)){
                echo "La información fue guardada con éxito <i class='fa fa-check-circle'></i>";
            }
            else{
                echo "Error";
            }
        }

        // si es editar un tratamiento
        if($_POST['llave'] == "editarTratamiento"){
            $codigoActual = $_POST['codigoActual'];
            $descripcion = $_POST['descripcion'];

            // crear llamada al procedimiento almacenado 
            $sql = "BEGIN editar_tratamiento(:codigoActual, :descripcion); END;";
            
            // crear un query que junte la conexion a la BD con lo que se va a ejecutar, 
            //$conn viene de config_bd.php
            $query = oci_parse($conn, $sql);

            // juntar cada dato al query
            oci_bind_by_name($query, ":codigoActual", $codigoActual);
            oci_bind_by_name($query, ":descripcion", $descripcion);

            // ejecutar el procedimiento almacenado 
            if(oci_execute($query)){
                echo "Tratamiento editado con éxito <i class='fa fa-check-circle'></i>";
            }
            else{
                echo "Error";
            }
        }

        // si es eliminar un tratamiento
        if($_POST['llave'] == "eliminarTratamiento"){
            $codigoEliminar = $_POST['codigoEliminar'];

            // crear llamada al procedimiento almacenado 
            $sql = "BEGIN eliminar_tratamiento(:codigoEliminar); END;";
            
            // crear un query que junte la conexion a la BD con lo que se va a ejecutar, 
            //$conn viene de config_bd.php
            $query = oci_parse($conn, $sql);

            // juntar cada dato al query
            oci_bind_by_name($query, ":codigoEliminar", $codigoEliminar);

            // ejecutar el procedimiento almacenado 
            if(oci_execute($query)){
                echo "Tratamiento eliminado con éxito <i class='fa fa-check-circle'></i>";
            }
            else{
                echo "Error";
            }
        }

        // cerrar conexion
        oci_close($conn);

    }

?>