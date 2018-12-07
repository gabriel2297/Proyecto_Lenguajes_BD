<!-- Modal para ver tratamientos asignados al paciente -->
<div id="verTratamientosModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tratamientos asignados</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="ver_tratamientos">
                    <?php

                        $cedula = $_GET['cedula_paciente'];
                        $p_cursor = oci_new_cursor($conn);
                        $stid = oci_parse($conn, "begin :cursor := buscar_tratamientos_paciente(:cedula); end;");

                        oci_bind_by_name($stid, ":cedula", $cedula, 20);
                        oci_bind_by_name($stid, ':cursor', $p_cursor, -1, OCI_B_CURSOR);
                        oci_execute($stid);

                        oci_execute($p_cursor, OCI_DEFAULT);
                        
                        echo "<ul>";
                        while (($row = oci_fetch_array($p_cursor, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                            echo "<li> Tratamiento: " . $row['TRATAMIENTO'] . "</li>";
                            echo "<li> Fecha recetado: " . $row['FECHA_RECETA'] . "</li>";
                            echo "<hr/>";
                        }
                        echo "</ul>";
                        oci_free_statement($stid);
                        oci_free_statement($p_cursor);

                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>