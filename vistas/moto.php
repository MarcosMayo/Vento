<?php include("../logica/conexion.php"); ?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
    <div class="container-fluid">

        <!-- Título principal -->
        <h2 class="text-center mb-4">Motos</h2>

      
        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarMotoModal">
                Nueva moto
            </button>
        </div>

        <!-- Tabla de motos -->
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered" id="tablaMotos">
                <thead class="table-primary">
                    <tr>
                        <th scope="col"><i class="bi bi-bicycle me-2"></i>Marca</th>
                        <th scope="col"><i class="bi bi-bicycle me-2"></i>Modelo</th>
                        <th scope="col"><i class="bi bi-calendar me-2"></i>Año</th>
                        <th scope="col"><i class="bi bi-list-columns-reverse me-2"></i>Historial de servicios</th>
                        <th scope="col"><i class="bi bi-chat-left-text me-2"></i>Observaciones</th>
                        <th scope="col" class="text-center"><i class="bi bi-gear-fill me-2"></i>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = $conexion->query("SELECT * FROM motos");
                    while ($dato = $sql->fetch_object()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($dato->marca); ?></td>
                            <td><?php echo htmlspecialchars($dato->modelo); ?></td>
                            <td><?php echo htmlspecialchars($dato->anio); ?></td>
                            <td><?php echo htmlspecialchars($dato->historial_servicios); ?></td>
                            <td><?php echo htmlspecialchars($dato->observaciones); ?></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editarMotoModal<?= $dato->id ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>  
</main>


<?php include("../plantillas/footer.php"); ?>
