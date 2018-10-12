<?php 

    require_once 'config_bd.php';
    
    if(isset($_POST['llave'])){
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
            $peso = $_POST['peso'];
            $altura = $_POST['altura'];

            // crear llamada al procedimiento almacenado 
            $sql = 'BEGIN agregar_paciente(:cedula,
                                           :nombre,
                                           :apellido1,
                                           :apellido2,
                                           :telefono,
                                           :fecha_nacimiento,
                                           :correo,
                                           :telefono_sos,
                                           :peso,
                                           :altura); END;';
            
            // juntar la conexion a la BD con lo que se va a ejecutar, $conn viene de config_bd.php
            $stmt = oci_parse($conn, $sql);

            // juntar cada dato al query
            oci_bind_by_name($stmt, ":cedula", $cedula);
            oci_bind_by_name($stmt, ":nombre", $nombre);
            oci_bind_by_name($stmt, ":apellido1", $apellido1);
            oci_bind_by_name($stmt, ":apellido2", $apellido2);
            oci_bind_by_name($stmt, ":telefono", $telefono);
            oci_bind_by_name($stmt, ":fecha_nacimiento", $fecha_nacimiento);
            oci_bind_by_name($stmt, ":correo", $correo);
            oci_bind_by_name($stmt, ":telefono_sos", $telefono_sos);
            oci_bind_by_name($stmt, ":peso", $peso);
            oci_bind_by_name($stmt, ":altura", $altura);

            // ejecutar el procedimiento almacenado 
            oci_execute($stmt);

            echo "La información fue guardada con éxito <i class='far fa-check-circle'></i>";
        }

        // cerrar conexion
        oci_close($conn);

    }

?>