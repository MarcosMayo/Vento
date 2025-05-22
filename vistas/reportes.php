<?php
require '../logica/verificar_rol.php';
verificar_rol(['Administrador', 'Encargado']);
include("../plantillas/header.php");
include("../plantillas/menuu.php");
?>

<main class="p-3">
  <div class="container-fluid">
    <h3 class="text-center mb-4">Reporte de Ventas Realizadas</h3>

    <div class="row mb-3">
      <div class="col-md-3">
        <label>Desde:</label>
        <input type="date" id="filtroDesde" class="form-control">
      </div>
      <div class="col-md-3">
        <label>Hasta:</label>
        <input type="date" id="filtroHasta" class="form-control">
      </div>
      <div class="col-md-4">
        <label>Cliente:</label>
        <input type="text" id="filtroCliente" class="form-control" placeholder="Nombre o apellido">
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button class="btn btn-primary w-100" onclick="filtrarVentas()">Buscar</button>
      </div>
    </div>

    <div id="tablaVentas"></div>
  </div>
</main>

<?php include("../plantillas/footer.php"); ?>
<script src="../js/reportes.js"></script>
