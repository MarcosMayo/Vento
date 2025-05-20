<?php require '../logica/verificar_rol.php';
verificar_rol(['Administrador', 'Empleado','Encargado']); // To todos pueden ver esta vista
?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
    <div class="container-fluid">
        <h2 class="text-center">Bienvenido, <?= $_SESSION['usuario'] ?> (<?= $_SESSION['rol'] ?>)</h2>
        
        <div class="row mt-4">

            <?php if ($_SESSION['rol'] === 'Administrador'): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Usuarios</h5>
                            <p class="card-text">Administra todos los usuarios del sistema.</p>
                            <a href="usuarios.php" class="btn btn-primary">Ver usuarios</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Ventas</h5>
                            <p class="card-text">Revisa el historial de ventas registradas.</p>
                            <a href="ventas.php" class="btn btn-primary">Ver ventas</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (in_array($_SESSION['rol'], ['Administrador', 'Encargado'])): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Servicios</h5>
                            <p class="card-text">Gestiona servicios y refacciones.</p>
                            <a href="servicios.php" class="btn btn-primary">Ir a servicios</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title">Órdenes de trabajo</h5>
                        <p class="card-text">Consulta y administra órdenes asignadas.</p>
                        <a href="ordenes.php" class="btn btn-primary">Ver órdenes</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-4">
                <div class="card shadow-sm border-danger">
                    <div class="card-body text-center">
                        <h5 class="card-title text-danger">Cambiar contraseña</h5>
                        <p class="card-text">Actualiza tu contraseña personal de forma segura.</p>
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalCambiarPassword">
                            Cambiar contraseña
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php include("../modales/usuarios_modales.php"); ?>
<script src="../js/cambiar_password.js"></script>



<?php include("../plantillas/footer.php"); ?>
