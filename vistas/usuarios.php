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
            <table class="table table-hover table-striped table-bordered" id="tablaUsuarios">
                <thead class="table-primary">
                    <tr>
                        <th scope="col"><i class="bi bi-person-vcard me-2"></i>Nombre</th>
                        <th scope="col"><i class="bi bi-telephone-fill me-2"></i>Rol</th>
                        <th scope="col"><i class="bi bi-calendar-check me-2"></i>Contraseña</th>
                        <th scope="col" class="text-center"><i class="bi bi-gear-fill me-2"></i>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = $conexion->query("SELECT * FROM usuarios");
                    while ($dato = $sql->fetch_object()) { ?>
                        <tr>
                            <td><?php echo $dato->nombre; ?></td>
                            <td><?php echo $dato->id_rol; ?></td>
                            <td><?php echo $dato->contraseña; ?></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal<?= $dato->id_usu ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="../crud/eliminarusuario.php" method="POST" style="display:inline;" onsubmit="return confirmar();">
                                    <input type="hidden" name="id" value="<?= $dato->id_usu ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php include("../modales/modaleditarusuarios.php"); ?>

                    <?php } ?>
                </tbody>
            </table>
        </div>


    </div>
</main>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tablaUsuarios').DataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 25, 50, 100],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
    });
</script>

<?php include("../modales/modalUsuario.php"); ?>
<?php include("../plantillas/footer.php"); ?>