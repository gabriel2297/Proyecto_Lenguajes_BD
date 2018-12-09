<!-- Modal para editar sala -->
<div id="editarSalaModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar sala</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="editar_sala">
                    <input type="hidden" id="num_salaEditar">
                    <div class="form-group">
                        <label for="tipo_salaEditar">Tipo de sala</label>
                        <select class="form-control" id="tipo_salaEditar" name="tipo_salaEditar">
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
                <button type="button" class="btn btn-primary" onclick="editarSala('editarSala');" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>