<?php include("../logica/conexion.php"); ?> 
<div class="modal fade" id="agregarClienteModal" tabindex="-1" aria-labelledby="agregarClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="agregarClienteModalLabel">Nuevo Cliente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formCliente" action="insertarcliente.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Número telefónico</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-md-6">
                            <label for="fechaRegistro" class="form-label">Fecha de registro</label>
                            <input type="date" class="form-control" id="fechaRegistro" name="fechaRegistro">
                        </div>
                        <div class="col-md-6">
                            <label for="folio" class="form-label">FOLIO</label>
                            <input type="text" class="form-control" id="folio" name="folio" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="confirmarDatos">Confirmar datos</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
