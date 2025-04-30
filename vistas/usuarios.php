<?php include("../logica/conexion.php"); ?>
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
            <!-- Formulario de búsqueda -->
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre...">
        <button class="btn btn-primary mt-2" onclick="loadData()">Buscar</button>


            <table class="table table-hover table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th scope="col"><i class="bi bi-person-vcard me-2"></i>Nombre</th>
                        <th scope="col"><i class="bi bi-telephone-fill me-2"></i>Rol</th>
                        <th scope="col"><i class="bi bi-calendar-check me-2"></i>Contraseña</th>
                        <th scope="col" class="text-center"><i class="bi bi-gear-fill me-2"></i>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaUsuarios">
                     <!-- Los resultados se mostrarán aquí -->

                    
                </tbody>
            </table>
            
        </div>

        <!-- Paginación -->
<nav>
    <ul class="pagination justify-content-center" id="paginacionUsuarios">
        <!-- Botones generados por JS -->
    </ul>
</nav>

<!-- Modal para editar usuario, único para cada usuario -->
<div class="modal fade" id="editarUsuarioModal<?= $dato->id_usu ?>" tabindex="-1" aria-labelledby="editarUsuarioModalLabel<?= $dato->id_usu ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editarUsuarioModalLabel<?= $dato->id_usu ?>">Editar usuario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario para editar usuario -->
                <form action="../crud/editarusuario.php" method="POST">
                    <input type="hidden" name="id" value="<?= $dato->id_usu ?>"> <!-- Campo oculto para el ID -->
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" name="nombre" value="<?= $dato->nombre ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <input type="text" class="form-control" name="rol" value="<?= $dato->id_rol ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="contraseña" class="form-label">Contraseña</label>
                        <input type="text" class="form-control" name="contraseña" value="<?= $dato->contraseña ?>" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



    </div>
</main>

<script src="../js/modales.js"></script>

<?php include("../modales/modalUsuario.php"); ?>
<?php include("../plantillas/footer.php"); ?>