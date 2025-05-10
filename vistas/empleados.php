<?php include("../logica/conexion.php"); ?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
    <div class="container-fluid">
        <h2 class="text-center mb-4">Empleados</h2>

        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarEmpleadoModal">
                Nuevo Empleado
            </button>
        </div>

        <div class="table-responsive">
            <input type="text" id="searchInputEmpleados" class="form-control mb-2" placeholder="Buscar por nombre...">
            <table class="table table-hover table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido Paterno</th>
                        <th scope="col">Apellido Materno</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Puesto</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaEmpleados"></tbody>
            </table>
            <nav>
                <ul class="pagination" id="paginacionEmpleados"></ul>
            </nav>
        </div>

        <!-- Modal Agregar Empleado -->
        <div class="modal fade" id="agregarEmpleadoModal" tabindex="-1" aria-labelledby="agregarEmpleadoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Agregar Empleado</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregarEmpleado">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido_materno" class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <textarea class="form-control" id="direccion" name="direccion" rows="1" required></textarea>
                            </div>
                            <div class="mb-3">
                        <label for="editar_id_puesto" class="form-label">Puesto</label>
                        <select class="form-select" id="editar_id_puesto" name="id_puesto" required>
                            <option selected>Seleccione</option>
                            <option value="1">Mecanico</option>
                            <!-- Opciones dinámicas -->
                        </select>
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

        <!-- Modal Editar Empleado -->
<div class="modal fade" id="editarEmpleadoModal" tabindex="-1" aria-labelledby="editarEmpleadoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Editar Empleado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarEmpleado">
                    <input type="hidden" id="editar_id_empleado" name="id_empleado">
                    <div class="mb-3">
                        <label for="editar_nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editar_nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_apellido_paterno" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control" id="editar_apellido_paterno" name="apellido_paterno" required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_apellido_materno" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" id="editar_apellido_materno" name="apellido_materno" required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="editar_telefono" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_correo" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="editar_correo" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="editar_direccion" name="direccion" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editar_id_puesto" class="form-label">Puesto</label>
                        <select class="form-select" id="editar_id_puesto" name="id_puesto" required>
                            
                            <option value="1">Mecanico</option>
                            <!-- Opciones dinámicas -->
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/guaremp.js"></script>
<script src="../js/editemp.js"></script>
<script src="../js/eliemp.js"></script>
<script src="../js/empleados.js"></script>
<?php include("../plantillas/footer.php"); ?>
