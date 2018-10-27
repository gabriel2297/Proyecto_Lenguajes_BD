<!-- Modal para agregar sala -->
<div id="agregarSalaModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar nueva sala</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="agregar_sala">
                    <div class="form-group">
                        <label for="tipo_sala">Tipo de sala</label>
                        <select class="form-control" id="tipo_sala" name="tipo_sala">
                            <?php
                                $datos = oci_parse ($conn, "SELECT tipo FROM hospital_admin.tipo_sala");
                                oci_execute ($datos);
                                while($fila = oci_fetch_assoc ($datos)){
                                    echo "<option>" . $fila['TIPO']. "</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarSala('guardarSala');" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>