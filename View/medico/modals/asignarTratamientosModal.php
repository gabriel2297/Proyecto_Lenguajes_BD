<!-- Modal para asignar tratamientos al paciente -->
<div id="asignarTratamientosModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Asignar tratamientos</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="asignar_tratamientos">
                    <div class="form-group">
                        <label for="tratamientoAsignar">Seleccione el tratamiento a asignar: </label>
                        <select id="tratamientoAsignar" name="tratamientoAsignar" class="form-control">
                            <?php
                                $query = oci_parse($conn, "SELECT tratamiento FROM tratamientos");
                                oci_execute($query);
                                while($fila = oci_fetch_assoc ($query)){
                                    echo "<option value='" . $fila['TRATAMIENTO'] . "'>" . $fila['TRATAMIENTO'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="asignarTratamiento('asignarTratamiento')">Asignar</button>
            </div>
        </div>
    </div>
</div>