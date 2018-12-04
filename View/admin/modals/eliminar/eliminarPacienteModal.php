<!-- Modal para eliminar paciente-->
<div class="modal fade" tabindex="-1" role="dialog" id="eliminarPacienteModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">¿Seguro que desea eliminar a este paciente?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p style="text-align: center;">Esta acción no puede ser deshecha.</p>
        <div class="form-group">
            <input type="hidden" class="form-control" id="cecula_pacienteEliminar" name="cedula_paciente">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-outline-danger" onclick="eliminarPaciente('eliminarPaciente')" data-dismiss="modal">Eliminar</button>
      </div>
    </div>
  </div>
</div>