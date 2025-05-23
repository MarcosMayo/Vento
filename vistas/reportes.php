<?php
require '../logica/verificar_rol.php';
verificar_rol(['Administrador', 'Encargado']);
include("../plantillas/header.php");
include("../plantillas/menuu.php");
?>

<main class="p-3">
  <div class="container-fluid">
    <h3 class="text-center mb-4">Centro de Reportes</h3>

    <ul class="nav nav-tabs" id="tabsReportes" role="tablist">
      <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#clientesTab">Clientes</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#serviciosTab">Servicios</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#ordenesTab">Órdenes de Trabajo</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#ventasTab">Ventas</button></li>
    </ul>

    <div class="tab-content pt-3">

      <!-- CLIENTES -->
      <div class="tab-pane fade show active" id="clientesTab">
        <?php include("../componentes/reporte_clientes.php"); ?>
      </div>

      <!-- SERVICIOS -->
      <div class="tab-pane fade" id="serviciosTab">
        <?php include("../componentes/reportes_servicios.php"); ?>
      </div>

      <!-- ORDENES -->
      <div class="tab-pane fade" id="ordenesTab">
        <?php include("../componentes/reportes_ordenes.php"); ?>
      </div>

      <!-- VENTAS -->
      <div class="tab-pane fade" id="ventasTab">
        <?php include("../componentes/reportes_ventas.php"); ?>
      </div>

    </div>
  </div>
</main>

<?php include("../plantillas/footer.php"); ?>

