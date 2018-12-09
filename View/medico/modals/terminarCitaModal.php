<!-- Modal para terminar cita -->
<div class="modal fade" tabindex="-1" role="dialog" id="terminarCitaModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Finalizar cita</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Por favor ingrese las observaciones necesarias para la continuidad del paciente.</p>
        <div class="form-group">
            <textarea rows="4" class="form-control" id="observaciones" placeholder="Observaciones"></textarea>
        </div>
        <?php
            $num_cita = $_GET['num_cita'];
            echo "<input type ='hidden' id='numero_cita' value='$num_cita'>";
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="terminarCita('terminarCita')" data-dismiss="modal">Finalizar</button>
      </div>
    </div>
  </div>
</div>