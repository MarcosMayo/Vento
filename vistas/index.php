<?php require '../logica/verificar_rol.php';
verificar_rol(['Administrador', 'Empleado','Encargado']);
?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
  <div class="container-fluid">
    <h2 class="text-center">Bienvenido, <?= $_SESSION['usuario'] ?> (<?= $_SESSION['rol'] ?>)</h2>

    <!-- Tarjetas resumen -->
    <div class="row mt-4 g-4">
      <div class="col-md-4">
        <div class="card text-bg-warning shadow-sm h-100">
          <div class="card-body text-center">
            <h6 class="card-title">Órdenes Pendientes</h6>
            <h3 id="ordenesPendientes">0</h3>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="card text-bg-danger shadow-sm h-100">
          <div class="card-body text-center">
            <h6 class="card-title">Refacciones con bajo stock</h6>
            <h3 id="stockBajo">0</h3>
            <ul id="listaStockBajo" class="mt-3 small text-start" style="padding-left: 1rem;"></ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Módulos según rol -->
    <div class="row mt-5">
      <?php if ($_SESSION['rol'] === 'Administrador'): ?>
        <div class="col-md-4">
          <div class="card shadow-sm h-100">
            <div class="card-body text-center">
              <h5 class="card-title">Usuarios</h5>
              <p class="card-text">Administra todos los usuarios del sistema.</p>
              <a href="usuarios.php" class="btn btn-primary">Ver usuarios</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow-sm h-100">
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
          <div class="card shadow-sm h-100">
            <div class="card-body text-center">
              <h5 class="card-title">Servicios</h5>
              <p class="card-text">Gestiona servicios y refacciones.</p>
              <a href="servicios.php" class="btn btn-primary">Ir a servicios</a>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <div class="col-md-4">
        <div class="card shadow-sm h-100">
          <div class="card-body text-center">
            <h5 class="card-title">Órdenes de trabajo</h5>
            <p class="card-text">Consulta y administra órdenes asignadas.</p>
            <a href="ordenes.php" class="btn btn-primary">Ver órdenes</a>
          </div>
        </div>
      </div>

      <div class="col-md-4 mt-4">
        <div class="card shadow-sm border-danger h-100">
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

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/cambiar_password.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    fetch('../logica/datos_dashboard.php')
      .then(res => res.json())
      .then(data => {
        document.getElementById('ordenesPendientes').textContent = data.ordenes_pendientes;
        document.getElementById('stockBajo').textContent = data.stock_bajo;

        const lista = document.getElementById('listaStockBajo');
        lista.innerHTML = '';
        data.refacciones_bajas.forEach(ref => {
          const li = document.createElement('li');
          li.textContent = `${ref.nombre} (${ref.stock})`;
          lista.appendChild(li);
        });
      });
  });
</script>

<?php include("../modales/usuarios_modales.php"); ?>
<?php include("../plantillas/footer.php"); ?>
