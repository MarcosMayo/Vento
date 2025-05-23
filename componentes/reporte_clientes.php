<!-- SUBTABS para reportes de clientes -->
<ul class="nav nav-pills mb-3" id="pills-clientes" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#frecuentes" type="button">Más frecuentes</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#conMotos" type="button">Con motocicletas</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#cancelaron" type="button">Cancelaron órdenes</button>
  </li>
</ul>

<div class="tab-content">
  <div class="tab-pane fade show active" id="frecuentes" role="tabpanel">
    <?php include("clientes_frecuentes.php"); ?>
  </div>
  <div class="tab-pane fade" id="conMotos" role="tabpanel">
    <?php include("clientes_motos.php"); ?>
  </div>
  <div class="tab-pane fade" id="cancelaron" role="tabpanel">
    <?php include("clientes_cancelaron.php"); ?>
  </div>
</div>
