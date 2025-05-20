<!-- Modal: Agregar Usuario -->
<div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formAgregarUsuario" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="nombre" class="form-control mb-3" placeholder="Nombre" required>
        <select name="id_rol" class="form-select mb-3" required>
          <option value="">Selecciona un rol</option>
          <option value="2">Encargado</option>
          <option value="3">Empleado</option>
        </select>
        <input type="password" name="pass" class="form-control mb-3" placeholder="Contraseña" required>
<input type="password" name="confirmar" class="form-control" placeholder="Confirmar contraseña" required>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Editar Usuario -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formEditarUsuario" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="editarId">
        <input type="text" name="nombre" id="editarNombre" class="form-control mb-3" placeholder="Nombre" required>
        <select name="id_rol" id="editarRol" class="form-select" required>
          <option value="2">Encargado</option>
          <option value="3">Empleado</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Cambiar Contraseña (personal) -->
<div class="modal fade" id="modalCambiarPassword" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formCambiarPassword" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cambiar Contraseña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="password" name="actual" class="form-control mb-3" placeholder="Contraseña actual" required>
        <input type="password" name="nueva" class="form-control mb-3" placeholder="Nueva contraseña" required>
        <input type="password" name="confirmar" class="form-control" placeholder="Confirmar nueva contraseña" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-warning">Cambiar</button>
      </div>
    </form>
  </div>
</div>
