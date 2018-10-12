<!-- Modal para agregar pacientes-->
<div id="agregarPacienteModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar nuevo paciente</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="agregar_paciente">
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
                        <input type="text" class="form-control" id="nombre" placeholder="Nombre del paciente">
                    </div>
                    <div class="form-group">
                        <label for="apellido1">Primer apellido</label>
                        <input type="text" class="form-control" id="apellido1" placeholder="Primer apellido del paciente">
                    </div>
                    <div class="form-group">
                        <label for="apellido2">Segundo apellido</label>
                        <input type="text" class="form-control" id="apellido2" placeholder="Segundo apellido del paciente">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Telefono</label>
                        <input type="tel" class="form-control" id="telefono" placeholder="Telefono del paciente">
                    </div>
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" placeholder="Fecha de nacimiento del paciente">
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo electronico</label>
                        <input type="email" class="form-control" id="correo" placeholder="Correo electronico del paciente">
                    </div>
                    <div class="form-group">
                        <label for="telefono_sos">Telefono de emergencia</label>
                        <input type="tel" class="form-control" id="telefono_sos" placeholder="Telefono de emergencia del paciente">
                    </div>
                    <div class="form-group">
                        <label for="tipo_sangre">Tipo de sangre</label>
                        <select class="form-control" id="tipo_sangre" name="tipo_sangre">
                            <option>Por implementar</option>
                            <!--
                            <?php
                                $query = "SELECT genero FROM hospital_admin.genero;";
                                $statement = oci_parse ($conn, $query);
                                oci_execute ($statement);
                                while($row = oci_fetch_array ($statement, OCI_ASSOC)){
                                    echo "<option>" . $row['genero']. "</option>";
                                }
                            ?> -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="genero">Genero</label>
                        <select class="form-control" id="genero" name="genero">
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
                        <label for="peso">Peso</label>
                        <input type="number" min="0" class="form-control" id="peso" placeholder="Peso del paciente">
                    </div>
                    <div class="form-group">
                        <label for="altura">Altura</label>
                        <input type="number" min="0" class="form-control" id="altura" placeholder="Altura del paciente">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarPaciente('guardarPaciente');" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>