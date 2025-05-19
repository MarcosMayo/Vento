<?php require '../logica/verificar_rol.php';
verificar_rol(['Administrador', 'Empleado']); ?>
<?php include("../plantillas/header.php"); ?>
<?php include("../plantillas/menuu.php"); ?>

<main class="p-3">
  <div class="container-fluid">
    <h2 class="text-center mb-4">Módulo de Ventas</h2>

    <ul class="nav nav-tabs mb-3" id="ventasTab" role="tablist">
      <li class="nav-item">
        <button class="nav-link active" id="ventaOrden-tab" data-bs-toggle="tab" data-bs-target="#ventaOrden" type="button" role="tab">Desde Orden de Trabajo</button>
      </li>
      <li class="nav-item">
        <button class="nav-link" id="ventaDirecta-tab" data-bs-toggle="tab" data-bs-target="#ventaDirecta" type="button" role="tab">Venta Directa</button>
      </li>
    </ul>

    <div class="tab-content" id="ventasTabContent">

      <!-- VENTA DESDE ORDEN -->
      <div class="tab-pane fade show active" id="ventaOrden" role="tabpanel">
        <div class="mb-3">
          <label for="ordenSeleccion" class="form-label">Seleccionar orden pendiente</label>
          <select id="ordenSeleccion" class="form-select"></select>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Refacción</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody id="tablaOrdenRefacciones"></tbody>
          </table>
        </div>

        <div class="text-end">
          <strong>Total: $<span id="totalOrden">0.00</span></strong>
        </div>

        <div class="text-end mt-3">
          <button class="btn btn-success" id="btnGuardarVentaOrden">Registrar venta</button>
        </div>
      </div>

      <!-- VENTA DIRECTA -->
      <div class="tab-pane fade" id="ventaDirecta" role="tabpanel">
        <div class="mb-3">
          <label for="clienteVenta" class="form-label">Cliente</label>
          <input type="text" class="form-control" id="clienteVenta" placeholder="Público en general">
          <input type="hidden" id="clienteVentaId" value="38">
        </div>

        <div class="mb-3">
          <button class="btn btn-secondary" onclick="agregarFilaVentaDirecta()">+ Refacción</button>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Refacción</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tbody id="tablaVentaDirecta"></tbody>
          </table>
        </div>

        <div class="text-end">
          <strong>Total: $<span id="totalVentaDirecta">0.00</span></strong>
        </div>

        <div class="text-end mt-3">
          <button class="btn btn-success" id="btnGuardarVentaDirecta">Registrar venta</button>
        </div>
      </div>

    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/ventas.js"></script>

<script src="../js/autocompletar_clientes.js"></script>
<?php include("../plantillas/footer.php"); ?>
