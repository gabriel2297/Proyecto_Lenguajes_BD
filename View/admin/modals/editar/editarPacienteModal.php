<!-- Modal para editar paciente-->
<div class="modal fade" tabindex="-1" role="dialog" id="editarPacienteModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar paciente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="agregar_paciente">
            <div class="form-group">
                <label for="cedula">Número de cédula</label>
                <input type="text" class="form-control" id="cedula_editar" readonly>
                <span>El numero de cedula no puede ser editado. Debera borrar al paciente</span>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre_editar" placeholder="Nombre del paciente">
            </div>
            <div class="form-group">
                <label for="apellido1">Primer apellido</label>
                <input type="text" class="form-control" id="apellido1_editar" placeholder="Primer apellido del paciente">
            </div>
            <div class="form-group">
                <label for="apellido2">Segundo apellido</label>
                <input type="text" class="form-control" id="apellido2_editar" placeholder="Segundo apellido del paciente">
            </div>
            <div class="form-group">
                <label for="telefono">Telefono</label>
                <input type="tel" class="form-control" id="telefono_editar" placeholder="Telefono del paciente">
            </div>
            <div class="form-group">
                <label for="correo">Correo electronico</label>
                <input type="email" class="form-control" id="correo_editar" placeholder="Correo electronico del paciente">
            </div>
            <div class="form-group">
                <label for="telefono_sos">Telefono de emergencia</label>
                <input type="tel" class="form-control" id="telefono_sos_editar" placeholder="Telefono de emergencia del paciente">
            </div>
            <div class="form-group">
                <label for="peso">Peso</label>
                <input type="number" min="0" class="form-control" id="peso_editar" placeholder="Peso del paciente">
            </div>
            <div class="form-group">
                <label for="altura">Altura</label>
                <input type="number" min="0" class="form-control" id="altura_editar" placeholder="Altura del paciente">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-outline-warning" onclick="editarPaciente('editarPaciente')" data-dismiss="modal">Editar</button>
      </div>
    </div>
  </div>
</div>