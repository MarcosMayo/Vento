<?php require '../logica/verificar_rol.php';
verificar_rol(['Administrador', 'Empleado']); // Solo administradores o empleados
?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
    <div class="container-fluid">
        <h2 class="text-center mb-4">Crear Orden de Trabajo</h2>

        <form id="formOrdenTrabajo">
            <div class="row g-3">

                <!-- MOTOCICLETA -->
                <div class="col-md-6">
                    <label for="motocicleta" class="form-label">Motocicleta</label>
                    <select id="motocicleta" name="motocicleta" style="width: 100%"> </select>
                    <!-- Motocicleta se llenan con JS -->

                </div>

                <!-- SERVICIO -->
                <div class="col-md-6">
                    <label for="servicio" class="form-label">Servicio</label>
                    <select id="servicio" name="servicio" class="form-select" style="width: 100%;" required></select>
                </div>


                <!-- EMPLEADO -->
                <div class="col-md-6">
                    <label for="empleado" class="form-label">Empleado asignado</label>
                    <select id="empleado" name="empleado" style="width: 100%;"></select>


                    <!-- Opciones se llenan con JS -->

                </div>


                <!-- FECHA -->
                <div class="col-md-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" id="fecha" name="fecha" class="form-control" readonly>
                </div>

                <!-- ESTATUS -->
                <div class="col-md-3">
                    <label for="estatus" class="form-label">Estatus</label>
                    <select id="estatus" name="estatus" class="form-select" required>
                        <option value="1" selected>Pendiente</option>
                        <option value="2">Cancelado</option>
                        <option value="3">Terminado</option>
                        
                    </select>
                </div>

            </div>

            <hr class="my-4">

            <h5>Refacciones incluidas</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" id="tablaRefacciones">
                    <thead class="table-light">
                        <tr>
                            <th>Refacción</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyRefacciones">
                        <!-- Filas dinámicas -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total:</td>
                            <td id="totalRefaccionesTabla">$0.00</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mb-3 text-end">
                <button type="button" class="btn btn-success" id="btnAgregarRefaccion">Agregar Refacción</button>
            </div>

            <div class="row my-4">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Mano de Obra Estimada:</label>
                    <div class="form-control bg-light" id="manoObraVisual">$0.00</div>
                </div>

                <!-- Donde se muestra el total de la orden (refacciones) -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Subtotal Refacciones:</label>
                    <div class="form-control bg-light" id="totalRefaccionesVisual">$0.00</div>
                </div>

                <!-- Total final (refacciones + mano de obra) -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Total Final:</label>
                    <div class="form-control bg-light" id="totalFinal">$0.00</div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Guardar Orden</button>
            </div>


        </form>
    </div>
</main>

<?php include("../plantillas/footer.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/guarorden.js"></script>
<script src="../js/busquedasorden.js"></script>
<script src="../js/orden_trabajo.js"></script>