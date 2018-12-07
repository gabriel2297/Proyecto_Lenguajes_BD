<?php 

    require_once 'config_bd.php';
    
    if(isset($_POST['llave'])){

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
                    $sub_array['ver_mas'] = "<form method='GET' action='http://localhost/Proyecto_Lenguajes_BD/View/admin/infopacientes.php'> <input type='hidden' name='cedula_paciente' value='$data[CEDULA]'> <button type='submit' class='btn btn-primary btn-sm'>Ver más</button>  </form>";
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
                if($tipo_sangre == $fila["SANG_TIPO"]){
                    $id_tipo_sangre = $fila["SANG_ID_TIPO"];
                    break;
                }
            }

            // cambiar fecha_nacimiento porque del json viene como yyyy-mm-dd y oracle es dd-mm-yyyy
            $fecha_nacimiento = date('d-m-Y', strtotime($fecha_nacimiento));

            // crear llamada al procedimiento almacenado 
            $sql = "BEGIN agregar_paciente(:cedula,
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
                                           :altura); 
                    END;";
            
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
                echo "La información fue guardada con éxito <i class='fa fa-check-circle'></i>";
            }
            else{
                echo "Error";
            }
        }

        // si se quiere eliminar un paciente
        if($_POST['llave'] == "eliminarPaciente"){

            // obtener la cedula
            $cedula = $_POST['cedula_paciente'];

            // preparar el query de sql
            $sql = 'BEGIN 
                        :resultado := eliminar_paciente(:cedula);
                    END;';

            // asignar valores
            $query = oci_parse($conn, $sql);

            // hacer el binding de las variables
            oci_bind_by_name($query, ":cedula", $cedula);
            oci_bind_by_name($query, ":resultado", $resultado, 80, SQLT_CHR);

            // ejecutar el procedimiento almacenado
            oci_execute($query);
            if($resultado == "Eliminado"){
                echo "Eliminado";
            }
            else{
                echo "Error";
            }
        }



        // si se quiere editar un paciente
        if($_POST['llave'] == "editarPaciente"){

            // obtener la cedula
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $apellido1 = $_POST['apellido1'];
            $apellido2 = $_POST['apellido2'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $telefono_sos = $_POST['telefono_sos'];
            $peso = $_POST['peso'];
            $altura = $_POST['altura'];

            // preparar el query de sql
            $sql = 'BEGIN 
                        :resultado := editar_paciente(:cedula, :nombre, :apellido1, :apellido2, :telefono, :correo, :telefono_sos, :peso, :altura);
                    END;';

            // asignar valores
            $query = oci_parse($conn, $sql);

            // hacer el binding de las variables
            oci_bind_by_name($query, ":cedula", $cedula);
            oci_bind_by_name($query, ":nombre", $nombre);
            oci_bind_by_name($query, ":apellido1", $apellido1);
            oci_bind_by_name($query, ":apellido2", $apellido2);
            oci_bind_by_name($query, ":telefono", $telefono);
            oci_bind_by_name($query, ":correo", $correo);
            oci_bind_by_name($query, ":telefono_sos", $telefono_sos);
            oci_bind_by_name($query, ":peso", $peso);
            oci_bind_by_name($query, ":altura", $altura);
            oci_bind_by_name($query, ":resultado", $resultado, 80, SQLT_CHR);

            // ejecutar el procedimiento almacenado
            oci_execute($query);
            if($resultado == "Editado"){
                echo "Editado";
            }
            else{
                echo "Error";
            }
        }

        // si se quiere agregar una cita
        if($_POST['llave'] == "guardarCita"){

            // obtener la cedula
            $cedula_paciente = $_POST['cedula_paciente'];
            $cedula_empleado = $_POST['cedula_empleado'];
            $sala = $_POST['sala'];
            $observaciones = $_POST['observaciones'];
            $tipo_cita = $_POST['tipo_cita'];
            $fecha_hora = $_POST['fecha_hora'];

            // convertir formato de fecha y hora
            $fecha_hora = date('d-m-Y H:i', strtotime($fecha_hora));

            // obtener el id de sala seleccionado
            $id_tipo_sala = 0;
            $datos = oci_parse($conn, "SELECT * FROM tipo_sala");
            oci_execute ($datos);
            while($fila = oci_fetch_assoc ($datos)){
                if($sala == $fila["TIPO"]){
                    $id_tipo_sala = $fila["ID_TIPO"];
                    break;
                }
            }

            // obtener el numero de sala disponible
            $num_sala = 0;
            $datos = oci_parse($conn, "SELECT * FROM salas");
            oci_execute($datos);
            while($fila = oci_fetch_assoc($datos)){
                if($fila['ID_TIPO'] == $id_tipo_sala){
                    $num_sala = $fila['NUM_SALAS'];
                }
            }

            // obtener el id de tipo de cita
            $id_tipo_cita = 0;
            $datos = oci_parse($conn, "SELECT * FROM tipo_cita");
            oci_execute($datos);
            while($fila = oci_fetch_assoc($datos)){
                if($fila['TIPO_CITA'] == $tipo_cita){
                    $id_tipo_cita = $fila['ID_TIPO_CITA'];
                }
            }

            // crear llamada al procedimiento almacenado 
            $sql = "BEGIN crear_cita(:cedula_paciente,
                                    :cedula_empleado,
                                    :num_sala,
                                    :fecha_hora,
                                    :observaciones,
                                    :id_tipo_cita); 
                    END;";
            
            // crear un query que junte la conexion a la BD con lo que se va a ejecutar, 
            //$conn viene de config_bd.php
            $query = oci_parse($conn, $sql);

            // juntar cada dato al query
            oci_bind_by_name($query, ":cedula_paciente", $cedula_paciente);
            oci_bind_by_name($query, ":cedula_empleado", $cedula_empleado);
            oci_bind_by_name($query, ":num_sala", $num_sala);
            oci_bind_by_name($query, ":fecha_hora", $fecha_hora);
            oci_bind_by_name($query, ":observaciones", $observaciones);
            oci_bind_by_name($query, ":id_tipo_cita", $id_tipo_cita);

            // ejecutar el procedimiento almacenado 
            if(oci_execute($query)){
                echo "Agregado";
            }
            else{
                echo "Error";
            }

        }


    }

    // cerrar conexion
    oci_close($conn);

?>