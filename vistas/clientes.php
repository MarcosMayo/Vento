<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?><!-- Contenido principal -->
<main class="p-3">
    <div class="container-fluid">

        <!-- Título principal -->
        <h2 class="text-center mb-4">Clientes</h2>

        <!-- Botón para añadir nuevo cliente -->
        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarClienteModal">
                Nuevo cliente
            </button>
        </div>

        <!-- Tabla de clientes -->
        <div class="table-responsive">  
            <table class="table table-hover table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th scope="col"><i class="bi bi-person-vcard me-2"></i>Nombre</th>
                        <th scope="col"><i class="bi bi-person-vcard me-2"></i>Apellidos</th>
                        <th scope="col"><i class="bi bi-telephone-fill me-2"></i>Teléfono</th>
                        <th scope="col"><i class="bi bi-envelope-fill me-2"></i>Email</th>
                        <th scope="col"><i class="bi bi-calendar-check me-2"></i>Fecha de registro</th>
                        <th scope="col"><i class="bi bi-file-text me-2"></i>FOLIO</th>
                        <th scope="col" class="text-center"><i class="bi bi-gear-fill me-2"></i>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Juan</td>
                        <td>Pérez García</td>
                        <td>(555) 123-4567</td>
                        <td>juan.perez@example.com</td>
                        <td>15/03/2025</td>
                        <td>CLI-001</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>María</td>
                        <td>López Martínez</td>
                        <td>(555) 987-6543</td>
                        <td>maria.lopez@example.com</td>
                        <td>10/03/2025</td>
                        <td>CLI-002</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include("../modales/modalClientes.php"); ?>
<?php include("../plantillas/footer.php"); ?>