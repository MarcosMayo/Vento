<?php include("../logica/conexion.php"); ?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
    <div class="container-fluid">
        <h2 class="text-center mb-4">Gestión de Tipos de Servicios</h2>

        <div class="row">
            <!-- Columna formulario -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <strong>Agregar Servicio</strong>
                    </div>
                    <div class="card-body">
                        <form id="formServicio">
                            <div class="mb-3">
                                <label class="form-label">Nombre del Servicio</label>
                                <input type="text" class="form-control" name="nombre_servicio" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mano de Obra ($)</label>
                                <input type="number" class="form-control" name="mano_obra" id="manoObra" value="0" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="2" required></textarea>
                            </div>

                            <hr>
                            <h6 class="mb-3">Refacciones</h6>
                            <div class="table-responsive mb-3" style="max-height: 200px; overflow-y: auto;">
                                <table class="table table-sm table-bordered" id="tablaRefacciones">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th>Refacción</th>
                                            <th>Cant.</th>
                                            <th>Precio</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                            <button type="button" class="btn btn-outline-primary btn-sm mb-3" onclick="agregarFila()">+ Agregar Refacción</button>

                            <div class="mb-3">
                                <p><strong>Total Refacciones:</strong> $<span id="totalRefacciones">0.00</span></p>
                                <p><strong>Total Servicio:</strong> $<span id="totalServicio">0.00</span></p>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Guardar Servicio</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Columna tabla -->
            <div class="col-lg-6">
                <div class="card h-100 shadow-sm">
                    <div class=" mb-1 card-header bg-dark text-white">
                        <strong>Servicios Registrados</strong>
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <input type="text" id="searchInputServicios" class="form-control " placeholder="Buscar servicio...">
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="tablaServicios">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBodyServicios">
                                <!-- Cargar con PHP o JS -->
                            </tbody>
                        </table>
                    </div>
                    <nav>
                        <ul class="pagination justify-content-center" id="paginacionServicios">
                            <!-- Paginación dinámica -->
                        </ul>
                    </nav>
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