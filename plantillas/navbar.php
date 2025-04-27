<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
    <div class="container-fluid">

        <!-- Título principal -->
        <h2 class="text-center mb-4">Usuarios</h2>

        <!-- Botón para añadir nuevo usuario -->
        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal">
                Nuevo usuario
            </button>
        </div>

        <!-- Tabla de usuarios -->
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Fecha de ingreso</th>
                        <th scope="col">Email</th>
                        <th scope="col" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Jose Lopez</td>
                        <td>(414) 907-1274</td>
                        <td>05/03/2025</td>
                        <td>Jose@gmail.com</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Karen Torres</td>
                        <td>(240) 480-4277</td>
                        <td>02/03/2025</td>
                        <td>Karen@gmail.com</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Eduardo Olan</td>
                        <td>(318) 698-9889</td>
                        <td>01/03/2025</td>
                        <td>Eduardo@gmail.com</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal para agregar usuario -->
        <div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="agregarUsuarioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="agregarUsuarioModalLabel">Agregar nuevo usuario</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Nombre Apellido">
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" placeholder="(000) 000-0000">
                            </div>
                            <div class="mb-3">
                                <label for="fechaIngreso" class="form-label">Fecha de ingreso</label>
                                <input type="date" class="form-control" id="fechaIngreso">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" placeholder="correo@example.com">
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php include("../plantillas/footer.php"); ?>
