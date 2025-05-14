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
                    <?php
                    $query = "SELECT * FROM refacciones";
                    $result = mysqli_query($conexion, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id_refaccion'] . "</td>";
                            echo "<td>" . htmlspecialchars($row['nombre_refaccion']) . "</td>";
                            echo "<td>$" . number_format($row['precio'], 2) . "</td>";
                            echo "<td>" . $row['stock'] . "</td>";
                            echo "<td class='text-center'>
    <button class='btn btn-warning btn-sm btn-editar' 
        data-id='" . $row['id_refaccion'] . "'
        data-nombre='" . htmlspecialchars($row['nombre_refaccion']) . "'
        data-precio='" . $row['precio'] . "'
        data-stock='" . $row['stock'] . "'>
        Editar  
    </button>
    <button class='btn btn-danger btn-sm btn-eliminar' 
        data-id='" . $row['id_refaccion'] . "'>
        Eliminar
    </button>
</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No hay refacciones registradas.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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
        <div class="modal fade" id="editarRefaccionModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title">Editar Refacción</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="formEditarRefaccion">
                        <div class="modal-body">
                            <input type="hidden" name="id_refaccion" id="editar_id_refaccion">
                            <div class="mb-3">
                                <label for="editar_nombre_refaccion" class="form-label">Nombre</label>
                                <input type="text" name="nombre_refaccion" id="editar_nombre_refaccion" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="editar_precio" class="form-label">Precio ($)</label>
                                <input type="number" name="precio" step="0.01" min="0.01" id="editar_precio" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="editar_stock" class="form-label">Stock</label>
                                <input type="number" name="stock" min="0" id="editar_stock" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-warning">Actualizar</button>
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