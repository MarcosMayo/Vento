<?php include("../logica/conexion.php"); ?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

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
                        <th scope="col"><i class="bi bi-file-text me-2"></i>FOLIO</th>
                        <th scope="col"><i class="bi bi-person-vcard me-2"></i>Nombre</th>
                        <th scope="col"><i class="bi bi-person-vcard me-2"></i>Apellido</th>
                        <th scope="col"><i class="bi bi-telephone-fill me-2"></i>Teléfono</th>
                        <th scope="col"><i class="bi bi-envelope-fill me-2"></i>Email</th>
                        <th scope="col" class="text-center"><i class="bi bi-gear-fill me-2"></i>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = $conexion->query("SELECT * FROM clientes");
                    while ($dato = $sql->fetch_object()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($dato->nombre); ?></td>
                            <td><?php echo htmlspecialchars($dato->apellidos); ?></td>
                            <td><?php echo htmlspecialchars($dato->telefono); ?></td>
                            <td><?php echo htmlspecialchars($dato->email); ?></td>
                            <td><?php echo htmlspecialchars($dato->fecha_registro); ?></td>
                            <td><?php echo htmlspecialchars($dato->folio); ?></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarClienteModal<?= $dato->id ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <?php include("../modales/modalEditarclient.php"); ?>

                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</main>



<?php include("../modales/modalClientes.php"); ?>
<?php include("../plantillas/footer.php"); ?>