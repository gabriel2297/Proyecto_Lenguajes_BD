<!-- Modal para eliminar empleado -->
<div class="modal fade" tabindex="-1" role="dialog" id="eliminarEmpleadoModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">¿Seguro que desea eliminar a este empleado?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p style="text-align: center;">
            Esta acción no puede ser deshecha. Recuerde que esto borrará todas las citas que el médico tenga asignadas 
            por lo que los pacientes perderán sus citas.
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-outline-danger" onclick="eliminarEmpleado('eliminarEmpleado')" data-dismiss="modal">Eliminar</button>
      </div>
    </div>
  </div>
</div>