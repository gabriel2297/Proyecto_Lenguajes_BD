<?php 

    require_once 'config_bd.php';
    
    if(isset($_POST['llave'])){

        // si se quiere cargar de nuevo la tabla
        if($_POST['llave'] == "cargarTabla"){
            $datos = oci_parse($conn, "SELECT * FROM paciente");
            oci_execute ($datos);          
            if(oci_num_rows($datos) > 0){
                while($data = oci_fetch_assoc ($datos)){
                    $sub_array['DT_RowId'] = $data['CEDULA'];
                    $sub_array["cedula"] = $data['CEDULA'];
                    $sub_array['nombre'] = $data['NOMBRE'];
                    $sub_array['apellido1'] = $data['APELLIDO1'];
                    $sub_array['apellido2'] = $data['APELLIDO2'];
                    $sub_array['telefono'] = $data['TELEFONO'];
                    $sub_array['fecha_nacimiento'] = $data['FECHA_NACIMIENTO'];
                    $sub_array['correo'] = $data['CORREO'];
                    $sub_array['telefono_sos'] = $data['TELEFONO_SOS'];
                    // buscar el genero en base del id del paciente
                    $datos = oci_parse($conn, "SELECT * FROM genero");
                    oci_execute ($datos);
                    while($fila = oci_fetch_assoc ($datos)){
                        if($data['ID_GENERO'] == $fila["ID_GENERO"]){
                            $sub_array['genero'] = $data['GENERO'];
                            break;
                        }
                    }
                    // lo mismo para la sangre
                    $datos = oci_parse($conn, "SELECT * FROM tipo_sangre");
                    oci_execute ($datos);
                    while($fila = oci_fetch_assoc ($datos)){
                        if($date['ID_TIPO'] == $fila["ID_TIPO"]){
                            $sub_array['tipo_sangre'] = $data['TIPO'];
                            break;
                        }
                    }
                    $sub_array['peso'] = $data['peso'];
                    $sub_array['altura'] = $data['altura'];
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

        // si es guardar un paciente
        if($_POST['llave'] == "guardarPaciente"){
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $apellido1 = $_POST['apellido1'];
            $apellido2 = $_POST['apellido2'];
            $telefono = $_POST['telefono'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $correo = $_POST['correo'];
            $telefono_sos = $_POST['telefono_sos'];
            $tipo_sangre = $_POST['tipo_sangre'];
            $genero = $_POST['genero'];
            $peso = $_POST['peso'];
            $altura = $_POST['altura'];

            // buscar el id del genero que fue seleccionado
            $id_genero = "";
            $datos = oci_parse($conn, "SELECT * FROM genero");
            oci_execute ($datos);
            while($fila = oci_fetch_assoc ($datos)){
                if($genero == $fila["GENERO"]){
                    $id_genero = $fila["ID_GENERO"];
                    break;
                }
            }

            // lo mismo para la sangre
            $id_tipo_sangre = 0;
            $datos = oci_parse($conn, "SELECT * FROM tipo_sangre");
            oci_execute ($datos);
            while($fila = oci_fetch_assoc ($datos)){
                if($tipo_sangre == $fila["TIPO"]){
                    $id_tipo_sangre = $fila["ID_TIPO"];
                    break;
                }
            }

            // cambiar fecha_nacimiento porque del json viene como yyyy-mm-dd y oracle es dd-mm-yyyy
            $fecha_nacimiento = date('d-m-Y', strtotime($fecha_nacimiento));

            // crear llamada al procedimiento almacenado 
            $sql = 'BEGIN agregar_paciente(:cedula,
                                           :nombre,
                                           :apellido1,
                                           :apellido2,
                                           :telefono,
                                           :fecha_nacimiento,
                                           :correo,
                                           :telefono_sos,
                                           :id_tipo_sangre,
                                           :id_genero,
                                           :peso,
                                           :altura); END;';
            
            // crear un query que junte la conexion a la BD con lo que se va a ejecutar, 
            //$conn viene de config_bd.php

            $query = oci_parse($conn, $sql);

            // juntar cada dato al query
            oci_bind_by_name($query, ":cedula", $cedula);
            oci_bind_by_name($query, ":nombre", $nombre);
            oci_bind_by_name($query, ":apellido1", $apellido1);
            oci_bind_by_name($query, ":apellido2", $apellido2);
            oci_bind_by_name($query, ":telefono", $telefono);
            oci_bind_by_name($query, ":fecha_nacimiento", $fecha_nacimiento);
            oci_bind_by_name($query, ":correo", $correo);
            oci_bind_by_name($query, ":telefono_sos", $telefono_sos);
            oci_bind_by_name($query, ":id_tipo_sangre", $id_tipo_sangre);
            oci_bind_by_name($query, ":id_genero", $id_genero);
            oci_bind_by_name($query, ":peso", $peso);
            oci_bind_by_name($query, ":altura", $altura);

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