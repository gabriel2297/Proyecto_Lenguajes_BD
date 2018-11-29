<!-- Modal para agregar tratamientos -->
<div id="agregarTratamientoModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar nuevo tratamiento</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="agregar_tratamiento">
                    <div class="form-group">
                        <label for="codigo">Código del tratamiento</label>
                        <input type="text" class="form-control" id="codigo" placeholder="Codigo en numeros">
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <input type="text" class="form-control" id="descripcion" placeholder="Descripcion del tratamiento">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarTratamiento('guardarTratamiento');" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>