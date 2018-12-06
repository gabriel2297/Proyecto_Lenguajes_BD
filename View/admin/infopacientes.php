<?php
	require_once '../../php/config_bd.php';
    // iniciar la sesion
    session_start();
    // Si aun no hay sesion significa que el usuario no ha hecho login, redireccionar a login
    if(!isset($_SESSION['cedula_empleado']) || empty($_SESSION['cedula_empleado'])){
      header("location: http://localhost/Proyecto_Lenguajes_BD/");
      exit;
    }
    // el usuario tiene sesion, es admin?
    if( $_SESSION['id_trabajo'] != 2 ){
        http_response_code(403);
        exit;
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Lenguajes de bases de datos</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="keywords" content="HTML, CSS, JavaScript">
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
            
            <!-- bootstrap scripts -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

            <!-- Google fonts -->
            <link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet"> 

            <!-- Datatables info -->
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css">
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">

            <!-- Nuestros estilos -->
            <link href="http://localhost/Proyecto_Lenguajes_BD/recursos/css/css.css" rel="stylesheet">
            <!-- font awesome library -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <!-- Navbar de la pagina -->
        <div id="navbar">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="admin.php">SAH</a>

                <!-- boton para colapsar navbar-->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#links">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- links del navbar -->
                <div class="collapse navbar-collapse" id="links">
                    <ul class="navbar-nav">
                        <li><a class="nav-link active" href="pacientes.php">Pacientes</a></li>
                        <li><a class="nav-link" href="personal.php">Personal</a></li>
                        <li><a class="nav-link" href="salas.php">Salas</a></li>
                        <li><a class="nav-link" href="tratamientos.php">Tratamientos</a></li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
						<li><a class="nav-link" href="ajustes.php">Ajustes</a></li>
						<li><button type="button" class="btn btn-link" onclick="cerrarSesion('cerrarSesion')">Salir</button></li>
					</ul>
                </div>
            </nav> 	
        </div>
        <!-- Contenido de la pagina -->
        <div class="container-fluid">
            <div class="titulos">
                <h1 class="encabezado_h1">S  A  H</h1>
                <h4 class="encabezado_h4">Sistema de Administración Hospitalaria</h4>				
                <hr/>
            </div>
            <div class="introduccion">
                <h5>Manejo de pacientes</h5>
            </div>
            <hr/>

            <?php 

            $cedula = $_GET['cedula_paciente'];

            // obtener datos de ese paciente
            $query = oci_parse($conn, "SELECT * FROM paciente WHERE cedula = :cedula_paciente");

            // juntar cada dato al query
            oci_bind_by_name($query, ":cedula_paciente", $cedula);
            
            oci_execute ($query);  

            // convertir a arreglo asociativo
            $paciente = oci_fetch_assoc ($query);

            // buscar el id del genero que fue seleccionado
            $datos = oci_parse($conn, "SELECT * FROM genero");
            oci_execute ($datos);
            while($fila = oci_fetch_assoc ($datos)){
                if($paciente['ID_GENERO'] == $fila["ID_GENERO"]){
                    $genero = $fila["GENERO"];
                    break;
                }
            }

            // lo mismo para la sangre
            $id_tipo_sangre = 0;
            $datos = oci_parse($conn, "SELECT * FROM tipo_sangre");
            oci_execute ($datos);
            while($fila = oci_fetch_assoc ($datos)){
                if($paciente['ID_TIPO_SANGRE'] == $fila["SANG_ID_TIPO"]){
                    $tipo_sangre = $fila["SANG_TIPO"];
                    break;
                }
            }
            
            echo "
            <div class='container'>
                <div class='row'>
                    <div class='col-sm-6'>
                        <div class='form-group'>
                            <label for='cedula'>Número de cédula</label>
                            <input type='text' class='form-control' id='cedula' readonly value= '" . $paciente['CEDULA'] . "'>
                        </div>
                        <div class='form-group'>
                            <label for='nombre'>Nombre</label>
                            <input type='text' class='form-control' id='nombre' value='" . $paciente['NOMBRE'] . "'>
                        </div>
                        <div class='form-group'>
                            <label for='apellido1'>Primer apellido</label>
                            <input type='text' class='form-control' id='apellido1' value='" . $paciente['APELLIDO1'] . "'>
                        </div>
                        <div class='form-group'>
                            <label for='apellido2'>Segundo apellido</label>
                            <input type='text' class='form-control' id='apellido2' value='" . $paciente['APELLIDO2'] . "'>
                        </div>
                        <div class='form-group'>
                            <label for='telefono'>Telefono</label>
                            <input type='tel' class='form-control' id='telefono' value='" . $paciente['TELEFONO'] . "'>
                        </div>
                        <div class='form-group'>
                            <label for='fecha_nac'>Fecha de nacimiento</label>
                            <input type='text' class='form-control' id='fecha_nac' readonly value='" . $paciente['FECHA_NACIMIENTO'] . "'>
                        </div>
                    </div>
                    <div class='col-sm-6'>
                        <div class='form-group'>
                            <label for='correo'>Correo electronico</label>
                            <input type='email' class='form-control' id='correo' value='" . $paciente['CORREO_ELECTRONICO'] . "'>
                        </div>
                        <div class='form-group'>
                            <label for='telefono_sos'>Telefono de emergencia</label>
                            <input type='tel' class='form-control' id='telefono_sos' value='" . $paciente['TELEFONO_SOS'] . "'>
                        </div>
                        <div class='form-group'>
                            <label for='tipo_sangre'>Tipo de sangre</label>
                            <input type='text' class='form-control' id='tipo_sangre' readonly value='" . $tipo_sangre . "'>
                        </div>
                        <div class='form-group'>
                            <label for='genero'>Género</label>
                            <input type='text' class='form-control' id='genero' readonly value='" . $genero . "'>
                        </div>
                        <div class='form-group'>
                            <label for='peso'>Peso</label>
                            <input type='number' min='0' class='form-control' id='peso' value='" . $paciente['PESO'] . "'>
                        </div>
                        <div class='form-group'>
                            <label for='altura'>Altura</label>
                            <input type='number' min='0' class='form-control' id='altura' value='" . $paciente['ALTURA'] . "'>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ";
        ?>

        <!-- pie de pagina -->
		<footer>
            <p style="text-align: center">Diseño y desarrollo por LenguajesBD Proyecto &copy; 2018</p>
        </footer>

        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js "></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js"></script>


        <script type="text/javascript" src="http://localhost/Proyecto_Lenguajes_BD/recursos/javascript/pacientes.js"></script>

    </body>
</html>