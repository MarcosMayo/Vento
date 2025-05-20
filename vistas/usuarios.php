<?php
require '../logica/verificar_rol.php';
verificar_rol(['Administrador']);
?>

<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>


<main class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Gestión de Usuarios</h3>
    <div>
        <button class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#modalCambiarPassword">
            Cambiar contraseña
        </button>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal">
            Agregar Usuario
        </button>
    </div>
</div>

    

    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar usuarios...">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Contraseña</th> <!-- Se puede ocultar luego -->
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="tablaUsuarios"></tbody>
    </table>

    <ul class="pagination justify-content-center" id="paginacionUsuarios"></ul>
</main>

<!-- Modales -->
<?php include("../modales/usuarios_modales.php"); ?>

<!-- Scripts -->
 <script>
  const idUsuarioActual = <?= $_SESSION['id_usuario'] ?>;
</script>

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/usuarios.js"></script>
<script src="../js/guarus.js"></script>
<script src="../js/editusu.js"></script>
<script src="../js/eliusu.js"></script>
<script src="../js/cambiar_password.js"></script>

<?php include("../plantillas/footer.php"); ?>
