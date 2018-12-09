<!-- Modal para eliminar tratamientos -->
<div class="modal fade" tabindex="-1" role="dialog" id="eliminarTratamientoModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">¿Seguro que desea eliminar este tratamiento?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p style="text-align: center;">
            Esta acción no puede ser deshecha. De proceder, tambien eliminará el tratamiento a todos los pacientes que lo tengan asignado.
        </p>
        <div class="form-group">
            <input type="hidden" class="form-control" id="codigoEliminar" name="codigoEliminar">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-outline-danger" onclick="eliminarTratamiento('eliminarTratamiento')" data-dismiss="modal">Eliminar</button>
      </div>
    </div>
  </div>
</div>