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
            <table class="table table-hover table-striped table-bordered" id="tablaClientes">
                <thead class="table-primary">
                    <tr>
                        <th scope="col"><i class="bi bi-file-text me-2"></i>Folio</th>
                        <th scope="col"><i class="bi bi-person-vcard me-2"></i>Nombre</th>
                        <th scope="col"><i class="bi bi-person-vcard me-2"></i>Apellido</th>
                        <th scope="col"><i class="bi bi-telephone-fill me-2"></i>Teléfono</th>
                        <th scope="col"><i class="bi bi-envelope-fill me-2"></i>Email</th>
                        <th scope="col"><i class="bi bi-calendar-check me-2"></i>Direccion</th>   
                        <th scope="col" class="text-center"><i class="bi bi-gear-fill me-2"></i>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql = $conexion->query("SELECT * FROM clientes");
                    while ($dato = $sql->fetch_object()) { ?>
                        <tr>
                            <td><?php echo $dato->folio; ?></td>
                            <td><?php echo $dato->nombre; ?></td>
                            <td><?php echo $dato->apellido_paterno; ?></td>
                            <td><?php echo $dato->telefono; ?></td>
                            <td><?php echo $dato->correo; ?></td>
                            <td><?php echo $dato->direccion; ?></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarClienteModal<?= $dato->id_cliente ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="#" method="POST" style="display:inline;" onsubmit="return confirmar();">
                                    <input type="hidden" name="id" value="<?= $dato->id_cliente ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php include("../modales/modaleditarclientes.php"); ?>

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
        $('#tablaClientes').DataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 25, 50, 100],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
    });
</script>

<?php include("../modales/modalClientes.php"); ?>
<?php include("../plantillas/footer.php"); ?>