<?php require '../logica/verificar_rol.php';
verificar_rol(['Administrador', 'Empleado']); ?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
  <div class="container-fluid">
    <h2 class="text-center mb-4">Órdenes de Trabajo</h2>

    <div class="row mb-3">
      <div class="col-md-3">
        <select id="filtroEstatus" class="form-select">
          <option value="">Todos los estatus</option>
          <option value="1">Pendiente</option>
          <option value="2">Cancelado</option>
          <option value="3">Terminado</option>
        </select>
      </div>
      <div class="col-md-3">
        <input type="date" id="fechaDesde" class="form-control" placeholder="Desde">
      </div>
      <div class="col-md-3">
        <input type="date" id="fechaHasta" class="form-control" placeholder="Hasta">
      </div>
      <div class="col-md-3">
        <input type="text" id="buscarOrdenes" class="form-control" placeholder="Buscar por cliente, moto, servicio...">
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead class="table-dark">
          <tr>
            <th>Cliente</th>
            <th>Motocicleta</th>
            <th>Servicio</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Estatus</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="tablaBodyOrdenes"></tbody>
      </table>
    </div>

    <nav>
      <ul class="pagination justify-content-center" id="paginacionOrdenes"></ul>
    </nav>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/ordenes_paginadas.js"></script>
<?php include("../plantillas/footer.php"); ?>
