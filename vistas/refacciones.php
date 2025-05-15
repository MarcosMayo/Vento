<?php include("../logica/conexion.php"); ?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
    <div class="container-fluid">
        <h2 class="text-center mb-4">Refacciones</h2>

        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarRefaccionModal">
                Nueva Refacción
            </button>
        </div>

        <!-- Tabla de Refacciones - Corregida -->
        <div class="table-responsive">
            <input type="text" id="searchInputRefacciones" class="form-control mb-2" placeholder="Buscar por nombre...">

            <table class="table table-hover table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Stock</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaRefacciones">


                </tbody>
            </table>
            <nav>
                <ul class="pagination" id="paginacionRefacciones"></ul>
            </nav>
        </div>

        <!-- Modal Agregar Refacción - Corregido -->
        <div class="modal fade" id="agregarRefaccionModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Nueva Refacción</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="formAgregarRefaccion">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nombre_refaccion" class="form-label">Nombre</label>
                                <input type="text" name="nombre_refaccion" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio ($)</label>
                                <input type="number" name="precio" step="0.01" min="0.01" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" name="stock" min="0" class="form-control" required>
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
        <!-- Modal Editar Refacción -->
        <div class="modal fade" id="editarRefaccionModal" tabindex="-1" aria-labelledby="editarRefaccionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formEditarRefaccion">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarRefaccionModalLabel">Editar Refacción</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id_refaccion" id="editarIdRefaccion">
                            <div class="mb-3">
                                <label for="editarNombreRefaccion" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="editarNombreRefaccion" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="editarPrecioRefaccion" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="editarPrecioRefaccion" name="precio" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="editarStockRefaccion" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="editarStockRefaccion" name="stock" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/refacciones.js"></script>
<script src="../js/refacion.js"></script>
<?php include("../plantillas/footer.php"); ?>