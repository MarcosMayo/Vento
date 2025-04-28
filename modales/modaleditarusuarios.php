<?php include("../logica/conexion.php"); ?>
<!-- Modal para editar usuario, único para cada usuario -->
<div class="modal fade" id="editarUsuarioModal<?= $dato->id_usu ?>" tabindex="-1" aria-labelledby="editarUsuarioModalLabel<?= $dato->id_usu ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editarUsuarioModalLabel<?= $dato->id_usu ?>">Editar usuario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario para editar usuario -->
                <form action="../crud/editarusuario.php" method="POST">
                    <input type="hidden" name="id" value="<?= $dato->id_usu ?>"> <!-- Campo oculto para el ID -->
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" name="nombre" value="<?= $dato->nombre ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <input type="text" class="form-control" name="rol" value="<?= $dato->id_rol ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="contraseña" class="form-label">Contraseña</label>
                        <input type="text" class="form-control" name="contraseña" value="<?= $dato->contraseña ?>" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php

 