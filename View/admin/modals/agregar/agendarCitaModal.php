<!-- Modal para agregar cita -->
<div id="agendarCitaModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agendar cita</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="agendar_cita">
                    <div class="form-group">
                        <label for="cedula_empleado">Cedula del empleado</label>
                        <input type="text" class="form-control" id="cedula_empleado" placeholder="Número de cédula del médico">
                    </div>
                    <div class="form-group">
                        <label for="sala">Sala</label>
                        <select class="form-control" id="sala" name="sala">
                            <?php
                                $datos_salas = oci_parse($conn, "SELECT tipo FROM tipo_sala");
                                oci_execute ($datos_salas);
                                while($fila = oci_fetch_assoc ($datos_salas)){
                                    echo "<option>" . $fila['TIPO'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_sala">Número de sala</label>
                        <select class="form-control" id="id_sala" name="sala">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tipo_cita">Tipo de cita</label>
                        <select class="form-control" id="tipo_cita" name="tipo_cita">
                            <?php
                                $datos_citas = oci_parse($conn, "SELECT tipo_cita FROM tipo_cita");
                                oci_execute ($datos_citas);
                                while($fila = oci_fetch_assoc ($datos_citas)){
                                    echo "<option>" . $fila['TIPO_CITA'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha_hora">Fecha y hora</label>
                        <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarCita('guardarCita');" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>