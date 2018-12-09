<!-- Modal para editar tratamientos -->
<div id="editarTratamientoModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar tratamiento</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="agregar_tratamiento">
                    <input type="hidden" id="codigoActual">
                        <div class="form-group">
                            <label for="descripcionEditar">Descripción</label>
                            <input type="text" class="form-control" id="descripcionEditar" placeholder="Descripcion del tratamiento">
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="editarTratamiento('editarTratamiento');" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>