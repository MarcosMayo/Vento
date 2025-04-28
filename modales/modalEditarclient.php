<?php include("../logica/conexion.php"); ?>

<!-- Modal para editar cliente -->
<div class="modal fade" id="editarClienteModal" tabindex="-1" aria-labelledby="editarClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editarClienteModalLabel">Editar Cliente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarCliente" action="editarcliente.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombreEdit" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreEdit" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellidosEdit" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidosEdit" name="apellidos" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefonoEdit" class="form-label">Número telefónico</label>
                            <input type="tel" class="form-control" id="telefonoEdit" name="telefono">
                        </div>
                        <div class="col-md-6">
                            <label for="emailEdit" class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailEdit" name="email">
                        </div>
                        <div class="col-md-6">
                            <label for="fechaRegistroEdit" class="form-label">Fecha de registro</label>
                            <input type="date" class="form-control" id="fechaRegistroEdit" name="fechaRegistro">
                        </div>
                        <div class="col-md-6">
                            <label for="folioEdit" class="form-label">FOLIO</label>
                            <input type="text" class="form-control" id="folioEdit" name="folio" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="confirmarEditar">Confirmar edición</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
