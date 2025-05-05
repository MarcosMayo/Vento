<?php include("../logica/conexion.php"); ?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
    <div class="container-fluid">
        <h2 class="text-center mb-4">Órdenes de Trabajo</h2>

        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarOrdenModal">
                Nueva Orden de Trabajo
            </button>
        </div>

        <div class="table-responsive">
            <input type="text" id="searchInputOrdenes" class="form-control" placeholder="Buscar por folio...">
            <table class="table table-hover table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Folio</th>
                        <th scope="col">Mecánico</th>
                        <th scope="col">Motocicleta</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Descripción</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaOrdenes"></tbody>
            </table>
            <nav class="mt-3">
                <ul class="pagination" id="paginacionOrdenes"></ul>
            </nav>
        </div>

        <!-- Modal Agregar Orden -->
        <div class="modal fade" id="agregarOrdenModal" tabindex="-1" aria-labelledby="agregarOrdenModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Nueva Orden de Trabajo</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregarOrden">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="mecanico" class="form-label">Mecánico</label>
                                    <select id="mecanico" name="mecanico" class="form-select" required>
                                        <!-- Opciones de mecánico se llenarán dinámicamente -->
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="motocicleta" class="form-label">Motocicleta (Folio)</label>
                                    <select id="motocicleta" name="motocicleta" class="form-select" required>
                                        <!-- Opciones de motocicleta se llenarán dinámicamente -->
                                    </select>
                                </div>

                                <!-- Nuevo campo para seleccionar el servicio -->
                                <div class="col-md-6">
                                    <label for="tipo_servicio" class="form-label">Servicio</label>
                                    <select id="tipo_servicio" name="tipo_servicio" class="form-select" required>
                                        <option value="">Seleccione un servicio</option>
                                    </select>
                                </div>

                                <!-- Descripción dinámica del servicio -->
                                <div class="col-md-6">
                                    <label class="form-label">Descripción del servicio</label>
                                    <div id="descripcion_servicio" class="border rounded p-2" style="min-height: 90px; background-color: #f8f9fa;">
                                        Seleccione un servicio para ver su descripción.
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label for="descripcion" class="form-label">Descripción adicional</label>
                                    <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Orden -->
        <div class="modal fade" id="editarOrdenModal" tabindex="-1" aria-labelledby="editarOrdenModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Editar Orden</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarOrden">
                            <input type="hidden" id="editarIdOrden" name="id_orden">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="editarMecanico" class="form-label">Mecánico</label>
                                    <select id="editarMecanico" name="mecanico" class="form-select" required></select>
                                </div>
                                <div class="col-md-6">
                                    <label for="editarMotocicleta" class="form-label">Motocicleta</label>
                                    <select id="editarMotocicleta" name="motocicleta" class="form-select" required></select>
                                </div>
                                <div class="col-md-12">
                                    <label for="editarDescripcion" class="form-label">Descripción</label>
                                    <textarea id="editarDescripcion" name="descripcion" class="form-control" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary" id="btnConfirmarEdicionOrden">Confirmar edición</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/ordenes.js"></script>
<?php include("../plantillas/footer.php"); ?>
