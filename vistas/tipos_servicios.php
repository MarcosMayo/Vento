<?php include("../logica/conexion.php"); ?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
    <div class="container-fluid">
        <h2 class="text-center mb-4">Gestión de Tipos de Servicios</h2>

        <div class="row">
            <div class="container mt-4">
                <div class="row">
                    <!-- Columna: Agregar Servicio -->
                    <div class="col-md-6">
                        <h4>Agregar Servicio</h4>
                        <form id="formServicio">

                            <div class="mb-3">
                                <label>Nombre del servicio</label>
                                <input type="text" class="form-control" name="nombre_servicio" required>
                            </div>
                            <div class="mb-3">
                                <label>Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Mano de obra ($)</label>

                                <input type="number" class="form-control" name="mano_obra" id="manoObra" min="0" step="0.01" value="0" required>

                            </div>

                            <h5>Refacciones</h5>
                            <table class="table table-bordered" id="tablaRefacciones">
                                <thead>
                                    <tr>
                                        <th>Refacción</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                            <button type="button" class="btn btn-secondary mb-3" onclick="agregarFila()">+ Refacción</button>

                            <div class="mb-3">
                                <strong>Total Refacciones: $<span id="totalRefacciones">0.00</span></strong><br>
                                <strong>Total: $<span id="totalServicio">0.00</span></strong>

                            </div>

                            <button type="submit" class="btn btn-primary">Guardar Servicio</button>
                        </form>
                    </div>

                    <!-- Columna: Lista de Servicios -->
                    <div class="col-md-6">
                    <div div class="table-responsive">>
<h4>Servicios Registrados</h4>
                        <!-- Buscador -->
                        <input type="text" class="form-control mb-2" placeholder="Buscar servicio..." id="searchInputServicios">
                        <table class="table table-hover table-striped table-bordered" id="tablaServicios">
                            <thead>
                                <tr>

                                    <th>Nombre</th>
                                    <th>descripcion</th>
                                    <th>Refacciones</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyServicios">
                                <!-- Servicios cargados desde el backend -->
                            </tbody>
                        </table>
                        <nav>

                            <!-- Paginación -->
                            <ul class="pagination justify-content-center" id="paginacionServicios"></ul>

                        </nav>
                    </div>
                        
                    </div>
                </div>
            </div>


            <!-- Modal de Edición -->
<div class="modal fade" id="editarServicioModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Encabezado -->
      <div class="modal-header">
        <h5 class="modal-title">Editar Servicio</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <!-- Cuerpo -->
      <div class="modal-body">
        <form id="formEditarServicio">

          <!-- ID oculto para edición -->
          <input type="hidden" name="id_servicio" id="idServicioEditar">

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="nombreServicioEditar" class="form-label">Nombre del servicio</label>
                <input type="text" class="form-control" name="nombre_servicio" id="nombreServicioEditar" required>
              </div>
              <div class="mb-3">
                <label for="descripcionEditar" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" id="descripcionEditar" rows="3" required></textarea>
              </div>
              <div class="mb-3">
                <label for="manoObraEditar" class="form-label">Mano de obra ($)</label>
                <input type="number" class="form-control" name="mano_obra" id="manoObraEditar" min="0" step="0.01" value="0" required>
              </div>
            </div>

            <!-- Tabla de refacciones -->
            <div class="col-md-6">
              <h5>Refacciones</h5>
              <div class="table-responsive mb-3">
                <table class="table table-hover table-striped table-bordered" id="tablaRefacciones">
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

                  </tbody>
                </table>
              </div>

              <button type="button" class="btn btn-secondary mb-3" onclick="agregarFilaEditar()">+ Refacción</button>

              <div class="mb-3">
                <strong>Total Refacciones: $<span id="totalRefaccionesEditar">0.00</span></strong><br>
                <strong>Total: $<span id="totalServicioEditar">0.00</span></strong>
              </div>
            </div>
          </div>

          <!-- Botón guardar -->
          <div class="text-end">
            <button type="submit" class="btn btn-primary">Guardar Servicio</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>



            
        </div>
    </div>
</main>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/guarserv.js"></script>
<script src="../js/servicios.js"></script>
<script src="../js/autocomRef.js"></script>
<?php include("../plantillas/footer.php"); ?>