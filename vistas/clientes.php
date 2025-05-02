<?php include("../logica/conexion.php"); ?>
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
            <!-- Formulario de búsqueda -->
            <input type="text" id="searchInputClientes" class="form-control" placeholder="Buscar por nombre...">
            <table class="table table-hover table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th scope="col"><i class="bi bi-file-text me-2"></i>Folio</th>
                        <th scope="col"><i class="bi bi-person-vcard me-2"></i>Nombre</th>
                        <th scope="col"><i class="bi bi-person-vcard me-2"></i>Apellido</th>
                        <th scope="col"><i class="bi bi-person-vcard me-2"></i>Materno</th>
                        <th scope="col"><i class="bi bi-telephone-fill me-2"></i>Teléfono</th>
                        <th scope="col"><i class="bi bi-envelope-fill me-2"></i>Email</th>
                        <th scope="col"><i class="bi bi-calendar-check me-2"></i>Direccion</th>   
                        <th scope="col" class="text-center"><i class="bi bi-gear-fill me-2"></i>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaClientes">
                
                </tbody>
            </table>
             <!-- Paginación -->
             <nav class="mt-3">
                <ul class="pagination" id="paginacionClientes">
                    <!-- Botones generados por JS -->
                </ul>
            </nav>
        </div>
       <!-- Modal para editar cliente -->
<div class="modal fade" id="editarClienteModal" tabindex="-1" aria-labelledby="editarClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editarClienteModalLabel">Editar Cliente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarCliente">
                    <input type="hidden" name="id_cliente" id="editarIdCliente">
                    
                    <div class="row g-3">
                        <!-- Folio (solo lectura) -->
                        <div class="col-md-6">
                            <label for="folioEdit" class="form-label">Folio</label>
                            <input type="text" class="form-control" id="folioEdit" name="folio" readonly>
                        </div>

                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label for="nombreEdit" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="editarNombreCliente" name="nombre" required>
                        </div>

                        <!-- Apellido Paterno -->
                        <div class="col-md-6">
                            <label for="apellido_pEdit" class="form-label">Apellido Paterno</label>
                            <input type="text" class="form-control" id="editarApellidoPCliente" name="apellido_p" required>
                        </div>

                        <!-- Apellido Materno -->
                        <div class="col-md-6">
                            <label for="apellido_mEdit" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="editarApellidoMCliente" name="apellido_m">
                        </div>

                        <!-- Teléfono -->
                        <div class="col-md-6">
                            <label for="telefonoEdit" class="form-label">Número telefónico</label>
                            <input type="tel" class="form-control" id="editarTelefonoCliente" name="telefono">
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="emailEdit" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editarEmailCliente" name="email">
                        </div>

                        <!-- Dirección -->
                        <div class="col-md-6">
                            <label for="direccionEdit" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="editarDireccionCliente" name="direccion" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnConfirmarEdicion">Confirmar edición</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    </div>
</main>

<script src="../js/editclientes.js"></script>
<script src="../js/pagclientes.js"></script>
<?php include("../modales/modalClientes.php"); ?>
<?php include("../plantillas/footer.php"); ?>