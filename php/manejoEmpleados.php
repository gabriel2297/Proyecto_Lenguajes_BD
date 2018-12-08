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
                    $sub_array['DT_RowId'] = $data['ECEDULA'];
                    $sub_array["cedula"] = $data['ECEDULA'];
                    $sub_array['nombre'] = $data['ENOMBRE'];
                    $sub_array['apellido1'] = $data['EAPELLIDO1'];
                    $sub_array['apellido2'] = $data['EAPELLIDO2'];
                    $sub_array['telefono'] = $data['ETELEFONO'];
                    $sub_array['correo'] = $data['ECORREO_ELECTRONICO'];
                    $sub_array['ver_mas'] = "<form method='GET' action='http://localhost/Proyecto_Lenguajes_BD/View/admin/infoempleados.php'> <input type='hidden' name='cedula_empleado' value='$data[ECEDULA]'> <button type='submit' class='btn btn-primary btn-sm'>Ver más</button>  </form>";
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
            $contrasenha = $_POST['contrasenha']; 

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
                                           :correo,
                                           :fecha_nacimiento,
                                           :id_departamento,
                                           :id_puesto,
                                           :contrasenha); 
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
            oci_bind_by_name($query, ":contrasenha", $contrasenha); 

            // ejecutar el procedimiento almacenado 
            if(oci_execute($query)){
                echo "La información fue guardada con éxito <i class='fa fa-check-circle'></i>";
            }
            else{
                echo "Error";
            }
        }

        // si se quiere editar un empleado
        if($_POST['llave'] == "editarEmpleado"){

            // obtener la cedula
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $apellido1 = $_POST['apellido1'];
            $apellido2 = $_POST['apellido2'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];

            // preparar el query de sql
            $sql = 'BEGIN 
                        :resultado := editar_empleado(:cedula, :nombre, :apellido1, :apellido2, :telefono, :correo);
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

        
        // si se quiere eliminar un empleado
        if($_POST['llave'] == "eliminarEmpleado"){

            // obtener la cedula
            $cedula = $_POST['cedula_empleado'];

            // preparar el query de sql
            $sql = 'BEGIN 
                        :resultado := eliminar_empleado(:cedula);
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