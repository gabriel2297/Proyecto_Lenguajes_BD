<?php 

    require_once 'config_bd.php';
    
    if(isset($_POST['llave'])){

        // si se quiere cargar de nuevo la tabla
        if($_POST['llave'] == "cargarTabla"){

            // obtener todos los empleados
            $datos = oci_parse($conn, "SELECT * FROM empleado");
            oci_execute ($datos);  

            // obtener cantidad de empleados
            $sql = oci_parse($conn, "SELECT COUNT(*) AS COUNT FROM empleado");
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
                    $sub_array['fecha_nacimiento'] = $data['FECHA_NACIMIENTO'];
                    $sub_array['correo'] = $data['CORREO_ELECTRONICO'];
                    // buscar el departamento en base del id del departamento
                    $datos_departamento = oci_parse($conn, "SELECT * FROM departamento");
                    oci_execute ($datos_departamento);
                    while($fila = oci_fetch_assoc ($datos_departamento)){
                        if($data['ID_DEPARTAMENTO'] == $fila["ID_DEPARTAMENTO"]){
                            $sub_array['departamento'] = $fila['DEPARTAMENTO'];
                            break;
                        }
                    }
                    // lo mismo para puesto
                    $datos_trabajo = oci_parse($conn, "SELECT * FROM trabajo");
                    oci_execute ($datos_trabajo);
                    while($fila = oci_fetch_assoc ($datos_trabajo)){
                        if($data['ID_TRABAJO'] == $fila["ID_TRABAJO"]){
                            $sub_array['puesto'] = $fila['TITULO_TRABAJO'];
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

        // si es guardar un paciente
        if($_POST['llave'] == "guardarEmpleado"){
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $apellido1 = $_POST['apellido1'];
            $apellido2 = $_POST['apellido2'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $departamento = $_POST['departamento'];
            $puesto = $_POST['puesto'];

            // buscar el id del departamento que fue seleccionado
            $id_departamento = "";
            $datos = oci_parse($conn, "SELECT * FROM departamento");
            oci_execute ($datos);
            while($fila = oci_fetch_assoc ($datos)){
                if($departamento == $fila["DEPARTAMENTO"]){
                    $id_departamento = $fila["ID_DEPARTAMENTO"];
                    break;
                }
            }

            // lo mismo para el puesto
            $id_puesto = 0;
            $datos = oci_parse($conn, "SELECT * FROM trabajo");
            oci_execute ($datos);
            while($fila = oci_fetch_assoc ($datos)){
                if($puesto == $fila["TITULO_TRABAJO"]){
                    $id_puesto = $fila["ID_TRABAJO"];
                    break;
                }
            }

            // cambiar fecha_nacimiento porque del json viene como yyyy-mm-dd y oracle es dd-mm-yyyy
            $fecha_nacimiento = date('d-m-Y', strtotime($fecha_nacimiento));

            // crear llamada al procedimiento almacenado 
            $sql = "BEGIN agregar_empleado(:cedula,
                                           :nombre,
                                           :apellido1,
                                           :apellido2,
                                           :telefono,
                                           :fecha_nacimiento,
                                           :correo,
                                           :id_departamento,
                                           :id_puesto); 
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
            oci_bind_by_name($query, ":correo", $correo);
            oci_bind_by_name($query, ":fecha_nacimiento", $fecha_nacimiento);
            oci_bind_by_name($query, ":id_departamento", $id_departamento);
            oci_bind_by_name($query, ":id_puesto", $id_puesto);

            // ejecutar el procedimiento almacenado 
            if(oci_execute($query)){
                echo "La información fue guardada con éxito <i class='far fa-check-circle'></i>";
            }
            else{
                echo "Error";
            }
        }

        // si es cerrar sesion
        if($_POST['llave'] == "cerrarSesion"){
             // inicializar la sesion
             session_start();
             // eliminar los datos de sesion en servidor
             $_SESSION = array();
             // destruir la sesion y revisar por errores
             if(session_destroy()){
                echo "Correcto";
             }
             else{
                echo "Error";
             }
        }

        // cerrar conexion
        oci_close($conn);

    }

?>