<?php require '../logica/verificar_rol.php';
verificar_rol(['Administrador', 'Empleado']);
?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
    <div class="container-fluid">
        <h2 class="text-center mb-4">Gestión de Servicios</h2>

        <div class="row">
            <!-- Columna: Agregar nuevo servicio -->
            <div class="col-md-6">
                <h4>Agregar Servicio</h4>
                <form id="formAgregarServicio">
                    <div class="mb-3">
                        <label for="nombreServicio" class="form-label">Nombre del servicio</label>
                        <input type="text" class="form-control" id="nombreServicio" name="nombre_servicio" required>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="manoObra" class="form-label">Mano de obra ($)</label>
                        <input type="number" class="form-control" id="manoObra" name="mano_obra" min="0" step="0.01" value="0" required>
                    </div>

                    <h5>Refacciones</h5>
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered" id="tablaRefaccionesAgregar">
                            <thead>
                                <tr>
                                    <th>Refacción</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyRefaccionesAgregar">
                                <!-- Se agregan dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-secondary mb-3" onclick="agregarFilaAgregar()">+ Refacción</button>

                    <div class="mb-3">
                        <strong>Total Refacciones: $<span id="totalRefaccionesAgregar">0.00</span></strong><br>
                        <strong>Total Servicio: $<span id="totalServicioAgregar">0.00</span></strong>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar Servicio</button>
                </form>
            </div>

            <!-- Columna: Lista de Servicios -->
            <div class="col-md-6">
                <h4>Servicios Registrados</h4>
                <input type="text" class="form-control mb-2" placeholder="Buscar servicio..." id="searchInputServicios">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered" id="tablaServicios">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Refacciones incluidas</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBodyServicios">
                            <!-- Servicios cargados desde el backend -->
                        </tbody>
                    </table>
                </div>
                <nav>
                    <ul class="pagination justify-content-center" id="paginacionServicios"></ul>
                </nav>
            </div>
        </div>
    </div>
</main>
<!-- Modal para editar servicio -->
<div class="modal fade" id="editarServicioModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Servicio</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formEditarServicio">
          <input type="hidden" name="id_servicio" id="idServicioEditar">

          <div class="mb-3">
            <label class="form-label">Nombre del servicio</label>
            <input type="text" class="form-control" name="nombre_servicio" id="nombreServicioEditar" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" id="descripcionEditar" rows="3" required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Mano de obra ($)</label>
            <input type="number" class="form-control" name="mano_obra" id="manoObraEditar" min="0" step="0.01" required>
          </div>

          <h5>Refacciones</h5>
          <div class="table-responsive mb-3">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Refacción</th>
                  <th>Cantidad</th>
                  <th>Precio</th>
                  <th>Subtotal</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody id="tablaRefaccionesEditar">
                <!-- Se llenan con JS -->
              </tbody>
            </table>
          </div>
          <button type="button" class="btn btn-secondary mb-3" onclick="agregarFilaEditar()">+ Refacción</button>

          <div class="mb-3">
            <strong>Total Refacciones: $<span id="totalRefaccionesEditar">0.00</span></strong><br>
            <strong>Total Servicio: $<span id="totalServicioEditar">0.00</span></strong>
          </div>

          <div class="text-end">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/servicios.js"></script>
<script src="../js/editar_servicio.js"></script>
<script src="../js/autocomRef.js"></script>
<script src="../js/servicios_paginacion.js"></script>
<script src="../js/guardar_edicion_servicio.js"></script>
<script src="../js/agregar_fila_editar.js"></script>
<script src="../js/eliminar_servicio.js"></script>
<?php include("../plantillas/footer.php"); ?>
