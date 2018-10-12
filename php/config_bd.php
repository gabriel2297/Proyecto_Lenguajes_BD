<?php
    // variables
    $usuario = "hospital_admin";
    $password = "hospital_admin";
    $string_conexion = "localhost/xe";

    // conectarse a la BD de Oracle
    $conn = oci_connect($usuario, $password, $string_conexion);

    // revisar si hay errores y cerrar conexion
    if (!$conn) {
        $m = oci_error();
        echo $m['message'], "\n";
        exit;
    }
?>