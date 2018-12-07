<!-- Modal para agregar empleado -->
<div id="agregarEmpleadoModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar nuevo empleado</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="agregar_empleado">
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
                        <label for="fecha_nacimiento">Fecha de nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" placeholder="Fecha de nacimiento del paciente">
                    </div>
                    <div class="form-group">
                        <label for="departamento">Departamento</label>
                        <select class="form-control" id="departamento" name="departamento">
                            <?php
                                $datos_departamento = oci_parse($conn, "SELECT departamento FROM departamento");
                                oci_execute ($datos_departamento);
                                while($fila = oci_fetch_assoc ($datos_departamento)){
                                    echo "<option>" . $fila['DEPARTAMENTO'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="puesto">Puesto</label>
                        <select class="form-control" id="puesto" name="puesto">
                            <?php
                                $datos = oci_parse($conn, "SELECT titulo_trabajo FROM trabajo");
                                oci_execute($datos);
                                while($fila = oci_fetch_assoc($datos)){
                                    echo "<option>" . $fila['TITULO_TRABAJO']. "</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="contrasenha">Contraseña</label>
                        <input type="password" class="form-control" id="contrasenha" name="contrasenha" placeholder="Contraseña temporal">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarEmpleado('guardarEmpleado');" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>