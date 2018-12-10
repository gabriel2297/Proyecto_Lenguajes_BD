<?php
	require_once '../../php/config_bd.php';
    // iniciar la sesion
    session_start();
    // Si aun no hay sesion significa que el usuario no ha hecho login, redireccionar a login
    if(!isset($_SESSION['cedula_empleado']) || empty($_SESSION['cedula_empleado'])){
      header("location: http://localhost/Proyecto_Lenguajes_BD/");
      exit;
    }
    // el usuario tiene sesion, es medico?
    if( $_SESSION['id_trabajo'] != 1 ){
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
                        <li><a class="nav-link active" href="#">Mis pacientes</a></li>
                        <li><a class="nav-link" href="tratamientos.php">Tratamientos</a></li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
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
            <div class="contenido">
                <div id="resultados"></div>
                <hr/>
                <div>
                    <table class="table table-striped table-hover table-bordered nowrap" style="width:100%" id="tabla_pacientes">
                        <thead>
                            <th>Número de cita</th>
                            <th>Estado</th>
                            <th>Número de sala</th>
                            <th>Fecha y hora</th>
                            <th>Tipo de cita</th>
                            <th>Cedula</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <?php
                                $cedula = $_SESSION['cedula_empleado'];
                                
                                $p_cursor = oci_new_cursor($conn);
                                $stid = oci_parse($conn, "begin :cursor := obtener_citas_medico_dia(:cedula); end;");
        
                                oci_bind_by_name($stid, ":cedula", $cedula, 20);
                                oci_bind_by_name($stid, ':cursor', $p_cursor, -1, OCI_B_CURSOR);
                                oci_execute($stid);
        
                                oci_execute($p_cursor, OCI_DEFAULT);
                                
                                $contador = 0;
        
                                while (($row = oci_fetch_array($p_cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                                    echo "<tr>";
                                    echo "<td>". $row['ID_CITA'] . "</td>";
                                    echo "<td>". $row['ESTADO_CITA'] . "</td>";
                                    echo "<td>". $row['NUM_SALA'] . "</td>";
                                    echo "<td>". $row['FECHA_HORA'] . "</td>";
                                    echo "<td>". $row['TIPO_CITA'] . "</td>";
                                    echo "<td>". $row['CEDULA'] . "</td>";
                                    echo "<td><form method='GET' action='http://localhost/Proyecto_Lenguajes_BD/View/medico/infopacientes.php'> <input type='hidden' name='cedula_paciente' value='$row[CEDULA]'> <input type='hidden' name='num_cita' value='$row[ID_CITA]'> <button type='submit' class='btn btn-primary btn-sm'>Ver más</button>  </form></td>";
                                    echo "</tr>";
        
                                    $contador++;
                                }
        
                                oci_free_statement($stid);
                                oci_free_statement($p_cursor);
        
                                if($contador == 0){
                                    echo "<td colspan='7'>Ninguna cita encontrada</td>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

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

        <script src="../../recursos/javascript/js.js"></script>
        
    </body>
</html>