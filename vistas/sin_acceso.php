<?php
session_start();
?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
    <div class="container-fluid text-center">
        <h2 class="text-danger">Acceso Denegado</h2>
        <p class="fs-5">No tienes permisos suficientes para acceder a esta sección del sistema.</p>
        <a href="index.php" class="btn btn-primary mt-3">Volver al inicio</a>
    </div>
</main>

<?php include("../plantillas/footer.php"); ?>
