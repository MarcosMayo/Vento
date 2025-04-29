<?php include("../logica/conexion.php"); ?>

<!-- Modal para editar cliente -->
<div class="modal fade" id="editarClienteModal<?= $dato->id_cliente ?>" tabindex="-1" aria-labelledby="editarClienteModalLabel<?= $dato->id_cliente ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editarClienteModalLabel<?= $dato->id_cliente ?>">Editar Cliente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../crud/editarcliente.php" method="POST">
                    <input type="hidden" name="id_cliente" value="<?= $dato->id_cliente ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="folioEdit<?= $dato->id_cliente ?>" class="form-label">Folio</label>
                            <input type="number" class="form-control" id="folioEdit<?= $dato->id_cliente ?>" name="folio" value="<?= $dato->folio ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nombreEdit<?= $dato->id_cliente ?>" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreEdit<?= $dato->id_cliente ?>" name="nombre" value="<?= $dato->nombre ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellidosEdit<?= $dato->id_cliente ?>" class="form-label">Apellido Paterno</label>
                            <input type="text" class="form-control" id="apellidosEdit<?= $dato->id_cliente ?>" name="apellidos" value="<?= $dato->apellido_paterno ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="apellidosEdit<?= $dato->id_cliente ?>" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="apellidosEdit<?= $dato->id_cliente ?>" name="apellidos" value="<?= $dato->apellido_materno ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefonoEdit<?= $dato->id_cliente ?>" class="form-label">Número telefónico</label>
                            <input type="tel" class="form-control" id="telefonoEdit<?= $dato->id_cliente ?>" name="telefono" value="<?= $dato->telefono ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="emailEdit<?= $dato->id_cliente ?>" class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailEdit<?= $dato->id_cliente ?>" name="email" value="<?= $dato->correo ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="fechaRegistroEdit<?= $dato->id_cliente ?>" class="form-label">Direccion</label>
                            <input type="text" class="form-control" id="direccion<?= $dato->id_cliente ?>" name="direccion" value="<?= $dato->direccion ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Confirmar edición</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
