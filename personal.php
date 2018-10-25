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
                        <li><a class="nav-link active" href="personal.php">Personal</a></li>
                        <li><a class="nav-link" href="salas.php">Salas</a></li>
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
            <div class="agregar_empleado">
                <h5>Agregar nuevo empleado</h5>
                <form>
                    <div class="form-group">
                        <label for="cedula">Número de cédula</label>
                        <input type="text" class="form-control" id="cedula" placeholder="Cédula como XX-XXXX-XXXX">
                    </div>
                    <div class="card border-primary mb-3">
                        <div class="card-header">Formato para cédula: </div>
                        <div class="card-body">
                            <p class="card-text">Este tipo de persona tendrá 0 como primera posición de la cédula, de acuerdo con la tabla de naturalezas antes descrita y las restantes posiciones deben cumplir con la siguiente codificación:</p>
                            <p class="card-text" style="text-align: center;">0P-TTTT-AAAA</p>
                            <p class="card-text">Donde la P representa la provincia, TTTT representa el Tomo justificado con ceros a la izquierda, y AAAA el asiento, que al igual que el tomo, debe estar justificado con ceros a la izquierda. Un número de cédula valido sería por ejemplo 01-0913-0259. </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" placeholder="Nombre del empleado">
                    </div>
                    <div class="form-group">
                        <label for="apellido1">Primer apellido</label>
                        <input type="text" class="form-control" id="apellido1" placeholder="Primer apellido del empleado">
                    </div>
                    <div class="form-group">
                        <label for="apellido2">Segundo apellido</label>
                        <input type="text" class="form-control" id="apellido2" placeholder="Segundo apellido del empleado">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Telefono</label>
                        <input type="tel" class="form-control" id="telefono" placeholder="Telefono del empleado">
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo electronico</label>
                        <input type="email" class="form-control" id="correo" placeholder="Correo electronico del empleado">
                    </div>
                    <div class="form-group">
                        <label for="departamento">Departamento</label>
                        <select class="form-control" id="departamento" name="departamento">
                            <option>Por implementar</option>
                            <!-- <?php
                                $datos = mysqli_query($conn, "SELECT tipo_carne FROM tipo_carnes;");
                                while($fila = mysqli_fetch_array($datos)){
                                    echo "<option>" . $fila['tipo_carne']. "</option>";
                                }
                            ?> -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="trabajo">Puesto</label>
                        <select class="form-control" id="trabajo" name="trabajo">
                            <option>Por implementar</option>
                            <!-- <?php
                                $datos = mysqli_query($conn, "SELECT tipo_carne FROM tipo_carnes;");
                                while($fila = mysqli_fetch_array($datos)){
                                    echo "<option>" . $fila['tipo_carne']. "</option>";
                                }
                            ?> -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right">Guardar empleado</button>
                </form>
            </div>
        </div>

        <!-- pie de pagina -->
		<footer>
            <p style="text-align: center">Diseño y desarrollo por LenguajesBD Proyecto &copy; 2018</p>
        </footer>

    </body>
</html>