<?php include("../logica/conexion.php"); ?>
<!-- Modal para agregar usuario -->
<div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="agregarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="agregarUsuarioModalLabel">Agregar nuevo usuario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">

                <form id="formAgregarUsuario" action="../crud/guardarusuario.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Apellido" required>
                    </div>

                    <div class="mb-3">
                            <select name="rol" class="form-select" aria-label="Seleccione">
                                <option selected>Seleccione</option>

                                <?php
                                $sql = $conexion->query("SELECT * FROM roles");
                                while ($datos = $sql->fetch_object()) { ?>
                                    <option value="<?php echo $datos->id_rol; ?>"><?php echo $datos->nombre; ?></option>
                                <?php } ?>

                            </select>
                        </div>

                    <div class="mb-3">
                        <label for="contraseña" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Ingrese una contraseña" required>
                    </div>

                    <div class="mb-3">
                        <label for="confirmar_contraseña" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="confirmar_contraseña" name="confirmar_contraseña" placeholder="Confirme la contraseña" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>