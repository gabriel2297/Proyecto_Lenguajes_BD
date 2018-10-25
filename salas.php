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
                        <li><a class="nav-link" href="pacientes.php">Pacientes</a></li>
                        <li><a class="nav-link" href="personal.php">Personal</a></li>
                        <li><a class="nav-link active" href="#">Salas</a></li>
                        <li><a class="nav-link" href="tratamientos.php">Tratamientos</a></li>
                    </ul>
                </div>
            </nav> 	
        </div>
        <!-- Contenido de la pagina -->
        <div class="container">
            <h1 class="encabezado_h1">S  A  H</h1>
            <h4 class="encabezado_h4">Sistema de Administración Hospitalaria</h4>
            <hr/>
            <div class="agregar_sala">
                <h5>Agregar nueva sala</h5>
                <form>
                    <div class="form-group">
                        <label for="tipo_sala">Tipo de sala</label>
                        <select class="form-control" id="tipo_sala" name="tipo_sala">
                            <option>Por implementar</option>
                            <!-- <?php
                                $datos = mysqli_query($conn, "SELECT tipo_carne FROM tipo_carnes;");
                                while($fila = mysqli_fetch_array($datos)){
                                    echo "<option>" . $fila['tipo_carne']. "</option>";
                                }
                            ?> -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Guardar sala</button>
                </form>
            </div>
        </div>

        <!-- pie de pagina -->
		<footer>
            <p style="text-align: center">Diseño y desarrollo por LenguajesBD Proyecto &copy; 2018</p>
        </footer>

    </body>
</html>