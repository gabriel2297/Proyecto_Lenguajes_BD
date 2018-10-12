<?php include 'php/config_bd.php'; ?>

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
            <!-- Nuestros estilos -->
            <link href="http://localhost/Proyecto_Lenguajes_BD/recursos/css/css.css" rel="stylesheet">
            <!-- font awesome library -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <!-- Navbar de la pagina -->
        <div id="navbar">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="index.html">SAH</a>

                <!-- boton para colapsar navbar-->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#links">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- links del navbar -->
                <div class="collapse navbar-collapse" id="links">
                    <ul class="navbar-nav">
                        <li><a class="nav-link active" href="#">Pacientes</a></li>
                        <li><a class="nav-link" href="personal.php">Personal</a></li>
                        <li><a class="nav-link" href="salas.php">Salas</a></li>
                    </ul>
                </div>
            </nav> 	
        </div>
        <!-- Contenido de la pagina -->
        <div class="container">
            <div class="titulos">
                <h1 class="encabezado_h1">S  A  H</h1>
                <h4 class="encabezado_h4">Sistema de Administración Hospitalaria</h4>				
                <hr/>
            </div>
            <div class="introduccion">
			    <button type="submit" class="btn btn-outline-success pull-right" id="agregarPacienteBtn" data-toggle="modal" data-target="#agregarPacienteModal">Nuevo paciente</button>
                <h5>Manejo de pacientes</h5>
            </div>
            <div class="contenido">
                <div id="resultados"></div>
                <hr/>
            </div>
        </div>

        <!-- Modal para agregar pacientes -->
        <?php include("modals/agregarPacienteModal.php");?>

        <!-- pie de pagina -->
		<footer>
            <p style="text-align: center">Diseño y desarrollo por LenguajesBD Proyecto &copy; 2018</p>
        </footer>

        <script type="text/javascript" src="javascript/JS.js"></script>

    </body>
</html>